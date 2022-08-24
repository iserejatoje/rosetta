<?

Response::NoCache();

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Моя страница');

return $this->_Get_Mypage();	
?>