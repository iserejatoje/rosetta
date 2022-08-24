<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'places',
	'tables' => array(
		'comments' 		=> 'place_comments',
		'votes'			=> 'place_comments_votes',
		'ref'			=> 'place_comments_ref',
	),
	'space'		=> 'firms_comments',
	'premoderate'	=> true,
);

?>