<?
global $CONFIG;
$list = array();

LibFactory::GetStatic('location');

$type = '';
if( isset($params[0]['type']) )
	$type = $params[0]['type'];

$types = array(
	'all' => array(),
	'search' => array(),
	'contacts' => array(),
	'myfriends' => array(),
	'friends' => array(),
);

if(!array_key_exists($type, $types))
	return $list;

$list['type'] = $type;
//$form['online'] = App::$Request->Get['online']->Int(0, Request::UNSIGNED_NUM);

/**
 *
 * Блок заголовка
 * Блок подменю
 * И блок поиска
 *
 */
if( in_array($type, array('all', 'search')) )
{
	$list['title'] = 'Пользователи';
	$list['search_form'] = $this->_get_search_form();
}
else if( $type == 'contacts' )
{
	// получение информации о папках
	$filter = array();
	$messages = $OBJECTS['user']->Plugins->Messages;
	$blacklist = $OBJECTS['user']->Plugins->BlackList;
	$filter['folder'] = 2;
	$list['menu']['count']['outcoming']		= $messages->GetMessagesCount($filter);
	$filter['folder'] = 1;
	$list['menu']['count']['incoming']		= $messages->GetMessagesCount($filter);
	$filter['isnew'] = 1;
	$list['menu']['count']['incoming_new']	= $messages->GetNewMessagesCount();
	$list['menu']['count']['blacklist']		= $blacklist->GetBlackListCount();
	unset($filter);

}

/**
 *
 * проверка входящих параметров
 * формирование запроса
 *
 */
$filter = array();
$p = App::$Request->Get['p']->Int(1, Request::UNSIGNED_NUM);
if( $type == 'search' )
{
	//$index = 'passport_main passport_delta';
	$index = 'passport_main';
	$query = '';

	$cl = LibFactory::GetInstance('sphinx_api');

	$cl->SetWeights ( array ( 20, 10, 10, 50, 100, 70, 15, 5, 0, 50, 0 ) );
	$cl->SetMatchMode ( SPH_MATCH_ALL );
	$cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
	$cl->SetArrayResult ( true );

	$cl->SetMatchMode ( SPH_MATCH_FULLSCAN );

	if ( (isset($list['search_form']['age_from']) || isset($list['search_form']['age_to'])) && $list['search_form']['age_from'] <= $list['search_form']['age_to'] )
		$cl->SetFilterRange('Birthday', $list['search_form']['age_from'], $list['search_form']['age_to']);

	if ( isset($list['search_form']['photo']) && $list['search_form']['photo'] == 1 )
		$cl->SetFilter ( 'photo', array($list['search_form']['photo']), false );

	if ( isset($list['search_form']['gender1']) && isset($list['search_form']['gender2']) && $list['search_form']['gender1'] !== $list['search_form']['gender2'] )
		$cl->SetFilter ( 'gender', array($list['search_form']['gender1']?1:2), false );

	/*if( empty($list['search_form']['city']) && isset($list['search_form']['city_id']) && $list['search_form']['city_id'] == 0)
		$list['search_form']['city_id'] = -1;
		
	if ( isset($list['search_form']['city']) && !$list['search_form']['city'] )
		$cl->SetFilter ( 'regionid', array($this->_env['regid']), false ); */

	$ext_query = '';
	if ( !empty($list['search_form']['city']) ) {
		$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$ext_query = '@City '.addslashes($list['search_form']['city']).'* '.$ext_query;
	}

	if ( !empty($list['search_form']['firstname']) && $list['search_form']['firstname'] != $list['search_form']['defaults']['firstname'] ) {
		$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$ext_query = '@FirstName '.addslashes($list['search_form']['firstname']).' '.$ext_query;
	}

	if ( !empty($list['search_form']['lastname']) && $list['search_form']['lastname'] != $list['search_form']['defaults']['lastname'] ) {
		$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$ext_query = '@LastName '.addslashes($list['search_form']['lastname']).' '.$ext_query;
	}

	if ( !empty($list['search_form']['midname']) && $list['search_form']['midname'] != $list['search_form']['defaults']['midname'] ) {
		$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
		$ext_query = '@MidName '.addslashes($list['search_form']['midname']).' '.$ext_query;
	}

	//$query = "\"{$query}\" ".$ext_query;
	$query = $ext_query;

	$cl->SetLimits(
		($p-1) * $this->_config['contacts']['usersperpage'],
		(int) $this->_config['contacts']['usersperpage']
	);
}
else if( $type == 'friends' )
{
	$list['params']['approved'] = true;
	$list['params']['id'] = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
	if($list['params']['id'] == 0)
		Response::Status(404, RS_SENDPAGE | RS_EXIT);

	if ( $list['params']['id'] == $OBJECTS['user']->ID )
		Response::Redirect($url = '/'.$this->_env['section'].'/'.$this->_config['files']['get']['mypage_friends']['string']);

	$User = $OBJECTS['usersMgr']->GetUser( $list['params']['id'] );

	if( $User === null )
		Response::Status(404, RS_SENDPAGE | RS_EXIT);

	if ( $User->ID && !$User->Profile['general']['ShowFriends'])
		Response::Redirect('/' . $this->_env['section'] . '/msg.hidden.html');

	$OBJECTS['title']->AppendBefore($User->Profile['general']['ShowName']);
	$OBJECTS['title']->AppendBefore('Друзья');
	$list['title'] = 'Друзья '.$User->Profile['general']['ShowName'];
}
else if( $type == 'myfriends' )
{
	$list['params']['approved'] = App::$Request->Get['type']->Value() != 'invite';
	$list['params']['id'] = $OBJECTS['user']->ID;
	
	if ($list['params']['approved'] === true)
	{
		$OBJECTS['title']->AppendBefore('Мои друзья');
		$list['title'] = 'Мои друзья';
	}
	else
	{
		$OBJECTS['title']->AppendBefore('Приглашения');
		$list['title'] = 'Приглашения';
	}
}


/**
 *
 * выбираем количество
 *
 */
$list['count'] = 0;
if( $type == 'search' )
{
	$res = $cl->Query (iconv('WINDOWS-1251', 'UTF-8', $query), $index );
	if ( $res === false || !is_array( $res['matches']) || !sizeof( $res['matches']) )
	{
		if ($res === false)
			error_log("Search query failed: " . $cl->GetLastError());
		return $list;
	}

	$list['count'] = $res['total_found'];
	//$list['menu']['count']['search'] = $list['count'];
	//$list['count'] = $res['total'];
	//$list['time'] = $res['time'];
}
else if( $type == 'contacts' )
{
	$list['count'] = $OBJECTS['user']->Plugins->Messages->GetContactsCount();
	$list['menu']['count']['contacts'] = $list['count'];
}
else if( in_array($type, array('friends', 'myfriends')) )
	$list['count'] = $OBJECTS['user']->Plugins->Friends->GetFriendsCount($list['params']['id'], $list['params']['approved']);

if ( (($p-1) * $this->_config['contacts']['usersperpage']) > ($list['count']+1) )
	$p = 1;

/**
 *
 * формируем постраничную навигацию
 *
 */
$temp = '';
if( $type == 'search' )
	$temp = DATA::build_query_string($list['search_form'], array('firstname','lastname','city','city_id','gender1','gender2','photo', 'age_from', 'age_to'), true);
else if( in_array($type, array('friends')) )
	$temp = DATA::build_query_string($list['params'], array('id'), true);

$list['pageslink'] = Data::GetNavigationPagesNumber(
	$this->_config['contacts']['usersperpage'],
	$this->_config['contacts']['linksperpage'],
	$list['count'], $p, '?p=@p@&'.$temp);

/**
 *
 * Выборка
 *
 */
if( $type == 'search' )
{
	$list_users =& $res['matches'];
}
else if($type == 'contacts')
{
	$list_users = $OBJECTS['user']->Plugins->Messages->GetContacts((($p-1) * $this->_config['contacts']['usersperpage']), $this->_config['contacts']['usersperpage']);
}
else if( in_array($type, array('friends', 'myfriends')) )
{
	$filter['offset'] = (($p-1) * $this->_config['contacts']['usersperpage']);
	$filter['limit'] = $this->_config['contacts']['usersperpage'];
	$filter['Approved'] = (int) $list['params']['approved'];
	
	$list_users = $OBJECTS['user']->Plugins->Friends->GetFriends($list['params']['id'], $filter);
	if(!is_array($list_users))
		$list_users = array();
}


/**
 *
 * Дополнительные данные (массивы, списки...)
 *
 */
 
/**
 *
 * Формируем массив пользователей
 *
 */
LibFactory::GetStatic('source');
LibFactory::GetStatic('datetime_my');

$citiesArr = array();
$defaultCityCode = $CONFIG['env']['site']['city_code'];

if (strlen($defaultCityCode) < 22)
	$defaultCityCode .= str_repeat('0', 22-strlen($defaultCityCode));

$list['data'] = array();
if(is_array($list_users))
foreach($list_users as $k=>$u)
{
	/**
     * здесь выбираем пользователя по-разному, ибо массив приходит разный...
     */
	if( in_array($type, array('search', 'contacts')) )
		$user = $OBJECTS['usersMgr']->GetUser($u['id']);
	else if( in_array($type, array('friends', 'myfriends')) )
	{
		if( $u['FriendID'] == 0 )
			continue;

		$user = $OBJECTS['usersMgr']->GetUser($u['FriendID']);
    }
	
	$isFriend = false;
    if ($list['params']['approved'])
		$isFriend = $OBJECTS['user']->Plugins->Friends->IsFriend($user->ID);
	
	$list['data'][$user->ID] = array(
		'nickname' => $user->NickName,
		'showname' => $user->Profile['general']['ShowName'],
		'firstname' => $user->Profile['general']['FirstName'],
		'lastname' => $user->Profile['general']['LastName'],
		'midname' => $user->Profile['general']['MidName'],
		'gender' => $user->Profile['general']['Gender'],

		'avatar' => $user->Profile['general']['Avatar'],
		'avatarurl' => $user->Profile['general']['AvatarUrl'],
		'avatarwidth' => $user->Profile['general']['AvatarWidth'],
		'avatarheight' => $user->Profile['general']['AvatarHeight'],
		
		'citytext' => '',

		'infourl' => $user->Profile['general']['InfoUrl'],

		'InContacts' => $OBJECTS['user']->Plugins->Messages->InContacts($user->ID),
		'replyjs' => $OBJECTS['user']->Plugins->Messages->GetReplyJS(array('UserID' => $user->ID)),
		'friendsjs'	=> $OBJECTS['user']->Plugins->Friends->GetInviteJS(array('UserID' => $user->ID)),
		'communityinvitejs' => null,
		
		'IsFriend' => $isFriend,
		'showvisited' =>  $user->Profile['general']['showvisited'],
	);
	
	$list['data'][$user->ID]['current_year'] = strftime("%G") == strftime("%G", strtotime($list['data'][$user->ID]['visited']));
		
	if( $user->Profile['location']['current'] ) {

		$loc_pc = Location::ParseCode($user->Profile['location']['current']);
		if (Location::ObjectLevel($loc_pc) >= Location::OL_CITIES) {

			$code = Location::GetPartcodeByLevel($user->Profile['location']['current'], Location::OL_VILLAGES);
			$code .= '0000';

			if ($defaultCityCode != $code) {
				if (!isset($citiesArr[$code])) {
					$citiesArr[$code] = Location::Normalize($code, array(
						Location::OL_REGIONS		=> true,
						Location::OL_CITIES			=> true,
						Location::OL_VILLAGES		=> true,
					));
				}

				$list['data'][$user->ID]['citytext'] = $citiesArr[$code];
			}
		}
	}

	if( in_array($type, array('friends', 'myfriends')) )
	{
		//if ( !$u['Approved'] )
		if ( !$list['data'][$user->ID]['Approved'] && $type == 'myfriends' )
			$list['data'][$user->ID]['Message'] = $OBJECTS['user']->Plugins->Friends->GetFriendMessage($user->ID);
		else
			$list['data'][$user->ID]['Message'] = null;

		$list['data'][$user->ID]['friend_approvejs'] = $OBJECTS['user']->Plugins->Friends->GetActionJS(array('UserID' => $user->ID, 'action' => 'approve'));
		$list['data'][$user->ID]['friend_refusejs'] = $OBJECTS['user']->Plugins->Friends->GetActionJS(array('UserID' => $user->ID, 'action' => 'refuse'));
    }
	else
	{
    }
}

/**
 *
 * Выполняем служебные функции, которые нужны длякорректного отображения страницы
 *
 */
 
 $this->_config['templates']['ssections']['users_block'] = $this->_config['templates']['ssections']['user_block'];
 
$OBJECTS['user']->Plugins->Messages->AddResponse();
$OBJECTS['user']->Plugins->Friends->AddResponse();

return $list;
