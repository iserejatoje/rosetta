<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'70.ru/forum_magic_pm' => array(
				'section_id' => 211,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'70.ru/love' => array(
	            'site_id' => 149,
                'site_title' => '70.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_70',
	    		'photo_dir'	=> '/common_fs/i/sites/70.ru/love/photo/',
				'photo_url'	=> 'http://70.ru/i/love/photo/',
	    		),
			'70.ru/job' => array('section_id' => 1066),
			'70.ru/baraholka' => array('section_id' => 10372),
			'70.ru/lostfound' => array('section_id' => 11130),
			'70.ru/hitech' => array('section_id' => 10373),
			/*array(
				'site_id' => 149, // 70.ru
	    		'site_title' => '70.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 70,
				),*/
			'70.ru/grab_job' => array(
				'site_id' => 149, // 70.ru
		    		'site_title' => '70.ru',
		    		'regid' => 70,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_70',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'70.ru/grab_job_resume' => array(
				'site_id' => 149, // 70.ru
		    		'site_title' => '70.ru',
		    		'regid' => 70,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_70',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'70.ru/grab_job_vacancy' => array(
				'site_id' => 149, // 70.ru
		    		'site_title' => '70.ru',
		    		'regid' => 70,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_70',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'70.ru/sale' => array('section_id' => 1275),
			'70.ru/rent' => array('section_id' => 1276),
			'70.ru/commerce' => array('section_id' => 1278),
			'70.ru/change' => array('section_id' => 1277),*/
			'70.ru/realty' => array(
				'section_id' => 10769,
			),
			'70.ru/grab_realty' => array(
				'section_id' => 10769,
		    		'site_title' => '70.ru',
		    		'group' => 'grab_realty',
				),
			/*'70.ru/firms' => array(
				'site_id' => 149, // 70.ru
	    		'site_title' => '70.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 70,
				),*/
			'70.ru/firms' => array('section_id' => 3947),
			'70.ru/hadv' => array('section_id' => 298), // 70.ru - Частные объявления 	    	
/*	    	'70.ru/advertises' => array(
	    		'site_id' => 149, // 70.ru
	    		'site_title' => '70.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_70',
	    		), */
	    	'70.ru/car' => array('section_id' => 10987),
	    	'70.ru/grab_advertises' => array(
	    		'site_id' => 149, // 70.ru
	    		'site_title' => '70.ru',
	    		'regid' => 70,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_70',
	    		),
	    	'70.ru/catalog' => array('section_id' => 299), // 70.ru - Каталог сайтов
		//'70.ru/accident' => array('section_id' => 4493), // автокатастрофы 
		'70.ru/accident' => array(
			'site_id' => 149, // 70.ru
	    		'site_title' => '70.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4493
		), // автокатастрофы v2
		'70.ru/gallery' => array('section_id' => 4498),
			'70_conference_comments' => array(
				'site_title' => 'Регион 70',
				'section_title' => 'Комментарии конференции 70.ru',
		    		'RegionID' => 70,
				'group' => 'conference',
			),
			
			'70_firms_comments' => array(
				'site_title' => 'Комментарии фирм 70.ru',
				'section_title' => 'Комментарии фирм 70.ru',
				'TreeID' => 3947,
				'group' => 'all_firms_comments',
			),
			
			'70_blogs' => array(
				'site_title' => 'Регион 70',
				'section_title' => 'Дневники 70.ru',
	    		'RegionID' => 70,
				'group' => 'blogs',
			),
			'70_group_article_comments' => array(
				'site_title' => 'Регион 70',
				'section_title' => 'Комментарии группы статей 70.ru',
		    		'RegionID' => 70,
				'group' => 'group_article',
			),
			'70_grab_news' => array(
				'site_title' => 'Регион 70',
				'section_title' => '70: Новости (грабленные)',
		    	'RegionID' => array(70),
				'group' => 'grab_news_magic',
			),
	    		'70.ru/grab_board' => array(
		    		'site_title' => '70.ru',
		    		'regid' => 70,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'70.ru/grab_hitech' => array(
		    		'site_title' => '70.ru',
		    		'regid' => 70,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>