<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'93.ru/forum_magic_pm' => array(
				'section_id' => 773,
				'params' => array('show_type' => array('moderate')),
			),
			
			// Форум предмодерация сообщений [E]
			
			/*'93.ru/firms' => array(// сделать в виде модуля
				'site_id' => 472, // 93.ru
	    		'site_title' => '93.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 23,
				),*/
			'93.ru/firms' => array('section_id' => 3956),
			'93.ru/job' => array('section_id' => 802),
			'93.ru/hadv' => array('section_id' => 476),
			'93.ru/catalog' => array('section_id' => 477),
			'93filma.ru/love' => array('section_id' => 803),
			'93filma.ru/gallery' => array('section_id' => 1061),
//			'93avto.ru/advertise' => array('section_id' => 799),
		    	'93.ru/car' => array('section_id' => 11014),
			'93avto.ru/opinion' => array('section_id' => 808),
			//'93avto.ru/accident' => array('section_id' => 772),
			'93.ru/accident' => array(
				'site_id' => 472, // 14.ru
		    		'site_title' => '93.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 4079
			), // автокатастрофы v2
/*			'93metra.ru/sale' => array('section_id' => 804),
			'93metra.ru/rent' => array('section_id' => 805),
			'93metra.ru/commerce' => array('section_id' => 806),
			'93metra.ru/change' => array('section_id' => 807),*/
			'93.ru/realty' => array(
				'section_id' => 10739,
			),
			'93.ru/baraholka' => array('section_id' => 10414),
			'93.ru/lostfound' => array('section_id' => 11138),
			'93.ru/hitech' => array('section_id' => 10415),

// ======================
// для грабежа
// ======================
			'93.ru/grab_job' => array(
				'site_id' => 472, // 93.ru
		    		'site_title' => '93.ru',
		    		'regid' => 93,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_23',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'93.ru/grab_job_resume' => array(
				'site_id' => 472, // 93.ru
		    		'site_title' => '93.ru',
		    		'regid' => 93,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_23',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'93.ru/grab_job_vacancy' => array(
				'site_id' => 472, // 93.ru
		    		'site_title' => '93.ru',
		    		'regid' => 93,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_23',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
		   			'j_resume' => 'job_v2_resume',
					),
				),
			'93.ru/grab_realty' => array(
		    		'site_title' => '93.ru',
				'section_id' => 10739,
		    		'group' => 'grab_realty',
				),
	    	'93avto.ru/grab_advertises' => array(
	    		'site_id' => 472, // 93.ru
	    		'site_title' => '93.ru',
	    		'regid' => 93,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '93avto',
	    		),
			'93.ru/forum-pm' => array(
				'section_id' => 773
			),
			'93avto.ru/forum-pm' => array(
				'section_id' => 766
			),
			'93banka.ru/forum-pm' => array(
				'section_id' => 781
			),
			'93filma.ru/forum-pm' => array(
				'section_id' => 748
			),
			'93metra.ru/forum-pm' => array(
				'section_id' => 739
			),
			'93_afisha_comments' => array(
				'site_title' => 'Регион 93',
				'section_title' => 'Комментарии афиши 93.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 4633, //(array)
				'group' => 'afisha_magic',
			),
			'93_conference_comments' => array(
				'site_title' => 'Регион 93',
				'section_title' => 'Комментарии конференции 93.ru',
		    		'RegionID' => 93,
				'group' => 'conference',
			),
			
			'93_firms_comments' => array(
				'site_title' => 'Комментарии фирм 93.ru',
				'section_title' => 'Комментарии фирм 93.ru',
				'TreeID' => 3956,
				'group' => 'all_firms_comments',
			),
			
			'93_blogs' => array(
				'site_title' => 'Регион 93',
				'section_title' => 'Дневники 93.ru',
	    		'RegionID' => 93,
				'group' => 'blogs',
			),
			'93_group_article_comments' => array(
				'site_title' => 'Регион 93',
				'section_title' => 'Комментарии группы статей 93.ru',
		    		'RegionID' => 93,
				'group' => 'group_article',
			),
			'93_grab_news' => array(
				'site_title' => 'Регион 93',
				'section_title' => '93: Новости (грабленные)',
		    	'RegionID' => array(93),
				'group' => 'grab_news_magic',
			),
	    		'93.ru/grab_board' => array(
		    		'site_title' => '93.ru',
		    		'regid' => 93,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'93.ru/grab_hitech' => array(
		    		'site_title' => '93.ru',
		    		'regid' => 93,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
