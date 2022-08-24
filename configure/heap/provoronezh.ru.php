<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'provoronezh.ru/forum_magic_pm' => array(
				'section_id' => 4905,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			'provoronezh.ru/job' => array('section_id' => 4909),
/*			'provoronezh.ru/sale' => array('section_id' => 4910),
			'provoronezh.ru/rent' => array('section_id' => 4911),
			'provoronezh.ru/change' => array('section_id' => 4912),
			'provoronezh.ru/commerce' => array('section_id' => 4913),*/
			'provoronezh.ru/realty' => array(
				'section_id' => 10733,
			),
//			'provoronezh.ru/advertises' => array('section_id' => 4928),
		    	'provoronezh.ru/car' => array('section_id' => 10976),
			'provoronezh.ru/love' => array('section_id' => 4915),
			'provoronezh.ru/baraholka' => array('section_id' => 10426),
			'provoronezh.ru/lostfound' => array('section_id' => 11108),
			'provoronezh.ru/hitech' => array('section_id' => 10427),
			'provoronezh.ru/accident' => array(
				'site_id' => 4901, 
	    			'site_title' => 'provoronezh.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 4925
			), // автокатастрофы v2
			'provoronezh.ru/grab_job' => array(
				'site_id' => 4901, // provoronezh.ru
		    		'site_title' => 'provoronezh.ru',
		    		'regid' => 36,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'provoronezh',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'provoronezh.ru/grab_job_resume' => array(
				'site_id' => 4901, // provoronezh.ru
		    		'site_title' => 'provoronezh.ru',
		    		'regid' => 36,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'provoronezh',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'provoronezh.ru/grab_job_vacancy' => array(
				'site_id' => 4901, // provoronezh.ru
		    		'site_title' => 'provoronezh.ru',
		    		'regid' => 36,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'provoronezh',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'provoronezh.ru/grab_realty' => array(
		    		'site_title' => 'provoronezh.ru',
				'section_id' => 10733,
		    		'group' => 'grab_realty',
				),
	    	'provoronezh.ru/grab_advertises' => array(
	    		'site_id' => 4901, // provoronezh.ru
	    		'site_title' => 'provoronezh.ru',
	    		'regid' => 36,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'provoronezh',
	    		),
			'provoronezh.ru/forum-pm' => array(
				'section_id' => 4905
			),
			'36_conference_comments' => array(
				'site_title' => 'Регион 36',
				'section_title' => 'Комментарии конференции provoronezh.ru',
		    		'RegionID' => 36,
				'group' => 'conference',
			),
			'provoronezh_afisha_comments' => array(
				'site_title' => 'Регион 36',
				'section_title' => 'Комментарии афиши provoronezh.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4903, //(array)
				'group' => 'afisha_magic',
			),
			'provoronezh_blogs' => array(
				'site_title' => 'Регион 36',
				'section_title' => 'Дневники provoronezh.ru',
	    		'RegionID' => 36,
				'group' => 'blogs',
			),
			'provoronezh_group_article_comments' => array(
				'site_title' => 'Регион 36',
				'section_title' => 'Комментарии группы статей provoronezh.ru',
		    		'RegionID' => 36,
				'group' => 'group_article',
			),
			'36_grab_news' => array(
				'site_title' => 'Регион 36',
				'section_title' => '36: Новости (грабленные)',
		    	'RegionID' => array(36),
				'group' => 'grab_news_magic',
			),
	    		'provoronezh.ru/grab_board' => array(
		    		'site_title' => 'provoronezh.ru',
		    		'regid' => 36,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'provoronezh.ru/grab_hitech' => array(
		    		'site_title' => 'provoronezh.ru',
		    		'regid' => 36,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	    );

?>
