<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'164.ru/forum_magic_pm' => array(
				'section_id' => 5855,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'164_blogs' => array(
				'site_title' => 'Регион 164',
				'section_title' => 'Дневники 164.ru',
	    		'RegionID' => 164,
				'group' => 'blogs',
			),
			
			'164_news_comments' => array(
				'site_title' => 'Регион 64',
				'section_title' => 'Комментарии новости 164.ru',
		    		'RegionID' => 64, //(array)
				//'SiteID' => , (array)
				//'SectionID' => , (array)
				'group' => 'news_magic',
			),
			
			'164.ru/firms' => array('section_id' => 5879),

			'164.ru/job' => array('section_id' => 5859),
			'164.ru/baraholka' => array('section_id' => 10452),
			'164.ru/lostfound' => array('section_id' => 11127),
			'164.ru/hitech' => array('section_id' => 10453),

			'164.ru/realty' => array('section_id' => 10735),

	  		'164.ru/accident' => array(
				'site_id' => 5851, // 164.ru
		    		'site_title' => '164.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 5875
			), // автокатастрофы v2

			'164.ru/grab_job' => array(
				'site_id' => 5851, // 164.ru
		    		'site_title' => '164.ru',
		    		'regid' => 64,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_64',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'164.ru/grab_job_resume' => array(
				'site_id' => 5851, // 164.ru
		    		'site_title' => '164.ru',
		    		'regid' => 64,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_64',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'164.ru/grab_job_vacancy' => array(
				'site_id' => 5851, // 164.ru
		    		'site_title' => '164.ru',
		    		'regid' => 64,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_64',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
		    	'164.ru/car' => array('section_id' => 10980),
		    	'164.ru/grab_advertises' => array(
		    		'site_id' => 5851, // 164.ru
	    			'site_title' => '164.ru',
	    			'regid' => 64,
		    		'group' => 'grab_rugion_car',
		    		//'db' => 'region_64',
	    			),
			'164.ru/grab_realty' => array(
		    		'site_title' => '164.ru',
				'section_id' => 10735,
	    			'group' => 'grab_realty',
				),
			'164_group_article_comments' => array(
				'site_title' => 'Регион 64',
				'section_title' => 'Комментарии группы статей 164.ru',
		    		'RegionID' => 64,
				'group' => 'group_article',
			),
			'64_grab_news' => array(
				'site_title' => 'Регион 64',
				'section_title' => '64: Новости (грабленные)',
		    	'RegionID' => array(64),
				'group' => 'grab_news_magic',
			),
	    		'164.ru/grab_board' => array(
		    		'site_title' => '164.ru',
		    		'regid' => 64,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'164.ru/grab_hitech' => array(
		    		'site_title' => '164.ru',
		    		'regid' => 64,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);
?>