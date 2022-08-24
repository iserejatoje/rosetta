<?

Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);

return array(
	'message' => $this->_params['message'],
);
	
?>