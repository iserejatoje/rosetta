<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'51.ru/forum_magic_pm' => array(
				'section_id' => 205,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'51.ru/love' => array(
	            'site_id' => 143,
                'site_title' => '51.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_51',
	    		'photo_dir'	=> '/common_fs/i/sites/51.ru/love/photo/',
				'photo_url'	=> 'http://51.ru/i/love/photo/',
	    		),
			'51.ru/job' => array('section_id' => 1044),
			'51.ru/baraholka' => array('section_id' => 10384),
			'51.ru/lostfound' => array('section_id' => 11114),
			'51.ru/hitech' => array('section_id' => 10385),
			/*array(
				'site_id' => 143, // 51.ru
	    		'site_title' => '51.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 51,
				),*/
			'51.ru/grab_job' => array(
				'site_id' => 143, // 51.ru
		    		'site_title' => '51.ru',
		    		'regid' => 51,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_51',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'51.ru/grab_job_resume' => array(
				'site_id' => 143, // 51.ru
		    		'site_title' => '51.ru',
		    		'regid' => 51,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_51',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'51.ru/grab_job_vacancy' => array(
				'site_id' => 143, // 51.ru
		    		'site_title' => '51.ru',
		    		'regid' => 51,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_51',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'51.ru/sale' => array('section_id' => 1245),
			'51.ru/rent' => array('section_id' => 1246),
			'51.ru/commerce' => array('section_id' => 1248),
			'51.ru/change' => array('section_id' => 1247),*/
			'51.ru/realty' => array(
				'section_id' => 10741,
			),

			'51.ru/grab_realty' => array(
		    		'site_title' => '51.ru',
				'section_id' => 10741,
	    			'group' => 'grab_realty',
				),
			/*'51.ru/firms' => array(
				'site_id' => 143, // 51.ru
	    		'site_title' => '51.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 51,
				),*/
			'51.ru/firms' => array('section_id' => 3941),
			'51.ru/hadv' => array('section_id' => 316), // 51.ru - Частные объявления 	    	
/*	    	'51.ru/advertises' => array(
	    		'site_id' => 143, // 51.ru
	    		'site_title' => '51.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_51',
	    		), */
	    	'51.ru/car' => array('section_id' => 10995),
	    	'51.ru/grab_advertises' => array(
	    		'site_id' => 143, // 51.ru
	    		'site_title' => '51.ru',
	    		'regid' => 51,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_51',
	    		),
	    	'51.ru/catalog' => array('section_id' => 317), // 51.ru - Каталог сайтов
		//'51.ru/accident' => array('section_id' => 4365), // автокатастрофы 
		'51.ru/accident' => array(
			'site_id' => 143, // 51.ru
	    		'site_title' => '51.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4365
		), // автокатастрофы v2
		'51.ru/gallery' => array('section_id' => 4367),
			'51_conference_comments' => array(
				'site_title' => 'Регион 51',
				'section_title' => 'Комментарии конференции 51.ru',
		    		'RegionID' => 51,
				'group' => 'conference',
			),
			'51_afisha_comments' => array(
				'site_title' => 'Регион 51',
				'section_title' => 'Комментарии афиши 51.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4636, //(array)
				'group' => 'afisha_magic',
			),
			
			'51_firms_comments' => array(
				'site_title' => 'Комментарии фирм 51.ru',
				'section_title' => 'Комментарии фирм 51.ru',
				'TreeID' => 3941,
				'group' => 'all_firms_comments',
			),
			
			'51_blogs' => array(
				'site_title' => 'Регион 51',
				'section_title' => 'Дневники 51.ru',
	    		'RegionID' => 51,
				'group' => 'blogs',
			),
			'51_group_article_comments' => array(
				'site_title' => 'Регион 51',
				'section_title' => 'Комментарии группы статей 51.ru',
		    		'RegionID' => 51,
				'group' => 'group_article',
			),
			'51_grab_news' => array(
				'site_title' => 'Регион 51',
				'section_title' => '51: Новости (грабленные)',
		    	'RegionID' => array(51),
				'group' => 'grab_news_magic',
			),
			
	    		'51.ru/grab_board' => array(
		    		'site_title' => '51.ru',
		    		'regid' => 51,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'51.ru/grab_hitech' => array(
		    		'site_title' => '51.ru',
		    		'regid' => 51,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
    );

?>
