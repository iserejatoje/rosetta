<?

class BL_system_ProviderFactory
{
	static private $cache = array();
	static public function GetProvider($name)
	{
		global $CONFIG;
		
		if ( strlen($name) == 0 )
			return null;
			
		$class_name = 'BL_system_provider_'. str_replace('/', '_', $name);
		if(!class_exists($class_name))
		{		
			$path = $CONFIG['engine_path'] .'include/bl/system/providers/'. strtolower($name) .'.php';
			if ( is_file($path) )
			{
				include $path;
				if(!class_exists($class_name))
				{
					error_log('provider class: '.$class_name.' in file: '.$path.' not found');
					return null;
				}
			}
			else
			{
				error_log('provider file: '. $path .' not found');
				return null;
			}
		}

		return new $class_name;
	}
	
	static public function GetCompareProvider($name)
	{
		if(!isset(self::$cache[$name]))
			self::$cache[$name] = self::GetProvider('compare/'. $name);
		return self::$cache[$name];
	}
}

abstract class BL_system_provider
{
	static function &getInstance()
	{
        static $instance;
		
        if ( !isset($instance) )
		{
            $class_name = __CLASS__;
            $instance = new $class_name();
        }
		
        return $instance;
    }
}

interface IBL_system_provider_data
{
	public function GetValue($name);
}

interface IComparer
{
	public function Compare($a, $b);
}

interface IComparerName
{
	public function GetComparerName();
}

class BL_system_provider_compare_empty implements IComparer, IComparerName
{
	public function Compare($value1, $value2)
	{
		return false;
    }
	
	public function GetComparerName()
	{
		return '';
	}
}

?>
