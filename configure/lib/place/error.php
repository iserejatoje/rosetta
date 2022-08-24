<?php

static $error_code = 0;
define('ERR_L_PLACE_MASK', 0x00010000);

define('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_MASK | $error_code++);
UserError::$Errors[ERR_L_PLACE_CANT_CONNECT_TODB]
	= 'Не удалось подключится к базе данных мест.';

define('ERR_L_PLACE_UNKNOWN_ADDRESS', ERR_L_PLACE_MASK | $error_code++);
UserError::$Errors[ERR_L_PLACE_UNKNOWN_ADDRESS]
	= 'Адрес указан не верно.';

define('ERR_L_PLACE_UNKNOWN_CONTACTINFO', ERR_L_PLACE_MASK | $error_code++);
UserError::$Errors[ERR_L_PLACE_UNKNOWN_CONTACTINFO]
	= 'Контактная информация указана не верно.';

define('ERR_L_PLACE_CANT_LOAD_PLUGIN', ERR_L_PLACE_MASK | $error_code++);
UserError::$Errors[ERR_L_PLACE_CANT_LOAD_PLUGIN]
	= 'Плагин "%s" не загружен.';

?>