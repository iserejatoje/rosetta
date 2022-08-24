<?

	return array(
	    'sections' => array (
		
			// Форум предмодерация сообщений [B]
			
			'178.ru/forum_magic_pm' => array(
				'section_id' => 789,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'neva1.ru/love' => array(
	            'site_id' => 489,
                'site_title' => 'neva1.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_78',
	    		'photo_dir'	=> '/common_fs/i/sites/neva1.ru/love/photo/',
				'photo_url'	=> 'http://neva1.ru/i/love/photo/',
	    		),
//			'178metrov.ru/sale' => array('section_id' => 1031),
//			'178metrov.ru/rent' => array('section_id' => 1032),
//			'178metrov.ru/commerce' => array('section_id' => 1033),
//			'178metrov.ru/change' => array('section_id' => 1034),
			'178.ru/realty' => array(
				'section_id' => 10803,
			),
			'178filmov.ru/change' => array('section_id' => 1052),
			'178.ru/lostfound' => array('section_id' => 11135),
			'neva1.ru/job' => array('section_id' => 3257),
			/*array(
				'site_id' => 489, // neva1.ru
	    		'site_title' => 'neva1.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 78,
				),*/
			'neva1.ru/grab_job' => array(
				'site_id' => 489, // neva1.ru
	    			'site_title' => 'neva1.ru',
	    			'regid' => 78,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_78',
				'tables' => array(
		   			'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'neva1.ru/grab_job_resume' => array(
				'site_id' => 489, // neva1.ru
	    			'site_title' => 'neva1.ru',
	    			'regid' => 78,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_78',
				'show' => 'resume',
				'tables' => array(
		   			'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'neva1.ru/grab_job_vacancy' => array(
				'site_id' => 489, // neva1.ru
	    			'site_title' => 'neva1.ru',
	    			'regid' => 78,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_78',
				'show' => 'vacancy',
				'tables' => array(
		   			'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'178.ru/grab_realty' => array(
		    		'site_title' => '178.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10803,
				),
			'178metrov.ru/grab_change' => array(
				'site_id' => 787, // 178metrov.ru
	    		'site_title' => '178metrov.ru',
	    		'regid' => 78,
	    		'group' => 'grab_rugion_adv_change',
	    		'db' => '178metrov',
				),
			'178.ru/firms' => array('section_id' => 3972),
			'178auto.ru/firms' => array('section_id' => 833),
			'neva1.ru/firms' => array(
				'site_id' => 489, // neva1.ru
	    		'site_title' => 'neva1.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 78,
				),
			'neva1.ru/hadv' => array('section_id' => 500), // neva1.ru - Частные объявления 	    	
//			'178auto.ru/advertises' => array('section_id' => 1071),
		    	'178.ru/car' => array('section_id' => 10997),
	    	'178auto.ru/grab_advertises' => array(
	    		'site_id' => 489, // neva1.ru
	    		'site_title' => '178auto.ru',
	    		'regid' => 78,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '178auto',
	    		),
	    	'neva1.ru/catalog' => array('section_id' => 501), // neva1.ru - Каталог сайтов
			'neva1.ru/forum-pm' => array(
				'section_id' => 498
			),
			'178auto.ru/forum-pm' => array(
				'section_id' => 831
			),
			'178bankov.ru/forum-pm' => array(
				'section_id' => 825
			),
			'178filmov.ru/forum-pm' => array(
				'section_id' => 810
			),
			'178metrov.ru/forum-pm' => array(
				'section_id' => 789
			),
		'178.ru/accident' => array(
			'site_id' => 489, // 178.ru
	    		'site_title' => '178.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4058
		), // автокатастрофы v2
			'78_conference_comments' => array(
				'site_title' => 'Регион 78',
				'section_title' => 'Комментарии конференции 178.ru',
		    		'RegionID' => 78,
				'group' => 'conference',
			),
			'78_afisha_comments' => array(
				'site_title' => 'Регион 78',
				'section_title' => 'Комментарии афиши 178.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4571, //(array)
				'group' => 'afisha_magic',
			),
			
			'178_blogs' => array(
				'site_title' => 'Регион 178',
				'section_title' => 'Дневники 178.ru',
	    		'RegionID' => 178,
				'group' => 'blogs',
			),
			'178.ru/baraholka' => array('section_id' => 10420),
			'178.ru/hitech' => array('section_id' => 10421),
			'178_group_article_comments' => array(
				'site_title' => 'Регион 78',
				'section_title' => 'Комментарии группы статей 178.ru',
		    		'RegionID' => 78,
				'group' => 'group_article',
			),
			'78_grab_news' => array(
				'site_title' => 'Регион 78',
				'section_title' => '78: Новости (грабленные)',
		    	'RegionID' => array(78),
				'group' => 'grab_news_magic',
			),
	    		'178.ru/grab_board' => array(
		    		'site_title' => '178.ru',
		    		'regid' => 78,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'178.ru/grab_hitech' => array(
		    		'site_title' => '178.ru',
		    		'regid' => 78,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),

		)
	);
?>