<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'mgorsk.ru/forum_magic_pm' => array(
				'section_id' => 4273,
				'params' => array('show_type' => array('moderate')),
			),
		
			// Форум предмодерация сообщений [E]
		
		        //'mgorsk.ru/accident' => array('section_id' => 4253),
			'mgorsk.ru/accident' => array(
				'site_id' => 4253, // mgorsk.ru
		    		'site_title' => 'mgorsk.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 4253
			), // автокатастрофы v2
			'mgorsk.ru/job' => array('section_id' => 4269),
/*			'mgorsk.ru/sale' => array('section_id' => 4268),
			'mgorsk.ru/rent' => array('section_id' => 4267),
			'mgorsk.ru/change' => array('section_id' => 4266),
			'mgorsk.ru/commerce' => array('section_id' => 4265),*/
			'mgorsk.ru/realty' => array(
				'section_id' => 10736,
			),
//			'mgorsk.ru/advertises' => array('section_id' => 4250),
		    	'mgorsk.ru/car' => array('section_id' => 11019),
			'mgorsk.ru/gallery' => array('section_id' => 4254),
			'mgorsk.ru/firms' => array('section_id' => 4249),
			'mgorsk.ru/love' => array('section_id' => 4263),
			'mgorsk.ru/baraholka' => array('section_id' => 10416),
			'mgorsk.ru/lostfound' => array('section_id' => 11121),
			'mgorsk.ru/sales' => array('section_id' => 10550),
			'mgorks.ru/hitech' => array('section_id' => 10417),
			'mgorsk.ru/grab_job' => array(
				'site_id' => 4235,
		    		'site_title' => 'mgorsk.ru',
		    		'regid' => 174,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'mgorsk',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'mgorsk.ru/grab_job_resume' => array(
				'site_id' => 4235,
		    		'site_title' => 'mgorsk.ru',
		    		'regid' => 174,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'mgorsk',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'mgorsk.ru/grab_job_vacancy' => array(
				'site_id' => 4235,
		    		'site_title' => 'mgorsk.ru',
		    		'regid' => 174,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'mgorsk',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'mgorsk.ru/grab_realty' => array(
				'section_id' => 10736,
		    		'site_title' => 'mgorsk.ru',
		    		'group' => 'grab_realty',
				),
			'mgorsk.ru/hadv' => array('section_id' => 4271), 
	    	/*'mgorsk.ru/advertises' => array(
	    		'site_id' => 4235, // mgorsk.ru
	    		'site_title' => 'mgorsk.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'mgorsk',
	    		),*/
		
		'mgorsk.ru/advertises' => array('section_id' => 4250),
	    	'mgorsk.ru/grab_advertises' => array(
	    		'site_id' => 4235, // mgorsk.ru
	    		'site_title' => 'mgorsk.ru',
	    		'regid' => 174,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'mgorsk',
	    		),
			'mgorsk.ru/forum-pm' => array(
					'section_id' => 4273
			),
			'174_conference_comments' => array(
				'site_title' => 'Регион 174',
				'section_title' => 'Комментарии конференции mgorsk.ru',
		    		'RegionID' => 174,
				'group' => 'conference',
			),
			'mgorsk_afisha_comments' => array(
				'site_title' => 'Регион 74',
				'section_title' => 'Комментарии афиши mgorsk.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4316, //(array)
				'group' => 'afisha_magic',
			),
			
			'mgorsk_firms_comments' => array(
				'site_title' => 'Комментарии фирм mgorsk.ru',
				'section_title' => 'Комментарии фирм mgorsk.ru',
				'TreeID' => 4249,
				'group' => '74_firms_comments',
			),
			
			'mgorsk_blogs' => array(
				'site_title' => 'Регион 174',
				'section_title' => 'Дневники mgorsk.ru',
	    		'RegionID' => 174,
				'group' => 'blogs',
			),
/*
			'mgorsk_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest mgorsk.ru',
				'section_title' => 'Комментарии конкурса contest mgorsk.ru',
				'group' => 'all_contest_comments',
			),
*/
			'mgorsk_group_article_comments' => array(
				'site_title' => 'Регион 174',
				'section_title' => 'Комментарии группы статей mgorsk.ru',
		    		'RegionID' => 174,
				'group' => 'group_article',
			),
			'mgorsk_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'mgorks.ru/grab_board' => array(
		    		'site_title' => 'mgorsk.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'mgorsk.ru/grab_hitech' => array(
		    		'site_title' => 'mgorsk.ru',
		    		'regid' => 193,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);
?>