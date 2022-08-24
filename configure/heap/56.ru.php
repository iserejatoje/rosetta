<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'56.ru/forum_magic_pm' => array(
				'section_id' => 207,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'56.ru/love' => array(
	            'site_id' => 145,
                'site_title' => '56.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_56',
	    		'photo_dir'	=> '/common_fs/i/sites/56.ru/love/photo/',
				'photo_url'	=> 'http://56.ru/i/love/photo/',
	    		),
			'56.ru/job' => array('section_id' => 1047),
			'56.ru/baraholka' => array('section_id' => 10380),
			'56.ru/lostfound' => array('section_id' => 11118),
			'56.ru/hitech' => array('section_id' => 10381),
			/*array(
				'site_id' => 145, // 56.ru
	    		'site_title' => '56.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 56,
				),*/
			'56.ru/grab_job' => array(
				'site_id' => 145, // 56.ru
		    		'site_title' => '56.ru',
		    		'regid' => 56,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_56',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'56.ru/grab_job_resume' => array(
				'site_id' => 145, // 56.ru
		    		'site_title' => '56.ru',
		    		'regid' => 56,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_56',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'56.ru/grab_job_vacancy' => array(
				'site_id' => 145, // 56.ru
		    		'site_title' => '56.ru',
		    		'regid' => 56,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_56',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'56.ru/sale' => array('section_id' => 1255),
//			'56.ru/rent' => array('section_id' => 1256),
//			'56.ru/commerce' => array('section_id' => 1258),
//			'56.ru/change' => array('section_id' => 1257),
			'56.ru/realty' => array(
				'section_id' => 10791,
			),
			'56.ru/grab_realty' => array(
		    		'site_title' => '56.ru',
				'section_id' => 10791,
		    		'group' => 'grab_realty',
				),
			/*'56.ru/firms' => array(
				'site_id' => 145, // 56.ru
	    		'site_title' => '56.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 56,
				),*/
			'56.ru/firms' => array('section_id' => 3943),
			'56.ru/hadv' => array('section_id' => 310), // 56.ru - Частные объявления 	    	
/*	    	'56.ru/advertises' => array(
	    		'site_id' => 145, // 56.ru
	    		'site_title' => '56.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_56',
	    		),  */
	    	'56.ru/car' => array('section_id' => 10981),
	    	'56.ru/grab_advertises' => array(
	    		'site_id' => 145, // 56.ru
	    		'site_title' => '56.ru',
	    		'regid' => 56,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_56',
	    		),
	    	'56.ru/catalog' => array('section_id' => 311), // 56.ru - Каталог сайтов
		//'56.ru/accident' => array('section_id' => 4384), // автокатастрофы 
		'56.ru/accident' => array(
			'site_id' => 145, // 56.ru
	    		'site_title' => '56.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4384
		), // автокатастрофы v2
			'56_afisha_comments' => array(
				'site_title' => 'Регион 56',
				'section_title' => 'Комментарии афиши 56.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4640, //(array)
				'group' => 'afisha_magic',
			),
			'56_conference_comments' => array(
				'site_title' => 'Регион 56',
				'section_title' => 'Комментарии конференции 56.ru',
		    		'RegionID' => 56,
				'group' => 'conference',
			),
		'56.ru/gallery' => array('section_id' => 4389),
		
		'56_firms_comments' => array(
				'site_title' => 'Комментарии фирм 56.ru',
				'section_title' => 'Комментарии фирм 56.ru',
				'TreeID' => 3943,
				'group' => 'all_firms_comments',
			),
			
			'56_blogs' => array(
				'site_title' => 'Регион 56',
				'section_title' => 'Дневники 56.ru',
	    		'RegionID' => 56,
				'group' => 'blogs',
			),
			'56_group_article_comments' => array(
				'site_title' => 'Регион 56',
				'section_title' => 'Комментарии группы статей 56.ru',
		    		'RegionID' => 56,
				'group' => 'group_article',
			),
			'56_grab_news' => array(
				'site_title' => 'Регион 56',
				'section_title' => '56: Новости (грабленные)',
		    	'RegionID' => array(56),
				'group' => 'grab_news_magic',
			),
	    		'56.ru/grab_board' => array(
		    		'site_title' => '56.ru',
		    		'regid' => 56,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'56.ru/grab_hitech' => array(
		    		'site_title' => '56.ru',
		    		'regid' => 56,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		
			)
	    );

?>
