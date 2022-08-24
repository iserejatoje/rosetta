<?php

if(App::$Request->Get['rtype']->Value() == 'ajax')
{
	include_once $CONFIG['engine_path'].'include/json.php';
	
	$json = new Services_JSON();
	$json->charset = 'WINDOWS-1251';
}

if(!$OBJECTS['user']->IsAuth() && $this->_page != 'friends_invite')
{
	if(App::$Request->Get['rtype']->Value() == 'ajax') {
		echo $json->encode(array(
				'status' => 'error',
				'data' => UserError::GetError(ERR_M_PASSPORT_NOT_ENOUGH_RIGHTS)
			));
		exit();
	} else
		$this->redirect_not_authorized();
}

if ( !isset(App::$Request->Get['id']) )
	App::$Request->Get['id'] = 0;

if ( App::$Request->Get['id']->Int(false, Request::UNSIGNED_NUM) === false )
	UserError::AddErrorIndexed('friend', ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS);

if (UserError::IsError() && App::$Request->Get['rtype']->Value() == 'ajax') {
	
	echo $json->encode(array(
		'status' => 'error',
		'data' => UserError::GetErrorsText("\n")
	));
	exit();
}// elseif (UserError::IsError())
	//Response::Redirect('/' . $this->_env['section'] . '/'.$this->_config['files']['get']['friends']['string']);
	

if ( $this->_page == 'friends_refuse') {

	$OBJECTS['user']->Plugins->Friends->RemoveFriend( App::$Request->Get['id']->Int() );
	if ( App::$Request->Get['id']->Int() > 0 )
		UserError::AddErrorIndexed('friends_refuse', ERR_M_PASSPORT_FRIEND_INVITE_REFUSE);
	else {
		UserError::AddErrorIndexed('friends_refuse', ERR_M_PASSPORT_FRIEND_INVITE_REFUSE_ALL);
		$this->_page = 'friends_all_refuse';
	}
}

if ( $this->_page == 'friends_remove') {
	$OBJECTS['user']->Plugins->Friends->RemoveFriend( App::$Request->Get['id']->Value(), 1 );
	UserError::AddErrorIndexed('friend_remove', ERR_M_PASSPORT_FRIEND_INVITE_REMOVE);
}

if ( $this->_page == 'friends_approve') {
	$OBJECTS['user']->Plugins->Friends->AddFriend( App::$Request->Get['id']->Value() );
	UserError::AddErrorIndexed('friends_approve', ERR_M_PASSPORT_FRIEND_INVITE_APPROVED);
}

if ( App::$Request->Get['rtype']->Value() == 'ajax' ) {
	
	if ( $this->_page == 'friends_invite') {
		
		if ( !$OBJECTS['user']->IsAuth() ) {
			$template = $this->_config['templates']['ssections']['login_ajax'];
			$response = array(
				'status' => 'login', 
				'data' => $this->RenderBlock($template, null, array($this, '_Get_Login'))
			);
		} else {
			$template = $this->_config['templates']['friends_ajax_invite'];
			$response = array(
				'status' => 'ok', 
				'data' => $this->RenderBlock($template, null, array($this, '_Get_Friends_Invite'))
			);
		}		
		
		echo $json->encode( $response );
	} else
		echo $json->encode(array('status' => 'OK','data' => UserError::GetErrorsText("\n")));
	exit;
} else {
	if ( $this->_page == 'friends_invite') {
		$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
		$OBJECTS['title']->AppendBefore('Добавление друга');

		return $this->_Get_Friends_Invite();
	} else 
		Response::Redirect('/' . $this->_env['section'] . '/msg.'.$this->_page.'d.html');
}

?>