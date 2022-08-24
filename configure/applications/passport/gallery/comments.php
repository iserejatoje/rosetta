<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment',
	'comment_type' => 'passport',
	'db'				=> 'gallery',
	'tables' => array(
		'comments' 		=> 'users_comments',
		'votes'			=> 'users_CommentVotes',
		'ref'			=> 'users_comments_ref',
	),
	'space'		=> 'passport_comments',

	'premoderate'	=> false,
);

?>