<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'technics',
	'tables' => array(
		'comments' 		=> 'catalog_comments',
		'votes'			=> 'catalog_comments_votes',
		'ref'			=> 'catalog_comments_ref',
	),
	'space'		=> 'technics_comments',
	'subsection'	=> array(
		'sectionid' => 5079,
	),
	'premoderate'	=> true,
);

?>