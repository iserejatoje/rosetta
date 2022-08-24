<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'154.ru/forum_magic_pm' => array(
				'section_id' => 3899,
				'params' => array('show_type' => array('moderate')),
			),
			
			'154_news_comments' => array(
				'site_title' => 'Регион 54',
				'section_title' => 'Комментарии новости 154.ru',
		    		'RegionID' => 54, //(array)
				//'SiteID' => , (array)
				//'SectionID' => , (array)
				'group' => 'news_magic',
			),
			
			// Форум предмодерация сообщений [E]

			'154.ru/job' => array('section_id' => 3904),
//			'154.ru/accident' => array('section_id' => 3920), // автокатастрофы 
	  		'154.ru/accident' => array(
				'site_id' => 3897, // 154.ru
		    		'site_title' => '154.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 3920
			), // автокатастрофы v2
			'154.ru/baraholka' => array('section_id' => 10418),
			'154.ru/lostfound' => array('section_id' => 11116),
			'154.ru/hitech' => array('section_id' => 10419),

// ======================
// для грабежа
// ======================
			'154.ru/grab_job' => array(
				'site_id' => 3897, // 154.ru
	    		'site_title' => '154.ru',
		    	'regid' => 54,
		    	'group' => 'grab_rugion_job',
				'out_db' => 'region_54',
				'tables' => array(
		          	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
				),
			),
			'154.ru/grab_job_resume' => array(
				'site_id' => 3897, // 154.ru
	    		'site_title' => '154.ru',
		    	'regid' => 54,
		    	'group' => 'grab_rugion_job',
				'out_db' => 'region_54',
				'show' => 'resume',
				'tables' => array(
		          	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
				),
			),
			'154.ru/grab_job_vacancy' => array(
				'site_id' => 3897, // 154.ru
	    		'site_title' => '154.ru',
		    	'regid' => 54,
		    	'group' => 'grab_rugion_job',
				'out_db' => 'region_54',
				'show' => 'vacancy',
				'tables' => array(
		          	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
				),
			),
			'154.ru/forum-pm' => array(
				'section_id' => 3899,
			),
/*			'154.ru/sale' => array('section_id' => 3905),
			'154.ru/rent' => array('section_id' => 3906),
			'154.ru/commerce' => array('section_id' => 3908),
			'154.ru/change' => array('section_id' => 3907),*/
			'154.ru/realty' => array(
				'section_id' => 10742,
			),
			'154.ru/grab_realty' => array(
		    		'site_title' => '154.ru',
	    			'group' => 'grab_realty',
				'section_id' => 10742,
				),
//	    	'154.ru/advertises' => array('section_id' => 3923),
	    	'154.ru/car' => array('section_id' => 10975),
	    	'154.ru/gallery' => array('section_id' => 3919),
	    	'154.ru/grab_advertises' => array(
	    		'site_id' => 3897, // 154.ru
	    		'site_title' => '154.ru',
	    		'regid' => 54,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_54',
	    		),
			'54_conference_comments' => array(
				'site_title' => 'Регион 54',
				'section_title' => 'Комментарии конференции 154.ru',
		    		'RegionID' => 54,
				'group' => 'conference',
			),
			'154.ru/firms' => array('section_id' => 3924),
			
			'154_firms_comments' => array(
				'site_title' => 'Комментарии фирм 154.ru',
				'section_title' => 'Комментарии фирм 154.ru',
				'TreeID' => 3924,
				'group' => 'all_firms_comments',
			),			

			'154_blogs' => array(
				'site_title' => 'Регион 154',
				'section_title' => 'Дневники 154.ru',
	    		'RegionID' => 154,
				'group' => 'blogs',
			),
			'154_group_article_comments' => array(
				'site_title' => 'Регион 54',
				'section_title' => 'Комментарии группы статей 154.ru',
		    		'RegionID' => 54,
				'group' => 'group_article',
			),
			'54_grab_news' => array(
				'site_title' => 'Регион 54',
				'section_title' => '54: Новости (грабленные)',
		    	'RegionID' => array(54),
				'group' => 'grab_news_magic',
			),

	    		'154.ru/grab_board' => array(
		    		'site_title' => '54.ru',
		    		'regid' => 54,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'154.ru/grab_hitech' => array(
		    		'site_title' => '54.ru',
		    		'regid' => 54,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);
?>