<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'86.ru/forum_magic_pm' => array(
				'section_id' => 216,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'86.ru/love' => array(
	            'site_id' => 154,
                'site_title' => '86.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_86',
	    		'photo_dir'	=> '/common_fs/i/sites/86.ru/love/photo/',
				'photo_url'	=> 'http://86.ru/i/love/photo/',
	    		),
			'86.ru/job' => array('section_id' => 1062),
			'86.ru/baraholka' => array('section_id' => 10362),
			'86.ru/lostfound' => array('section_id' => 11136),
			'86.ru/hitech' => array('section_id' => 10363),
			/*array(
				'site_id' => 154, // 86.ru
	    		'site_title' => '86.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 86,
				),*/
			'86.ru/grab_job' => array(
				'site_id' => 154, // 86.ru
		    		'site_title' => '86.ru',
		    		'regid' => 86,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_86',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'86.ru/grab_job_resume' => array(
				'site_id' => 154, // 86.ru
		    		'site_title' => '86.ru',
		    		'regid' => 86,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_86',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'86.ru/grab_job_vacancy' => array(
				'site_id' => 154, // 86.ru
		    		'site_title' => '86.ru',
		    		'regid' => 86,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_86',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
/*			'86.ru/sale' => array('section_id' => 1295),
			'86.ru/rent' => array('section_id' => 1296),
			'86.ru/commerce' => array('section_id' => 1298),
			'86.ru/change' => array('section_id' => 1297),*/

			'86.ru/realty' => array(
				'section_id' => 10738,
			),

			'86.ru/grab_realty' => array(
				'section_id' => 10738,
		    		'site_title' => '86.ru',
		    		'group' => 'grab_realty',
				),
			/*'86.ru/firms' => array(
				'site_id' => 154, // 86.ru
	    		'site_title' => '86.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 86,
				),*/
			'86.ru/firms' => array('section_id' => 3953),
			'86.ru/hadv' => array('section_id' => 283), // 86.ru - Частные объявления 	    	
/*	    	'86.ru/advertises' => array(
	    		'site_id' => 154, // 86.ru
	    		'site_title' => '86.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_86',
	    		), */
		    	'86.ru/car' => array('section_id' => 11016),
	    	'86.ru/grab_advertises' => array(
	    		'site_id' => 154, // 86.ru
	    		'site_title' => '86.ru',
	    		'regid' => 86,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_86',
	    		),
	    	'86.ru/catalog' => array('section_id' => 284), // 86.ru - Каталог сайтов
		'86.ru/forum-pm' => array('section_id' => 216),
		        //'86.ru/accident' => array('section_id' => 4167),
		'86.ru/accident' => array(
			'site_id' => 154, // 86.ru
	    		'site_title' => '86.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4167
		), // автокатастрофы v2
			'86_afisha_comments' => array(
				'site_title' => 'Регион 86',
				'section_title' => 'Комментарии афиши 86.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4639, //(array)
				'group' => 'afisha_magic',
			),
			'86_conference_comments' => array(
				'site_title' => 'Регион 86',
				'section_title' => 'Комментарии конференции 86.ru',
		    		'RegionID' => 86,
				'group' => 'conference',
			),
			'86.ru/gallery' => array('section_id' => 4168),
			
			'86_firms_comments' => array(
				'site_title' => 'Комментарии фирм 86.ru',
				'section_title' => 'Комментарии фирм 86.ru',
				'TreeID' => 3953,
				'group' => 'all_firms_comments',
			),
			
			'86_blogs' => array(
				'site_title' => 'Регион 86',
				'section_title' => 'Дневники 86.ru',
	    		'RegionID' => 86,
				'group' => 'blogs',
			),
			'86_group_article_comments' => array(
				'site_title' => 'Регион 86',
				'section_title' => 'Комментарии группы статей 86.ru',
		    		'RegionID' => 86,
				'group' => 'group_article',
			),
			
	    		'86.ru/grab_board' => array(
		    		'site_title' => '86.ru',
		    		'regid' => 86,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'86.ru/grab_hitech' => array(
		    		'site_title' => '86.ru',
		    		'regid' => 86,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>
