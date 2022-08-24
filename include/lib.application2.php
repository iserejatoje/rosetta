<?
class Application2Mgr
{
	private $tree = null;
	private $expr_error = false;
	public function __construct()
	{
		//2do: кэширование
		$sql = "SELECT * FROM application";
		$res = DBFactory::GetInstance('site')->query($sql);
		$d = array();
		while($row = $res->fetch_assoc())
		{
			$d[$row['id']] = array('parent' => $row['parent'], 'data' => array(
				'domain'		=> $row['domain'],
				'server' 		=> $row['server'],
				'client' 		=> $row['client'],
				'method' 		=> $row['method'],
				'user' 			=> $row['user'],
				'devel' 		=> $row['devel'],
				'application'	=> $row['application'],
				'link'			=> $row['link'],
			), 'name' => $row['path']);
		}
		
		LibFactory::GetStatic('tree');
		$this->tree = new Tree();
		$this->tree->BuildTree($d);
	}
	
	public function ParseUrl($url)
	{
		$stack = array();
		$node = $this->tree;
		$data = array('from' => null, 'to' => array());
		while(!empty($url) && $node !== null)
		{
			list($token, $url) = $this->Token($url);
			$n = $node->GetByName($token);
			if($n === false)
				return null;
			if(!empty($n->Data['application']))
			{
				$p = $this->GetPathProvider($n->Data['application']);
				if($p !== null)
				{
					if($data['from'] !== null)
					{
						$data['to'] = array();
						if(!empty($n->Data['link']))
						{
							$this->expr_error = false;
							$expr = $n->Data['link'];
							$expr = preg_replace_callback('@\$(\w+)\b@', array($this, 'VarsReplace'), $expr);
							if($this->expr_error === true)
								error_log('Application: Error in link expression: '.$n->Data['link']);
							if(eval($expr) === false)
								return $stack;
						}
					}
					else
						$data['to'] = null;
					$d = $p->ParseUrl($url, $data['to']);
					if($d === null)
						return false;	// не распарсили урл, по сути нотфаунд
						
					$url = $d['url'];
					$canapp = $d['canapp'];
					unset($d['url'], $d['canapp']);
					
					$data['from'] = $d;
					$stack[] = $d;
					
					if($canapp !== true)
						return $stack;
				}
				else
					return false;		// что-то не то, для приложения должен быть провайдер
			}
			$node = $n;
		}
		return $stack;
	}
	
	public function VarsReplace($matches)
	{
		if($matches[1] == 'from' || $matches[1] == 'to')
		{
			return '$data[\''.$matches[1].'\']';
		}
		$this->expr_error = true;
		return '';
	}
	
	public function Token($url, $delimiter = '/')
	{
		$pos = strpos($url, $delimiter);
		if($pos === false)
			return array($url, '');
		
		return array(substr($url, 0, $pos), substr($url, $pos + 1));
	}

	private function GetPathProvider($name)
	{
		global $CONFIG;
		$cname = 'ApplicationPathProvider_'.$name;
		if(!class_exists($cname))
		{
			$fname = $CONFIG['engine_path'].'include/application2/path/'.$name.".php";
			if(is_file($fname))
				include_once $fname;
			else
				return null;
		}
		
		if(class_exists($cname))
			return new $cname($this);
		return null;
	}
	
	private $configs = array();
	public function GetConfig($path)
	{
		if(empty($path))
			return array();

		if(!isset($this->$configs['app'][$path]))
			$this->$configs['app'][$path] = $this->LoadConfig('app', $name, $folder);

		return $this->$configs['app'][$path];
    }

	private function LoadConfig($type, $path)
	{
		global $CONFIG, $ERROR;
		$config = array();

		if($type == 'app')
		{
			$config = $this->LoadConfigFile($CONFIG['engine_path'].'configure/applications/instance/'.$folder.'/'.$name.'.php');
			if(isset($config['module']))
				$path = $config['module'];
			else
				$path = '';
		}

		if(($type == 'base' || $type == 'app') && !empty($path))
		{
			$config_base = $this->LoadConfigFile($CONFIG['engine_path'].'configure/applications2/base/'.$path.'.php');

			$config = Data::array_merge_recursive_changed($config_base, $config);
        }

		return $config;
    }
	
	private function LoadConfigFile($path)
	{
		if(is_file($path))
			return include $path;
		else
			return array();
	}
}

abstract class IApplicationPathProvider
{
	protected $mgr = null;
	public function __construct($mgr)
	{
		$this->mgr = $mgr;
	}
	abstract public function ParseUrl($url, $data = null);
}

?>