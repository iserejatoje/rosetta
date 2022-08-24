<?

class SubsectionProviderFactory
{
	static private $providers = array();
	static function GetInstance($SectionID, $provider_name = null)
	{
		global $CONFIG;
		if(!isset(self::$providers[$SectionID]))
		{		
			LibFactory::GetStatic('tree');
			self::$providers[$SectionID] = null;
			// грузим конфиг раздела, если нет - null
			$config = ModuleFactory::GetConfigById('section', $SectionID);
			if($config === null)
				$config = ModuleFactory::GetConfigById('section', $SectionID, true);
			//if($SectionID == 4572) error_log('ssd create 1');
			if($config === null)
			{
				self::$providers[$SectionID] = null;
				return null;
			}
			//if($SectionID == 4572) error_log('ssd create 2');
			// если есть запись о провайдере - берем ее, иначе по имени модуля
			if($provider_name === null || !is_string($provider_name))
			{
				if(isset($config['subsection']['provider']))
					$provider_name = $config['subsection']['provider'];
				else
					$provider_name = $config['module'];
			}
							
			// проверяем наличие файла провайдера, если нет - null
			if(!is_file($CONFIG['engine_path'].'include/subsection/'.$provider_name.'_provider.php'))
			{
				self::$providers[$SectionID] = null;
				return null;
			}
			//if($SectionID == 4572) error_log('ssd create 3');
			// грузим файл провайдера
			include_once $CONFIG['engine_path'].'include/subsection/'.$provider_name.'_provider.php';
			// создаем объект
			$classname = 'Subsection_'.$provider_name.'_provider';
			self::$providers[$SectionID] = new $classname;
			// задаем раздел
			self::$providers[$SectionID]->SetSection($SectionID);
		}
		// возвращаем объект
		return self::$providers[$SectionID];
	}
	
	static function GetInstanceApp($name, $folder, $provider_name = null)
	{
		global $CONFIG;
		if(!isset(self::$providers[$folder.'/'.$name]))
		{		
			LibFactory::GetStatic('tree');
			self::$providers[$folder.'/'.$name] = null;
			// грузим конфиг раздела, если нет - null
			LibFactory::GetStatic('application');
			$config = ApplicationMgr::GetConfig($name, $folder);
			if($config === null)
			{
				self::$providers[$folder.'/'.$name] = null;
				return null;
			}

			// если есть запись о провайдере - берем ее, иначе по имени модуля
			if($provider_name === null || !is_string($provider_name))
			{
				if(isset($config['subsection']['provider']))
					$provider_name = $config['subsection']['provider'];
				else
					$provider_name = $config['module'];
			}
				
			// проверяем наличие файла провайдера, если нет - null
			if(!is_file($CONFIG['engine_path'].'include/subsection/'.$provider_name.'_provider.php'))
			{
				self::$providers[$folder.'/'.$name] = null;
				return null;
			}
			// грузим файл провайдера
			include_once $CONFIG['engine_path'].'include/subsection/'.$provider_name.'_provider.php';
			// создаем объект
			$classname = 'Subsection_'.$provider_name.'_provider';
			self::$providers[$folder.'/'.$name] = new $classname;
			// задаем раздел
			self::$providers[$folder.'/'.$name]->SetSection($folder.'/'.$name);
		}
		// возвращаем объект
		return self::$providers[$folder.'/'.$name];
	}
}

/**
 * Интерфейс для провайдера подразделов
 * должен по возможности кэшировать данные, так как может быть много образений за пользовательский запрос
 * на каждый раздел создается собственный экземпляр объекта
 */
abstract class SubsectionProvider
{
	protected $SectionID = 0;
	public $KeyPrefix   = '';
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	abstract public function GetTree();
	
	/**
	 * Генерация ключа для элемента
	 * @param array параметры
	 * @return string ключ
	 */
	abstract public function CreateKey($params);
	
	/**
	 * Установить раздел
	 * @param int идентификатор раздела
	 */
	public function SetSection($SectionID)
	{
		$this->SectionID = $SectionID;
	}
	
	//2do: временно
	public function AddLocation($params){}
	public function GetLink($params){return '';}
}
	
?>