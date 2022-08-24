<?php

/**
 * @author danilin
 * @version 1.0
 * @created 24-дек-2007 14:30:04
 */
class ActionsLog
{

	/**
	 * линк на БД
	 */
	private $db = null;
	private $db_info = null;
	/**
	 * array - (ip, forwardedip, cookie, agent, date, serverip)
	 */
	private $cache = null;
	private $sectionID = 0;
	private $userID = 0;
	private $_actions = array();
	private $tables = array(
		'log' => 'el_log',
	);

	function __construct()
	{
	}

	/**
	 * Логирование событий
	 *
	 * @param action
	 * @param objectid    объект действия
	 * @param params
	 * @param userid
	 */
	function Log($action, $objectid = 0, $params = array(), $userid = null)
	{
		return false;
		if(is_string($action))
			$action = intval($action); // возможно сделать иначе
		
		if(!is_int($action))
			return false;
		
		if($userid === null)
			$userid = $this->userID;
			
		if($userid === null)
			return false;
			
		if($this->cache === null)
			$this->GetInfo();
		
		if($this->db === null)
			$this->InitDB();
			
		$additional = '';
		if(is_array($params) && count($params) > 0)
		{
			foreach($params as $key => $value)
			{
				if(!empty($additional))
					$additional.="\n";
				$additional.= $key.':'.$value;
			}
		}
		
		$userid = intval($userid);
			
		if($this->IsActionExists($action))
		{
			$sql = "INSERT INTO ".$this->tables['log']." SET ";
			$sql.= " ActionID=".$action.',';
			$sql.= " SectionID=".$this->sectionID.',';
			$sql.= ' Date=NOW(),';
			$sql.= " UserID=".$userid.',';
			$sql.= " IP='".$this->cache['IP']."',";
			$sql.= " ForwardedIP='".$this->cache['ForwardedIP']."',";
			$sql.= " Cookie='".$this->cache['Cookie']."',";
			$sql.= " Agent='".$this->cache['Agent']."',";
			$sql.= " ObjectID=".intval($objectid).",";
			$sql.= " ServerIP='".$this->cache['ServerIP']."',";
			$sql.= " Description='".addslashes($additional)."'";
			$this->db->query($sql);
			return true;
		}
		else
		{
			$errinfo = debug_backtrace();
			error_log("Log Action: $action not exists in file: ".$errinfo[0]['file'].' on line: '.$errinfo[0]['line']);
		}
			
		return false;
	}
	
	protected function IsActionExists($action)
	{
		return false;
		if(isset($this->_actions[$action]))
			return $this->_actions[$action];
		$sql = "SELECT ActionID
				FROM el_actions
				WHERE ActionID=$action";
		$res = $this->db_info->query($sql);
		if($res->fetch_row())
			$this->_actions[$action] = true;
		else
			$this->_actions[$action] = false;
		return $this->_actions[$action];
	}
	
	// подключение к BD
	protected function InitDB()
	{
		return false;
		$this->db = DBFactory::GetInstance('log');
		$this->db_info = DBFactory::GetInstance('site');
		
		// проверяем есть ли табличка для следующего месяца и если нет - создаем.
		// проверку проводим в разгруженное время в конце месяца
		$day_of_month = date('j');
		$hour = date('G');
		if( $day_of_month > 20 && $day_of_month < 31 && $hour == 23 )
		{
			$this->_create_table('el_log_'.date('Ym', strtotime("+1 month")));
		}
		// формируем имя для текущей таблички
		$this->tables['log'] = 'el_log_'.date('Ym');
	}

	protected function _create_table($tbl_name = null)
	{
		return false;
		if($tbl_name === null)
			return false;

		$sql = "CREATE TABLE IF NOT EXISTS `".$tbl_name."` (
  `ActionID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `UserID` int(11) NOT NULL,
  `IP` varchar(20) NOT NULL,
  `ForwardedIP` varchar(50) NOT NULL,
  `Cookie` varchar(250) NOT NULL,
  `Agent` varchar(250) NOT NULL,
  `ObjectID` bigint(20) NOT NULL,
  `ServerIP` varchar(20) NOT NULL,
  `Description` text NOT NULL,
  KEY `section` (`SectionID`),
  KEY `date` (`Date`),
  KEY `userid` (`UserID`),
  KEY `ip` (`IP`,`ForwardedIP`),
  KEY `agent` (`Agent`),
  KEY `object` (`ObjectID`),
  KEY `server` (`ServerIP`),
  KEY `ActionID` (`ActionID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251";
		$this->db->query($sql);
	}

	// инициализация
	function Init()
	{
	}

	/**
	 * Установить раздел, используется в движке перед вызовом методов модуля 
	 *
	 * @param sectionID
	 */
	function SetSectionID($sectionID)
	{
		$old = $this->sectionID;
		$this->sectionID = intval($sectionID);
		return $old;
	}

	/**
	 * Установка пользователя для паспорта, пока заглушка
	 * 
	 * @param userID
	 */
	function SetUserID($userID)
	{
		$this->userID = intval($userID);
	}

	/**
	 * Получение информации о компьютере пользователя, один раз на все логи.
	 */
	function GetInfo()
	{
		return false;
		$this->cache = array();
		$this->cache['IP']			= getenv("REMOTE_ADDR");
		$this->cache['ForwardedIP'] = getenv("HTTP_X_FORWARDED_FOR");
		#$cookie = $_SERVER['HTTP_COOKIE']; // может и несколько на одном домене быть, для случаев, когда домен 3-го уровня
		#preg_match('@uid=([\w]+)@', $cookie, $match);
		#$this->cache['Cookie'] = $match[2];
		$this->cache['Cookie'] = $_COOKIE['uid'];
		$this->cache['Agent']		= addslashes($_SERVER['HTTP_USER_AGENT']);
		$this->cache['ServerIP']	= $_SERVER["SERVER_ADDR"];
	}

}
?>
