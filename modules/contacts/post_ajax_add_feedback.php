<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$username = App::$Request->Post['customerFeedbackName']->Value(Request::OUT_HTML_CLEAN);
	$email    = App::$Request->Post['customerFeedbackMail']->Email(false);
	$text     = App::$Request->Post['customerFeedbackText']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

	if (strlen($username) == 0)
		UserError::AddErrorIndexed('customerFeedbackName', ERR_M_CONTACTS_EMPTY_AUTHOR);

	if (App::$Request->Post['Email']->Value() != "" && $Email === false)
		UserError::AddErrorIndexed('customerFeedbackMail', ERR_M_CONTACTS_INCORRECT_EMAIL);

	if (strlen($text) == 0)
		UserError::AddErrorIndexed('customerFeedbackText', ERR_M_CONTACTS_EMPTY_TEXT);

	if(UserError::IsError())
	{
		echo $json->encode(array(
				'status' => 'error',
				'errors' => UserError::GetErrorsTextWithoutAnchor("\n"),
			));

		exit;
	}

	LibFactory::GetStatic('mailsender');
	$mail = new MailSender();
	$mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
	$mail->AddHeader('Subject', "Новое сообщение с сайта ".$this->_env['site']['domain'], 'utf-8');
	$mail->body_type = MailSender::BT_HTML;

	foreach($this->_config['notice_mails'] as $notice_email)
	{
		$mail->AddAddress('to', $notice_email);
	}

	$letter = "Привет!<br/><br/>";
	$letter.= "На сайте ".$this->_env['site']['domain']." появился новый отзыв.<br/>";
	$letter.= "Его оставил пользователь с именем ".$username."<br/>";
	$letter.= "Электронная почта: ".$email."<br/>";
	$letter.= "Текст:<br/>".$text."<br/><br/>";
	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
	$mail->SendImmediate();

	echo $json->encode(array(
		'status' => 'ok',
	));

	exit;
