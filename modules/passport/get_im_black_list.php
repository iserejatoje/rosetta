<?php
if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

Response::NoCache();
$OBJECTS['user']->Plugins->Messages->AddResponse();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Черный список');

return $this->_Get_IM_Black_List();
?>