<?
LibFactory::GetStatic('config');
class Namespace_subsection extends NamespaceBase
{
	public function GetEnv($siteid, $sectionid)
	{
		echo 1;
		exit;
		// берем по сайту и разделу разделу
		LibFactory::GetStatic('bl');
		
		$env_bl = BLFactory::GetInstance('system/env');
		$env_site = $env_bl->GetEnvForSection($siteid);
		$env_section = $env_bl->GetEnvForSection($sectionid, false); // грузим только для раздела
	
		return Data::array_merge_recursive_changed($env_site, $env_section);
	}
	
	// получение пути к файлу конфига
	public function GetConfigFilePath($type, $sectionid)
	{
		global $CONFIG;
				
		if ( $type == 'section' )
		{
			$sn = STreeMgr::GetNodeByID($sectionid);
			$name = urlencode($sn->Path);
			return $CONFIG['engine_path'].'/configure/ns/'. $sn->Parent->Path .'/'.$name.".php";
		}
		
		return parent::GetConfigFilePath($type, $sectionid);
	}
	
	public function ParseLink($site, $url)
	{
		list($nsname, $url) = ModuleFactory::Token($url);
		list($id, $url) = ModuleFactory::Token($url);

		list($sname, $url) = ModuleFactory::Token($url);
		
		$nid = STreeMgr::GetNamespaceIDByTreePath($nsname);
		$ns = STreeMgr::GetNodeByID($nid);
		$p = STreeMgr::GetSectionIDByTreePath($nid, $sname);

		if($p === null)
			return array(0, array(), '');
		return array($p, array('id' => $id), $url);
	}

	public function SetTitle($params = null)
	{
		global $CONFIG, $OBJECTS;
		
		return '';
	}

	public function GetLink($sectionid = 0, $params = array(), $withdomain = true)
	{
		global $CONFIG;

		return '';
	}
}
?>