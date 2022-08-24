<?
static $admin_error_code = 0;
define('ERR_E_ADMIN_MASK', 0x00015000);
define('ERR_E_ADMIN_UNKNOWN_ERROR', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_UNKNOWN_ERROR]
	= 'Незвестная ошибка.';
define('ERR_E_ADMIN_CUSTOM', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_CUSTOM]
	= '%s';
define('ERR_E_ADMIN_WRONG_MODULE', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_MODULE]
	= 'Вы не указали модуль.';
define('ERR_E_ADMIN_WRONG_TYPE', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_TYPE]
	= 'Вы не указали тип раздела.';
define('ERR_E_ADMIN_WRONG_ENCODING', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_ENCODING]
	= 'Вы не указали кодировку.';
define('ERR_E_ADMIN_WRONG_REGION', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_REGION]
	= 'Регион должет быть числом.';
define('ERR_E_ADMIN_WRONG_NAME', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_NAME]
	= 'Вы указали неправильное имя раздела.';
define('ERR_E_ADMIN_WRONG_PATH', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_PATH]
	= 'Вы указали неправильный путь раздела.';
define('ERR_E_ADMIN_WRONG_XML_ENV', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_XML_ENV]
	= 'Ошибка в xml.';
define('ERR_E_ADMIN_WRONG_BLOCKKEY', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_BLOCKKEY]
	= 'Ошибка в ключе блока.';
define('ERR_E_ADMIN_WRONG_BLOCKSECTION', ERR_E_ADMIN_MASK | $admin_error_code++);
$ERROR[ERR_E_ADMIN_WRONG_BLOCKSECTION]
	= 'Ошибка в ID раздела блока.';
?>