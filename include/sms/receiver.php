<?

global $CONFIG;
require_once ($CONFIG['engine_path'].'configure/lib/sms/error.php');

/**
* SMS-приемник
*/

class SMSReceiver
{
	protected static $SMS_CONTENT_LOG = 'sms_content_%04u%02u';
		
	private $_log_db = null;
	
	public function __construct() {}
		
	static function &getInstance()
	{
        static $instance;
		
        if ( !isset($instance) )
		{
            $cl = __CLASS__;
            $instance = new $cl();
        }
		
        return $instance;
    }
	/**
	* Получение объекта провайдера
	*/
	public static function GetProvider($name)
	{
		global $CONFIG;
		
		$file = dirname(__FILE__).'/receiver/providers/'.$name.'.php';
		
		if ( is_file($file) )
		{
			// создаем объект провайдера
			include_once $file;
			$cname = 'SMS_Receiver_Provider_'.$name;
			if ( class_exists($cname) === true )
				return new $cname($name,$this);
			else
				return null;
		}
		//throw new EngineException( array(ERR_L_SMS_CANT_LOAD_PROVIDER, 'SMSProvider_'.$name) );
		throw new RuntimeBTException('ERR_L_SMS_CANT_LOAD_PROVIDER SMS_Receiver_Provider_'.$name, ERR_L_SMS_CANT_LOAD_PROVIDER, array($name));
	}
		
	/**
	* Запись в лог входящего запроса
	*/
	public static function Log($name,$params)
	{
		self::getInstance()->_log($name,$params);
	}
	
	private function _log($name,$params)
	{
		$sql = "INSERT INTO ". $this->log_table ." SET ";
		$sql.= " `Date` = NOW(), ";
		$sql.= " `ProviderName` = '". addslashes($name) ."', ";
		$sql.= " `Params` = '". addslashes($params) ."', ";
		$sql.= " `GET` = '". addslashes( serialize(App::$Request->Get->AsArray()) ) ."', ";
		$sql.= " `POST` = '". addslashes( serialize(App::$Request->Post->AsArray()) ) ."'";
		
		$this->log_db->query($sql);		
	}
	
	/**
	* Инициализация лога
	*/
	private function _log_init()
	{
		$this->_log_db = DBFactory::GetInstance('log');
		
		$sql = "CREATE TABLE IF NOT EXISTS `". $this->log_table ."`(";
		$sql.= " `Date` datetime, ";
		$sql.= " `ProviderName` varchar(100) not null, ";
		$sql.= " `Params` varchar(255) not null, ";
		$sql.= " `GET` varchar(255) not null, ";
		$sql.= " `POST` varchar(255) not null, ";
		$sql.= " KEY (`Date`),";
		$sql.= " KEY (`ProviderName`)";
		$sql.= ")";
		
		$this->_log_db->query($sql);
	}
	
	/**
	* Получение списка провайдеров
	*/
	public static function GetProviderList()
	{
		global $CONFIG;
		
		$list = array();
		$path = dirname(__FILE__).'/receiver/providers/';
		$dIterator = new DirectoryIterator($path);
		foreach ( $dIterator as $dir )
			if ( $dIterator->isFile() === true )
				$list[] = str_replace('.php','', $dIterator->getFileName() );
		
		return $list;
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
				return sprintf( self::$SMS_CONTENT_LOG, date('Y'), date('m') );
			default:
				return null;
		}
	}
	
}
