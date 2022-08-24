<?

/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'module_gallery_by_section' 	=> array('string' => 'module_gallery_by_section.php'),
			'default' => array('regexp' => '@^$@'),
		),
	),

	'module'			=> 'app_gallery2',
	'db'				=> 'gallery',

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
			'module_gallery_by_section'	=> '_modules/mod_news_magic/ss/gallery.tpl',
		),
	),
	
	'photo' => array(
		'path'		=> '/common_fs/i/vipcatalog/gallery/photo/',
		'url'		=> '/_CDN/_i/vipcatalog/gallery/photo/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/vipcatalog/gallery/thumb/',
		'url'		=> '/_CDN/_i/vipcatalog/gallery/thumb/',
		'file_size' => 2000 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
	),
	
	'tables' => array(
		'galleries'	=> 'vipcatalog_gallery',
		'albums'	=> 'vipcatalog_gallery_albums',
		'photos'	=> 'vipcatalog_gallery_photos',
	),

	
);

?>
