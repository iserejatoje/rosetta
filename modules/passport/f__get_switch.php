<?

	$form = array();
	if ( App::$Request->requestMethod === Request::M_POST ) {
		$form['email']	= App::$Request->Post['email']->Value(Request::OUT_HTML);
		$form['id']		= App::$Request->Post['id']->Int(null, Request::UNSIGNED_NUM);
		$form['url']	= App::$Request->Post['url']->Url('');
	} else {
		$form['email']	= App::$Request->Get['email']->Email();
		$form['id']		= App::$Request->Get['id']->Int(null, Request::UNSIGNED_NUM);
		$form['url']	= App::$Request->Get['url']->Url('');
	}
	
	return array(
		'form' => $form
	);
?>