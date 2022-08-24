<?

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

$email = App::$Request->Post['email']->Value();
$password = App::$Request->Post['password']->Value();
$error = null;

if( strlen($email) == 0 )
	$error = UserError::GetError(ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);
else if( App::$Request->Post['email']->Email(false) === false )
	$error = UserError::GetError(ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
else if( strlen($password) == 0 )
	$error = UserError::GetError(ERR_M_PASSPORT_EMPTY_PASSWORD);
	
if( App::$Request->Post['remember'] == 1 )
	$remember = true;
else
	$remember = false;
	
if( $error !== null ) {
	echo $json->encode( array('status' => 'error',  'data' => $error) );
	exit;
}

// Не понятно зачем тут вообще try стоит - все исключения внутри функции Login обрабатываются
/*
try
{

	$OBJECTS['user'] = $OBJECTS['usersMgr']->Login($email, $password, $remember, $this->_env['regid'], $this->_env['site']['domain']);
}
catch(Exception $e)
{
	if($e->getCode() === ERR_L_PASSPORT_INCORRECT_PASSWORD)
		$error = UserError::GetError(ERR_L_PASSPORT_INCORRECT_PASSWORD);
	else
		$error = UserError::GetError($e->getCode());
}

if( $error !== null ) {
	echo $json->encode( array('status' => 'error',  'data' => $error) );
	exit;
}
*/

$OBJECTS['user'] = $OBJECTS['usersMgr']->Login($email, $password, $remember, $this->_env['regid'], $this->_env['site']['domain']);

if(UserError::IsError()){
	
	echo $json->encode( array('status' => 'error',  'data' => 'Неверный E-Mail или пароль.') );
	exit;
}

$OBJECTS['log']->Log(276, $OBJECTS['user']->ID, array());

if (App::$Request->Post['type']->Value() == 'friends') {

	Response::Redirect( '/'.$this->_env['section'].'/'.$this->_config['files']['get']['friends_invite']['string']
		.'?id='.App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM).'&rtype=ajax' );
		
} else {
	$params['rtype'] = 'ajax';
	echo $json->encode( array(
		'status' => 'ok', 
		'data' => $this->RenderBlock($this->_config['templates']['im_ajax_new'],
			array($params), array($this, '_Get_IM_New'))
	));
}

exit;

?>