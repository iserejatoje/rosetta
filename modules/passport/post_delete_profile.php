<?php

$del = App::$Request->Post['del']->Value();
$password = App::$Request->Post['password']->Value(); 
if (!is_string($password))
	$password = '';

if ($del != 1)
	UserError::AddErrorIndexed('del', ERR_M_PASSPORT_NOT_ISSET_CHECKBOX_DELETE);

// ПРОВЕРЯЕМ Пароль
if(!PUsersMgr::CheckPassword($OBJECTS['user']->Email, $password))
	UserError::AddErrorIndexed('password_delete', ERR_M_PASSPORT_INCORRECT_SETTINGS_PASSWORD);

if (UserError::IsError())
	return false;

// Постановка в очередь на удаление.
LibFactory::GetMStatic('events','eventmgr');
EventMgr::Raise('passport/delete', array('id' => $OBJECTS['user']->ID));

PUsersMgr::Delete($OBJECTS['user']->ID, 1);
	
$OBJECTS['user']->Logout();

Response::Redirect('/'.$this->_env['section'].'/msg.delete_profile_ok.html');
?>