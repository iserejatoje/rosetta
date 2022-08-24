<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'29.ru/forum_magic_pm' => array(
				'section_id' => 198,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'29.ru/love' => array(
	            'site_id' => 136,
                'site_title' => '29.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_29',
	    		'photo_dir'	=> '/common_fs/i/sites/29.ru/love/photo/',
				'photo_url'	=> 'http://29.ru/i/love/photo/',
	    		),
			'29.ru/job' => array('section_id' => 1025),
			'29.ru/baraholka' => array('section_id' => 10398),
			'29.ru/lostfound' => array('section_id' => 11105),
			'29.ru/hitech' => array('section_id' => 10399),
			/*array(
				'site_id' => 136, // 29.ru
	    		'site_title' => '29.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 29,
				),*/
			'29.ru/grab_job' => array(
				'site_id' => 136, // 29.ru
		    		'site_title' => '29.ru',
		    		'regid' => 29,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_29',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'29.ru/grab_job_resume' => array(
				'site_id' => 136, // 29.ru
		    		'site_title' => '29.ru',
		    		'regid' => 29,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_29',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'29.ru/grab_job_vacancy' => array(
				'site_id' => 136, // 29.ru
		    		'site_title' => '29.ru',
		    		'regid' => 29,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_29',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'29.ru/sale' => array('section_id' => 1210),
			'29.ru/rent' => array('section_id' => 1211),
			'29.ru/commerce' => array('section_id' => 1213),
			'29.ru/change' => array('section_id' => 1212),*/
			'29.ru/realty' => array(
				'section_id' => 10750,
			),
			'29.ru/grab_realty' => array(
		    		'site_title' => '29.ru',
				'section_id' => 10750,
		    		'group' => 'grab_realty',
				),
			/*'29.ru/firms' => array(
				'site_id' => 136, // 29.ru
	    		'site_title' => '29.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 29,
				),*/
			'29.ru/firms' => array('section_id' => 3930),
			'29.ru/hadv' => array('section_id' => 337), // 29.ru - Частные объявления 	    	
/*	    	'29.ru/advertises' => array(
	    		'site_id' => 136, // 29.ru
	    		'site_title' => '29.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_29',
	    		),  */
	    	'29.ru/car' => array('section_id' => 10992),
	    	'29.ru/grab_advertises' => array(
	    		'site_id' => 136, // 29.ru
	    		'site_title' => '29.ru',
	    		'regid' => 29,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_29',
	    		),
	    	'29.ru/catalog' => array('section_id' => 338), // 29.ru - Каталог сайтов
		//'29.ru/accident' => array('section_id' => 3890), // автокатастрофы 
		'29.ru/accident' => array(
			'site_id' => 136, // 29.ru
	    		'site_title' => '29.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 3890
		), // автокатастрофы v2
			'29_conference_comments' => array(
				'site_title' => 'Регион 29',
				'section_title' => 'Комментарии конференции 29.ru',
		    		'RegionID' => 29,
				'group' => 'conference',
			),
			'29_afisha_comments' => array(
				'site_title' => 'Регион 29',
				'section_title' => 'Комментарии афиши 29.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4637, //(array)
				'group' => 'afisha_magic',
			),
			'29.ru/gallery' => array('section_id' => 3889),
			'29_firms_comments' => array(
				'site_title' => 'Комментарии фирм 29.ru',
				'section_title' => 'Комментарии фирм 29.ru',
				'TreeID' => 3930,
				'group' => 'all_firms_comments',
			),
			
			'29_blogs' => array(
				'site_title' => 'Регион 29',
				'section_title' => 'Дневники 29.ru',
	    		'RegionID' => 29,
				'group' => 'blogs',
			),
			'29_group_article_comments' => array(
				'site_title' => 'Регион 29',
				'section_title' => 'Комментарии группы статей 29.ru',
		    		'RegionID' => 29,
				'group' => 'group_article',
			),
			'29_grab_news' => array(
				'site_title' => 'Регион 29',
				'section_title' => '29: Новости (грабленные)',
		    	'RegionID' => array(29),
				'group' => 'grab_news_magic',
			),
			'29_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'29.ru/grab_board' => array(
		    		'site_title' => '29.ru',
		    		'regid' => 29,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'29.ru/grab_hitech' => array(
		    		'site_title' => '29.ru',
		    		'regid' => 29,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	    );

?>
