<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'afisha',
	'tables' => array(
		'comments' 		=> 'comments',
		'votes'			=> 'CommentVotes',
		'ref'			=> 'comments_ref',
	),
	'space'		=> 'afisha_comments',
	'subsection' => array('sectionid' => 5085),//4572),
	'premoderate'	=> true,
);

?>
