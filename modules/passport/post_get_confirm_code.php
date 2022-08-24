<?

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

LibFactory::GetStatic('antiflood2');
if ( !AntiFlood2::Score('passport:confirm_mobile', AntiFlood2::K_USER, 300, 1) )
{
	echo $json->encode(array(
		'status' => 'error',
		'message' => 'Вы слишком часто пытаетесь получить код. Попробуйте поздее',
	));	
	exit;
}

$phone = App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
$phone = trim($phone);

LibFactory::GetStatic("data");
		
if ( !Data::Is_Phone($phone) )
	UserError::AddError(ERR_M_PASSPORT_ERROR_LENGTH_PHONE);

if (UserError::IsError())
{
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));
	
	exit;
}

// такой номер уже есть
if (App::$User->Plugins->Phones->IsExists($phone) === true)
	UserError::AddError(ERR_M_PASSPORT_IS_REGISTER_PHONE);

if (UserError::IsError())
{
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));
	
	exit;
}

// Генерим код и если что говорим ошибку
$code = App::$User->Plugins->Phones->GenerateCode($phone);
if ($code === false)
	UserError::AddError(ERR_M_PASSPORT_UNKNOWN_ERROR);

if (UserError::IsError())
{
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));
	
	exit;
}

LibFactory::GetMStatic("sms", "sender");

try 
{	
	$sender = SMSSender::GetProvider("marketsms");

	//Добавляем сообщение в стек либы
	$sender->PushMessage("Код подтверждения ".$code, array($phone));
	//Отправляем
	$sender->Send($this->_env['site']['domain']);
	
	echo $json->encode(array(
		'status' => 'ok',
		'message' => "На номер ".$phone." отправлен код подтверждения",
	));
}
catch (BTException $e)
{
	UserError::AddError(ERR_M_PASSPORT_SEND_SMS_ERROR);
	echo $json->encode(array(
		'status' => 'error',
		'message' => UserError::GetErrorsTextWithoutAnchor("\n")
	));	
}

exit;