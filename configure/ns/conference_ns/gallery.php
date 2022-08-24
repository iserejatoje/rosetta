<?

/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'module_gallery' 	=> array('string' => 'module_gallery.php'),
			'default' => array('regexp' => '@^$@'),
		),
	),
	
	'security' => array(),
	
	'module'			=> 'app_gallery2',
	'db'				=> 'conference',

	'max_source_photo_size' => array(
		'size' => 2 * 1024 * 1024,
		'width' => 1600,
		'height' => 1200,
	),

	'scripts'			=> array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		'/_scripts/themes/frameworks/jquery/jquery.fancybox.js',
		'/_scripts/themes/frameworks/jquery/jquery.pngFix.js',
	),
	'styles'			=> array(
		'/_styles/jquery/fancy/jquery.fancy.css',
	),
	
	'templates'	=> array(
		'ssections'	=> array(
			'module_gallery'	=> '_modules/mod_conference/ss/gallery.tpl',
		),
	),
	
	'photo' => array(
		'path'		=> '/common_fs/i/conference/gallery/photo/',
		'url'		=> '/_CDN/_i/conference/gallery/photo/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/conference/gallery/thumb/',
		'url'		=> '/_CDN/_i/conference/gallery/thumb/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
	),
	
	'tables' => array(
		'galleries'		=> 'conference_gallery',
		'albums'		=> 'conference_gallery_albums',
		'photos'		=> 'conference_gallery_photos',
	),

	
);

?>
