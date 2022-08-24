<?
return array(
	'styles' => array(
		'/_styles/design/200901_social/common/styles.css',
		'/_styles/design/200901_social/modules/help/styles.css',
	),
	
	'templates' => array(
		'index'				=> '_design/200901_social/common/2pages.tpl',
		'left'				=> '_design/200901_social/common/left_block.tpl',
		'right'				=> '_design/200901_social/common/right_block.tpl',		
		
		//'section_title'		=> '_design/200901_social/mod_help/section_title.tpl',		
		'section_title'		=> '_design/200901_social/mod_passport/section_title.tpl',		
		'ssections' => array(		
			'default'		=> '_design/200901_social/mod_help/ss/default.tpl',
			'describe'		=> '_design/200901_social/mod_help/ss/describe.tpl',
		),
	),
	
	'blocks' => array(
		'header' => array(
			'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'social', 'place' => 'header')),
			'people_search' => array('type' => 'widget', 'name' => 'user/search/form', 'params' => array('method' => 'sync', 'place'=> 'header'),
				'ref' => array(
					'link' => array(
					),
					'condition' => array(
					),
				),
			),
		),
		
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
		),
		
		'left' => array(		
			array('type' => 'widget', 'name' => 'control/left_menu/default', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:page', 'destination' => '$this:page'),
					)
				)
			),					
			array('type' => 'widget', 'name' => 'announce/messages/default', 'params' => array(
				'method' => 'sync',
				'config' => 'announce/messages/social',
				'container' => 'containers/empty.tpl',
				)
			),
			array('type' => 'widget', 'name' => 'announce/groups/default', 'params' => array('method' => 'sync'),
				'ref' => array(
					'link' => array(
					),
					'condition' => array(
					),
				),
			),
		),
		
		'right' => array(
			array('type' => 'widget', 'name' => 'announce/catalog/slide', 'params' => array('method' => 'sync', 'prefix' => 'help_', 'design' => '200901_social'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:rolekey', 'destination' => '$this:rolekey'),
						array('source' => '$main/0:nodeid', 'destination' => '$this:id')
					),
				),
			),
		),
	)
);

?>