<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'60.ru/forum_magic_pm' => array(
				'section_id' => 208,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'60.ru/love' => array(
	            'site_id' => 146,
                'site_title' => '60.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_60',
	    		'photo_dir'	=> '/common_fs/i/sites/60.ru/love/photo/',
				'photo_url'	=> 'http://60.ru/i/love/photo/',
	    		),
			'60.ru/job' => array('section_id' => 1056),
			'60.ru/baraholka' => array('section_id' => 10378),
			'60.ru/lostfound' => array('section_id' => 11123),
			'60.ru/hitech' => array('section_id' => 10379),
			/*array(
				'site_id' => 146, // 60.ru
	    		'site_title' => '60.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 60,
				),*/
			'60.ru/grab_job' => array(
				'site_id' => 146, // 60.ru
	    			'site_title' => '60.ru',
		    		'regid' => 60,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'region_60',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'60.ru/grab_job_resume' => array(
				'site_id' => 146, // 60.ru
	    			'site_title' => '60.ru',
		    		'regid' => 60,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'region_60',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'60.ru/grab_job_vacancy' => array(
				'site_id' => 146, // 60.ru
	    			'site_title' => '60.ru',
		    		'regid' => 60,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'region_60',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'60.ru/sale' => array('section_id' => 1260),
//			'60.ru/rent' => array('section_id' => 1261),
//			'60.ru/commerce' => array('section_id' => 1263),
//			'60.ru/change' => array('section_id' => 1262),
			'60.ru/realty' => array(
				'section_id' => 10798,
			),
			'60.ru/grab_realty' => array(
		    		'site_title' => '60.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10798,
				),
			/*'60.ru/firms' => array(
				'site_id' => 146, // 60.ru
	    		'site_title' => '60.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 60,
				),*/
			'60.ru/firms' => array('section_id' => 3944),
			'60.ru/hadv' => array('section_id' => 307), // 60.ru - Частные объявления 	    	
/*	    	'60.ru/advertises' => array(
	    		'site_id' => 146, // 60.ru
	    		'site_title' => '60.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_60',
	    		),  */
	    	'60.ru/car' => array('section_id' => 10974),
	    	'60.ru/grab_advertises' => array(
	    		'site_id' => 146, // 60.ru
	    		'site_title' => '60.ru',
	    		'regid' => 60,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_60',
	    		),
	    	'60.ru/catalog' => array('section_id' => 308), // 60.ru - Каталог сайтов
		//'60.ru/accident' => array('section_id' => 4396), // автокатастрофы 
		'60.ru/accident' => array(
			'site_id' => 146, // 60.ru
	    		'site_title' => '60.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4396
		), // автокатастрофы v2
			'60_conference_comments' => array(
				'site_title' => 'Регион 60',
				'section_title' => 'Комментарии конференции 60.ru',
		    		'RegionID' => 60,
				'group' => 'conference',
			),
		'60.ru/gallery' => array('section_id' => 4401),
		
		'60_firms_comments' => array(
				'site_title' => 'Комментарии фирм 60.ru',
				'section_title' => 'Комментарии фирм 60.ru',
				'TreeID' => 3944,
				'group' => 'all_firms_comments',
			),
			
			'60_blogs' => array(
				'site_title' => 'Регион 60',
				'section_title' => 'Дневники 60.ru',
		    		'RegionID' => 60,
				'group' => 'blogs',
			),
			'60_group_article_comments' => array(
				'site_title' => 'Регион 60',
				'section_title' => 'Комментарии группы статей 60.ru',
		    		'RegionID' => 60,
				'group' => 'group_article',
			),
			'60_grab_news' => array(
				'site_title' => 'Регион 60',
				'section_title' => '60: Новости (грабленные)',
		    	'RegionID' => array(60),
				'group' => 'grab_news_magic',
			),
	    		'60.ru/grab_board' => array(
		    		'site_title' => '60.ru',
		    		'regid' => 60,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'60.ru/grab_hitech' => array(
		    		'site_title' => '60.ru',
		    		'regid' => 60,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
    );

?>
