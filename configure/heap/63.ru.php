<?

	return array(
	    'sections' => array (
	    	'freetime63.ru/love' => array(
	            'site_id' => 147,
                'site_title' => 'freetime63.ru',
	    		'section_title' => 'Знакомства',
	    		'type' => 'old_love',
	    		'tables' => array(
			        'photos' => 'love_photo',
			        'users' => 'love_user',
			        'story' => 'love_story_comment',
			        ),
	    		'db' => 'afisha63',
	    		'photo_dir'	=> '_var_local_www_be_sites/afisha63.ru/love/photo_love/',
				'photo_url'	=> 'http://freetime63.ru/love/photo_love/',
	    		),
			'63.ru/job' => array('section_id' => 1006),
			'63.ru/baraholka' => array('section_id' => 10435),
			'63.ru/lostfound' => array('section_id' => 11126),
			'63.ru/hitech' => array('section_id' => 10436),
			'doroga63.ru/rating' => array('section_id' => 10564),
			'freetime63.ru/rating' => array('section_id' => 10823),
			
			'63_gallery' => array(
				'section_id' => 10445,
				'group' => 'gallery',
				'site_title' => 'Регион 63',
				'section_title' => 'Справочник горожанина 63.ru',
	    		'RegionID' => 63,
			),
			
			/*array(
				'site_id' => 91, // 63.ru
	    		'site_title' => '63.ru',
	    		'section_title' => 'Работа',
	    		'type' => 'job',
	    		'group' => 'rugion_job',
	    		'db' => 'rugion',
	    		'regid' => 63,
				), */
			'63.ru/firms' => array('section_id' => 3274),
			/*array(
				'site_id' => 91, // 63.ru
	    		'site_title' => '63.ru',
	    		'section_title' => 'Справочник фирм',
	    		'type' => 'firms',
	    		'group' => 'rugion_firms',
	    		'db' => 'rugion',
	    		'regid' => 63,
				),*/
				
			
			'63.ru/grab_job_new' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_63',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'63.ru/grab_job_v2' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_63',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'63.ru/grab_job_new_resume' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_63',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'63.ru/grab_job_v2_resume' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_63',
				'show' => 'resume',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'63.ru/grab_job_new_vacancy' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_new',
				'out_db' => 'region_63',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),
			'63.ru/grab_job_v2_vacancy' => array(
				'site_id' => 488, // 63.ru
	    		'site_title' => '63.ru',
	    		'regid' => 63,
	    		'group' => 'grab_rugion_job_v2',
				'out_db' => 'region_63',
				'show' => 'vacancy',
				'tables' => array(
		                	'j_vacancy' => 'job_v2_vacancy',
					'j_resume' => 'job_resume',
                    ),
			),

			'dengi63.ru/atm' => array('section_id' => 10076),
//			'dom63.ru/sale' => array('section_id' => 1027),
//			'dom63.ru/rent' => array('section_id' => 1028),
//			'dom63.ru/commerce' => array('section_id' => 1029),
//			'dom63.ru/change' => array('section_id' => 1030),
			'dom63.ru/realty' => array(
				'section_id' => 1096,
			),

//		        'doroga63.ru/advertises' => array('section_id' => 971),
		    	'doroga63.ru/car' => array('section_id' => 11046),
		    	'doroga63.ru/grab_advertises' => array(
		    		'site_id' => 93, // doroga63.ru
		    		'site_title' => 'doroga63.ru',
	    			'regid' => 63,
		    		'group' => 'grab_rugion_car',
		    		//'db' => 'auto_rugion',
	    		),
			'dom63.ru/grab_realty' => array(
				'section_id' => 1096,
		    		'site_title' => 'dom63.ru',
		    		'group' => 'grab_realty',
				),
			//'doroga63.ru/accident' => array('section_id' => 589), // автокатастрофы 
			'doroga63.ru/accident' => array(
				'site_id' => 93, // doroga63.ru
		    		'site_title' => 'doroga63.ru',
	    			'section_title' => 'Автокатастрофы',			
				'group' => 'accident_v2',
				'images_dir' => '/common_fs/i/accident/',
				'images_url' => 'http://other.img.rugion.ru/_i/accident/',
				'SectionID' => 589
			), // автокатастрофы v2
			'63.ru/forum-pm' => array(
				'section_id' => 189
			),
			'business63.ru/forum-pm' => array(
				'section_id' => 671
			),
			'dengi63.ru/forum-pm' => array(
				'section_id' => 573
			),
			'dom63.ru/forum-pm' => array(
				'section_id' => 190
			),
			'doroga63.ru/forum-pm' => array(
				'section_id' => 191
			),
			'freetime63.ru/forum-pm' => array(
				'section_id' => 271
			),
			'freetime63.ru/gallery' => array(
				'section_id' => 1065
			),
			'63_news_comments' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Комментарии новости 63.ru',
	    		'RegionID' => 63,
				'group' => 'news_magic',
			),	
			'freetime63_afisha_comments' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Комментарии афиши freetime63.ru',
		    		//'RegionID' => , (array)
				//'SiteID' => , (array)
				'SectionID' => 530, //(array)
				'group' => 'afisha_magic',
			),
			'63_conference_comments' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Комментарии конференции 63.ru',
		    		'RegionID' => 63,
				'group' => 'conference',
			),
			
			'63_firms_comments' => array(
				'site_title' => 'Комментарии фирм 63.ru',
				'section_title' => 'Комментарии фирм 63.ru',
				'TreeID' => 3274,
				'group' => 'all_firms_comments',
			),
			
			'dom63_firms_comments' => array(
				'site_title' => 'Комментарии фирм dom63.ru',
				'section_title' => 'Комментарии фирм dom63.ru',
				'TreeID' => 3272,
				'group' => 'all_firms_comments',
			),
			
			'freetime63_firms_comments' => array(
				'site_title' => 'Комментарии фирм freetime63.ru',
				'section_title' => 'Комментарии фирм freetime63.ru',
				'TreeID' => 3277,
				'group' => 'all_firms_comments',
			),
			
			'dengi63_firms_comments' => array(
				'site_title' => 'Комментарии фирм dengi63.ru',
				'section_title' => 'Комментарии фирм dengi63.ru',
				'TreeID' => 3276,
				'group' => 'all_firms_comments',
			),
			
			'business63_firms_comments' => array(
				'site_title' => 'Комментарии фирм business63.ru',
				'section_title' => 'Комментарии фирм business63.ru',
				'TreeID' => 3275,
				'group' => 'all_firms_comments',
			),
			
			'doroga63_firms_comments' => array(
				'site_title' => 'Комментарии фирм doroga63.ru',
				'section_title' => 'Комментарии фирм doroga63.ru',
				'TreeID' => 3155,
				'group' => 'all_firms_comments',
			),
			
			'doctor63_firms_comments' => array(
				'site_title' => 'Комментарии фирм doctor63.ru',
				'section_title' => 'Комментарии фирм doctor63.ru',
				'TreeID' => 9315,
				'group' => 'all_firms_comments',
			),
/*
			'63_contest_comments' => array(
				'site_title' => 'Комментарии конкурса contest 63 регион (Самара)',
				'section_title' => 'Комментарии конкурса contest 63 регион (Самара)',
				'group' => 'all_contest_comments',
			),
*/
			
			'63_blogs' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Дневники 63.ru',
	    		'RegionID' => 63,
				'group' => 'blogs',
			),
			'63_group_article_comments' => array(
				'site_title' => 'Регион 63',
				'section_title' => 'Комментарии группы статей 63.ru',
		    		'RegionID' => 63,
				'group' => 'group_article',
			),
	    		'63.ru/grab_board' => array(
		    		'site_title' => '63.ru',
		    		'regid' => 26,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_board',
				'params' => array(
					'type' => 8,
				),
	    		),
	    		'63.ru/grab_hitech' => array(
		    		'site_title' => '63.ru',
		    		'regid' => 63,
		    		'group' => 'grab_rugion_board',
				'db' => 'adv_techboard',
				'params' => array(
					'type' => 9,
				),
	    		),
		)
	);

?>
