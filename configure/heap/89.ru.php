<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'89.ru/forum_magic_pm' => array(
				'section_id' => 217,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'89.ru/love' => array(
	            'site_id' => 155,
                'site_title' => '89.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_89',
	    		'photo_dir'	=> '/common_fs/i/sites/89.ru/love/photo/',
				'photo_url'	=> 'http://89.ru/i/love/photo/',
	    		),
			'89.ru/job' => array('section_id' => 1063),
			'89.ru/baraholka' => array('section_id' => 10360),
			'89.ru/lostfound' => array('section_id' => 11137),
			'89.ru/hitech' => array('section_id' => 10361),
			/*array(
				'site_id' => 155, // 89.ru
	    		'site_title' => '89.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 89,
				),*/
			'89.ru/grab_job' => array(
				'site_id' => 155, // 89.ru
		    		'site_title' => '89.ru',
				'regid' => 89,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_89',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'89.ru/grab_job_resume' => array(
				'site_id' => 155, // 89.ru
		    		'site_title' => '89.ru',
				'regid' => 89,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_89',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'89.ru/grab_job_vacancy' => array(
				'site_id' => 155, // 89.ru
		    		'site_title' => '89.ru',
				'regid' => 89,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_89',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
/*			'89.ru/sale' => array('section_id' => 1300),
			'89.ru/rent' => array('section_id' => 1301),
			'89.ru/commerce' => array('section_id' => 1303),
			'89.ru/change' => array('section_id' => 1302),*/
			'89.ru/realty' => array(
				'section_id' => 10734,
			),

			'89.ru/grab_realty' => array(
				'section_id' => 10734,
		    		'site_title' => '89.ru',
		    		'group' => 'grab_realty',
				),
			/*'89.ru/firms' => array(
				'site_id' => 155, // 89.ru
	    		'site_title' => '89.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 89,
				),*/
			'89.ru/firms' => array('section_id' => 3955),
			'89.ru/hadv' => array('section_id' => 280), // 89.ru - Частные объявления 	    	
/*	    	'89.ru/advertises' => array(
	    		'site_id' => 155, // 89.ru
	    		'site_title' => '89.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'region_89',
	    		), */
	    	'89.ru/car' => array('section_id' => 10988),
	    	'89.ru/grab_advertises' => array(
	    		'site_id' => 155, //89.ru
	    		'site_title' => '89.ru',
	    		'regid' => 89,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_89',
	    		),
	    	'89.ru/catalog' => array('section_id' => 281), // 89.ru - Каталог сайтов
		'89.ru/forum-pm' => array('section_id' => 217),
	        //'89.ru/accident' => array('section_id' => 4175),
		'89.ru/accident' => array(
			'site_id' => 155, // 89.ru
	    		'site_title' => '89.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4175
		), // автокатастрофы v2
			'89_conference_comments' => array(
				'site_title' => 'Регион 89',
				'section_title' => 'Комментарии конференции 89.ru',
		    		'RegionID' => 89,
				'group' => 'conference',
			),
		'89.ru/gallery' => array('section_id' => 4174),
		
		'89_firms_comments' => array(
				'site_title' => 'Комментарии фирм 89.ru',
				'section_title' => 'Комментарии фирм 89.ru',
				'TreeID' => 3955,
				'group' => 'all_firms_comments',
			),
			
			'89_blogs' => array(
				'site_title' => 'Регион 89',
				'section_title' => 'Дневники 89.ru',
	    		'RegionID' => 89,
				'group' => 'blogs',
			),
			'89_group_article_comments' => array(
				'site_title' => 'Регион 89',
				'section_title' => 'Комментарии группы статей 89.ru',
		    		'RegionID' => 89,
				'group' => 'group_article',
			),
		
			)
	    );

?>
