<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	if($this->catalogMgr->inmode() == false)
	{
		echo $json->encode(array(
			'status' => 'ok',
			'inmode' => false
		));
		exit;
	}

	$phone = App::$Request->Post['callbackPhone']->Value(Request::OUT_HTML_CLEAN);
	$name = App::$Request->Post['callbackName']->Value(Request::OUT_HTML_CLEAN);

	$errors = array();
	if (empty($phone))
		$errors['callbackPhone'] = "Не указан номер";

	if (empty($name))
		$errors['callbackName'] = "Не указано имя";

	if(count($errors) > 0)
	{
		echo $json->encode(array(
			'status' => 'error',
			'errors' => $errors,
		));

		exit;
	}

	// =======================================
	LibFactory::GetStatic('mailsender');
	$mail = new MailSender();
	$mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">");
	$mail->AddHeader('Subject', "Онлайн заявка ".$this->_env['site']['domain'], 'utf-8');
	$mail->body_type = MailSender::BT_HTML;
	foreach($this->_config['call_email'] as $operator_mail)
	{
		$mail->AddAddress('to', $operator_mail);
	}

	$letter.= "С сайте ".$this->_env['site']['domain']." пришла онлайн заявка звонка.<br/>";
	$letter.= "Телефон: ".$phone."<br/>";
	$letter.= "Имя: ".$name."<br/>";
	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
	$mail->SendImmediate();

	echo $json->encode(array(
		'status' => 'ok',
	));

	exit;