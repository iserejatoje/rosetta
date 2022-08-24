<?
return array(
	'realty' => array(
		'templates' => array(
			'overload' => array(
				'container' => 'containers/empty.tpl',
			),
		),

		'db' => 'adv_realty',
		'tables' => array(
			'secondary_offer' => array(
				'master'	=> '_secondary_offer',
				'index'		=> '_secondary_offer_price_index',
				'geo_zone'	=> '_secondary_offer_price_geo_zone',
				'map'		=> '_secondary_offer_price_map',
			),
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
			1 => array('b'=>'хрущ.','s'=>'Хр'),
			2 => array('b'=>'бреж.','s'=>'Бр'),
			3 => array('b'=>'97','s'=>'97'),
			4 => array('b'=>'97 улуч.','s'=>'97У'),
			5 => array('b'=>'121','s'=>'121'),
			6 => array('b'=>'121Т','s'=>'121Т'),
			7 => array('b'=>'полномет.','s'=>'Пм'),
			8 => array('b'=>'ленин. проект','s'=>'Лп'),
			9 => array('b'=>'индивид. проект','s'=>'Ип'),
			10 => array('b'=>'элитная','s'=>'Эл'),
			11 => array('b'=>'другая','s'=>'другая')
		),
	),
	'weather' => array(
		'sections' => array (
			59	=> 1077,
			16	=> 1080,
			61	=> 1087,
			63	=> 1090,
			72	=> 1100,
			2	=> 1104,
			102	=> 10006,
			93	=> 1143,
			34	=> 1146,
			74	=> 5081,
			174	=> 4259,
			14	=> 1372,
			26	=> 1376,
			29	=> 1381,
			35	=> 1386,
			36	=> 4919,
			38	=> 1391,
			42	=> 1396,
			43	=> 1401,
			45	=> 1406,
			48	=> 1411,
			51	=> 1416,
			53	=> 1421,
			56	=> 1426,
			60	=> 1431,
			62	=> 1436,
			64	=> 5869,
			68	=> 1441,
			70	=> 1446,
			71	=> 1451,
			75	=> 1462,
			76	=> 1467,
			86	=> 1472,
			89	=> 1477,
			66	=> 1482,
			55	=> 1499,
			193	=> 1580,
			54	=> 3914,
			78	=> 3258,
			24	=> 3185,
			163	=> 4659,
		),
	),
	'news'	    => array(
	    'sections'	=> array(
		74	    => 5253,
	    ),
	    'city_name'	=> array(
		74	=> 'Новости Челябинска',
	    ),
	),
);
?>