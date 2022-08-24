<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'26.ru/forum_magic_pm' => array(
				'section_id' => 197,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'26.ru/lostfound' => array('section_id' => 11104),
			'26.ru/love' => array('section_id' => 800),
			'26.ru/job' => array('section_id' => 794),
			'26.ru/grab_job' => array(
				'site_id' => 135, // 26.ru
		    		'site_title' => '26.ru',
		    		'regid' => 26,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_26',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'26.ru/grab_job_resume' => array(
				'site_id' => 135, // 26.ru
		    		'site_title' => '26.ru',
		    		'regid' => 26,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_26',
					'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'26.ru/grab_job_vacancy' => array(
				'site_id' => 135, // 26.ru
		    		'site_title' => '26.ru',
		    		'regid' => 26,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_26',
					'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'26.ru/baraholka' => array('section_id' => 10400),
			'26.ru/hitech' => array('section_id' => 10401),
//			'26.ru/sale' => array('section_id' => 1205),
//			'26.ru/rent' => array('section_id' => 1206),
//			'26.ru/commerce' => array('section_id' => 1208),
//			'26.ru/change' => array('section_id' => 1207),
			'26.ru/realty' => array(
				'section_id' => 10787,
			),
			'26.ru/grab_realty' => array(
		    		'site_title' => '26.ru',
				'section_id' => 10787,
		    		'group' => 'grab_realty',
				),
			/*'26.ru/firms' => array(
				'site_id' => 135, // 26.ru
	    		'site_title' => '26.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 26,
				),*/
			'26.ru/firms' => array('section_id' => 3895),
			'26.ru/hadv' => array('section_id' => 340), // 26.ru - Частные объявления 	    	
/*	    	'26.ru/advertises' => array(
	    		'site_id' => 135, // 26.ru
	    		'site_title' => '26.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_26',
	    		),*/
	    	'26.ru/car' => array('section_id' => 10991),
		        //'26.ru/accident' => array('section_id' => 4208),
		'26.ru/accident' => array(
			'site_id' => 135, // 26.ru
	    		'site_title' => '26.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4208
		), // автокатастрофы v2
	    	'26.ru/grab_advertises' => array(
	    		'site_id' => 135, // 26.ru
	    		'site_title' => '26.ru',
	    		'regid' => 26,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_26',
	    	),
			'26_conference_comments' => array(
				'site_title' => 'Регион 26',
				'section_title' => 'Комментарии конференции 26.ru',
		    		'RegionID' => 26,
				'group' => 'conference',
			),
	    	'26.ru/catalog' => array('section_id' => 341), // 26.ru - Каталог сайтов
			'26.ru/gallery' => array('section_id' => 4211),
			
			'26_firms_comments' => array(
				'site_title' => 'Комментарии фирм 26.ru',
				'section_title' => 'Комментарии фирм 26.ru',
				'TreeID' => 3895,
				'group' => 'all_firms_comments',
			),
			
			'26_blogs' => array(
				'site_title' => 'Регион 26',
				'section_title' => 'Дневники 26.ru',
	    		'RegionID' => 26,
				'group' => 'blogs',
			),
			'26_group_article_comments' => array(
				'site_title' => 'Регион 26',
				'section_title' => 'Комментарии группы статей 26.ru',
		    		'RegionID' => 26,
				'group' => 'group_article',
			),
			'26_grab_news' => array(
				'site_title' => 'Регион 26',
				'section_title' => '26: Новости (грабленные)',
		    	'RegionID' => array(26),
				'group' => 'grab_news_magic',
			),
	    		'26.ru/grab_board' => array(
		    		'site_title' => '26.ru',
		    		'regid' => 26,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'26.ru/grab_hitech' => array(
		    		'site_title' => '26.ru',
		    		'regid' => 26,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		),
	    );

?>
