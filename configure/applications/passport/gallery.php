<?
global $OBJECTS, $CONFIG;

$index 	= '_design/200608_title/common/2pages.tpl';
$left	= '_design/200608_title/common/2pages_simple.tpl';
$right	= '_design/200608_title/common/left_block.tpl';
$login_form = array('type' => 'block', 'sectionid' => 3219, 'name' => 'login', 'lifetime' => 0);

if( $OBJECTS['user'] && $OBJECTS['user']->IsInRole('e_developer') || $CONFIG['env']['svoi'])
{
	$index 	= '_design/200608_title_blue/common/2pages.tpl';
	$left	= '_design/200608_title_blue/common/2pages_simple.tpl';
	$right	= '_design/200608_title_blue/common/left_block.tpl';
	$login_form = array('type' => 'widget', 'name' => 'login/default', 'params' => array('method' => 'sync', 'design' => 'title_blue', 'place' => 'header'));
}

return array(
	'module' => 'user_component',
	'space'		=> 'passport_gallery',
	
	'chain' => array(
		'root' => array('type' => 'component', 'name' => 'passport/gallery/gallery', 'lifetime' => 0),
		'comments' => array('type' => 'component', 'name' => 'passport/gallery/comments', 'page' => 'default.php', 'ref' =>
			array(
				'link' => array(
					array('source' => '$root:rolekey', 'destination' => '$this:rolekey'),
					array('source' => '$root:photoid', 'destination' => '$this:parentid'),
					array('source' => '$root:rolekey', 'destination' => '$this:rolekey') // я юля апстену убился, но в итоге смог сделать только так.
				),
				'condition' => array(
					array('type' => 'equal', 'field' => '$root:page', 'value' => 'photo'),
					//array('type' => 'notequal', 'field' => '$root:iscomments', 'value' => 0),
				),
			)
		),
	),

	'templates'	=> array(
		'index'			=> $index,
		'left'			=> $left,
		'right'			=> $right,
		'body'			=> '_design/200608_title_blue/common/uc_vertical.tpl' // шаблон для сведения в кучу
	),

	'blocks' => array(
		'main' => array(
			0 => array('type' => 'this', 'name' => 'main', 'lifetime' => 0, 'params'=>array()),
		),
		'left' => array(
			'menu_left' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_left', 'lifetime' => 0, 'params' => array()),
		),
		'header' => array(
			'login_form' => $login_form,
			'header_menu_bottom' => array('type' => 'block', 'sectionid' => 3219, 'name' => 'menu_bottom', 'lifetime' => 600, 'params' => array()),
			'weather' => array('type' => 'widget', 'name' => 'announce/weather/default', 'params' => array('method' => 'sync')),
			),
		'right' => array(
			'messages' => array('type' => 'widget', 'name' => 'announce/messages/default', 'params' => array('method' => 'sync')),
			'friends' => array('type' => 'widget', 'name' => 'announce/friends/default', 'params' => array('method' => 'sync')),
			'mail' => array('type' => 'block', 'name' => 'mail', 'sectionid' => 3999, 'lifetime' => 0, 'params' => array()),
			),
	),
);

?>