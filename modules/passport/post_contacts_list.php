<?php

include_once $CONFIG['engine_path'].'include/json.php';
$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

if (!$OBJECTS['user']->IsAuth() || !isset($_POST['user_id']) || !is_numeric($_POST['user_id']) || $_POST['user_id'] < 1 || !isset($_POST['type']))
{
	$response = array('status' => 'error');
	echo $json->encode($response);
	exit();
}

if ($_POST['type'] == 'del')
{
	if ($OBJECTS['user']->Plugins->Messages->DeleteFromContactsList($_POST['user_id']))
		$response = array('status' => 'ok');
}
elseif ($_POST['type'] == 'add')
{
	if ($OBJECTS['user']->Plugins->Messages->AddToContactsList($_POST['user_id']))
		$response = array('status' => 'ok_add');
}
echo $json->encode($response);
exit();
