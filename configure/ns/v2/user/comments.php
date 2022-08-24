<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment2',
	'comment_type' => 'passport',
	'db'				=> 'gallery',
	'subsection'	=> array(
		'sectionid' => 3219
		),
	'tables' => array(
		'comments' 		=> 'users_comments',
		'votes'			=> 'users_CommentVotes',
		'ref'			=> 'users_comments_ref',
	),
	'space'		=> 'passport_comments',
	
	'styles' => array(
		'/_styles/design/200901_social/common/styles.css',
		),
	
	'templates'	=> array(
		'index'			=> '_design/200901_social/common/2pages.tpl',
		'left'			=> '_design/200901_social/common/left_block.tpl',
		'right'			=> '_design/200901_social/common/right_block.tpl',
		'form' 			=> '_design/200901_social/app_comments/ss/app_comment_form.tpl',
		'ssections'	=> array(
			'default'				=> '_design/200901_social/app_comments/ss/app_comment_default.tpl',
			'list'					=> '_design/200901_social/app_comments/ss/app_comment_list_vote.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),

	'premoderate'	=> false,
);

?>