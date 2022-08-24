<?

	return array(
	    'sections' => array (
			'ufa1.ru/job' => array('section_id' => 1016),
			'102banka.ru/atm' => array('section_id' => 10773),
			//'ufa1.ru/job_v2' => array('section_id' => 10696),
			
			'ufa1_gallery' => array(
				'section_id' => 10447,
				'group' => 'gallery',
				'site_title' => 'Регион 02',
				'section_title' => 'Справочник горожанина ufa1.ru',
	    		'RegionID' => 2,
			),
			
			/*array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 2,
				),*/
/*			'102metra.ru/sale' => array('section_id' => 868),
			'102metra.ru/rent' => array('section_id' => 869),
			'102metra.ru/commerce' => array('section_id' => 870),
			'102metra.ru/change' => array('section_id' => 871),*/
			'102metra.ru/realty' => array(
				'section_id' => 10732,
			),
			'102filma.ru/love' => array('section_id' => 880),
			'ufa1.ru/firms' => array('section_id' => 942),
			'102doctora.ru/firms' => array('section_id' => 11029),
			'ufa1.ru/place' => array('section_id' => 4532),
			'102vechera.ru/gallery' => array('section_id' => 1050),
			'ufa1.ru/baraholka' => array('section_id' => 10408),
			'ufa1.ru/lostfound' => array('section_id' => 11100),
			'ufa1.ru/hitech' => array('section_id' => 10409),

			'102km.ru/rating' => array('section_id' => 10558),
			'102vechera.ru/rating' => array('section_id' => 10818),

			'ufa1.ru/place_simple' => array(
				'type' => 'place_simple',
				'site_id' => 472, // ufa1.ru
		    		'site_title' => 'Места',
	    			'regid' => 2,
	    		//'group' => 'place_simple',
			),
			/*'ufa1.ru/interest' => array(
				'type' => 'interest',
				'site_id' => 472, // ufa1.ru
		    		'site_title' => 'Интересы',
	    			'regid' => 2,
			),*/
			'ufa1.ru/interest_v2' => array(
				'type' => 'interest_v2',
				'site_id' => 472, // ufa1.ru
		    		'site_title' => 'Интересы',
	    			'regid' => 2,
			),
			'ufa1.ru/svoi' => array(
				'type' => 'svoi',
				'site_id' => 472, // ufa1.ru
				'site_title' => 'Социальная сеть',
	    			'regid' => 2,
			),
// ======================
// для грабежа
// ======================

			'ufa1.ru/grab_job_new' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_02',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'ufa1.ru/grab_job_v2' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_02',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
            'ufa1.ru/grab_job_v2' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_02',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'ufa1.ru/grab_job_new_resume' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_02',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
            'ufa1.ru/grab_job_v2_resume' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_02',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'ufa1.ru/grab_job_new_vacancy' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_02',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
            'ufa1.ru/grab_job_v2_vacancy' => array(
				'site_id' => 472, // ufa1.ru
	    		'site_title' => 'ufa1.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_02',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'102metra.ru/grab_realty' => array(
		    		'site_title' => '102metra.ru',
				'section_id' => 10732,
	    			'group' => 'grab_realty',
				),
			'ufa1.ru/hadv' => array('section_id' => 476), // ufa1.ru - Частные объявления 	    	
//	    	'102km.ru/advertises' => array('section_id' => 1072),
	    	'102km.ru/car' => array('section_id' => 9338),

	    	'102km.ru/grab_advertises' => array(
	    		'site_id' => 472, // ufa1.ru
	    		'site_title' => '102km.ru',
	    		'regid' => 2,
	    		'group' => 'grab_rugion_car',
	    		//'db' => '102km',
	    		),
	    	'ufa1.ru/catalog' => array('section_id' => 477), // ufa1.ru - Каталог сайтов
			//'102km.ru/accident' => array('section_id' => 639), // автокатастрофы 
			'102km.ru/accident' => array(
				'site_id' => 633, // 14.ru
		    		'site_title' => '102km.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 639
			), // автокатастрофы v2
			'ufa1.ru/forum-pm' => array(
				'section_id' => 11499,11475,11476,11477,11478,11510,11515//474,
			),
			'102banka.ru/forum-pm' => array(
				'section_id' => 11475//651,
			),
			'102km.ru/forum-pm' => array(
				'section_id' => 637,
			),
			'102metra.ru/forum-pm' => array(
				'section_id' => 682,
			),
			'102vechera.ru/forum-pm' => array(
				'section_id' => 641,
			),
			'ufa1.ru/forum-alert' => array('section_id' => 474),
			
			'ufa1_news_comments' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Комментарии новости ufa.ru',
	    		'RegionID' => 2,
				'group' => 'news_magic',
			),
			'2_conference_comments' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Комментарии конференции ufa1.ru',
		    		'RegionID' => 2,
				'group' => 'conference',
			),	
			'102vechera_afisha_comments' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Комментарии афиши 102vechera.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 644, //(array)
				'group' => 'afisha_magic',
			),
			
			'ufa1_blogs' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Дневники ufa1.ru',
	    		'RegionID' => 2,
				'group' => 'blogs',
			),
			
			'ufa1_firms_comments' => array(
				'site_title' => 'Комментарии фирм ufa1.ru',
				'section_title' => 'Комментарии фирм ufa1.ru',
				'TreeID' => 942,
				'group' => 'all_firms_comments',
			),
						
			'102metra_firms_comments' => array(
				'site_title' => 'Комментарии фирм 102metra.ru',
				'section_title' => 'Комментарии фирм 102metra.ru',
				'TreeID' => 1533,
				'group' => 'all_firms_comments',
			),
			
			'102km_firms_comments' => array(
				'site_title' => 'Комментарии фирм 102km.ru',
				'section_title' => 'Комментарии фирм 102km.ru',
				'TreeID' => 1522,
				'group' => 'all_firms_comments',
			),
			
			'102vechera_firms_comments' => array(
				'site_title' => 'Комментарии фирм 102vechera.ru',
				'section_title' => 'Комментарии фирм 102vechera.ru',
				'TreeID' => 1524,
				'group' => 'all_firms_comments',
			),
			
			'102banka_firms_comments' => array(
				'site_title' => 'Комментарии фирм 102banka.ru',
				'section_title' => 'Комментарии фирм 102banka.ru',
				'TreeID' => 1527,
				'group' => 'all_firms_comments',
			),
			'102doctora_firms_comments' => array(
				'site_title' => 'Комментарии фирм 102doctora.ru',
				'section_title' => 'Комментарии фирм 102doctora.ru',
				'TreeID' => 11029,
				'group' => 'all_firms_comments',
			),
			'ufa1_group_article_comments' => array(
				'site_title' => 'Регион 02',
				'section_title' => 'Комментарии группы статей ufa1.ru',
		    		'RegionID' => 2,
				'group' => 'group_article',
			),
			'ufa1_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'ufa1.ru/grab_board' => array(
		    		'site_title' => 'ufa1.ru',
		    		'regid' => 2,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'ufa1.ru/grab_hitech' => array(
		    		'site_title' => 'ufa1.ru',
		    		'regid' => 2,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
