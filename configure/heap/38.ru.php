<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'38.ru/forum_magic_pm' => array(
				'section_id' => 200,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
		
			'38.ru/love' => array(
	            'site_id' => 138,
                'site_title' => '38.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_38',
	    		'photo_dir'	=> '/common_fs/i/sites/38.ru/love/photo/',
				'photo_url'	=> 'http://38.ru/i/love/photo/',
	    		),
			'38.ru/job' => array('section_id' => 1036),
			/*array(
				'site_id' => 138, // 38.ru
	    		'site_title' => '38.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 38,
				),*/
			'38.ru/baraholka' => array('section_id' => 10394),
			'38.ru/lostfound' => array('section_id' => 11109),
			'38.ru/hitech' => array('section_id' => 10395),
			'38.ru/grab_job' => array(
				'site_id' => 138, // 38.ru
		    		'site_title' => '38.ru',
		    		'regid' => 38,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_38',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'38.ru/grab_job_resume' => array(
				'site_id' => 138, // 38.ru
		    		'site_title' => '38.ru',
		    		'regid' => 38,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_38',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'38.ru/grab_job_vacancy' => array(
				'site_id' => 138, // 38.ru
		    		'site_title' => '38.ru',
		    		'regid' => 38,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_38',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'38.ru/sale' => array('section_id' => 1220),
//			'38.ru/rent' => array('section_id' => 1221),
//			'38.ru/commerce' => array('section_id' => 1223),
//			'38.ru/change' => array('section_id' => 1222),
			'38.ru/realty' => array(
				'section_id' => 10796,
			),
			'38.ru/grab_realty' => array(
		    		'site_title' => '38.ru',
				'section_id' => 10796,
		    		'group' => 'grab_realty',
				),
			/*'38.ru/firms' => array(
				'site_id' => 138, // 38.ru
	    		'site_title' => '38.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 38,
				),*/
			'38.ru/firms' => array('section_id' => 3933),
			'38.ru/hadv' => array('section_id' => 331), // 38.ru - Частные объявления 	    	
/*	    	'38.ru/advertises' => array(
	    		'site_id' => 138, // 38.ru
	    		'site_title' => '38.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_38',
	    		),*/
	    	'38.ru/car' => array('section_id' => 10984),
	    	'38.ru/grab_advertises' => array(
	    		'site_id' => 138, // 38.ru
	    		'site_title' => '38.ru',
	    		'regid' => 38,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_38',
	    		),
	    	'38.ru/catalog' => array('section_id' => 332), // 38.ru - Каталог сайтов
		//'38.ru/accident' => array('section_id' => 4290), // автокатастрофы 
			'38_conference_comments' => array(
				'site_title' => 'Регион 38',
				'section_title' => 'Комментарии конференции 38.ru',
		    		'RegionID' => 38,
				'group' => 'conference',
			),
		'38.ru/accident' => array(
			'site_id' => 138, // 38.ru
	    		'site_title' => '38.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4290
		), // автокатастрофы v2
			'38.ru/gallery' => array('section_id' => 4292),
			
			'38_firms_comments' => array(
				'site_title' => 'Комментарии фирм 38.ru',
				'section_title' => 'Комментарии фирм 38.ru',
				'TreeID' => 3933,
				'group' => 'all_firms_comments',
			),
			
			'38_blogs' => array(
				'site_title' => 'Регион 38',
				'section_title' => 'Дневники 38.ru',
	    		'RegionID' => 38,
				'group' => 'blogs',
			),
			'38_group_article_comments' => array(
				'site_title' => 'Регион 38',
				'section_title' => 'Комментарии группы статей 38.ru',
		    		'RegionID' => 38,
				'group' => 'group_article',
			),
			'38_grab_news' => array(
				'site_title' => 'Регион 38',
				'section_title' => '38: Новости (грабленные)',
		    	'RegionID' => array(38),
				'group' => 'grab_news_magic',
			),
	    		'38.ru/grab_board' => array(
		    		'site_title' => '38.ru',
		    		'regid' => 38,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'38.ru/grab_hitech' => array(
		    		'site_title' => '38.ru',
		    		'regid' => 38,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		),
	    );

?>
