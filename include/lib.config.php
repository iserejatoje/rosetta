<?

// только для второй версии движка
// загрузчик конфигов с кэшированием по пути файла
class ConfigFactory
{
	private static $configs = array();
	
	public static function GetConfig($path)
	{
		global $CONFIG, $ERROR;
		if(!isset(self::$configs[$path]))
		{
			self::$configs[$path] = include($path);
		}
		
		return self::$configs[$path];
	}
}

?>