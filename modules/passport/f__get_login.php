<?
/**
* здесь можно добавить проверку на то по HTTPS пользователь пришел или по HTTP
* и если по HTTP, то редиректить на HTTPS
*
*/


	$form = array();
	if ( App::$Request->requestMethod === Request::M_POST ) {
		$form['email'] = App::$Request->Post['email']->Email(App::$Request->Post['email']);
		$form['remember'] = App::$Request->Post['remember']->Enum(0, array(0,1));
		$form['url'] = App::$Request->Post['url']->Url('');
	} else {
		$form['email'] = App::$Request->Get['email']->Email();	
		$form['remember'] = 1;
		$form['url'] = App::$Request->Get['url']->Url('');
	}
	
	return array(
		'form' => $form
	);
?>