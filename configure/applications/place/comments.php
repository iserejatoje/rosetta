<?

/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment',
	'db'				=> 'places',
	'tables' => array(
		'comments' 		=> 'PlaceComments',
		'votes'			=> 'CommentVotes',
		'ref'			=> 'PlaceComments_ref',
	),
	'space' => 'place_comments',
	'subsection' => array('sectionid' => 4532),
	'premoderate'	=> true,
);

?>


