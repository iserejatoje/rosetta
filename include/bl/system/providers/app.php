<?

class BL_system_provider_app extends BL_system_provider implements IBL_system_provider_data
{
	public function GetValue($name)
	{
		list($name,$key) = explode(':', $name, 2);
		$name = strtolower($name);
		
		switch ( $name )
		{
			case 'global':
				return self::_get_array_value(App::$Global, explode('/',$key));
			case 'env':
				return self::_get_array_value(App::$Env, explode('/',$key));
			case 'currentenv':
				return self::_get_array_value(App::$CurrentEnv, explode('/',$key));
			case 'moduleconfig':
				return self::_get_array_value(App::$ModuleConfig, explode('/',$key));
			case 'request':
				$key = explode('/', $key);
				$prop_name = ucfirst(strtolower(array_shift($key)));
				return self::_get_array_value(App::$Request->{$prop_name}, $key);
			case 'title':
				$key = explode('/', $key);
				$prop_name = array_shift($key);
				return self::_get_array_value(App::$Title->{$prop_name}, $key);
			case 'uerror':
				$key = explode('/', $key);
				$prop_name = array_shift($key);
				return self::_get_array_value(App::$UError->{$prop_name}, $key);
			case 'user':
				$key = explode('/', $key);
				$prop_name = array_shift($key);
				return self::_get_array_value(App::$User->{$prop_name}, $key);
			default:
				return null;
		}
	}
	
	private static function _get_array_value(&$arr, $key)
	{
		if ( is_array($key) && count($key) > 1)
		{
			$k = array_shift($key);
			return self::_get_array_value($arr[$k], $key);
		}
		else
		{
			return $arr[ $key[0] ];
		}
	}
}

?>
