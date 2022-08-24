<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'71.ru/forum_magic_pm' => array(
				'section_id' => 212,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'71.ru/love' => array(
	            'site_id' => 150,
                'site_title' => '71.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_71',
	    		'photo_dir'	=> '/common_fs/i/sites/71.ru/love/photo/',
				'photo_url'	=> 'http://71.ru/i/love/photo/',
	    		),
			'71.ru/job' => array('section_id' => 1067),
			'71.ru/baraholka' => array('section_id' => 10370),
			'71.ru/lostfound' => array('section_id' => 11131),
			'71.ru/hitech' => array('section_id' => 10371),
			/*array(
				'site_id' => 150, // 71.ru
	    		'site_title' => '71.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 71,
				),*/
			'71.ru/grab_job' => array(
				'site_id' => 150, // 71.ru
		    		'site_title' => '71.ru',
		    		'regid' => 71,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_71',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'71.ru/grab_job_resume' => array(
				'site_id' => 150, // 71.ru
		    		'site_title' => '71.ru',
		    		'regid' => 71,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_71',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'71.ru/grab_job_vacancy' => array(
				'site_id' => 150, // 71.ru
		    		'site_title' => '71.ru',
		    		'regid' => 71,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_71',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
/*			'71.ru/sale' => array('section_id' => 1280),
			'71.ru/rent' => array('section_id' => 1281),
			'71.ru/commerce' => array('section_id' => 1283),
			'71.ru/change' => array('section_id' => 1282),*/
			'71.ru/realty' => array(
				'section_id' => 10740,
			),


			'71.ru/grab_realty' => array(
				'section_id' => 10740,
		    		'site_title' => '71.ru',
		    		'group' => 'grab_realty',
				),
			/*'71.ru/firms' => array(
				'site_id' => 150, // 71.ru
	    		'site_title' => '71.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 71,
				),*/
			'71.ru/firms' => array('section_id' => 3948),
			'71.ru/hadv' => array('section_id' => 295), // 71.ru - Частные объявления 	    	
/*	    	'71.ru/advertises' => array(
	    		'site_id' => 150, // 71.ru
	    		'site_title' => '71.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_71',
	    		), */
	    	'71.ru/car' => array('section_id' => 10983),
	    	'71.ru/grab_advertises' => array(
	    		'site_id' => 150, // 71.ru
	    		'site_title' => '71.ru',
	    		'regid' => 71,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_71',
	    		),
	    	'71.ru/catalog' => array('section_id' => 296), // 71.ru - Каталог сайтов
		//'71.ru/accident' => array('section_id' => 4507), // автокатастрофы 
		'71.ru/accident' => array(
			'site_id' => 150, // 71.ru
	    		'site_title' => '71.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4507
		), // автокатастрофы v2
			'71_conference_comments' => array(
				'site_title' => 'Регион 71',
				'section_title' => 'Комментарии конференции 71.ru',
		    		'RegionID' => 71,
				'group' => 'conference',
			),
		'71.ru/gallery' => array('section_id' => 4512),
		
		'71_firms_comments' => array(
				'site_title' => 'Комментарии фирм 71.ru',
				'section_title' => 'Комментарии фирм 71.ru',
				'TreeID' => 3948,
				'group' => 'all_firms_comments',
			),		
			
			'71_blogs' => array(
				'site_title' => 'Регион 71',
				'section_title' => 'Дневники 71.ru',
	    		'RegionID' => 71,
				'group' => 'blogs',
			),
			'71_group_article_comments' => array(
				'site_title' => 'Регион 71',
				'section_title' => 'Комментарии группы статей 71.ru',
		    		'RegionID' => 71,
				'group' => 'group_article',
			),
			'71_grab_news' => array(
				'site_title' => 'Регион 71',
				'section_title' => '71: Новости (грабленные)',
		    	'RegionID' => array(71),
				'group' => 'grab_news_magic',
			),
	    		'71.ru/grab_board' => array(
		    		'site_title' => '71.ru',
		    		'regid' => 71,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'71.ru/grab_hitech' => array(
		    		'site_title' => '71.ru',
		    		'regid' => 71,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>