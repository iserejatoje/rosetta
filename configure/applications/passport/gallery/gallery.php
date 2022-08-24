<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_gallery',
	'title' 	=> 'Галлерея пользователя',
	'rights'	=> 'gallery_passport',
	'gallery_type' => 'passport',
	'space'		=> 'passport_gallery',
	'subsection'	=> array(
		'name' 	=> 'passport',
		'folder'=> 'passport',
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
		'file_size' => 700 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/passport/gallery/thumb/',
		'url'		=> 'http://other.img.rugion.ru/_i/passport/gallery/thumb/',
		'file_size' => 100 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title/common/2pages.tpl',
		'left'			=> '_design/200608_title/common/left_block.tpl',
		'right'			=> '_design/200608_title/common/right_block.tpl',
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
);

?>