<?
	return array(
		'stpl_design' => '200710_business',
		'styles'			=> array(
			'common' => '/_styles/design/200710_business/common/styles.css',
			'mod_svoi' => '/_styles/design/200710_business/modules/svoi/styles.css',	
			'mod_forum' => '/_styles/design/200710_business/modules/forum/styles.css',
		),
	
		'templates'	=> array(
			'index'		=> '_design/200710_business/common/2pages.tpl',
			'section' 	=> null,
			'left' 		=> null,
			'header'	=> '_design/200710_business/common/header.tpl',
			'footer'	=> '_design/200710_business/common/footer.tpl',
			'right'		=> '_design/200710_business/common/right_block.tpl',
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
				'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'business', 'place' => 'right')),
			),
			'header' => array(
			),
			'footer' => array(
			),
		),
	);
?>