<?
	if ( App::$Request->requestMethod === Request::M_POST )
	{
		$form['Username'] = App::$Request->Post['username']->Value(Request::OUT_HTML_CLEAN);
		$form['Surname']  = App::$Request->Post['surname']->Value(Request::OUT_HTML_CLEAN);
		$form['Text']     = App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN);
	}
	else
	{
		$form['Username'] = "";
		$form['Surname'] = "";
		$form['Text'] = "";
	}

	$params = array(
		'form' => $form
	);

	return STPL::Fetch('modules/reviews/form', $params);