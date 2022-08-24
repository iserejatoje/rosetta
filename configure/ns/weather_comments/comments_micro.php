<?
/*
* Module Engine Config
*/
return array(
	'module'	=> 'app_comment_micro',
	'db'				=> 'weather',
	'tables' => array(
		'comments' 		=> 'weather_comments',
		'current'		=> 'weather_current',
		'adnvanced'		=> 'weather_advanced', // Почасовая погода
	),
	'space'		=> 'weather_comments',
	'subsection'	=> array(
		'sectionid' => 5081,
	),
	'premoderate'	=> false,	
	
	'library' => 'app_comment_micro_weather',
);

?>