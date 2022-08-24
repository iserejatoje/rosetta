<?
return array(
	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
	),
	
	'db' => 'gallery',
	
	'tables' => array(
		'galleries'	=> 'gallery_gallery',
		'albums'	=> 'gallery_gallery_albums',
		'photos'	=> 'gallery_gallery_photos',
	),
	
	'gallery_thumb' => array(
		'path'		=> '/common_fs/i/gallery/thumb/',
		'url'		=> 'http://other.img.rugion.ru/_i/gallery/thumb/',
		'file_size' => 700 * 1024,
		'img_size'	=> array('max_height' => 90, 'max_width' => 90, 'min_width' => 0, 'min_height' => 0, 'types' => array(1,2,3)),
	),
);
?>