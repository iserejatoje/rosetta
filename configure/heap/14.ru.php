<?

	return array(
	    'sections' => array (
			// Форум предмодерация сообщений [B]
			
			'14.ru/forum_magic_pm' => array(
				'section_id' => 196,
				'params' => array('show_type' => array('moderate')),
			),
		
			// Форум предмодерация сообщений [E]
		
	        '14.ru/love' => array(
	            'site_id' => 134,
                'site_title' => '14.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'love',
	    		'group' => 'rugion_love',
	    		'db' => 'region_14',
	    		'photo_dir'	=> '/common_fs/i/sites/14.ru/love/photo/',
				'photo_url'	=> 'http://14.ru/i/love/photo/',
	    		),
			'14.ru/job' => array('section_id' => 661), 
			'14.ru/baraholka' => array('section_id' => 10356),
			'14.ru/lostfound' => array('section_id' => 11101),
			'14.ru/hitech' => array('section_id' => 10357),
	    		/*array(
				'site_id' => 134, // 14.ru
	    		'site_title' => '14.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 14,
				),*/
			'14.ru/grab_job' => array(
				'site_id' => 134, // 14.ru
		    		'site_title' => '14.ru',
		    		'regid' => 14,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_14',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'14.ru/grab_job_resume' => array(
				'site_id' => 134, // 14.ru
		    		'site_title' => '14.ru',
		    		'regid' => 14,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_14',
				'show' => 'resume',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
			'14.ru/grab_job_vacancy' => array(
				'site_id' => 134, // 14.ru
		    		'site_title' => '14.ru',
		    		'regid' => 14,
	    			'group' => 'grab_rugion_job',
				'out_db' => 'region_14',
				'show' => 'vacancy',
				'tables' => array(
					'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_v2_resume',
					),
				),
//			'14.ru/sale' => array('section_id' => 1200),
//			'14.ru/rent' => array('section_id' => 1201),
//			'14.ru/commerce' => array('section_id' => 1203),
//			'14.ru/change' => array('section_id' => 1202),
			'14.ru/realty' => array(
				'section_id' => 10790,
			),
			'14.ru/grab_realty' => array(
		    			'site_title' => '14.ru',
					'section_id' => 10790,
			    		'group' => 'grab_realty',
				),
			'14.ru/grab_rent' => array(
				'site_id' => 134, // 14.ru
	    		'site_title' => '14.ru',
	    		'regid' => 14,
	    		'group' => 'grab_rugion_adv_rent',
	    		'db' => 'region_14',
				),
			'14.ru/grab_commerce' => array(
				'site_id' => 134, // 14.ru
	    		'site_title' => '14.ru',
	    		'regid' => 14,
	    		'group' => 'grab_rugion_adv_commerce',
	    		'db' => 'region_14',
				),
			//'14.ru/firms' => array(
			//	'site_id' => 134, // 14.ru
	    		//'site_title' => '14.ru',
	    		//'section_title' => 'Справочник фирм',
	    		//'type' => 'firms',
	    		//'group' => 'rugion_firms',
	    		//'db' => 'rugion',
	    		//'regid' => 14,
			//	),
			'14.ru/firms' => array('section_id' => 3429),
			//'14.ru/hadv' => array('section_id' => 272), // 14.ru - Частные объявления 	    	
	    	'14.ru/car' => array('section_id' => 10951),
	    	'14.ru/grab_advertises' => array(
	    		'site_id' => 134, // 14.ru
	    		'site_title' => '14.ru',
	    		'regid' => 14,
	    		'group' => 'grab_rugion_car',
	    		//'db' => 'region_14',
	    		),
	    	//'14.ru/catalog' => array('section_id' => 273), // 14.ru - Каталог сайтов
		//'14.ru/accident' => array('section_id' => 4194),
		'14.ru/accident' => array(
			'site_id' => 134, // 14.ru
	    		'site_title' => '14.ru',
    			'section_title' => 'Автокатастрофы',			
			'group' => 'accident_v2',
			'images_dir' => '/common_fs/i/accident/',
			'images_url' => 'http://other.img.rugion.ru/_i/accident/',
			'SectionID' => 4194
		), // автокатастрофы v2
			'14.ru/gallery' => array('section_id' => 4197),
			'14_conference_comments' => array(
				'site_title' => 'Регион 14',
				'section_title' => 'Комментарии конференции 14.ru',
		    		'RegionID' => 14,
				'group' => 'conference',
			),
			
			'14_grab_news' => array(
				'site_title' => 'Регион 14',
				'section_title' => '14: Новости (грабленные)',
		    	'RegionID' => array(14),
				'group' => 'grab_news_magic',
			),
			
			'14_news_comments' => array(
				'site_title' => 'Регион 14',
				'section_title' => 'Комментарии новости 14.ru',
		    		'RegionID' => 14, //(array)
				//'SiteID' => , (array)
				//'SectionID' => , (array)
				'group' => 'news_magic',
			),
			
			'14_firms_comments' => array(
				'site_title' => 'Комментарии фирм 14.ru',
				'section_title' => 'Комментарии фирм 14.ru',
				'TreeID' => 3429,
				'group' => 'all_firms_comments',
			),
			
			'14_blogs' => array(
				'site_title' => 'Регион 14',
				'section_title' => 'Дневники 14.ru',
	    		'RegionID' => 14,
				'group' => 'blogs',
			),
/*			'14.ru/forum-pm' => array(
				'section_id' => 196,
			),
*/
			'14_group_article_comments' => array(
				'site_title' => 'Регион 14',
				'section_title' => 'Комментарии группы статей 14.ru',
		    		'RegionID' => 14,
				'group' => 'group_article',
			),
	    		'14.ru/grab_board' => array(
		    		'site_title' => '14.ru',
		    		'regid' => 14,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'14.ru/grab_hitech' => array(
		    		'site_title' => '14.ru',
		    		'regid' => 14,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
    );

?>
