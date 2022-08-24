<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'conference',
	'tables' => array(	
		'comments' 		=> 'conference_comments',
		'votes'			=> 'conference_comments_votes',
		'ref'			=> 'conference_comments_ref',
	),
	'space'		=> 'conference_comments',
	'subsection'	=> array(
		'sectionid' => 5186,
	),
	'premoderate'	=> true,
);

?>