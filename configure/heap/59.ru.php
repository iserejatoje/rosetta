<?

	return array(
	    'sections' => array (
			'59.ru/job' => array('section_id' => 1018),
			'dengi59.ru/atm' => array('section_id' => 10815),
			/*array(
				'site_id' => 85, // 59.ru
	    		'site_title' => '59.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 59,
				),*/
			/*'59.ru/firms' => array(
				'site_id' => 85, // 59.ru
	    		'site_title' => '59.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 59,
				),*/
			'59.ru/baraholka' => array('section_id' => 10433),
			'59.ru/lostfound' => array('section_id' => 11122),
			'59.ru/hitech' => array('section_id' => 10434),
			'59.ru/firms' => array('section_id' => 3151),
			'kvartira59.ru/firms' => array('section_id' => 355),
			'doctor59.ru/firms' => array('section_id' => 521),
			'kapital59.ru/firms' => array('section_id' => 659),
			'dengi59.ru/firms' => array('section_id' => 925),
			'avto59.ru/firms' => array('section_id' => 941),
			'afisha59.ru/firms' => array('section_id' => 946),
			'afisha59.ru/gallery' => array('section_id' => 1064),
			'avto59.ru/rating' => array('section_id' => 10562),
			'afisha59.ru/rating' => array('section_id' => 10822),

/*	    	'avto59.ru/advertises' => array(
	    		'site_id' => 156, // avto59.ru
	    		'site_title' => 'avto59.ru',
	    		'section_title' => 'Авто объявления',
	    		'type' => 'auto_advertise',
	    		'group' => 'rugion_auto',
	    		'db' => 'avto59',
	    		),  */
		    	'avto59.ru/car' => array('section_id' => 11049),
				
			'59_gallery' => array(
				'section_id' => 10451,
				'group' => 'gallery',
				'site_title' => 'Регион 59',
				'section_title' => 'Справочник горожанина 59.ru',
	    		'RegionID' => 59,
			),
				
			
			'59.ru/grab_job_new' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_59',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'59.ru/grab_job_v2' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_59',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'59.ru/grab_job_new_resume' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_59',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'59.ru/grab_job_new_vacancy' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_59',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'59.ru/grab_job_v2_resume' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_59',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'59.ru/grab_job_v2_vacancy' => array(
				'site_id' => 488, // 59.ru
	    		'site_title' => '59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_59',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			
	    	'avto59.ru/grab_advertises' => array(
	    		'site_id' => 156, // avto59.ru
	    		'site_title' => 'avto59.ru',
	    		'regid' => 59,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'avto59',
	    		),
/*			'kvartira59.ru/sale' => array('section_id' => 976),
			'kvartira59.ru/rent' => array('section_id' => 977),
			'kvartira59.ru/commerce' => array('section_id' => 978),
			'kvartira59.ru/change' => array('section_id' => 979),*/
			'kvartira59.ru/realty' => array(
				'section_id' => 10770,
			),

			'kvartira59.ru/grab_realty' => array(
		    		'site_title' => 'kvartira59.ru',
	    			'group' => 'grab_realty',
				'section_id' => 10770,
				),
			'kvartira59.ru/tender' => array(
				'site_id' => 119, 
	    			'site_title' => 'kvartira59.ru',
	    			'section_title' => 'Тендеры',
	    			'type' => 'tender',
	    			'group' => 'rugion_tender_59',
	    			'db' => 'kvartira59'
				),
			//'avto59.ru/accident' => array('section_id' => 592), // автокатастрофы
			'avto59.ru/accident' => array(
				'site_id' => 156, // avto59.ru
		    		'site_title' => 'avto59.ru',
    				'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 592
			), // автокатастрофы v2
			'59.ru/forum-pm' => array(
				'section_id' => 188
			),
			'afisha59.ru/forum-pm' => array(
				'section_id' => 368
			),
			'avto59.ru/forum-pm' => array(
				'section_id' => 193
			),
			'dengi59.ru/forum-pm' => array(
				'section_id' => 357
			),
			'doctor59.ru/forum-pm' => array(
				'section_id' => 518
			),
			'kapital59.ru/forum-pm' => array(
				'section_id' => 654
			),
			'kvartira59.ru/forum-pm' => array(
				'section_id' => 195
			),
			
			'59_conference_comments' => array(
				'site_title' => 'Регион 59',
				'section_title' => 'Комментарии конференции 59.ru',
		    		'RegionID' => 59,
				'group' => 'conference',
			),
			'59_news_comments' => array(
				'site_title' => 'Регион 59',
				'section_title' => 'Комментарии новости 59.ru',
	    		'RegionID' => 59,
				'group' => 'news_magic',
			),	
			'afisha59_afisha_comments' => array(
				'site_title' => 'Регион 59',
				'section_title' => 'Комментарии афиши afisha59.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 532, //(array)
				'group' => 'afisha_magic',
			),
			
			
			'59_firms_comments' => array(
				'site_title' => 'Комментарии фирм 59.ru',
				'section_title' => 'Комментарии фирм 59.ru',
				'TreeID' => 3151,
				'group' => 'all_firms_comments',
			),
						
			'kvartira59_firms_comments' => array(
				'site_title' => 'Комментарии фирм kvartira59.ru',
				'section_title' => 'Комментарии фирм kvartira59.ru',
				'TreeID' => 355,
				'group' => 'all_firms_comments',
			),
			
			'doctor59_firms_comments' => array(
				'site_title' => 'Комментарии фирм doctor59.ru',
				'section_title' => 'Комментарии фирм doctor59.ru',
				'TreeID' => 521,
				'group' => 'all_firms_comments',
			),
			
			'kapital59_firms_comments' => array(
				'site_title' => 'Комментарии фирм kapital59.ru',
				'section_title' => 'Комментарии фирм kapital59.ru',
				'TreeID' => 659,
				'group' => 'all_firms_comments',
			),
			
			'dengi59_firms_comments' => array(
				'site_title' => 'Комментарии фирм dengi59.ru',
				'section_title' => 'Комментарии фирм dengi59.ru',
				'TreeID' => 925,
				'group' => 'all_firms_comments',
			),
			
			'avto59_firms_comments' => array(
				'site_title' => 'Комментарии фирм avto59.ru',
				'section_title' => 'Комментарии фирм avto59.ru',
				'TreeID' => 941,
				'group' => 'all_firms_comments',
			),
			
			'afisha59_firms_comments' => array(
				'site_title' => 'Комментарии фирм afisha59.ru',
				'section_title' => 'Комментарии фирм afisha59.ru',
				'TreeID' => 946,
				'group' => 'all_firms_comments',
			),
			
			'59_blogs' => array(
				'site_title' => 'Регион 59',
				'section_title' => 'Дневники 59.ru',
	    		'RegionID' => 59,
				'group' => 'blogs',
			),

			'59_group_article_comments' => array(
				'site_title' => 'Регион 59',
				'section_title' => 'Комментарии группы статей 59.ru',
		    		'RegionID' => 59,
				'group' => 'group_article',
			),
			'59_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest',
				'section_title' => 'Комментарии конкурса contest',
				'group' => 'all_contest_comments',
			),
	    		'59.ru/grab_board' => array(
		    		'site_title' => '59.ru',
		    		'regid' => 59,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'59.ru/grab_hitech' => array(
		    		'site_title' => '59.ru',
		    		'regid' => 59,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
