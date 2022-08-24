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
		'index'				=> '_design/200901_social/common/2pages.tpl',
		'index_popup'		=> '_design/200901_social/common/2pages_popup.tpl',
		'right'				=> '_design/200901_social/common/right_block.tpl',
		'left'				=> '_design/200901_social/common/left_block.tpl',		
		'rightsmenu'		=> '_design/200901_social/mod_gallery/ss/rightsmenu.tpl',
		'sectiontitle'		=> '_design/200901_social/mod_svoi/section_title.tpl',
		'ssections'	=> array(
			'gallery'	=> '_design/200901_social/mod_gallery/ss/gallery.tpl',
			'album'		=> '_design/200901_social/mod_gallery/ss/album.tpl',
			'photo'		=> '_design/200901_social/mod_gallery/ss/photo.tpl',
			'addalbum'	=> '_design/200901_social/mod_gallery/ss/addalbum.tpl',
			'editalbum'	=> '_design/200901_social/mod_gallery/ss/addalbum.tpl',
			'addphoto'	=> '_design/200901_social/mod_gallery/ss/addphoto.tpl',
			'editphoto'	=> '_design/200901_social/mod_gallery/ss/addphoto.tpl',
			'delalbum'	=> '_design/200901_social/mod_gallery/ss/delalbum.tpl',
			'delphoto'	=> '_design/200901_social/mod_gallery/ss/delphoto.tpl',
			'messages'	=> '_design/200901_social/mod_gallery/ss/messages.tpl',
			'thumb'		=> '_design/200901_social/mod_gallery/ss/thumb.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'styles' => array(
		'/_styles/design/200901_social/common/styles.css',
		'/_styles/design/200901_social/modules/gallery/styles.pack.css',
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
		'right' => array(
			),
		'section_title' => array(
			array('type' => 'widget', 'name' => 'control/section_title/svoi', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
					)
				),
			)
		),
	),
);

?>