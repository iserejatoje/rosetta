<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Моя страница');
$OBJECTS['title']->AppendBefore('Работа');

return $this->_Get_Mypage_Work();;
	
?>