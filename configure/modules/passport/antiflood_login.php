<?
return array(
	'antiflood' => array(
		'max_scores' => array(          // баллы для определения ограничения
			'captcha' => 500,            // каптча
			'wait' => 1000,              // ожидание
			'block' => 1500,          // блокировка
		),
		
		'timeout' => array(             // условия уменьшения балла
			'divide' => 1.2,
			'sub' => 1,
			'time' => 60,
		),
		
		'rules' => array(               // автоматические правила
			'post_login' => array(
				'name' => 'general',
				'key' => 1,// ip адрес компа и прокси
				'condition' => array(
					'post.action' => 'login',					
				),
				'score' => array(
					'multiply' => 1.5,
					'add' => 50,
				),
			),
			'get_login' => array(
				'name' => 'general',
				'key' => 1,// ip адрес компа и прокси
				'condition' => array(
					'get.action' => 'login',
				),
				'score' => array(
					'multiply' => 1.5,
					'add' => 50,
				),
			),			
		),		
	),
);
?>