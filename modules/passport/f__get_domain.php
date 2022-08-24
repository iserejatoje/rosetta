<?php
$list = array(
	'TitleDomain' => $this->_env['site']['regdomain'],
	'Type' => 3,
	'ObjectID' => $OBJECTS['user']->ID,
);

LibFactory::GetStatic('domain');
$list['domain'] = Domain::GetInfo($list['Type'], $list['ObjectID']);
if (is_array($list['domain']))
	$list['TitleDomain'] = $list['domain']['Domain'];

return $list;
?>