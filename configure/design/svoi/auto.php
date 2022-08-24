<?
	return array(
		'stpl_design' => '200710_auto',
		'styles'			=> array(
			'common' => '/_styles/design/200710_auto/common/styles.css',
			'mod_svoi' => '/_styles/design/200710_auto/modules/svoi/styles.css',	
			'mod_forum' => '/_styles/design/200710_auto/modules/forum/styles.css',
		),
	
		'templates'	=> array(
			'index'		=> '_design/200710_auto/common/2pages.tpl',
			'section' 	=> null,
			'left' 		=> null,
			'header'	=> '_design/200710_auto/common/header.tpl',
			'footer'	=> '_design/200710_auto/common/footer.tpl',
			'right'		=> '_design/200710_auto/common/right_block.tpl',
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
				'login_form' => array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'auto', 'place' => 'right')),
			),
			'header' => array(
			),
			'footer' => array(
			),
		),
	);
?>