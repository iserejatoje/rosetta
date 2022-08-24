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

	'premoderate'	=> false,
);

?>