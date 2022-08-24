<?
LibFactory::GetStatic('config');
// загружает дополнительно 3 конфигурационных файла, для типа section
// [гл. дизайн]		1. Конфигурационный файл глобального дизайна (применяется всегда)
// [дизайн]			2. Конфигурационный файл дизайна (по модулю)
// [сайт]			3. Конфигурационный файл сайта (здесь указан дизайн)
// [сайт][раздел]	4. Конфигурационный файл социалки (загружается только для страниц конкретного сообщества и страницы групп)
// !!!!!! Нынешний подход в использовании пространств не позволяет разделить отдельные модули, пространство созадется одно, на
// !!!!!! все модули находящиеся в нем, исходя из этого невозможно четко определить, где и как обрабатывать
// !!!!!! только кастыль в виде приватной переменной, в который по id раздела указана инфа

// пространство глобальных разделов для всех сайтов
// в дереве сайтов указывается пространство (тип 5), ему назначается данное пространство
class Namespace_global extends NamespaceBase
{
	static protected $load_addition_config = false;
	public function GetEnv($siteid, $sectionid)
	{

		// берем по сайту и разделу разделу
		LibFactory::GetStatic('bl');

		$env_bl = BLFactory::GetInstance('system/env');
		$env_site = $env_bl->GetEnvForSection($siteid);
		$env_section = $env_bl->GetEnvForSection($sectionid, false); // грузим только для раздела
		
		//$node = STreeMgr::GetNodeById($siteid);
		//$env_site['regid'] = $node->Regions;

		return Data::array_merge_recursive_changed($env_site, $env_section);
	}

	public function GetConfigFilePath($type, $sectionid)
	{
		global $CONFIG;

		/*if(self::$load_addition_config === true)
		{
			$node = STreeMgr::GetNodeByID($sectionid);
			$site_id = STreeMgr::GetSiteIDByHost($CONFIG['env']['site']['domain']);
			$site_info = STreeMgr::GetNodeByID($site_id);

			if ( $type == 'design' )
			{
				$file = $site_info->OldSitePath .'/configure/'. $node->Module .".php";
				if ( is_file($file) )
				{
					$site_design = ConfigFactory::GetConfig($file);
					return $CONFIG['engine_path'] .'/configure/design/'. $node->Module .'/'. $site_design['design'] .".php";
				}
				return '';}
			if ( $type == 'module_design' )
			{
				$file = $site_info->OldSitePath .'/configure/'. $node->Module .".php";
				if ( is_file($file) )
					$site_design = ConfigFactory::GetConfig($file);
				return $CONFIG['engine_path'] .'/configure/ns/global/design/'. $node->Module .'/'. $site_design['design'] .".php";
			}
			if ( $type == 'site_design' )
				return $site_info->OldSitePath .'/configure/'. $node->Module .".php";
			if ( $type == 'local' )
			{
				$name = urlencode($node->Path);
				return $site_info->OldSitePath ."/configure/ns/global/".$name.".php";
			}
		}*/

		return parent::GetConfigFilePath($type, $sectionid);
	}

	// получение идентификатора конфига для раздела
	public function GetConfigPath($type, $sectionid)
	{
		global $CONFIG;

		if(self::$load_addition_config === true)
		{
			$node = STreeMgr::GetNodeByID($sectionid);
			$site_id = STreeMgr::GetSiteIDByHost($CONFIG['env']['site']['domain']);

			if ( $type == 'design' )
			{
				LibFactory::GetStatic('bl');
				$bl = BLFactory::GetInstance('system/config');
				$site_design = $bl->LoadConfig('site_design', $node->Module .'/'. $site_id );
				if ( isset($site_design['design']) )
				{
					return array(
						'Type' => $type,
						'ID' => $node->Module .'/'. $site_design['design']
					);
				}
				return null;
			}
			if ( $type == 'module_design' )
			{
				LibFactory::GetStatic('bl');
				$bl = BLFactory::GetInstance('system/config');
				$site_design = $bl->LoadConfig('site_design', $node->Path .'/'. $site_id );
				if ( isset($site_design['design']) )
				{
					return array(
						'Type' => $type,
						'ID' => $site_design['design'] .'/'. $node->Path
					);
				}
				return null;
			}
			if ( $type == 'site_design' && $site_id > 0 )
				return array(
					'Type' => $type,
					'ID' => $node->Path .'/'. $site_id
				);
		}

		return parent::GetConfigPath($type, $sectionid);
	}

	// получение списка файлов конфига для раздела
	public function GetConfigFileList($sectionid)
	{
		$list = array();

		// design
		$file = $this->GetConfigFilePath('design', $sectionid);
		if ( is_file($file) )
			$list['design'] = $file;
		// module_design
		$file = $this->GetConfigFilePath('module_design', $sectionid);
		if ( is_file($file) )
			$list['module_design'] = $file;
		// site_design
		$file = $this->GetConfigFilePath('site_design', $sectionid);
		if ( is_file($file) )
			$list['site_design'] = $file;
		// local
		$file = $this->GetConfigFilePath('local', $sectionid);
		if ( is_file($file) )
			$list['local'] = $file;

		$cs =  array_merge( parent::GetConfigFileList($sectionid), $list );
		return $cs;
	}

	// получение списка конфигов для раздела
	public function GetConfigList($sectionid, $global = false)
	{
		global $CONFIG;

		if ( STreeMgr::GetNodeByID($sectionid)->TypeInt != 2 )
			return null;

		if ( $global === false )
		{
			$design = $this->GetConfigPath('design', $sectionid);
			$module_design = $this->GetConfigPath('module_design', $sectionid);
			$site_design = $this->GetConfigPath('site_design', $sectionid);

			$list = parent::GetConfigList($sectionid, $global);

			if ( $design !== null )
				$list['design'] = $design;
			if ( $module_design !== null )
				$list['module_design'] = $module_design;
			if ( $site_design !== null )
				$list['site_design'] = $site_design;

			//App::$CurrentEnv['site']['design'] = 'default';

			return $list;
		}
		self::$load_addition_config = true;
		$list[''] = parent::GetConfigList($sectionid, $global);

		$_domain = $CONFIG['env']['site']['domain'];

		$sites = STreeMgr::Iterator(array('type' => 1));
		foreach ( $sites as $site )
		{
			$CONFIG['env']['site']['domain'] = $site->Name;
			//$list[$site->Parent->Name][$site->Name]['design'] = $this->GetConfigPath('design', $sectionid);
			//$list[$site->Parent->Name][$site->Name]['module_design'] = $this->GetConfigPath('module_design', $sectionid);
			$list[$site->Parent->Name][$site->Name]['site_design'] = $this->GetConfigPath('site_design', $sectionid);
		}
		ksort($list);

		$CONFIG['env']['site']['domain'] = $_domain;
		return $list;
	}

	public function ParseLink($site, $url)
	{
		global $CONFIG;
		
		// имя пространства и по совместительству имя раздела
		list($token, $url) = ModuleFactory::Token($url);
		
		$nid = STreeMgr::GetNamespaceIDByTreePath($token);
		$ns = STreeMgr::GetNodeByID($nid);
		$nsname = $ns->Module;

		$p = STreeMgr::GetSectionIDByTreePath($nid, $token);

		if($p === null)
			return array(0, array(), '');

		//2do: убрать, как избавимся от разных дизайнов в социалке
		if($token == 'help'
			|| $token == 'tags'
			//|| $token == 'blog'
		)
		{
			self::$load_addition_config = true;
		}

		return array($p, array(), $url);
	}

	public function SetTitle($params = null)
	{
	}

	public function GetLink($sectionid = 0, $params = array(), $withdomain = true)
	{
		global $CONFIG;

		try
		{
			$sinfo = STreeMgr::GetNodeByID($sectionid);
		}
		catch(exception $e)
		{
			return false;
		}

		if($withdomain == true)
			$d = 'http://'.$CONFIG['env']['site']['domain'].DOMAIN_SUFFIX.'/';
		else
			$d = '';
		return $d.$sinfo->Path.($withdomain?'/':'');
	}

	public function UpdateConfig($config)
	{
		global $CONFIG;
		if(self::$load_addition_config === true && isset($config['stpl_design']))
		{
			$CONFIG['env']['site']['design'] = $config['stpl_design'];
			STPL::SetTheme($config['stpl_design']);
		}

		return $config;
	}
}
?>
