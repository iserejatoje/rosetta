<?

Response::NoCache();

if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Регистрация');
//if ($_GET['debug_test'] != 654321)
//{
	LibFactory::GetStatic('antiflood2');
	if ( !AntiFlood2::Check('passport:register', AntiFlood2::K_IP, 3600, 1) )
		Response::Status(423, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);
//}
return $this->_Get_Register();
	
