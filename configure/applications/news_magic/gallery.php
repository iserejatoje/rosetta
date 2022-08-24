<?

/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'news_gallery' 	=> array('string' => 'news_gallery.php'),
			'default' => array('regexp' => '@^$@'),
		),
	),
	'module'			=> 'app_gallery',
	'db'				=> 'news',

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
			'news_gallery'	=> '_modules/mod_news_magic/ss/gallery.tpl',
		),
	),
	
	'photo' => array(
		'path'		=> '/common_fs/i/news/gallery/photo/',
		'url'		=> 'http://other.img.rugion.ru/_i/news/gallery/photo/',
		'file_size' => 700 * 1024,
		'img_size'	=> array('max_height' => 480, 'max_width' => 640, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
		),
		
	'thumb' => array(
		'path'		=> '/common_fs/i/news/gallery/thumb/',
		'url'		=> 'http://other.img.rugion.ru/_i/news/gallery/thumb/',
		'file_size' => 100 * 1024,
		'img_size'	=> array('max_height' => 100, 'max_width' => 100, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
	),
	
	'tables' => array(
		'galleries'	=> 'news_gallery',
		'albums'	=> 'news_gallery_albums',
		'photos'	=> 'news_gallery_photos',
	),

	
);

?>