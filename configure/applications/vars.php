<?

static $help_vars_code = 0;
define('ERR_M_VARS_MASK', 0x00310000);
define('ERR_M_VARS_EMPTY_DEFAULT_VALUE', ERR_M_VARS_MASK | $help_vars_code++);
$ERROR[ERR_M_VARS_EMPTY_DEFAULT_VALUE]	= 'Необходи ввести значение переменной по умолчанию "0".';
	
define('ERR_M_VARS_EMPTY_NAME', ERR_M_VARS_MASK | $help_vars_code++);
$ERROR[ERR_M_VARS_EMPTY_NAME]= 'Необходимо ввести имя переменной.';

define('ERR_M_VARS_EXISTS_NAME', ERR_M_VARS_MASK | $help_vars_code++);
$ERROR[ERR_M_VARS_EXISTS_NAME]= 'Переменная с введенным вами именем уже существует.';

define('ERR_M_VARS_NOT_FOUND', ERR_M_VARS_MASK | $help_vars_code++);
$ERROR[ERR_M_VARS_NOT_FOUND]= 'Переменная не найдена.';

return array(	
	'title'		=> 'Переменные',
);
?>