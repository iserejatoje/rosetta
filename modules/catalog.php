<?

$error_code = 0;

define('ERR_M_CATALOG_FIRSTNAME_EMPTY', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_FIRSTNAME_EMPTY] = 'Укажите ваше имя';

define('ERR_M_CATALOG_ORDER_SUCCESS_PAID', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_SUCCESS_PAID] = 'Заказ успешно оплачен';

define('ERR_M_ARTIFICIAL_SEND_ORDER', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_ARTIFICIAL_SEND_ORDER] = 'Запрос отправлен! В ближайшее время с Вами свяжется менеджер';

define('ERR_M_CATALOG_ORDER_SUCCESS_PAID', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_SUCCESS_PAID] = 'Заказ успешно оплачен';

define('ERR_M_CATALOG_ORDER_UNKNOW', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_UNKNOW] = 'Неизвестный заказ';

define('ERR_M_CATALOG_ORDER_OLD', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_OLD] = 'Нельзя оплатить старый заказ.';

define('ERR_M_CATALOG_ORDER_WAS_PAID', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_WAS_PAID] = 'Заказ уже оплачен';

define('ERR_M_CATALOG_EMPTY_PHONE', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_EMPTY_PHONE] = 'Не указан номер телефона';

define('ERR_M_CATALOG_WRONG_PHONE_FORMAT', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_WRONG_PHONE_FORMAT] = 'Неверный формат номера телефона';

define('ERR_M_CATALOG_WRONG_FORMAT_DATE', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_WRONG_FORMAT_DATE] = 'Не верно указана дата';

define('ERR_M_CATALOG_EMPTY_DELIVERY_ADDRESS', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_EMPTY_DELIVERY_ADDRESS] = 'Не указан адрес доставки';

define('ERR_M_CATALOG_ORDER_PAYMENT_FAIL', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_PAYMENT_FAIL] = 'Не удалось произвести оплату заказа';

define('ERR_M_CATALOG_ORDER_PAYMENT_SUCCESS', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_PAYMENT_SUCCESS] = 'Cпасибо за заказ, в течение 10 минут с Вами свяжется оператор для подтверждения заказа';

define('ERR_M_CATALOG_ORDER_ACCEPTED', ERR_M_CATALOG_MASK | $error_code++);
UserError::$Errors[ERR_M_CATALOG_ORDER_ACCEPTED] = 'Cпасибо за заказ, в течение 10 минут с Вами свяжется оператор для подтверждения заказа';

LibFactory::GetStatic('application');

class Mod_Catalog extends ApplicationBaseMagic
{
    protected $_page = 'catalog';
    protected $_params = array();
    protected $_cache = null;
    protected $_db = null;
    protected $_type = null;
    protected $_skip = null;
    protected $_module_caching = true;

    protected $_cataloglink = null;

    protected $catalogMgr;
    protected $paymentMgr;
    protected $citiesMgr;

    public function __construct() {

        parent::__construct('catalog');

        LibFactory::GetStatic('ustring');

        LibFactory::GetMStatic('catalog', 'catalogmgr');
        LibFactory::GetMStatic('cities', 'citiesmgr');
        LibFactory::GetMStatic('payments', 'paymentmgr');

        $this->catalogMgr = CatalogMgr::GetInstance();
        $this->paymentMgr = PaymentMgr::GetInstance();
        $this->citiesMgr = CitiesMgr::GetInstance();
    }



    function Init() {

        global $OBJECTS;



    }



    public function AppInit($params)

    {

        global $OBJECTS, $CONFIG;

    }



    public function &GetPropertyByRef($name)

    {

        return parent::GetPropertyByRef($name);

    }



    protected function _ActionGet()

    {

        global $OBJECTS, $CONFIG;



        return parent::_ActionGet();

    }



    protected function _ActionModRewrite(&$params)

    {

        global $OBJECTS;



        parent::_ActionModRewrite($params);

    }



}