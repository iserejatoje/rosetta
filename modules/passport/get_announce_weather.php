<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Профиль');
$OBJECTS['title']->AppendBefore('Моя погода');

return $this->_Get_Announce_Weather();
	
?>