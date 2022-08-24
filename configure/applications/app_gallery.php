<?

static $gallery_error_code = 0;
define('ERR_M_GALLERY_MASK', 0x00330000);
define('ERR_M_GALLERY_UNKNOWN_ERROR', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_UNKNOWN_ERROR]
	= 'Незвестная ошибка.';
define('ERR_M_GALLERY_ALBUM_TITLE_EMPTY', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_ALBUM_TITLE_EMPTY]
	= 'Вы не указали имя альбома.';
define('ERR_M_GALLERY_ALBUM_TITLE_TO_LONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_ALBUM_TITLE_TO_LONG]
	= 'Длина имени альбома не должна превышать %1$s знаков.';
	
define('ERR_M_GALLERY_ALBUM_DESCR_TO_LONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_ALBUM_DESCR_TO_LONG]
	= 'Длина описания альбома не должна превышать %1$s знаков.';
	
define('ERR_M_GALLERY_PHOTO_TITLE_EMPTY', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_TITLE_EMPTY]
	= 'Вы не указали имя фотографии.';
define('ERR_M_GALLERY_PHOTO_TITLE_TO_LONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_TITLE_TO_LONG]
	= 'Длина имени фотографии не должна превышать %1$s знаков.';
define('ERR_M_GALLERY_PHOTO_WRONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_WRONG]
	= 'Фотография не удовлетворяет указанным условиям.';
define('ERR_M_GALLERY_PHOTO_EMPTY', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_EMPTY]
	= 'Вы не выбрали фотографию.';
define('ERR_M_GALLERY_PHOTO_TYPE_WRONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_TYPE_WRONG]
	= 'Данный тип изображения не поддерживается. Можно добавить только файлы <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>.';

define('ERR_M_GALLERY_PHOTO_DESCR_TO_LONG', ERR_M_GALLERY_MASK | $gallery_error_code++);
$ERROR[ERR_M_GALLERY_PHOTO_DESCR_TO_LONG]
	= 'Длина описания фотографии не должна превышать %1$s знаков.';



/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'messages'	=> array('regexp' => '@^msg\.([a-z0-9\-_]+)\.html$@', 'matches' => array(1 => 'message')),
			'gallery' 	=> array('regexp' => '@^gallery/([\d]+)\.php$@', 'matches' => array(1 => 'gallery')),
			'album' 	=> array('regexp' => '@^album/([\d]+)\.php$@', 'matches' => array(1 => 'album')),
			'photo' 	=> array('regexp' => '@^photo/([\d]+)\.php$@', 'matches' => array(1 => 'photo')),
			'addalbum'	=> array('regexp' => '@^gallery/([\d]+)/addalbum.php$@', 'matches' => array(1 => 'gallery')),
			'addphoto'	=> array('regexp' => '@^album/([\d]+)/addphoto.php$@', 'matches' => array(1 => 'album')),
			'delalbum'	=> array('regexp' => '@^delalbum/([\d]+)\.php$@', 'matches' => array(1 => 'album')),
			'editalbum'	=> array('regexp' => '@^editalbum/([\d]+)\.php$@', 'matches' => array(1 => 'album')),
			'delphoto'	=> array('regexp' => '@^delphoto/([\d]+)\.php$@', 'matches' => array(1 => 'photo')),
			'editphoto'	=> array('regexp' => '@^editphoto/([\d]+)\.php$@', 'matches' => array(1 => 'photo')),
			'default' 	=> array('regexp' => '@^.*$@'),
		),
		'post' => array(
			'addalbum' 		=> array(),
			'addphoto' 		=> array(),
			'editphoto' 	=> array(),
			'editalbum' 	=> array(),
			'setrights'		=> array(),
			//'delalbum' 		=> array(),
			//'delphoto' 		=> array(),
		),
		'block' => array(
		),
	),
	'module'			=> 'app_gallery',
	'db'				=> 'passport',

	'mode'				=> 'gallery',
	
	'offset' 			=> 0,
	'row_on_page' 		=> 5,
	'links_on_page' 	=> 5,
	
	'styles' => array(
		'/_styles/modules/passport/passport.css',
	),

	'limits' => array(
		'max_title_len' => 100,
		'max_descr_len' => 500,
	),
	
	'max_source_photo_size' => array(
		'size' => 2 * 1024 * 1024,
		'width' => 1600,
		'height' => 1200,
		),

	'photo' => array(
		'path'		=> '/common_fs/i/svoi/gallery/photo/',
		'url'		=> 'http://other.img.rugion.ru/_i/svoi/gallery/photo/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/svoi/gallery/thumb/',
		'url'		=> 'http://other.img.rugion.ru/_i/svoi/gallery/thumb/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
	
	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this','name' => 'main','lifetime' => 0),
		),
		'header' => array(
			'login_form' => array('type' => 'block', 'sectionid' => 3629, 'name' => 'login', 'lifetime' => 0),
			'weather' => array('type' => 'widget', 'name' => 'announce/weather_magic/default', 'params' => array('method' => 'sync')),
			'header_menu_bottom' => array('type' => 'this', 'name' => 'header_menu_bottom', 'lifetime' => 0),
		),
	),

	'scripts' => array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		'/_scripts/modules/app_gallery/gallery.js',
		),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title_blue/common/2pages.tpl',
		'left'			=> '_design/200608_title_blue/common/left_block.tpl',
		'right'			=> '_design/200608_title_blue/common/right_block.tpl',
		'rightsmenu'	=> '_modules/app_gallery/ss/rightsmenu.tpl',
		'header_menu_bottom' => '_modules/mod_svoi/header_menu_bottom.tpl',
		'sectiontitle'	=> '_modules/mod_svoi/sectiontitle.tpl',
		'ssections'	=> array(
			'gallery'	=> '_modules/app_gallery/ss/gallery.tpl',
			'album'		=> '_modules/app_gallery/ss/album.tpl',
			'photo'		=> '_modules/app_gallery/ss/photo.tpl',
			'addalbum'	=> '_modules/app_gallery/ss/addalbum.tpl',
			'editalbum'	=> '_modules/app_gallery/ss/addalbum.tpl',
			'addphoto'	=> '_modules/app_gallery/ss/addphoto.tpl',
			'editphoto'	=> '_modules/app_gallery/ss/addphoto.tpl',
			'delalbum'	=> '_modules/app_gallery/ss/delalbum.tpl',
			'delphoto'	=> '_modules/app_gallery/ss/delphoto.tpl',
			'messages'	=> '_modules/app_gallery/ss/messages.tpl',
			'thumb'		=> '_modules/app_gallery/ss/thumb.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'tables' => array(
		'galleries'	=> 'gallery',
		'albums'	=> 'gallery_albums',
		'photos'	=> 'gallery_photos',
	),

	
);

?>