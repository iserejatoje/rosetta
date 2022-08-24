<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'contests',
	'tables' => array(
		'comments' 		=> 'contest_comments',
		'votes'			=> 'contest_comments_votes',
		'ref'			=> 'contest_comments_ref'
	),
	'space'		=> 'contest_comments',
	'premoderate'	=> true
);

?>