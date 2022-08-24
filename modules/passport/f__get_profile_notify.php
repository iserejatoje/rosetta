<?
$form = array();
$form['form'] = array();

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'profile_notify')
{
	$form['form']['imnotify']			= App::$Request->Post['imnotify']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['friendinvite']		= App::$Request->Post['friendinvite']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$form['form']['imnotify']			= $OBJECTS['user']->Profile['themes']['talk']['ImNotify'];
	$form['form']['friendinvite']		= $OBJECTS['user']->Profile['themes']['talk']['FriendInvite'];
}

return $form;
?>