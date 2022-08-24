<?php

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();

if (!$OBJECTS['user']->IsInRole('m_passport_switch_user'))
	Response::Redirect('/'.$this->_env['section'].'/');
	
Response::NoCache();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Сменить пользователя');

return $this->_Get_Switch();


?>