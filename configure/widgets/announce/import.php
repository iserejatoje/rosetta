<?
return array(
	'db' => 'public',

	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
		'kommersant' => 'announce/import/kommersant.tpl',
	),

	'tables'	=> array(
		'kommersant' 		=> 'kommersant_art',
	),
	
	'limit_news' => 2,
);
?>