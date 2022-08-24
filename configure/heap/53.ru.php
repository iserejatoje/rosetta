<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'53.ru/forum_magic_pm' => array(
				'section_id' => 206,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'53.ru/love' => array(
	            'site_id' => 144,
                'site_title' => '53.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_53',
	    		'photo_dir'	=> '/common_fs/i/sites/53.ru/love/photo/',
				'photo_url'	=> 'http://53.ru/i/love/photo/',
	    		),
			'53.ru/job' => array('section_id' => 1045),
			'ufa1.ru/baraholka' => array('section_id' => 10382),
			'53.ru/lostfound' => array('section_id' => 11115),
			'ufa1.ru/hitech' => array('section_id' => 10383),
			/*array(
				'site_id' => 144, // 53.ru
	    		'site_title' => '53.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 53,
				),*/
			'53.ru/grab_job' => array(
				'site_id' => 144, // 53.ru
		    		'site_title' => '53.ru',
		    		'regid' => 53,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_53',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'53.ru/grab_job_resume' => array(
				'site_id' => 144, // 53.ru
		    		'site_title' => '53.ru',
		    		'regid' => 53,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_53',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'53.ru/grab_job_vacancy' => array(
				'site_id' => 144, // 53.ru
		    		'site_title' => '53.ru',
		    		'regid' => 53,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_53',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'53.ru/sale' => array('section_id' => 1250),
//			'53.ru/rent' => array('section_id' => 1251),
//			'53.ru/commerce' => array('section_id' => 1253),
//			'53.ru/change' => array('section_id' => 1252),
			'53.ru/realty' => array(
				'section_id' => 10789,
			),

			'53.ru/grab_realty' => array(
		    		'site_title' => '53.ru',
				'section_id' => 10789,
	    			'group' => 'grab_realty',
				),
			/*'53.ru/firms' => array(
				'site_id' => 144, // 53.ru
	    		'site_title' => '53.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 53,
				),*/
			'53.ru/firms' => array('section_id' => 3942),
			'53.ru/hadv' => array('section_id' => 313), // 53.ru - Частные объявления 	    	
/*	    	'53.ru/advertises' => array(
	    		'site_id' => 144, // 53.ru
	    		'site_title' => '53.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_53',
	    		), */
	    	'53.ru/car' => array('section_id' => 10996),
	    	'53.ru/grab_advertises' => array(
	    		'site_id' => 144, // 53.ru
	    		'site_title' => '53.ru',
	    		'regid' => 53,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_53',
	    		),
	    	'53.ru/catalog' => array('section_id' => 314), // 53.ru - Каталог сайтов
		//'53.ru/accident' => array('section_id' => 4479), // автокатастрофы 
		'53.ru/accident' => array(
			'site_id' => 144, // 53.ru
	    		'site_title' => '53.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4479
		), // автокатастрофы v2 ]
			'53_conference_comments' => array(
				'site_title' => 'Регион 53',
				'section_title' => 'Комментарии конференции 53.ru',
		    		'RegionID' => 53,
				'group' => 'conference',
			),
		'53.ru/gallery' => array('section_id' => 4484),
		
		'53_firms_comments' => array(
				'site_title' => 'Комментарии фирм 53.ru',
				'section_title' => 'Комментарии фирм 53.ru',
				'TreeID' => 3942,
				'group' => 'all_firms_comments',
			),
			
			'53_blogs' => array(
				'site_title' => 'Регион 53',
				'section_title' => 'Дневники 53.ru',
	    		'RegionID' => 53,
				'group' => 'blogs',
			),
			'53_group_article_comments' => array(
				'site_title' => 'Регион 53',
				'section_title' => 'Комментарии группы статей 53.ru',
		    		'RegionID' => 53,
				'group' => 'group_article',
			),
			'53_grab_news' => array(
				'site_title' => 'Регион 53',
				'section_title' => '53: Новости (грабленные)',
		    	'RegionID' => array(53),
				'group' => 'grab_news_magic',
			),
	    		'53.ru/grab_board' => array(
		    		'site_title' => '53.ru',
		    		'regid' => 53,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'53.ru/grab_hitech' => array(
		    		'site_title' => '53.ru',
		    		'regid' => 53,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
    );

?>
