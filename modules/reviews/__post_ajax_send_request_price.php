<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$phone = App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
	$name = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN);

	$errors = array();
	if (empty($phone))
		$errors['phone'] = "Не указан номер";

	if (empty($name))
		$errors['name'] = "Не указано имя";

	if(count($errors) > 0)
	{
		echo $json->encode(array(
			'status' => 'error',
			'errors' => $errors,
		));

		exit;
	}

	LibFactory::GetStatic('bl');
	$bl = BLFactory::GetInstance('system/config');
	$config = $bl->LoadConfig('module_engine', 'reviews');

	//  ========================
	LibFactory::GetStatic('mailsender');
	$mail = new MailSender();
	$mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">");
	$mail->AddHeader('Subject', "Запрос стоимости ".$this->_env['site']['domain'], 'utf-8');
	$mail->body_type = MailSender::BT_HTML;
	foreach($config['main_orders'] as $operator_mail)
	{
		$mail->AddAddress('to', $operator_mail);
	}

	$letter.= "С сайте ".$this->_env['site']['domain']." запрос на стоимость.<br/>";
	$letter.= "Телефон: ".$phone."<br/>";
	$letter.= "Имя: ".$name."<br/>";
	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
	$mail->SendImmediate();

	echo $json->encode(array(
		'status' => 'ok',
	));

	exit;