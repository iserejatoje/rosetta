<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'42.ru/forum_magic_pm' => array(
				'section_id' => 201,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'42.ru/love' => array(
	            'site_id' => 139,
                'site_title' => '42.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_42',
	    		'photo_dir'	=> '/common_fs/i/sites/42.ru/love/photo/',
				'photo_url'	=> 'http://42.ru/i/love/photo/',
	    		),
			'42.ru/job' => array('section_id' => 1038),
			/*array(
				'site_id' => 139, // 42.ru
	    		'site_title' => '42.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 42,
				),*/
			'42.ru/baraholka' => array('section_id' => 10392),
			'42.ru/lostfound' => array('section_id' => 11110),
			'42.ru/hitech' => array('section_id' => 10393),
			'42.ru/grab_job' => array(
				'site_id' => 139, // 42.ru
	 	   		'site_title' => '42.ru',
	    			'regid' => 42,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_42',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'42.ru/grab_job_resume' => array(
				'site_id' => 139, // 42.ru
	 	   		'site_title' => '42.ru',
	    			'regid' => 42,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_42',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'42.ru/grab_job_vacancy' => array(
				'site_id' => 139, // 42.ru
	 	   		'site_title' => '42.ru',
	    			'regid' => 42,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_42',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'42.ru/sale' => array('section_id' => 1225),
//			'42.ru/rent' => array('section_id' => 1226),
//			'42.ru/commerce' => array('section_id' => 1228),
//			'42.ru/change' => array('section_id' => 1227),
			'42.ru/realty' => array(
				'section_id' => 10788,
			),

			'42.ru/grab_realty' => array(
		    		'site_title' => '42.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10788,
				),
			/*'42.ru/firms' => array(
				'site_id' => 139, // 42.ru
	    		'site_title' => '42.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 42,
				),*/
			'42.ru/firms' => array('section_id' => 3934),
			'42.ru/hadv' => array('section_id' => 328), // 42.ru - Частные объявления 	    	
/*	    	'42.ru/advertises' => array(
	    		'site_id' => 139, // 42.ru
	    		'site_title' => '42.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_42',
	    		), */
	    	'42.ru/car' => array('section_id' => 10986),
	    	'42.ru/grab_advertises' => array(
	    		'site_id' => 139, // 42.ru
	    		'site_title' => '42.ru',
	    		'regid' => 42,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_42',
	    		),
	    	'42.ru/catalog' => array('section_id' => 329), // 42.ru - Каталог сайтов
		//'42.ru/accident' => array('section_id' => 4303), // автокатастрофы 
			'42_conference_comments' => array(
				'site_title' => 'Регион 42',
				'section_title' => 'Комментарии конференции 42.ru',
		    		'RegionID' => 42,
				'group' => 'conference',
			),
		'42.ru/accident' => array(
			'site_id' => 139, // 42.ru
	    		'site_title' => '42.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4303
		), // автокатастрофы v2
			'42.ru/gallery' => array('section_id' => 4305),
			
			'42_firms_comments' => array(
				'site_title' => 'Комментарии фирм 42.ru',
				'section_title' => 'Комментарии фирм 42.ru',
				'TreeID' => 3934,
				'group' => 'all_firms_comments',
			),
			
			'42_blogs' => array(
				'site_title' => 'Регион 42',
				'section_title' => 'Дневники 42.ru',
	    		'RegionID' => 42,
				'group' => 'blogs',
			),
			'42_group_article_comments' => array(
				'site_title' => 'Регион 42',
				'section_title' => 'Комментарии группы статей 42.ru',
		    		'RegionID' => 42,
				'group' => 'group_article',
			),
			'42_grab_news' => array(
				'site_title' => 'Регион 42',
				'section_title' => '42: Новости (грабленные)',
		    	'RegionID' => array(42),
				'group' => 'grab_news_magic',
			),
	    		'42.ru/grab_board' => array(
		    		'site_title' => '42.ru',
		    		'regid' => 42,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'42.ru/grab_hitech' => array(
		    		'site_title' => '42.ru',
		    		'regid' => 42,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		),
	    );

?>
