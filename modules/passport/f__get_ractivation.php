<?php
if(!$OBJECTS['user']->IsAuth())
	$this->redirect_authorized();

$code = $OBJECTS['usersMgr']->ActivationCodeRemember($OBJECTS['user']->ID, 2);

if ($code !== 0)
{
	$subj = "Подтверждение смены E-mail на сайте ".$this->_env['site']['domain']."\n";
	$header = "Content-Type: text/html ; charset=windows-1251;\nMIME-Version: 1.0\nFrom: ".$this->_env['section']." <remind@".$this->_env['site']['domain'].">\n";
	//$header = "From: ".$this->_env['section']." <remind@".$this->_env['site']['domain'].">\nContent-Type: text/html ; charset=windows-1251;\n";
	$msg = "Здравствуйте, ".$OBJECTS['user']->Profile['general']['ShowName'].".<br><br>
	Вы поменяли E-mail в своем профиле на сайте ".$this->_env['site']['domain'].".<br>
	Для подтверждения E-mail Вам необходимо пройти по следующей ссылке:<br>
	<a href=\"http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."\" target=\"_blank\">http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php?code=".$code."</a>.<br><br>
	Если у Вас не получается перейти по ссылке, то введите код активации на странице <a href=\"http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php\" target=\"_blank\">http://".$this->_env['site']['domain']."/".$this->_env['section']."/activation.php</a><br>
	Код активации: <b>".$code."</b><br><br>
	Если в течение 24 часов Вы не подтвердите новый E-mail, то активация будет отменена.<br><br>
	С уважением,<br>
	&nbsp;&nbsp;&nbsp;Служба поддержки ".$this->_env['site']['domain'];
	
	$email = $OBJECTS['usersMgr']->CheckActivation($OBJECTS['user']->ID, 2);
	if (!mail($email, $subj, $msg, $header))
		error_log("Can't sending mail 'Change E-mail'");
}
Response::Redirect('/'.$this->_env['section'].'/msg.activation.html');
?>