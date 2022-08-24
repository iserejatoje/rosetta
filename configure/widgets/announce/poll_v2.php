<?
return array(
	'db'	=> 'poll',
	'tables'    => array(
		'question' => 'poll_question',
		'answer' => 'poll_answer',
		'hosts' => 'poll_hosts',
		//'group' => 'news_group',
		'ref' => 'poll_ref',
		'sections_groups' => 'poll_sections_groups',
		'sections_groups_ref' => 'poll_sections_groups_ref',
	),

	'scripts' => array(
	'/_scripts/themes/frameworks/jquery/jquery.js',
	),
	
	'styles' => array(		
		'/_styles/modules/poll/styles.css',
	),
	
		'container' => array( 
			'template' => array( 
				'default' => 'containers/blank.tpl',
			),
		),
	

	
);
?>
