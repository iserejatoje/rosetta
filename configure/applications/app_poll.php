<?
// {{{ Errors
static $poll_error_code = 0;
define('ERR_A_APP_POLL_MASK', 0x002D0000);
define('ERR_A_APP_POLL_CLEAR_ANSWER', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_NULL_MULTIMIN', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_BIG_MULTIMAX', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_SMALL_TITLE', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_BIG_TITLE', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_EMPTY_TYPE', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_POST_EMTY_ANSWERE', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_POST_MIN_ANSWER', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_POST_MAX_ANSWER', ERR_A_APP_POLL_MASK | $poll_error_code++);
define('ERR_A_APP_POLL_BIG_ANSWER', ERR_A_APP_POLL_MASK | $poll_error_code++);

$ERROR[ERR_A_APP_POLL_CLEAR_ANSWER] = 'Вы ввели меньше 2-х вариантов ответов.';
$ERROR[ERR_A_APP_POLL_NULL_MULTIMIN] = 'Минимальное количество ответов не может быть меньше 1.';
$ERROR[ERR_A_APP_POLL_BIG_MULTIMAX] = 'Максимальное количество ответов не может быть больше количества ответов.';
$ERROR[ERR_A_APP_POLL_BIG_MULTIMIN] = 'Минимальное количество ответов не может быть больше максимального.';
$ERROR[ERR_A_APP_POLL_SMALL_TITLE] = 'Вы ввели слишком маленький заголовок.';
$ERROR[ERR_A_APP_POLL_BIG_TITLE] = 'Вы ввели слишком большой заголовок.';
$ERROR[ERR_A_APP_POLL_EMPTY_TYPE] = 'Вы не выбрали тип голосования.';
$ERROR[ERR_A_APP_POLL_POST_EMTY_ANSWERE] = 'Вы не выбрали не один вариант ответа.';
$ERROR[ERR_A_APP_POLL_POST_MIN_ANSWER] = 'Вы выбрали слишком мало вариантов ответа.';
$ERROR[ERR_A_APP_POLL_POST_MAX_ANSWER] = 'Вы выбрали слишком много вариантов ответа.';
$ERROR[ERR_A_APP_POLL_BIG_ANSWER] = 'Вы пытаетесь добавить слишком много вариантов ответов.';



// }}}
/*
* Module Engine Config
*/
return array(
	'files' => array(
		// GET (выводят данные) обработчики
		'get' => array(
			'view' 		=> array('regexp' => '@^([0-9]+)\.php$@', 'matches' => array(1 => 'pollid')),
			'messages' 	=> array('regexp' => '@^msg\.([a-z0-9\-_]+)\.html$@', 'matches' => array(1 => 'message')),
			'last' 		=> array('string' => 'last.php'),
			'del' 		=> array('string' => 'del.php'),
			'edit'		=> array('string' => 'edit.php'),
			'default' 	=> array('regexp' => '@^.*$@'),
		),
		'post' => array(
			'edit' 		=> array(),
			'vote' 		=> array(),
			'vote_ajax'	=> array(),
		),
		'block' => array(
		),
	),
	'module'			=> 'app_poll',
	'db'				=> 'passport',
	
	'row_on_page' 		=> 15,
	'links_on_page'		=> 5,
	
	'min_len_title'		=> 5,
	'max_len_title'		=> 250,
	
	'max_count_answer' 	=> 15,
	
	
	'styles' => array(),
	'scripts' => array(
		'/_scripts/modules/app_poll/poll.js',
	),
	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this','name' => 'main','lifetime' => 0),
		),
		'header' => array(
			'login_form' => array('type' => 'block', 'sectionid' => 3629, 'name' => 'login', 'lifetime' => 0),
			'weather' => array('type' => 'widget', 'name' => 'announce/weather_magic/default', 'params' => array('method' => 'sync')),
			'header_menu_bottom' => array('type' => 'this', 'name' => 'header_menu_bottom', 'lifetime' => 0),
		),
	),
	
	'templates'	=> array(
		'index'			=> '_design/200608_title_blue/common/2pages.tpl',
		'left'			=> '_design/200608_title_blue/common/left_block.tpl',
		'right'			=> '_design/200608_title_blue/common/right_block.tpl',
		'header_menu_bottom' => '_modules/mod_svoi/header_menu_bottom.tpl',
		'sectiontitle'	=> '_modules/mod_svoi/sectiontitle.tpl',
		'ssections'	=> array(
			'view'			=> '_modules/app_poll/ss/view.tpl',
			'view_poll'		=> '_modules/app_poll/ss/view_poll.tpl',
			'view_poll_result'	=> '_modules/app_poll/ss/view_poll_result.tpl',
			'last'			=> '_modules/app_poll/ss/list.tpl',
			'last_list'		=> '_modules/app_poll/ss/last_list.tpl',
			'edit'			=> '_modules/app_poll/ss/edit.tpl',
			'edit_poll'			=> '_modules/app_poll/ss/edit_poll.tpl',
			'messages'		=> '_modules/app_poll/ss/messages.tpl',
			'community_block_right'	=> '_var_local_www_be/var/common/smarty/templates/modules/mod_svoi/ss/community_block_right.tpl',
		),
	),
	
	'tables' => array(
		'poll'			=> 'poll',
		'poll_answer'	=> 'poll_answer',
		'poll_voted'	=> 'poll_voted',
	),
	
);

?>


