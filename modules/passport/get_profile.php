<?

// редиректим на другую страницу, т.к. для этой страницы пока контента нет.
Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['profile_id']['string']);

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Профиль');

$user_info = array();

return $user_info;
	
?>