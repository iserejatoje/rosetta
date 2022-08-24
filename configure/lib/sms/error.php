<?php

global $ERROR;

static $l_sms_error_code = 0;
define('ERR_L_SMS_MASK', 0x00013000);

define('ERR_L_SMS_CANT_LOAD_PROVIDER', ERR_L_SMS_MASK | $l_sms_error_code++);
$ERROR[ERR_L_SMS_CANT_LOAD_PROVIDER]
	= 'Не удалось загрузить провайдер "%s".';
	

?>