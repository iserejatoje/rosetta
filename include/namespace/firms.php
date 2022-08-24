<?
LibFactory::GetStatic('config');
class Namespace_firms extends NamespaceBase
{
	static private $config = array(
		'site' => array(),
		'section' => array(),
		'module_engine' => array());

	private function LoadConfig($type, $params)
	{
		global $CONFIG, $ERROR;
		global $MCONFIG, $SCONFIG, $DCONFIG; //это надо убрать

		if($type == "section" && $params['section'] != 0)
		{
			$name = urlencode($CONFIG['tree'][$params['section']]['path']);
			$file = $CONFIG['engine_path'].'/configure/ns/firms/'.$name.".php";
			if(is_file($file))
			{
				$this->config['section'][$params['section']] = ConfigFactory::GetConfig($file);
				$this->config['section'][$params['section']]['module'] = $CONFIG['tree'][$params['section']]['module'];
			}
			else
				Data::e_backtrace("Can't load config: '".$file."'; sectionID='".$params['section']."'");
		}
		else if($type == "module_engine" && $params['module'] != "")
		{
			$file = $CONFIG['engine_path'].'/configure/modules/'.$params['module'].".php";
			if(is_file($file))
				$this->config['module_engine'][$params['module']] = ConfigFactory::GetConfig($file);
			else
				Data::e_backtrace("Can't load config: '".$file."'; Module='".$params['module']."'");
		}
		elseif($type == "site" && $params['site'] != 0 && $CONFIG['tree'][$params['site']]['type'] == 1)
		{
			$params['site'] = $CONFIG['siteid_v2'][ $CONFIG['env']['site']['domain'] ];
			LibFactory::GetStatic('bl');
			$bl = BLFactory::GetInstance('system/env');
			$this->config['site'][$params['site']] = $bl->GetEnvForSection($params['site']);
			
			// добавим title еще
			foreach($CONFIG['tree'] as $k => $v)
			{
				if($v['parent'] == $params['site'])
					$this->config['site'][$params['site']]['title'][$v['path']] = $v['name'];
			}
		}
	}

	public function GetConfig($type = "", $id = 0)
	{
		global $CONFIG;

		LibFactory::GetStatic('data');

		if($type == 'site' || $type == 'section')
		{
			if( !isset($CONFIG['tree'][$id]) )
			{
				Data::e_backtrace("Section not found; sectionID='".$id."'");
				return array();
			}
		}
		else
			return array();

		if($type == 'site')
		{
			if( !isset($this->config['site'][$id]) )
				self::LoadConfig('site', array(
						'site' => $id
					)
				);

			return Data::array_merge_recursive_changed(
				$this->config['site'][$id],
				array('tree_id' => $id)
			);
		}
		else if($type == 'section')
		{
			if( !isset($CONFIG['tree'][ $CONFIG['tree'][$id]['parent'] ]) )
			{
				Data::e_backtrace("Parent section not found; sectionID='".$id."'");
				return array();
			}

			$site_id = $CONFIG['tree'][$id]['parent'];
			if( !isset($this->config['section'][$id]) )
				self::LoadConfig('section', array(
						'section' => $id
					)
				);
			if( !isset($this->config['module_engine'][$this->config['section'][$id]['module']]) )
				self::LoadConfig('module_engine', array(
						'module' => $this->config['section'][$id]['module']
					)
				);

			return Data::array_merge_recursive_changed(
				$this->config['module_engine'][$this->config['section'][$id]['module']],
				$this->config['section'][$id]
			);
		}
	}

	public function ParseLink($site, $url)
	{
		global $CONFIG;
		list($nsname, $url) = ModuleFactory::Token($url);
		list($id, $url) = ModuleFactory::Token($url);

		list($sname, $url) = ModuleFactory::Token($url);

		if(!isset($CONFIG['sectionid_v2'][ $CONFIG['site_namespace'][$nsname] ][$sname]))
			return array(0, array(), '');
		return array($CONFIG['sectionid_v2'][$CONFIG['site_namespace'][$nsname]][$sname], array('id' => $id), $url);
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