<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'76.ru/forum_magic_pm' => array(
				'section_id' => 215,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'76.ru/love' => array(
	            'site_id' => 154,
                'site_title' => '76.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_76',
	    		'photo_dir'	=> '/common_fs/i/sites/76.ru/love/photo/',
				'photo_url'	=> 'http://76.ru/i/love/photo/',
	    		),
			'76.ru/job' => array('section_id' => 1069),
			'76.ru/baraholka' => array('section_id' => 10364),
			'76.ru/lostfound' => array('section_id' => 11134),
			'76.ru/hitech' => array('section_id' => 10365),
			/*array(
				'site_id' => 153, // 76.ru
	    		'site_title' => '76.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 76,
				),*/
			'76.ru/grab_job' => array(
				'site_id' => 153, // 76.ru
		    		'site_title' => '76.ru',
		    		'regid' => 76,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_76',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'76.ru/grab_job_resume' => array(
				'site_id' => 153, // 76.ru
		    		'site_title' => '76.ru',
		    		'regid' => 76,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_76',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'76.ru/grab_job_vacancy' => array(
				'site_id' => 153, // 76.ru
		    		'site_title' => '76.ru',
		    		'regid' => 76,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_76',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'76.ru/sale' => array('section_id' => 1290),
//			'76.ru/rent' => array('section_id' => 1291),
//			'76.ru/commerce' => array('section_id' => 1293),
//			'76.ru/change' => array('section_id' => 1292),
			'76.ru/realty' => array(
				'section_id' => 4158,
			),
			'76.ru/grab_realty' => array(
				'section_id' => 4158,
		    		'site_title' => '76.ru',
		    		'group' => 'grab_realty',
				),
			/*'76.ru/firms' => array(
				'site_id' => 153, // 76.ru
	    		'site_title' => '76.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 76,
				),*/
			'76.ru/firms' => array('section_id' => 3950),
			'76.ru/hadv' => array('section_id' => 286), // 76.ru - Частные объявления 	    	
/*	    	'76.ru/advertises' => array(
	    		'site_id' => 153, // 76.ru
	    		'site_title' => '76.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_76',
	    		), */
	    	'76.ru/car' => array('section_id' => 10994),
	    	'76.ru/grab_advertises' => array(
	    		'site_id' => 153, // 76.ru
	    		'site_title' => '76.ru',
	    		'regid' => 76,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_76',
	    		),
		        //'76.ru/accident' => array('section_id' => 4128),
		'76.ru/accident' => array(
			'site_id' => 153, // 76.ru
	    		'site_title' => '76.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4128
		), // автокатастрофы v2
	    	'76.ru/catalog' => array('section_id' => 287), // 76.ru - Каталог сайтов
			'76_conference_comments' => array(
				'site_title' => 'Регион 76',
				'section_title' => 'Комментарии конференции 76.ru',
		    		'RegionID' => 76,
				'group' => 'conference',
			),
			'76_afisha_comments' => array(
				'site_title' => 'Регион 76',
				'section_title' => 'Комментарии афиши 76.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4635, //(array)
				'group' => 'afisha_magic',
			),
			
			'76_firms_comments' => array(
				'site_title' => 'Комментарии фирм 76.ru',
				'section_title' => 'Комментарии фирм 76.ru',
				'TreeID' => 3950,
				'group' => 'all_firms_comments',
			),
			
			'76_blogs' => array(
				'site_title' => 'Регион 76',
				'section_title' => 'Дневники 76.ru',
	    		'RegionID' => 76,
				'group' => 'blogs',
			),
			'76_group_article_comments' => array(
				'site_title' => 'Регион 76',
				'section_title' => 'Комментарии группы статей 76.ru',
		    		'RegionID' => 76,
				'group' => 'group_article',
			),
			'76_grab_news' => array(
				'site_title' => 'Регион 76',
				'section_title' => '76: Новости (грабленные)',
		    	'RegionID' => array(76),
				'group' => 'grab_news_magic',
			),
			'76_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'76.ru/grab_board' => array(
		    		'site_title' => '76.ru',
		    		'regid' => 76,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'76.ru/grab_hitech' => array(
		    		'site_title' => '76.ru',
		    		'regid' => 76,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>
