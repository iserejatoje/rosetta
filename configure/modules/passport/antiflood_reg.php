<?
return array(
	'antiflood' => array(
		'max_scores' => array(          // баллы для определения ограничения
			'captcha'	=> false,            // каптча
			'wait'		=> 50,              // ожидание
			'block'		=> false,          // блокировка
		),
		
		'timeout' => array(             // условия уменьшения балла
			'divide'	=> 1,
			'sub'		=> 50,
			'time'		=> 900,
		),
		
		'rules' => array(               // автоматические правила
			'get_register' => array(
				'name' => 'general',
				'key' => 1,// ip адрес компа и прокси
				'condition' => array(
				),
				'score' => array(
					'multiply' => 1,
					'add' => 0,
				),
			),
			'post_register' => array(
				'name' => 'general',
				'key' => 1,// ip адрес компа и прокси
				'condition' => array(
					'post.action' => 'register',
				),
				'score' => array(
					'multiply' => 1,
					'add' => 55,
				),
			),
		),		
	),
);
?>