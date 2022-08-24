<?
	//print_r($_POST); exit;

	 

	$Username = App::$Request->Post['username']->Value(Request::OUT_HTML_CLEAN);
	$Surname = App::$Request->Post['surname']->Value(Request::OUT_HTML_CLEAN);
	$Text = App::$Request->Post['text']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);


	if (strlen($Username) == 0 && strlen($Surname) == 0)
		UserError::AddErrorIndexed('username', ERR_M_REVIEWS_EMPTY_USERNAME);

	if (strlen($Text) == 0)
		UserError::AddErrorIndexed('text', ERR_M_REVIEWS_EMPTY_TEXT);

	if (strlen($Text) > 1000)
		UserError::AddErrorIndexed('text', ERR_M_REVIEWS_EXCEED_TEXT);

	if(UserError::IsError())
	{
		return false;

	}

	$sectionId = $this->_env['sectionid'];
	if($this->_config['root'])
		$sectionId = $this->_config['root'];

	$info = array(
		'SectionID' => $sectionId,
		'Text'      => $Text,
		'Username'  => $Username,
		'Surname'   => $Surname,
		'IsVisible'	=> 0,
	);

	$review = new Review($info);
	$review->Update();

	LibFactory::GetStatic('mailsender');
	$mail = new MailSender();
	$mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">");
	$mail->AddHeader('Subject', "Новый отзыв на сайте ".$this->_env['site']['domain'], 'utf-8');
	$mail->body_type = MailSender::BT_HTML;
	$mail->AddAddress('to', $this->_config['recipient_email']);

	$letter = "Привет!<br/><br/>";
	$letter.= "На сайте ".$this->_env['site']['domain']." появился новый отзыв.<br/>";
	$letter.= "Его оставил пользователь с именем ".$Username." ".$Surname."<br/>";
	$letter.= "Текст:<br/>".$Text."<br/><br/>";
	// $letter.= "Для модерирования пройдите по ссылке <a href=\"http://___/admin/site/___/reviews/.module/?treelisth_scol=1&treelisth_sord=0\">ссылке</a><br/><br/>";
	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
	$mail->SendImmediate();

	 

	Response::Redirect('/'.$this->_env['section'].'/notification/success_submit/');

	exit;
