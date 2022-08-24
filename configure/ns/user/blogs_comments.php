<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',	
	'db'				=> 'blogs',
	'comment_type' => 'passport',
	'subsection'	=> array(
		'sectionid' => 10260
		),
	'tables' => array(
		'comments' 		=> 'users_comments',
		'votes'			=> 'users_CommentVotes',
		'ref'			=> 'users_comments_ref',
	),
	
	'space'		=> 'blogs_comments',
	'indexed'	=> true,

	'premoderate'	=> false,
);

?>