<?php

interface IDisposable
{
	public function Dispose();
}

class LibFactory
{
	static function GetStatic()
	{
		global $CONFIG, $OBJECTS, $ERROR;
		if(!isset($CONFIG['engine_path'])) $CONFIG['engine_path'] = $GLOBALS['CONFIG']['engine_path'];
		$count = func_num_args();
		for($i = 0; $i < $count; $i++)
		{
			include_once $CONFIG['engine_path']."include/lib.".func_get_arg($i).".php";
		}
	}

	static function GetMStatic($name, $subname)
	{
		global $CONFIG, $OBJECTS, $ERROR;
		$bt = debug_backtrace();
		$fname = $CONFIG['engine_path']."include/".$name."/".$subname.".php";

		include_once $fname;
	}

	static function GetConfig($name, $region = null)
	{
		global $CONFIG, $LCONFIG;
		if(is_file($CONFIG['engine_path'].'configure/lib/'.$name.'/default.php'))
			include_once $CONFIG['engine_path'].'configure/lib/'.$name.'/default.php';
		if($region != null && is_file($CONFIG['engine_path'].'configure/lib/'.$name.'/'.$region.'.php'))
			include_once $CONFIG['engine_path'].'configure/lib/'.$name.'/'.$region.'.php';
	}

	static function GetInstance($name, $subname = null)
	{
		global $CONFIG, $OBJECTS, $ERROR;

		include_once $CONFIG['engine_path']."include/lib.{$name}.php";
		$name = "lib_".$name;
		return new $name();
	}
}

class App {

	static public $Request = null;
	static public $Global = array();

	// окружение и конфиг
	static public $Env = null;
	static public $CurrentEnv = null;
	static public $ModuleConfig = array();

	static private $EnvStack = array();
	static private $ModuleConfigStack = array();

	// глобальные объекты
	static public $Title = null;
	static public $UError = null;
	static public $User = null;
	static public $City = null;
	static public $Log = null;

	static private $internal_encoding = 'utf-8';
	static private $external_encoding = 'utf-8';
	static private $is_encode = false;

	static private $null = null;

	/**
	 * Окружение (текущее)
	 *
	 * @var array
	 *
	 */
	static public $Terminal			= 1;
	const TM_HTTP					= 1;
	const TM_CLI					= 2;

	static public $Protocol;

	static public function Init() {
		global $CONFIG, $OBJECTS;

		self::$Request = new Request();
		self::$CurrentEnv =& $CONFIG['env'];
	}

	static public function SetEnv(&$env)
	{
		self::$Env =& $env;
		self::$EnvStack[] =& $env;
	}

	static public function SetModuleConfig(&$config)
	{
		self::$ModuleConfig =& $config;
		self::$ModuleConfigStack[] =& $config;
	}

	static public function RemoveEnv()
	{
		self::$Env =& self::$null;
		if (sizeof(self::$EnvStack))
			unset(self::$EnvStack[sizeof(self::$EnvStack)-1]);

		if (sizeof(self::$EnvStack))
			self::$Env =& self::$EnvStack[sizeof(self::$EnvStack)-1];
	}

	static public function RemoveModuleConfig()
	{
		self::$ModuleConfig =& self::$null;
		if (sizeof(self::$ModuleConfigStack))
			unset(self::$ModuleConfigStack[sizeof(self::$ModuleConfigStack)-1]);

		if (sizeof(self::$ModuleConfigStack))
			self::$ModuleConfig =& self::$ModuleConfigStack[sizeof(self::$ModuleConfigStack)-1];
	}

	static public function SetTitleObject(&$title)
	{
		self::$Title =& $title;
	}

	static public function SetUserErrorObject(&$uerror)
	{
		self::$UError =& $uerror;
	}

	static public function SetUserObject(&$user)
	{
		self::$User =& $user;
	}

	static public function SetCityObject(&$city)
	{
		self::$City =& $city;
	}

	static public function SetLogObject(&$log)
	{
		self::$Log =& $log;
	}

	static public function SetInternalEncoding($encoding)
	{
		self::$internal_encoding = $encoding;
		if( strcasecmp(self::$internal_encoding, self::$external_encoding) == 0 )
			self::$is_encode = false;
		else
			self::$is_encode = true;
	}
	static public function SetExternalEncoding($encoding)
	{
		self::$external_encoding = $encoding;
		if( strcasecmp(self::$internal_encoding, self::$external_encoding) == 0 )
			self::$is_encode = false;
		else
			self::$is_encode = true;
	}
	static public function GetInternalEncoding()
	{
		return self::$internal_encoding;
	}
	static public function GetExternalEncoding()
	{
		return self::$external_encoding;
	}
	static public function IsEncode()
	{
		return self::$is_encode;
	}

	/**
	 * Остнавливает выполнение приложения
	 */
	static public function Stop()
	{
		if( self::$Terminal == self::TM_HTTP && class_exists('response') )
			Response::Status(500, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);
		else
			exit("Application stop emergency by Exception!\n");
	}

}

LibFactory::GetStatic('widget');
LibFactory::GetStatic('handler');

LibFactory::GetStatic('modulefactory');

LibFactory::GetStatic('http');

LibFactory::GetStatic('db');
App::Init();
LibFactory::GetStatic('namespace');
LibFactory::GetMStatic('events','eventmgr');

