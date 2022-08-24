<?

$form = array();

$filter = array();



if (isset(App::$Request->Get['chain']) && App::$Request->Get['chain']->Int(false, Request::UNSIGNED_NUM) !== false)
{
	$uchain = $OBJECTS['usersMgr']->GetUser(App::$Request->Get['chain']->Value());
	if ($uchain->ID == 0)
		Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['im_messages']['string']);
}

$folder = App::$Request->Get['folder']->Enum(1, array(1, 2));

$messages = $OBJECTS['user']->Plugins->Messages;
$filter['folder'] = 2;
$outcoming = $messages->GetMessagesCount($filter);
$filter['folder'] = 1;
$incoming = $messages->GetMessagesCount($filter);
$filter['isnew'] = 1;
$incoming_new = $messages->GetNewMessagesCount();
unset($filter['isnew']);
$contacts = $OBJECTS['user']->Plugins->Messages->GetContactsCount();

if (!isset($uchain))
{
	if ($folder == 2)
		$filter['folder'] = 2;
	else
		$filter['folder'] = 1;

	$form['folder'] = $filter['folder'];

	$count = $filter['folder'] == 2 ? $outcoming : $incoming;
	$blink = '/'.$this->_env['section']."/".$this->_config['files']['get']['im_messages']['string']."?folder=".$filter['folder'];
}
else
{
	$filter['user_chain'] = $uchain->ID;
	$form['uchain'] = $uchain;
	$count = $chain_count = $messages->GetMessagesCount($filter);
	$form['folder'] = 3;
	$blink = '/'.$this->_env['section']."/".$this->_config['files']['get']['im_messages']['string']."?chain=".$uchain->ID;
	$form['redirect_url'] = $blink.((App::$Request->Get['p']->Int(false, Request::UNSIGNED_NUM) !== false && App::$Request->Get['p']->Value() > 0 && (App::$Request->Get['p']->Value() - 1) * $this->_config['messages']['messageperpage'] < $count) ? '&p='.App::$Request->Get['p']->Value() : '');
}

if (!isset($uchain))
{
	if (!isset(App::$Request->Get['field']) || (App::$Request->Get['field']->Value() != 'type' &&
			App::$Request->Get['field']->Value() != 'title' &&
			App::$Request->Get['field']->Value() != 'created' &&
			App::$Request->Get['field']->Value() != 'user'))
	{
		$field = $OBJECTS['user']->Profile['modules']['im']['MessageSortField'];
	}
	else
	{
		$field = App::$Request->Get['field']->Value();
		$OBJECTS['user']->Profile['modules']['im']['MessageSortField'] = $field;
	}

	if (!isset(App::$Request->Get['ord']) || (App::$Request->Get['ord']->Value() != 'a' && App::$Request->Get['ord']->Value() != 'd'))
		$ord = $OBJECTS['user']->Profile['modules']['im']['MessageSortOrd'];
	else
	{
		$ord = App::$Request->Get['ord']->Value();
		$OBJECTS['user']->Profile['modules']['im']['MessageSortOrd'] = $ord;
	}

	if (!isset(App::$Request->Get['filter']) || App::$Request->Get['filter']->Int(false, Request::UNSIGNED_NUM) === false || (App::$Request->Get['filter']->Value() < 0 || App::$Request->Get['filter']->Value() > count($OBJECTS['user']->Plugins->Messages->typesdesc)))
		$ftype = $OBJECTS['user']->Profile['modules']['im']['MessageFilter'];
	else
	{
		$ftype = App::$Request->Get['filter']->Int(0, Request::UNSIGNED_NUM);
		$OBJECTS['user']->Profile['modules']['im']['MessageFilter'] = $ftype;
	}
}
else
{
	$field = 'created';
	$ord = 'd';
}

$form['field'] = $field;
$form['ord'] = $ord;
$form['pord'] = $ord == 'a' ? 'd' : 'a';
$form['ftype'] = $ftype;

if (!isset($uchain) && $field == 'user')
{
	if ($filter['folder'] == 1)
		$field = 'From';
	else
		$field = 'To';
}

if ($field == 'created')
	$field = 'Created';
elseif ($field == 'type')
	$field = 'Type';
elseif ($field == 'title')
	$field = 'RefererTitle';

$filter['field'] = $field;
$filter['dir'] = $ord == 'a' ? 'ASC' : 'DESC';
//$filter['type'] = $ftype;

LibFactory::GetStatic('datetime_my');
$this->_config['messages']['messageperpage'] = 10;

$p = 1;
if (App::$Request->Get['p']->Int(false, Request::UNSIGNED_NUM) !== false && App::$Request->Get['p']->Value() > 0 && (App::$Request->Get['p']->Value() - 1) * $this->_config['messages']['messageperpage'] < $count)
{
	$p = App::$Request->Get['p']->Value();
}

$filter['offset'] = ($p - 1) * $this->_config['messages']['messageperpage'];
$filter['limit'] = $this->_config['messages']['messageperpage'];

$form['page'] = $p;

$count = $messages->GetMessagesCount($filter);
$form['pages'] = Data::GetNavigationPagesNumber($filter['limit'], $this->_config['messages']['linksperpage'], $count, $p, $blink."&p=@p@");

$blacklist = $OBJECTS['user']->Plugins->BlackList;

$mms = $messages->GetMessages($filter);
foreach ($mms as $mm)
{
	if ($mm['Folder'] == 1 || isset($uchain))
		$mm['UserInfo'] = $OBJECTS['usersMgr']->GetUser($mm['UserFrom']);
	else
		$mm['UserInfo'] = $OBJECTS['usersMgr']->GetUser($mm['UserTo']);

	$mm['DType'] = $OBJECTS['user']->Plugins->Messages->typesdesc[$mm['Type']];
	$mm['showvisited'] = $mm['UserInfo']->Profile['general']['showvisited'];
	$mm['replyjs'] = $OBJECTS['user']->Plugins->Messages->GetReplyJS(array(
				'UserID' => $mm['UserInfo']->ID,
				'MessageID' => $mm['MessageID'],
				'Type' => $mm['Type'],
				'Title' => $mm['RefererTitle'],
				'Url' => $mm['RefererUrl'],
				'Reload' => $mm['IsNew'],
			));
	$mm['File'] = $messages->GetFilesForMessage($mm['MessageID']);

	$mm['IsInBlackList'] = $blacklist->IsInBlackList($mm['UserInfo']->ID);
	$mm['IsInContactsList'] = $messages->InContacts($mm['UserInfo']->ID);

	//$mm['IsInBlackList'] = $messages->IsInBlackList($mm['UserInfo']->ID);
	//$mm['makereadjs'] = $OBJECTS['user']->Plugins->Messages->GetMakeReadJS(array('MessageID' => $mm['MessageID']));
	$form['list'][] = $mm;
}

$form['types'] = $OBJECTS['user']->Plugins->Messages->typesdesc;

$form['count'] = array(
	'chain' => $chain_count,
	'incoming' => $incoming,
	'incoming_new' => $incoming_new,
	'outcoming' => $outcoming,
	'contacts' => $contacts,
	'blacklist' => $blacklist->GetBlackListCount(),
);

return $form;
