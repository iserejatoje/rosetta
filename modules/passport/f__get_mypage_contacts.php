<?
$form = array();
$form['form'] = array();

if (isset($params[0]))
	$user = $OBJECTS['usersMgr']->GetUser($params[0]);
else
	$user = $OBJECTS['user'];

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'mypage_contacts')
{
	$form['form']['icq']			= App::$Request->Post['icq']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['skype']			= App::$Request->Post['skype']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['site']			= App::$Request->Post['site']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['form']['phone']			= App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
}	
else
{
	$form['form']['icq']			= $user->Profile['general']['ICQ'];
	$form['form']['skype']			= $user->Profile['general']['Skype'];
	$form['form']['site']			= $user->Profile['general']['Site'];
	$form['form']['phone']			= $user->Profile['general']['Phone'];
}

return $form;
?>