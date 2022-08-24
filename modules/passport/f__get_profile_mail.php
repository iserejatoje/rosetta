<?

$this->_lib_mail = LibFactory::GetInstance('mail_service');
if(!empty($this->_config['mail']['sectionid']))
	$this->_lib_mail->Init($this->_config['mail']['sectionid']);
else
	$this->_lib_mail = null;

$form = array();
$form['form'] = array();

if(App::$Request->requestMethod === Request::M_POST && App::$Request->Post['action'] == 'profile_mail')
{
	$form['form']['signature']			= App::$Request->Post['signature']->Value(Request::OUT_HTML_AREA);
	$form['form']['replyto']			= App::$Request->Post['replyto']->Value(Request::OUT_HTML);
	$form['form']['messagecolpp']		= App::$Request->Post['messagecolpp']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['addresscolpp']		= App::$Request->Post['addresscolpp']->Int(0, Request::UNSIGNED_NUM);
	$form['form']['messagesortfield']	= App::$Request->Post['messagesortfield']->Alpha($OBJECTS['user']->Profile['modules']['mail']['MessageSortField']);
	$form['form']['messagesortord']		= App::$Request->Post['messagesortord']->Alpha($OBJECTS['user']->Profile['modules']['mail']['MessageSortOrd']);
	$form['form']['addresssortfield']	= App::$Request->Post['addresssortfield']->Alpha($OBJECTS['user']->Profile['modules']['mail']['AddressSortField']);
	$form['form']['addresssortord']		= App::$Request->Post['addresssortord']->Alpha($OBJECTS['user']->Profile['modules']['mail']['AddressSortOrd']);
	$form['form']['saveinsent']			= App::$Request->Post['saveinsent']->Int(0, Request::UNSIGNED_NUM);
	//$form['form']['logoutcleartrash']	= App::$Request->Post['logoutcleartrash']->Int(0, Request::UNSIGNED_NUM);
}
else
{
	$form['form']['signature']			= $OBJECTS['user']->Profile['modules']['mail']['Signature'];
	$form['form']['replyto']			= $OBJECTS['user']->Profile['modules']['mail']['ReplyTo'];
	$form['form']['messagecolpp']		= $OBJECTS['user']->Profile['modules']['mail']['MessageColPP'];
	$form['form']['addresscolpp']		= $OBJECTS['user']->Profile['modules']['mail']['AddressColPP'];
	$form['form']['messagesortfield'] 	= $OBJECTS['user']->Profile['modules']['mail']['MessageSortField'];
	$form['form']['messagesortord'] 	= $OBJECTS['user']->Profile['modules']['mail']['MessageSortOrd'];
	$form['form']['addresssortfield'] 	= $OBJECTS['user']->Profile['modules']['mail']['AddressSortField'];
	$form['form']['addresssortord'] 	= $OBJECTS['user']->Profile['modules']['mail']['AddressSortOrd'];
	$form['form']['saveinsent'] 		= $OBJECTS['user']->Profile['modules']['mail']['SaveInSent'];
	//$form['form']['logoutcleartrash'] 	= $OBJECTS['user']->Profile['modules']['mail']['LogoutClearTrash'];
}

$form['form']['counts_arr'] = $this->_lib_mail->col_pp;
if(!in_array($form['form']['messagecolpp'], $form['form']['counts_arr']))
	$form['form']['messagecolpp'] = $form['form']['counts_arr'][1];
if(!in_array($form['form']['addresscolpp'], $form['form']['counts_arr']))
	$form['form']['addresscolpp'] = $form['form']['counts_arr'][1];

$form['form']['messagesortfield_arr']	= $this->_lib_mail->message_sf_arr;
$form['form']['messagesortord_arr']		= $this->_lib_mail->so_arr;
$form['form']['addresssortfield_arr']	= $this->_lib_mail->address_sf_arr;
$form['form']['addresssortord_arr']		= $this->_lib_mail->so_arr;

return $form;
?>