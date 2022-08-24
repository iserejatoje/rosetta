<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
LibFactory::GetStatic('data');	
$password = App::$Request->Post['password']->Value();
$password2 = App::$Request->Post['password2']->Value();
$password_old = App::$Request->Post['password_old']->Value();

if (empty($password_old))
    UserError::AddErrorIndexed('password_old', ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_EMPTY);
elseif (!PUsersMgr::CheckPassword($OBJECTS['user']->Email, $password_old))
    UserError::AddErrorIndexed('password_old', ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_WRONG);

if ($password=='' || $password2=='')
    UserError::AddErrorIndexed('password', ERR_M_PASSPORT_EMPTY_PASSWORD);
elseif (strcmp($password, $password2) != 0)
    UserError::AddErrorIndexed('password', ERR_M_PASSPORT_PASSWORD_NOT_EQUAL);


if (UserError::IsError())
	return false;

PUsersMgr::SetPassword($OBJECTS['user']->Email, $password, $OBJECTS['user']->SessionCode);

Response::Redirect('/' . $this->_env['section'] . '/msg.profile_password.html');
?>