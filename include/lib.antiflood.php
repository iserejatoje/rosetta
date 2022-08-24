<?
// при добавлении нового контентного хендлера, в котором возможен пользовательский ввод
// необходимо дополнить определение местоположение конфига и его загрузку
class AntiFlood
{
	// константы для генерации ключа, этим занимается сама библиотека
	// нум нужен унифицированный механизм, т.к. хранится все в одной бд
	const K_IP		= 0x0001;		// ip адрес компа и прокси
	const K_USER	= 0x0002;		// идентификатор пользователя
	const K_CUID	= 0x0004;		// uid из cookie пользователя от nginx, разные по сайтам

	const MAX_SCORE = 2000000;		// для защиты от переполнения, максимальный балл

	const ST_NORMAL	= 0x0001;
	const ST_CAPTCHA= 0x0002;
	const ST_WAIT	= 0x0003;
	const ST_BLOCK	= 0x0004;
	
	private $config = array();
	private $env = array();
	private $cache = null;
	private $db = null;
	private $ruleapplied = false;	// применялись ли правила
	private $statussent = false;	// отправлен ли статус ошибки
	private $globalhandle = true;	// глобальная обработка статуса, по умолчанию включена
	private $checkcaptcha = true;
	
	private $defaultstatuskey = 0x0002;
	
	private function __construct()
	{
		global $CONFIG;

		$this->db = DBFactory::GetInstance('passport');
		
		$this->cache = new Cache();
        $this->cache->Init('memcache', 'e_antiflood');
		
		// загрузка глобального конфига
        $this->LoadConfig($CONFIG['engine_path'].'/configure/lib/antiflood/default.php');

		$this->FillEnv();
		
		//error_log("antiflood loaded");
    }

	public function SetGlobalHandle($handle = true)
	{
		$this->globalhandle = $handle;
	}

	public function GetGlobalHandle()
	{
		return $this->globalhandle;
	}

	public function SetCaptchaCheck($check = true)
	{
		$this->checkcaptcha = $check;
	}

	public function GetCaptchaCheck()
	{
		return $this->checkcaptcha;
	}
	
	public function ApplyRules($rules = null, $data = null, $usevalidate = true)
	{
		if($rules === null)
			$rules = $this->config['rules'];
		if(is_array($rules) && count($rules) > 0)
			foreach($rules as $rule)
				$this->ApplyRule($rule, $usevalidate);
    }
	
	public function ApplyRule($rule, $data = null, $usevalidate = true)
	{
		if (is_string($rule))
			$rule = $this->config['rules'][$rule];

		if(!$usevalidate || $this->CheckRule($rule, $data))
		{
			$key = $rule['key'];
			$this->SetScore($this->ModifyScore($this->GetScore($key), $rule), $key);
			$this->ruleapplied = true;
		}
    }

	public function CheckRule($rule = null, $data = null)
	{
		if($data === null)
		{			
			return $this->_CheckRule($rule, $_GET) || $this->_CheckRule($rule, $_POST);
        }
		else
		{
			return $this->_CheckRule($rule, $data);
        }
    }

	public function LoadConfig($path, $index = null)
	{
		LibFactory::GetStatic('data');
		$cfg = null;
		if(is_file($path))
		{
			$cfg = include $path;
		}

		if($cfg !== null && is_array($cfg['antiflood']))
			$this->config = Data::array_merge_recursive_changed($this->config, $cfg['antiflood']);
    }

	public function SetStatusSent($status = true)
	{
		$this->statussent = $status;
	}

	public function IsStatusSent()
	{
		return $this->statussent;
	}
	
	protected function GetRuleProvider($name)
	{
		global $CONFIG;
		$path = $CONFIG['engine_path']."include/antiflood/".$name.".php";
		if(is_file($path))
		{
			include_once $path;
			$cln = 'AntiFloodProvider_'.$name;
			if(class_exists($cln))
				return new $cln;
        }
		return null;
    }

	protected function _CheckRule($rule, $data)
	{
		$p = $this->GetRuleProvider($rule['name']);
		
		if($p !== null)
		{			
			return $p->CheckRule($rule['condition'], $data);
		}
		else
			return false;
    }
	
	protected function ModifyScore($score, $rule)
	{
		if($this->ruleapplied === false)
		{
			if(!isset($this->config['timeout']['divide']))
				$this->config['timeout']['divide'] = 1;
			$tout = time() - $score['time'];
			if($tout > $this->config['timeout']['time'] && $score['score'])
			{
				$mod = $tout / $this->config['timeout']['time'];
				$score['score'] = intval($score['score'] / $this->config['timeout']['divide'] / $mod - $this->config['timeout']['sub'] * $mod);			
			}

			if($score['score'] < 0)
				$score['score'] = 0;
		}

		$p = $this->GetRuleProvider($rule['name']);
		if($p !== null)
			$score = $p->ModifyScore($score, $rule['score']);
				
		return $score;
    }
	
	private function FillEnv()
	{
		global $OBJECTS;
		$this->env[self::K_IP]			= $_SERVER["HTTP_REMOTE_ADDR"];
		$this->env[self::K_USER]		= $OBJECTS['user']->ID;
		$this->env[self::K_CUID]		= Request::GetUID();
    }

	public function GetScore($key) // получение балла для текущего пользователя по ключу
	{
		$kstr = $this->GetKey($key);
		$score = $this->cache->Get($kstr);
		if($score === false)
		{
			$sql = "SELECT * FROM af_scores";
			$sql.= " WHERE ID='".addslashes($kstr)."'";
			$res = $this->db->query($sql);
			if($row = $res->fetch_assoc())
			{
				$score = array(
					'score' => $row['Score'],
					'time' => strtotime($row['LastTime']));
            }
			else
				$score = array('score' => 0, 'time' => time()); // значение по умолчанию
			$this->cache->Set($kstr, $score, 10);
        }
		return $score;
    }
	
	public function GetStatus($statuskey = null)
	{
		global $OBJECTS;
		
		if($this->ruleapplied === true)
		{
			$score = $this->GetTotalScore($statuskey);

			if($this->config['max_scores']['block'] !== false && $score > $this->config['max_scores']['block'])
				return self::ST_BLOCK;
			elseif($this->config['max_scores']['wait'] !== false && $score > $this->config['max_scores']['wait'])
				return self::ST_WAIT;
			elseif($this->config['max_scores']['captcha'] !== false && $score > $this->config['max_scores']['captcha'])
			{
				if($this->checkcaptcha === true)
				{
					$cp = LibFactory::GetInstance('captcha');
					if($cp->is_valid())
						return self::ST_NORMAL;
				}
				return self::ST_CAPTCHA;
			}
		}
		return self::ST_NORMAL;
    }
	
	public function GetWaitTimeout()
	{
		$score = $this->GetTotalScore();
		
		$toscore = ($this->config['max_scores']['wait'] - $this->config['max_scores']['captcha']) / 3;

		$a = $this->config['timeout']['divide'] * $this->config['timeout']['sub'];
		$b = $this->config['timeout']['divide'] * $toscore;
		$c = $score;

		$d = $b * $b + 4*$a*$c;
		$x = array();
		if($d == 0)
		{
			$x[] = -$b / 2 / $a;
        }
		elseif($d > 0)
		{
			$d = sqrt($d);
			$x[] = (-$b - $d) / 2 / $a;
			$x[] = (-$b + $d) / 2 / $a;
        }

		$res = 1; // некое дефолтное значение
		if(count($x) > 0)
		{
			$res = 1; // про запас)
			foreach($x as $_x)
			{
				if($_x > 1 && $_x < $res)
					$res = $_x;
            }
		}

		return ($res + 1) * $this->config['timeout']['time'];
    }
	
	public function SendStatus($exit = false, $statuskey = null)
	{
		global $OBJECTS, $CONFIG;
		$status = $this->GetStatus($statuskey);
		
		if($status == self::ST_CAPTCHA)
		{
			$sstr = 'captcha';
			$cp = LibFactory::GetInstance('captcha');
			$cpath = $cp->get_path();
		}
		if($status == self::ST_WAIT)
		{
			$sstr = 'wait';
			$twait = round($this->GetWaitTimeout());
			$cp = LibFactory::GetInstance('captcha');
			$cpath = $cp->get_path();
		}
		if($status == self::ST_BLOCK)
		{
			$sstr = 'block';			
		}
		
		Response::Status(403);			// доступ запрещен
		
		$stid = STreeMgr::GetSiteTitleIDByRegion($CONFIG['env']['regid']);
		$sn = STreeMgr::GetNodeByID($stid);
		
		$OBJECTS['smarty']->assign('res', array(
				'status' => $sstr,
				'captcha' => $cpath,
				'wait' => $twait,
				'action' => $_SERVER['REQUEST_URI'],
				'logo' => '/_img/design/200608_title/logo/logo.'.$sn->Name.'.gif',
			));
		
		$oldcaching = $OBJECTS['smarty']->caching;
		$OBJECTS['smarty']->caching = 0;
		$OBJECTS['smarty']->display('modules/antiflood/default.tpl');
		$OBJECTS['smarty']->caching = $oldcaching;

		if($exit)
			exit();
    }
	
	// тут вытаскиваем все варианты и сумируем, используется для определения статуса
	public function GetTotalScore($statuskey = null)
	{
		if($statuskey === null)
			$statuskey = $this->defaultstatuskey;
	
		$score = 0;
		if($statuskey & self::K_IP)
		{
			$s = $this->GetScore(self::K_IP);
			$score+= $s['score'];
		}
		if($statuskey & self::K_CUID)
		{
			$s = $this->GetScore(self::K_IP | self::K_CUID);
			$score+= $s['score'];
		}
		if($statuskey & self::K_USER)
		{
			$s = $this->GetScore(self::K_USER);
			$score+= $s['score'];
		}

		return $score;
    }
	
	protected function SetScore($score, $key)
	{
		$kstr = $this->GetKey($key);
		$score['time'] = time();		// текущее время
		if($score['score'] > self::MAX_SCORE)	// защита от переполнения
			$score['score'] = self::MAX_SCORE;
		if($score['score'] < 0)					// не может быть меньше 0
			$score['score'] = 0;
		$sql = "REPLACE af_scores";
		$sql.= " SET ID='".addslashes($kstr)."',";
		$sql.= " Score=".intval($score['score']).",";
		$sql.= " LastTime=FROM_UNIXTIME(".$score['time'].")"; // чтобы время одно было в бд и мемкэше и не зависило от времени сервера
		$res = $this->db->query($sql);
		$this->cache->Set($kstr, $score);
    }

	public function GetKey($key) // строковое представление ключа
	{
		if($key & self::K_IP)
			$k[] = 'ip='.$this->env[$key & self::K_IP];
		if($key & self::K_USER)
			$k[] = 'user='.$this->env[$key & self::K_USER];
		if($key & self::K_CUID)
			$k[] = 'cuid='.$this->env[$key & self::K_CUID];
		return implode($k, '|');
    }

	private function __clone()
	{

    }
	
	public function &getInstance()
	{
		static $instance = null;
		if($instance === null)
		{
			$cl = __CLASS__;
            $instance = new $cl();
		}
		return $instance;
    }
}

abstract class AAntiFloodProvider
{
	abstract public function CheckRule($rule, $data = null);
	abstract public function ModifyScore($score, $rule);
}
?>