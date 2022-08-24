<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$workplace = App::$Request->Post['workplace']->Value(Request::OUT_HTML_CLEAN);
if(!is_string($workplace))
	$workplace = '';
$position = App::$Request->Post['position']->Value(Request::OUT_HTML_CLEAN);
if(!is_string($position))
	$position = '';
	
if(strlen($workplace) > $this->_config['limits']['max_len_workplace'])
	UserError::AddErrorIndexed('workplace', ERR_M_PASSPORT_INCORRECT_SETTINGS_WORKPLACE_LEN, $this->_config['limits']['max_len_workplace']);
	
if(strlen($position) > $this->_config['limits']['max_len_position'])
	UserError::AddErrorIndexed('position', ERR_M_PASSPORT_INCORRECT_SETTINGS_POSITION_LEN, $this->_config['limits']['max_len_position']);
	
if(UserError::IsError())
	return false;

$OBJECTS['user']->Profile['general']['WorkPlace']	= $workplace;
$OBJECTS['user']->Profile['general']['Position']	= $position;
$OBJECTS['log']->Log(
		268,
		0,
		array()
		);
Response::Redirect('/' . $this->_env['section'] . '/msg.mypage_work.html');

?>