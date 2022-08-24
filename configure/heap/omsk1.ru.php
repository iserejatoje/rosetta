<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'omsk1.ru/forum_magic_pm' => array(
				'section_id' => 424,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'omsk1.ru/love' => array(
	            'site_id' => 420,
                'site_title' => 'omsk1.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_55',
	    		'photo_dir'	=> '/common_fs/i/sites/omsk1.ru/love/photo/',
				'photo_url'	=> 'http://omsk1.ru/i/love/photo/',
	    		),
			'omsk1.ru/job' => array('section_id' => 1046),
//			'55metrov.ru/sale' => array('section_id' => 1191),
//			'55metrov.ru/rent' => array('section_id' => 1192),
//			'55metrov.ru/commerce' => array('section_id' => 1193),
//			'55metrov.ru/change' => array('section_id' => 1194),
			'omsk1.ru/realty' => array(
				'section_id' => 10802,
			),
			'55filmov.ru/gallery' => array('section_id' => 1055),
			'55.ru/baraholka' => array('section_id' => 10404),
			'omsk1.ru/lostfound' => array('section_id' => 11117),
			'55.ru/hitech' => array('section_id' => 10404),
			/*array(
				'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 55,
				),*/
			'omsk1.ru/grab_job' => array(
				'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
	    		'regid' => 55,
	    		'group' => 'grab_rugion_job',
				'out_db' => 'region_55',
				'tables' => array(
				   'j_vacancy' => 'job_v2_vacancy',
				   'j_resume' => 'job_v2_resume',
					),
				),
			'omsk1.ru/grab_job_resume' => array(
				'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
	    		'regid' => 55,
	    		'group' => 'grab_rugion_job',
				'out_db' => 'region_55',
				'show' => 'resume',
				'tables' => array(
				   'j_vacancy' => 'job_v2_vacancy',
				   'j_resume' => 'job_v2_resume',
					),
				),
			'omsk1.ru/grab_job_vacancy' => array(
				'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
	    		'regid' => 55,
	    		'group' => 'grab_rugion_job',
				'out_db' => 'region_55',
				'show' => 'vacancy',
				'tables' => array(
				   'j_vacancy' => 'job_v2_vacancy',
				   'j_resume' => 'job_v2_resume',
					),
				),
			'omsk1.ru/grab_realty' => array(
		    		'site_title' => 'omsk1.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10802,
				),
			/*'omsk1.ru/firms' => array(
				'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 55,
				),*/
			'omsk1.ru/firms' => array('section_id' => 3970),
			'omsk1.ru/hadv' => array('section_id' => 426), // omsk1.ru - Частные объявления 	    	
//			'55auto.ru/advertises' => array('section_id' => 1195),
	    	'omsk1.ru/car' => array('section_id' => 11001),
	    	'55auto.ru/grab_advertises' => array(
	    		'site_id' => 858, // 55auto.ru
	    		'site_title' => '55auto.ru',
	    		'regid' => 55,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '55auto',
	    		),
	    	'omsk1.ru/catalog' => array('section_id' => 427), // omsk1.ru - Каталог сайтов
			'omsk1.ru/forum-pm' => array(
				'section_id' => 424
			),
			'55auto.ru/forum-pm' => array(
				'section_id' => 861
			),
			'55bankov.ru/forum-pm' => array(
				'section_id' => 846
			),
			'55filmov.ru/forum-pm' => array(
				'section_id' => 852
			),
			'55metrov.ru/forum-pm' => array(
				'section_id' => 837
			),
			'55_conference_comments' => array(
				'site_title' => 'Регион 55',
				'section_title' => 'Комментарии конференции omsk1.ru',
		    		'RegionID' => 55,
				'group' => 'conference',
			),
		'omsk1.ru/accident' => array(
			'site_id' => 420, // omsk1.ru
	    		'site_title' => 'omsk1.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4112
		), // автокатастрофы v2
		
		'omsk1_firms_comments' => array(
				'site_title' => 'Комментарии фирм omsk1.ru',
				'section_title' => 'Комментарии фирм omsk1.ru',
				'TreeID' => 3970,
				'group' => 'all_firms_comments',
			),
			
			'omsk1_blogs' => array(
				'site_title' => 'Регион 55',
				'section_title' => 'Дневники omsk1.ru',
	    		'RegionID' => 55,
				'group' => 'blogs',
			),
			'omsk1_group_article_comments' => array(
				'site_title' => 'Регион 55',
				'section_title' => 'Комментарии группы статей omsk1.ru',
		    		'RegionID' => 55,
				'group' => 'group_article',
			),
			'55_grab_news' => array(
				'site_title' => 'Регион 55',
				'section_title' => '55: Новости (грабленные)',
		    	'RegionID' => array(55),
				'group' => 'grab_news_magic',
			),
	    		'omsk1.ru/grab_board' => array(
		    		'site_title' => 'omsk1.ru',
		    		'regid' => 55,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'omsk1.ru/grab_hitech' => array(
		    		'site_title' => 'omsk.ru',
		    		'regid' => 55,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
