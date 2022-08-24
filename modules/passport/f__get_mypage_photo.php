<?
$form = array();
$form['form'] = array();

if (isset($params[0]))
	$user = $OBJECTS['usersMgr']->GetUser($params[0]);
else
	$user = $OBJECTS['user'];

if( $user->Profile['general']['Avatar'] != '' )
{	
	$form['form']['avatar'] = array(
			'file' => $user->Profile['general']['AvatarUrl'],
			'w' => $user->Profile['general']['AvatarWidth'],
			'h' => $user->Profile['general']['AvatarHeight'],
			);
}

if( $user->Profile['general']['Photo'] != '' )
{	
	$form['form']['photo'] = array(
			'file' => $user->Profile['general']['PhotoUrl'],
			'w' => $user->Profile['general']['PhotoWidth'],
			'h' => $user->Profile['general']['PhotoHeight'],
			);
}

// Получаем список "плохих" полей
if ( $user->ID == $OBJECTS['user']->ID )
{
	$form['form']['bad_fields'] = array();
	if ( $user->Blocked == 1 )
		$form['form']['bad_fields'] = PUsersMgr::GetBadFieldsForUser($user->ID);
}

$form['avatar_file_size'] = App::$User->Profile['general']['avatar_file_size'];
$form['photo_file_size'] = App::$User->Profile['general']['photo_file_size'];

return $form;
?>