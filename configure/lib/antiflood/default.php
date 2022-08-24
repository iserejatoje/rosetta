<?
return array(
	'antiflood' => array(
		'max_scores' => array(
			'captcha' => 20,
			'wait' => 320,
			'block' => 100000,
		),
		'timeout' => array(		// скинуть балл
			'divide' => 1,
			'sub' => 1,
			'time' => 30, 		// время в секундах
		),
		'rules' => array(
			/*array(
				'name' => 'censor',	// по умолчанию, можно не указывать
				'key' => AntiFlood::K_USER,
				'condition' => array(		// параметры для проверки условия провайдером
					'fields' => array('get.ttt')
				),
				'score' => array(		// действия над баллом пользоватя в случае срабатывания условия
					'multiply' => 2,
					'add' => 1,
				),
			),
			array(
				'name' => 'general',	// по умолчанию, можно не указывать
				'key' => AntiFlood::K_USER,
				'condition' => array(		// параметры для проверки условия провайдером
					'user' => 'auth',
					'get.afact' => 'blockme',
				),
				'score' => array(		// действия над баллом пользоватя в случае срабатывания условия
					'multiply' => 100,
					'add' => 1,
				),
			),*/
		),
	),
);
?>