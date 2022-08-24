<?
	return array(
		'stpl_design' => '200608_title',
		'styles' => array(
			'common'	=> '/_styles/design/200608_title/common/styles.css',
	//		'mod_svoi'	=> '/_styles/design/200608_title/modules/svoi/styles.css',	
	//		'mod_forum' => '/_styles/design/200608_title/modules/forum/styles.css',
		),
	
		'templates'	=> array(
				'index'				=> '_design/200608_title/common/2pages.tpl',
				'index_popup'   	=> '_design/200608_title/common/2pages_popup.tpl',
				'header_popup'  	=> '_design/200608_title/common/header_popup.tpl',
				'footer_popup'  	=> '_design/200608_title/common/footer_popup.tpl',
				'left'				=> '_design/200608_title/common/left_block.tpl',
				'right'				=> null,
		),
				
		'blocks'	=> array(	
		
			'right'	=> null,
			//'section_title'	=> null,
		
			'left' => array(
				'menu_left' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_left', 'lifetime' => 0, 'params' => array()),
				
				'messages' => array(
					'type' => 'widget', 
					'name' => 'announce/messages/default', 
					'params' => array(
						'method' => 'sync', 
						'container' => 'containers/svoi_left.tpl'
					)
				),
				
				array('type' => 'widget', 'name' => 'control/left_menu/default', 'params' => array('method' => 'sync'),
					'ref' => array(
						'link' => array(
							array('source' => '$main/0:page', 'destination' => '$this:page'),
						),
						'condition' => array(
							array('type' => 'notequal', 'field' => '$main/0:page', 'value' => 'blogs_new'),
							array('type' => 'notequal', 'field' => '$main/0:page', 'value' => 'blogs_popular'),
							array('type' => 'notequal', 'field' => '$main/0:page', 'value' => 'blogs_tag'),
						),
					)
				),				
			),
			
			'header' => array(					
					'login_form' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'login', 'lifetime' => 0),
					'header_menu_bottom' => array('type' => 'this', 'name' => 'header_menu_blogs', 'lifetime' => 600, 'params' => array()),
			),
			
			'footer' => array(
			),
		),
	);
?>