<?

class BLFactory
{
	static $_cache = array();
	
	static public function GetInstance($name, $parent = null, $params = array(), $cacheid = null)
	{
		global $CONFIG;
		
		$name = strtolower($name);
		
		if($cacheid !== null)
			$cid = $name.'_'.$cacheid;
		else
			$cid = $name;
		
		if(!isset(self::$_cache[$cid]))
		{		
			$class_name = 'BL_'.str_replace('/', '_', $name);
			
			if(!class_exists($class_name))
			{
				self::Load($name);
			}
			if(class_exists($class_name))
			{
				self::$_cache[$cid] = new $class_name($parent);
				self::$_cache[$cid]->Init($params);
			}
			else
			{
				error_log('class: '.$name.' not found');
				return null;
			}
		}
		
		return self::$_cache[$cid];
	}
	
	static public function Load($name)
	{
		global $CONFIG;
		$path = $CONFIG['engine_path'].'include/bl/'.$name.'.php';
		if(is_file($path))
			include $path;
		else
			error_log('business logic file: '.$path.' not found');
	}
}

// предзагрузка классов базовых источников данных
include $CONFIG['engine_path'].'include/bl/isource.php';

?>