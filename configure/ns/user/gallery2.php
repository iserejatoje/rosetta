<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_gallery2',
	'title' 	=> 'Галлерея пользователя',
	'rights'	=> 'gallery_passport',
	'gallery_type' => 'passport',
	'space'		=> 'passport_gallery',
	'subsection'	=> array(
		'sectionid' => 3219
		),
	'db' => 'passport',
	
	'tables' => array(
		'galleries'	=> 'users_gallery',
		'albums'	=> 'users_gallery_albums',
		'photos'	=> 'users_gallery_photos',
	),
	
	'photo' => array(
		'path'		=> '/common_fs/i/passport/gallery/photo/',
		'url'		=> 'http://other.img.rugion.ru/_i/passport/gallery/photo/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/passport/gallery/thumb/',
		'url'		=> 'http://other.img.rugion.ru/_i/passport/gallery/thumb/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title_blue/common/2pages.tpl',
		'left'			=> '_design/200608_title_blue/common/left_block.tpl',
		'right'			=> '_design/200608_title_blue/common/right_block.tpl',
		'rightsmenu'	=> '_modules/app_gallery/ss/rightsmenu.tpl',
		'header_menu_bottom' => '_modules/mod_passport/menu_bottom_block.tpl',
		'sectiontitle'	=> '_modules/mod_passport/sectiontitle.tpl',
		'ssections'	=> array(
			'gallery'	=> '_modules/app_gallery/ss/gallery.tpl',
			'album'		=> '_modules/app_gallery/ss/album.tpl',
			'photo'		=> '_modules/app_gallery/ss/photo.tpl',
			'addalbum'	=> '_modules/app_gallery/ss/addalbum.tpl',
			'addphoto'	=> '_modules/app_gallery/ss/addphoto.tpl',
			'delalbum'	=> '_modules/app_gallery/ss/delalbum.tpl',
			'delphoto'	=> '_modules/app_gallery/ss/delphoto.tpl',
			'messages'	=> '_modules/app_gallery/ss/messages.tpl',
			'thumb'		=> '_modules/app_gallery/ss/thumb.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'blocks' => array(
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
			'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'title_blue', 'place' => 'header')),
			'header_menu_bottom' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_bottom', 'lifetime' => 600, 'params' => array()),
			//'weather' => array('type' => 'widget', 'name' => 'announce/weather/default', 'params' => array('method' => 'sync')),
			'weather' => array('type' => 'widget', 'name' => 'announce/weather_magic/default', 'params' => array('method' => 'sync')),
			),
		'right' => array(
			'messages' => array('type' => 'widget', 'name' => 'announce/messages/default', 'params' => array('method' => 'sync')),
			'friends' => array('type' => 'widget', 'name' => 'announce/friends/default', 'params' => array('method' => 'sync')),
			'mail' => array('type' => 'block', 'name' => 'mail', 'sectionid' => 3999, 'lifetime' => 0, 'params' => array()),
			),
	),
);

?>