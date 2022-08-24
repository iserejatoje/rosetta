<?
LibFactory::GetStatic('config');
class Namespace_user extends NamespaceBase
{
	public function GetEnv($siteid, $sectionid)
	{
		global $CONFIG;
		// берем по сайту и разделу разделу
		LibFactory::GetStatic('bl');
		
		$env_bl = BLFactory::GetInstance('system/env');
		$env_site = $env_bl->GetEnvForSection($siteid);
		
		$node = STreeMgr::GetNodeByID($siteid);
		foreach($node->Children as $v)
		{
			$env_site['title'][$v->Path] = $v->Name;
		}
		
		if($CONFIG['env']['svoi'] == true)
			$env_section = $env_bl->GetEnvForSection($sectionid, false); // грузим только для раздела
		else
			$env_section = array();
	
		return Data::array_merge_recursive_changed($env_site, $env_section);
	}
	
	// получение пути к файлу конфига
	public function GetConfigFilePath($type, $sectionid)
	{
		global $CONFIG;
				
		if ( $type == 'section' )
		{
			$name = urlencode(STreeMgr::GetNodeByID($sectionid)->Path);
			return $CONFIG['engine_path'].'/configure/ns/user/'.$name.".php";
		}
		
		return parent::GetConfigFilePath($type, $sectionid);
	}
	
	public function ParseLink($site, $url)
	{
		global $CONFIG, $OBJECTS;
		
		list($nsname, $url) = ModuleFactory::Token($url);
		list($id, $url) = ModuleFactory::Token($url);
		
		$uinfo = $OBJECTS['usersMgr']->GetUser($id, true);
		if($uinfo->IsDel)
			Response::Redirect('/passport/info.php?id='.$id);

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
		global $OBJECTS;

		if($params !== null && is_numeric($params['id']) && $params['id'] > 0)
		{
			$user = $OBJECTS['usersMgr']->GetUser($params['id']);
			$OBJECTS['title']->AppendBefore($user->Profile['general']['ShowName']);
			$OBJECTS['title']->AddPath($user->Profile['general']['ShowName'], '/passport/info.php?id='.$params['id']);
		}
	}

	public function GetLink($sectionid = 0, $params = array(), $withdomain = true)
	{
		global $CONFIG;

		if($params === null)
			$this->params = $params;
		
		$sn = STreeMgr::GetNodeByID($sectionid);

		if( $sn->ID != 0 )
		{
			if($withdomain == true)
				$d = 'http://'.$CONFIG['env']['site']['domain'].DOMAIN_SUFFIX.'/';
			else
				$d = '';
			return $d.'user/'.$params['id'].'/'.$sn->Path.($withdomain?'/':'');
		}
		else
			return false;
	}
	
	public function UpdateConfig($config)
	{
		global $OBJECTS, $CONFIG;
		
		if(!$CONFIG['env']['svoi'] && $config['module'] == 'app_gallery2')
		{
			$index 	= 'design/200608_title/common/2pages.tpl';
			$left	= 'design/200608_title/common/left_block.tpl';
			$right	= 'design/200608_title/common/right_block.tpl';
			$login_form = array('type' => 'block', 'sectionid' => 3219, 'name' => 'login', 'lifetime' => 0);
			
			$config['blocks'] = array(
				'main' => array(
					0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
					1 => array('type' => 'block', 'sectionid' => 5036, 'name' => 'main', 'post' => true, 'ref' =>
						array(
							'link' => array(
								array('source' => 'default', 'destination' => '$this:page'),
								array('source' => '$main/0:rolekey', 'destination' => '$this:rolekey'),
								array('source' => '$main/0:photoid', 'destination' => '$this:id')
							),
							'condition' => array(
								array('type' => 'equal', 'field' => '$main/0:page', 'value' => 'photo'),
								//array('type' => 'notequal', 'field' => '$root:iscomments', 'value' => 0),
							),
						),
					),
				),
				'left' => array(
					'menu_left' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_left', 'lifetime' => 0, 'params' => array()),
				),
				'header' => array(
					'login_form' => $login_form,
					'header_menu_bottom' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_bottom', 'lifetime' => 600, 'params' => array()),
					//'weather' => array('type' => 'widget', 'name' => 'announce/weather/default', 'params' => array('method' => 'sync')),
					'weather' => array('type' => 'widget', 'name' => 'announce/weather_magic/default', 'params' => array('method' => 'sync')),
					),
				'right' => array(
					'messages' => array('type' => 'widget', 'name' => 'announce/messages/default', 'params' => array('method' => 'sync')),
					'friends' => array('type' => 'widget', 'name' => 'announce/friends/default', 'params' => array('method' => 'sync')),
					'mail' => array('type' => 'block', 'name' => 'mail', 'sectionid' => 3999, 'lifetime' => 0, 'params' => array()),
					),
			);

			$config['styles'][1] = '/_styles/design/200608_title/modules/gallery/styles.pack.css';
			$config['templates'] = array(
				'index'			=> $index,
				'index_popup'	=> 'design/200608_title/common/2pages_popup.tpl',
				'left'			=> $left,
				'right'			=> $right,
				'rightsmenu'	=> 'modules/app_gallery/ss/rightsmenu.tpl',
				'header_menu_bottom' => 'modules/mod_passport/menu_bottom_block.tpl',
				'sectiontitle'	=> 'modules/mod_passport/sectiontitle.tpl',
				'pages_link'		=> 'modules/app_gallery/pages_link.tpl',
				'ssections'	=> array(
					'popup_gallery'	=> 'modules/app_gallery/ss/popup_gallery.tpl',
					'popup_album'	=> 'modules/app_gallery/ss/popup_album.tpl',
					'popup_addphoto'=> 'modules/app_gallery/ss/popup_addphoto.tpl',
					'popup_addalbum'=> 'modules/app_gallery/ss/popup_addalbum.tpl',
					
					'gallery'	=> 'modules/app_gallery/ss/gallery.tpl',
					'album'		=> 'modules/app_gallery/ss/album.tpl',
					'photo'		=> 'modules/app_gallery/ss/photo.tpl',
					'addalbum'	=> 'modules/app_gallery/ss/addalbum.tpl',
					'addphoto'	=> 'modules/app_gallery/ss/addphoto.tpl',
					'editalbum'	=> 'modules/app_gallery/ss/addalbum.tpl',
					'editphoto'	=> 'modules/app_gallery/ss/addphoto.tpl',
					'delalbum'	=> 'modules/app_gallery/ss/delalbum.tpl',
					'delphoto'	=> 'modules/app_gallery/ss/delphoto.tpl',
					'messages'	=> 'modules/app_gallery/ss/messages.tpl',
					'thumb'		=> 'modules/app_gallery/ss/thumb.tpl',
					'community_block_right'	=> ENGINE_PATH.'templates/smarty/modules/mod_svoi/ss/community_block_right.tpl',
				),
			);
		}
		
		return parent::UpdateConfig($config);
	}
}
?>