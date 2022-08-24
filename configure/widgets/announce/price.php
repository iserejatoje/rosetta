<?
return array(
	'db'	=> 'group_price',
	'tables'	=> array(
		'groups'			=> 'price_groups',
		'managers'		=> 'price_managers',
		'price'			=> 'price_list',
		'note'				=> 'price_note',
		'manager_ref'	=> 'price_managers_ref',
		'positions'		=> 'price_list_positions',
	),	
	
	'managers_thumb_url'	=> '/_CDN/_i/group_price/1/thumb/',
	'managers_photo_url'	=> '/_CDN/_i/group_price/1/photo/',

	'managers_thumb_dir'	=> '/common_fs/i/group_price/1/thumb/',
	'managers_photo_dir'	=> '/common_fs/i/group_price/1/photo/',
			
	'container' => array( 
		'template' => array( 
			'default' => 'containers/blank.tpl',
		),
	),
	
	'positions'	=>	array(
		1	=> 'Менеджер проекта &laquo;Работа&raquo;',
		2	=> 'Менеджер проекта',
		3	=> 'Координатор проекта',
		4	=> 'Руководитель проекта',
		5	=> 'Руководитель отдела продаж',
		6	=> 'Коммерческий директор',
		7	=> 'Директор филиала',
	),
);
?>