<?
	return array(
		'stpl_design' => '200710_doctor',
		'styles'			=> array(
			'common' => '/_styles/design/200710_doctor/common/styles.css',
			'mod_svoi' => '/_styles/design/200710_doctor/modules/svoi/styles.css',	
			'mod_forum' => '/_styles/design/200710_doctor/modules/forum/styles.css',
		),
	
		'templates'	=> array(
			'index'		=> '_design/200710_doctor/common/2pages.tpl',
			'section' 	=> null,
			'left' 		=> null,
			'header'	=> '_design/200710_doctor/common/header.tpl',
			'footer'	=> '_design/200710_doctor/common/footer.tpl',
			'right'		=> '_design/200710_doctor/common/right_block.tpl',
		),
		
		'blocks'	=> array(
			'others' => array(
				'people_search' => array('type' => 'widget', 'name' => 'user/search/form', 
					'params' => array(
						'method' => 'sync', 'place'=> 'main'
					),
					'ref' => array(
						'link' => array(
						),
						'condition' => array(
						),
					),
				),
			),
			'right' => array(
				'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'doctor', 'place' => 'right')),
			),
			'header' => array(
			),
			'footer' => array(
			),
		),
	);
?>