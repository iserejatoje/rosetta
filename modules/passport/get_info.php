<?php

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Информация о пользователе');
$OBJECTS['user']->Plugins->Messages->AddResponse();
$OBJECTS['user']->Plugins->Friends->AddResponse();

$form = array();

if (!isset(App::$Request->Get['id']))
{
	Response::Status(404, RS_NONE);
	return array();
}

$user_id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

if($user_id == 0)
{
	Response::Status(404, RS_NONE);
	return array();
}
$this->_RoleKey = $this->SSP($OBJECTS['user']->ID);
$this->_UniqueID = $user_id;
$user = $OBJECTS['usersMgr']->GetUser($user_id);

if($user === null)
{
  Response::Status(404, RS_NONE);
  return array();
}

if ($user->IsDel != 0)
{
	$form['IsDel'] = true;
	return $form;
}

$form = $this->_Get_Mypage_Contacts($user_id);

$form = array_merge_recursive($form,
	$this->_Get_Mypage_Person($user_id),
	$this->_Get_Mypage_Photo($user_id));
/*
,
	$this->_Get_Mypage_Place($user_id)
	*/

$form['role_info_view'] = $OBJECTS['user']->IsInRole('m_passport_info_view');

$form['user_is_friend'] = true;
if ( $OBJECTS['user']->ID != $user_id )
	$form['user_is_friend'] = $OBJECTS['user']->Plugins->Friends->IsFriend($user_id);

$form['replyjs'] = $OBJECTS['user']->Plugins->Messages->GetReplyJS(array('UserID' => $user_id));


$form['forum_themes'] = ModuleFactory::GetBlock('block', $this->_config['block_section'], 'forum_themes', null, 1800,
					array( 'count' => 4, 'user_id' => $user_id ) );

$form['diary_records'] = ModuleFactory::GetBlock('block', $this->_config['block_section'], 'diary_records', null, 1800,
					array( 'count' => 4, 'user_id' => $user_id ) );

$form['friends_records'] = ModuleFactory::GetBlock('block', $this->_config['block_section'], 'friends', null, 1800,
					array( 'user_id' => $user_id ) );

if ( !$OBJECTS['user']->Plugins->Friends->IsFriend($user_id) && $user_id != $OBJECTS['user']->ID )
	$form['friendsjs'] = $OBJECTS['user']->Plugins->Friends->GetInviteJS(array('UserID' => $user_id));

if ($OBJECTS['user']->Plugins->Friends->IsFriend($user_id) && $user_id != $OBJECTS['user']->ID
	&& $OBJECTS['user']->Plugins->Friends->IsApprovedFriend($user_id, 1))
	$form['isfriend'] = true;

//Ссылка фотогалерея
// устанавливаем окружение виджетов

$state = WidgetFactory::GetState();
WidgetFactory::SetWidgetState();

// интересы пользователя
$widget = WidgetFactory::GetInstance(
	'announce/gallery',
	'Passport',
	array(
		'id' => $user_id,
		'rolekey' => $this->_RoleKey,
		'container' => 'containers/blank.tpl',
		)
	);
if($widget)
{
	$widget->SetOutputMode(IWidget::OUTPUT_SYNC);
	$form['Gallery'] = $widget->Run();
}

// востанавливаем окружение
WidgetFactory::SetState($state);

// домен третьего уровня
LibFactory::GetStatic('domain');
$form['user_domain'] = Domain::GetInfo(3, $user_id);


$form['UserID'] = $user_id;
$form['UserInfo'] = $user;
return $form;
?>
