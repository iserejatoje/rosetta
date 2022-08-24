<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$icq = App::$Request->Post['icq']->Value();
if(!empty($icq))
{
	if(eregi('[^0-9-]+', $icq))
	{
		UserError::AddErrorIndexed('icq', ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_WRONG);
	}
	else
	{
		$icq_test = str_replace('-', '', $icq);
		if(strlen($icq_test) < 5)
			UserError::AddErrorIndexed('icq', ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_WRONG);
		elseif(strlen($icq) > $this->_config['limits']['max_len_icq'])
			UserError::AddErrorIndexed('icq', ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_LEN, $this->_config['limits']['max_len_icq']);
	}
}

$skype = App::$Request->Post['skype']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
if(strlen($skype) > $this->_config['limits']['max_len_skype'])
	UserError::AddErrorIndexed('skype', ERR_M_PASSPORT_INCORRECT_SETTINGS_SKYPE_LEN, $this->_config['limits']['max_len_skype']);

$site = App::$Request->Post['site']->Value();
if(!empty($site))
{
	if(!preg_match('/^(?:(?:https?|ftp|file):\/\/)?([\-A-Za-z0-9+&@#\/%\?=~_|!:,\.;]*)$/', $site))
		UserError::AddErrorIndexed('site', ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_WRONG);
	elseif(strlen($site) > $this->_config['limits']['max_len_site'])
		UserError::AddErrorIndexed('site', ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_LEN, $this->_config['limits']['max_len_site']);
}

$phone = App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
if(strlen($phone) > $this->_config['limits']['max_len_phone'])
	UserError::AddErrorIndexed('phone', ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_LEN, $this->_config['limits']['max_len_phone']);
elseif (eregi("[^0-9\(\) \-]+", $phone))
	UserError::AddErrorIndexed('phone', ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_WRONG);
	
if(UserError::IsError())
	return false;

$OBJECTS['user']->Profile['general']['ICQ']		= $icq;
$OBJECTS['user']->Profile['general']['Skype']	= $skype;
$OBJECTS['user']->Profile['general']['Site']	= $site;
$OBJECTS['user']->Profile['general']['Phone']	= $phone;

$rights = App::$Request->Post['rights']->Value();
$contactRights = 0;
if ( is_array( $rights ) && sizeof($rights) )  {

	foreach( $rights as $right )
		if ( $right )
			$contactRights |= $right;

}
$OBJECTS['user']->Profile['general']['ContactRights'] = $contactRights;

$OBJECTS['log']->Log(
		265,
		0,
		array()
		);
Response::Redirect('/' . $this->_env['section'] . '/msg.mypage_contacts.html');
?>