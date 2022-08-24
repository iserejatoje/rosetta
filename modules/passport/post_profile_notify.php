<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$imnotify			= App::$Request->Post['imnotify']->Int(0, Request::UNSIGNED_NUM);
$friendinvite		= App::$Request->Post['friendinvite']->Int(0, Request::UNSIGNED_NUM);

$OBJECTS['user']->Profile['themes']['talk']['ImNotify']			= $imnotify;
$OBJECTS['user']->Profile['themes']['talk']['FriendInvite']		= $friendinvite;

$OBJECTS['log']->Log(
		264,
		0,
		array()
		);
		
Response::Redirect('/' . $this->_env['section'] . '/msg.profile_notify.html');
?>
