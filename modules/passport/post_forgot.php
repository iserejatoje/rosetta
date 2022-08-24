<?

if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

$step = $OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step'];

if($step === 'step1')
{
	$email = App::$Request->Post['email']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		
	$user = PUsersMgr::GetUserInfoArrayByEmail($email);

	$code = DATA::GetRandStr(8);

	PUsersMgr::SetForgotCode($user['UserID'], $code);	
	unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step']);

	$message = 'Здравствуйте!
Кто-то, возможно вы, воспользовался сервисом восстановления пароля на сайте ('.$this->_env['site']['domain'].').
Для восстановления пароля перейдите по ссылке (http://'.$this->_env['site']['domain'].'/account/forgot.php?code='.$code.')

Либо введите секретный код: '.$code.'
на странице (http://'.$this->_env['site']['domain'].'/account/forgot.php?code=)

Если вы не отправляли запрос на восстановление пароля, то удалите это письмо.

Спасибо за обращение к нашему сайту!';

	$header = "From: no.reply@{$this->_env['site']['domain']}\nContent-Type: text/plain; charset=utf-8;\n\n";

	mail($email,'Восстановление пароля', $message, $header);
	
	$OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_email'] = $email;
	$OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step'] = 'step3';
	
	Response::Redirect('/'.$this->_env['section'].'/msg.remind_link_sent.html');
}
else if($step === 'step3')
{
	$password = App::$Request->Post['new_pass']->Value();
	$password2 = App::$Request->Post['new_pass2']->Value();
	if($password=="" || $password2=="")
		UserError::AddErrorIndexed('password', ERR_M_PASSPORT_EMPTY_PASSWORD);
	else if(strcmp($password, $password2) != 0)
		UserError::AddErrorIndexed('password', ERR_M_PASSPORT_PASSWORD_NOT_EQUAL);
	
	if(!UserError::IsError())
	{
	
		PUsersMgr::SetPassword($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_email'], $password);
		
		unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step']);
		unset($OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_email']);				
		Response::Redirect('/'.$this->_env['section'].'/msg.remind_ok.html');
	}
}
else
	$OBJECTS['user']->Session[$this->_env['sectionid']]['forgot_step'] = 'step1';

if(!UserError::IsError())
	Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['forgot']['string'].'?rand='.rand(1000000,9999999));

?>