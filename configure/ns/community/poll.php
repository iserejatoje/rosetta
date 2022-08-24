<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_poll2',
	'title' 	=> 'Голосования',
	'space'		=> 'svoi_poll',
	'subsection'	=> array(
		'sectionid' => 5043,
	),
	
	'styles' => array(
		'common' => '/_styles/design/200901_social/common/styles.css',
		'mod_poll' => '/_styles/design/200901_social/modules/poll/styles.css',
		),
		
	'templates'	=> array(
		'index'					=> '_design/200901_social/common/2pages.tpl',
		'left'					=> '_design/200901_social/common/left_block.tpl',
		'right'					=> '_design/200901_social/common/right_block.tpl',
		'header_menu_bottom' 	=> '_modules/mod_svoi/header_menu_bottom.tpl',
		'sectiontitle'			=> '_design/200901_social/mod_svoi/section_title.tpl',
		'pages_link'			=> '_design/200901_social/mod_passport/pages_link.tpl',
		'ssections'	=> array(
			'view'					=> '_design/200901_social/mod_poll/ss/view.tpl',
			'view_poll'				=> '_design/200901_social/mod_poll/ss/view_poll.tpl',
			'view_poll_result'		=> '_design/200901_social/mod_poll/ss/view_poll_result.tpl',
			'last'					=> '_design/200901_social/mod_poll/ss/list.tpl',
			'last_list'				=> '_design/200901_social/mod_poll/ss/last_list.tpl',
			'edit'					=> '_design/200901_social/mod_poll/ss/edit.tpl',
			'edit_poll'				=> '_design/200901_social/mod_poll/ss/edit_poll.tpl',
			'messages'				=> '_design/200901_social/mod_poll/ss/messages.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'blocks' => array(
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
			'sitebar' => array('type' => 'widget', 'name' => 'announce/sitebar/default', 'params' => array('method' => 'sync')),
		),
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
			//array('type' => 'widget', 'name' => 'control/svoi_subtitle/default', 'params' => array('method' => 'sync'), 'ref' => array('link' => array())),
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
		'right' => array(
		),
		'section_title' => array(
			array('type' => 'widget', 'name' => 'control/section_title/svoi', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:page', 'destination' => '$this:page'),
					)
				),
			),
			array('type' => 'widget', 'name' => 'control/svoi_subtitle/default', 'params' => array('method' => 'sync'), 'ref' => array('link' => array())),
		),
	),
);

?>


