<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment2',
	'db'				=> 'news',
	'tables' => array(
		'comments' 		=> 'news_comments',
		'votes'			=> 'news_comments_votes',
		'ref'			=> 'news_comments_ref',
	),
	'space'		=> 'news_magic_comments',
	'subsection'	=> array(
		'sectionid' => 5048,
	),
	'premoderate'	=> true,
);

?>