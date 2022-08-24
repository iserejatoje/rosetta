<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$phone = App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
	$address = App::$Request->Post['address']->Value(Request::OUT_HTML_CLEAN);
	$name = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN);

	$errors = array();
	if (empty($phone))
		$errors['phone'] = "Не указан номер";

	if (empty($address))
		$errors['address'] = "Не указан адрес";

	if (empty($name))
		$errors['name'] = "Не указано имя";

	if(count($errors) > 0)
	{
		echo $json->encode(array(
			'status' => 'error',
			'errors' => $errors,
		));
	}

	LibFactory::GetStatic('bl');
	$bl = BLFactory::GetInstance('system/config');
	$config = $bl->LoadConfig('module_engine', 'reviews');


	$subj = "Онлайн заявка ".$this->_env['site']['domain'];
	$letter.= "С сайте ".$this->_env['site']['domain']." пришла онлайн заявка.<br/>";
	$letter.= "Телефон: +".$phone."<br/>";
	$letter.= "Адрес: +".$address."<br/>";
	$letter.= "Имя: +".$name."<br/>";
	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	foreach($config['main_orders'] as $operator_mail)
	{
		mail($operator_mail, $subj, $letter);
	}

	echo $json->encode(array(
		'status' => 'ok',
	));

	exit;