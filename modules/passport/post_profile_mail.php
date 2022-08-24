<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

$signature			= App::$Request->Post['signature']->Value(Request::OUT_HTML_CLEAN);
$replyto			= App::$Request->Post['replyto']->Value();
$messagecolpp		= App::$Request->Post['messagecolpp']->Int(0, Request::UNSIGNED_NUM);
$addresscolpp		= App::$Request->Post['addresscolpp']->Int(0, Request::UNSIGNED_NUM); 
$messagesortfield	= App::$Request->Post['messagesortfield']->Alpha('');
$messagesortord		= App::$Request->Post['messagesortord']->Alpha('');
$addresssortfield	= App::$Request->Post['addresssortfield']->Alpha('');
$addresssortord		= App::$Request->Post['addresssortord']->Alpha('');
$saveinsent			= App::$Request->Post['saveinsent']->Int(0, Request::UNSIGNED_NUM);
//$logoutcleartrash	= App::$Request->Post['logoutcleartrash']->Int(0, Request::UNSIGNED_NUM);
if(!is_string($signature)) $signature = '';
if(!is_string($replyto)) $replyto = '';
	
if(strlen($signature) > $this->_config['limits']['max_len_signature'])
	UserError::AddErrorIndexed('signature', 
			ERR_M_PASSPORT_INCORRECT_SETTINGS_SIGNATURE_LEN, $this->_config['limits']['max_signature_let']);

if (!empty($replyto))
{
	if (  App::$Request->Post['replyto']->Email(false) === false)
		UserError::AddErrorIndexed('replyto',
				ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
	elseif (strlen($replyto) > $this->_config['limits']['max_len_email'])
		UserError::AddErrorIndexed('replyto',
				ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN, $this->_config['limits']['max_len_email']);
}

if(!in_array($messagecolpp, $this->_lib_mail->col_pp))
	$messagecolpp = $this->_lib_mail->default_profile['MessageColPP'];
if(!in_array($addresscolpp, $this->_lib_mail->col_pp))
	$addresscolpp = $this->_lib_mail->default_profile['AddressColPP'];

if(!isset($this->_lib_mail->message_sf_arr[$messagesortfield]))
	$messagesortfield = $this->_lib_mail->default_profile['MessageSortField'];
if(!isset($this->_lib_mail->so_arr[$messagesortord]))
	$messagesortord = $this->_lib_mail->default_profile['MessageSortOrd'];
if(!isset($this->_lib_mail->address_sf_arr[$addresssortfield]))
	$addresssortfield = $this->_lib_mail->default_profile['AddressSortField'];
if(!isset($this->_lib_mail->so_arr[$addresssortord]))
	$addresssortord = $this->_lib_mail->default_profile['AddressSortOrd'];
	
if(UserError::IsError())
	return false;

//error_log('ms: '.$messagesortfield.'-'.$messagesortord.' as: '.$addresssortfield.'-'.$addresssortord);
$OBJECTS['user']->Profile['modules']['mail']['Signature']			= $signature;
$OBJECTS['user']->Profile['modules']['mail']['ReplyTo']				= $replyto;
$OBJECTS['user']->Profile['modules']['mail']['MessageColPP']		= $messagecolpp;
$OBJECTS['user']->Profile['modules']['mail']['AddressColPP']		= $addresscolpp;
$OBJECTS['user']->Profile['modules']['mail']['MessageSortField']	= $messagesortfield;
$OBJECTS['user']->Profile['modules']['mail']['MessageSortOrd']		= $messagesortord;
$OBJECTS['user']->Profile['modules']['mail']['AddressSortField']	= $addresssortfield;
$OBJECTS['user']->Profile['modules']['mail']['AddressSortOrd']		= $addresssortord;
$OBJECTS['user']->Profile['modules']['mail']['SaveInSent']			= $saveinsent;
//$OBJECTS['user']->Profile['modules']['mail']['LogoutClearTrash']	= $logoutcleartrash;	
$OBJECTS['log']->Log(
		262,
		0,
		array()
		);
Response::Redirect('/' . $this->_env['section'] . '/msg.profile_mail.html');

?>