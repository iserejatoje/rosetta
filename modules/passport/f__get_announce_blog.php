<?
$form = array();
$form['form'] = array();

if(App::$Request->requestMethod === Request::M_POST &&  App::$Request->Post['action'] == 'announce_bblog')
{
	$form['form']['blogfavorites']		=  App::$Request->Post['blogfavorites']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$form['form']['blogfavorites']		= $OBJECTS['user']->Profile['widgets']['announce']['blog']['Favorites'];
}

return $form;
?>