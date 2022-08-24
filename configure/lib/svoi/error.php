<?

global $ERROR;

static $l_svoi_error_code = 0;
define('ERR_L_SOCIAL_MASK', 0x002B0000);
define('ERR_L_SOCIAL_UNKNOWN_ERROR', ERR_L_SOCIAL_MASK | $l_svoi_error_code++);
$ERROR[ERR_L_SOCIAL_UNKNOWN_ERROR]
	= 'Незвестная ошибка.';
define('ERR_L_SOCIAL_COMMUNITY_EXISTS', ERR_L_SOCIAL_MASK | $l_svoi_error_code++);
$ERROR[ERR_L_SOCIAL_COMMUNITY_EXISTS]
	= 'Сообщество с данным именем уже зарегистрировано.';



?>