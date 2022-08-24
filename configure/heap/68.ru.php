<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'68.ru/forum_magic_pm' => array(
				'section_id' => 210,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'68.ru/love' => array(
	            'site_id' => 148,
                'site_title' => '68.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_68',
	    		'photo_dir'	=> '/common_fs/i/sites/68.ru/love/photo/',
				'photo_url'	=> 'http://68.ru/i/love/photo/',
	    		),
			'68.ru/job' => array('section_id' => 1058),
			'68.ru/baraholka' => array('section_id' => 10374),
			'68.ru/lostfound' => array('section_id' => 11129),
			'68.ru/hitech' => array('section_id' => 10375),
			/*array(
				'site_id' => 148, // 68.ru
	    		'site_title' => '68.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 68,
				),*/
			'68.ru/grab_job' => array(
				'site_id' => 148, // 68.ru
		    		'site_title' => '68.ru',
		    		'regid' => 68,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_68',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'68.ru/grab_job_resume' => array(
				'site_id' => 148, // 68.ru
		    		'site_title' => '68.ru',
		    		'regid' => 68,
	    			'group' => 'grab_rugion_job',
	    			'out_db' => 'region_68',
					'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'68.ru/grab_job_vacancy' => array(
				'site_id' => 148, // 68.ru
		    		'site_title' => '68.ru',
		    		'regid' => 68,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_68',
					'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'68.ru/sale' => array('section_id' => 1270),
			'68.ru/rent' => array('section_id' => 1271),
			'68.ru/commerce' => array('section_id' => 1273),
			'68.ru/change' => array('section_id' => 1272),*/

			'68.ru/realty' => array(
				'section_id' => 10754,
			),

			'68.ru/grab_realty' => array(
		    		'site_title' => '68.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10754,
				),
			/*'68.ru/firms' => array(
				'site_id' => 148, // 68.ru
	    		'site_title' => '68.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 68,
				),*/
			'68.ru/firms' => array('section_id' => 3946),
			'68.ru/hadv' => array('section_id' => 201), // 68.ru - Частные объявления 	    	
/*	    	'68.ru/advertises' => array(
	    		'site_id' => 148, // 68.ru
	    		'site_title' => '68.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_68',
	    		),*/
	    	'68.ru/car' => array('section_id' => 10977),
	    	'68.ru/grab_advertises' => array(
	    		'site_id' => 148, // 68.ru
	    		'site_title' => '68.ru',
	    		'regid' => 68,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_68',
	    		),
	    	'68.ru/catalog' => array('section_id' => 302), // 68.ru - Каталог сайтов
		//'68.ru/accident' => array('section_id' => 4432), // автокатастрофы 
		'68.ru/accident' => array(
			'site_id' => 4, // 14.ru
	    		'site_title' => '68.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4432
		), // автокатастрофы v2
			'68_conference_comments' => array(
				'site_title' => 'Регион 68',
				'section_title' => 'Комментарии конференции 68.ru',
		    		'RegionID' => 68,
				'group' => 'conference',
			),
		'68.ru/gallery' => array('section_id' => 4437),
		
		'68_firms_comments' => array(
				'site_title' => 'Комментарии фирм 68.ru',
				'section_title' => 'Комментарии фирм 68.ru',
				'TreeID' => 3946,
				'group' => 'all_firms_comments',
			),
			
			'68_blogs' => array(
				'site_title' => 'Регион 68',
				'section_title' => 'Дневники 68.ru',
	    		'RegionID' => 68,
				'group' => 'blogs',
			),
			'68_group_article_comments' => array(
				'site_title' => 'Регион 68',
				'section_title' => 'Комментарии группы статей 68.ru',
		    		'RegionID' => 68,
				'group' => 'group_article',
			),
			'68_grab_news' => array(
				'site_title' => 'Регион 68',
				'section_title' => '68: Новости (грабленные)',
		    	'RegionID' => array(68),
				'group' => 'grab_news_magic',
			),
	    		'68.ru/grab_board' => array(
		    		'site_title' => '68.ru',
		    		'regid' => 68,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'68.ru/grab_hitech' => array(
		    		'site_title' => '68.ru',
		    		'regid' => 68,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>