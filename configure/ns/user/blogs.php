<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_diaries',
	'title' 		=> 'Дневники',
	'rights'		=> 'blogs_passport',
	'space'		=> 'blogs_passport',
	
	'db'				=> 'blogs',
	'gallery_db'	=> 'passport',
	
	'tables' => array(						
				
			'diaries'		=> 'users_diaries',
			'records'		=> 'users_diaries_records',
			'subscribe' 	=> 'users_diaries_subscribe',
			
			'galleries'	=> 'users_gallery',
			'albums'	=> 'users_gallery_albums',
			'photos'	=> 'users_gallery_photos',
			
			'comments' 	=> 'users_comments',
			'votes'			=> 'users_CommentVotes',
			'ref'				=> 'users_comments_ref',
	),
	
	'img_conf'	=> array(
		
		'photo' => array(
			'path'		=> '/common_fs/i/passport/gallery/photo/',
			'url'			=> 'http://other.img.rugion.ru/_i/passport/gallery/photo/',
			'file_size' 	=> 2048000, //2000*1024,
			'img_size'	=> array(
								'max_height' => 480, 
								'max_width' => 640, 
								'min_width' => 0, 
								'min_height' => 0, 
								'types' => array(1,2,3)
								),
			'tr'			=> 0, //сохранить пропорции
		),
		
	'thumb' => array(
			'path'		=> '/common_fs/i/passport/gallery/thumb/',
			'url'			=> 'http://other.img.rugion.ru/_i/passport/gallery/thumb/',
			'file_size' 	=> 2048000, //2000*1024,
			'img_size'	=> array(
								'max_height' => 100, 
								'max_width' => 100, 
								'min_width' => 0, 
								'min_height' => 0, 
								'types' => array(1,2,3)
								),
			'tr'			=> 3,// обрезать
		),	
	),
	
	'subsection'	=> array(
		'sectionid' => 10260
		),
	
);

?>