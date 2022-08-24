<?php
$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('OFF-line Активация');

Response::NoCache();

return $this->_Get_Offline_Activation();	
?>