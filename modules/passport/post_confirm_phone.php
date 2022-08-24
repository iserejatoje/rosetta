<?

if(!App::$User->IsAuth())
	$this->redirect_not_authorized();

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

$is_error = false;

$code = App::$Request->Post['code']->Value(Request::OUT_HTML_CLEAN);

//Проверяем код
$phone = App::$User->Plugins->Phones->CheckCode($code);
if ($phone === false)
{
	UserError::AddError(ERR_M_PASSPORT_CHECK_CODE_FAILURE);
	
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));
	
	exit;
}

//регистриуем номер телефона и редиректим
$registered = App::$User->Plugins->Phones->Register($phone);
if ($registered === false)
{
	UserError::AddError(ERR_M_PASSPORT_CHECK_CODE_FAILURE);
	
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));
	
	exit;
}

echo $json->encode(array(
	'status' => 'ok',
	'message' => 'Номер '.$phone.' подтверждён',
));
exit;
