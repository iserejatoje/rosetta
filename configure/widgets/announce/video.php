<?
return array(
	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
		
		// шаблоны виджета по дизайнам
		'title'	=> array(
			'users' 	=> 'announce/video/title/users.tpl', // любительское видео
			'users_right' => 'announce/video/title/users_right.tpl', // любительское видео
		),
		'chelyabinsk'	=> array(
			'users' 	=> 'announce/video/chelyabinsk/users.tpl'
		),
		'auto'	=> array(
			'users' 	=> 'announce/video/auto/users.tpl'
		),
		'mychel'	=> array(
			'users' 	=> 'announce/video/mychel/users.tpl'
		),
		'doctor'	=> array(
			'users' 	=> 'announce/video/doctor/users.tpl'
		),
		'2074'	=> array(
			'users' 	=> 'announce/video/2074.ru/users.tpl'
		),
	),
	
	'limit' => 10,
	
	'scripts' => array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		'/_scripts/themes/frameworks/jquery/jcmcarousel/jquery.jcmcarousel.js'
	),
	'styles' => array(
		'201002_title_main' => array(
			'/_styles/design/201002_title_main/widgets/video/styles.css'
		),
		'default' => array(
			'/_styles/jquery/jcmcarousel/styles.css'
		)
	),
	
	'news_images_dir' => '/common_fs/i/news/1/',
	'news_images_url' => '/_CDN/_i/news/1/',
	
	'conference_images_dir' => '/common_fs/i/conference/1/',
	'conference_images_url' => '/_CDN/_i/conference/1/',
	
	'limit_tags' => 25,

	'competition_urls' => array(
	    16	=> 'http://116.ru/competition/11.php',
	    2	=> 'http://ufa1.ru//competition/6.php',
	    34	=> 'http://v1.ru//competition/9.php',
	    59	=> 'http://59.ru//competition/5.php',
	    61	=> 'http://161.ru//competition/7.php',
	    63	=> 'http://63.ru//competition/8.php',
	    72	=> 'http://63.ru//competition/10.php',
	    74	=> 'http://74.ru/competition/12.php',
	),
);
?>