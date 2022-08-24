<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'group_article',
	'tables' => array(
		'comments' 		=> 'group_comments',
		'votes'			=> 'group_comments_votes',
		'ref'			=> 'group_comments_ref',
	),
	'space'		=> 'group_article_comments',
	'premoderate'	=> true,
);

?>