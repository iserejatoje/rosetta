<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'ekat.ru/forum_magic_pm' => array(
				'section_id' => 218,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'ekat.ru/love' => array(
	            'site_id' => 156,
                'site_title' => 'ekat.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_66',
	    		'photo_dir'	=> '/common_fs/i/sites/ekat.ru/love/photo/',
				'photo_url'	=> 'http://ekat.ru/i/love/photo/',
	    		),
			'ekat.ru/job' => array('section_id' => 1057),
			'ekat.ru/baraholka' => array('section_id' => 10358),
			'ekat.ru/lostfound' => array('section_id' => 11128),
			'ekat.ru/hitech' => array('section_id' => 10359),
			/*array(
				'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 66,
				),*/
			'ekat.ru/grab_job' => array(
				'site_id' => 156, // ekat.ru
	    			'site_title' => 'ekat.ru',
	    			'regid' => 66,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_66',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'ekat.ru/grab_job_resume' => array(
				'site_id' => 156, // ekat.ru
	    			'site_title' => 'ekat.ru',
	    			'regid' => 66,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_66',
					'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'ekat.ru/grab_job_vacancy' => array(
				'site_id' => 156, // ekat.ru
	    			'site_title' => 'ekat.ru',
	    			'regid' => 66,
	    			'group' => 'grab_rugion_job',
					'out_db' => 'region_66',
					'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'ekat.ru/sale' => array('section_id' => 1305),
//			'ekat.ru/rent' => array('section_id' => 1306),
//			'ekat.ru/commerce' => array('section_id' => 1308),
//			'ekat.ru/change' => array('section_id' => 1307),
			'ekat.ru/realty' => array(
				'section_id' => 10793,
			),

			'ekat.ru/grab_realty' => array(
		    		'site_title' => 'ekat.ru',
				'section_id' => 10793,
	    			'group' => 'grab_realty',
				),
			'ekat.ru/grab_rent' => array(
				'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
	    		'regid' => 66,
	    		'group' => 'grab_rugion_adv_rent',
	    		'db' => 'region_66',
				),
			'ekat.ru/grab_commerce' => array(
				'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
	    		'regid' => 66,
	    		'group' => 'grab_rugion_adv_commerce',
	    		'db' => 'region_66',
				),
                        'ekat.ru/grab_advertises' => array(
	                        'site_id' => 156, // ekat.ru
        	                'site_title' => 'ekat.ru',
	                        'regid' => 66,
        	                'group' => 'grab_rugion_car',
                	        //'db' => 'region_66',
                        ),

			/*'ekat.ru/firms' => array(
				'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 66,
				),*/
			'ekat.ru/firms' => array('section_id' => 3951),
			'ekat.ru/hadv' => array('section_id' => 277), // ekat.ru - Частные объявления 	    	
/*	    	'ekat.ru/advertises' => array(
	    		'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_66',
	    		), */
		    	'ekat.ru/car' => array('section_id' => 10998),
	    	'ekat.ru/catalog' => array('section_id' => 278), // ekat.ru - Каталог сайтов
		//'ekat.ru/accident' => array('section_id' => 4420), // автокатастрофы 
		'ekat.ru/accident' => array(
			'site_id' => 156, // ekat.ru
	    		'site_title' => 'ekat.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4420
		), // автокатастрофы v2
			'66_conference_comments' => array(
				'site_title' => 'Регион 66',
				'section_title' => 'Комментарии конференции ekat.ru',
		    		'RegionID' => 66,
				'group' => 'conference',
			),
		'ekat.ru/gallery' => array('section_id' => 4425),
		
		'ekat_firms_comments' => array(
				'site_title' => 'Комментарии фирм ekat.ru',
				'section_title' => 'Комментарии фирм ekat.ru',
				'TreeID' => 3951,
				'group' => 'all_firms_comments',
			),
		
		'ekat_blogs' => array(
				'site_title' => 'Регион 66',
				'section_title' => 'Дневники ekat.ru',
	    		'RegionID' => 66,
				'group' => 'blogs',
			),
			'ekat_group_article_comments' => array(
				'site_title' => 'Регион 66',
				'section_title' => 'Комментарии группы статей ekat.ru',
		    		'RegionID' => 66,
				'group' => 'group_article',
			),
			'66_grab_news' => array(
				'site_title' => 'Регион 66',
				'section_title' => '66: Новости (грабленные)',
		    	'RegionID' => array(66),
				'group' => 'grab_news_magic',
			),
	    		'ekat.ru/grab_board' => array(
		    		'site_title' => 'ekat.ru',
		    		'regid' => 66,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'ekat.ru/grab_hitech' => array(
		    		'site_title' => 'ekat.ru',
		    		'regid' => 66,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			)
	    );

?>
