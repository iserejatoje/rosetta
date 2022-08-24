<?

return array(
	'templates' => array(
		'overload' => array(
			'container' => 'containers/empty.tpl',
		),
	),
	
	'db' => 'adv_realty',
	'regid' => '74',
	'tables' => array(
		'secondary_offer' => array(
			'master'	=> '_secondary_offer',
			'index'		=> '_secondary_offer_price_index',
			'geo_zone'	=> '_secondary_offer_price_geo_zone',
			'map'		=> '_secondary_offer_price_map',
		),
		/*'new_offer' => array(
			'master'	=> '_new_offer',
			'index'		=> '_new_offer_price_index',
			'geo_zone'	=> '_new_offer_price_geo_zone',
			'map'		=> '_new_offer_price_map',
		),*/
	),
	
	'chart' => array(
		'type'		=> 'lc',
		'width'		=> 200, //241,
		'height'	=> 163, //196,
		'max_y'		=> strlen('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1,
		'bar'		=> array(
			'colors'	=> array('9bca5d'),
			'size'		=> array(
				'space_between_bars'	=> 5,
				'space_between_groups'	=> 5,
			),
		),
		'offset'		=> true,
		'line'			=> '2,2,0', //стиль линии
		'y_axis_count'	=> 5,	// число линий сетки по оси ординат
		'google_simple_encode_table' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
	),
	
	'Series' => array(
		1 => array('b'=>'хрущевка','s'=>'Хр'),
		2 => array('b'=>'брежневка','s'=>'Бр'),
		3 => array('b'=>'97','s'=>'97'),
		4 => array('b'=>'97 улучшенная','s'=>'97У'),
		5 => array('b'=>'121','s'=>'121'),
		6 => array('b'=>'121Т','s'=>'121Т'),
		7 => array('b'=>'полнометражная','s'=>'Пм'),
		8 => array('b'=>'ленинградский проект','s'=>'Лп'),
		9 => array('b'=>'индивидуальный проект','s'=>'Ип'),
		10 => array('b'=>'элитная','s'=>'Эл'),
		11 => array('b'=>'другая','s'=>'другая')
	),
);

?>