<?

$url = App::$Request->Post['url']->Url(false, false);

// убираем из урла https и если его нет, то отправляем на http
if( $url !== false )
{
	if( strpos($url, 'http') === 0 )
	{
		$tmp = parse_url($url);
		$url = 'http://' . $tmp['host'] . $tmp['path'];
		if( $tmp['query'] != '' )
		{
			$url .= '?'. $tmp['query'];
			if( $tmp['fragment'] != '' )
				$url .= '#'. $tmp['fragment'];
		}
	}
}


if($OBJECTS['user']->IsAuth())
{
	if( $url !== false )
		Response::Redirect( $url );
	else
		$this->redirect_authorized();
}

$email = App::$Request->Post['email']->Value();
$password = App::$Request->Post['password']->Value();

if( strlen($email) == 0 )
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);

else if( App::$Request->Post['email']->Email(false) === false ) {
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
}

if( strlen($password) == 0 )
	UserError::AddErrorIndexed('password', ERR_M_PASSPORT_EMPTY_PASSWORD);

if( App::$Request->Post['remember']->Int(0, Request::UNSIGNED_NUM) == 1 )
	$remember = true;
else
	$remember = false;

if(UserError::IsError())
	return false;
try
{
	$OBJECTS['user'] = $OBJECTS['usersMgr']->Login($email, $password, $remember, $this->_env['regid'], $this->_env['site']['domain']);

}
catch(Exception $e)
{
	if($e->getCode() === ERR_L_PASSPORT_INCORRECT_PASSWORD)
		UserError::AddErrorIndexed('password', ERR_L_PASSPORT_INCORRECT_PASSWORD, App::$Request->Get['url']->Url());
	elseif ($e->getCode() === ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED)
		UserError::AddErrorIndexed('password', ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED);
	else
		UserError::AddErrorIndexed('email', $e->getCode());

}

if(UserError::IsError())
	return false;

// EventMgr::Raise('passport/user/login',
// 				array(
// 					'userid' => $OBJECTS['user']->ID,
// 			));

if( $url !== false )
	Response::Redirect( $url );
else
	$this->redirect_authorized();

?>