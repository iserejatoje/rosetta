<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$signature = urldecode(App::$Request->Post['signature']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_QUOTES));
if(!is_string($signature))
	$signature = '';
	
$status = urldecode(App::$Request->Post['status']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_QUOTES));
if(!is_string($status))
	$status = '';
	
$smileoff	= App::$Request->Post['smileoff']->Int(0, Request::UNSIGNED_NUM);
$imageoff	= App::$Request->Post['imageoff']->Int(0, Request::UNSIGNED_NUM);
$avataroff	= App::$Request->Post['avataroff']->Int(0, Request::UNSIGNED_NUM);

if(strlen($signature) > $this->_config['limits']['max_len_talksignature'])
	UserError::AddErrorIndexed('signature', ERR_M_PASSPORT_INCORRECT_SETTINGS_SIGNATURE_LEN, $this->_config['limits']['max_len_talksignature']);

if (strlen($status) > $this->_config['limits']['max_len_user_status'])
	UserError::AddErrorIndexed('status', ERR_M_PASSPORT_INCORRECT_USER_STATUS_LEN, $this->_config['limits']['max_len_user_status']);

if(UserError::IsError())
	return false;

$OBJECTS['user']->Profile['themes']['talk']['Signature']	= $signature;
if ($OBJECTS['user']->IsInRole("m_forum_other_show_status"))
	$OBJECTS['user']->Profile['themes']['talk']['Status'] = $status;
$OBJECTS['user']->Profile['themes']['talk']['SmileOff']		= $smileoff;
$OBJECTS['user']->Profile['themes']['talk']['ImageOff']		= $imageoff;
$OBJECTS['user']->Profile['themes']['talk']['AvatarOff']	= $avataroff;

$OBJECTS['log']->Log(
		264,
		0,
		array()
		);
		
Response::Redirect('/' . $this->_env['section'] . '/msg.profile_talk.html');
?>
