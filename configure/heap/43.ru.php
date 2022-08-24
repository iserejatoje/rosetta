<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'43.ru/forum_magic_pm' => array(
				'section_id' => 202,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'43.ru/love' => array(
	            'site_id' => 140,
                'site_title' => '43.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_43',
	    		'photo_dir'	=> '/common_fs/i/sites/43.ru/love/photo/',
				'photo_url'	=> 'http://43.ru/i/love/photo/',
	    		),
			'43.ru/baraholka' => array('section_id' => 10390),
			'43.ru/lostfound' => array('section_id' => 11111),
			'43.ru/hitech' => array('section_id' => 10391),
			'43.ru/job' => array('section_id' => 1041),
			/*array(
				'site_id' => 140, // 43.ru
	    		'site_title' => '43.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 43,
				),*/
			'43.ru/grab_job' => array(
				'site_id' => 140, // 43.ru
		    		'site_title' => '43.ru',
		    		'regid' => 43,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_43',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'43.ru/grab_job_resume' => array(
				'site_id' => 140, // 43.ru
		    		'site_title' => '43.ru',
		    		'regid' => 43,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_43',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'43.ru/grab_job_vacancy' => array(
				'site_id' => 140, // 43.ru
		    		'site_title' => '43.ru',
		    		'regid' => 43,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_43',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'43.ru/sale' => array('section_id' => 1230),
//			'43.ru/rent' => array('section_id' => 1231),
//			'43.ru/commerce' => array('section_id' => 1233),
//			'43.ru/change' => array('section_id' => 1232),
			'43.ru/realty' => array(
				'section_id' => 10745,
			),

			'43.ru/grab_realty' => array(
		    		'site_title' => '43.ru',
				'section_id' => 10745,
	    			'group' => 'grab_realty',
				),
			/*'43.ru/firms' => array(
				'site_id' => 140, // 43.ru
	    		'site_title' => '43.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 43,
				),*/
			'43.ru/firms' => array('section_id' => 3937),
			'43.ru/hadv' => array('section_id' => 325), // 43.ru - Частные объявления 	    	
/*	    	'43.ru/advertises' => array(
	    		'site_id' => 140, // 43.ru
	    		'site_title' => '43.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_43',
	    		),*/
	    	'43.ru/car' => array('section_id' => 10982),
	    	'43.ru/grab_advertises' => array(
	    		'site_id' => 140, // 43.ru
	    		'site_title' => '43.ru',
	    		'regid' => 43,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_43',
	    		),
	    	'43.ru/catalog' => array('section_id' => 326), // 43.ru - Каталог сайтов
		//'43.ru/accident' => array('section_id' => 4323), // автокатастрофы 
		'43.ru/accident' => array(
			'site_id' => 140, // 43.ru
	    		'site_title' => '43.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4323
		), // автокатастрофы v2
			'43_conference_comments' => array(
				'site_title' => 'Регион 43',
				'section_title' => 'Комментарии конференции 43.ru',
		    		'RegionID' => 43,
				'group' => 'conference',
			),
		'43.ru/gallery' => array('section_id' => 4325),
		
		'43_firms_comments' => array(
				'site_title' => 'Комментарии фирм 43.ru',
				'section_title' => 'Комментарии фирм 43.ru',
				'TreeID' => 3937,
				'group' => 'all_firms_comments',
			),
			
			'43_blogs' => array(
				'site_title' => 'Регион 43',
				'section_title' => 'Дневники 43.ru',
	    		'RegionID' => 43,
				'group' => 'blogs',
			),
			'43_group_article_comments' => array(
				'site_title' => 'Регион 43',
				'section_title' => 'Комментарии группы статей 43.ru',
		    		'RegionID' => 43,
				'group' => 'group_article',
			),
			'43_grab_news' => array(
				'site_title' => 'Регион 43',
				'section_title' => '43: Новости (грабленные)',
		    	'RegionID' => array(43),
				'group' => 'grab_news_magic',
			),
	    		'43.ru/grab_board' => array(
		    		'site_title' => '43.ru',
		    		'regid' => 43,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'43.ru/grab_hitech' => array(
		    		'site_title' => '43.ru',
		    		'regid' => 43,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	    );

?>
