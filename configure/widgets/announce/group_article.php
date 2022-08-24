<?
return array(
	'templates' => array(
		'overload' => array(
			'container' => 'containers/blank.tpl',
		),
	),
	
	'db' => 'group_article',
	
	'tables'	=> array(
		'article'	=> 'article',
		'group'		=> 'group',
		'ref_counts'=> 'group_ref_counts',
		'ref'		=> 'group_ref',

		'sections_groups'		=> 'group_sections_groups',
		'sections_groups_ref'	=> 'group_sections_groups_ref',
		
		'comments' 		=> 'group_comments',
		'comments_votes'=> 'group_comments_votes',
		'comments_ref'	=> 'group_comments_ref',
	),

	'photo' => array(
		'path'	=> '/common_fs/i/group_article/1/',
		'url'	=> '/_CDN/_i/group_article/1/',
	),
);
?>