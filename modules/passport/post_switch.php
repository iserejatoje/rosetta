<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_authorized();
	
if (!$OBJECTS['user']->IsInRole('m_passport_switch_user'))
	Response::Redirect('/'.$this->_env['section'].'/');

$email = App::$Request->Post['email']->Email(false);

$id = App::$Request->Post['id']->Int(false, Request::UNSIGNED_NUM);

if (!$email && !$id)
	UserError::AddErrorIndexed('switch', ERR_M_PASSPORT_EMPTY_SWITCH_DATA);
   
if($id === false && strlen(App::$Request->Post['email']->Value()) == 0 )
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY);
else if($id === false && $email === false)
	UserError::AddErrorIndexed('email', ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG);
			
if(UserError::IsError())
	return false;

	$user = null;
	
	if( $user === null && $id )
		$user = $OBJECTS['usersMgr']->GetUser($id);
	
	if ( $user === null && $email )
		$user = $OBJECTS['usersMgr']->GetUserByEmail($email);
	
	if ( $user === null )
		UserError::AddErrorIndexed('switch', ERR_M_PASSPORT_EMPTY_SWITCH_USER_NF);
	
if(UserError::IsError())
	return false;

$OBJECTS['log']->Log(275, $user->ID, array());
$OBJECTS['usersMgr']->SetSessionUser($OBJECTS['user']->SessionCode, $user->ID, false);
 
$url = App::$Request->Post['url']->Url(false, false);  
if( $url !== false )
	Response::Redirect( $url );
else
	$this->redirect_authorized();

?>