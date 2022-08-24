<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'forum_magic',
	'space' 	=> 'svoi_forum_v2',
	'subsection'	=> array(
		'sectionid' => 5043
	),
	
	//'root' => 1005598,
	
	'styles' => array(
		'common' => '/_styles/design/200901_social/common/styles.css',
		'mod_forum'=>'/_styles/design/200901_social/modules/forum/styles.ss',
		),
	'scripts' => array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		),

	'templates' => array(
		'index'				=> '_design/200901_social/common/2pages.tpl',
		'right'				=> null,
		'left'				=> '_design/200901_social/common/left_block.tpl',
		'block_active'		=> '_design/200901_social/mod_forum/block_active.tpl',
		'block_section'		=> '_design/200901_social/mod_forum/block_section.tpl',
		'sectiontitle'		=> '_design/200901_social/mod_svoi/section_title.tpl',

		'ssections' => array(
			'default'			=> '_design/200901_social/mod_forum/ss/default.tpl', // выводим через него блочные страницы
			'header'			=> '_design/200901_social/mod_forum/ss/header.tpl',
			'admins'			=> '_design/200901_social/mod_forum/ss/admins.tpl',
			'active'			=> '_design/200901_social/mod_forum/ss/active.tpl',
			'selected'			=> '_design/200901_social/mod_forum/ss/selected.tpl',
			'rules'				=> '_design/200901_social/mod_forum/ss/rules.tpl',
			'active_messages'	=> '_design/200901_social/mod_forum/ss/active_messages.tpl',
			'selected_messages'	=> '_design/200901_social/mod_forum/ss/selected_messages.tpl',
			'active_other'		=> '_design/200901_social/mod_forum/ss/active_other.tpl',
			'new_theme'			=> '_design/200901_social/mod_forum/ss/new_theme.tpl',
			'new_message'		=> '_design/200901_social/mod_forum/ss/new_message.tpl',
			'edit_message'		=> '_design/200901_social/mod_forum/ss/edit_message.tpl',
			'theme'				=> '_design/200901_social/mod_forum/ss/theme.tpl',
			'theme_messages'	=> '_design/200901_social/mod_forum/ss/theme_messages.tpl',
			'view'				=> '_design/200901_social/mod_forum/ss/view.tpl',
			'view_sections'		=> '_design/200901_social/mod_forum/ss/view_sections.tpl',
			'view_statistic'	=> '_design/200901_social/mod_forum/ss/view_statistic.tpl',
			'view_sections_other'=> '_design/200901_social/mod_forum/ss/view_sections_other.tpl',
			'view_themes'		=> '_design/200901_social/mod_forum/ss/view_themes.tpl',
			'editor'			=> '_design/200901_social/mod_forum/ss/editor.tpl',
			'messages'			=> '_design/200901_social/mod_forum/ss/messages.tpl',
			'select_section'	=> '_design/200901_social/mod_forum/ss/select_section.tpl',
			'smiles'			=> '_design/200901_social/mod_forum/ss/smiles.tpl',

			'send_alert'		=> '_design/200901_social/mod_forum/ss/send_alert.tpl',
			'offence'			=> '_design/200901_social/mod_forum/ss/offence.tpl',
			'offence_plus'		=> '_design/200901_social/mod_forum/ss/offence_plus.tpl',
			'block'				=> '_design/200901_social/mod_forum/ss/block.tpl',
			'block_ip_list'		=> '_design/200901_social/mod_forum/ss/block_ip_list.tpl',
			'block_cookie_list'	=> '_design/200901_social/mod_forum/ss/block_cookie_list.tpl',
		),
	),
	
	'tables' => array(
		'rootref'		=> 'rootref', // нужна только для приложения
		'alert'			=> 'alert',
		'sections'		=> 'sections',
		'themes'		=> 'themes',
		'messages'		=> 'messages',
		'selected'		=> 'selected',
		'files'			=> 'files',
		),

	'deny_favorites' => true,
	
	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
		),
		'left' => array(
			//'block_left_menu' => array('type' => 'block', 'name' => 'left_menu', 'sectionid' => 9139, 'lifetime' => 0, 'params' => array()),
			
			array('type' => 'widget', 'name' => 'control/left_menu/default', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:page', 'destination' => '$this:page'),
					)
				)
			),
			array('type' => 'widget', 'name' => 'announce/messages/default', 'params' => array(
				'method' => 'sync',
				'config' => 'announce/messages/social',
				'container' => 'containers/empty.tpl',
				)
			),
			/*array('type' => 'widget', 'name' => 'user/advertise/default', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
					),
					'condition' => array(
					),
				),
			),*/
			array('type' => 'widget', 'name' => 'announce/groups/default', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
					),
					'condition' => array(
					),
				),
			),
			
		),
		'header' => array(
			'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'social', 'place' => 'header')),
			'people_search' => array('type' => 'widget', 'name' => 'user/search/form', 'params' => array('method' => 'sync', 'place'=> 'header'),
				'ref' => array(
					'link' => array(
					),
					'condition' => array(
					),
				),
			),
		),
	),
);

?>


