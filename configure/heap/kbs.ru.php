<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'kbs.ru/forum_magic_pm' => array(
				'section_id' => 3177,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'yarsk1.ru/love' => array(
	            'site_id' => 421,
                'site_title' => 'yarsk1.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_24',
	    		'photo_dir'	=> '/common_fs/i/sites/yarsk1.ru/love/photo/',
				'photo_url'	=> 'http://yarsk1.ru/i/love/photo/',
	    		),
			'yarsk1.ru/job' => array('section_id' => 3182),
			/*array(
				'site_id' => 421, // yarsk1.ru
	    		'site_title' => 'yarsk1.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 24,
				),*/
			'yarsk1.ru/grab_job' => array(
				'site_id' => 106, // kbs.ru
				'out_db' => 'region_24',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
				),
	    		'site_title' => 'kbs.ru',
	    		'regid' => 24,
	    		'group' => 'grab_rugion_job',
				),
			'yarsk1.ru/grab_job_resume' => array(
				'site_id' => 106, // kbs.ru
				'out_db' => 'region_24',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
				),
	    		'site_title' => 'kbs.ru',
	    		'regid' => 24,
	    		'group' => 'grab_rugion_job',
				),
			'yarsk1.ru/grab_job_vacancy' => array(
				'site_id' => 106, // kbs.ru
				'out_db' => 'region_24',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
				),
	    		'site_title' => 'kbs.ru',
	    		'regid' => 24,
	    		'group' => 'grab_rugion_job',
				),
//			'124metra.ru/sale' => array('section_id' => 921),
//			'124metra.ru/rent' => array('section_id' => 922),
//			'124metra.ru/commerce' => array('section_id' => 923),
//			'124metra.ru/change' => array('section_id' => 924),
			'kbs.ru/realty' => array(
				'section_id' => 4586,
			),
			'kbs.ru/grab_realty' => array(
		    		'site_title' => '124metra.ru',
		    		'group' => 'grab_realty',
				'section_id' => 4586,
				), 
			/*'yarsk1.ru/firms' => array(
				'site_id' => 421, // yarsk1.ru
	    		'site_title' => 'yarsk1.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 24,
				),*/
			'kbs.ru/firms' => array('section_id' => 3971),
			'yarsk1.ru/hadv' => array('section_id' => 432), // yarsk1.ru - Частные объявления 	    	
//			'124km.ru/advertises' => array('section_id' => 912),
	    	'kbs.ru/car' => array('section_id' => 11009),
            '124km.ru/opinion' => array('section_id' => 913),
            //'124km.ru/accident' => array('section_id' => 910),
		'kbs.ru/accident' => array(
			'site_id' => 106, // kbs.ru
	    		'site_title' => 'kbs.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4095
		), // автокатастрофы v2
	    	'yarsk1.ru/catalog' => array('section_id' => 433), // yarsk1.ru - Каталог сайтов
		    'yarsk1.ru/grab_advertises' => array(
	    			'site_id' => 905, // 124km.ru
	    			'site_title' => '124km.ru',
		    		'regid' => 24,
		    		'group' => 'grab_rugion_car',
	    			//'db' => '124km',
	    	),
			'yarsk1.ru/forum-pm' => array(
				'section_id' => 430
			),
			'124banka.ru/forum-pm' => array(
				'section_id' => 891
			),
			'124filma.ru/forum-pm' => array(
				'section_id' => 928
			),
			'124km.ru/forum-pm' => array(
				'section_id' => 908
			),
			'124metra.ru/forum-pm' => array(
				'section_id' => 917
			),
			'kbs_afisha_comments' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Комментарии афиши kbs.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4634, //(array)
				'group' => 'afisha_magic',
			),
			'24_conference_comments' => array(
				'site_title' => 'Регион 24',
				'section_title' => 'Комментарии конференции kbs.ru',
		    		'RegionID' => 24,
				'group' => 'conference',
			),
	            '124filma.ru/gallery' => array('section_id' => 1007),
			
			'kbs_blogs' => array(
				'site_title' => 'Регион 24',
				'section_title' => 'Дневники kbs.ru',
	    		'RegionID' => 24,
				'group' => 'blogs',
			),

			'kbs.ru/baraholka' => array('section_id' => 10422),
			'kbs.ru/lostfound' => array('section_id' => 11103),
			'kbs.ru/hitech' => array('section_id' => 10423),
			'kbs_group_article_comments' => array(
				'site_title' => 'Регион 24',
				'section_title' => 'Комментарии группы статей kbs.ru',
		    		'RegionID' => 24,
				'group' => 'group_article',
			),
			
			'24_grab_news' => array(
				'site_title' => 'Регион 24',
				'section_title' => '24: Новости (грабленные)',
		    	'RegionID' => array(24),
				'group' => 'grab_news_magic',
			),
	    		'kbs.ru/grab_board' => array(
		    		'site_title' => 'kbs.ru',
		    		'regid' => 24,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'kbs.ru/grab_hitech' => array(
		    		'site_title' => 'kbs.ru',
		    		'regid' => 24,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);
?>