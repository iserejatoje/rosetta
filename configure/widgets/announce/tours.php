<?

return array(
	'container' => array(
		'template' => array(
			//'list' 		=> 'announce/tours/container/list.tpl',
		),
	),

	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
		
		'searchForm' => 'widgets/announce/tours/search_form',
		'resorts' => 'widgets/announce/tours/resorts',
		'countries' => 'widgets/announce/tours/countries',
		'categories' => 'widgets/announce/tours/categories',
		'user_menu' => 'widgets/announce/tours/user_menu',
		'firm' => 'widgets/announce/tours/firm',
	),
	
	'tables' => array(
		'agency'	=> 'Agency',	// Агентства
		'tours'		=> 'Tours',		// Туры
		'resorts'	=> 'Resorts',	// Курорты
		'users'		=> 'Users',		// Пользователи => Агентства
		'summaryToursInCountry'	=> 'summaryToursInCountry',	// Количество туров по стране,категории
	),
	
	'styles' => array(
		0 => "/_styles/design/200805_afisha/modules/tours/styles.css",
	),
	
	'db' => 'tours',
);
?>