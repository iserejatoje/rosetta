<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$email = App::$Request->Post['email']->Value();
$password = App::$Request->Post['password']->Value(); 
if (!is_string($password))
	$password = '';

/**
 * =======================================
 * ПРОВЕРЯЕМ Email
 * =======================================
 */
if ($email != $OBJECTS['user']->Email)
{
    if (empty($email))
        UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);
    elseif ( App::$Request->Post['email']->Email(false) === false )
        UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
    elseif (strlen($email) > $this->_config['limits']['max_len_email'])
        UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
    elseif ($email != $OBJECTS['user']->OurEmail && PUsersMgr::IsEmailExists($email, $OBJECTS['user']->Email))
        UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS);
	
	list(, $host) = explode("@", $email);
	if ($email != $OBJECTS['user']->OurEmail && STreeMgr::GetSiteIDByHost($host) !== null)
		UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_OUR_EMAIL);
}
else
	$email = $OBJECTS['user']->Email;

if (UserError::IsError())
	return false;

if (UserError::IsError())
	return false;

$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

if($this->_lib_mail !== null)
{
	$mail_services			= $this->_lib_mail->GetMailServices();
	$mail_default_service	= $this->_lib_mail->GetDefaultMailService();
}

if (empty($OBJECTS['user']->OurEmail))
{
	$username_reg =  App::$Request->Post['username_reg']->Value();	// проверка функцией валидности мыла
	$domain_reg =  App::$Request->Post['domain_reg']->Value();		// проверка функцией валидности мыла
	$login_reg = $email_reg =  App::$Request->Post['username_reg']->Value();
	
	if(App::$Request->Post['reg']->Int(0) != 1)
	{
		if(!empty($username_reg))
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_NOTREG);
		$email_reg = $login_reg = null;
	}
	else
	{
		if(!is_string($email_reg))
			$login_reg = $email_reg = '';
		
		if(sizeof($mail_services) > 1)
			$domain_reg = App::$Request->Post['domain_reg']->Value();
		else
			$domain_reg = $mail_default_service;
		if(!isset($mail_services[$domain_reg]))
		{
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
			return false;
		}
		
		if(empty($email_reg) || empty($domain_reg))
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);
		
		$email_reg.= '@'.$domain_reg;
		if (strlen($email_reg) > $this->_config['limits']['max_len_email'])
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
		elseif(!Data::Is_Email($email_reg))
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
		elseif(PUsersMgr::IsEMailExists($email_reg) || ($this->_lib_mail !== null && $this->_lib_mail->IsEMailExists($email_reg)))
		{
			UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS);
			if($this->_lib_mail !== null)
				$this->_examples['email_reg'] = $this->_lib_mail->GenerateEmail($login_reg, $domain_reg, $nickname);
		}
	}
}

if(UserError::IsError())
	return false;

/**
 * =======================================
 * ПРОВЕРЯЕМ Пароль
 * =======================================
 */
if(!PUsersMgr::CheckPassword($OBJECTS['user']->Email, $password))
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_INCORRECT_SETTINGS_PASSWORD);

if (UserError::IsError())
	return false;

$user = array(
	'ID'		=> $OBJECTS['user']->ID,
	'Email'		=> $email,
	'OurEmail'	=> $OBJECTS['user']->OurEmail,
    'Question'	=> $OBJECTS['user']->Question,
	'Answer'	=> $OBJECTS['user']->Answer,
    'Blocked'	=> $OBJECTS['user']->Blocked);

if( $email_reg )
{
	//$user['OurEmail'] = $email_reg;
	/*EventMgr::Raise('passport/user/create_email',
				array(
					'userid' => $OBJECTS['user']->ID,
					'password' => $password,
					'mail_sectionid' => $this->_config['mail']['sectionid'],
			));*/
	$status = $this->_lib_mail->CreateEmail($email_reg, $password);
	if($status<0)
	{
		UserError::AddErrorIndexed('email_reg', ERR_M_PASSPORT_REG_EMAIL_ERROR);
		return false;
	}
	$user['OurEmail'] = $email_reg;
	$OBJECTS['log']->Log(
			259,
			0,
			array('EMail' => $email, 'OurEMail' => $email_reg, 'Status' => $status)
			);
}

if($email != $OBJECTS['user']->Email)
{
	$OBJECTS['log']->Log(
			260,
			0,
			array('OldEMail' => $OBJECTS['user']->Email, 'NewEmail' => $email)
			);
}

$OBJECTS['log']->Log(
		261,
		0,
		array()
		);

if($email != $OBJECTS['user']->Email)
{
	$code = $OBJECTS['usersMgr']->AddActivationCode($OBJECTS['user']->ID, $email, 2);

	$subj = "Подтверждение смены E-mail на сайте ".$this->_env['site']['domain']."\n";
	$header = "From: remind@".$this->_env['site']['domain']."\nMIME-Version: 1.0\nContent-Type: text/html; charset=windows-1251\n";
	$msg = "Здравствуйте, ".$OBJECTS['user']->Profile['general']['ShowName'].".<br><br>
	Вы поменяли E-mail в своем профиле на сайте ".$this->_env['site']['domain'].".<br>
	Для подтверждения E-mail Вам необходимо пройти по следующей ссылке:<br>
	<a href=\"http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."\" target=\"_blank\">http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."</a>.<br><br>
	Если у Вас не получается перейти по ссылке, то введите код активации на странице <a href=\"http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php\" target=\"_blank\">http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php</a><br>
	Код активации: <b>".$code."</b><br><br>
	Если в течение 24 часов Вы не подтвердите новый E-mail, то активация будет отменена.<br><br>
	С уважением,<br>
	&nbsp;&nbsp;&nbsp;Служба поддержки ".$this->_env['site']['domain'];
	if (!mail($email, $subj, $msg, $header))
		error_log("Can't sending mail 'Change E-mail'");
	
	Response::Redirect('/'.$this->_env['section'].'/msg.activation.html');
}		
PUsersMgr::UpdateByID($user);
Response::Redirect('/' . $this->_env['section'] . '/msg.profile_id.html');

?>