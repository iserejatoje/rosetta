<?
class NamespaceMgr
{
	private function __construct() {}

	/**
	 * Создать объект пространства
	 * @param string $name имя пространства
	 * @param array $params параметры
	 * @return NamespaceBase обьект пространства
	 */
	public function GetNamespace($name, $params = array())
	{
		global $CONFIG;
		//////////////////////////////////////////////////////////////////////////////
		// для отладки, пространства v2	подменяют разделы
		//if($_SERVER['HTTP_HOST'] == 'test.ufa1.ru')
		//	$path = $CONFIG['engine_path']."include/namespace/v2/".$name.".php";
		//else
			$path = $CONFIG['engine_path']."include/namespace/".$name.".php";
		//////////////////////////////////////////////////////////////////////////////
		
		if(is_file($path))
		{			
			include_once $path;
			$cln = 'Namespace_'.$name;
			if(class_exists($cln))
				return new $cln($params);
			else
				return null;
		}
		return null;
	}

	static public function GetInstance()
	{
		static $instance = null;
		if($instance === null)
		{
			$cl = __CLASS__;
            $instance = new $cl();
		}
		return $instance;
	}
}

abstract class NamespaceBase
{
	protected $params = null;
	public function __construct($params)
	{
		$this->params = $params;
	}
	
	public function GetEnv($siteid, $sectionid)
	{
		// берем по разделу
		LibFactory::GetStatic('bl');
		
		$env_bl = BLFactory::GetInstance('system/env');
		$env = $env_bl->GetEnvForSection($sectionid);
		
		return $env;
	}
	
	// получение пути к файлу конфига
	public function GetConfigFilePath($type, $sectionid)
	{
		global $CONFIG;
		
		$namespaceid = ModuleFactory::GetNamespaceIDBySectionID($sectionid);
		if ( $namespaceid === null)
			return null;
			
		$sn = STreeMgr::GetNodeByID($sectionid);
		$nn = STreeMgr::GetNodeByID($namespaceid);
			
		if( strlen($nn->Module) == 0 )
			return null;
		
		$name = urlencode($sn->Path);
		
		$list = array();
		
		/* if ( $type == 'module_engine' )
		{
			return $CONFIG['engine_path'].'configure/modules/'. $sn->Module .".php";
		}
		if ( $type == 'module_site' )
			return $file = $sn->Parent->OldSitePath.'/configure/modules/'. $sn->Module .".php";
		
		if ( $type == 'section' )
			return $sn->Parent->OldSitePath .'/configure/sections/'. $name .".php"; */
		return null;
	}
	
	// получение идентификатора конфига для раздела
	public function GetConfigPath($type, $sectionid)
	{
		global $CONFIG;
		
		$sn = STreeMgr::GetNodeByID($sectionid);
		
		if ( $type == 'section' )
			$id = $sectionid;
		else if ( $type == 'module_engine' )
		{
			if ( strlen($sn->Module) == 0 )
				return null;
			$id = $sn->Module;
		}
		else if ( $type == 'module_site' )
		{
			if ( $sn->ParentID == 0 || strlen($sn->Module) == 0 )
				return null;
			$id = $sn->ParentID .'/'. $sn->Module;
		}
		
		return array(
			'Type' => $type,
			'ID' => $id
		);
	}

	// получение списка файлов конфига для раздела
	public function GetConfigFileList($sectionid)
	{
		global $CONFIG;
		
		$name = urlencode(STreeMgr::GetNodeByID($sectionid)->Path);
		
		$list = array();
		
		// module_engine
		$file = $this->GetConfigFilePath('module_engine', $sectionid);
		if ( is_file($file) )
			$list['module_engine'] = $file;
		
		// module_site
		$file = $this->GetConfigFilePath('module_site', $sectionid);
		if ( is_file($file) )
			$list['module_site'] = $file;
		
		// section
		$file = $this->GetConfigFilePath('section', $sectionid);
		if ( is_file($file) )
			$list['section'] = $file;
		
		return $list;
	}
	
	// получение списка конфигов для раздела
	public function GetConfigList($sectionid, $global = false)
	{
		global $CONFIG;
		
		if ( STreeMgr::GetNodeByID($sectionid)->TypeInt != 2 )
			return null;
		
		$list = array();
		
		$module_engine = $this->GetConfigPath('module_engine', $sectionid);
		$module_site = $this->GetConfigPath('module_site', $sectionid);
		$section = $this->GetConfigPath('section', $sectionid);
		
		if ( $module_engine !== null )
			$list['module_engine'] = $module_engine;
		if ( $module_site !== null )
			$list['module_site'] = $module_site;
		if ( $section !== null )
			$list['section'] = $section;
			
		return $list;
	}
	
	// обработать конечный конфиг если требуется, выполняется после загрузки всех конфигов
	public function UpdateConfig($config)
	{
		return $config;
	}
	
	abstract public function SetTitle($params = null);
	abstract public function ParseLink($site, $url);
	abstract public function GetLink($sectionid = 0, $params = array(), $withdomain = true);
}
