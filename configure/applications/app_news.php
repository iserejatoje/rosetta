<?

/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'messages' 	=> array('regexp' => '@^msg\.([a-z0-9\-_]+)\.html$@', 'matches' => array(1 => 'message')),
			'last' 		=> array('string' => 'last.php'),
			'del' 		=> array('string' => 'del.php'),
			'edit'		=> array('string' => 'edit.php'),
			'view' 		=> array('regexp' => '@^([0-9]+)\.php$@', 'matches' => array(1 => 'newsid')),
			'default' 	=> array('regexp' => '@^.*$@'),
		),
		'post' => array(
			'edit' 		=> array(),
		),
	),
	'module'			=> 'app_news',
	'db'				=> 'passport',
	
	'offset' 			=> 0,
	'row_on_page' 		=> 5,
	'links_on_page' 		=> 5,
	
	'styles' => array(),
	
	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this','name' => 'main','lifetime' => 0),
			/*array('type' => 'component', 'name' => 'svoi/community/comments', 'page' => 'default.php', 'ref' => 
				array(
					'link' => array(array('source' => '$main/0:id', 'destination' => '$this:parentid')),
					'condition' => array(
						array('type' => 'equal', 'field' => '$main/0:page', 'value' => 'view'),
						array('type' => 'notequal', 'field' => '$main/0:iscomments', 'value' => 0),
					),
				)
			),*/
		),
		'header' => array(
			'login_form' => array('type' => 'block', 'sectionid' => 3629, 'name' => 'login', 'lifetime' => 0),
			'weather' => array('type' => 'widget', 'name' => 'announce/weather_magic/default', 'params' => array('method' => 'sync')),
			'header_menu_bottom' => array('type' => 'this', 'name' => 'header_menu_bottom', 'lifetime' => 0),
		),
		'block' => array(
		),
	),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title/common/2pages.tpl',
		'left'			=> '_design/200608_title/common/left_block.tpl',
		'right'			=> '_design/200608_title/common/right_block.tpl',
		'header_menu_bottom' => '_modules/mod_svoi/header_menu_bottom.tpl',
		'sectiontitle'	=> '_modules/mod_svoi/sectiontitle.tpl',
		'ssections'	=> array(
			'view'		=> '_modules/app_news/ss/app_news_view.tpl',
			'view_list'	=> '_modules/app_news/ss/view_list.tpl',
			'last'		=> '_modules/app_news/ss/app_news_list.tpl',
			'edit'		=> '_modules/app_news/ss/app_news_edit.tpl',
			'messages'	=> '_modules/app_news/ss/app_news_messages.tpl',
		),
	),
	
	'tables' => array(
		'article'	=> 'news',
	),
	
);

?>


