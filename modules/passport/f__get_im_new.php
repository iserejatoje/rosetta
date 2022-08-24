<?
$form = array();

if( App::$Request->Get['m']->Int(false, Request::UNSIGNED_NUM)) // тянем сообщение
{
	$form['message'] = $OBJECTS['user']->Plugins->Messages->GetMessage(App::$Request->Get['m']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML), 1, true);
	if($form['message'] != null)
	{
		App::$Request->Get['to']= $form['message']['UserFrom']; // перепишем пользователя
		$form['Type']			= $form['message']['Type'];
		$form['RefererTitle']	= $form['message']['RefererTitle'];
		$form['RefererUrl']		= $form['message']['RefererUrl'];
	}
}

$form['nicknameto'] = '';
if(App::$Request->requestMethod !== Request::M_POST)
{
	$to = App::$Request->Get['to']->Int(0, Request::UNSIGNED_NUM);
	$req =& App::$Request->Get;
}
else
{
	$to = App::$Request->Post['to']->Int(0, Request::UNSIGNED_NUM);
	$req =& App::$Request->Post;
}
$form['to'] = $to;
if($to !== 0)
{
	$uto = $OBJECTS['usersMgr']->GetUser($to);
	if($uto->ID > 0)
	{
		LibFactory::GetStatic('datetime_my');
		$form['nicknameto'] = $uto->NickName;
		$form['UserInfo'] = $uto;
		$form['showvisited'] = $uto->Profile['general']['showvisited'];
	}
}
elseif( App::$Request->Post['nicknameto']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML) != '' )
	$form['nicknameto'] = App::$Request->Get['nicknameto']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);

if( App::$Request->Post['title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML) != '')
	$form['title'] = App::$Request->Post['title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	
if( App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML) != '')
	$form['text'] = App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	
if( isset($req['type']) )
{
	$form['Type']			= $req['type']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	$form['DType']			= $OBJECTS['user']->Plugins->Messages->typesdesc[$req['type']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML)];
}
if( isset($req['title']) )
	$form['RefererTitle']	= $req['title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
if( isset($req['url']) && $req['url']->Url(false) !== false )
	$form['RefererUrl']		= $req['url']->Url('', false);
	
if($params[0]['rtype'] == 'ajax')
{
	$form['RefererTitle'] = iconv('UTF-8', 'WINDOWS-1251', $form['RefererTitle']);
	$form['RefererUrl'] = iconv('UTF-8', 'WINDOWS-1251', $form['RefererUrl']);
}

$form['smiles'] = $OBJECTS['user']->Plugins->Messages->GetSmilesInfo();

return $form;
?>