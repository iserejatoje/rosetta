<?
return array(
		'templates' => array(
			'overload' => array(
				'container' => 'containers/blank.tpl',
				),
			
			// шаблоны виджета по дизайнам
			'title'	=> array(
				'default' 	=> 'announce/empty/title/default.tpl',
				'oxota'		=> 'announce/empty/title/oxota.tpl', // для главной
				'block_oxota'	=> 'announce/empty/title/block_oxota.tpl', // для внутренних
				'oxota_title_menu' => 'announce/empty/title/oxota_title_menu.tpl', // для главных титульных, в меню блоков, слева
			),
			'200805_afisha' => array(
				'default'	=> 'announce/empty/200805_afisha/default.tpl',
				'oxota'		=> 'announce/empty/200805_afisha/oxota.tpl',
				'oxota_main'	=> 'announce/empty/200805_afisha/oxota_main.tpl'
			)
		),
		'limit' => 1,
		'withtext' => 1,
		'sections' => array (
			74 => array(
				'oxota' => 9134
			),
			// дальше просто конкурсы
			26 => array(
				'oxota' => 10216
			),
			29 => array(
				'oxota' => 10213
			),
			45 => array(
				'oxota' => 10215
			),
			56 => array(
				'oxota' => 10212
			),
			76 => array(
				'oxota' => 10214
			),
			174 => array(
				'oxota' => 10217
			),
		)
	);
?>