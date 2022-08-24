<?
return array(
	'db' => 'afisha',
	'images_dir'	=> '/common_fs/i/afisha/',
	'images_url'	=> 'http://other.img.rugion.ru/_i/afisha/',
	'images' => array(
		'large' => array(
			'path' => '/common_fs/i/afisha/events/large/',
			'url' => 'http://other.img.rugion.ru/_i/afisha/events/large/'
		),
		'small' => array(
			'path' => '/common_fs/i/afisha/events/small/',
			'url' => 'http://other.img.rugion.ru/_i/afisha/events/small/'
		)
	),
	'tables' => array(
		'events' => 'events',
		'seances' => 'seances',
		'places' => 'places',
		'types' => 'types',
		'groups' => 'groups',
		'halls' => 'halls',
	),
	'templates' => array(
		'overload' => array(
			'container' => 'containers/empty.tpl',
		),
		
		// шаблоны по дизайнам
		'200805_afisha' => array(
			'default'	=> 'announce/afisha_group/200805_afisha/default.tpl',
		),
		'200710_afisha' => array(
			'default'	=> 'announce/afisha_group/200710_afisha/default.tpl',
		),
	),
);
?>