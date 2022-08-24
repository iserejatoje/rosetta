<?
return array(
	'config_groups' => array (
	    	'rugion_auto' => array(
	    	    'tables' => array(
	    	    	'advertise' => 'advertise',
	    	    	'color' => 'advertise_colour',
	    	    	'marka' => 'advertise_marka',
	    	    	'model' => 'advertise_model',
	    	    	),
	    	    ),
	    	'grab_rugion_auto' => array(
	    		'section_title' => 'Автообъявления (Грабленная)',
	    		'type' => 'grab_auto_advertise',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_adv' => 'grab_auto_adv',
	    			'advertise' => 'advertise',
    	    	'color' => 'advertise_colour',
    	    	'marka' => 'advertise_marka',
    	    	'model' => 'advertise_model',
	    			),
	    		),
		'grab_rugion_car' => array(
	    		'section_title' => 'Автообъявления НОВЫЕ (Грабленные)',
	    		'type' => 'grab_car',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_adv' => 'grab_car_adv',	    			    	    	
	    			),
    		),
		'grab_rugion_board' => array(
	    		'section_title' => 'Частные объявления (Грабленные)',
	    		'type' => 'grab_board',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_adv' => 'grab_board',
	    			),
    		),
	    	'grab_rugion_auto_new' => array(
	    		'section_title' => 'Автообъявления (Грабленная)',
	    		'type' => 'grab_auto_advertise_new',
	    		'in_db' => 'public',
	    		'arrays_db' => 'adv_auto',
	    		'tables' => array(
	    			'in_adv' => 'grab_auto_adv_new',
	    			'advertise' => 'advertise_data',
	    	    	'color' => 'auto_color',
	    	    	'marka' => 'automarka',
	    	    	'model' => 'advertise_tree',
	    			),
	    		),
	    	'rugion_firms' => array(
	    	    'tables' => array(
	    	    	'data' => 'enterprises',
	    	    	'subsecref' => 'subsecref',
	    	    	'city' => 'city',
	    	    	),
	    	    ),
	    	'rugion_adv_sale' => array(
	    		'tables' => array(
	    			'sale' => 'adv_sale',
	    			'change' => 'adv_change',
	    			'commerce' => 'adv_commerce',
	    			'rent' => 'adv_rent',
	    			),
	    		),
	    	/*'grab_rugion_adv_sale' => array(
	    		'section_title' => 'Недвижимость (Грабленная)',
	    		'type' => 'grab_adv_sale',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_sale' => 'grab_realty_sale',
	    			'sale' => 'adv_sale',
	    			),
	    		),*/
		'grab_realty' => array(
	    		'section_title' => 'Недвижимость (Грабленная)',
	    		'type' => 'grab_realty',
	    		'source_db' => 'public',
	    		'tables' => array(
		    			'source' => 'grab_realty',
	    			),
			),
	    	/*'grab_rugion_adv_rent' => array(
	    		'section_title' => 'Недвижимость Аренда (Грабленная)',
	    		'type' => 'grab_adv_rent',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_rent' => 'grab_realty_rent',
	    			'rent' => 'adv_rent',
	    			),
	    		),
	    	'grab_rugion_adv_commerce' => array(
	    		'section_title' => 'Недвижимость Коммерческая (Грабленная)',
	    		'type' => 'grab_adv_commerce',
	    		'in_db' => 'public',
	    		'tables' => array(
	    			'in_commerce' => 'grab_realty_commerce',
	    			'commerce' => 'adv_commerce',
	    			),
	    		), */
	    	'rugion_job' => array(
	    		'tables' => array(
	    			'razdel' => 'j_razdel',
	    			'vacancy' => 'j_vacancy',
	    			'resume' => 'j_resume',
	    			),
	    		),
	    	'grab_rugion_job' => array(
	    		'section_title' => 'Работа (Грабленная)',
	    		'type' => 'grab_job',
	    		'in_db' => 'public',
	    		'db' => 'rugion',
	    		'out_db' => 'rugion',
	    		'tables' => array(
	    			'in_vacancy' => 'grab_job_vacancy',
	    			'in_resume' => 'grab_job_resume',
	    			'razdel' => 'j_razdel',
	    			'j_vacancy' => 'j_vacancy',
	    			'j_resume' => 'j_resume',
	    			'jvcount' => 'jvcount',
	    			),
	    		),
			'grab_rugion_job_new' => array(
	    		'section_title' => 'Работа (Грабленная)',
	    		'type' => 'grab_job_new',
	    		'in_db' => 'public',
	    		'db' => 'rugion',
	    		'out_db' => 'rugion',
	    		'tables' => array(
	    			'in_vacancy' => 'grab_job_vacancy',
	    			'in_resume' => 'grab_job_resume_new',
	    			'razdel' => 'j_razdel',
	    			'j_vacancy' => 'job_v2_vacancy',
	    			'j_resume' => 'job_resume',
	    			'jvcount' => 'jvcount',
	    			),
	    		),
      'grab_rugion_job_v2' => array(
	    		'section_title' => 'Работа (Грабленная) v2',
	    		'type' => 'grab_job_v2',
	    		'in_db' => 'public',
	    		'db' => 'rugion',
	    		'out_db' => 'rugion',
	    		'tables' => array(
	    			'in_vacancy' => 'grab_job_vacancy',
	    			'in_resume' => 'grab_job_resume_new',
	    			'razdel' => 'j_razdel',
	    			'j_vacancy' => 'job_v2_vacancy',
	    			'j_resume' => 'job_resume',
	    			'jvcount' => 'jvcount',
	    			),
	    		),
			'rugion_love' => array(
			    'tables' => array(
			        'photos' => 'love_photo',
			        'users' => 'love_user',
			        'story' => 'love_story_comment',
				),
			),
			'rugion_tender' => array(
				'tables'=> array(
					'request'=>'tender_request',
					'tree'=>'tender_tree',
				),
			),
			'rugion_tender_59' => array(
				'tables'=> array(
					'request'=>'tender_request',
					'tree'=>'tender_tree',
				),
			),
			'place_simple' => array(
				'section_title' => 'Места (PlaceSimple)',
		    		'type' => 'place_simple',
			),
			/*'interest' => array(
				'section_title' => 'Интересы',
		    		'type' => 'interest',
			),*/
			'interest_v2' => array(
				'section_title' => 'Интересы',
		    		'type' => 'interest_v2',
			),
			'svoi' => array(
				'section_title' => 'Сообщества',
		    		'type' => 'svoi',
			),
			
			
			'news_magic' => array(
				'type' => 'news_magic',
				'db' => 'news',
				'tables'	=> array(
					'article'	=> 'news',
					'ref'		=> 'news_ref',
					
					'comments' 		=> 'news_comments',
					'comments_votes'=> 'news_comments_votes',
					'comments_ref'	=> 'news_comments_ref',
				),
			),
			
			'grab_news_magic' => array(
				'type' => 'grab_news_magic',
				'db' => 'news',
				'tables'	=> array(
					'article'	=> 'news',
					'ref'		=> 'news_ref',
					
					'article_source' 	=> 'news_source',
					'article_source_ref'=> 'news_source_ref',
				),
			),
			
			'blogs' => array(
				'type' => 'blogs',
				'db' => 'blogs',
				'tables'	=> array(),
			),
			
			'gallery' => array(
				'type' => 'gallery',
				'db'	=> 'gallery',
				'rights'	=> 'gallery',
				'tables'	=> array(
					'galleries'	=> 'gallery_gallery',
					'albums'		=> 'gallery_gallery_albums',
					'photos'		=> 'gallery_gallery_photos',
				),
				'gallery_photo'	=> array (
					'path'	=> '/common_fs/i/gallery/photo/',
					'url'	=> 'http://other.img.rugion.ru/_i/gallery/photo/',
					'file_size'	=> 716800,
					'img_size'	=> array(
						'max_height'	=> 600,
						'max_width'	=> 480,
						'min_width'	=> 0,
						'min_height'	=> 0,
						'types'	=> array(
							0	=> 1,
							1	=> 2,
							2	=> 3,
						),
					),  
				 ),
				 'gallery_thumb'	=> array (
					'path'	=> '/common_fs/i/gallery/thumb/',
					'url'	=> 'http://other.img.rugion.ru/_i/gallery/thumb/',
					'file_size'	=> 716800,
					'img_size'	=> array(
						'max_height'	=> 90,
						'max_width'	=> 90,
						'min_width'	=> 0,
						'min_height'	=> 0,
						'types'	=> array(
							0	=> 1,
							1	=> 2,
							2	=> 3,
						),
					),  
				  ),
				 'max_source_photo_size'	=> array(
					'size'	=> 2097152,
					'width'	=> 1600,
					'height'	=> 1200,
				),				
			),
			
			'74_firms_comments' => array(
				'type' => 'firms_comments',
				'db' => 'places',
				'tables'	=> array(
					'tree'	=> 'place_tree',
					'ref'	=> 'place_tree_ref',
					'data'	=> 'place_data',
					
					'comments' 		=> 'place_comments',
					'comments_votes'=> 'place_comments_votes',
					'comments_ref'	=> 'place_comments_ref',
				),
			),
			
			'all_firms_comments' => array(
				'type' => 'firms_comments',
				'db' => 'places',
				'tables'	=> array(
					'tree'	=> 'place_tree',
					'ref'	=> 'place_tree_ref',
					'data'	=> 'place_data',
					
					'comments' 		=> 'place_comments',
					'comments_votes'=> 'place_comments_votes',
					'comments_ref'	=> 'place_comments_ref',
				),
			),

			'all_contest_comments' => array(
				'type'	=> 'contest_comments',
				'db'	=> 'contest',
				'tables'=> array(
					'comments'	=> 'contest_comments',
					'comments_votes'=> 'contest_comments_votes',
					'comments_ref'	=> 'contest_comments_ref',
					'contest_ref'	=> 'contest_ref',
					'contest_ankets'=> 'contest_ankets',
					'contest_item'	=> 'contest_item'
				)
			),
			
			'group_article' => array(
				'type' => 'group_article',
				'db' => 'group_article',
				'tables'	=> array(
					'group'		=> 'group',
					'ref'		=> 'group_ref',
					
					'comments' 		=> 'group_comments',
					'comments_votes'=> 'group_comments_votes',
					'comments_ref'	=> 'group_comments_ref',
				),
			),
			
			'news_magic2' => array(
				'type' => 'news_magic2',
				'db' => 'news',
				'tables'	=> array(
					'article'	=> 'news',
					'ref'		=> 'news_ref',
					
					'comments' 		=> 'news_comments_tree',
					'comments_votes'=> 'news_comments_tree_votes',
					'comments_ref'	=> 'news_comments_tree_ref',
				),
			),
			
			'conference' => array(
				'type' => 'conference',
				'db' => 'conference',
				'tables'	=> array(
					'article'	=> 'conference',
					'ref'		=> 'conference_ref',
					
					'comments' 		=> 'conference_comments',
					'comments_votes'=> 'conference_comments_votes',
					'comments_ref'	=> 'conference_comments_ref',
				),
			),
			
			'accident_v2' => array(
				'type' => 'accident_v2',
				'db' => 'accident',
				'tables'	=> array(
					'accident' 	=> 'accident_list', 
					'photo' 	=> 'accident_photo',
					
					'comments' 		=> 'accident_comments',
					'votes'			=> 'accident_comments_votes',
					'ref'			=> 'accident_comments_ref',
				),
			),
			'location_update' => array(
				'type' => 'location_update',
				'db' => 'sources',
				'tables'	=> array(
					'update' => 'location_update',
					'objects' => 'location_objects_new',
				),
			),
			'location_landmarks' => array(
				'type' => 'location_landmarks',
				'db' => 'sources',
				'tables'	=> array(
					'update' => 'location_update',
					'landmarks' => 'location_landmarks',
				),
			),
			'afisha_magic' => array(
				'type' => 'afisha_magic',
				'db' => 'afisha',
				'tables'	=> array(
					'types' => 'types',
					'places' => 'places',
					'events' => 'events',
					'ref' => 'events_ref',
					'seances' => 'seances',
					'halls' => 'halls',
					'extra' => 'extra',
					'prices' => 'prices',
					'groups' => 'groups',
					'comments' => 'comments',
					'comments_ref' => 'comments_ref',
				),
			),
			'jobnames' => array(
				'type' => 'jobnames',
			),
			
			'weather' => array(
				'type' => 'weather_comments',
				'db' => 'weather',
				'tables'	=> array(					
					'comments' 		=> 'weather_comments',
					'current'		=> 'weather_current',					
				),
			),
			
			'grab_rugion_technics' => array(
	    		'section_title' => 'Каталоги техники (Грабленные)',
	    		'type' => 'grab_technics',
	    		'db' => 'technics',
				'item_col_pp' => 10,
				'source' => 'http://zoom.cnews.ru',
				'photo' => array(
					'images' => array(
						'path' => '/common_fs/i/technics/item/',
						'url' => 'http://other.img.rugion.ru/_i/technics/item/'
					),
					'gallery' => array(
						'path' => '/common_fs/i/technics/gallery/',
						'url' => 'http://other.img.rugion.ru/_i/technics/gallery/'
					),
					'empty_img' => array(
						'name' => 'no_photo.gif',
						'path' => ENGINE_PATH .'resources/img/design/common/',
						'url' => '/_img/design/common/'
					)
				),
				'photo_temp' => array(
					'images' => array(
						'path' => '/common_fs/i/technics/temp/item/',
						'url' => 'http://other.img.rugion.ru/_i/technics/temp/item/'
					),
					'gallery' => array(
						'path' => '/common_fs/i/technics/temp/gallery/',
						'url' => 'http://other.img.rugion.ru/_i/technics/temp/gallery/'
					),
					'empty_img' => array(
						'name' => 'no_photo.gif',
						'path' => ENGINE_PATH .'resources/img/design/common/',
						'url' => '/_img/design/common/'
					)
				),
				'tables' => array(
					'item' => 'catalog_item',
					'item_temp' => 'catalog_item_temp',
					'gallery' => 'catalog_gallery',
					'gallery_temp' => 'catalog_gallery_temp'
				),
				'photocamera' => array(
					'tables' => array(
						'array' => 'catalog_photocamera_array',
						'property' => 'catalog_photocamera_property',
						'item_property' => 'catalog_photocamera_item_property',
						'item_property_temp' => 'catalog_photocamera_item_property_temp'
					),
				),
				'videocamera' => array(
					'tables' => array(
						'array' => 'catalog_videocamera_array',
						'property' => 'catalog_videocamera_property',
						'item_property' => 'catalog_videocamera_item_property',
						'item_property_temp' => 'catalog_videocamera_item_property_temp'
					),
				),
				'tv' => array(
					'tables' => array(
						'array' => 'catalog_tv_array',
						'property' => 'catalog_tv_property',
						'item_property' => 'catalog_tv_item_property',
						'item_property_temp' => 'catalog_tv_item_property_temp'
					),
				),
				'notebooks' => array(
					'tables' => array(
						'array' => 'catalog_notebooks_array',
						'property' => 'catalog_notebooks_property',
						'item_property' => 'catalog_notebooks_item_property',
						'item_property_temp' => 'catalog_notebooks_item_property_temp'
					),
				),
				'catalog' => array(
					'tables' => array(
						'array' => 'catalog_catalog_array',
						'property' => 'catalog_catalog_property',
						'item_property' => 'catalog_catalog_item_property',
						'item_property_temp' => 'catalog_catalog_item_property_temp'
					),
				)
	    	)
		),
	);
?>
