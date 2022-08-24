<?

	return array(
	    'sections' => array (

//			'34metra.ru/sale' => array('section_id' => 872),
//			'34metra.ru/rent' => array('section_id' => 873),
//			'34metra.ru/commerce' => array('section_id' => 874),
//			'34metra.ru/change' => array('section_id' => 875),
			'34metra.ru/realty' => array(
				'section_id' => 10805,
			),
			/*'volgograd1.ru/firms' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 34,
			),*/
			'v1.ru/lostfound' => array('section_id' => 11106),
	    	'volgograd1.ru/firms' => array('section_id' => 1147),			
			'v1.ru/firms' => array('section_id' => 1147),			
		'34doctora.ru/firms' => array('section_id' => 11038),
	    	/*'34banka.ru/firms' => array('section_id' => 692),
	    	'34metra.ru/firms' => array('section_id' => 705),
	    	'34filma.ru/firms' => array('section_id' => 719),*/
	    	'34vechera.ru/gallery' => array('section_id' => 1054),
	    	/*'34auto.ru/firms' => array('section_id' => 767),*/
			'34filma.ru/love' => array('section_id' => 867),
			'volgograd1.ru/job' => array('section_id' => 866),
			'volgograd1.ru/hadv' => array('section_id' => 494), // volgograd1.ru - Частные объявления 	    	
//            '34auto.ru/advertise' => array('section_id' => 864),
		    	'34auto.ru/car' => array('section_id' => 11050),
            '34auto.ru/opinion' => array('section_id' => 865),
			'34auto.ru/rating' => array('section_id' => 10561),

            //'34auto.ru/accident' => array('section_id' => 770),
		'34auto.ru/accident' => array(
			'site_id' => 755, // 14.ru
	    		'site_title' => '34auto.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 770
		), // автокатастрофы v2
	    	'volgograd1.ru/catalog' => array('section_id' => 495),

			'v1_gallery' => array(
				'section_id' => 10448,
				'group' => 'gallery',
				'site_title' => 'Регион 34',
				'section_title' => 'Справочник горожанина v1.ru',
	    		'RegionID' => 34,
			),
		
			'volgograd1.ru/grab_job_new' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_34',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'volgograd1.ru/grab_job_v2' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_34',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'volgograd1.ru/grab_job_new_resume' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_34',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'volgograd1.ru/grab_job_new_vacancy' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_34',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'volgograd1.ru/grab_job_v2_resume' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_34',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'volgograd1.ru/grab_job_v2_vacancy' => array(
				'site_id' => 488, // volgograd1.ru
	    		'site_title' => 'volgograd1.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_34',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'34metra.ru/grab_realty' => array(
				'section_id' => 10805,
		    		'site_title' => '34metra.ru',
	    			'group' => 'grab_realty',
			),
	    	'34auto.ru/grab_advertises' => array(
	    		'site_id' => 755, // 34auto.ru
	    		'site_title' => '34auto.ru',
	    		'regid' => 34,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '34auto',
    		),
			'volgograd1.ru/forum-pm' => array(
				'section_id' => 492
			),
			'34auto.ru/forum-pm' => array(
				'section_id' => 764
			),
			'34banka.ru/forum-pm' => array(
				'section_id' => 691
			),
			'34filma.ru/forum-pm' => array(
				'section_id' => 714
			),
			'34metra.ru/forum-pm' => array(
				'section_id' => 703
			),
			'v1_news_comments' => array(
				'site_title' => 'Регион 34',
				'section_title' => 'Комментарии новости v1.ru',
		    		'RegionID' => 34,
				'group' => 'news_magic',
			),	
			'34vechera_afisha_comments' => array(
				'site_title' => 'Регион 34',
				'section_title' => 'Комментарии афиши 34vechera.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 717, //(array)
				'group' => 'afisha_magic',
			),
			'34_conference_comments' => array(
				'site_title' => 'Регион 34',
				'section_title' => 'Комментарии конференции v1.ru',
		    		'RegionID' => 34,
				'group' => 'conference',
			),
			
			'v1_firms_comments' => array(
				'site_title' => 'Комментарии фирм v1.ru',
				'section_title' => 'Комментарии фирм v1.ru',
				'TreeID' => 1147,
				'group' => 'all_firms_comments',
			),
						
			'34vechera_firms_comments' => array(
				'site_title' => 'Комментарии фирм 34vechera.ru',
				'section_title' => 'Комментарии фирм 34vechera.ru',
				'TreeID' => 719,
				'group' => 'all_firms_comments',
			),
			
			'34banka_firms_comments' => array(
				'site_title' => 'Комментарии фирм 34banka.ru',
				'section_title' => 'Комментарии фирм 34banka.ru',
				'TreeID' => 692,
				'group' => 'all_firms_comments',
			),
			
			'34auto_firms_comments' => array(
				'site_title' => 'Комментарии фирм 34auto.ru',
				'section_title' => 'Комментарии фирм 34auto.ru',
				'TreeID' => 767,
				'group' => 'all_firms_comments',
			),
			
			'34metra_firms_comments' => array(
				'site_title' => 'Комментарии фирм 34metra.ru',
				'section_title' => 'Комментарии фирм 34metra.ru',
				'TreeID' => 705,
				'group' => 'all_firms_comments',
			),
			'34doctora_firms_comments' => array(
				'site_title' => 'Комментарии фирм 34doctora.ru',
				'section_title' => 'Комментарии фирм 34doctora.ru',
				'TreeID' => 11038,
				'group' => 'all_firms_comments',
			),
			
			'v1_blogs' => array(
				'site_title' => 'Регион 34',
				'section_title' => 'Дневники v1.ru',
	    		'RegionID' => 34,
				'group' => 'blogs',
			),
			'v1.ru/baraholka' => array('section_id' => 10410),
			'v1.ru/hitech' => array('section_id' => 10411),
			'v1_group_article_comments' => array(
				'site_title' => 'Регион 34',
				'section_title' => 'Комментарии группы статей v1.ru',
		    		'RegionID' => 34,
				'group' => 'group_article',
			),
			'v1_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'v1.ru/grab_board' => array(
		    		'site_title' => 'v1.ru',
		    		'regid' => 34,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'v1.ru/grab_hitech' => array(
		    		'site_title' => 'v1.ru',
		    		'regid' => 34,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
