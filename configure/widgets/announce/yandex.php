<?
return array(
	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
		'job' => 'announce/yandex/job.tpl',
		'news' => 'announce/yandex/news.tpl',
		'sale' => 'announce/yandex/sale.tpl',
		'rent' => 'announce/yandex/rent.tpl',
		'realty' => 'announce/yandex/realty.tpl',
		'auto' => 'announce/yandex/auto.tpl',
		'afisha' => 'announce/yandex/afisha.tpl',
		'exchange' => 'announce/yandex/exchange_v3.tpl',
		'exchange_test' => 'widgets/announce/yandex/exchange',
		'weather' => 'widgets/announce/yandex/weather',
		'search' => 'widgets/announce/yandex/search',
		'tours'	=>  'widgets/announce/yandex/tours',
	),
	
	'scripts' => array(
		'http://img.yandex.net/webwidgets/1/WidgetApi.js',
		'/_scripts/themes/frameworks/jquery/jquery/1.2.6.pack.js',
	),
	
	'realty_objects' => array(
		1	=>array('Комната'),
		2	=>array('Однокомнатная'),
		3	=>array('Двухкомнатная'),
		4	=>array('Трехкомнатная'),
		5	=>array('Четырехкомнатная'),
		6	=>array('5-к и более'),
		7	=>array('Дача'),
		8	=>array('Дом'),
		9	=>array('Коттедж'),
		10	=>array('Земельный участок'),
		13	=>array('Гараж'),
		14	=>array('Таунхаус')
	),
	
	'limit' => 5,
	
	'icon_url_weather' => '/_img/modules/weather/ico/small/',
);
?>