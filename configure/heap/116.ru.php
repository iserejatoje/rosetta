<?

	return array(
	    'sections' => array (		

			'kazan1.ru/job' => array('section_id' => 1019),
			
			// Что это?! о.О
			//'chelyabinsk.ru/conference' => array('section_id' => 4687),

			/*array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 16,
				),*/
//			'116metrov.ru/sale' => array('section_id' => 937),
//			'116metrov.ru/rent' => array('section_id' => 938),
//			'116metrov.ru/commerce' => array('section_id' => 939),
//			'116metrov.ru/change' => array('section_id' => 940),
			'116metrov.ru/realty' => array(
				'section_id' => 10806,
			),
			'116.ru/firms' => array('section_id' => 4011),
			'116doctor.ru/firms' => array('section_id' => 6257),
//			'116vecherov.ru/gallery' => array('section_id' => 1049),
			'116.ru/baraholka' => array('section_id' => 10402),
			'116.ru/lostfound' => array('section_id' => 11102),
			'116.ru/hitech' => array('section_id' => 10403),

			'116auto.ru/rating' => array('section_id' => 10560),
			'116vecherov.ru/rating' => array('section_id' => 10819),
			
			'116_gallery' => array(
				'section_id' => 10449,
				'group' => 'gallery',
				'site_title' => 'Регион 16',
				'section_title' => 'Справочник горожанина 116.ru',
	    		'RegionID' => 16,
			),
/*
			так делать не надо. надо указать только один справочник региона, дабы информация не дублировалась многократно.
			'116vecherov.ru/firms' => array('section_id' => 612),
			'116dengi.ru/firms' => array('section_id' => 665),
			'116auto.ru/firms' => array('section_id' => 899),
			'116metrov.ru/firms' => array('section_id' => 936),
*/
// ======================
// для грабежа
// ======================

			'kazan1.ru/grab_job_new' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_16',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'kazan1.ru/grab_job_v2' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_16',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'kazan1.ru/grab_job_new_resume' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_16',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'kazan1.ru/grab_job_new_vacancy' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_16',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'kazan1.ru/grab_job_v2_resume' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_16',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'kazan1.ru/grab_job_v2_vacancy' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'regid' => 16,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_16',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
				),
			'116metrov.ru/grab_realty' => array(
		    			'site_title' => '116metrov.ru',
					'section_id' => 10806,
			    		'group' => 'grab_realty',
				),
			'kazan1.ru/firms' => array(
				'site_id' => 345, // kazan1.ru
	    		'site_title' => 'kazan1.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 16,
				),
			'kazan1.ru/hadv' => array('section_id' => 353), // kazan1.ru - Частные объявления 	    	
			'116vecherov.ru/love' => array('section_id' => 882), //Знакомства
//		        '116auto.ru/advertises' => array('section_id' => 947),
		    	'116auto.ru/car' => array('section_id' => 11047),
		        '116auto.ru/opinion' => array('section_id' => 948),
		        //'116auto.ru/accident' => array('section_id' => 590),
			'116auto.ru/accident' => array(
				'site_id' => 345, // kazan1.ru
	    			'site_title' => '116auto.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 590
			), // автокатастрофы v2
		    	'116auto.ru/grab_advertises' => array(
	    			'site_id' => 345, // kazan1.ru
	    			'site_title' => '116auto.ru',
		    		'regid' => 16,
		    		'group' => 'grab_rugion_car',
	    			//'db' => '116auto',
	    		),
	    	'kazan1.ru/catalog' => array('section_id' => 354), // kazan1.ru - Каталог сайтов
			'kazan1.ru/forum-pm' => array(
				'section_id' => 11479//351
			),
			'116auto.ru/forum-pm' => array(
				'section_id' => 11507//586
			),
			'116dengi.ru/forum-pm' => array(
				'section_id' => 11480//666
			),
			'116metrov.ru/forum-pm' => array(
				'section_id' => 11481//570
			),
			'116vecherov.ru/forum-pm' => array(
				'section_id' => 11482//604
			),
			'116_news_comments' => array(
				'site_title' => 'Регион 16',
				'section_title' => 'Комментарии новости 116.ru',
	    		'RegionID' => 16,
				'group' => 'news_magic',
			),	
			'116vecherov_afisha_comments' => array(
				'site_title' => 'Регион 16',
				'section_title' => 'Комментарии афиши 116vecherov.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 610, //(array)
				'group' => 'afisha_magic',
			),
			'16_conference_comments' => array(
				'site_title' => 'Регион 16',
				'section_title' => 'Комментарии конференции 116.ru',
		    		'RegionID' => 16,
				'group' => 'conference',
			),
						
			'116_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116.ru',
				'section_title' => 'Комментарии фирм 116.ru',
				'TreeID' => 4011,
				'group' => 'all_firms_comments',
			),
						
			'116vecherov_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116vecherov.ru',
				'section_title' => 'Комментарии фирм 116vecherov.ru',
				'TreeID' => 612,
				'group' => 'all_firms_comments',
			),
			
			'116dengi_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116dengi.ru',
				'section_title' => 'Комментарии фирм 116dengi.ru',
				'TreeID' => 665,
				'group' => 'all_firms_comments',
			),
			
			'116metrov_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116metrov.ru',
				'section_title' => 'Комментарии фирм 116metrov.ru',
				'TreeID' => 936,
				'group' => 'all_firms_comments',
			),
			
			'116auto_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116auto.ru',
				'section_title' => 'Комментарии фирм 116auto.ru',
				'TreeID' => 899,
				'group' => 'all_firms_comments',
			),
			
			'116doctor_firms_comments' => array(
				'site_title' => 'Комментарии фирм 116doctor.ru',
				'section_title' => 'Комментарии фирм 116doctor.ru',
				'TreeID' => 6257,
				'group' => 'all_firms_comments',
			),
			
			'116_blogs' => array(
				'site_title' => 'Регион 16',
				'section_title' => 'Дневники 116.ru',
	    		'RegionID' => 16,
				'group' => 'blogs',
			),
/*
			'116_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest 116 регион (Казань)',
				'section_title' => 'Комментарии конкурса contest 116 регион (Казань)',
				'group' => 'all_contest_comments',
			),
*/
			'116_group_article_comments' => array(
				'site_title' => 'Регион 16',
				'section_title' => 'Комментарии группы статей 116.ru',
		    		'RegionID' => 16,
				'group' => 'group_article',
			),
	    		'116.ru/grab_board' => array(
		    		'site_title' => '16.ru',
		    		'regid' => 16,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'116.ru/grab_hitech' => array(
		    		'site_title' => '16.ru',
		    		'regid' => 16,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
