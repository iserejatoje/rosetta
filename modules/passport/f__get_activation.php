<?php
if (!isset($_GET['code']) || empty($_GET['code']))
	return array('result' => false);

if ($OBJECTS['usersMgr']->Activate($_GET['code']) > 0)
	Response::Redirect('/'.$this->_env['section'].'/msg.activation_ok.html');
else
	return array('result' => false);
?>