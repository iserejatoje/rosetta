<?

	return array(
	    'sections' => array (
			'161.ru/job' => array('section_id' => 1023),
			'161.ru/baraholka' => array('section_id' => 10406),
			'161.ru/lostfound' => array('section_id' => 11124),
			'161.ru/hitech' => array('section_id' => 10407),

			'161auto.ru/rating' => array('section_id' => 10563),
			'161vecher.ru/rating' => array('section_id' => 10820),

			/*array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 61,
				),*/
			'161.ru/grab_job_new' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_61',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'161.ru/grab_job_v2' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_61',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),

			'161_gallery' => array(
				'section_id' => 10446,
				'group' => 'gallery',
				'site_title' => 'Регион 61',
				'section_title' => 'Справочник горожанина 161.ru',
	    		'RegionID' => 61,
			),

			'161.ru/grab_job_new_resume' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_61',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
            '161.ru/grab_job_v2_resume' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_61',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'161.ru/grab_job_new_vacancy' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_61',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
            '161.ru/grab_job_v2_vacancy' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'regid' => 61,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_61',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'161film.ru/love' => array('section_id' => 883), # Знакомства
			'161vecher.ru/gallery' => array('section_id' => 1051), # Галереи
/*			'161metr.ru/sale' => array('section_id' => 876),
			'161metr.ru/rent' => array('section_id' => 877),
			'161metr.ru/commerce' => array('section_id' => 878),
			'161metr.ru/change' => array('section_id' => 879),*/
			'161metr.ru/realty' => array(
				'section_id' => 10747,
			),

//		        '161auto.ru/advertise' => array('section_id' => 884),
		    	'161auto.ru/car' => array('section_id' => 11031),
		        '161auto.ru/opinion' => array('section_id' => 885),
		        //'161auto.ru/accident' => array('section_id' => 771),
		'161auto.ru/accident' => array(
			'site_id' => 576, // 14.ru
	    		'site_title' => '161auto.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 771
		), // автокатастрофы v2
//	        '161bank.ru/firms' => array('section_id' => 699),
//	        '161film.ru/firms' => array('section_id' => 726),
//	        '161metr.ru/firms' => array('section_id' => 731),
//	        '161auto.ru/firms' => array('section_id' => 768),
			'161metr.ru/grab_realty' => array(
		    		'site_title' => '161metr.ru',
				'section_id' => 10747,
		    		'group' => 'grab_realty',
				),
			/*'161.ru/firms' => array(
				'site_id' => 422, // 161.ru
	    		'site_title' => '161.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 61,
				),*/
			'161.ru/firms' => array('section_id' => 4136),
			'161.ru/hadv' => array('section_id' => 438), // 161.ru - Частные объявления 	    	
		    	'161auto.ru/grab_advertises' => array(
		    		'site_id' => 756, // 161auto.ru
		    		'site_title' => '161auto.ru',
		    		'regid' => 61,
		    		'group' => 'grab_rugion_car',
		    		//'db' => '161auto',
	    		),
	    	'161.ru/catalog' => array('section_id' => 439), // 161.ru - Каталог сайтов
			'161.ru/forum-pm' => array('section_id' => 436),
			'161auto.ru/forum-pm' => array(
				'section_id' => 765
			),
			'161bank.ru/forum-pm' => array(
				'section_id' => 698
			),
			'161film.ru/forum-pm' => array(
				'section_id' => 721
			),
			'161metr.ru/forum-pm' => array(
				'section_id' => 729
			),
			
			'161_news_comments' => array(
				'site_title' => 'Регион 61',
				'section_title' => 'Комментарии новости 161.ru',
	    		'RegionID' => 61,
				'group' => 'news_magic',
			),	
			'61_conference_comments' => array(
				'site_title' => 'Регион 61',
				'section_title' => 'Комментарии конференции 161.ru',
		    		'RegionID' => 61,
				'group' => 'conference',
			),	
			'161vecher_afisha_comments' => array(
				'site_title' => 'Регион 61',
				'section_title' => 'Комментарии афиши 161vecher.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 724, //(array)
				'group' => 'afisha_magic',
			),
			
			'161_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161.ru',
				'section_title' => 'Комментарии фирм 161.ru',
				'TreeID' => 4136,
				'group' => 'all_firms_comments',
			),
						
			'161bank_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161bank.ru',
				'section_title' => 'Комментарии фирм 161bank.ru',
				'TreeID' => 699,
				'group' => 'all_firms_comments',
			),
			
			'161vecher_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161vecher.ru',
				'section_title' => 'Комментарии фирм 161vecher.ru',
				'TreeID' => 726,
				'group' => 'all_firms_comments',
			),
			
			'161metr_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161metr.ru',
				'section_title' => 'Комментарии фирм 161metr.ru',
				'TreeID' => 731,
				'group' => 'all_firms_comments',
			),
			
			'161auto_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161auto.ru',
				'section_title' => 'Комментарии фирм 161auto.ru',
				'TreeID' => 768,
				'group' => 'all_firms_comments',
			),
			
			'161doctor_firms_comments' => array(
				'site_title' => 'Комментарии фирм 161doctor.ru',
				'section_title' => 'Комментарии фирм 161doctor.ru',
				'TreeID' => 6861,
				'group' => 'all_firms_comments',
			),
			
			'161_blogs' => array(
				'site_title' => 'Регион 61',
				'section_title' => 'Дневники 161.ru',
	    		'RegionID' => 61,
				'group' => 'blogs',
			),
			'161_group_article_comments' => array(
				'site_title' => 'Регион 61',
				'section_title' => 'Комментарии группы статей 161.ru',
		    		'RegionID' => 61,
				'group' => 'group_article',
			),
			'161_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'161.ru/grab_board' => array(
		    		'site_title' => '61.ru',
		    		'regid' => 61,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'161.ru/grab_hitech' => array(
		    		'site_title' => '61.ru',
		    		'regid' => 61,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
