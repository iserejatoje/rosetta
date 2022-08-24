<?

class ControlFactory
{
	static public function GetInstance($name, $parent = null, $params = array())
	{
		global $CONFIG;

		$name = strtolower($name);

		$class_name = 'Control_'.str_replace('/', '_', $name);

		if(!class_exists($class_name))
		{
			self::Load($name);
		}
		if(class_exists($class_name))
		{
			$obj = new $class_name($parent);
			$obj->Init($params);
			return $obj;
		}
		else
		{
			error_log('class: '.$name.' not found');
			return null;
		}
	}

	static public function Load($name)
	{
		global $CONFIG;
		$path = $CONFIG['engine_path'].'include/control/'.$name.'.php';
		if(is_file($path))
			include $path;
		else
			error_log('control file: '.$path.' not found');
	}
}

// предзагрузка классов базовых контролов
ControlFactory::Load('icontrol');
ControlFactory::Load('ipager');
ControlFactory::Load('iheader');
ControlFactory::Load('itemplatecontrol');
ControlFactory::Load('ivirtualcontrol');
ControlFactory::Load('control');
ControlFactory::Load('templatecontrol');
ControlFactory::Load('virtualcontrol');
ControlFactory::Load('templatevirtualcontrol');

?>