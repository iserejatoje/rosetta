<?
return array(
	// дизайн, используемый по умолчанию
	'design_default' => '200608_title',
		
	'templates' => array(
		'overload' => array(
			'container' => 'containers/empty.tpl',
		),
		
		// шаблоны по дизайнам
		'200608_title' => array(
			'default'	=> 'announce/catalog/200608_title/default.tpl',
			'slide'		=> 'announce/catalog/200608_title/slide.tpl',
		),
		'200901_social' => array(
			'default'	=> 'announce/catalog/200901_social/default.tpl',
			'slide'		=> 'announce/catalog/200901_social/slide.tpl',
		),
	),
);
?>