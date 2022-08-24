<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'sterlitamak1.ru/forum_magic_pm' => array(
				'section_id' => 9961,
				'params' => array('show_type' => array('moderate')),
			),
		
			'74_news_comments' => array(
				'site_title' => 'Регион 74',
				'section_title' => 'Комментарии новости 74.ru',
		    		//'RegionID' => 74, //(array)
					'SiteID' => array(1,9,13,18,23,26,31,35,245,397,3974,10522),
				//'SectionID' => , (array)
				'group' => 'news_magic',
			),
			
			'sterlitamak1_news_comments' => array(
				'site_title' => 'Регион 102',
				'section_title' => 'Комментарии новости sterlitamak1.ru',
	    		'RegionID' => 102,
				'group' => 'news_magic',
			),
		
			// Форум предмодерация сообщений [E]
		
		        //'sterlitamak1.ru/accident' => array('section_id' => 4665),
			'sterlitamak1.ru/accident' => array(
				'site_id' => 9960, // sterlitamak1.ru
	    			'site_title' => 'sterlitamak1.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 9967
			), // автокатастрофы v2
			'sterlitamak1.ru/job' => array('section_id' => 9960),
/*			'sterlitamak1.ru/sale' => array('section_id' => 9973),
			'sterlitamak1.ru/rent' => array('section_id' => 9974),
			'sterlitamak1.ru/change' => array('section_id' => 9987),
			'sterlitamak1.ru/commerce' => array('section_id' => 9988),*/
			'sterlitamak1.ru/realty' => array(
				'section_id' => 10731,
			),
//			'sterlitamak1.ru/advertises' => array('section_id' => 9966),
		    	'sterlitamak1.ru/car' => array('section_id' => 11018),
			'sterlitamak1.ru/gallery' => array('section_id' => 9970),			
			'sterlitamak1.ru/firms' => array('section_id' => 9941),
			'sterlitamak1.ru/baraholka' => array('section_id' => 10428),
			'sterlitamak1.ru/lostfound' => array('section_id' => 11119),
			'sterlitamak1.ru/hitech' => array('section_id' => 10429),
			//'sterlitamak1.ru/firms' => array('section_id' => 9981),
			'sterlitamak1.ru/love' => array('section_id' => 9971),
			'sterlitamak1.ru/grab_job' => array(
				'site_id' => 9960,
		    		'site_title' => 'sterlitamak1.ru',
		    		'regid' => 102,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'sterlitamak1',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'sterlitamak1.ru/grab_job_resume' => array(
				'site_id' => 9960,
		    		'site_title' => 'sterlitamak1.ru',
		    		'regid' => 102,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'sterlitamak1',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'sterlitamak1.ru/grab_job_vacancy' => array(
				'site_id' => 9960,
		    		'site_title' => 'sterlitamak1.ru',
		    		'regid' => 102,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'sterlitamak1',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
			),
			'sterlitamak1.ru/grab_realty' => array(
		    		'site_title' => 'sterlitamak1.ru',
		    		'group' => 'grab_realty',
				'section_id' => 10731,
				),
			'sterlitamak1.ru/hadv' => array('section_id' => 9991), 
	    	'sterlitamak1.ru/advertises' => array(
	    		'site_id' => 9966, // sterlitamak1.ru
	    		'site_title' => 'sterlitamak1.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'sterlitamak1',
	    		),
	    	'sterlitamak1.ru/grab_advertises' => array(
	    		'site_id' => 9966, // sterlitamak1.ru
	    		'site_title' => 'sterlitamak1.ru',
	    		'regid' => 102,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'sterlitamak1',
	    		),
			'sterlitamak1.ru/forum-pm' => array(
					'section_id' => 9961
			),
			'102_conference_comments' => array(
				'site_title' => 'Регион 102',
				'section_title' => 'Комментарии конференции sterlitamak1.ru',
		    		'RegionID' => 102,
				'group' => 'conference',
			),
			'sterlitamak1_afisha_comments' => array(
				'site_title' => 'Регион 102',
				'section_title' => 'Комментарии афиши sterlitamak1.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 9986, //(array)
				'group' => 'afisha_magic',
			),
			'sterlitamak1_firms_comments' => array(
				'site_title' => 'Комментарии фирм',
				'section_title' => 'Комментарии фирм',
				'TreeID' => 9941,
				'group' => 'all_firms_comments',
			),
			'sterlitamak1_blogs' => array(
				'site_title' => 'Регион 102',
				'section_title' => 'Дневники sterlitamak1.ru',
	    		'RegionID' => 102,
				'group' => 'blogs',
			),

			'sterlitamak1_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest sterlitamak1.ru',
				'section_title' => 'Комментарии конкурса contest sterlitamak1.ru',
				'group' => 'all_contest_comments',
			),

			'sterlitamak1_group_article_comments' => array(
				'site_title' => 'Регион 102',
				'section_title' => 'Комментарии группы статей sterlitamak1.ru',
		    		'RegionID' => 102,
				'group' => 'group_article',
			),

	    		'sterlitamak1.ru/grab_board' => array(
		    		'site_title' => 'sterlitamak1.ru',
		    		'regid' => 102,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'sterlitamak1.ru/grab_hitech' => array(
		    		'site_title' => 'sterlitamak1.ru',
		    		'regid' => 102,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);
?>