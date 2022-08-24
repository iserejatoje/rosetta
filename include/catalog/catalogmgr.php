<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/catalog/iproduct.php');
require_once ($CONFIG['engine_path'].'include/catalog/product.php');
require_once ($CONFIG['engine_path'].'include/catalog/roselen.php');
require_once ($CONFIG['engine_path'].'include/catalog/category.php');
require_once ($CONFIG['engine_path'].'include/catalog/addition.php');
include_once ($CONFIG['engine_path'].'include/catalog/filter.php');
include_once ($CONFIG['engine_path'].'include/catalog/member.php');
include_once ($CONFIG['engine_path'].'include/catalog/type.php');
include_once ($CONFIG['engine_path'].'include/catalog/order.php');
include_once ($CONFIG['engine_path'].'include/catalog/card.php');
include_once ($CONFIG['engine_path'].'include/catalog/discountcard.php');

spl_autoload_register(function ($class_name)
{
    if (file_exists(ENGINE_PATH.'include/catalog/'.$class_name . '.php'))
    {
        include_once(ENGINE_PATH.'include/catalog/'.mb_strtolower($class_name).'.php');
        return true;
    }
    return false;

});

class CatalogMgr
{
    private $_products      = array();
    private $_categories    = array();
    private $_lens          = array();
    private $_additions     = array();
    private $_filters       = array();
    private $_members       = array();
    private $_types         = array();
    private $_orders        = array();
    private $_cart          = array();
    private $_cards         = array();
    private $_discountcards = array();

    private $_cache     = null;

    private $_photoMgr  = null;

    public $_db         = null;
    public $_tables     = array(
        'products'          => 'ctl_products',
        'category'          => 'ctl_category',
        'rose_len'          => 'ctl_rose_len',
        'addition'          => 'ctl_addition',
        'filters'           => 'ctl_filters',
        'filter_params'     => 'ctl_filter_params',
        'product_filters'   => 'ctl_filter_refs',
        'decor'             => 'ctl_decor',
        'compositions'      => 'ctl_compositions',
        'elements'          => 'ctl_products_elements',
        'refs'              => 'ctl_product_area',
        'addition_refs'     => 'ctl_addition_area',
        'compositions_refs' => 'ctl_composition_area',
        'tree'              => 'tree',
        'cart'              => 'ctl_cart',
        'card'              => 'ctl_card',
        'orders'            => 'ctl_orders',
        'order_refs'        => 'ctl_order_refs',
        'settings'          => 'settings',
        'section_settings'  => 'ctl_section_settings',
        'types'             => 'ctl_product_types',
        'typeRefs'          => 'ctl_type_area',
        'cache_prices'      => 'ctl_product_cache_prices',
        'discount_cards'    => 'ctl_discount_cards',
        'cart_trying'       => 'cart_trying'
    );

    public static $b_size = [
        'Мини'  => 'size-mini',
        'Миди'  => 'size-midi',
        'Макси' => 'size-maxi',
        'мини'  => 'size-mini',
        'миди'  => 'size-midi',
        'макси' => 'size-maxi',
        'mini'  => 'size-mini',
        'midi'  => 'size-midi',
        'maxi'  => 'size-maxi',
    ];

    public static $weekdate = [
        0 => 'Воскресенье',
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
    ];

    public $CartCode;

    // новый|принят к исполнению|собран|доставлен
    const OS_NEW       = 10;
    const OS_ACCEPT    = 20;
    const OS_ASSEMBLED = 30;
    const OS_DELIVERED = 40;

    public static $ORDER_STATUSES = [
        self::OS_NEW       => 'новый',
        self::OS_ACCEPT    => 'принят к исполнению',
        self::OS_ASSEMBLED => 'собран',
        self::OS_DELIVERED => 'доставлен',
    ];

    const PS_NOPAID = 10;
    const PS_PAID = 20;
    public static $PAYMENT_STATUSES = [
        self::PS_NOPAID => 'не оплачен',
        self::PS_PAID => 'оплачен',
    ];

    const PT_CASH = 10;
    const PT_ONLINE = 20;

    public static $PM_TYPES = [
        self::PT_CASH => 'наличными',
        self::PT_ONLINE => 'онлайн',
    ];

    const CK_BOUQUET = 10;
    const CK_MONO    = 20;
    const CK_ROSE    = 30;
    const CK_FIXED   = 40;
    const CK_WEDDING = 50;
    const CK_ADD     = 60;
    const CK_FOLDER = 70;

    const CK_FOLDER_ID = 12;
    const CK_ARTIFICIAL_ID = 13;


    public static $CTL_KIND = array(
        self::CK_BOUQUET => ['name' => 'букеты', 'nameid' => 'bouquet'],
        self::CK_MONO    => ['name' => 'монобукеты', 'nameid' => 'mono'],
        self::CK_ROSE    => ['name' => 'розы', 'nameid' => 'rose'],
        self::CK_FIXED   => ['name' => 'фиксированный букет', 'nameid' => 'fixed'],
        self::CK_WEDDING => ['name' => 'Cвадебные букеты', 'nameid' => 'wedding', 'placeid'=>2],
        self::CK_ADD     => ['name' => 'Дополнительные товары', 'nameid' => 'add'],
        self::CK_FOLDER => ['name' => 'Папки', 'nameid' => 'folder'],
    );

    const DT_DELIVERY = 1;
    const DT_PICKUP = 2;

    public static $DT_TYPES = [
        self::DT_DELIVERY => 'курьером',
        self::DT_PICKUP => 'самовывоз',
    ];

    public static $THEMES = [
        1 => [
            'name' => 'Розовая',
            'class' => 'pink',
        ],
        2 => [
            'name' => 'Синяя',
            'class' => 'blue',
        ],
        3 => [
            'name' => 'Вишневая',
            'class' => 'cherry',
        ],
        4 => [
            'name' => 'Зеленая',
            'class' => 'green',
        ],
        5 => [
            'name' => 'Красная',
            'class' => 'red',
        ],
        6 => [
            'name' => 'Фиолетовый',
            'class' => 'purple',
        ],
        7 => [
            'name' => 'Серая',
            'class' => 'grey',
        ],

        8 => [
            'name' => 'Вишневый (свадебный) ',
            'class' => 'wed-cherry',
        ],
        9 => [
            'name' => 'Серо-зеленый (свадебный) ',
            'class' => 'wed-grey-green',
        ],
        10 => [
            'name' => 'Темно-синий (свадебный) ',
            'class' => 'wed-dark-blue',
        ],
        11 => [
            'name' => 'Фиолетовый (свадебный) ',
            'class' => 'wed-purple',
        ],
        12 => [
            'name' => 'Красный (свадебный) ',
            'class' => 'wed-red',
        ],
        13 => [
            'name' => 'Ярко-зеленый (свадебный) ',
            'class' => 'wed-bright-green',
        ],
        14 => [
            'name' => 'Сизый (свадебный) ',
            'class' => 'wed-dove-colored',
        ],
    ];

    const ORDER_NOT_PAID = 1;
    const ORDER_PAID = 2;

    public static $paymentStatuses = array(
        self::ORDER_NOT_PAID => 'Не оплачено',
        self::ORDER_PAID => 'Оплачено',
    );

    public static $fieldTypes = array(
        'string' => 'String',
        'text' => 'Text',
        'boolean' => 'Boolean',
        'select' => 'Select',
        'checkbox' => 'Checkbox',
    );

    const SPECIAL_ALL = 0;
    const SPECIAL_STORE = 1;
    const SPECIAL_DELIVERY = 2;

    public static $specialTypes = [
        self::SPECIAL_ALL => 'Магазин и доставка',
        self::SPECIAL_STORE => 'Магазин',
        self::SPECIAL_DELIVERY => 'Доставка'
    ];

    // скидка в процентах для товаров с пометкой ExcludeDiscount
    const DISCOUNT = 25;
    const DC_PREFIX = 9978;
    const DC_DISCOUNT_CODE = 3;

    // максимальное кол-во цветов в монобукете
    const MONO_MAX = 51;
    // максимальное количество роз
    const ROSE_MAX = 101;

    public static $errors = [
        'order' => [
            'lessDate'             => 'Дата введена неверно',
            'invalidDate'          => 'Дата введена неверно',
            'noConfirmation'       => 'Необходимо ознакомиться с информацией',
            'customerName'         => 'Укажите ваше имя',
            'customerPhone'        => 'Не указан номер телефона',
            'customerPhone'        => 'Неверный формат номера телефона',
            'recipientPhone'       => 'Неверный формат номера телефона',
            'customerEmail'        => 'Неверный e-mail пользователя',
            'recipientName'        => 'Не указано имя получателя',
            'deliveryDate'         => 'Неверно указана дата',
            'deliveryAddress'      => 'Не указан адрес получателя',
            'noCreateOrder'        => 'Не удалось создать заказ',
            'pickupStore'          => 'Не выбран пункт самовывоза',
            'invalidDiscountCard'  => 'Неверный номер скидочной карты',
            'inactiveDiscountCard' => 'Код недействителен. Обратитесь к администратору интернет-магазина',
            'deliveryTime'         => 'Не выбрано время доставки',
            'invalidPickupTime'    => 'Для того чтобы собрать для вас красивый букет, нам нужно 2 часа с момента оформления заказа. Указанное вами ранее время самовывоза уже не доступно. Просим вас выбрать новое время самовывоза.',
            'invalidDeliveryTime'    => 'Для того чтобы собрать для вас красивый букет, нам нужно 2 часа с момента оформления заказа. Указанное вами ранее время доставки уже не доступно. Просим вас выбрать новое время доставки.',
        ],
        'form_request' => [
            'invalidDate'   => 'Дата введена неверно',
            'wishText'      => 'Не заполнен текст пожелания',
            'customerName'  => 'Укажите ваше имя',
            'customerPhone' => 'Не указан номер телефона',
            'customerPhone' => 'Неверный формат номера телефона',
            'customerEmail' => 'Неверный e-mail пользователя',
            'contact'        => 'Необходимо заполнить поле',
        ],
    ];

    public function __construct()
    {
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('images');

        $this->_db = DBFactory::GetInstance($this->dbname);
        if($this->_db == false)
            throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);

        $this->_cache = $this->getCache();
        $this->GenerateCart();
    }

    public function getCache()
    {
        LibFactory::GetStatic('cache');

        $cache = new Cache();
        $cache->Init('memcache', 'catalogmgr');

        return $cache;
    }

    static function &getInstance ($caching = true)
    {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }

    public function GenerateCart()
    {
        $code = $_COOKIE['cart_code'];
        $code = base64_decode($code);
        if (isset($code) && preg_match("@\d{5}\w{10}\d{10}@", $code))
        {
            $this->CartCode = $code;
        } else {
            LibFactory::GetStatic('textutil');
            $this->CartCode = rand(10000,99999).TextUtil::GenerateRandomString(10).time();
            setcookie("cart_code", base64_encode($this->CartCode), time() + 3600 * 2, '/');
        }

        //setcookie("cart_code", base64_encode($this->CartCode), time() + 1000, '/');
        return;
    }

    public function ClearCart($cart_code)
    {
        $catalogID = App::$City->CatalogId;

        $cart_code = mb_strlen($cart_code) > 0 ? $cart_code : base64_decode($_COOKIE['cart_code']);

        $sql = "DELETE FROM ".$this->_tables['cart'];
        $sql .= " WHERE CartCode = '".$cart_code."'";
        $sql .= " AND CatalogID = ".$catalogID;

        $this->_db->query($sql);
        setcookie("cart_code", "", time()-3600, "/");
        return true;
    }


    // public function GenerateCart()
    // {
    //     $this->CartCode = App::$User->SessionCode;
    //     return;
    // }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Product. В случае ошибки вернет null
     */
    // private function _productObject(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     $product = new Product($info);
    //     if (isset($info['productid']))
    //         $this->_products[ $info['productid'] ] = $product;

    //     return $product;
    // }
    private function _productObject(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);
        $category = $this->GetCategory($info['typeid']);
        $cls = self::$CTL_KIND[$category->Kind]['nameid'];

        if(class_exists($cls))
            $product = new $cls($info);
        else
            $product = new Product($info);

        if (isset($info['productid']))
         $this->_products[ $info['productid'] ] = $product;

        return $product;
    }


    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект discountCard. В случае ошибки вернет null
     */
    private function _discountCardObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new DiscountCard($info);
        if (isset($info['cardid']))
            $this->_discountcards[ $info['cardid'] ] = $obj;

        return $obj;
    }



    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Card. В случае ошибки вернет null
     */
    private function _cardObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $obj = new Card($info);
        if (isset($info['cardid']))
            $this->_cards[ $info['cardid'] ] = $obj;

        return $obj;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект EFilter. В случае ошибки вернет null
     */
    private function _filterObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $filter = new EFilter($info);
        if (isset($info['filterid']))
            $this->_filters[ $info['filterid'] ] = $filter;

        return $filter;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Category. В случае ошибки вернет null
     */
    private function _CategoryObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $category = new Category($info);
        if (isset($info['categoryid']))
            $this->_members[ $info['info'] ] = $category;

        return $category;
    }

       /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект RoseLen. В случае ошибки вернет null
     */
    private function _LenObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $len = new RoseLen($info);
        if (isset($info['lenid']))
            $this->_lens[ $info['info'] ] = $len;

        return $len;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Addition. В случае ошибки вернет null
     */
    private function _AdditionObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $add = new Addition($info);
        if (isset($info['additionid']))
            $this->_additions[ $info['info'] ] = $add;

        return $add;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Member. В случае ошибки вернет null
     */
    private function _MemberObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $member = new Member($info);
        if (isset($info['memberid']))
            $this->_members[ $info['memberid'] ] = $member;

        return $member;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Type. В случае ошибки вернет null
     */
    private function _TypeObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $type = new Type($info);
        if (isset($info['typeid']))
            $this->_types[ $info['typeid'] ] = $type;

        return $type;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Order. В случае ошибки вернет null
     */
    private function _OrderObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $order = new Order($info);
        if (isset($info['orderid']))
            $this->_orders[ $info['orderid'] ] = $order;

        return $order;
    }

    /**
     * Сформировать объект по массиву данных
     *
     * @param array $info - массив полей со значениями
     * @return Объект Seo. В случае ошибки вернет null
     */
    private function _SeoObject(array $info) {

        $info = array_change_key_case($info, CASE_LOWER);

        $seo = new Seo($info);
        $this->_seo[ $info['sectionid'].'_'.$info['typeid'] ] = $seo;

        return $seo;
    }

    /**
    * @return array of product types and its parameters
    *
    */
    public function getProductCategories()
    {
        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
            ),
            'field' => array("Ord"),
            'dir' => array('ASC'),
        );

        $categories = $this->GetCategories($filter);
        $list = array();
        foreach($categories as $category) {
            $list[$category->ID] = array(
                'id'        => $category->ID,
                'url'       => $category->NameID,
                'name'      => $category->Title,
                'ord'       => $category->Ord,
                'kind'      => $category->Kind,
                'isvisible' => $category->IsVisible,
            );
        }

        return $list;

        return array(
            /*self::TYPE_CUSTOM => array(
                'id' => self::TYPE_CUSTOM,
                'url' => 'unique',
                'name' => 'Собери свой букет',
            ),*/
            self::TYPE_ROSE => array(
                'id' => self::TYPE_ROSE,
                'url' => 'roses',
                'name' => 'Розы',
            ),
            self::TYPE_BOUQUET => array(
                'id' => self::TYPE_BOUQUET,
                'url' => 'bouquet',
                'name' => 'Букеты',
            ),
            self::TYPE_TULIP => array(
                'id' => self::TYPE_TULIP,
                'url' => 'tulips',
                'name' => 'Тюльпаны',
            ),
            self::TYPE_WEDDING_DECOR => array(
                'id' => self::TYPE_WEDDING_DECOR,
                'url' => 'wedding_decor',
                'name' => 'Свадебное оформление',
            ),
            self::TYPE_VASE => array(
                'id' => self::TYPE_VASE,
                'url' => 'vases',
                'name' => 'Вазы',
            ),
            self::TYPE_TOY => array(
                'id' => self::TYPE_TOY,
                'url' => 'toys',
                'name' => 'Игрушки',
            ),
            self::TYPE_WORD => array(
                'id' => self::TYPE_WORD,
                'url' => 'words',
                'name' => 'Словечки в букеты',
            ),
            self::TYPE_BRIDAL_BOUQUET => array(
                'id' => self::TYPE_BRIDAL_BOUQUET,
                'url' => 'bridal_bouquet',
                'name' => 'Букет невесты',
            ),
        );
    }

    /**
    * @return array of decor types and its parameters
    *
    */
    public function getDecorTypes()
    {
        return array(
            1 => array(
                'name' => 'Тип 1',
            ),
            2 => array(
                'name' => 'Тип 2',
            ),
            3 => array(
                'name' => 'Тип 3',
            ),
            4 => array(
                'name' => 'Тип 4',
            ),
            5 => array(
                'name' => 'Тип 5',
            ),
            6 => array(
                'name' => 'Тип 6',
            ),
            7 => array(
                'name' => 'Тип 7',
            ),
            8 => array(
                'name' => 'Тип 8',
            ),
        );
    }

    /**
    * @return array of catalog information
    */
    public function GetCatalog()
    {
        return $this->getProductCategories();
    }

    public function GetCatalogsInfo($excludeID) {

        $sql = "SELECT A.id, A.parent, A.name, A.path, A.module, B.name as domain";
        $sql .= " FROM ".$this->_tables['tree']." as A INNER JOIN ".$this->_tables['tree']." as B ON A.parent = B.id";
        $sql .= " WHERE A.module = 'catalog'";

        if (!empty($excludeID)) {
            $excludeID = intval($excludeID);

            $sql .= " AND A.id <> ".$excludeID;
        }

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row;
        }

        return $result;
    }

    /**
    * @return Объект Catalog. В случае ошибки вернет null
    */
    public function GetCatalogByLinkName($linkName)
    {
        if(empty($linkName))
            return null;

        $section = array();

        foreach ($this->getProductCategories() as $type) {
            if ($type['url'] == $linkName) {
                $section = $type;
                break;
            }
        }

        if (empty($section))
            return null;

        $filter = array(
            'flags' => array(
                'filtered' => $ids,
                'CatalogID' => App::$City->CatalogId,
                'TypeID' => $section['id'],
                'IsVisible' => 1,
                // 'IsAvailable' => 1,
                'with' => array('AreaRefs', 'ProductPhotos', 'Types'),
                'objects' => true,
            ),
            'calc' => true,
            'dbg' => 0,
        );

        list($products, $count) = $this->GetProducts($filter);

        return array(
            'section' => $section,
            'products' => $products,
        );
    }

    public function GetSectionsCount() {
        $sql = "select typeid, count(productid) count from ctl_products group by typeid";
    }

    public function GetProducts($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                // if ( !in_array($v, array('Ord', 'TypeID')) )
                //     unset($filter['field'][$k], $filter['dir'][$k]);
                if ( !in_array($v, array('productid', 'article', 'name', 'isvisible', 'isavailable', 'ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }
        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('name');
            $filter['dir'] = array('ASC');
        }

        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['IsMain']) && $filter['flags']['IsMain'] != -1 )
            $filter['flags']['IsMain'] = (int) $filter['flags']['IsMain'];
        elseif (!isset($filter['flags']['IsMain']))
            $filter['flags']['IsMain'] = -1;

        if ( isset($filter['flags']['IsAvailable']) && $filter['flags']['IsAvailable'] != -1 )
            $filter['flags']['IsAvailable'] = (int) $filter['flags']['IsAvailable'];
        elseif (!isset($filter['flags']['IsAvailable']))
            $filter['flags']['IsAvailable'] = -1;

        if ( isset($filter['flags']['InSlider']) && $filter['flags']['InSlider'] != -1 )
            $filter['flags']['InSlider'] = (int) $filter['flags']['InSlider'];
        elseif (!isset($filter['flags']['InSlider']))
            $filter['flags']['InSlider'] = -1;

        if ( isset($filter['flags']['CatalogID']) && (int) $filter['flags']['CatalogID'] > 0 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if ( isset($filter['flags']['TypeID']) && in_array($filter['flags']['TypeID'], array_keys($this->getProductCategories())) )
            $filter['flags']['TypeID'] = (int) $filter['flags']['TypeID'];
        elseif (!isset($filter['flags']['TypeID']))
            $filter['flags']['TypeID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        $fparams = array();
        if(sizeof($filter['flags']['colors']) > 0 )
        {
            foreach($filter['flags']['colors'] as $color)
                $fparams[] = $color;
        }

        if(sizeof($filter['flags']['flowers']) > 0 )
        {
            foreach($filter['flags']['flowers'] as $flower)
                $fparams[] = $flower;
        }

        if(sizeof($filter['flags']['causes']) > 0 )
        {
            foreach($filter['flags']['causes'] as $cause)
                $fparams[] = $cause;
        }

        // if (sizeof($fparams) > 0) {
            $filter['group']['fields'] = array('productid');
        // }

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['products'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['products'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        if($filter['flags']['color'] != 0 )
            $fparams[] = $filter['flags']['color'];

        $sql .= ' FROM '.$this->_tables['products'];

        if(isset($filter['flags']['params']) && is_array($filter['flags']['params']) && count($filter['flags']['params']) > 0 )
        {
            foreach($filter['flags']['params'] as $key => $value) {
                $sql .= ' INNER JOIN '. $this->_tables['product_filters'] .' AS f'.$key.' ON f'.$key.'.ProductID = '.$this->_tables['products'].'.ProductID';
                $sql .= ' AND f'.$key.'.ParamID IN ('.implode(", ", $value).')';
            }


        }

        if ($filter['flags']['all'] === true)
            $areaJoin = ' LEFT JOIN ';
        else
            $areaJoin = ' INNER JOIN ';

        $sql .= $areaJoin.$this->_tables['refs'];
        $sql .= ' ON '.$this->_tables['products'].'.ProductID = '.$this->_tables['refs'].'.ProductID';

        if ( $filter['flags']['CatalogID'] != -1 && $filter['flags']['all'] === true )
            $sql .= ' AND '.$this->_tables['refs'].'.SectionID = '.$filter['flags']['CatalogID'];

        if (sizeof($fparams) > 0) {
            $params = array();

            foreach($fparams as $item)
                $params[] = $this->_tables['product_filters'].'.ParamID='.intval($item);

            $sql .= ' INNER JOIN '.$this->_tables['product_filters'];
            $sql .= ' ON '.$this->_tables['products'].'.ProductID = '.$this->_tables['product_filters'].'.ProductID AND ('.implode(' OR ', $params).')';
        }

        $where = array();

        if ( $filter['flags']['minprice'] != 0 || $filter['flags']['maxprice'] != 0 ) {
            $subHaving= array();
            $subSql = ' SELECT DISTINCT '.$this->_tables['elements'].'.ProductID';
            $subSql .= ' FROM '.$this->_tables['elements'];
            $subSql .= ' INNER JOIN '.$this->_tables['compositions'];
            $subSql .= ' ON '.$this->_tables['compositions'].'.MemberID = '.$this->_tables['elements'].'.ElementID';

            $subExpression = ' SUM('.$this->_tables['compositions'].'.Price * '.$this->_tables['elements'].'.Count)';

            if ( $filter['flags']['maxprice'] != 0 )
                $subHaving[] = $subExpression.' <= '.$filter['flags']['maxprice'];

            if ( $filter['flags']['minprice'] != 0 )
                $subHaving[] = $subExpression.' >= '.$filter['flags']['minprice'];
                //TypeID
            $subSql .= ' GROUP by '.$this->_tables['elements'].'.TypeID';

            if ( sizeof($subHaving) )
                $subSql .= ' HAVING '.implode(' AND ', $subHaving);

            $where[] = ' '.$this->_tables['products'].'.ProductID IN ('.$subSql.')';
        }

        if(isset($filter['flags']['sections']) && is_array($filter['flags']['sections']) && count($filter['flags']['sections']) > 0 ) {
            $where[] = ' '.$this->_tables['products'].'.WeddingType IN ('.implode(",", $filter['flags']['sections']).')';
        }

        if ( is_array($filter['flags']['filtered']) && sizeof($filter['flags']['filtered']) > 0 )
            $where[] = ' '.$this->_tables['products'].'.ProductID IN ('.implode(",", $filter['flags']['filtered']).')';

        if ( $filter['flags']['TypeID'] != -1 )
            $where[] = ' '.$this->_tables['products'].'.TypeID = '.$filter['flags']['TypeID'];

        if(isset($filter['flags']['ParentId'])) {
            $where[] = ' ' . $this->_tables['products'] . '.ParentId = ' . intval($filter['flags']['ParentId']);
        }

        if(isset($filter['flags']['Categories']) && is_array($filter['flags']['Categories']) && count($filter['flags']['Categories'])) {
            $where[] = ' '.$this->_tables['products'].'.TypeID IN ('.implode(',', $filter['flags']['Categories']).')';
        }

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['refs'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['IsMain'] != -1 )
            $where[] = ' '.$this->_tables['refs'].'.IsMain = '.$filter['flags']['IsMain'];

        if ( $filter['flags']['InSlider'] != -1 )
            $where[] = ' '.$this->_tables['refs'].'.InSlider = '.$filter['flags']['InSlider'];

        if ( $filter['flags']['IsAvailable'] != -1 )
            $where[] = ' '.$this->_tables['refs'].'.IsAvailable = '.$filter['flags']['IsAvailable'];

        if ( $filter['flags']['CatalogID'] != -1 && $filter['flags']['all'] !== true )
            $where[] = ' '.$this->_tables['refs'].'.SectionID = '.$filter['flags']['CatalogID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['products'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['products'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['products'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
            {
                if(in_array(strtolower($v), ['ord', 'isvisible', 'isavailable']))
                    $sqlo[] = ' '.$this->_tables['refs'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
                // elseif(strtolower($v) == 'typeid')
                else
                    $sqlo[] = ' '.$this->_tables['products'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
            }

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }
        if($filter['dbg'] == 1)
            echo ":".$sql;
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        $ids = array();
        while ($row = $res->fetch_assoc())
        {
            $id = $row['ProductID'];
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_products[$id]) )
                    $row = $this->_products[$id];
                else
                    $row = $this->_productObject($row);
            }
            $result[$id] = $row;
        }

        if (isset($filter['flags']['with']) && is_array($filter['flags']['with']) && sizeof($filter['flags']['with']) > 0) {
            $ids = array_keys($result);
            $params = array(
                array(
                    'CatalogID' => $filter['flags']['CatalogID'],
                    'ids' => $ids,
                ),
            );

            foreach ($filter['flags']['with'] as $with) {
                $getMethod = 'Get'.$with.'ByIds';
                $loadMethod = 'load'.$with;

                if (method_exists($this, $getMethod)) {
                    $data = call_user_func_array([$this, $getMethod], $params);
                }

                foreach ($ids as $id) {
                    if ($filter['flags']['objects'] === true) {
                        if (method_exists($result[$id], $loadMethod))
                            call_user_func_array([$result[$id], $loadMethod], array($data[$id]));
                    } else {
                        $result[$id][$with] = $data['ProductID'];
                    }
                }
            }
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function GetAreaRefsByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']))
            return null;

        if (empty($filter['CatalogID']) || $filter['CatalogID'] <= 0)
            return null;

        $default = array(
            'IsAdditional' => 0,
            'IsAvailable' => 0,
            'IsVisible' => 0,
            'IsMain' => 0,
            'Ord' => 0,
        );

        $sql = 'SELECT * FROM '.$this->_tables['refs'];
        $sql .= ' WHERE `ProductID` IN ('.implode(",",$filter['ids']).')';
        $sql .= ' AND `SectionID` = '.intval($filter['CatalogID']);

        $isEmpty = false;
        if ( false === ($res = $this->_db->query($sql)))
            $isEmpty = true;

        if (!$res->num_rows)
            $isEmpty = true;

        $result = array();
        if (!$isEmpty) {
            while ($row = $res->fetch_assoc())
            {
                $result[$row['ProductID']] = $row;
            }
        }

        $refs = array();
        foreach ($filter['ids'] as $id) {
            $refs[$id] = isset($result[$id]) ? $result[$id] : $default;
        }

        return $refs;
    }

    public function GetTypeAreaRefsByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']))
            return null;

        if (empty($filter['CatalogID']) || $filter['CatalogID'] <= 0)
            return null;

        $default = array(
            'IsVisible' => 0,
            'IsDefault' => 0,
            'Ord' => 0,
        );

        $sql = 'SELECT * FROM '.$this->_tables['typeRefs'];
        $sql .= ' WHERE `TypeID` IN ('.implode(",",$filter['ids']).')';
        $sql .= ' AND `SectionID` = '.intval($filter['CatalogID']);

        $isEmpty = false;
        if ( false === ($res = $this->_db->query($sql)))
            $isEmpty = true;

        if (!$res->num_rows)
            $isEmpty = true;

        $result = array();
        if (!$isEmpty) {
            while ($row = $res->fetch_assoc())
            {
                $result[$row['TypeID']] = $row;
            }
        }

        $refs = array();
        foreach ($filter['ids'] as $id) {
            $refs[$id] = isset($result[$id]) ? $result[$id] : $default;
        }

        return $refs;
    }

    public function isVisibleElement($ElementID, $CatalogID) {
        $sql = 'SELECT IsVisible FROM '. $this->_tables['compositions_refs'].' WHERE MemberID='.$ElementID.' AND SectionID='.$CatalogID;

        if($res = $this->_db->query($sql))
            return $res->fetch_assoc()['IsVisible'];
    }

    public function GetElementsByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']) || sizeof($filter['ids']) <= 0)
            return null;

        $filter['CatalogID'] = intval($filter['CatalogID']);

        // if ($filter['CatalogID'] <= 0)
        //     return null;

        $sql  = "SELECT *";
        $sql .= " FROM ".$this->_tables['elements']." as e";
        $sql .= " INNER JOIN ".$this->_tables['compositions'] ." as c ";
        $sql .= " ON e.ElementID = c.MemberID ";
        $sql .= " LEFT JOIN ".$this->_tables['compositions_refs'].' as r ';
        $sql .= " ON c.MemberID = r.MemberID AND r.SectionID = ".$filter['CatalogID'];
        $sql .= " WHERE e.TypeID IN (".implode(",", $filter['ids']).")";
        if($filter['CatalogID'] > 0)
            $sql .= " AND e.SectionID = ".$filter['CatalogID'];
        if(isset($filter['IsVisible']) && in_array($filter['IsVisible'], [0,1]))
            $sql .= ' AND r.IsVisible = '.$filter['IsVisible'];
        $sql .= " ORDER BY c.Name ASC";
        //echo $sql; exit;
         if ( false === ($res = $this->_db->query($sql)))
        {
            return null;
        }

        if (!$res->num_rows )
        {
            return null;
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[$row['TypeID']][] = $row;
        }

        return $result;
    }

    public function GetTypesByIds($filter, $IsVisible = true)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']) || sizeof($filter['ids']) <= 0)
            return null;

        $filter['CatalogID'] = intval($filter['CatalogID']);

        // if ($filter['CatalogID'] <= 0)
        //  return null;

        $sql = "SELECT ".$this->_tables['types'].".*";
        $sql .= " FROM ".$this->_tables['types'];
        if ($filter['CatalogID'] > 0) {
            $sql .= " INNER JOIN ".$this->_tables['typeRefs'];
            $sql .= " ON ".$this->_tables['typeRefs'].".TypeID=".$this->_tables['types'].".TypeID";
           if($IsVisible)
                $sql .= " AND ".$this->_tables['typeRefs'].".IsVisible=1";
            $sql .= " AND ".$this->_tables['typeRefs'].".SectionID=".$filter['CatalogID'];
        }
        $sql .= " WHERE ".$this->_tables['types'].".ProductID IN (".implode(",", $filter['ids']).")";
        $sql .= " ORDER BY ".$this->_tables['types'].".Ord Desc";

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows)
            return null;

        $result = array();
        $ids = array();
        while ($row = $res->fetch_assoc())
        {
            $ids[] = $row['TypeID'];
            $result[$row['ProductID']][] = $this->_TypeObject($row);
        }

        $filter = array(
            'CatalogID' => $filter['CatalogID'],
            'ids' => $ids,
        );

        $composition = $this->GetElementsByIds($filter);
        $refs = $this->GetTypeAreaRefsByIds($filter);

        foreach ($result as $productid => $types) {
            foreach ($types as $k => $v) {
                $result[$productid][$k]->loadElements($composition[$v->ID]);
                $result[$productid][$k]->loadTypeAreaRefs($refs[$v->ID]);
            }
        }

        return $result;
    }

    /**
    * @return Объект Product. В случае ошибки вернет null
    */
    public function GetProduct($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return null;

        if ( isset($this->_products[$id]) )
            return $this->_products[$id];

        $info = false;

        $cacheid = 'product_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['products'].' WHERE ProductID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;


            $info = $res->fetch_assoc();

            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600 * 24);
        }

        $product = $this->_productObject($info);
        return $product;
    }

    /**
    * @return id of added product or false
    */
    public function AddProduct(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        unset($info['productid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['products'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return id of <update></update>d product or false
    */
    public function UpdateProduct(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) || !Data::Is_Number($info['productid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
        {
            $fields[] = "`$k` = '".addslashes($v)."'";
        }
        $sql = 'UPDATE '.$this->_tables['products'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE ProductID = '.$info['productid'];

        if($this->_db->query($sql) !== false)
        {
            $cache = $this->getCache();
            $cache->Remove('product_'.$info['productid']);

            unset($this->_products[$info['productid']]);
            return $info['productid'];
        }

        return false;
    }

    /**
    * @return bool
    */
    public function RemoveProduct($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['products'].' WHERE ProductID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('product_'.$id);

            unset($this->_products[$id]);
            return true;
        }

        return false;
    }

    /**
    * @return array of photo objects
    */
    public function GetProductPhotosByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']) || sizeof($filter['ids']) <= 0)
            return null;

        $filter = array(
            'flags' => array(
                'filtered' => $filter['ids'],
                'IsVisible' => 1,
                'with' => true,
                'objects' => true,
            ),
        );

        return $this->GetProductPhotos($filter);
    }

    /**
    * alias for ProductPhotoMgr::GetPhotos().
    */
    public function GetProductPhotos($filter)
    {
        if (empty($filter))
            return null;

        if ($this->_photoMgr === null) {
            LibFactory::GetMStatic('catalog', 'productphotomgr');
            $this->_photoMgr = ProductPhotoMgr::getInstance(false);
        }

        return $this->_photoMgr->GetPhotos($filter);
    }

    // /**
    // * @param section id
    // * @param type id
    // * @return Seo object
    // */
    // public function GetSectionSeo($sid, $tid)
    // {
    //     $sid = intval($sid);
    //     $tid = intval($tid);
    //     if ($sid <= 0 || $tid <= 0)
    //         return null;

    //     if ( isset($this->_seo[$sid.'_'.$tid]) )
    //         return $this->_seo[$sid.'_'.$tid];

    //     $info = false;

    //     $cacheid = 'seo_'.$sid.'_'.$tid;

    //     if ($this->_cache !== null)
    //         $info = $this->_cache->get($cacheid);

    //     if ($_GET['nocache']>12)
    //         $info = false;

    //     if ($info === false)
    //     {
    //         $sql = 'SELECT * FROM '.$this->_tables['seo'];
    //         $sql .= ' WHERE SectionID = '.$sid;
    //         $sql .= ' AND TypeID = '.$tid;

    //         if ( false === ($res = $this->_db->query($sql)))
    //             return null;

    //         if (!$res->num_rows )
    //             return null;

    //         $info = $res->fetch_assoc();

    //         if ($this->_cache !== null)
    //             $this->_cache->set($cacheid, $info, 3600 * 24);
    //     }

    //     $product = $this->_SeoObject($info);
    //     return $product;
    // }

    // /**
    // * @return id of added entry or false
    // */
    // public function AddSeo(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     if ( !sizeof($info) )
    //         return false;

    //     $fields = array();
    //     foreach( $info as $k => $v)
    //         $fields[] = "`$k` = '".addslashes($v)."'";

    //     $sql = 'INSERT IGNORE INTO '.$this->_tables['seo'].' SET ' . implode(', ', $fields);

    //     if ( false !== $this->_db->query($sql) )
    //         return $this->_db->insert_id;

    //     return false;
    // }

    // /**
    // * @return bool
    // */
    // public function UpdateSeo(array $info)
    // {
    //     $info = array_change_key_case($info, CASE_LOWER);

    //     if ( !sizeof($info) || !Data::Is_Number($info['sectionid']) )
    //         return false;

    //     $fields = array();
    //     foreach( $info as $k => $v)
    //     {
    //         $fields[] = "`$k` = '".addslashes($v)."'";
    //     }
    //     $sql = 'UPDATE '.$this->_tables['seo'].' SET ' . implode(', ', $fields);
    //     $sql .= ' WHERE SectionID = '.$info['sectionid'];
    //     $sql .= ' AND TypeID = '.$info['typeid'];

    //     if($this->_db->query($sql) !== false)
    //     {
    //         $cache = $this->getCache();
    //         $cache->Remove('seo_'.$info['sectionid'].'_'.$info['typeid']);

    //         unset($this->_seo[$info['sectionid'].'_'.$info['typeid']]);
    //         return true;
    //     }

    //     return false;
    // }

    /**
    * @param section id
    * @param type id
    * @return bool
    */
    // public function RemoveSeo($sid, $tid)
    // {
    //     if ( !Data::Is_Number($id) )
    //         return false;

    //     $sql = 'DELETE FROM '.$this->_tables['seo'];
    //     $sql .= ' WHERE SectionID = '.$sid;
    //     $sql .= ' AND TypeID = '.$tid;
    //     if ( false !== $this->_db->query($sql) )
    //     {
    //         $cache = $this->getCache();
    //         $cache->Remove('seo_'.$sid.'_'.$tid);

    //         unset($this->_seo[$sid.'_'.$tid]);
    //         return true;
    //     }

    //     return false;
    // }

    /**
    * @param section id
    * @param type id
    * @return bool or if error null
    */
    public function IsSeoExist($sid, $tid)
    {
        if ( !Data::Is_Number($sid) || !Data::Is_Number($tid) )
            return null;

        if ($sid < 0 || $tid < 0)
            return null;

        $sql = 'SELECT count(*) FROM '.$this->_tables['refs'];
        $sql .= ' WHERE SectionID = '.$sid;
        $sql .= ' AND TypeID = '.$tid;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();
        $count = intval($info['count(*)']);

        if ($count > 0)
        {
            return true;
        }

        return false;
    }

    public function IsAreaRefExist($productid, $sectionid)
    {
        if ( !Data::Is_Number($productid) || !Data::Is_Number($sectionid) )
            return null;

        if ($productid < 0 || $sectionid < 0)
            return null;

        $sql = 'SELECT count(*) FROM '.$this->_tables['refs'];
        $sql .= ' WHERE ProductID = '.$productid;
        $sql .= ' AND sectionID = '.$sectionid;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $result = array();

        $info = $res->fetch_assoc();
        $count = intval($info['count(*)']);

        if ($count > 0)
        {
            return true;
        }

        return false;
    }

    /**
    * @return bool
    */
    public function UpdateAreaRef(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) )
            return false;

        if ($this->IsAreaRefExist($info['productid'], $info['sectionid'])) {
            return $this->_UpdateRef($info);
        } else {
            return $this->_AddRef($info);
        }
    }

    /**
    * @return id of added reference or false
    */
    private function _AddRef(array $info)
    {

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT IGNORE INTO '.$this->_tables['refs'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return bool shows if entry was updated or not
    */
    private function _UpdateRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['refs'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE ProductID = '.$info['productid'];
        $sql .= ' AND SectionID = '.$info['sectionid'];

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function RemoveProductRefs($productID)
    {
        $productID = intval($productID);
        if ( !Data::Is_Number($productID) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['refs'].' WHERE ProductID = '.$productID;

        return $this->_db->query($sql);
    }

    public function IsTypeAreaRefExist($typeid, $sectionid)
    {
        if ( !Data::Is_Number($typeid) || !Data::Is_Number($sectionid) )
            return null;

        if ($typeid < 0 || $sectionid < 0)
            return null;

        $sql = 'SELECT count(*) FROM '.$this->_tables['typeRefs'];
        $sql .= ' WHERE TypeID = '.$typeid;
        $sql .= ' AND sectionID = '.$sectionid;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();
        $count = intval($info['count(*)']);

        if ($count > 0)
        {
            return true;
        }

        return false;
    }

    /**
    * @return bool
    */
    public function UpdateTypeAreaRef(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) )
            return false;

        if ($this->IsTypeAreaRefExist($info['typeid'], $info['sectionid'])) {
            return $this->_UpdateTypeRef($info);
        } else {
            return $this->_AddTypeRef($info);
        }
    }

    /**
    * @return id of added reference or false
    */
    private function _AddTypeRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT IGNORE INTO '.$this->_tables['typeRefs'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return bool shows if entry was updated or not
    */
    private function _UpdateTypeRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['typeRefs'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE TypeID = '.$info['typeid'];
        $sql .= ' AND SectionID = '.$info['sectionid'];

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function RemoveTypeRefs($typeID)
    {
        $typeID = intval($typeID);
        if ( !Data::Is_Number($typeID) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['typeRefs'];
        $sql .= ' WHERE TypeID = '.$typeID;

        return $this->_db->query($sql);
    }

    public function RemoveTypeElementsRefs($typeID)
    {
        $typeID = intval($typeID);
        if ( !Data::Is_Number($typeID) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['elements'];
        $sql .= ' WHERE TypeID = '.$typeID;

        $res = $this->_db->query($sql);

        $this->logElementsDeleting($sql);


        return $res;
    }

    /**
    * @return false or section
    */
    public function IsCatalogLinkNameExist($linkName)
    {
        $exists = false;

        foreach ($this->getProductCategories() as $section) {
            if ($section['url'] == $linkName)
                $exists = $section;
        }

        return $exists;
    }

    /****** Filters *******/
    public function AddFilter(array $info)
    {
        unset($info['filterid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['filters'].' SET '. implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveFilter($id)
    {
        if ( !Data::Is_Number($id) )
            return false;


        if ($this->_filters[$id])
            $filter = $this->_filters[$id];
        else
            $filter = $this->GetFilter($id);

        if ($filter !== null)
        {
            $params = $filter->GetParams();
            if (is_array($params) && count($params) > 0)
            {
                foreach($params as $k => $v)
                    $filter->RemoveParam($k);
            }
        }

        $sql = 'DELETE FROM '.$this->_tables['filters'].' WHERE filterid = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('ctl_filter_'.$id);

            unset($this->_filters[$id]);
            return true;
        }

        return false;
    }

    public function UpdateFilter(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['filterid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['filters']. ' SET '. implode(', ', $fields);
        $sql .= ' WHERE FilterID = '.$info['filterid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('ctl_filter_'.$info['filterid']);

            return true;
        }

        return false;
    }

    public function GetFilter($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_filters[$id]))
            return $this->_filters[$id];

        $info = false;

        $cacheid = 'ctl_filter_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['filters'].' WHERE FilterID = '.$id;
            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_filterObject($info);
    }

    public function GetFilterByName($ctl_filter_name, $isavailable = null)
    {
        if(!$ctl_filter_name)
            return null;

        $sql = "SELECT * FROM ".$this->_tables['filters']." WHERE NameID = '".$ctl_filter_name."'";
        // if($isavailable !== null)
        //     $sql .= " AND IsAvailable = " .intval($isavailable);

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();
        return $this->_filterObject($info);
    }

    public function GetFilters($filter)
    {
        global $OBJECTS;

        $sql = "SELECT * FROM ".$this->_tables['filters']." ORDER BY Name";

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;


        $result = array();
        while ($row = $res->fetch_assoc())
        {

            if ( isset($this->_filters[$row['filterid']]) )
                $row = $this->_filters[$row['filterid']];
            else
                $row = $this->_filterObject($row);

            $result[] = $row;
        }

        return $result;
    }

    /******** End filters ********/


    /******* Decors ********/
    public function GetDecors($type = null, $sectionID = 0)
    {
        if ($sectionID == 0)
            return null;

        $sql = "SELECT * FROM ".$this->_tables['decor'];

        $sql .= " WHERE SectionID = ".intval($sectionID);

        if ($type !== null)
            $sql.= " AND NodeType=".$type;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return null;

        $decors = array();
        while($row = $res->fetch_assoc())
        {
            $row['Ranges'] = unserialize($row['Ranges']);
            $decors[$row['DecorID']] = $row;
        }
        return $decors;
    }

    public function GetDecor($id)
    {
        $id = intval($id);
        if ($id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['decor']." WHERE DecorID=".$id;
        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return false;

        $decor = $res->fetch_assoc();
        $decor['Ranges'] = unserialize($decor['Ranges']);
        return $decor;
    }

    public function AddDecor($decor)
    {
        $sql = "INSERT INTO ".$this->_tables['decor']." SET";
        $sql.= " NodeType=".intval($decor['NodeType']);
        $sql.= ", SectionID=".intval($decor['SectionID']);
        $sql.= ", Name='".addslashes($decor['Name'])."'";
        $sql.= ", Ranges='".addslashes(serialize($decor['Ranges']))."'";

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function UpdateDecor($decor)
    {
        $sql = "UPDATE ".$this->_tables['decor']." SET";
        $sql.= " NodeType=".intval($decor['NodeType']);
        $sql.= ", Name='".addslashes($decor['Name'])."'";
        $sql.= ", Ranges='".addslashes(serialize($decor['Ranges']))."'";
        $sql.= " WHERE DecorID=".intval($decor['DecorID']);

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function RemoveDecor($id)
    {
        $sql = "DELETE FROM ".$this->_tables['decor']." WHERE DecorID=".intval($id);
        $this->_db->query($sql);
        return;
    }

    public function GetDecorPrice($id, $cnt)
    {
        $decor = $this->GetDecor($id);
        if ($decor === false)
            return 0;

        foreach($decor['Ranges'] as $range)
        {
            if ($cnt >= $range['from'] && $cnt <= $range['to'])
            {
                return $range['price'];
            }
        }
        return 0;
    }

    /****** End decors ********/

    /****** Types *******/

    public function AddType(array $info)
    {
        unset($info['typeid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['types'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveType($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        // Удаление товаров из корзины с текущим TypeID
        $sql = 'DELETE FROM '.$this->_tables['cart'].' WHERE TypeID = '.$id;
        $this->_db->query($sql);

        $sql = 'DELETE FROM '.$this->_tables['elements'].' WHERE TypeID = '.$id;
        $this->_db->query($sql);

        $sql = 'DELETE FROM '.$this->_tables['types'].' WHERE TypeID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Type_'.$id);

            unset($this->_types[$id]);
            return true;
        }

        return false;
    }

    public function UpdateType(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['typeid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['types'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE TypeID = '.$info['typeid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Type_'.$info['typeid']);

            return true;
        }

        return false;
    }

    public function GetType($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_types[$id]))
            return $this->_types[$id];

        $info = false;

        $cacheid = 'Type_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['types'].' WHERE TypeID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_TypeObject($info);
    }

    public function GetTypes($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Name', 'Created', 'LastUpdated')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Name');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;

        if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if ( !Data::Is_Number($filter['flags']['UserID']) )
            $filter['flags']['UserID'] = 0;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['types'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['types'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['types'].' ';

        $where = array();

        if ( is_array($filter['flags']['filtered']) && sizeof($filter['flags']['filtered']) > 0 )
            $where[] = $this->_tables['types'].' .TypeID IN ('.implode(",", $filter['flags']['filtered']).')';

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['types'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['types'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['types'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['CatalogID'] != -1 )
            $where[] = ' '.$this->_tables['types'].'.CatalogID = '.$filter['flags']['CatalogID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['types'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['types'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['types'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        $ids = array();
        while ($row = $res->fetch_assoc())
        {
            $id = $row['TypeID'];
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_types[$id]) )
                    $row = $this->_types[$id];
                else
                    $row = $this->_TypeObject($row);
            }
            $result[$id] = $row;
        }

        if (isset($filter['flags']['with']) && is_array($filter['flags']['with']) && sizeof($filter['flags']['with']) > 0) {
            $ids = array_keys($result);
            $params = array(
                array(
                    'CatalogID' => $filter['flags']['CatalogID'],
                    'ids' => $ids,
                ),
            );

            foreach ($filter['flags']['with'] as $with) {
                $getMethod = 'Get'.$with.'ByIds';
                $loadMethod = 'load'.$with;
                if (method_exists($this, $getMethod)) {
                    $data = call_user_func_array([$this, $getMethod], $params);
                }

                foreach ($ids as $id) {
                    if ($filter['flags']['objects'] === true) {
                        if (method_exists($result[$id], $loadMethod))
                            call_user_func_array([$result[$id], $loadMethod], array($data[$id]));
                    } else {
                        $result[$id][$with] = $data['TypeID'];
                    }
                }
            }
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** End types *******/


    /****** Composition *******/

    public function AddMember(array $info)
    {
        unset($info['memberid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['compositions'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveMember($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = "DELETE FROM ".$this->_tables['elements'].' WHERE ElementID = '.$id;
        $this->_db->query($sql);


        $this->logElementsDeleting($sql);

        $sql = 'DELETE FROM '.$this->_tables['compositions'].' WHERE MemberID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $this->logElementsDeleting($sql);
            $cache = $this->getCache();
            $cache->Remove('Member_'.$id);

            unset($this->_members[$id]);
            return true;
        }

        return false;
    }

    public function UpdateMember(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['memberid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['compositions'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE MemberID = '.$info['memberid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Member_'.$info['memberid']);

            return true;
        }

        return false;
    }

    public function GetMember($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_members[$id]))
            return $this->_members[$id];

        $info = false;

        $cacheid = 'Member_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['compositions'].' WHERE MemberID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_MemberObject($info);
    }

    public function GetMemberByName($name)
    {

        if (mb_strlen($name) == 0)
            return null;

        $sql = 'SELECT * FROM '.$this->_tables['compositions'].' WHERE Name = "'.addslashes(htmlspecialchars($name)).'"';

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();

        return $this->_MemberObject($info);
    }

    public function GetMemberByArticle($article)
    {

        if (mb_strlen($article) == 0)
            return null;

        $sql = 'SELECT * FROM '.$this->_tables['compositions'].' WHERE Article = "'.addslashes($article).'"';

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();

        return $this->_MemberObject($info);
    }

    // public function GetMembers($filter)
    // {
    //     global $OBJECTS;
    //     if ( isset($filter['field']) ) {
    //         $filter['field'] = (array) $filter['field'];
    //         $filter['dir'] = (array) $filter['dir'];

    //         foreach($filter['field'] as $k => $v) {
    //             if ( !in_array($v, array('Name', 'Created', 'LastUpdated')) )
    //                 unset($filter['field'][$k], $filter['dir'][$k]);
    //         }

    //         foreach($filter['dir'] as $k => $v) {
    //             $v = strtoupper($v);
    //             if ( $v != 'ASC' && $v != 'DESC' )
    //                 $filter['dir'][$k] = 'ASC';
    //         }

    //     }

    //     if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
    //         $filter['field'] = array('Name');
    //         $filter['dir'] = array('ASC');
    //     }

    //     // Видимые
    //     if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
    //         $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
    //     elseif (!isset($filter['flags']['IsVisible']))
    //         $filter['flags']['IsVisible'] = 1;

    //     if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
    //         $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
    //     elseif (!isset($filter['flags']['CatalogID']))
    //         $filter['flags']['CatalogID'] = -1;

    //     if ( !Data::Is_Number($filter['flags']['UserID']) )
    //         $filter['flags']['UserID'] = 0;

    //     if(!isset($filter['offset']) || !is_numeric($filter['offset']))
    //         $filter['offset'] = 0;
    //     if($filter['offset'] < 0) $filter['offset'] = 0;

    //     if(!isset($filter['limit']) || !is_numeric($filter['limit']))
    //         $filter['limit'] = 0;

    //     if ($filter['calc'] === true)
    //         $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['compositions'].'.* ';
    //     else
    //         $sql = 'SELECT '.$this->_tables['compositions'].'.* ';

    //     if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
    //         $sql.= ', COUNT(*) as GroupingCount ';

    //     $sql.= ' FROM '.$this->_tables['compositions'].' ';

    //     $where = array();


    //     if ( !empty($filter['flags']['NameStart']) )
    //         $where[] = ' '.$this->_tables['compositions'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
    //     else if ( !empty($filter['flags']['NameContains']) )
    //         $where[] = ' '.$this->_tables['compositions'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

    //     if ( $filter['flags']['IsVisible'] != -1 )
    //         $where[] = ' '.$this->_tables['compositions'].'.IsVisible = '.$filter['flags']['IsVisible'];

    //     if ( $filter['flags']['CatalogID'] != -1 )
    //         $where[] = ' '.$this->_tables['compositions'].'.CatalogID = '.$filter['flags']['CatalogID'];


    //     if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
    //         $like = array();
    //         foreach($filter['filter']['fields'] as $k => $v) {
    //             if (!isset($filter['filter']['values'][$k]))
    //                 $like[] = ' '.$this->_tables['compositions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
    //             else
    //                 $like[] = ' '.$this->_tables['compositions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
    //         }

    //         if ($filter['filter']['cond'])
    //             $where[] = implode(' AND ', $like);
    //         else
    //             $where[] = '('.implode(' OR ', $like).')';
    //     }

    //     if ( sizeof($where) )
    //         $sql .= ' WHERE '.implode(' AND ', $where);

    //     if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
    //         $group = array();
    //         foreach($filter['group']['fields'] as $v) {
    //             $group[] = ' '.$this->_tables['compositions'].'.`'.$v.'`';
    //         }

    //         $sql .= ' GROUP by '.implode(', ', $group);
    //     }

    //     if (isset($filter['having']) && $filter['having'])
    //         $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

    //     $sql.= ' ORDER by ';

    //         $sqlo = array();
    //         foreach( $filter['field'] as $k => $v )
    //             $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

    //         $sql .= implode(', ', $sqlo);

    //     if ( $filter['limit'] ) {
    //         $sql .= ' LIMIT ';
    //         if ( $filter['offset'] )
    //             $sql .= $filter['offset'].', ';

    //         $sql .= $filter['limit'];
    //     }

    //     $res = $this->_db->query($sql);
    //     if ( !$res || !$res->num_rows )
    //         return false;

    //     if ( $filter['calc'] === true )
    //     {
    //         $sql = "SELECT FOUND_ROWS()";
    //         list($count) = $this->_db->query($sql)->fetch_row();
    //     }

    //     if($filter['dbg'] == 1)
    //         echo ":".$sql;

    //     $result = array();
    //     while ($row = $res->fetch_assoc())
    //     {
    //         if ($filter['flags']['objects'] === true)
    //         {
    //             if ( isset($this->_members[$row['MemberID']]) )
    //                 $row = $this->_members[$row['MemberID']];
    //             else
    //                 $row = $this->_MemberObject($row);
    //         }
    //         $result[] = $row;
    //     }

    //     if ( $filter['calc'] === true )
    //         return array($result, $count);

    //     return $result;
    // }

    public function GetMembers($filter)
    {
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Ord', 'name', 'article', 'isvisible')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }
        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Name');
            $filter['dir'] = array('ASC');
        }

        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['CatalogID']) && (int) $filter['flags']['CatalogID'] > 0 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        // if (sizeof($fparams) > 0) {
            $filter['group']['fields'] = array('memberid');
        // }

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['compositions'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['compositions'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        if($filter['flags']['color'] != 0 )
            $fparams[] = $filter['flags']['color'];

        $sql .= ' FROM '.$this->_tables['compositions'];

        if ($filter['flags']['all'] === true)
            $areaJoin = ' LEFT JOIN ';
        else
            $areaJoin = ' INNER JOIN ';

        $sql .= $areaJoin.$this->_tables['compositions_refs'];
        $sql .= ' ON '.$this->_tables['compositions_refs'].'.MemberID = '.$this->_tables['compositions_refs'].'.MemberID';

        if ( $filter['flags']['CatalogID'] != -1 && $filter['flags']['all'] === true )
            $sql .= ' AND '.$this->_tables['compositions_refs'].'.SectionID = '.$filter['flags']['CatalogID'];


        $where = array();

        if ( is_array($filter['flags']['filtered']) && sizeof($filter['flags']['filtered']) > 0 )
            $where[] = ' '.$this->_tables['compositions'].'.MemberID IN ('.implode(",", $filter['flags']['filtered']).')';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['compositions_refs'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['CatalogID'] != -1 && $filter['flags']['all'] !== true )
            $where[] = ' '.$this->_tables['compositions_refs'].'.SectionID = '.$filter['flags']['CatalogID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['compositions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['compositions'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['compositions'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
            {
                if(strtolower($v) == 'ord')
                    $sqlo[] = ' '.$this->_tables['compositions_refs'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
                else
                    $sqlo[] = ' '.$this->_tables['compositions'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
            }

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }
        if($filter['dbg'] == 1)
            echo ":".$sql;
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        $ids = array();
        while ($row = $res->fetch_assoc())
        {
            $id = $row['MemberID'];
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_members[$id]) )
                    $row = $this->_members[$id];
                else
                    $row = $this->_memberObject($row);
            }
            $result[$id] = $row;
        }

        if (isset($filter['flags']['with']) && is_array($filter['flags']['with']) && sizeof($filter['flags']['with']) > 0) {
            $ids = array_keys($result);
            $params = array(
                array(
                    'CatalogID' => $filter['flags']['CatalogID'],
                    'ids' => $ids,
                ),
            );

            foreach ($filter['flags']['with'] as $with) {
                $getMethod = 'Get'.$with.'ByIds';
                $loadMethod = 'load'.$with;

                if (method_exists($this, $getMethod)) {
                    $data = call_user_func_array([$this, $getMethod], $params);
                }

                foreach ($ids as $id) {
                    if ($filter['flags']['objects'] === true) {
                        if (method_exists($result[$id], $loadMethod))
                            call_user_func_array([$result[$id], $loadMethod], array($data[$id]));
                    } else {
                        $result[$id][$with] = $data['MemberID'];
                    }
                }
            }
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** End composition *******/

    /****** Orders *******/

    public function RemoveOrderRefs($id)
    {
        $sql = "DELETE FROM ".$this->_tables['order_refs'].' WHERE OrderID = '.$id;
        $this->_db->query($sql);

        return true;
    }

    public function AddCustomOrderRefs($orderId, $items)
    {
        $productId = 0;
        $typeId = 0;
        $currenttime = time();

        foreach ($items as $item) {
            $price = $item['count'] * $item['price'];
            $currenttime += 1;
            $sql = "INSERT IGNORE INTO ".$this->_tables['order_refs']." SET";
            $sql .= " OrderID = ".$orderId;
            $sql .= ", ProductID = " . $productId;
            $sql .= ", Count = ".$item['count'];
            $sql .= ", TypeID = ".$typeId;
            $sql .= ", CurrentTime = '".$currenttime."'";
            $sql .= ", Params = ''";
            $sql .= ", Additions = ''";
            $sql .= ", Description = ''";
            $sql .= ", BouquetType = ''";
            $sql .= ", Price = ".$price;
            $sql .= ", BouquetPrice = ".$item['price'];
            $sql .= ", Name = '".$item['name']."'";

            $this->_db->query($sql);
        }

        return true;
    }

    public function AddOrderRefs($id)
    {
        $cart = $this->GetCart();

        foreach ($cart['items'] as $key => $item) {

            $arrAdditions = [];
            if(count($item['additions']))
            {
                foreach ($item['additions'] as $additionid => $addition) {
                    // $arrAdditions[$additionid] = $addition['count'];
                    $arrAdditions[$additionid]['count'] = $addition['count'];
                    $arrAdditions[$additionid]['name'] = $addition['object']->name;
                    $arrAdditions[$additionid]['price'] = $addition['object']->price;
                    $arrAdditions[$additionid]['article'] = $addition['object']->article;
                }
            }

            if(count($arrAdditions) > 0)
                $additions = serialize($arrAdditions);
            else
                $additions = '';

            if(is_array($item['params']) && count($item['params']) > 0 )
                $params = serialize($item['params']);
            else
                $params = '';

            list($productid, $typeid, $currenttime) = explode("_", base64_decode($key));

            $bouquet_type = '';
            if($typeid > 0) {
                $type = $this->GetType($typeid);
                if($type !== null) {
                    $bouquet_type = $type->name;
                }

            }

            $sql = "INSERT IGNORE INTO ".$this->_tables['order_refs']." SET";
            $sql .= " OrderID = ".$id;
            $sql .= ", ProductID = ".$item['product']->ID;
            $sql .= ", Count = ".$item['count'];
            $sql .= ", TypeID = ".$typeid;
            $sql .= ", CurrentTime = '".$currenttime."'";
            $sql .= ", Params = '".$params."'";
            $sql .= ", Additions = '".$additions."'";
            $sql .= ", Description = '".addslashes($item['description'])."'";
            $sql .= ", BouquetType = '".addslashes($bouquet_type)."'";
            $sql .= ", Price = ".$item['item_price'];
            $sql .= ", BouquetPrice = ".$item['price'];
            $sql .= ", ClearPrice = ".$item['clear_price'];

            $this->_db->query($sql);

        }
        return true;
    }

    public function AddOrder(array $info)
    {
        unset($info['orderid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();

        // Костыль
        $info['paymentdate'] = 0;
        foreach( $info as $k => $v) {
            // Костыль
            if(is_bool($v)) {
                $v = (int) $v;
            }

            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'INSERT INTO '.$this->_tables['orders'].' SET  ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) ) {
            $id = $this->_db->insert_id;
            $this->AddOrderRefs($id);
            return $id;
        }

        return false;
    }

    public function RemoveOrder($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $this->RemoveOrderRefs($id);

        $sql = 'DELETE FROM '.$this->_tables['orders'].' WHERE OrderID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Order_'.$id);

            unset($this->_orders[$id]);
            return true;
        }

        return false;
    }

    public function UpdateOrder(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['orderid']) )
            return false;

        $path = ENGINE_PATH.'resources/log';

        $fields = array();
        foreach( $info as $k => $v) {
            // $fields[] = "`$k` = '".addslashes($v)."'";
            $fields[] = "`$k` = '".addslashes($v)."'";
        }

        $sql = 'UPDATE '.$this->_tables['orders'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE OrderID = '.$info['orderid'];

        error_log("\n", 3, $path.'/log_order_'.$info['orderid'].'.log');
        error_log($sql, 3, $path.'/log_order_'.$info['orderid'].'.log');
        error_log("\n", 3, $path.'/log_order_'.$info['orderid'].'.log');

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Order_'.$info['orderid']);

            // $this->RemoveOrderRefs($info['orderid']);
            // $this->AddOrderRefs($info['orderid']);

            return true;
        }

        return false;
    }

    public function GetOrder($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_orders[$id]))
            return $this->_orders[$id];

        $info = false;

        $cacheid = 'Order_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['orders'].' WHERE OrderID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_OrderObject($info);
    }

    public function GetOrders($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('created', 'updated', 'deliverydate', 'customername', 'deliverytype', 'totalprice', 'status', 'paymentstatus')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Created');
            $filter['dir'] = array('DESC');
        }

        // Видимые
        // if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
        //  $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        // elseif (!isset($filter['flags']['IsVisible']))
        //  $filter['flags']['IsVisible'] = 1;



        if ( isset($filter['flags']['Status']) && $filter['flags']['Status'] != -1 )
            $filter['flags']['Status'] = (int) $filter['flags']['Status'];
        elseif (!isset($filter['flags']['Status']))
            $filter['flags']['Status'] = -1;

        if ( isset($filter['flags']['PaymentStatus']) && $filter['flags']['PaymentStatus'] != -1 )
            $filter['flags']['PaymentStatus'] = (int) $filter['flags']['PaymentStatus'];
        elseif (!isset($filter['flags']['PaymentStatus']))
            $filter['flags']['PaymentStatus'] = -1;

        if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if ( isset($filter['flags']['IsArchive']) && $filter['flags']['IsArchive'] != -1 )
            $filter['flags']['IsArchive'] = (int) $filter['flags']['IsArchive'];
        elseif (!isset($filter['flags']['IsArchive']))
            $filter['flags']['IsArchive'] = -1;

        if ( isset($filter['flags']['Sended']) && (int) $filter['flags']['Sended'] != -1)
            $filter['flags']['Sended'] = (int) $filter['flags']['Sended'];
        else
            $filter['flags']['Sended'] = -1;


        if ( !Data::Is_Number($filter['flags']['UserID']) )
            $filter['flags']['UserID'] = 0;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['orders'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['orders'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['orders'].' ';

        $where = array();

        // if ( $filter['flags']['IsVisible'] != -1 )
        //  $where[] = ' '.$this->_tables['orders'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['Status'] != -1 )
            $where[] = ' '.$this->_tables['orders'].'.Status = '.$filter['flags']['Status'];

        if ( $filter['flags']['IsArchive'] != -1 )
            $where[] = ' '.$this->_tables['orders'].'.IsArchive = '.$filter['flags']['IsArchive'];

        if ( $filter['flags']['PaymentStatus'] != -1 )
            $where[] = ' '.$this->_tables['orders'].'.PaymentStatus = '.$filter['flags']['PaymentStatus'];

        if ( $filter['flags']['CatalogID'] != -1 )
            $where[] = ' '.$this->_tables['orders'].'.CatalogID = '.$filter['flags']['CatalogID'];


        if ( isset($filter['flags']['Created_from']) && $temp = strtotime($filter['flags']['Created_from']) )
            $where[] = ' Created >= '. $temp;
        if ( isset($filter['flags']['Created_to']) && $temp = strtotime($filter['flags']['Created_to']) )
            $where[] = ' Created <= '. $temp;
        if ( isset($filter['flags']['DeliveryDate_from']) && $temp = strtotime($filter['flags']['DeliveryDate_from']) )
            $where[] = ' DeliveryDate >= '. $temp;
        if ( isset($filter['flags']['DeliveryDate_to']) && $temp = strtotime($filter['flags']['DeliveryDate_to']) )
            $where[] = ' DeliveryDate <= '. $temp;

        if(isset($filter['flags']['DeliveryDate']))
            $where[] = ' FROM_UNIXTIME('.$this->_tables['orders'].'.DeliveryDate , "%d.%m.%Y") = "'.$filter['flags']['DeliveryDate'].'"';

        if ( $filter['flags']['Sended'] != -1 )
            $where[] = ' '.$this->_tables['orders'].'.Sended = '.$filter['flags']['Sended'];



        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['orders'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['orders'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['orders'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo $sql;

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        $ids = array();
        while ($row = $res->fetch_assoc())
        {
            $id = $row['OrderID'];
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_orders[$id]) )
                    $row = $this->_orders[$id];
                else
                    $row = $this->_orderObject($row);
            }
            $result[$id] = $row;
        }

        if (isset($filter['flags']['with']) && is_array($filter['flags']['with']) && sizeof($filter['flags']['with']) > 0) {
            $ids = array_keys($result);
            $params = array(
                'ids' => $ids,
            );

            if ($filter['flags']['objects'] === true) {
                $params['CatalogID'] = $result[$id]->CatalogID;
                $params['OrderID'] = $result[$id]->OrderID;
            } else {
                $params['CatalogID'] = $result[$id]['CatalogID'];
                $params['OrderID'] = $result[$id]['OrderID'];
            }

            foreach ($filter['flags']['with'] as $with) {
                $getMethod = 'Get'.$with.'ByIds';
                $loadMethod = 'load'.$with;
                if (method_exists($this, $getMethod)) {
                    $data = call_user_func_array([$this, $getMethod], array($params));
                }

                foreach ($ids as $id) {
                    if ($filter['flags']['objects'] === true) {
                        if (method_exists($result[$id], $loadMethod))
                            call_user_func_array([$result[$id], $loadMethod], array($data[$id]));
                    } else {
                        $result[$id][$with] = $data['ProductID'];
                    }
                }
            }
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function GetOrderRefsByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']))
            return null;

        if (empty($filter['CatalogID']) || $filter['CatalogID'] <= 0)
            return null;

        $sql = 'SELECT * FROM '.$this->_tables['order_refs'];
        $sql .= ' WHERE `OrderID` IN ('.implode(",",$filter['ids']).')';

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows)
            return null;

        $result = array();
        $pids = array();
        while ($row = $res->fetch_assoc())
        {
            $result[$row['OrderID']]['refs'][] = $row;
            $pids[] = $row['ProductID'];
        }

        $filter = array(
            'flags' => array(
                'filtered' => $pids,
                'CatalogID' => $filter['CatalogID'],
                'IsVisible' => -1,
                'with' => array('ProductPhotos', 'Elements'),
                'objects' => true,
            ),
        );

        $products = $this->GetProducts($filter);

        $orderRefs = array();
        foreach ($result as $orderid => $refs) {
            foreach ($refs['refs'] as $ref) {
                $ref['RealProduct'] = $products[$ref['ProductID']];
                $orderRefs[$orderid][] = $ref;
            }
        }

        return $orderRefs;
    }

    /****** End orders *******/

    /****** Categories *******/

    public function AddCategory(array $info)
    {
        unset($info['categoryid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['category'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveCategory($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $filter = array(
            'flags' => array(
                'objects' => true,
                'TypeID' => $id,
            ),
            'calc' => true,
        );

        list(, $count) = $this->GetProducts($filter);
        if($count > 0)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['category'].' WHERE CategoryID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Category_'.$id);

            unset($this->_categories[$id]);
            return true;
        }

        return false;
    }

    public function UpdateCategory(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['categoryid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['category'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE CategoryID = '.$info['categoryid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Category_'.$info['categoryid']);

            return true;
        }

        return false;
    }

    public function GetCategory($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_categories[$id]))
            return $this->_categories[$id];

        $info = false;

        $cacheid = 'Category_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['category'].' WHERE CategoryID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_CategoryObject($info);
    }

    public function GetCategories($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Title', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Name');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;

        if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['category'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['category'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['category'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['category'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['category'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['category'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['CatalogID'] != -1 )
            $where[] = ' '.$this->_tables['category'].'.CatalogID = '.$filter['flags']['CatalogID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['category'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['category'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['category'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['CategoryID'];
                if ( isset($this->_categories[$id]) )
                    $row = $this->_categories[$id];
                else
                    $row = $this->_CategoryObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** End category *******/

    /****** RoseLen *******/

    public function AddLen(array $info)
    {

        unset($info['lenid']);
        if ( !sizeof($info) )
            return false;
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['rose_len'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('rose_len_'.$info['productid']);
            return $this->_db->insert_id;
        }

        return false;
    }

    public function RemoveLen($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $len = $this->GetLen($id);
        if($len === null)
            return false;

        $sql = 'DELETE FROM '.$this->_tables['rose_len'].' WHERE LenID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Len_'.$id);
            $cache->Remove('rose_len_'.$len->categoryid);

            unset($this->_lens[$id]);
            return true;
        }

        return false;
    }

    public function UpdateLen(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['lenid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['rose_len'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE LenID = '.$info['lenid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Len_'.$info['lenid']);
            $cache->Remove('rose_len_'.$info['productid']);

            return true;
        }

        return false;
    }

    public function GetLen($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_lens[$id]))
            return $this->_lens[$id];

        $info = false;

        $cacheid = 'Len_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['rose_len'].' WHERE LenID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_LenObject($info);
    }

    public function GetLens($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Len', 'Ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Len');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = 1;

        if ( isset($filter['flags']['ProductID']) && $filter['flags']['ProductID'] != -1 )
            $filter['flags']['ProductID'] = (int) $filter['flags']['ProductID'];
        elseif (!isset($filter['flags']['ProductID']))
            $filter['flags']['ProductID'] = 1;

        if ( isset($filter['flags']['TypeID']) && $filter['flags']['TypeID'] != -1 )
            $filter['flags']['TypeID'] = (int) $filter['flags']['TypeID'];
        elseif (!isset($filter['flags']['TypeID']))
            $filter['flags']['TypeID'] = -1;

        if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if ( isset($filter['flags']['CategoryID']) && $filter['flags']['CategoryID'] != -1 )
            $filter['flags']['CategoryID'] = (int) $filter['flags']['CategoryID'];
        elseif (!isset($filter['flags']['CategoryID']))
            $filter['flags']['CategoryID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['rose_len'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['rose_len'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['rose_len'].' ';

        $where = array();


        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['rose_len'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['rose_len'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['rose_len'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['TypeID'] != -1 )
            $where[] = ' '.$this->_tables['rose_len'].'.CategoryID = '.$filter['flags']['TypeID'];

        if ( $filter['flags']['CategoryID'] != -1 )
            $where[] = ' '.$this->_tables['rose_len'].'.CategoryID = '.$filter['flags']['CategoryID'];

        if ( $filter['flags']['TypeID'] != -1 )
            $where[] = ' '.$this->_tables['rose_len'].'.CategoryID = '.$filter['flags']['TypeID'];

        if ( $filter['flags']['ProductID'] != -1 )
            $where[] = ' '.$this->_tables['rose_len'].'.ProductID = '.$filter['flags']['ProductID'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['rose_len'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['rose_len'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['rose_len'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo ":".$sql;
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_lens[$row['LenID']]) )
                    $row = $this->_lens[$row['LenID']];
                else
                    $row = $this->_LenObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** End lens *******/

        /****** Additions *******/

    public function AddAddition(array $info)
    {
        unset($info['additionid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['addition'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveAddition($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['addition'].' WHERE AdditionID = '.$id;
        // echo ":".$sql; exit;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Addition_'.$id);

            unset($this->_additions[$id]);
            return true;
        }

        return false;
    }

    public function UpdateAddition(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['additionid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['addition'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE AdditionID = '.$info['additionid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Addition_'.$info['additionid']);

            return true;
        }

        return false;
    }

    public function GetAddition($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_additions[$id]))
            return $this->_additions[$id];

        $info = false;

        $cacheid = 'Addition_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['addition'].' WHERE AdditionID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_AdditionObject($info);
    }

    public function GetAdditions($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Name', 'Ord', 'article', 'name', 'isvisible', 'ord')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Name');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['Type']) && $filter['flags']['Type'] != -1 )
            $filter['flags']['Type'] = (int) $filter['flags']['Type'];
        elseif (!isset($filter['flags']['Type']))
            $filter['flags']['Type'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['addition'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['addition'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['addition'].' ';

        if ($filter['flags']['all'] === true)
            $areaJoin = ' LEFT JOIN ';
        else
            $areaJoin = ' INNER JOIN ';

        $sql .= $areaJoin.$this->_tables['addition_refs'];
        $sql .= ' ON '.$this->_tables['addition'].'.AdditionID = '.$this->_tables['addition_refs'].'.AdditionID';

        if ( $filter['flags']['CatalogID'] != -1 && $filter['flags']['all'] === true )
            $sql .= ' AND '.$this->_tables['addition_refs'].'.SectionID = '.$filter['flags']['CatalogID'];

        $where = array();

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['addition'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['addition'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['addition_refs'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['addition'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['addition'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( $filter['flags']['Type'] != -1)
            $where[] .= ' '.$this->_tables['addition'].'.Type = '.$filter['flags']['Type'];

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['addition'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';


            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
            {
                if(in_array(strtolower($v), ['ord', 'isvisible',]))
                    $sqlo[] = ' '.$this->_tables['addition_refs'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
                else
                    $sqlo[] = ' '.$this->_tables['addition'].'.`'.$filter['field'][$k].'` '.$filter['dir'][$k];
            }
            // foreach( $filter['field'] as $k => $v )
            //     $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo ":".$sql;
        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }
        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                if ( isset($this->_additions[$row['AdditionID']]) )
                    $row = $this->_additions[$row['AdditionID']];
                else
                    $row = $this->_AdditionObject($row);
            }
            $result[] = $row;
        }

        if (isset($filter['flags']['with']) && is_array($filter['flags']['with']) && sizeof($filter['flags']['with']) > 0) {
            $ids = array_keys($result);
            $params = array(
                array(
                    'CatalogID' => $filter['flags']['CatalogID'],
                    'ids' => $ids,
                ),
            );

            foreach ($filter['flags']['with'] as $with) {
                $getMethod = 'Get'.$with.'ByIds';
                $loadMethod = 'load'.$with;

                if (method_exists($this, $getMethod)) {
                    $data = call_user_func_array([$this, $getMethod], $params);
                }

                foreach ($ids as $id) {
                    if ($filter['flags']['objects'] === true) {
                        if (method_exists($result[$id], $loadMethod))
                            call_user_func_array([$result[$id], $loadMethod], array($data[$id]));
                    } else {
                        $result[$id][$with] = $data['AdditionID'];
                    }
                }
            }
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    public function IsAdditionAreaRefExist($additionid, $sectionid)
    {
        if ( !Data::Is_Number($additionid) || !Data::Is_Number($sectionid) )
            return null;

        if ($additionid < 0 || $sectionid < 0)
            return null;

        $sql = 'SELECT count(*) FROM '.$this->_tables['addition_refs'];
        $sql .= ' WHERE AdditionID = '.$additionid;
        $sql .= ' AND sectionID = '.$sectionid;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $result = array();

        $info = $res->fetch_assoc();
        $count = intval($info['count(*)']);

        if ($count > 0)
        {
            return true;
        }

        return false;
    }

    /**
    * @return bool
    */
    public function UpdateAdditionAreaRef(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) )
            return false;

        if ($this->IsAdditionAreaRefExist($info['additionid'], $info['sectionid'])) {
            return $this->_UpdateAdditionRef($info);
        } else {
            return $this->_AddAdditionRef($info);
        }
    }

    /**
    * @return id of added reference or false
    */
    private function _AddAdditionRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT IGNORE INTO '.$this->_tables['addition_refs'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return bool shows if entry was updated or not
    */
    private function _UpdateAdditionRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['addition_refs'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE AdditionID = '.$info['additionid'];
        $sql .= ' AND SectionID = '.$info['sectionid'];

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function RemoveAdditionRefs($additionid)
    {
        $additionid = intval($additionid);
        if ( !Data::Is_Number($additionid) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['refs'].' WHERE AdditionID = '.$additionid;

        return $this->_db->query($sql);
    }

    public function GetAdditionAreaRefsByIds($filter)
    {
        if (empty($filter['ids']) || !is_array($filter['ids']))
            return null;

        if (empty($filter['CatalogID']) || $filter['CatalogID'] <= 0)
            return null;

        $default = array(
            'IsVisible' => 0,
            'Ord' => 0,
        );

        $sql = 'SELECT * FROM '.$this->_tables['addition_refs'];
        $sql .= ' WHERE `AdditionID` IN ('.implode(",",$filter['ids']).')';
        $sql .= ' AND `SectionID` = '.intval($filter['CatalogID']);

        $isEmpty = false;
        if ( false === ($res = $this->_db->query($sql)))
            $isEmpty = true;

        if (!$res->num_rows)
            $isEmpty = true;

        $result = array();
        if (!$isEmpty) {
            while ($row = $res->fetch_assoc()) {
                $result[$row['AdditionID']] = $row;
            }
        }

        $refs = array();
        foreach ($filter['ids'] as $id) {
            $refs[$id] = isset($result[$id]) ? $result[$id] : $default;
        }

        return $refs;
    }

    /****** End addition *******/

    // ==========================
    public function IsMemberAreaRefExist($memberid, $sectionid)
    {
        if ( !Data::Is_Number($memberid) || !Data::Is_Number($sectionid) )
            return null;

        if ($memberid < 0 || $sectionid < 0)
            return null;

        $sql = 'SELECT count(*) FROM '.$this->_tables['compositions_refs'];
        $sql .= ' WHERE MemberID = '.$memberid;
        $sql .= ' AND sectionID = '.$sectionid;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $result = array();

        $info = $res->fetch_assoc();
        $count = intval($info['count(*)']);

        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
    * @return bool
    */
    public function UpdateMemberAreaRef(array $info)
    {
        $info = array_change_key_case($info, CASE_LOWER);

        if ( !sizeof($info) )
            return false;

        if ($this->IsMemberAreaRefExist($info['memberid'], $info['sectionid'])) {
            return $this->_UpdateMemberRef($info);
        } else {
            return $this->_AddMemberRef($info);
        }
    }

    /**
    * @return id of added reference or false
    */
    private function _AddMemberRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT IGNORE INTO '.$this->_tables['compositions_refs'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    /**
    * @return bool shows if entry was updated or not
    */
    private function _UpdateMemberRef(array $info)
    {
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['compositions_refs'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE MemberID = '.$info['memberid'];
        $sql .= ' AND SectionID = '.$info['sectionid'];

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function RemoveMemberRefs($memberid)
    {
        $memberid = intval($memberid);
        if ( !Data::Is_Number($memberid) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['refs'].' WHERE MemberID = '.$memberid;

        return $this->_db->query($sql);
    }

    public function GetMemberAreaRefsByIds($filter)
    {

        if (empty($filter['ids']) || !is_array($filter['ids']))
            return null;

        if (empty($filter['CatalogID']) || $filter['CatalogID'] <= 0)
            return null;

        $default = array(
            'IsVisible' => 0,
            'Ord' => 0,
        );

        $sql = 'SELECT * FROM '.$this->_tables['compositions_refs'];
        $sql .= ' WHERE `MemberID` IN ('.implode(",",$filter['ids']).')';
        $sql .= ' AND `SectionID` = '.intval($filter['CatalogID']);

        $isEmpty = false;
        if ( false === ($res = $this->_db->query($sql)))
            $isEmpty = true;

        if (!$res->num_rows)
            $isEmpty = true;

        $result = array();
        if (!$isEmpty) {
            while ($row = $res->fetch_assoc())
            {
                $result[$row['MemberID']] = $row;
            }
        }

        $refs = array();
        foreach ($filter['ids'] as $id) {
            $refs[$id] = isset($result[$id]) ? $result[$id] : $default;
        }

        return $refs;
    }

    /****** End memeber area *******/


    /***** Cart *****/

    public function GetCart()
    {
        if (!empty($this->_cart))
            return $this->_cart;

        $catalogID = App::$City->CatalogId;

        $sql = "SELECT ".$this->_tables['cart'].".* FROM ".$this->_tables['cart'];
        $sql .= " WHERE CartCode = '".$this->CartCode."'";
        $sql .= " AND CatalogID = ".$catalogID;

        if( false === ($res = $this->_db->query($sql)) || !$res->num_rows) {
            return [
                'items' => [],
                'sum' => [
                    'total_count' => 0,
                    'total_price' => 0,
                ]
            ];
        }

        $cart = [];
        $total_price = 0;
        $total_count = 0;
        $add_price = 0;
        while ($row = $res->fetch_assoc()) {
            $item_price = 0;
            $bouquet_price = 0;
            $product = $this->GetProduct($row['ProductID']);
            if($product === null)
                continue;

            // if($product->id == 129) {
            //     $type = $this->GetType($row['TypeID']);
            //     print_r($type);
            //     continue;
            // }
            $key = base64_encode($product->ID."_".$row['TypeID']."_".$row['CurrentTime']);

            $kind = $row['Kind'];
            $item_count = $row['Count'];

            $total_count += $item_count;

            // product price
            $arrType = [];
            $params = [];
            $type = null;
            $price = 0;
            if($kind == CatalogMgr::CK_BOUQUET) {
                $type = $this->GetType($row['TypeID']);
                if($type == null)
                    $type = $product->default_type;

                if($type == null)
                    continue;

                $type_price = $type->GetPrice();
                $price = $type_price;

                $arrType = [
                    'id' => $type->id,
                    'name' => $type->name,
                    'price' => $type_price,
                ];
            } elseif($kind == CatalogMgr::CK_FIXED) {
                $type = $product->default_type;
                $price = $type->GetPrice();
            } elseif($kind == CatalogMgr::CK_ROSE) {
                $params = unserialize($row['Params']);
                $price = $product->GetPrice($params['length'], $params['roses_count']);
            } elseif($kind == CatalogMgr::CK_MONO) {
                $type = $product->default_type;
                if($type == null)
                    continue;
                $params = unserialize($row['Params']);

                $price = $type->GetPrice($catalogID, $params['flower_count']);
            }

            if($price == 0) {
                continue;
            }

            $clearPrice = $price * $item_count;

            if($this->hasDiscount($product->GetAreaRefs($catalogID))) {
                $price = $this->getDiscountPrice($price, $product, $catalogID);
            }

            $item_price += $price * $item_count;


            // additions
            $additions = unserialize($row['Additions']);
            // print_r($additions); exit;

            $adds = [];
$addition_price = 0;
            if(count($additions) > 0) {
                $add_price = 0;
                foreach($additions as $additionid => $add_count) {
                    $addition = $this->GetAddition($additionid);

                    if($addition == null) {
                        continue;
                    }

                    // print_r($add_count); exit;

                   // $item_price += $addition->price * $add_count;
                    // $add_price += $addition->ref price * $add_count;

                    $add_price += $addition->price * $add_count;

                    $adds[$addition->id] = [
                        'object' => $addition,
//                        'name' => $addition->name,
//                        'price' => $addition->price,
                        'count' => $add_count,
                    ];
                }

                $addition_price = $add_price;
            }

            $cart[$key]['product']     = $product;
            $cart[$key]['price']       = $price;
            $cart[$key]['item_price']  = $item_price;
            $cart[$key]['count']       = $item_count;
            $cart[$key]['additions']   = $adds;
            $cart[$key]['type']        = $arrType;
            $cart[$key]['params']      = $params;
            $cart[$key]['clear_price'] = $clearPrice;
            $cart[$key]['add_price'] = $addition->price * $add_count;
            $cart[$key]['addition_price'] = $addition_price;
            $total_price              += $item_price + $add_price;
        }

        $result = [
            'cart_code' => $this->CartCode,
            'items' => $cart,
            'sum' => [
                'total_count' => intval($total_count),
                'total_price' => intval($total_price),
            ]
        ];

        $this->_cart = $result;
        return $this->_cart;
    }

    public function changeTryingCounter($code, $isReset = true)
    {
        $sql = 'UPDATE ' . $this->_tables['cart_trying'] .' SET Count = ';
        $sql .= $isReset ? 0 : 'Count + 1';
        $sql .= ', UpdatedAt = ' . time();
        $sql .= ' WHERE CartCode = \''. $code . '\'';
        return $this->_db->query($sql);
    }

    public function getTrying($code)
    {
        $sql = 'SELECT * FROM ' .$this->_tables['cart_trying'] . ' WHERE CartCode = \'' . $code . '\'';
        if (!$res = $this->_db->query($sql) || !$res->num_rows) {
            return false;
        }

        $res = $this->_db->query($sql);
        if ($res && $res->num_rows) {
            return $res->fetch_assoc();
        }

        $time = time();
        $sql = 'INSERT INTO ' . $this->_tables['cart_trying'];
        $sql .= '(CartCode, Count, UpdatedAt) VALUES (\'' . $code . '\', 0, ' . $time . ')';
        $this->_db->query($sql);
        return ['UpdatedAt' => $time, 'Count' => 0];
    }

    // public function GetCart()
    // {
    //     if (!empty($this->_cart))
    //         return $this->_cart;

    //     $catalogID = App::$City->CatalogId;

    //     $sql = "SELECT ".$this->_tables['cart'].".* FROM ".$this->_tables['cart'];
    //     $sql .= " WHERE CartCode = '".$this->CartCode."'";
    //     $sql .= " AND CatalogID = ".$catalogID;

    //     if ( false === ($res = $this->_db->query($sql)))
    //         return null;

    //     if (!$res->num_rows)
    //         return null;

    //     $counts = array();
    //     $ids = array();
    //     $pids = array();
    //     while ($row = $res->fetch_assoc())
    //     {
    //         $ids[] = $row['TypeID'];
    //         $pids[$row['ProductID']] = $row['ProductID'];
    //         $counts[$row['TypeID']] = $row['Count'];
    //     }

    //     $filter = array(
    //         'flags' => array(
    //             'filtered' => $pids,
    //             'CatalogID' => $catalogID,
    //             'IsVisible' => 1,
    //             'IsAvailable' => 1,
    //             'with' => array('AreaRefs', 'ProductPhotos', 'Types'),
    //             'objects' => true,
    //         ),
    //     );

    //     $products = $this->GetProducts($filter);

    //     $totalPrice = 0;
    //     $totalCount = 0;
    //     $productsCart = array();
    //     foreach ($products as $product) {
    //         foreach ($product->types as $type) {
    //             if (!in_array($type->ID, $ids))
    //                 continue;

    //             $totalPrice += $type->price * $counts[$type->ID];
    //             $totalCount += $counts[$type->ID];
    //             $productsCart[] = array(
    //                 'product' => $product,
    //                 'count' => $counts[$type->ID],
    //                 'price' => $product->price * $counts[$product->ID],
    //             );
    //         }
    //     }

    //     $cart = array(
    //         'products' => $productsCart,
    //         'total_count' => $totalCount,
    //         'total_price' => $totalPrice,
    //     );

    //     $this->_cart = $cart;
    //     return $this->_cart;
    // }

    /***** End cart *****/

    private function RecursiveAddSlashes($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value))
                    $value = $this->RecursiveAddSlashes($value);
                else
                    $data[$key] = addslashes($value);
            }

            return $data;
        }

        return array();
    }

    public function GetSettings($nameid)
    {
        $sql = "SELECT * FROM ".$this->_tables['settings'];
        $sql.= " WHERE nameid='".addslashes($nameid)."'";
        $sql.= " LIMIT 1";

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return array();

        $settings = $res->fetch_assoc();
        $settings = unserialize(($settings['fields']));
        return $settings;
    }

    public function UpdateSettings($nameid, $fields)
    {
        $fields = serialize($this->RecursiveAddSlashes($fields));

        $sql = "UPDATE ".$this->_tables['settings']." SET";
        $sql.= " fields='".$fields."'";
        $sql.= " WHERE nameid='".addslashes($nameid)."'";

        if ( false !== $this->_db->query($sql) )
            return true;

        return false;
    }

    public function GetSectionSettings($type_id)
    {
        $type_id = intval($type_id);

        if ($type_id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['section_settings'];
        $sql.= " WHERE TypeID=".$type_id;
        $sql.= " LIMIT 1";

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return false;

        $settings = $res->fetch_assoc();
        $settings = unserialize(($settings['Fields']));
        return $settings;
    }

    public function UpdateSectionSettings($type_id, $fields)
    {
        $type_id = intval($type_id);

        if ($type_id <= 0)
            return false;

        $exist = false;

        $sql = "SELECT * FROM ".$this->_tables['section_settings'];
        $sql.= " WHERE TypeID=".$type_id;
        $sql.= " LIMIT 1";

        $res = $this->_db->query($sql);

        if ($res === null)
            return false;

        if ($res->num_rows > 0)
            $exist = true;

        $fields = serialize(($this->RecursiveAddSlashes($fields)));

        if ($exist) {

            $sql = "UPDATE ".$this->_tables['section_settings']." SET";
            $sql.= " Fields='".$fields."'";
            $sql.= " WHERE TypeID=".$type_id;

            if ( false !== $this->_db->query($sql) )
                return true;
        } else {

            $sql = "INSERT INTO ".$this->_tables['section_settings']." SET";
            $sql .= " TypeID=".$type_id;
            $sql .= ", Fields='".$fields."'";

            if ( false !== $this->_db->query($sql) )
                return $this->_db->insert_id;
        }

        return false;
    }

    public function GetCatalogRefsByCatalogID($id)
    {
        $id = intval($id);

        if ($id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['refs'];
        $sql.= " WHERE SectionID=".$id;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row;
        }

        return $result;
    }

    public function GetCatalogDecorByCatalogID($id)
    {
        $id = intval($id);

        if ($id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['decor'];
        $sql.= " WHERE SectionID=".$id;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row;
        }

        return $result;
    }

    public function GetCatalogTypesByCatalogID($id)
    {
        $id = intval($id);

        if ($id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['typeRefs'];
        $sql.= " WHERE SectionID=".$id;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0) {
            return false;
        }

        $result = array();
        while ($row = $res->fetch_assoc()) {
            $result[] = $row;
        }

        return $result;
    }

    public function GetCatalogCompositionByCatalogID($id)
    {
        $id = intval($id);

        if ($id <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['elements'];
        $sql.= " WHERE SectionID=".$id;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0)
            return false;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row;
        }

        return $result;
    }

    public function CopyCatalogRefs($from, $to, $isRewrite = 0)
    {
        $from = intval($from);
        $to = intval($to);

        if ($from <= 0 || $to <= 0)
            return false;

        $refs = $this->GetCatalogRefsByCatalogID($from);

        if (empty($refs))
            return false;

        foreach ($refs as $ref) {
            $ref['SectionID'] = $to;

            $fields = array();
            foreach( $ref as $k => $v)
                $fields[] = "`$k` = '".addslashes($v)."'";

            $sql = "INSERT IGNORE INTO ".$this->_tables['refs']." SET " . implode(", ", $fields);

            if ($isRewrite > 0)
                $sql .= " ON DUPLICATE KEY UPDATE " . implode(", ", $fields);

            $this->_db->query($sql);
        }

        return true;
    }

    public function RecachePrices($from, $sectionid, $clear = 0)
    {
        ini_set('max_execution_time', 1000);
        if($clear > 0) {
            $sql = " DELETE FROM ".$this->_tables['typeRefs']." WHERE SectionID = ".$sectionid;
            $this->_db->query($sql);
        }

        $products = $this->GetProductsByCatalogID($from);
        // $chunks = array_chunk($productsList, 50);
        // // 10

        // $index = 9;
        // $products = $chunks[$index];

        foreach($products as $product) {
            $product->CachePrice($sectionid);
        }

        echo "OK ". $index; exit;

        return true;
    }

    private function GetProductsByCatalogID($sectionid)
    {
        $sql = "SELECT ProductID";
        $sql .= " FROM ".$this->_tables['types'];
        $sql .= " INNER JOIN ".$this->_tables['typeRefs']." ON ".$this->_tables['typeRefs'].".TypeId = ".$this->_tables['types'].".TypeID";
        $sql .= " WHERE ".$this->_tables['typeRefs'].".SectionID = ".$sectionid;

        $res = $this->_db->query($sql);
        if (!$res || !$res->num_rows) {
            return false;
        }

        $products = [];
        while ($row = $res->fetch_assoc()) {
            $product = $this->GetProduct($row['ProductID']);
            if($product !== null) {
                $products[] = $product;
            }
        }

        return $products;
    }

    public function CopyAdditionsRefs($from, $to, $isClear = 0)
    {
        ini_set('max_execution_time', 100);
        $from = intval($from);
        $to = intval($to);

        if ($from <= 0 || $to <= 0)
            return false;

        if ($isClear > 0) {
            $sql = " DELETE FROM ".$this->_tables['addition_refs']." WHERE SectionID = ".$to;
            $this->_db->query($sql);
        }

        $adds = $this->GetAddsAreaByCatalogID($from);
        foreach($adds as $add) {
            $add['SectionID'] = $to;

            $fields = array();
            foreach($add as $k => $v)
                $fields[] = "`$k` = '".addslashes($v)."'";

            $sql = "INSERT INTO ".$this->_tables['addition_refs']." SET " . implode(", ", $fields);

            $this->_db->query($sql);
        }

        return true;

    }

    private function GetAddsAreaByCatalogID($sectionid)
    {
         $sectionid = intval($sectionid);

        if ($sectionid <= 0)
            return false;

        $sql = "SELECT * FROM ".$this->_tables['addition_refs'];
        $sql.= " WHERE SectionID=".$sectionid;

        $res = $this->_db->query($sql);
        if ($res === null || $res->num_rows == 0) {
            return false;
        }

        $result = array();
        while ($row = $res->fetch_assoc()) {
            $result[] = $row;
        }

        return $result;
    }

    public function CopyCatalogTypes($from, $to, $isClear = 0)
    {
        $from = intval($from);
        $to = intval($to);

        if ($from <= 0 || $to <= 0)
            return false;

        if ($isClear > 0) {
            $sql = " DELETE FROM ".$this->_tables['typeRefs']." WHERE SectionID = ".$to;
            $this->_db->query($sql);
        }

        $types = $this->GetCatalogTypesByCatalogID($from);

        foreach($types as $type) {
            $type['SectionID'] = $to;

            $fields = array();
            foreach($type as $k => $v)
                $fields[] = "`$k` = '".addslashes($v)."'";

            $sql = "INSERT INTO ".$this->_tables['typeRefs']." SET " . implode(", ", $fields);

            $this->_db->query($sql);
        }

        return true;
    }


    public function CopyCatalogDecor($from, $to, $isClear = 0)
    {
        $from = intval($from);
        $to = intval($to);

        if ($from <= 0 || $to <= 0)
            return false;

        $decors = $this->GetCatalogDecorByCatalogID($from);

        if (empty($decors))
            return false;

        if ($isClear > 0) {
            $sql = " DELETE FROM ".$this->_tables['decor']." WHERE SectionID = ".$to;
            $this->_db->query($sql);
        }

        foreach ($decors as $decor) {
            $decor['SectionID'] = $to;
            unset($decor['DecorID']);

            $fields = array();
            foreach($decor as $k => $v)
                $fields[] = "`$k` = '".addslashes($v)."'";

            $sql = "INSERT INTO ".$this->_tables['decor']." SET " . implode(", ", $fields);

            $this->_db->query($sql);
        }

        return true;
    }

    public function CopyCatalogComposition($from, $to, $isClear = 0)
    {
        $from = intval($from);
        $to = intval($to);

        if ($from <= 0 || $to <= 0)
            return false;

        $compositions = $this->GetCatalogCompositionByCatalogID($from);

        if (empty($compositions))
            return false;

        if ($isClear > 0) {
            $sql = " DELETE FROM ".$this->_tables['elements']." WHERE SectionID = ".$to;
            $this->_db->query($sql);
        }

        foreach ($compositions as $composition) {
            $composition['SectionID'] = $to;

            $fields = array();
            foreach($composition as $k => $v)
                $fields[] = "`$k` = '".addslashes($v)."'";

            $sql = "INSERT INTO ".$this->_tables['elements']." SET " . implode(", ", $fields);

            $this->_db->query($sql);
        }

        return true;
    }


    /**
     * возвращает массив, состоящий из минимальной и максимальной цены видимой продукции
     *
     * @param integer $catalogId
     * @return array
     */
    public function getTotalRange($catalogId)
    {
        $sql =  "SELECT FLOOR(MIN(MinPrice) / 100) * 100 as min, CEILING(MAX(MaxPrice) / 100) * 100 as max " .
                "FROM " . $this->_tables['cache_prices'] . " AS c " .
                "LEFT JOIN " . $this->_tables['refs'] . " AS a ON a.ProductID = c.ProductID " .
                "WHERE a.SectionID = $catalogId AND a.IsVisible = 1 AND a.IsAvailable = 1 AND MinPrice > 0 AND c.TypeID IN(1, 3, 10, 11, 12)";

        $res = $this->_db->query($sql);
        if ($res === false || !$res->num_rows)
            return [
                'min' => 500,
                'max' => 15000,
            ];

        return $res->fetch_assoc();
    }

    public function getPriceRange($productId, $catalogId)
    {
        $sql = "SELECT MinPrice, MaxPrice FROM " . $this->_tables['cache_prices'];
        $sql .= " WHERE ProductID = " . $productId . " AND CatalogID = " . $catalogId;
        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows)
            return null;

        return $res->fetch_assoc();
    }

    public function updateParentCachePrice($productId, $catalogId)
    {
        $sql = "SELECT c.MinPrice, c.MaxPrice FROM " . $this->_tables['products'] . " AS p";
        $sql .= " LEFT JOIN " . $this->_tables['refs'] . " AS a ON p.ProductID = a.ProductID AND a.SectionID = " . $catalogId;
        $sql .= " LEFT JOIN " . $this->_tables['cache_prices'] . " AS c ON c.ProductID = p.ProductID AND c.CatalogID = " . $catalogId;
        $sql .= " WHERE a.IsAvailable = 1 AND p.ParentId = " . $productId;

        $res = $this->_db->query($sql);

        if (!$res || !$res->num_rows) {
            $min = $max = 0;
        } else {
            while ($row = $res->fetch_assoc())
            {
                $min[] = $row['MinPrice'];
                $max[] = $row['MaxPrice'];
            }

            $min = min($min);
            $max = max($max);
        }

        $sql = "SELECT * FROM " . $this->_tables['cache_prices'] . " WHERE ProductID = " . $productId . " AND CatalogID = " . $catalogId;
        $res = $this->_db->query($sql);
        if (!$res || !$res->num_rows) {
            $fields = [
                $productId,
                self::CK_FOLDER_ID,
                $catalogId,
                $min,
                $max
            ];
            $sql = "INSERT INTO " . $this->_tables['cache_prices'] . " VALUES (" . implode(',', $fields) . ")";
        } else {
            $sql = "UPDATE " . $this->_tables['cache_prices'] . " SET";
            $sql .= " MinPrice = " . $min;
            $sql .= ",MaxPrice = " . $max;
            $sql .= " WHERE ProductID = " . $productId;
        }

        return $this->_db->query($sql);
    }

    public function SlicePrice($products, $from, $to)
    {
        if($from == 0 && $to == 0)
            return $products;

        $pids = [];
        foreach($products as $product) {
            $pids[] = $product->id;
        }

        $sql  = "SELECT c.*, p.ParentId FROM " . $this->_tables['cache_prices'] . " AS c";
        $sql .= " LEFT JOIN " . $this->_tables['products'] . " AS p ON p.ProductID = c.ProductID";


        if($from > 0 && $to > 0) {
            $sql .= " WHERE (c.MinPrice BETWEEN " . intval($from) . " AND " . intval($to);
            $sql .= " OR " . intval($from) . " BETWEEN c.MinPrice AND c.MaxPrice)";
        } elseif($from > 0) {
            $sql .= " WHERE c.MinPrice >= ". intval($from);
        } elseif($to > 0) {
            $sql .= " WHERE c.MaxPrice <= ". intval($to);
        }

        $sql .= " AND c.ProductID in (".implode(', ', $pids).")";
        $sql .= " AND c.CatalogID = ".App::$City->CatalogId;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows)
            return null;

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            $result[] = $row['ParentId'] ?: $row['ProductID'];
        }

        return array_unique($result);
    }

    public function UpdateCart($options)
    {
        $this->_cart = null;

        $productid = $options['productid'];
        $currenttime = $options['currenttime'];
        $curtypeid = $options['curtypeid'];

        $count = intval($options['count']);
        $typeid = intval($options['typeid']);

        $count = $count > 0 ? $count : 1;

       if(count($options['additions']) > 0)
           $additions = serialize($options['additions']);
       else
           $additions = '';

//        if(count($options['params']) > 0)
//            $params = serialize($options['params']);
//        else
//            $params = '';

        $sql  = "UPDATE ".$this->_tables['cart']." SET ";
        $sql .= " Count = ".$count;
        $sql .= ", Updated = NOW()";
        if(isset($options['typeid']))
            $sql .= ", TypeID = ".$typeid;

        if(isset($options['additions']))
            $sql .= ", Additions='".addslashes($additions)."'";

        if(isset($options['params']))
            $sql .= ", Params='".addslashes($params)."'";

        $sql .= " WHERE ProductID = " . $productid;
        $sql .= " AND TypeID = ".$curtypeid;
        $sql .= " AND CurrentTime = '" .$currenttime. "'";
        $sql .= " AND CartCode = '".$this->CartCode."'";

        if($this->_db->query($sql) !== false)
            return true;

        return false;
    }

    public function RemoveFromCart($options)
    {
        $productid = $options['productid'];
        $currenttime = $options['currenttime'];
        $typeid = $options['typeid'];

        $sql  = "DELETE FROM ".$this->_tables['cart'];
        $sql .= " WHERE ProductID = " .$productid;
        $sql .= " AND TypeID = ".intval($typeid);
        $sql .= " AND CurrentTime = '".$currenttime."'";
        $sql .= " AND CartCode = '".$this->CartCode."'";

        if($this->_db->query($sql) !== false)
            return true;

        return false;
    }

    //
    /****** Cards *******/

    public function AddCard(array $info)
    {
        unset($info['cardid']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'INSERT INTO '.$this->_tables['card'].' SET ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveCard($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['card'].' WHERE CardID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('Card_'.$id);

            unset($this->_cards[$id]);
            return true;
        }

        return false;
    }

    public function UpdateCard(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['cardid']) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['card'].' SET ' . implode(', ', $fields);
        $sql .= ' WHERE CardID = '.$info['cardid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('Card_'.$info['cardid']);

            return true;
        }

        return false;
    }

    public function GetCard($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_cards[$id]))
            return $this->_cards[$id];

        $info = false;

        $cacheid = 'Card_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['card'].' WHERE CardID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_CardObject($info);
    }

    public function GetCards($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('Size', 'Price')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('Price');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
            $filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
        elseif (!isset($filter['flags']['IsVisible']))
            $filter['flags']['IsVisible'] = -1;

        if ( isset($filter['flags']['CatalogID']) && $filter['flags']['CatalogID'] != -1 )
            $filter['flags']['CatalogID'] = (int) $filter['flags']['CatalogID'];
        elseif (!isset($filter['flags']['CatalogID']))
            $filter['flags']['CatalogID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['card'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['card'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['card'].' ';

        $where = array();

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['card'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['card'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsVisible'] != -1 )
            $where[] = ' '.$this->_tables['card'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['CatalogID'] != -1 )
            $where[] = ' '.$this->_tables['card'].'.CatalogID = '.$filter['flags']['CatalogID'];


        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['card'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['card'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['card'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo ":".$sql."_<br>";

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['CardID'];
                if ( isset($this->_cards[$id]) )
                    $row = $this->_cards[$id];
                else
                    $row = $this->_CardObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }

    /****** End card *******/

    public function InMode($now='now')
    {
        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');
        $workmode = $config['workmode'];
        $days = $config['days'];

        $today = strtotime($now);

        $weekday = date('w', $today);
        $mode = $workmode[$weekday];

        // if($mode['disable'])
        // {
        //     return false;
        // }

        // if(is_array($days) && count($days) > 0 && (in_array(date('d.m', time()), $days) || in_array(date('j.m', time()), $days)))
        if(is_array($days) && count($days) > 0 && (in_array(date('d.m', $today), $days) || in_array(date('j.m', $today), $days)))
        {
            return false;
        }

        return true;

        $time = date('H:i', $today);

        // ========================
        $prev_weekday =  $weekday - 1;
        if($prev_weekday < 0)
            $prev_weekday = 0;

        $prev_mode = $workmode[$prev_weekday];
        $prev_from = strtotime(date('d.m.Y',  time())." ".$prev_mode['from'].":00");
        $prev_to   = strtotime(date('d.m.Y',  time())." ".$prev_mode['to'].":00");
        $prev_from_range = strtotime(date('d.m.Y', time()." 00:00:00"));
        // ========================
        $from = strtotime(date('d.m.Y', time())." ".$mode['from'].":00");
        $to   = strtotime(date('d.m.Y', time())." 23:59:59");


        $current = time();
        if($prev_from > $prev_to)
        {
            if(($current > $prev_from_range && $current < $prev_to) || ($current > $from && $current < $to))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if($current > $from && $current < $to)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    //  ==========================
    // discount cards

    //
    /****** Discount Cards *******/

    public function AddDiscountCard(array $info)
    {
        unset($info['cardid']);
        unset($info['created']);
        unset($info['updated']);
        if ( !sizeof($info) )
            return false;

        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";


        $created = date('Y-m-d H:i:s');
        $updated = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO '.$this->_tables['discount_cards'].' SET Created="'.$created.'", Updated="'.$updated.'", ' . implode(', ', $fields);

        if ( false !== $this->_db->query($sql) )
            return $this->_db->insert_id;

        return false;
    }

    public function RemoveDiscountCard($id)
    {
        if ( !Data::Is_Number($id) )
            return false;

        $sql = 'DELETE FROM '.$this->_tables['discount_cards'].' WHERE CardID = '.$id;
        if ( false !== $this->_db->query($sql) )
        {
            $cache = $this->getCache();
            $cache->Remove('DiscountCard_'.$id);

            unset($this->_discountcards[$id]);
            return true;
        }

        return false;
    }

    public function UpdateDiscountCard(array $info)
    {
        if ( !sizeof($info) || !Data::Is_Number($info['cardid']) )
            return false;

        unset($info['created']);
        unset($info['updated']);
        $fields = array();
        foreach( $info as $k => $v)
            $fields[] = "`$k` = '".addslashes($v)."'";

        $sql = 'UPDATE '.$this->_tables['discount_cards'].' SET Updated=NOW(), ' . implode(', ', $fields);
        $sql .= ' WHERE CardID = '.$info['cardid'];

        if ( false !== $this->_db->query($sql) ) {
            $cache = $this->getCache();
            $cache->Remove('DiscountCard_'.$info['cardid']);

            return true;
        }

        return false;
    }

    public function GetDiscountCard($id)
    {

        if (!Data::Is_Number($id))
            return null;

        if (isset($this->_discountcards[$id]))
            return $this->_discountcards[$id];

        $info = false;

        $cacheid = 'DiscountCard_'.$id;

        if ($this->_cache !== null)
            $info = $this->_cache->get($cacheid);

        if ($_GET['nocache']>12)
            $info = false;

        if ($info === false)
        {
            $sql = 'SELECT * FROM '.$this->_tables['discount_cards'].' WHERE CardID = '.$id;

            if ( false === ($res = $this->_db->query($sql)))
                return null;

            if (!$res->num_rows )
                return null;

            $info = $res->fetch_assoc();


            if ($this->_cache !== null)
                $this->_cache->set($cacheid, $info, 3600);
        }

        return $this->_DiscountCardObject($info);
    }

    public function GetDiscountCardByCode($code)
    {
        $code = trim($code);
        if (!Data::Is_Number($code))
            return null;

        $sql = 'SELECT * FROM '.$this->_tables['discount_cards'].' WHERE Code = '.$code;

        if ( false === ($res = $this->_db->query($sql)))
            return null;

        if (!$res->num_rows )
            return null;

        $info = $res->fetch_assoc();

        return $this->_DiscountCardObject($info);
    }


    private function debug_string_backtrace() {
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_contents();
        ob_end_clean();

        // Remove first item from backtrace as it's this function which
        // is redundant.
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1);

        // Renumber backtrace items.
        $trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace);

        return $trace;
    }


    private function get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function logElementsDeleting($sql) {

        $out = PHP_EOL.'Запрос: '.$sql;
        $out .= PHP_EOL.'Время: '.date("Y-m-d H:i:s");
        $out .= PHP_EOL."IP: ".$this->get_ip();
        $out .= PHP_EOL.'Backtrace: '.PHP_EOL;
        $out .= $this->debug_string_backtrace();
        $out .= PHP_EOL.'-----------------------------------'.PHP_EOL;

        $file = fopen($_SERVER['DOCUMENT_ROOT'].'/resources/log_delete.txt', 'a');
        fwrite($file, $out);
        fclose($f);
    }


    public function GetDiscountCards($filter)
    {
        global $OBJECTS;
        if ( isset($filter['field']) ) {
            $filter['field'] = (array) $filter['field'];
            $filter['dir'] = (array) $filter['dir'];

            foreach($filter['field'] as $k => $v) {
                if ( !in_array($v, array('CardID', 'code', 'created', 'orderid', 'isactive', 'discount')) )
                    unset($filter['field'][$k], $filter['dir'][$k]);
            }

            foreach($filter['dir'] as $k => $v) {
                $v = strtoupper($v);
                if ( $v != 'ASC' && $v != 'DESC' )
                    $filter['dir'][$k] = 'ASC';
            }

        }

        if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
            $filter['field'] = array('code');
            $filter['dir'] = array('ASC');
        }

        // Видимые
        if ( isset($filter['flags']['IsActive']) && $filter['flags']['IsActive'] != -1 )
            $filter['flags']['IsActive'] = (int) $filter['flags']['IsActive'];
        elseif (!isset($filter['flags']['IsActive']))
            $filter['flags']['IsActive'] = -1;

        if ( isset($filter['flags']['OrderID']) && $filter['flags']['OrderID'] != -1 )
            $filter['flags']['OrderID'] = (int) $filter['flags']['OrderID'];
        elseif (!isset($filter['flags']['OrderID']))
            $filter['flags']['OrderID'] = -1;

        if(!isset($filter['offset']) || !is_numeric($filter['offset']))
            $filter['offset'] = 0;
        if($filter['offset'] < 0) $filter['offset'] = 0;

        if(!isset($filter['limit']) || !is_numeric($filter['limit']))
            $filter['limit'] = 0;

        if ($filter['calc'] === true)
            $sql = 'SELECT SQL_CALC_FOUND_ROWS '.$this->_tables['discount_cards'].'.* ';
        else
            $sql = 'SELECT '.$this->_tables['discount_cards'].'.* ';

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
            $sql.= ', COUNT(*) as GroupingCount ';

        $sql.= ' FROM '.$this->_tables['discount_cards'].' ';

        $where = array();

        if ( !empty($filter['flags']['NameStart']) )
            $where[] = ' '.$this->_tables['discount_cards'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
        else if ( !empty($filter['flags']['NameContains']) )
            $where[] = ' '.$this->_tables['discount_cards'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

        if ( $filter['flags']['IsActive'] != -1 )
            $where[] = ' '.$this->_tables['discount_cards'].'.IsVisible = '.$filter['flags']['IsVisible'];

        if ( $filter['flags']['OrderID'] != -1 )
            $where[] = ' '.$this->_tables['discount_cards'].'.OrderID = '.$filter['flags']['OrderID'];

        if (!empty($filter['flags']['DateFrom']))
            $where[] = ' '.$this->_tables['discount_cards'].'.Created >= "'.$filter['flags']['DateFrom'].' 00:00:01"';


        if (!empty($filter['flags']['DateTo']))
            $where[] = ' '.$this->_tables['discount_cards'].'.Created <= "'.$filter['flags']['DateTo'].' 23:59:59"';

        if (!empty($filter['flags']['CardFrom']))
            $where[] = ' '.$this->_tables['discount_cards'].'.Code >= '.$filter['flags']['CardFrom'];

        if (!empty($filter['flags']['CardTo']))
            $where[] = ' '.$this->_tables['discount_cards'].'.Code <= '.$filter['flags']['CardTo'];

        if (!empty($filter['flags']['OrderIDFrom']))
            $where[] = ' '.$this->_tables['discount_cards'].'.OrderID >= '.$filter['flags']['OrderIDFrom'];

        if (!empty($filter['flags']['OrderIDTo']))
            $where[] = ' '.$this->_tables['discount_cards'].'.OrderID <= '.$filter['flags']['OrderIDTo'];

        if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
            $like = array();
            foreach($filter['filter']['fields'] as $k => $v) {
                if (!isset($filter['filter']['values'][$k]))
                    $like[] = ' '.$this->_tables['discount_cards'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
                else
                    $like[] = ' '.$this->_tables['discount_cards'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
            }

            if ($filter['filter']['cond'])
                $where[] = implode(' AND ', $like);
            else
                $where[] = '('.implode(' OR ', $like).')';
        }

        if ( sizeof($where) )
            $sql .= ' WHERE '.implode(' AND ', $where);

        if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
            $group = array();
            foreach($filter['group']['fields'] as $v) {
                $group[] = ' '.$this->_tables['card'].'.`'.$v.'`';
            }

            $sql .= ' GROUP by '.implode(', ', $group);
        }

        if (isset($filter['having']) && $filter['having'])
            $sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

        $sql.= ' ORDER by ';

            $sqlo = array();
            foreach( $filter['field'] as $k => $v )
                $sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

            $sql .= implode(', ', $sqlo);

        if ( $filter['limit'] ) {
            $sql .= ' LIMIT ';
            if ( $filter['offset'] )
                $sql .= $filter['offset'].', ';

            $sql .= $filter['limit'];
        }

        if($filter['dbg'] == 1)
            echo ":".$sql."_<br>";

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        if ( $filter['calc'] === true )
        {
            $sql = "SELECT FOUND_ROWS()";
            list($count) = $this->_db->query($sql)->fetch_row();
        }

        $result = array();
        while ($row = $res->fetch_assoc())
        {
            if ($filter['flags']['objects'] === true)
            {
                $id = $row['CardID'];
                if ( isset($this->_discountcards[$id]) )
                    $row = $this->_discountcards[$id];
                else
                    $row = $this->_DiscountCardObject($row);
            }
            $result[] = $row;
        }

        if ( $filter['calc'] === true )
            return array($result, $count);

        return $result;
    }


    /****** End card *******/

    // private function _get_last_card()
    // {
    //     $filter = [
    //         'flags' => [
    //             'objects' => true,
    //             'IsVisible' => -1,
    //         ],
    //         'field' => ['CardID'],
    //         'dir' => ['DEAC'],
    //         'limit' => 1,
    //         'calc' => false,
    //         'dbg' => 1,
    //     ];

    //     $cards = $this->GetDiscountCards($filter);
    //     if(count($cards) > 0)

    // }

    private function _get_correct_code($code)
    {
        $digits = preg_split('//', $code, -1, PREG_SPLIT_NO_EMPTY);

        $even = [];
        $odd = [];
        $i = 0;
        foreach($digits as $digit) {
            ++$i;
            if($i % 2 == 0)
                $even[] = $digit;
            else
                $odd[] = $digit;
        }

        $l1 = array_sum($even) * 3;
        $l2 = array_sum($odd);
        $sum = $l1 + $l2;
        $last_dig = $sum % 10;

        $correct_code = $last_dig > 0 ? 10 - ($sum % 10) : $last_dig;

        return $correct_code;
    }

    public function GenerateDiscountCard()
    {

        $data = [
            'IsActive' => 1,
            'Discount' => 5,
        ];
        $discount_card = new DiscountCard($data);
        $discount_card->Update();

        if($discount_card == null) {
            return false;
        }

        $lened_code = str_pad($discount_card->id, 7, "0", STR_PAD_LEFT);
        $raw_code = self::DC_PREFIX.self::DC_DISCOUNT_CODE.$lened_code;

        $correct_code = $this->_get_correct_code($raw_code);

        $code = $raw_code.$correct_code;

        $discount_card->code = $code;
        $discount_card->Update();

        return $discount_card;
        // return $code;
    }

    public function ValidateDiscountCard($code, $strict = false)
    {
        $code = trim($code);
        if(strlen($code) != 13) {
            return false;
        }

        $first_numbers = substr($code, 0, 4);
        if($first_numbers != '9978') {
            return false;
        }

        $orig_correct_code = substr($code, 12, 1);
        $verifiable_code = substr($code, 0, 12);

        if(!is_numeric($orig_correct_code)) {
            return false;
        }

        if(!is_numeric($verifiable_code)) {
            return false;
        }

        $correct_code = $this->_get_correct_code($verifiable_code);

        $type_card = substr($code, 4, 1);

        // выданные сайтом
        if($type_card == 3) {
            $sql = "SELECT * FROM ".$this->_tables['discount_cards'];
            $sql .= " WHERE Code ='".$code."'";

            if ( false === ($res = $this->_db->query($sql)))
                return false;

            if (!$res->num_rows )
                return false;
        }

        if($orig_correct_code == $correct_code) {
            return true;
        }

        return false;
    }

    /**
     * возвращает скидку дисконтной карты в процентах
     *
     * @param [[include\catalog\DiscountCard]] $discountcard
     * @return int
     */
    public function GetDiscountByCard($discountcard)
    {
        // DEPRECATED
        // вычисление скидки по 5й цифре кода
        // изменил тип аргумента:
        // String $discountcard -> DiscountCard $discountcard
        // $bl = BLFactory::GetInstance('system/config');
        // $config = $bl->LoadConfig('module_engine', 'catalog');

        // $discount_code = $config['discount_code'];
        // $code = substr($discountcard->Code, 4, 1);

        // $percent = 0;
        // if(isset($discount_code[$code]))
        //     $percent = $discount_code[$code];

        // return $percent;

        return $discountcard->discount;
    }

    public function getDiscountValue()
    {
    	$bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        return (int) $config['discount_value'];
    }

    public function GetLastOrd($params) {
        if(isset($params['SectionID'])) {
            $params['SectionID'] = intval($params['SectionID']);
        } else
            return -1;

        if(!isset($params['TypeIds']) || !is_array($params['TypeIds']) || empty($params['TypeIds']))
            return -1;

        $sql = 'SELECT MAX(a.Ord) as max FROM '.$this->_tables['refs'].' AS a LEFT JOIN '.$this->_tables['products'].' AS p ON p.ProductID = a.ProductID ';
        $sql .= ' WHERE a.SectionID = '.$params['SectionID'].' AND p.TypeID IN('.implode($params['TypeIds'], ',').')';

        if ( !$res = $this->_db->query($sql))
                return -1;

        if ( !$res->num_rows )
            return -1;

        $info = $res->fetch_assoc();
        return intval($info['max']);
    }

    /**
     * возвращает промежуток времени работы.
     * Сначала происходит поиск запрашиваемой даты в списке со специальным графиком.
     * Если даты нет в списке, возвращается значение графика дня по умолчанию
     * @param string $datetime дата, для которой нужно вернуть график
     * @param boolean $isDelivery график доставки или график работы магазина (самовывоз)
     * @return array ['from', 'to']
     */
    private static function getWorkMode($datetime, $isDelivery = true)
    {
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        $special = $config['special'];
        $dm = date('d.m', strtotime($datetime));
        $specialType = $isDelivery? self::SPECIAL_DELIVERY : self::SPECIAL_STORE;
        foreach ($special as $v) {
            if($v['date'] == $dm && in_array($v['type'], [self::SPECIAL_ALL, $specialType])) {
                return $v;
            }
        }

        $dayOfWeek = date('w', strtotime($datetime));
        $mode = $isDelivery ? 'deliverymode' : 'workmode';
        return $config[$mode][$dayOfWeek];
    }

    // public static function getD

    public static function TimeRangeDelivery($datetime)
    {
        $bl = BLFactory::GetInstance('system/config');
        $config_catalog = $bl->LoadConfig('module_engine', 'catalog');

        $deliveryRange = self::getWorkMode($datetime, true); // данные по времени доставки
        $pickupRange = self::getWorkMode($datetime, false); // режим работы магазина в тот день, на который делают заказ

        $objNow = new DateTime(date('d.m.Y H:', time())."00:00");              // текущее время
        $cur_minutes = date('i', time()); // минуты в текущем часе
        $objDeliveryDate = new DateTime($datetime); // дата доставки, выбранная пользователем
        $formation = $config_catalog['time_delivery']['formation'];          // время необходимо на формирование букета

        // Определение на какой день осуществляется доставка
        $objDeliveryDateDiff = new DateTime($objDeliveryDate->format('d.m.Y'));
        $objNowDiff = new DateTime($objNow->format('d.m.Y'));
        $diff = $objNowDiff->diff($objDeliveryDateDiff);

        // определение разницы между датой доставки и текущим днем
        if($diff->d == 0) {
            // начало доставки
            $objFrom = new DateTime($objNow->format('d.m.Y')." ".$deliveryRange['from']);                      // начало доставки
            $store_start = new DateTime($objNow->format('d.m.Y'." ".$pickupRange['from']));   // открытие магазина

            // если текущее время ДО начала старта доставки
            if($objNow < $objFrom) {
                // до начала работы магазина
                // старт доставки возможен с открытия магазина + время на формирование букета.
                // $n_from = $objFrom->modify("+".$formation." hours");
                // $n_from = $store_start->modify("+".$formation." hours");
                $n_from = clone $store_start;
                $n_from = $n_from->modify("+".$formation." hours");
            } else {
                // во время работы магазина
                // старт доставки возможен с текущего времени + время формирования букета

                // if($objNow->format('i') != '00')
                if($cur_minutes != '00')
                    $formation += 1;

                // $n_from = $objDeliveryDate->modify("+".$formation." hours");
                $n_from = clone $objDeliveryDate;
                $n_from = $n_from->modify("+".$formation." hours");
            }

            // !!!! Протестить этот момент. -- Если заказали до открытия магазина
            // букет будет готов со времени открытия магазина + время на формирование букета
            // если время готовности букета >= начало времени доставки - доставка осуществляется со времени готовности букета
            // если время готовности букета < начала доставки - доставка начинается со стартом доставки
            if($objFrom > $n_from) {
                $n_from = clone $objFrom;
            }

            // echo $n_from->format('d.m.Y H:i:s')."<br>";

            $start_delivery = new DateTime($objNow->format('d.m.Y')." ".$deliveryRange['from']);

            // определение до какого времени осуществлять доставку
            $store_end = new DateTime($objNow->format('d.m.Y')." ".$pickupRange['to']);   // время закрытия магазина
            $delivery_end = new DateTime($objNow->format('d.m.Y')." ".$deliveryRange['to']);   // время окончания работы доставки


            $n_to = $delivery_end;

        } elseif($diff->d == 1) {

            $today_weekday = $objNow->format("w");
            $today_workmode = $config_catalog['workmode'][$today_weekday];

            // если количество минут больше 0, то ко времени формирования прибавляем 1 час, так как необходимо целое количество часов
            // if($objNow->format('i') != '00')
            if($cur_minutes != '00')
                $n_formation = $formation + 1;
            else
                $n_formation = $formation;


            // определение времени, когда закончат формировать букет, если начнут его собирать сейчас
            // определить - успевают ли сделать букет за сегодня

            // $bouquet_finish = $objNow->modify("+".$n_formation." hours"); // время, когда закончат делать букет
            $bouquet_finish = clone $objNow;
            $bouquet_finish = $bouquet_finish->modify("+".$n_formation." hours");
            $store_end = new DateTime($objNow->format('d.m.Y ').$today_workmode['to']); // время, когда закончит работать магазин СЕГОДНЯ

            // echo $bouquet_finish->format('d.m.Y H:i:s')." ".$store_end->format('d.m.Y H:i:s')."<br>";

            // если букет не успевают сделать сегодня до закрытия магазина
            if($bouquet_finish > $store_end) {
                // букет будут делать на следующий день со времени открытия магазиня
                // echo 'не успели. Делают завтра';
                $objFrom = new DateTime($objDeliveryDate->format('d.m.Y')." ".$pickupRange['from']);
                $n_from = $objFrom->modify('+'.$formation." hours");
            } else {
                // букет сделают сегодня, а завтра доставят со старта работы доставки
                $n_from = new DateTime($objDeliveryDate->format('d.m.Y '.$deliveryRange['from']));
            }

            // echo "Букет будет готов в ".$n_from->format('d.m.Y H:i:s')."<br>";

            // Проверить, что к моменту готовности букета, доставка начала работать
            $delivery_start = new DateTime($objDeliveryDate->format('d.m.Y'." ".$deliveryRange['from'])); // время начала работы доставки
            if($delivery_start > $n_from)
                $n_from = $delivery_start;

            // echo "Доставка начинает работать с ".$delivery_start->format('d.m.Y H:i:s')."<br>";
            // echo "Завтра доставку осуществляют с ". $n_from->format('d.m.Y H:i:s')."<br>";


            // Время до которого можно осущесвтить доставку завтра
            $n_to = new DateTime($objDeliveryDate->format('d.m.Y '.$deliveryRange['to']));

        } elseif($diff->d > 1) {
            // послезавтра и все последующие дни
            // echo "послезавтра<br>";
            // Доставку можно осуществить со времени начала работы магазины и до закрытия магазина
            $n_from = new DateTime($objDeliveryDate->format('d.m.Y').' '.$deliveryRange['from']);
            $n_to = new DateTime($objDeliveryDate->format('d.m.Y').' '.$deliveryRange['to']);
        }

        $time_delivery = [
            'from' => [
                'hours'     => $n_from->format("H:i"),
                'sec'       => $n_from->format("H") * 3600,
                'datetime'  => $n_from->format('d.m.Y H:i:s'),
                'timestamp' => strtotime($n_from->format('d.m.Y H:i:s')),
            ],
            'to' => [
                'hours'     => $n_to->format("H:i"),
                'sec'       => $n_to->format("H") * 3600,
                'datetime'  => $n_to->format('d.m.Y H:i:s'),
                'timestamp' => strtotime($n_to->format('d.m.Y H:i:s')),
            ],
        ];

        return $time_delivery;
    }

    public static function TimeRangePickup($datetime)
    {
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');
        $pickupRange = self::getWorkMode($datetime, false); // режим работы магазина в тот день, на который делают заказ

        // время необходимо на формирование букета
        $formation = $config['time_delivery']['formation'];

        $objNow = new DateTime(date('d.m.Y H:', time())."00:00");              // текущее время
        $cur_minutes = date('i', time()); // минуты в текущем часе

        $objDeliveryDate = new DateTime($datetime); // дата доставки, выбранная пользователем

        // Определение на какой день осуществляется доставка
        $objDeliveryDateDiff = new DateTime($objDeliveryDate->format('d.m.Y'));
        $objNowDiff = new DateTime($objNow->format('d.m.Y'));

        // определение разницы между текущим днем и датой доставки, выбранной пользователем
        $diff = $objNowDiff->diff($objDeliveryDateDiff);
        if($diff->d == 0) {
            // сегодня
            //echo 'сегодня';
            $store_start = new DateTime($objNow->format('d.m.Y'." ".$pickupRange['from'])); // время открытия магазина сегодня

            // Если заказ делают до открытия магазина
            if($objNow < $store_start) {
                // Доставка возможно со времени открытия магазина + время на формирование букета
                $n_from = clone $store_start;
                $n_from = $n_from->modify("+".$formation." hours");
            } else {
                // добавляем час ко времени формирования букета, чтобы было целое количестов часов на формирование букета
                if($cur_minutes != '00')
                    $formation += 1;

                // доставка возможна от текущего времени + время на формирование букета
                $n_from = clone $objNow;
                $n_from = $n_from->modify("+".$formation." hours");
            }

            $n_to = new DateTime($objDeliveryDate->format('d.m.Y '.$pickupRange['to']));

        } elseif($diff->d == 1) {
            // завтра
            //echo 'завтра';
            $today_weekday = $objNow->format("w");
            $today_workmode = $config['workmode'][$today_weekday];

            // если количество минут больше 0, то ко времени формирования прибавляем 1 час, так как необходимо целое количество часов
            if($cur_minutes != '00')
                $n_formation = $formation + 1;
            else
                $n_formation = $formation;

            // определение времени, когда закончат формировать букет, если начнут его собирать сейчас
            // определить - успевают ли сделать букет за сегодня
            $bouquet_finish = clone $objNow;
            $bouquet_finish = $bouquet_finish->modify("+".$n_formation." hours");
            $store_end = new DateTime($objNow->format('d.m.Y ').$today_workmode['to']); // время, когда закончит работать магазин СЕГОДНЯ


            // если букет не успевают сделать сегодня до закрытия магазина
            if($bouquet_finish > $store_end) {
                //echo "Букет сделать не успевают, будут делать завтра<br/>";
                // букет будут делать на следующий день со времени открытия магазиня
                $objFrom = new DateTime($objDeliveryDate->format('d.m.Y')." ".$pickupRange['from']);
                $n_from = clone $objFrom;

                // $n_from = $objFrom->modify('+'.$config['formation']." hours");
                $n_from = $n_from->modify('+'.$formation." hours");

            } else {
                // букет сделают сегодня, а завтра самовывоз возможен со старта работы магазина
                //echo " букет сделают сегодня, а завтра самовывоз возможен со старта работы магазина<br>";
                $n_from = new DateTime($objDeliveryDate->format('d.m.Y '.$pickupRange['from']));
            }



            $n_to = new DateTime($objDeliveryDate->format('d.m.Y '.$pickupRange['to']));

        } elseif($diff->d > 1) {
            // послезавтра
            //echo 'самовывоз на послезавтра<br>';
            $n_from = new DateTime($objDeliveryDate->format('d.m.Y '.$pickupRange['from']));
            $n_to = new DateTime($objDeliveryDate->format('d.m.Y '.$pickupRange['to']));
        }

        $time_pickup = [
            'from' => [
                'hours'     => $n_from->format("H:i"),
                'sec'       => $n_from->format("H") * 3600,
                'datetime'  => $n_from->format('d.m.Y H:i:s'),
                'timestamp' => strtotime($n_from->format('d.m.Y H:i:s')),
            ],
            'to' => [
                'hours'     => $n_to->format("H:i"),
                'sec'       => $n_to->format("H") * 3600,
                'datetime'  => $n_to->format('d.m.Y H:i:s'),
                'timestamp' => strtotime($n_to->format('d.m.Y H:i:s')),
            ],
        ];

        return $time_pickup;
    }

    /**
    *  Возвращает true, если время входит в допустимый диапазон
    *   @var string type - строка 'delivery' или 'pickup'
    *   @var string date - дата, на которую оформляется заказ в формате UNIX
    *   @var string time_from - начальное время, формат '00:00'
    *   @var string time_to - конечное время, формат '00:00'
    */
    public static function validateTime($type = 'delivery', $date, $time_from, $time_to)
    {
        // сначала нужно найти минимальное и максимальное возможное время по выбранному дню.
        // если сегодняшний день
        if(date('d.m.Y', $date) == date('d.m.Y', time())) {
            $cur_date = date('d.m.Y H:i:s', time());
            $type == 'pickup'?
                $base = CatalogMgr::TimeRangePickup($cur_date):
                $base = CatalogMgr::TimeRangeDelivery($cur_date);
        } else {
             $type == 'pickup'?
                $base = CatalogMgr::TimeRangePickup(date('d.m.Y H:i:s', $date))  :
                $base = CatalogMgr::TimeRangeDelivery(date('d.m.Y H:i:s', $date));
        }

        $time_from = intval($time_from);
        $time_to = intval($time_to);

        //echo intval($time_from). '>=' .intval($base['from']['hours']). '&& '.intval($time_to) .'<='. intval($base['to']['hours']);

        // выбранное минимальное время больше допустимого И
        // выбранное максимальное меньше допустимого И
        // выбранное максимальное больше выбранного минимального
        return $time_from >= intval($base['from']['hours']) &&
               $time_to   <= intval($base['to']['hours']) &&
               $time_from <  $time_to;
    }


    public static function getPaymentTime($date, $time_from) {

        $bl = BLFactory::GetInstance('system/config');
        $config_catalog = $bl->LoadConfig('module_engine', 'catalog');
        $config = $config_catalog['time_delivery']; // данные по времени доставки
        $formation = $config['formation'];

        $weekday = date('w', strtotime($date));
        $workmode_for_date = $config_catalog['workmode'][$weekday];


        if(intval($time_from) - intval($workmode_for_date['from']) >= $formation){

            return [
                'date' => $date,
                'time' => (intval($time_from) - $formation).':00',
            ];
        }

        else {
            $date = date('d.m.Y', strtotime($date. "- 1 day"));
            while(!CatalogMgr::isWorkingDay($date)) {
                $date = date('d.m.Y', strtotime($date. "- 1 day"));
            }


            $weekday = date('w', strtotime($date));
            $workmode_for_date = $config_catalog['workmode'][$weekday];
            return [
                'date' => $date,
                'time' => (intval($workmode_for_date['to']) - $formation).':00',
            ];
        }
    }

    public static function isWorkingDay($needle) {
        $bl = BLFactory::GetInstance('system/config');
        $config_catalog = $bl->LoadConfig('module_engine', 'catalog');
        $not_working_days = $config_catalog['days'];

        $needle = strtotime($needle);
        return !in_array(date('d.m', $needle), $not_working_days);
    }

    /**
     * возмращает шаг для слайдера доставки.
     * по-умолчанию равен 1 час (3600). Можно изменить с админки для конкретной даты.
     * @param string $date дата, для которой нужно определить шаг. Формат дд.мм
     * @return int шаг в unix формате
     */
    public function getDeliveryStep($date)
    {
        $hour = 60 * 60;
        $bl = BLFactory::GetInstance('system/config');
        $config_catalog = $bl->LoadConfig('module_engine', 'catalog');
        /* массив вида [['date' => ..., 'step' => ...], [...], ] */
        $minSteps = $config_catalog['minSteps'];
        if(!$minSteps)
            return $hour;

        foreach ($minSteps as $step) {
            if($step['date'] == $date) {
                return $step['step'] * $hour;
            }
        }

        return $hour;
    }

    /**
     * возвращает скидку на товар, отмеченный флагом ExcludeDiscount
     *
     * @return float
     */
    public function getDiscount()
    {
        // return 1 - self::DISCOUNT / 100;
        return 1 - static::getDiscountValue() / 100;
    }

    /**
     * проверяет, установлена ли скидка на товар
     *
     * @param array $areaRefs
     * @return boolean
     */
    public function hasDiscount($areaRefs)
    {
        return isset($areaRefs['ExcludeDiscount']) && $areaRefs['ExcludeDiscount'];
    }

    public function getDiscountPrice($price, $product = null, $catalogId = 0)
    {
        $discount = $product->getDiscountValue($catalogId);
        return ceil($price * $discount);
        // return ceil($price * $this->getDiscount());
    }

    /**
     * возвращает сумму заказа с учетом скидочной карты и скидочных товаров.
     *
     * @param array $cart [[$this->GetCart()]]
     * @param float $totalPrice стоимость товаров корзины и открытки
     * @param int $discount скидка в процентах
     * @return int
     */
    // public function getCartPrice($cart, $totalPrice, $discount)
    // {
    //     if(!$discount)
    //         return $totalPrice;

    //     if(!count($cart['items']))
    //         return 0;

    //     $excludeDiscountPrice = 0;
    //     // В каталоге могут быть товары, на которые скидочная карта не действует (arearefs['ExcludeDiscount'] = 1).
    //     // Поэтому если введена скидочная карта, нужно пройтись по товарам корзины.
    //     // Если товар помечен флагом ExcludeDiscount, скидку для него не считать
    //     foreach($cart['items'] as $item) {
    //         $product = $item['product'];
    //         $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
    //         if($this->hasDiscount($areaRefs))
    //             $excludeDiscountPrice += $item['item_price'];
    //     }

    //     // часть из общей стоимости, для которой нужно применить скидку
    //     $discountPrice = $totalPrice - $excludeDiscountPrice;
    //     // применение скидки
    //     $discountPrice *= 1 - $discount / 100;
    //     // часть с примененной скидкой + неизменяемая часть
    //     return floor($discountPrice) + $excludeDiscountPrice;
    // }

    /**
     * возвращает сумму заказа с учетом скидочной карты и скидочных товаров.
     *
     * @param array $cart [[$this->GetCart()]]
     * @param float $cardPrice стоимость  открытки
     * @param int $discount скидка в процентах
     * @return int
     */
    public function getCartPrice($cart, $cardPrice, $discount)
    {

        if(!$discount) {
            return $cart['sum']['total_price'] + $cardPrice;
        }

        if(!count($cart['items']))
            return 0;

       	// Если процент скидки на товар больше процента по карте, то берется скидка букета
       	// иначе берется скидка карты
       	$totalPrice = 0;
        foreach($cart['items'] as $item) {
        	// print_r([
        	// 	$item['item_price'],
        	// 	$item['price'],
        	// 	$item['clear_price'],
        	// ]);
            $product = $item['product'];
            $additions = $item['addition'];
            $productDiscountPercent = (int) $product->getDiscountPercent(App::$City->CatalogId);
            $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
            if($this->hasDiscount($areaRefs) && $productDiscountPercent > $discount) {
            	$itemPrice = $item['item_price'];
            } else {
        		$itemPrice = $this->calcDiscountPrice($item['clear_price'], $discount);
            }

            // $addPrice = $this->calcDiscountPrice($item['add_price'], $discount);
            // Стоимость допов с учетом скидки
            $addPrice = $this->calcDiscountPrice($item['addition_price'], $discount);

            // $discountCardPrice = $this->calcDiscountPrice($cardPrice, $discount);
        	// $totalPrice += $itemPrice
        	// 	+ $this->calcDiscountPrice($item['add_price'], $discount)
        	// 	+ $this->calcDiscountPrice($cardPrice, $discount);

            $totalPrice += $itemPrice
                + $addPrice;

        }

        // $totalPrice += $this->calcDiscountPrice($cardPrice, $discount);
        $totalPrice += $cardPrice;

        return $totalPrice;
    }

    public function calcDiscountPrice($price, $discount)
    {
    	$discountValue = 1 - $discount / 100;
    	return ceil($discountValue * $price);
    }

    public function exportEmailsToCsv()
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/resources/emails.csv';

	    $sql = "SELECT DISTINCT CustomerName, CustomerEmail FROM " .$this->_tables['orders'];

        $res = $this->_db->query($sql);
        if ( !$res || !$res->num_rows )
            return false;

        $file = fopen($filename, 'w');
        while ($row = $res->fetch_assoc())
        {
            fputcsv($file, array_values($row));
        }

        fclose($file);
    }
}
