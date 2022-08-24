<?

static $help_error_code = 0;
define('ERR_M_HELP_MASK', 0x00300000);
define('ERR_M_HELP_NAMEID_IS_EXISTS', ERR_M_HELP_MASK | $help_error_code++);
$ERROR[ERR_M_HELP_NAMEID_IS_EXISTS]	= 'Введенное вами имя ссылки уже занято.';
	
define('ERR_M_HELP_NAMEID_IS_EMPTY', ERR_M_HELP_MASK | $help_error_code++);
$ERROR[ERR_M_HELP_NAMEID_IS_EMPTY]= 'Необходимо ввести имя ссылки.';

define('ERR_M_HELP_NAME_IS_EMPTY', ERR_M_HELP_MASK | $help_error_code++);
$ERROR[ERR_M_HELP_NAME_IS_EMPTY]= 'Необходимо ввести имя.';

define('ERR_M_HELP_NODE_NOT_FOUND', ERR_M_HELP_MASK | $help_error_code++);
$ERROR[ERR_M_HELP_NODE_NOT_FOUND]= 'Раздел не найден.';

return array(
	
	'title'		=> 'Помощь',
	'db'		=> 'catalog',
	'prefix'	=> 'help_',
	
	'files_dir'			=> '/common_fs/i/catalog/help/files/', // на случай, если забудут указать, значит все ффтопку
	'files_url'			=> 'http://other.img.rugion.ru/_i/catalog/help/files/',
	'images_cont_dir'	=> '/common_fs/i/catalog/help/img/',
	'images_cont_url'	=> 'http://other.img.rugion.ru/_i/catalog/help/img/',
	
	'fields' => array(
		'text' => array(
			'title'		=> 'Текст',
			'required'	=> false,
			'default'	=> '',
			'type'		=> 'wysiwyg',
			'desc'		=> 'Текст отображаемый на странице',
			'width'		=> '100%',
			'height'	=> 500,
		),
	),
	
	
	'templates' => array(
		'index'				=> '_design/200608_title/common/2pages.tpl',
		'left'				=> '_modules/mod_svoi/left_block.tpl',
		'sectiontitle'		=> '_modules/mod_svoi/sectiontitle.tpl',
		'ssections' => array(		
			'default'		=> '_modules/mod_help/ss/default.tpl',
			'describe'		=> '_modules/mod_help/ss/describe.tpl',
			'messages'		=> '_modules/mod_help/ss/messages.tpl',
		),
	),
	
	'files' => array(
		'get' => array(
			'describe'	=> array('regexp' => '@^(.+)$@', 'matches' => array(1 => 'path')),
			'default'	=> array('string' => '@^(.*)$@'),
		),

		'post' => array(
		),

		'block' => array(
		),
	),
		
	'blocks' => array(
		'header' => array(
		),
		
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
		),
		
		'left' => array(		
			/*array('type' => 'widget', 'name' => 'announce/catalog/default', 'params' => array('method' => 'sync', 'prefix' => 'help_'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:rolekey', 'destination' => '$this:rolekey'),
						array('source' => '$main/0:nodeid', 'destination' => '$this:id')
					),
				),
			),*/
			
			array('type' => 'widget', 'name' => 'announce/catalog/slide', 'params' => array('method' => 'sync', 'prefix' => 'help_'),
				'ref' => array(
					'link' => array(
						array('source' => '$main/0:rolekey', 'destination' => '$this:rolekey'),
						array('source' => '$main/0:nodeid', 'destination' => '$this:id')
					),
				),
			),
		),
		
		'right' => array(
		),
	)
);
?>