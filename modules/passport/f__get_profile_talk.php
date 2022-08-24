<?
$form = array();
$form['form'] = array();

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'profile_talk')
{
	$form['form']['signature']			= App::$Request->Post['signature']->Value(Request::OUT_HTML);
	$form['form']['status']				= App::$Request->Post['status']->Value(Request::OUT_HTML);
	$form['form']['smileoff']			= App::$Request->Post['smileoff']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['imageoff']			= App::$Request->Post['imageoff']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['avataroff']			= App::$Request->Post['avataroff']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$form['form']['signature']			= $OBJECTS['user']->Profile['themes']['talk']['Signature'];
	$form['form']['status']				= $OBJECTS['user']->Profile['themes']['talk']['Status'];
	$form['form']['smileoff']			= $OBJECTS['user']->Profile['themes']['talk']['SmileOff'];
	$form['form']['imageoff']			= $OBJECTS['user']->Profile['themes']['talk']['ImageOff'];
	$form['form']['avataroff']			= $OBJECTS['user']->Profile['themes']['talk']['AvatarOff'];
}

return $form;
?>