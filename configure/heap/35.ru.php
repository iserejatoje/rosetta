<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'35.ru/forum_magic_pm' => array(
				'section_id' => 199,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'35.ru/love' => array(
	            'site_id' => 137,
                'site_title' => '35.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_35',
	    		'photo_dir'	=> '/common_fs/i/sites/35.ru/love/photo/',
				'photo_url'	=> 'http://35.ru/i/love/photo/',
	    		),
			'35.ru/job' => array('section_id' => 1035),
			'35.ru/baraholka' => array('section_id' => 10396),
			'35.ru/lostfound' => array('section_id' => 11107),
			'35.ru/hitech' => array('section_id' => 10397),
			/*array(
				'site_id' => 137, // 35.ru
	    		'site_title' => '35.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 35,
				),*/
			'35.ru/grab_job' => array(
				'site_id' => 137, // 35.ru
		    		'site_title' => '35.ru',
		    		'regid' => 35,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_35',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'35.ru/grab_job_resume' => array(
				'site_id' => 137, // 35.ru
		    		'site_title' => '35.ru',
		    		'regid' => 35,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_35',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'35.ru/grab_job_vacancy' => array(
				'site_id' => 137, // 35.ru
		    		'site_title' => '35.ru',
		    		'regid' => 35,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_35',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'35.ru/sale' => array('section_id' => 1215),
			'35.ru/rent' => array('section_id' => 1216),
			'35.ru/commerce' => array('section_id' => 1218),
			'35.ru/change' => array('section_id' => 1217),*/
			'35.ru/realty' => array(
				'section_id' => 10737,
			),
			'35.ru/grab_realty' => array(
		    		'site_title' => '35.ru',
				'section_id' => 10737,
		    		'group' => 'grab_realty',
				),
			/*'35.ru/firms' => array(
				'site_id' => 137, // 35.ru
	    		'site_title' => '35.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 35,
				),*/
			'35.ru/firms' => array('section_id' => 3932),
			'35.ru/hadv' => array('section_id' => 334), // 35.ru - Частные объявления 	    	
/*	    	'35.ru/advertises' => array(
	    		'site_id' => 137, // 35.ru
	    		'site_title' => '35.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_35',
	    		),*/
	    	'35.ru/car' => array('section_id' => 10999),
	    	'35.ru/grab_advertises' => array(
	    		'site_id' => 137, // 35.ru
	    		'site_title' => '35.ru',
	    		'regid' => 35,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_35',
	    		),
	    	'35.ru/catalog' => array('section_id' => 335), // 35.ru - Каталог сайтов
		//'35.ru/accident' => array('section_id' => 4277), // автокатастрофы 
			'35_conference_comments' => array(
				'site_title' => 'Регион 35',
				'section_title' => 'Комментарии конференции 35.ru',
		    		'RegionID' => 35,
				'group' => 'conference',
			),
		'35.ru/accident' => array(
			'site_id' => 137, // 35.ru
	    		'site_title' => '35.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4277
		), // автокатастрофы v2
			'35.ru/gallery' => array('section_id' => 4279),
			
			'35_firms_comments' => array(
				'site_title' => 'Комментарии фирм 35.ru',
				'section_title' => 'Комментарии фирм 35.ru',
				'TreeID' => 3932,
				'group' => 'all_firms_comments',
			),
			
			'35_blogs' => array(
				'site_title' => 'Регион 35',
				'section_title' => 'Дневники 35.ru',
	    		'RegionID' => 35,
				'group' => 'blogs',
			),
			'35_group_article_comments' => array(
				'site_title' => 'Регион 35',
				'section_title' => 'Комментарии группы статей 35.ru',
		    		'RegionID' => 35,
				'group' => 'group_article',
			),
			'35_grab_news' => array(
				'site_title' => 'Регион 35',
				'section_title' => '35: Новости (грабленные)',
		    	'RegionID' => array(35),
				'group' => 'grab_news_magic',
			),
	    		'35.ru/grab_board' => array(
		    		'site_title' => '35.ru',
		    		'regid' => 35,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'35.ru/grab_hitech' => array(
		    		'site_title' => '35.ru',
		    		'regid' => 35,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		),
	    );

?>
