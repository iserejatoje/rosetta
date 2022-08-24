<?

$error_code = 0;
define('ERR_M_CONTACTS_MASK', 0x00570000);

define('ERR_M_CONTACTS_EMPTY_TEXT', ERR_M_CONTACTS_MASK | $error_code++);
UserError::$Errors[ERR_M_CONTACTS_EMPTY_TEXT] = 'Необходимо ввести текст сообщение.';

define('ERR_M_CONTACTS_INCORRECT_EMAIL', ERR_M_CONTACTS_MASK | $error_code++);
UserError::$Errors[ERR_M_CONTACTS_INCORRECT_EMAIL] = 'Введён некорректный email.';

define('ERR_M_CONTACTS_EMPTY_USERNAME', ERR_M_CONTACTS_MASK | $error_code++);
UserError::$Errors[ERR_M_CONTACTS_EMPTY_USERNAME] = 'Необходимо указать ФИО';

define('ERR_M_CONTACTS_SUCCESS_SUBMIT', ERR_M_CONTACTS_MASK | $error_code++);
UserError::$Errors[ERR_M_CONTACTS_SUCCESS_SUBMIT] = 'Ваше сообщение отправлено.';

define('ERR_M_CONTACTS_UNKNOWN_ERROR', ERR_M_CONTACTS_MASK | $error_code++);
UserError::$Errors[ERR_M_CONTACTS_UNKNOWN_ERROR] = 'Неизвестная ошибка';

LibFactory::GetStatic('application');
class Mod_Contacts extends ApplicationBaseMagic
{
	protected $_page = 'main';
	protected $_db;
	protected $_params;

	protected $_module_caching = true;

	protected $citymgr;

	public function __construct() {
		parent::__construct('contacts');
	}

	function Init() {
		global $OBJECTS;
		LibFactory::GetMStatic('cities', 'citiesmgr');

		$this->citymgr = CitiesMgr::GetInstance();

	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}
}
