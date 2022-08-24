<?

if(App::$Request->Post['rtype']->Value() == 'ajax')
{
	include_once $CONFIG['engine_path'].'include/json.php';
	
	$json = new Services_JSON();
	$json->charset = 'WINDOWS-1251';
}

if(!$OBJECTS['user']->IsAuth())
{
	if(App::$Request->Post['rtype']->Value() == 'ajax') {
		$url = '/'.$this->_env['section'].'/'.$this->_config['files']['get']['friends_invite']['string'];
		$url .= '?id='.App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM).'&rtype=ajax';
		Response::Redirect($url);
	} else
		$this->redirect_not_authorized();
}

if(App::$Request->Post['rtype']->Value() == 'ajax')
	App::$Request->Post['text']	= iconv('UTF-8', 'WINDOWS-1251', App::$Request->Post['text']->Value());


$FriendID = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
$Text = App::$Request->Post['text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
	
$uto = $OBJECTS['usersMgr']->GetUser($FriendID, false, false);
if($uto->ID == 0) {
	UserError::AddErrorIndexed('friend_guest', ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS);
	App::$Request->Post['id'] = 0;
}

if(App::$Request->Post['rtype']->Value() != 'ajax' && strlen($Text) > $this->_config['limits']['max_len_message_text'])
	UserError::AddErrorIndexed('text', ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_TOLONG, $this->_config['limits']['max_len_message_text']);
elseif ( App::$Request->Post['rtype']->Value() == 'ajax' && strlen($Text))
	$Text = substr($Text, 0, $this->_config['limits']['max_len_message_text']);
	
if($FriendID == $OBJECTS['user']->ID)
	UserError::AddErrorIndexed('friend', ERR_M_PASSPORT_INCORRECT_FRIEND_ID);

if( $OBJECTS['user']->Plugins->Friends->IsFriend($FriendID) )
	UserError::AddErrorIndexed('friend_exist', ERR_M_PASSPORT_INCORRECT_FRIEND_EXISTS);


if (UserError::IsError()) {
	
	if(App::$Request->Post['rtype']->Value() == 'ajax') {
		echo $json->encode(array(
					'status' => 'error',
					'data' => UserError::GetErrorsText("\n")
					));
		exit();
	} else
		return false;
}

$OBJECTS['user']->Plugins->Friends->AddFriend($FriendID, $Text);

if(App::$Request->Post['rtype']->Value() == 'ajax') {
	echo $json->encode(array('status' => 'invited','data' => UserError::GetError(ERR_M_PASSPORT_FRIEND_INVITE_SENT)));
	exit();
}
else
	Response::Redirect('/' . $this->_env['section'] . '/msg.friends_invited.html');
?>