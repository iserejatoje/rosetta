<?


if($OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Вход');

return $this->_Get_Login();

?>
