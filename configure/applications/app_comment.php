<?

/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'default' 	=> array('regexp' => '@^.*$@'),			
		),
		'post' 			=> array(
			'comments_edit' => array(),
			'page' 			=> array(),
			'comment_add_vote' => array(),
			'comment_delete' => array(),
		),
	),
	'module'			=> 'app_comment',
	'db'				=> '',
	
	'offset' 			=> 0,
	'row_on_page' 		=> 25, 
	'links_on_page' 	=> 5,
	
	'min_text_len' 		=> 1, //минимальная длинна комментария
	'max_text_len' 		=> 25, //максимальная длинна комментария
	
	'styles' => array(),
	'scripts' => array(
		'/_scripts/modules/app_comments/comments.js',
	),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title/common/2pages.tpl',
		'left'			=> '_design/200608_title/common/left_block.tpl',
		'right'			=> '_design/200608_title/common/right_block.tpl',
		'form' 			=> '_modules/app_comments/ss/app_comment_form.tpl',
		'ssections'	=> array(
			'default'	=> '_modules/app_comments/ss/app_comment_default.tpl',
			'list'	=> '_modules/app_comments/ss/app_comment_list_vote.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'tables' => array(
		'comments' 		=> '',
	),
	
);

?>



