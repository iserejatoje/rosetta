<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'sochi1.ru/forum_magic_pm' => array(
				'section_id' => 1012,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
		
//			'93.ru/firms' => array(// сделать в виде модуля
//				'site_id' => 472, // 93.ru
//	    		'site_title' => '93.ru',
//	    		'section_title' => 'Справочник фирм',
//	    		'type' => 'firms',
//	    		'group' => 'rugion_firms',
//	    		'db' => 'rugion',
//	    		'regid' => 23,
//				),
//			'sochi1.ru/accident' => array('section_id' => 4541), // автокатастрофы 
			'sochi1.ru/accident' => array(
				'site_id' => 1009, // sochi1.ru
		    		'site_title' => 'sochi1.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 4541
			), // автокатастрофы v2
			'sochi1.ru/gallery' => array('section_id' => 4546),
			'sochi1.ru/job' => array('section_id' => 1011),
			'sochi1.ru/baraholka' => array('section_id' => 10412),
			'sochi1.ru/lostfound' => array('section_id' => 11139),
			'sochi1.ru/hitech' => array('section_id' => 10413),
//			'93.ru/catalog' => array('section_id' => 477),
/*		        'sochi1.ru/love' => array(
	            'site_id' => 1009,
                'site_title' => 'sochi1.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'sochi1',
	    		'photo_dir'	=> '/common_fs/i/sites/sochi1.ru/love/photo/',
				'photo_url'	=> 'http://sochi1.ru/i/love/photo/',
	    		), */
//			'sochi1.ru/love' => array('section_id' => 803),
//			'sochi1.ru/advertises' => array('section_id' => 1161),
		    	'sochi1.ru/car' => array('section_id' => 11013),
/*			'sochi1.ru/sale' => array('section_id' => 1162),
			'sochi1.ru/rent' => array('section_id' => 1163),
			'sochi1.ru/commerce' => array('section_id' => 1164),
			'sochi1.ru/change' => array('section_id' => 1165),*/
			'sochi1.ru/realty' => array(
				'section_id' => 4549,
			),
			'sochi1.ru/firms' => array('section_id' => 3957),
			'sochi1.ru/forum-pm' => array(
				'section_id' => 773
			),
			'sochi1.ru/forum-pm' => array(
				'section_id' => 1012
			),


// ======================
// для грабежа
// ======================
			'sochi1.ru/grab_job' => array(
				'site_id' => 1009, // sochi1.ru
	    			'site_title' => 'sochi1.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'sochi1',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'sochi1.ru/grab_job_resume' => array(
				'site_id' => 1009, // sochi1.ru
	    			'site_title' => 'sochi1.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'sochi1',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'sochi1.ru/grab_job_vacancy' => array(
				'site_id' => 1009, // sochi1.ru
	    			'site_title' => 'sochi1.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_job',
				'out_db' => 'sochi1',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'sochi1.ru/grab_realty' => array(
			    		'site_title' => 'sochi1.ru',
					'section_id' => 4549,
			    		'group' => 'grab_realty',
				),
			'193_conference_comments' => array(
				'site_title' => 'Регион 193',
				'section_title' => 'Комментарии конференции sochi1.ru',
		    		'RegionID' => 193,
				'group' => 'conference',
			),
		    'sochi1.ru/grab_advertises' => array(
	    		'site_id' => 1009, // sochi1.ru
	    		'site_title' => 'sochi1.ru',
	    		'regid' => 193,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'sochi1',
	    		),
			'sochi1_blogs' => array(
				'site_title' => 'Регион 193',
				'section_title' => 'Дневники 193.ru',
	    		'RegionID' => 193,
				'group' => 'blogs',
			),
			'sochi1_group_article_comments' => array(
				'site_title' => 'Регион 193',
				'section_title' => 'Комментарии группы статей sochi1.ru',
		    		'RegionID' => 193,
				'group' => 'group_article',
			),
	    		'sochi1.ru/grab_board' => array(
		    		'site_title' => 'sochi1.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'sochi1.ru/grab_hitech' => array(
		    		'site_title' => 'sochi1.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
			),
			
	    );

?>
