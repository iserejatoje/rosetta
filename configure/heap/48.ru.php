<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'48.ru/forum_magic_pm' => array(
				'section_id' => 204,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'48.ru/love' => array(
	            'site_id' => 142,
                'site_title' => '48.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_48',
	    		'photo_dir'	=> '/common_fs/i/sites/48.ru/love/photo/',
				'photo_url'	=> 'http://48.ru/i/love/photo/',
	    		),
			'48.ru/job' => array('section_id' => 1043),
			'48.ru/baraholka' => array('section_id' => 10386),
			'48.ru/lostfound' => array('section_id' => 11113),
			'48.ru/hitech' => array('section_id' => 10387),
			/*array(
				'site_id' => 142, // 48.ru
	    		'site_title' => '48.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 48,
				),*/
			'48.ru/grab_job' => array(
				'site_id' => 142, // 48.ru
		    		'site_title' => '48.ru',
		    		'regid' => 48,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_48',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'48.ru/grab_job_resume' => array(
				'site_id' => 142, // 48.ru
		    		'site_title' => '48.ru',
		    		'regid' => 48,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_48',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'48.ru/grab_job_vacancy' => array(
				'site_id' => 142, // 48.ru
		    		'site_title' => '48.ru',
		    		'regid' => 48,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_48',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'48.ru/sale' => array('section_id' => 1240),
			'48.ru/rent' => array('section_id' => 1241),
			'48.ru/commerce' => array('section_id' => 1243),
			'48.ru/change' => array('section_id' => 1242),*/
			'48.ru/realty' => array(
				'section_id' => 10744,
			),

			'48.ru/grab_realty' => array(
		    		'site_title' => '48.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10744,
				),
			/*'48.ru/firms' => array(
				'site_id' => 142, // 48.ru
	    		'site_title' => '48.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 48,
				),*/
			'48.ru/firms' => array('section_id' => 3940),
			'48.ru/hadv' => array('section_id' => 319), // 48.ru - Частные объявления 	    	
/*	    	'48.ru/advertises' => array(
	    		'site_id' => 142, // 48.ru
	    		'site_title' => '48.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_48',
	    		),   */
	    	'48.ru/car' => array('section_id' => 11010),
	    	'48.ru/grab_advertises' => array(
	    		'site_id' => 142, // 48.ru
	    		'site_title' => '48.ru',
	    		'regid' => 48,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_48',
	    		),
	    	'48.ru/catalog' => array('section_id' => 320), // 48.ru - Каталог сайтов
//		'48.ru/accident' => array('section_id' => 4351), // автокатастрофы 
		'48.ru/accident' => array(
			'site_id' => 142, // 48.ru
	    		'site_title' => '48.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4351
		), // автокатастрофы v2
			'48_conference_comments' => array(
				'site_title' => 'Регион 48',
				'section_title' => 'Комментарии конференции 48.ru',
		    		'RegionID' => 48,
				'group' => 'conference',
			),
		'48.ru/gallery' => array('section_id' => 4353),
		
		'48_firms_comments' => array(
				'site_title' => 'Комментарии фирм 48.ru',
				'section_title' => 'Комментарии фирм 48.ru',
				'TreeID' => 3940,
				'group' => 'all_firms_comments',
			),
			
			'48_blogs' => array(
				'site_title' => 'Регион 48',
				'section_title' => 'Дневники 48.ru',
	    		'RegionID' => 48,
				'group' => 'blogs',
			),
			'48_group_article_comments' => array(
				'site_title' => 'Регион 48',
				'section_title' => 'Комментарии группы статей 48.ru',
		    		'RegionID' => 48,
				'group' => 'group_article',
			),	
			'48_grab_news' => array(
				'site_title' => 'Регион 48',
				'section_title' => '48: Новости (грабленные)',
		    	'RegionID' => array(48),
				'group' => 'grab_news_magic',
			),			
	    		'48.ru/grab_board' => array(
		    		'site_title' => '48.ru',
		    		'regid' => 48,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'48.ru/grab_hitech' => array(
		    		'site_title' => '48.ru',
		    		'regid' => 48,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	    );

?>
