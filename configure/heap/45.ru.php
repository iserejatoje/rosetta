<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'45.ru/forum_magic_pm' => array(
				'section_id' => 203,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'45.ru/love' => array(
	            'site_id' => 141,
                'site_title' => '45.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_45',
	    		'photo_dir'	=> '/common_fs/i/sites/45.ru/love/photo/',
				'photo_url'	=> 'http://45.ru/i/love/photo/',
	    		),
			'45.ru/job' => array('section_id' => 1042),
			'45.ru/baraholka' => array('section_id' => 10388),
			'45.ru/lostfound' => array('section_id' => 11112),
			'45.ru/hitech' => array('section_id' => 10389),
			/*array(
				'site_id' => 141, // 45.ru
	    		'site_title' => '45.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 45,
				),*/
			'45.ru/grab_job' => array(
				'site_id' => 141, // 45.ru
		    		'site_title' => '45.ru',
		    		'regid' => 45,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_45',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'45.ru/grab_job_resume' => array(
				'site_id' => 141, // 45.ru
		    		'site_title' => '45.ru',
		    		'regid' => 45,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_45',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'45.ru/grab_job_vacancy' => array(
				'site_id' => 141, // 45.ru
		    		'site_title' => '45.ru',
		    		'regid' => 45,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_45',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'45.ru/sale' => array('section_id' => 1235),
//			'45.ru/rent' => array('section_id' => 1236),
//			'45.ru/commerce' => array('section_id' => 1238),
//			'45.ru/change' => array('section_id' => 1237),
			'45.ru/realty' => array(
				'section_id' => 10792,
			),
			'45.ru/grab_realty' => array(
		    		'site_title' => '45.ru',
				'section_id' => 10792,
	    			'group' => 'grab_realty',
				),
			/*'45.ru/firms' => array(
				'site_id' => 141, // 45.ru
	    		'site_title' => '45.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 45,
				),*/
			'45.ru/firms' => array('section_id' => 3938),
			'45.ru/hadv' => array('section_id' => 322), // 45.ru - Частные объявления 	    	
/*	    	'45.ru/advertises' => array(
	    		'site_id' => 141, // 45.ru
	    		'site_title' => '45.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_45',
	    		), */
	    	'45.ru/car' => array('section_id' => 10993),
	    	'45.ru/grab_advertises' => array(
	    		'site_id' => 141, // 45.ru
	    		'site_title' => '45.ru',
	    		'regid' => 45,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_45',
	    		),
	    	'45.ru/catalog' => array('section_id' => 323), // 45.ru - Каталог сайтов
		//'45.ru/accident' => array('section_id' => 4337), // автокатастрофы 
		'45.ru/accident' => array(
			'site_id' => 141, // 45.ru
	    		'site_title' => '45.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4337
		), // автокатастрофы v2
			'45_afisha_comments' => array(
				'site_title' => 'Регион 45',
				'section_title' => 'Комментарии афиши 45.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4638, //(array)
				'group' => 'afisha_magic',
			),
			'45_conference_comments' => array(
				'site_title' => 'Регион 45',
				'section_title' => 'Комментарии конференции 45.ru',
		    		'RegionID' => 45,
				'group' => 'conference',
			),
		'45.ru/gallery' => array('section_id' => 4339),
		
		'45_firms_comments' => array(
				'site_title' => 'Комментарии фирм 45.ru',
				'section_title' => 'Комментарии фирм 45.ru',
				'TreeID' => 3938,
				'group' => 'all_firms_comments',
			),
			
			'45_blogs' => array(
				'site_title' => 'Регион 45',
				'section_title' => 'Дневники 45.ru',
	    		'RegionID' => 45,
				'group' => 'blogs',
			),
			'45_group_article_comments' => array(
				'site_title' => 'Регион 45',
				'section_title' => 'Комментарии группы статей 45.ru',
		    		'RegionID' => 45,
				'group' => 'group_article',
			),
			'45_grab_news' => array(
				'site_title' => 'Регион 45',
				'section_title' => '45: Новости (грабленные)',
		    	'RegionID' => array(45),
				'group' => 'grab_news_magic',
			),
			'45_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'45.ru/grab_board' => array(
		    		'site_title' => '45.ru',
		    		'regid' => 45,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'45.ru/grab_hitech' => array(
		    		'site_title' => '45.ru',
		    		'regid' => 45,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>
