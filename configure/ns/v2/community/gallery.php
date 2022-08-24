<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_gallery2',
	'title' 	=> 'Галлерея сообщества',
	'rights'	=> 'gallery_svoi',
	'gallery_type' => 'passport',
	'space'		=> 'svoi_gallery',
	'subsection'	=> array(
		'sectionid' => 5043,
		),
	'db' => 'passport',
	
	'templates'	=> array(
		'index'				=> '_design/200901_social/common/2pages.tpl',
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
		'common' => '/_styles/design/200901_social/common/styles.css',
		'mod_gallery' => '/_styles/design/200901_social/modules/gallery/styles.css',
		),
	
	'tables' => array(
		'galleries'	=> 'gallery',
		'albums'	=> 'gallery_albums',
		'photos'	=> 'gallery_photos',
	),
	
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
		'right' => array(
		),
	),
);

?>