<?php
$form = array();

$blacklist = $OBJECTS['user']->Plugins->BlackList;
$messages = $OBJECTS['user']->Plugins->Messages;
$filter['folder'] = 2;
$outcoming		= $messages->GetMessagesCount($filter);
$filter['folder'] = 1;
$incoming		= $messages->GetMessagesCount($filter);
$filter['isnew'] = 1;
$incoming_new	= $messages->GetNewMessagesCount();
unset($filter['isnew']);
$contacts = $OBJECTS['user']->Plugins->Messages->GetContactsCount();

$form['count'] = array(
	'chain'			=> $chain_count,
	'incoming'		=> $incoming,
	'incoming_new'	=> $incoming_new,
	'outcoming'		=> $outcoming,
	'contacts'		=> $contacts,
	'blacklist'		=> $blacklist->GetBlackListCount(),
	);


$p = 1;
if(App::$Request->Get['p']->Int(false, Request::UNSIGNED_NUM) !== false && App::$Request->Get['p']->Value() > 0 && (App::$Request->Get['p']->Value() - 1) * $this->_config['messages']['messageperpage'] < $count)
{
	$p = App::$Request->Get['p']->Value();
}

$filter['offset'] = ($p - 1) * $this->_config['messages']['messageperpage'];
$filter['limit'] = $this->_config['messages']['messageperpage'];

$form['page'] = $p;
$count = $form['count']['blacklist'];
$blink = '/'.$this->_env['section']."/".$this->_config['files']['get']['im_black_list']['string'];
$form['pages'] = Data::GetNavigationPagesNumber($filter['limit'], $this->_config['messages']['linksperpage'], $count, $p, $blink."?p=@p@");

LibFactory::GetStatic('datetime_my');
LibFactory::GetStatic('source');
$cities = array();
$regions = array();
$countries = array();

$bl = $blacklist->GetBlackList($filter);
foreach($bl as $mm)
{
	$user = $OBJECTS['usersMgr']->GetUser($mm['ToUserID']);
	$mm['UserInfo'] = array(
			'UserID'			=> $user->ID,
			'Approved'			=> 1,
			'IsFriend'			=> $OBJECTS['user']->Plugins->Friends->IsFriend($user->ID),
			'IsInvitedFriend'	=> 0,
			'city'				=> $user->Profile['general']['City'],
			'citytext'			=> $user->Profile['general']['CityText'],
			'region'			=> $user->Profile['general']['Region'],
			'country'			=> $user->Profile['general']['Country'],
			'showvisited'		=> $user->Profile['general']['showvisited'],
			'gender'			=> $user->Profile['general']['Gender'],
			'nickname'			=> $user->NickName,
			'showname'			=> $user->Profile['general']['ShowName'],
			'firstname'			=> $user->Profile['general']['FirstName'],
			'lastname'			=> $user->Profile['general']['LastName'],
			'midname'			=> $user->Profile['general']['MidName'],
			'avatar'			=> $user->Profile['general']['Avatar'],
			'avatarurl'			=> $user->Profile['general']['AvatarUrl'],
			'avatarwidth'		=> $user->Profile['general']['AvatarWidth'],
			'avatarheight'		=> $user->Profile['general']['AvatarHeight'],
			'birthday_day'		=> $day,
			'birthday_year'		=> $year,
			'birthday_month'	=> $month,
			'infourl'			=> $user->Profile['general']['InfoUrl'],
			'replyjs'			=> $OBJECTS['user']->Plugins->Messages->GetReplyJS(array('UserID' => $user->ID)),
			'friendsjs'			=> $OBJECTS['user']->Plugins->Friends->GetInviteJS(array('UserID' => $user->ID)),
			'in_blacklist'		=> true,
		);
	if($user->Profile['general']['City'] > 0)
		$cities[] = $user->Profile['general']['City'];
	if($user->Profile['general']['Region'] > 0)
		$regions[] = $user->Profile['general']['Region'];
	if($user->Profile['general']['Country'] > 0)
		$countries[] = $user->Profile['general']['Country'];
	
	$form['list'][] = $mm;
}

$cities = array_unique($cities);
$regions = array_unique($regions);
$countries = array_unique($countries);
	
if(count($cities) > 0)
	$form['cities'] = Source::GetData('db:location', array('type' => 'city', 'id' => $cities));
else
	$form['cities'] = array();
if(count($regions) > 0)
	$form['regions'] = Source::GetData('db:location', array('type' => 'region', 'id' => $regions));
else
	$form['regions'] = array();
if(count($countries) > 0)
	$form['countries'] = Source::GetData('db:location', array('type' => 'country', 'id' => $countries));
else
	$form['countries'] = array();

return $form;
?>