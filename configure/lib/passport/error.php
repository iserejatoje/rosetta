<?php

global $ERROR;

static $l_passport_error_code = 0;
define('ERR_L_PASSPORT_MASK', 0x00010000);
define('ERR_L_PASSPORT_UNKNOWN_ERROR', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_UNKNOWN_ERROR]
	= 'Незвестная ошибка.';
define('ERR_L_PASSPORT_NOT_AUTH', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_NOT_AUTH]
	= 'Пользователь не авторизован.';
define('ERR_L_PASSPORT_USER_NOT_FOUND', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_USER_NOT_FOUND]
	= 'Пользователь не найден.';

//define('ERR_L_PASSPORT_INCORRECT_PASSWORD', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
//$ERROR[ERR_L_PASSPORT_INCORRECT_PASSWORD]
	//= 'Неверный пароль. Если Вы забыли пароль - воспользуйтесь <a href="/passport/forgot.php?url='.$_GET['url'].'" style="color:red">системой восстановления пароля</a>.';
	
define('ERR_L_PASSPORT_INCORRECT_PASSWORD', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_INCORRECT_PASSWORD]
	= 'Неверный E-Mail или пароль. Если Вы забыли пароль - воспользуйтесь <a href="/account/forgot.php?url=%s" style="color:red">системой восстановления пароля</a>.';

define('ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_USER_IS_NOT_ACTIVATED]
	= 'Вы еще не подтвердили свою регистрацию. На E-mail, который Вы указали, отправлено письмо с дальнейшими инструкциями по активации.';
define('ERR_L_PASSPORT_USER_IS_BLOCKED', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_USER_IS_BLOCKED]
	= 'Пользователь заблокирован.';
define('ERR_L_PASSPORT_USER_DELETED', ERR_L_PASSPORT_MASK | $l_passport_error_code++);
$ERROR[ERR_L_PASSPORT_USER_DELETED]
	= 'Вы удалили свою учетную запись, для восстановления данных обратитесь в <a onclick="window.open(\'http://rugion.ru/feedback/\', \'ublock\',\'width=480,height=410,resizable=1,menubar=0,scrollbars=0\').focus(); return false;" target="ublock" title="Открыть" href="/feedback/">службу поддержки.</a>';

?>