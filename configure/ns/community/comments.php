<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'passport',
	
	'styles' => array(
		'/_styles/design/200901_social/common/styles.css',
		),
	
	'templates'	=> array(
		'index'			=> '_design/200901_social/common/2pages.tpl',
		'left'			=> '_design/200901_social/common/left_block.tpl',
		'right'			=> '_design/200901_social/common/right_block.tpl',
//		'form' 			=> '_design/200901_social/app_comments/ss/app_comment_form.tpl',
		'pages_link'	=> '_design/200901_social/mod_passport/pages_link.tpl',
		'ssections'	=> array(
	//		'default'				=> '_design/200901_social/app_comments/ss/app_comment_default.tpl',
		//	'list'					=> '_design/200901_social/app_comments/ss/app_comment_list_vote.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'tables' => array(
		'comments' 		=> 'comments',
		'votes'			=> 'comments_votes',
		'ref'			=> 'comments_ref',
	),
	'space'		=> 'svoi_comments',
	'subsection'	=> array(
		'sectionid' => 5043,
	),
	'premoderate'	=> false,
);

?>