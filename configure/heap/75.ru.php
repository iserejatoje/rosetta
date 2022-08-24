<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'75.ru/forum_magic_pm' => array(
				'section_id' => 214,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'75.ru/love' => array(
	            'site_id' => 152,
                'site_title' => '75.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_75',
	    		'photo_dir'	=> '/common_fs/i/sites/75.ru/love/photo/',
				'photo_url'	=> 'http://75.ru/i/love/photo/',
	    		),
			'75.ru/baraholka' => array('section_id' => 10366),
			'75.ru/lostfound' => array('section_id' => 11133),
			'75.ru/hitech' => array('section_id' => 10367),
			'75.ru/job' => array('section_id' => 1068),
			/*array(
				'site_id' => 152, // 75.ru
	    		'site_title' => '75.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 75,
				),*/
			'75.ru/grab_job' => array(
				'site_id' => 152, // 75.ru
		    		'site_title' => '75.ru',
			    	'regid' => 75,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_75',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'75.ru/grab_job_resume' => array(
				'site_id' => 152, // 75.ru
		    		'site_title' => '75.ru',
			    	'regid' => 75,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_75',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'75.ru/grab_job_vacancy' => array(
				'site_id' => 152, // 75.ru
		    		'site_title' => '75.ru',
			    	'regid' => 75,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_75',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'75.ru/sale' => array('section_id' => 1285),
			'75.ru/rent' => array('section_id' => 1286),
			'75.ru/commerce' => array('section_id' => 1288),
			'75.ru/change' => array('section_id' => 1287),*/

			'75.ru/realty' => array(
				'section_id' => 10721,
			),

			'75.ru/grab_realty' => array(
				'section_id' => 10721,
		    		'site_title' => '75.ru',
		    		'group' => 'grab_realty',
				),
			/*'75.ru/firms' => array(
				'site_id' => 152, // 75.ru
	    		'site_title' => '75.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 75,
				),*/
			'75.ru/firms' => array('section_id' => 3949),
			'75.ru/hadv' => array('section_id' => 289), // 75.ru - Частные объявления 	    	
/*	    	'75.ru/advertises' => array(
	    		'site_id' => 152, // 75.ru
	    		'site_title' => '75.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_75',
	    		), */
	    	'75.ru/car' => array('section_id' => 10978),
	    	'75.ru/grab_advertises' => array(
	    		'site_id' => 152, // 75.ru
	    		'site_title' => '75.ru',
	    		'regid' => 75,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_75',
	    		),
	    	'75.ru/catalog' => array('section_id' => 290), // 75.ru - Каталог сайтов
		//'75.ru/accident' => array('section_id' => 4521), // автокатастрофы 
		'75.ru/accident' => array(
			'site_id' => 152, // 75.ru
	    		'site_title' => '75.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4521
		), // автокатастрофы v2
		'75.ru/gallery' => array('section_id' => 4526),
			'75_conference_comments' => array(
				'site_title' => 'Регион 75',
				'section_title' => 'Комментарии конференции 75.ru',
		    		'RegionID' => 75,
				'group' => 'conference',
			),
			
			'75_firms_comments' => array(
				'site_title' => 'Комментарии фирм 75.ru',
				'section_title' => 'Комментарии фирм 75.ru',
				'TreeID' => 3949,
				'group' => 'all_firms_comments',
			),
			
			'75_blogs' => array(
				'site_title' => 'Регион 75',
				'section_title' => 'Дневники 75.ru',
	    		'RegionID' => 75,
				'group' => 'blogs',
			),
			'75_group_article_comments' => array(
				'site_title' => 'Регион 75',
				'section_title' => 'Комментарии группы статей 75.ru',
		    		'RegionID' => 75,
				'group' => 'group_article',
			),
			'75_grab_news' => array(
				'site_title' => 'Регион 75',
				'section_title' => '75: Новости (грабленные)',
		    	'RegionID' => array(75),
				'group' => 'grab_news_magic',
			),
	    		'75.ru/grab_board' => array(
		    		'site_title' => '75.ru',
		    		'regid' => 75,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'75.ru/grab_hitech' => array(
		    		'site_title' => '75.ru',
		    		'regid' => 75,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>