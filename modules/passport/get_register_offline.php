<?

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);

$OBJECTS['title']->AppendBefore('Off-line регистрация');
return $this->_Get_Register_Offline();
	
?>