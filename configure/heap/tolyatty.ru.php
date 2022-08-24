<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'tolyatty.ru/forum_magic_pm' => array(
				'section_id' => 4645,
				'params' => array('show_type' => array('moderate')),
			),
		
			// Форум предмодерация сообщений [E]
			
		        //'tolyatty.ru/accident' => array('section_id' => 4665),
			'tolyatty.ru/accident' => array(
				'site_id' => 4649, // tolyatty.ru
	    			'site_title' => 'tolyatty.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 4665
			), // автокатастрофы v2
			'tolyatty.ru/job' => array('section_id' => 4649),
/*			'tolyatty.ru/sale' => array('section_id' => 4650),
			'tolyatty.ru/rent' => array('section_id' => 4651),
			'tolyatty.ru/change' => array('section_id' => 4652),
			'tolyatty.ru/commerce' => array('section_id' => 4653),*/
			'tolyatty.ru/realty' => array(
				'section_id' => 10786,
			),
//			'tolyatty.ru/advertises' => array('section_id' => 4668),
		    	'tolyatty.ru/car' => array('section_id' => 11022),
			'tolyatty.ru/gallery' => array('section_id' => 4664),
			'tolyatty.ru/firms' => array('section_id' => 4669),
			'tolyatty.ru/love' => array('section_id' => 4655),
			'tolyatty.ru/baraholka' => array('section_id' => 10424),
			'tolyatty.ru/lostfound' => array('section_id' => 11120),
			'tolyatty.ru/hitech' => array('section_id' => 10425),
			'tolyatty.ru/grab_job' => array(
				'site_id' => 4649,
		    		'site_title' => 'tolyatty.ru',
		    		'regid' => 163,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'tolyatty',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'tolyatty.ru/grab_job_resume' => array(
				'site_id' => 4649,
		    		'site_title' => 'tolyatty.ru',
		    		'regid' => 163,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'tolyatty',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'tolyatty.ru/grab_job_vacancy' => array(
				'site_id' => 4649,
		    		'site_title' => 'tolyatty.ru',
		    		'regid' => 163,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'tolyatty',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'tolyatty.ru/grab_realty' => array(
		    		'site_title' => 'tolyatty.ru',
				'section_id' => 10786,
	    			'group' => 'grab_realty',
				),
			'tolyatty.ru/hadv' => array('section_id' => 4647), 
	    	'tolyatty.ru/advertises' => array(
	    		'site_id' => 4668, // tolyatty.ru
	    		'site_title' => 'tolyatty.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'tolyatty',
	    		),
	    	'tolyatty.ru/grab_advertises' => array(
	    		'site_id' => 4668, // tolyatty.ru
	    		'site_title' => 'tolyatty.ru',
	    		'regid' => 163,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'tolyatty',
	    		),
			'tolyatty.ru/forum-pm' => array(
					'section_id' => 4645
			),
			'163_conference_comments' => array(
				'site_title' => 'Регион 163',
				'section_title' => 'Комментарии конференции tolyatty.ru',
		    		'RegionID' => 163,
				'group' => 'conference',
			),
			'tolyatty_afisha_comments' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Комментарии афиши tolyatty.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4643, //(array)
				'group' => 'afisha_magic',
			),
			
			'tolyatty_firms_comments' => array(
				'site_title' => 'Комментарии фирм tolyatty.ru',
				'section_title' => 'Комментарии фирм tolyatty.ru',
				'TreeID' => 4669,
				'group' => 'all_firms_comments',
			),
			
			'tolyatty_blogs' => array(
				'site_title' => 'Регион 163',
				'section_title' => 'Дневники tolyatty.ru',
	    		'RegionID' => 163,
				'group' => 'blogs',
			),
			'tolyatty_group_article_comments' => array(
				'site_title' => 'Регион 163',
				'section_title' => 'Комментарии группы статей tolyatty.ru',
		    		'RegionID' => 163,
				'group' => 'group_article',
			),
	    		'tolyatty.ru/grab_board' => array(
		    		'site_title' => 'tolyatty.ru',
		    		'regid' => 163,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'tolyatty.ru/grab_hitech' => array(
		    		'site_title' => 'tolyatty.ru',
		    		'regid' => 163,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),

		)
	);
?>