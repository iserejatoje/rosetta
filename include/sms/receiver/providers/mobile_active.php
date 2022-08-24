<?

require_once dirname(__FILE__).'/../base/default.php';

class SMS_Receiver_Provider_Mobile_Active extends SMS_Receiver_Base_Default
{
	protected static $SMS_PROVIDER_LOG = 'sms_mobile_active_%04u%02u';
	/*
		Ошибки провайдера:
		0 - нет ошибок
		1-99 - ошибки в провайдере
		100+ - ошибки обработки запроса
	*/
	protected static $Password = '2vj,fxrf3';
	
	protected static $ERR_WRONG_PARAMETERS 	= 1;
	protected static $ERR_HASH_ERROR 		= 2;
	protected static $ERR_ACCESS_DENIED 	= 3;
	
	protected static $ERR_WRONG_REGION 		= 100;
	protected static $ERR_NO_RESUME 		= 101;
	protected static $ERR_INTERNAL_ERROR 	= 102;
	protected static $ERR_NO_ADV		 	= 103;
	
	protected $error_messages = array(
		0 => 'Ваше сообщение получено, функция будет активирована в течение 30 минут.',
		1 => 'Неверные параметры запроса.',
		2 => 'Ошибка в контрольной сумме запроса.',
		3 => 'Доступ запрещен.',
	);
	
	// ошибки действий
	// 2do: должны уехать в отдельный класс
	protected $action_errors = array(
		100 => 'Ошибка в задании региона.',
		101 => 'Нет такого резюме.',
		102 => 'Внутренняя ошибка.',
		103 => 'Нет такого объявления.',
	);
	
	// разрешенные IP-шники
	protected static $allowedIPs = array(
		'212.220.123.8',
		'10.80.12.33',
		//'195.95.253.26',
	);
	
	private $_log_db = null;
	
	// 2do: Это должно уйти в класс экшена
	private $job_sections = array (
		14 => 661,
		74 => 744,
		174 => 4269,
		26 => 794,
		93 => 802,
		34 => 866,
		63 => 1006,
		193 => 1011,
		2 => 1016,
		59 => 1018,
		16 => 1019,
		72 => 1022,
		61 => 1023,
		29 => 1025,
		35 => 1035,
		38 => 1036,
		42 => 1038,
		43 => 1041,
		45 => 1042,
		48 => 1043,
		51 => 1044,
		53 => 1045,
		55 => 1046,
		56 => 1047,
		60 => 1056,
		68 => 1058,
		62 => 1059,
		86 => 1062,
		89 => 1063,
		70 => 1066,
		71 => 1067,
		75 => 1068,
		76 => 1069,
		54 => 3904,
		78 => 3257,
		24 => 3182,
		66 => 1057,
	);	
	
	private $board_sections = array(
		68  => 10374,
		76  => 10364,
		102 => 10428,
		36  => 10426,
		163 => 10424,
		64  => 10452,
		66  => 10358,
		89  => 10360,
		72  => 10368,
		71  => 10370,
		70  => 10372,
		60  => 10378,
		56  => 10380,
		53  => 10382,
		51  => 10384,
		48  => 10386,
		43  => 10390,
		86  => 10362,
		74  => 10266,
		45  => 10388,
		42  => 10392,
		24  => 10422,
		78  => 10420,
		54  => 10418,
		174 => 10416,
		93  => 10414,
		193 => 10412,
		34  => 10410,
		2   => 10408,
		61  => 10406,
		55  => 10404,
		16  => 10402,
		26  => 10400,
		29  => 10398,
		35  => 10396,
		38  => 10394,
		63  => 10435,
		14  => 10356,
		75  => 10366,
		62  => 10376,
		59  => 10433,
	);
	private $hitech_sections = array(
		86 => 10363,
		45 => 10389,
		74 =>  1131,
		24 => 10423,
		66 => 10359,
		75 => 10367,
		72 => 10369,
		71 => 10371,
		70 => 10373,
		60 => 10379,
		56 => 10381,
		53 => 10383,
		51 => 10385,
		48 => 10387,
		89 => 10361,
		43 => 10391,
		102 => 10429,
		36 => 10427,
		163 => 10425,
		78 => 10421,
		54 => 10419,
		174 => 10417,
		93 => 10415,
		193 => 10413,
		34 => 10411,
		2  => 10409,
		61 => 10407,
		55 => 10405,
		16 => 10403,
		26 => 10401,
		29 => 10399,
		35 => 10397,
		38 => 10395,
		42 => 10393,
		63 => 10436,
		59 => 10434,
		68 => 10375,
		14 => 10357,
		76 => 10365,
		62 => 10377,
		64 => 10453,
	);
	
	/**
	* Проверка доступа к провайдеру
	*/
	public function CheckAccess($params)
	{
		$this->params = $params;
		
		// проверяем ip-шник
		if ( !in_array( $_SERVER['REMOTE_ADDR'], self::$allowedIPs ) && $params['pass'] != self::$Password )
		{
			$this->status = self::$ERR_ACCESS_DENIED;
			$this->Log();
			return false;
		}
		
		return true;
	}
	
	/**
	* Обработка полученной смс-ки
	*/
	public function Receive($params)
	{
		$this->params = $params;
		
		// проверяем параметры
		if ( empty($this->params['request']) || empty($this->params['userNumber']) ||
			empty($this->params['operatorNumber']) || empty($this->params['hash']) )
		{
			$this->status = self::$ERR_WRONG_PARAMETERS;
			return;
		}
		
		// проверка хэша запроса
		//error_log(md5(self::$Password.$this->params['request'].$this->params['userNumber'].$this->params['operatorNumber']));
		if ( md5(self::$Password.$this->params['request'].$this->params['userNumber'].$this->params['operatorNumber']) != $this->params['hash'] )
		{
			$this->status = self::$ERR_HASH_ERROR;
			return;
		}
		
		// разбираем текст смс-ки и запускаем экшен
		//if ( preg_match('@(resume|резюме)\s+(\d+)\s+(\d+)@i',$this->params['request'],$_) )
		if ( preg_match('@^((?:R|P|Р)(?:E|Е)(?:Z|З|3|S)(?:U|У|Ю)(?:M|М)(?:E|Е))\s+(\d+)\s+(\d+)$@i',$this->params['request'],$_) )
		{
			$this->Action_JobResume($_[2],$_[3]);
		}
		else if ( preg_match('@^((?:B|Б|В)(?:A|А)(?:R|Р|P)(?:A|U|А|У)(?:H|Х)(?:O|О|0)(?:L|Л)(?:K|К)(?:A|А))\s+(\d+)\s+(\d+)$@i',$this->params['request'],$_) )
		{
			$this->Action_Board($_[2],$_[3]);
		}
		else if ( preg_match('@^((?:H|Н)I(?:T|Т)(?:E|Е)(?:C|С|K|К)(?:H|Н)?)\s+(\d+)\s+(\d+)$@i',$this->params['request'],$_) || preg_match('@^((?:X|Х)(?:A|А)(?:И|Й)(?:T|Т)(?:E|Е|Э)(?:K|К))\s+(\d+)\s+(\d+)$@i',$this->params['request'],$_) )
		{
			$this->Action_Board($_[2],$_[3],true);
		}
		else
		{
			$this->status = self::$ERR_WRONG_PARAMETERS;
			return;
		}
	}
	
	/**
	* Получение результата обработки смс-ки
	*/
	public function PrintResult()
	{
		// логируем
		$this->Log();
		
		// тута пишем вывод ответа в зависимости от статуса
		// для вывода сообщения об ошибке
		return parent::PrintResult();		
	}
	
	/**
	* Инициализация лога
	*/
	protected function _log_init()
	{
		$this->_log_db = DBFactory::GetInstance('log');
		
		$sql = "CREATE TABLE IF NOT EXISTS `". $this->log_table ."`(";
		$sql.= " `Date` datetime, ";
		$sql.= " `request` varchar(100) not null, ";
		$sql.= " `userNumber` varchar(255) not null, ";
		$sql.= " `operatorNumber` varchar(255) not null, ";
		$sql.= " `hash` varchar(255) not null, ";
		$sql.= " `status` int(4) not null, ";
		$sql.= " KEY (`Date`),";
		$sql.= " KEY (`userNumber`)";
		$sql.= ")";
		
		$this->_log_db->query($sql);
	}
	
	/**
	* Запись в лог входящего запроса
	*/
	public function Log()
	{
		$sql = "INSERT INTO ". $this->log_table ." SET ";
		$sql.= " `Date` = NOW(), ";
		$sql.= " `request` = '". addslashes($this->params['request']) ."', ";
		$sql.= " `userNumber` = '". addslashes($this->params['userNumber']) ."', ";
		$sql.= " `operatorNumber` = '". addslashes($this->params['operatorNumber']) ."', ";
		$sql.= " `hash` = '". addslashes($this->params['hash']) ."', ";
		$sql.= " `status` = ". $this->status;
		
		$this->log_db->query($sql);
	}
	
	/**
	* Получение списка полей фильтра лога для админки или для эмулятора отправки
	*/
	public function GetLogFields()
	{		
		return array (
			'Date' 				=> array( 'title' => 'Дата', 'type' => 'date_range', 'field' => 'date', 'skip' => true ),
			'request' 			=> array( 'title' => 'Текст SMS', 'type' => 'string', 'field' => 'request' ),
			'userNumber' 		=> array( 'title' => 'Номер телефона', 'type' => 'string', 'field' => 'userNumber' ),
			'operatorNumber' 	=> array( 'title' => 'Номер оператора', 'type' => 'string', 'field' => 'operatorNumber', 'default_value' => 'mts:5120' ),
			'hash' 				=> array( 'title' => 'HASH', 'type' => 'string', 'field' => 'hash', 'skip' => true ),
			'status' 			=> array( 'title' => 'Статус', 'type' => 'number', 'field' => 'status', 'skip' => true ),
		);
	}
	
	/**
	* Получение URL-а для отправки SMS по заданному набору параметров
	*/
	public function GetUrl($params)
	{
		global $CONFIG;
		
		$url = ModuleFactory::GetLinkBySectionId(9353);
		
		$hash = md5(self::$Password.$params['request'].$params['userNumber'].$params['operatorNumber']);
		
		$url.= 'receive/mobile_active/?';
		$url.= 'request='. $params['request'] .'&';
		$url.= 'userNumber='. $params['userNumber'] .'&';
		$url.= 'operatorNumber='. $params['operatorNumber'] .'&';
		$url.= 'hash='. $hash .'&';
		$url.= 'pass='. self::$Password;
		
		return $url;
	}
	
	/**
	* Продление заданного резюме на заданном регионе
	*/
	private function Action_JobResume($Region,$ResumeID)
	{
		global $OBJECTS, $CONFIG;
		
		// тута пишем экшен и возвращаем статус
		if ( !isset($this->job_sections[$Region]) )
		{
			$this->status = self::$ERR_WRONG_REGION;
			return;
		}
		
		$sectionid = $this->job_sections[$Region];
		
		$config = ModuleFactory::GetConfigById('section', $sectionid);
		
		if ( !is_array($config) )
		{
			$this->status = self::$ERR_INTERNAL_ERROR;
			return;
		}
		
		$db = DBFactory::GetInstance($config['db']);
		// проверяем наличие резюме
		
		$nn = STreeMgr::GetNodeByID($sectionid);
		
		if ( $nn->Module == 'job' || $nn->Module == 'job_v2' )
			$sql = "SELECT `Important` FROM `". $config['tables']['j_resume'] ."` WHERE `ResumeID` = ". $ResumeID;
		else
			$sql = "SELECT `imp` FROM `". $config['tables']['j_resume'] ."` WHERE `resid` = ". $ResumeID;
		
		if ( ($res = $db->query($sql)) === false ) 
		{
			$this->status = self::$ERR_NO_RESUME;
			return;
		}			
		if ( ($row = $res->fetch_row()) !== null ) 
			$imp = $row[0];
		else
		{
			$this->status = self::$ERR_NO_RESUME;
			return;
		}
		
		// продляем резюме
		$sql = "UPDATE `". $config['tables']['j_resume'] ."` SET ";
		if ( $imp > 0 )
		{
			// уже красное - продляем на 3 дня от даты истечения
			if ( $nn->Module == 'job' || $nn->Module == 'job_v2' )
				$sql.= "`Important` = 1, `ImportantTill` = `ImportantTill` + INTERVAL 3 DAY ` WHERE `ResumeID` = ". $ResumeID;
			else
				$sql.= "`imp` = 1, `imp_till` = `imp_till` + INTERVAL 3 DAY WHERE `resid` = ". $ResumeID;
		}
		else
		{
			// не красное - продляем на 3 дня от текущего момента
			if ( $nn->Module == 'job' || $nn->Module == 'job_v2' )
				$sql.= "`Important` = 1, `ImportantTill` = NOW() + INTERVAL 3 DAY WHERE `ResumeID` = ". $ResumeID;
			else
				$sql.= "`imp` = 1, `imp_till` = NOW() + INTERVAL 3 DAY WHERE `resid` = ". $ResumeID;
		}
		//error_log($sql);
		
		if ( $db->query($sql) === false )
		{
			$this->status = self::$ERR_INTERNAL_ERROR;
			return;
		}
		
		// добавляем движковый лог
		$OBJECTS['log']->Log( 373, $ResumeID, array('regid' => $Region) );
	}
	

	/**
	* Продление заданного объявления на заданном регионе
	*/
	private function Action_Board($Region, $AdvID, $hi_tech = false)
	{
		global $OBJECTS, $CONFIG;
		
		// тута пишем экшен и возвращаем статус
		if ( $hi_tech === true )
		{
			if ( !isset($this->hitech_sections[$Region]) )
			{
				$this->status = self::$ERR_WRONG_REGION;
				return;
			}
			$sectionid = $this->hitech_sections[$Region];
		}
		else
		{
			if ( !isset($this->board_sections[$Region]) )
			{
				$this->status = self::$ERR_WRONG_REGION;
				return;
			}
			$sectionid = $this->board_sections[$Region];
		}
		
		$config = ModuleFactory::GetConfigById('section', $sectionid);
		
		if ( !is_array($config) )
		{
			$this->status = self::$ERR_INTERNAL_ERROR;
			return;
		}
		
		$db = DBFactory::GetInstance($config['db']);
		
		$sql = "SELECT COUNT(*) FROM `". $config['regid'] ."_advertise`";
		$sql.= " WHERE `AdvID` = ". intval($AdvID);
		list($cnt) = $db->query($sql)->fetch_row();
		if ( $cnt == 0 )
		{
			$this->status = self::$ERR_NO_ADV;
			return;
		}
		
		
		$sql = "UPDATE `". $config['regid'] ."_advertise` SET ";
		$sql.= " `DateUpdate` = NOW(), ";
		$sql.= " `DateValid` = IF(`DateValid` < NOW(), NOW() + INTERVAL 1 WEEK, `DateValid` + INTERVAL 1 WEEK), ";
		$sql.= " `opt_InState` = 0 ";
		$sql.= " WHERE `AdvID` = ". intval($AdvID);
		
		if ( $db->query($sql) === false )
		{
			$this->status = self::$ERR_INTERNAL_ERROR;
			return;
		}
		
		// добавляем движковый лог
		$OBJECTS['log']->Log( 498, $AdvID, array('regid' => $Region) );
	}
	
	
	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'log_db':
				if ( $this->_log_db === null )
					$this->_log_init();
				
				return $this->_log_db;
			case 'log_table':
				return sprintf( self::$SMS_PROVIDER_LOG, date('Y'), date('m') );
			default:
				return null;
		}
	}
	
}

?>
