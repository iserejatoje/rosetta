<?

	return array(
	    'sections' => array (
			'72.ru/job' => array('section_id' => 1022),
			'72dengi.ru/atm' => array('section_id' => 10085),
			/*array(
				'site_id' => 151, // 72.ru
	    		'site_title' => '72.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 72,
				),*/
			'72.ru/baraholka' => array('section_id' => 10368),
			'72.ru/lostfound' => array('section_id' => 11132),
			'72.ru/hitech' => array('section_id' => 10369),
			'72avto.ru/rating' => array('section_id' => 10565),
			'72afisha.ru/rating' => array('section_id' => 10824),

			'72.ru/grab_job_new' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_new',
				'out_db' => 'region_72',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
			'72.ru/grab_job_v2' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_72',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
			
			'72_gallery' => array(
				'section_id' => 10450,
				'group' => 'gallery',
				'site_title' => 'Регион 72',
				'section_title' => 'Справочник горожанина 72.ru',
	    		'RegionID' => 72,
			),
			
			'72.ru/grab_job_new_resume' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_new',
				'out_db' => 'region_72',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
			'72.ru/grab_job_new_vacancy' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_new',
				'out_db' => 'region_72',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
			'72.ru/grab_job_v2_resume' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_72',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
			'72.ru/grab_job_v2_vacancy' => array(
				'site_id' => 151, // 72.ru
		    		'site_title' => '72.ru',
		    		'regid' => 72,
	    			'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_72',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
				),
			),
/*			'72doma.ru/sale' => array('section_id' => 997),
			'72doma.ru/rent' => array('section_id' => 998),
			'72doma.ru/commerce' => array('section_id' => 999),
			'72doma.ru/change' => array('section_id' => 1000),*/
			'72doma.ru/realty' => array(
				'section_id' => 10748,
			),

			'72doma.ru/grab_realty' => array(
					'section_id' => 10748,
		    			'site_title' => '72doma.ru',
			    		'group' => 'grab_realty',
				),
			'72.ru/firms' => array('section_id' => 3146),
			'72.ru/hadv' => array('section_id' => 292), // 72.ru - Частные объявления 	    	
			'72filma.ru/love' => array('section_id' => 881), //Знакомства
//			'72avto.ru/advertises' => array('section_id' => 958),
		    	'72avto.ru/car' => array('section_id' => 11051),
	    	'72.ru/grab_advertises' => array(
	    		'site_id' => 467, // 72avto.ru
	    		'site_title' => '72avto.ru',
	    		'regid' => 72,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '72avto',
	    		),
	    	'72.ru/catalog' => array('section_id' => 293), // 72.ru - Каталог сайтов
	    	//'72avto.ru/accident' => array('section_id' => 591), // автокатастрофы
		'72avto.ru/accident' => array(
			'site_id' => 467, // 72avto.ru
	    		'site_title' => '72avto.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 591
		), // автокатастрофы v2
	    	'72doctor.ru/firms' => array('section_id' => 3147), // Справочник фирм
	    	'72afisha.ru/gallery' => array('section_id' => 1060),
			'72.ru/forum-pm' => array(
				'section_id' => 213
			),
			'72afisha.ru/forum-pm' => array(
				'section_id' => 626
			),
			'72avto.ru/forum-pm' => array(
				'section_id' => 470
			),
			'72dengi.ru/forum-pm' => array(
				'section_id' => 448
			),
			'72doctor.ru/forum-pm' => array(
				'section_id' => 3136
			),
			'72doma.ru/forum-pm' => array(
				'section_id' => 485
			),
			'72_news_comments' => array(
				'site_title' => 'Регион 72',
				'section_title' => 'Комментарии новости 72.ru',
	    		'RegionID' => 72,
				'group' => 'news_magic',
			),	
			'72vechera_afisha_comments' => array(
				'site_title' => 'Регион 72',
				'section_title' => 'Комментарии афиши 72vechera.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 629, //(array)
				'group' => 'afisha_magic',
			),
			'72_conference_comments' => array(
				'site_title' => 'Регион 72',
				'section_title' => 'Комментарии конференции 72.ru',
		    		'RegionID' => 72,
				'group' => 'conference',
			),
						
			'72_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72.ru',
				'section_title' => 'Комментарии фирм 72.ru',
				'TreeID' => 3146,
				'group' => 'all_firms_comments',
			),
						
			'72avto_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72avto.ru',
				'section_title' => 'Комментарии фирм 72avto.ru',
				'TreeID' => 3425,
				'group' => 'all_firms_comments',
			),
			
			'72afisha_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72afisha.ru',
				'section_title' => 'Комментарии фирм 72afisha.ru',
				'TreeID' => 3426,
				'group' => 'all_firms_comments',
			),
			
			'72doma_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72doma.ru',
				'section_title' => 'Комментарии фирм 72doma.ru',
				'TreeID' => 3424,
				'group' => 'all_firms_comments',
			),
			
			'72doctor_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72doctor.ru',
				'section_title' => 'Комментарии фирм 72doctor.ru',
				'TreeID' => 3147,
				'group' => 'all_firms_comments',
			),
			
			'72dengi_firms_comments' => array(
				'site_title' => 'Комментарии фирм 72dengi.ru',
				'section_title' => 'Комментарии фирм 72dengi.ru',
				'TreeID' => 3423,
				'group' => 'all_firms_comments',
			),
			
			'72_blogs' => array(
				'site_title' => 'Регион 72',
				'section_title' => 'Дневники 72.ru',
	    		'RegionID' => 72,
				'group' => 'blogs',
			),
			'72_group_article_comments' => array(
				'site_title' => 'Регион 72',
				'section_title' => 'Комментарии группы статей 72.ru',
		    		'RegionID' => 72,
				'group' => 'group_article',
			),
			'72_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'72.ru/grab_board' => array(
		    		'site_title' => '72.ru',
		    		'regid' => 72,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'72.ru/grab_hitech' => array(
		    		'site_title' => '72.ru',
		    		'regid' => 72,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
