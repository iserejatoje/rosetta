<?

$error_code = 0;
define('ERR_M_REVIEWS_MASK', 0x00570000);

define('ERR_M_REVIEWS_WRONG_CAPTCHA', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_WRONG_CAPTCHA] = 'Вы не прошли проверку на бота.';

define('ERR_M_REVIEWS_EMPTY_AUTHOR', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EMPTY_AUTHOR] = 'Поле Автор является обязательным.';

define('ERR_M_REVIEWS_EMPTY_TITLE', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EMPTY_TITLE] = 'Поле Заголовок является обязательным.';

define('ERR_M_REVIEWS_EMPTY_PHONE', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EMPTY_PHONE] = 'Поле Телефон является обязательным.';

define('ERR_M_REVIEWS_EMPTY_TEXT', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EMPTY_TEXT] = 'Необходимо ввести текст отзыва.';

define('ERR_M_REVIEWS_EXCEED_TEXT', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EXCEED_TEXT] = 'Максимальная длина отзыва 1000 символов.';

define('ERR_M_REVIEWS_INCORRECT_EMAIL', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_INCORRECT_EMAIL] = 'Введён некорректный email.';

define('ERR_M_REVIEWS_EMPTY_USERNAME', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_EMPTY_USERNAME] = 'Необходимо указать имя или фамилию.';

define('ERR_M_REVIEWS_SUCCESS_SUBMIT', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_SUCCESS_SUBMIT] = 'Ваш отзыв отправлен.<br/>Отзыв будет размещен на сайте после модерации';

define('ERR_M_REVIEWS_UNKNOWN_ERROR', ERR_M_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_M_REVIEWS_UNKNOWN_ERROR] = 'Неизвестная ошибка';



LibFactory::GetStatic('application');
class Mod_Reviews extends ApplicationBaseMagic
{
	protected $_page = 'main';
	protected $_db;
	protected $_params;
	protected $reviewmgr;
	protected $_module_caching = true;


	public function __construct() {
		parent::__construct('reviews');
	}

	function Init() {
		global $OBJECTS;
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
		LibFactory::GetStatic('ustring');

		LibFactory::GetMStatic('reviews', 'reviewmgr');
		$this->reviewmgr = ReviewMgr::GetInstance();
	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}

	protected function _ActionModRewrite(&$params)
	{
		global $OBJECTS;
		parent::_ActionModRewrite($params);

		if ($_SERVER['QUERY_STRING'] != "" && !isset($_GET['p']))
		{
			Response::Status(404, RS_SENDPAGE | RS_EXIT);
		}
	}
}
