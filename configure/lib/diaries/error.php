<?

$error_code = 0;
define('ERR_L_DIARIES_MASK', 0x00670000);

define('ERR_L_DIARIES_UNKNOWN_ERROR', ERR_L_DIARIES_MASK | $error_code++);
UserError::$Errors[ERR_L_DIARIES_UNKNOWN_ERROR]
	= 'Незвестная ошибка';
	
define('ERR_L_DIARIES_CANT_CONNECT_TODB', ERR_L_DIARIES_MASK | $error_code++);
UserError::$Errors[ERR_L_DIARIES_CANT_CONNECT_TODB]
	= 'Не удалось подключится к базе данных дневников.';

?>