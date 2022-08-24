<?
	$form = array(
		'UserInfo' => null
	);
	
	if(App::$Request->requestMethod !== Request::M_POST) {
		$form['id'] = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$form['text'] = '';
	} else {
		$form['id']= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$form['text'] = App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	}

	$uto = $OBJECTS['usersMgr']->GetUser($form['id']);
	if($uto !== null && $uto->ID > 0)
	{
		LibFactory::GetStatic('datetime_my');
		$form['UserInfo'] = $uto;
		$form['showvisited'] = $uto->Profile['general']['showvisited'];
	}
	
return $form;
?>