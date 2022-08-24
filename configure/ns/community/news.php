<?

return array(
	'module'	=> 'app_news2',
	'title' 	=> 'Новости сообщества',
	'space'		=> 'svoi_news',
	'subsection'	=> array(
		'sectionid' => 5043,
		),
		
	'styles' => array(
		'common' => '/_styles/design/200901_social/common/styles.css',
		'mod_news' => '/_styles/design/200901_social/modules/news/styles.css',
		),
		
	'templates'	=> array(
		'index'			=> '_design/200901_social/common/2pages.tpl',
		'left'			=> '_design/200901_social/common/left_block.tpl',
		'right'			=> '_design/200901_social/common/right_block.tpl',
		'sectiontitle'	=> '_design/200901_social/mod_svoi/section_title.tpl',
		'pages_link'	=> '_design/200901_social/mod_passport/pages_link.tpl',
		'ssections'	=> array(
			'view'		=> '_design/200901_social/mod_news/ss/app_news_view.tpl',
			'view_list'	=> '_design/200901_social/mod_news/ss/view_list.tpl',
			'last'		=> '_design/200901_social/mod_news/ss/app_news_list.tpl',
			'edit'		=> '_design/200901_social/mod_news/ss/app_news_edit.tpl',
			'messages'	=> '_design/200901_social/mod_news/ss/app_news_messages.tpl',
		),
	),

	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
			1 => array('type' => 'block', 'sectionid' => 5038, 'name' => 'main', 'post' => true, 'ref' =>
				array(
					'link' => array(
						array('source' => 'default', 'destination' => '$this:page'),
						array('source' => '$main/0:rolekey', 'destination' => '$this:rolekey'),
						array('source' => '$main/0:id', 'destination' => '$this:id')
					),
					'condition' => array(
						array('type' => 'equal', 'field' => '$main/0:page', 'value' => 'view'),
						array('type' => 'notequal', 'field' => '$main/0:iscomments', 'value' => 0),
					),
				),
			),
			//array('type' => 'widget', 'name' => 'control/svoi_subtitle/default', 'params' => array('method' => 'sync'), 'ref' => array('link' => array())),
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
			'sitebar' => array('type' => 'widget', 'name' => 'announce/sitebar/default', 'params' => array('method' => 'sync')),
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