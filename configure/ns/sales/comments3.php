<?
/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment3',
	'db'				=> 'chelfin',
	'tables' => array(
		'comments' 		=> 'sales_comments',
		'votes'			=> 'sales_comments_votes',
		'ref'			=> 'sales_comments_ref',
	),
	'space'		=> 'sales_comments',
	'subsection'	=> array(
		'sectionid' => 9924,
	),
	'premoderate'	=> true,
);

?>