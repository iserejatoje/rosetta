<?php

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
$OBJECTS['title']->AppendBefore('Подтверждение номера телефона');

$url = App::$Request->Get['url']->Url(null);
$url = urldecode($url);

$current_phone = App::$User->Plugins->Phones->GetPhone();

return array(
	'url' => $url,
	'phone' => $current_phone,
);