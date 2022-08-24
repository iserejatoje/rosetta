<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'62.ru/forum_magic_pm' => array(
				'section_id' => 209,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'62.ru/love' => array(
	            'site_id' => 147,
                'site_title' => '62.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_62',
	    		'photo_dir'	=> '/common_fs/i/sites/62.ru/love/photo/',
				'photo_url'	=> 'http://62.ru/i/love/photo/',
	    		),
			'62.ru/job' => array('section_id' => 1059),
			'62.ru/baraholka' => array('section_id' => 10376),
			'62.ru/lostfound' => array('section_id' => 11125),
			'62.ru/hitech' => array('section_id' => 10377),
			/*array(
				'site_id' => 147, // 62.ru
	    		'site_title' => '62.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 62,
				),*/
			'62.ru/grab_job' => array(
				'site_id' => 147, // 62.ru
		    		'site_title' => '62.ru',
		    		'regid' => 62,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_62',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'62.ru/grab_job_resume' => array(
				'site_id' => 147, // 62.ru
		    		'site_title' => '62.ru',
		    		'regid' => 62,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_62',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'62.ru/grab_job_vacancy' => array(
				'site_id' => 147, // 62.ru
		    		'site_title' => '62.ru',
		    		'regid' => 62,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_62',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'62.ru/sale' => array('section_id' => 1265),
			'62.ru/rent' => array('section_id' => 1266),
			'62.ru/commerce' => array('section_id' => 1268),
			'62.ru/change' => array('section_id' => 1267),*/

			'62.ru/realty' => array(
				'section_id' => 10743,
			),

			'62.ru/grab_realty' => array(
		    		'site_title' => '62.ru',
				'section_id' => 10743,
		    		'group' => 'grab_realty',
				),
			/*'62.ru/firms' => array(
				'site_id' => 147, // 62.ru
	    		'site_title' => '62.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 62,
				),*/
			'62.ru/firms' => array('section_id' => 3945),
			'62.ru/hadv' => array('section_id' => 304), // 62.ru - Частные объявления 	    	
/*	    	'62.ru/advertises' => array(
	    		'site_id' => 147, // 62.ru
	    		'site_title' => '62.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_62',
	    		), */
	    	'62.ru/car' => array('section_id' => 11012),
	    	'62.ru/grab_advertises' => array(
	    		'site_id' => 147, // 62.ru
	    		'site_title' => '62.ru',
	    		'regid' => 62,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_62',
	    		),
	    	'62.ru/catalog' => array('section_id' => 305), // 62.ru - Каталог сайтов
		//'62.ru/accident' => array('section_id' => 4408), // автокатастрофы 
		'62.ru/accident' => array(
			'site_id' => 147, // 62.ru
	    		'site_title' => '62.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4408
		), // автокатастрофы v2
			'62_conference_comments' => array(
				'site_title' => 'Регион 62',
				'section_title' => 'Комментарии конференции 62.ru',
		    		'RegionID' => 62,
				'group' => 'conference',
			),
		'62.ru/gallery' => array('section_id' => 4413),
		
		'62_firms_comments' => array(
				'site_title' => 'Комментарии фирм 62.ru',
				'section_title' => 'Комментарии фирм 62.ru',
				'TreeID' => 3945,
				'group' => 'all_firms_comments',
			),
			
			'62_blogs' => array(
				'site_title' => 'Регион 62',
				'section_title' => 'Дневники 62.ru',
	    		'RegionID' => 62,
				'group' => 'blogs',
			),
			'62_group_article_comments' => array(
				'site_title' => 'Регион 62',
				'section_title' => 'Комментарии группы статей 62.ru',
		    		'RegionID' => 62,
				'group' => 'group_article',
			),
			'62_grab_news' => array(
				'site_title' => 'Регион 62',
				'section_title' => '62: Новости (грабленные)',
		    	'RegionID' => array(62),
				'group' => 'grab_news_magic',
			),
	    		'62.ru/grab_board' => array(
		    		'site_title' => '62.ru',
		    		'regid' => 62,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'62.ru/grab_hitech' => array(
		    		'site_title' => '62.ru',
		    		'regid' => 62,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>