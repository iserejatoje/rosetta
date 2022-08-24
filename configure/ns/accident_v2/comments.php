<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'accident',
	'tables' => array(
		'comments' 		=> 'accident_comments',
		'votes'			=> 'accident_comments_votes',
		'ref'			=> 'accident_comments_ref',
	),
	'space'		=> 'accident_v2_comments',
	'subsection'	=> array(
		'sectionid' => 5190,
	),
	'premoderate'	=> true,
	'indexed'	=> true,
);

?>