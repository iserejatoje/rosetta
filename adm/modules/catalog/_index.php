<?php

if(1)
{
    $catalog_error_code = 0;
    define('ERR_A_CATALOG_MASK', 0x01640000);

    define('ERR_A_CATALOG_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_NOT_FOUND] = 'Раздел каталога не найден';

    define('ERR_A_DISCOUNTCARD_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_DISCOUNTCARD_NOT_FOUND] = 'Скидочная карта не найдена';

    define('ERR_A_SECTION_ACCESS_DENIED', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_SECTION_ACCESS_DENIED] = 'У вас нет доступа к этому разделу';

    define('ERR_A_CTL_UPDATE_FILE_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CTL_UPDATE_FILE_EMPTY] = 'Нет файла';

    define('ERR_A_CARD_NAME_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CARD_NAME_EMPTY] = 'Не указано название открытки';

    define('ERR_A_LEN_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_LEN_NOT_FOUND] = 'Ростовка не найдена';

    define('ERR_A_ADDITION_EMPTY_NOT_SELECTED', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_ADDITION_EMPTY_NOT_SELECTED] = 'Не выбран тип допа.';

    define('ERR_A_PRODUCT_ROSE_COUNT_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_ROSE_COUNT_EMPTY] = 'Необходимо указать количество';

    define('ERR_A_PRODUCT_ROSE_LENGTH_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_ROSE_LENGTH_EMPTY] = 'Необходимо указать длину роз';

    define('ERR_CARD_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_CARD_NOT_FOUND] = 'Открытка не найдена';

    define('ERR_A_CATALOG_EMPTY_KIND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_KIND] = 'Не указан тип каталога';

    define('ERR_A_LEN_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_LEN_EMPTY] = 'Не указана длина';

    define('ERR_A_RETAIL_EMPTY_PRICE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_RETAIL_EMPTY_PRICE] = 'Не указана розничная цена';

    define('ERR_A_WHOLESALE_EMPTY_PRICE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_WHOLESALE_EMPTY_PRICE] = 'Не указана оптовая цена';

    define('ERR_A_ADDITION_EMPTY_NAME', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_ADDITION_EMPTY_NAME] = 'Не указано название доп. товара';

    define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

    define('ERR_A_PRODUCT_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_NOT_FOUND] = 'Продукт не найден';

    define('ERR_A_PRODUCT_EMPTY_TITLE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_EMPTY_TITLE] = 'Не указано название продукта';

    define('ERR_A_PRODUCT_EMPTY_TYPE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_EMPTY_TYPE] = 'Не указан тип продукта';

    define('ERR_A_PRODUCT_EMPTY_NAMEID', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_EMPTY_NAMEID] = 'Не указано имя ссылки на продукт';

    define('ERR_A_CATALOG_ERROR_LINK', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_ERROR_LINK] = 'Произошла ошибка при проверке имени ссылки';

    define('ERR_A_CATALOG_OCCUPIED_LINK', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_OCCUPIED_LINK] = 'Ссылка с таким именем уже существует';

    define('ERR_A_PRODUCT_LONG_SHORTDESC', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_PRODUCT_LONG_SHORTDESC] = 'Слишком длинный текст';

    define('ERR_A_CATALOG_FILTER_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_FILTER_NOT_FOUND]
        = 'Фильтр не найден';

    define('ERR_A_CATALOG_EMPTY_FILTER_NAME', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_FILTER_NAME] = 'Название фильтра не указано';

    define('ERR_A_CATALOG_EMPTY_FILTER_NAMEID', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_FILTER_NAMEID] = 'Название ключа фильтра не указано';

    define('ERR_A_CATALOG_EMPTY_PARAM_FILTER', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_PARAM_FILTER] = 'Необходимо указать хотя бы один параметр';

    define('ERR_A_CATALOG_EMPTY_MEMBER_NAME', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_MEMBER_NAME]
        = 'Необходимо указать имя для элемента';

    define('ERR_A_CATALOG_NOT_SELECTED_NODE_TYPE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_NOT_SELECTED_NODE_TYPE] = 'Не указан тип оформления';

    define('ERR_A_CATALOG_NOT_SELECTED_RANGES', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_NOT_SELECTED_RANGES] = 'Не указана ценовая политика';

    define('ERR_A_CATALOG_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_NOT_FOUND]
        = 'Товар не найден.';

    define('ERR_A_CATEGORY_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATEGORY_NOT_FOUND] = 'Раздел не найден.';

    define('ERR_A_CATALOG_EMPTY_TITLE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_TITLE] = 'Не указано название раздела';

    define('ERR_A_CATALOG_EMPTY_NAMEID', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_EMPTY_NAMEID] = 'Не указан URL раздела';

    define('ERR_A_CATALOG_NOT_EMPTY', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_CATALOG_NOT_EMPTY] = 'Нельзя удалить раздел, который содержит товары.';

    define('ERR_A_ADDITION_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_ADDITION_NOT_FOUND] = 'Доп. товар не найден';

    define('ERR_A_LEN_MEMBER_NOT_SELECTED', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_LEN_MEMBER_NOT_SELECTED] = 'Компонент не выбран';

    define('ERR_A_ORDER_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_ORDER_NOT_FOUND] = 'Заказ не найден';

    define('ERR_A_DISCOUNTCARD_NOT_FOUND', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_DISCOUNTCARD_NOT_FOUND] = 'Скидачная карта не найдена';

    define('ERR_A_DELIVERY_TIME_INVALID_FORMAT', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_DELIVERY_TIME_INVALID_FORMAT] = 'Неверный формат времени. Время нужно вводить в формате ЧЧ:ММ';

    define('ERR_SPECIAL_UNKNOWN_TYPE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_SPECIAL_UNKNOWN_TYPE] = 'Несуществующий тип особенных дат';

    define('ERR_SPECIAL_INVALID_DATE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_SPECIAL_INVALID_DATE] = 'Неправильная дата';

    define('ERR_SPECIAL_INVALID_TIME', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_SPECIAL_INVALID_TIME] = 'Неправильное время';

    define('ERR_SPECIAL_INVALID_TIME_RANGE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_SPECIAL_INVALID_TIME_RANGE] = 'Время окончания работы должно быть больше времени начала';

    define('ERR_MINSTEP_INVALID_DATE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_MINSTEP_INVALID_DATE] = 'Неправильная дата';

    define('ERR_MINSTEP_INVALID_STEP', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_MINSTEP_INVALID_STEP] = 'Шаг должен быть целым числом';

    define('ERR_A_DELIVERY_TIME_INVALID_RANGE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_DELIVERY_TIME_INVALID_RANGE] = 'Неверный формат времени. Время начала доставки должно быть меньше времени завершения доставки';

    define('ERR_A_WORKMODE_TIME_INVALID_RANGE', ERR_A_CATALOG_MASK | $error_code++);
    UserError::$Errors[ERR_A_WORKMODE_TIME_INVALID_RANGE] = 'Неверный формат времени. Время открытия должно быть меньше времени закрытия';
}
ini_set('max_execution_time', '60');
date_default_timezone_set(TIMEZONE);

class AdminModule
{
    static $TITLE = 'Каталог';

    static $ROW_ON_PAGE = 15;
    static $PAGES_ON_PAGE = 5;
    static $ORDER_ROWS_COUNT = 200;

    static $SURCHARGE_IDS = [
        'повторная доставка',
        'неправильный район'
    ];

    static $SURCHARGE_CAUSES = [
        '<p>В связи с тем, что во время доставки получателя не оказалось на месте, 
        мы можем осуществить доставку вторично, но Вам необходимо оплатить сумму в размере {{sum}} руб.</p>
        <p>Также Вы можете забрать букет самостоятельно в салоне «Букетная мастерская "Розетта"» по адресу г. Кемерово, пр-т Ленина 114.</p>',

        '<p>В связи с тем, что адрес доставки не совпадает с выбранным районом, просим Вас доплатить сумму в размере {{sum}} руб.</p>'
    ];

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $catalogMgr;
    private $paymentMgr;
    private $photoMgr;

    function __construct($config, $aconfig, $id)
    {
        static $ROW_ON_PAGE = 11;
        static $PAGES_ON_PAGE = 10;
        static $ORDER_ROWS_COUNT = 200;

        global $CONFIG,$DCONFIG, $OBJECTS;
        LibFactory::GetMStatic('catalog', 'catalogmgr');
        LibFactory::GetMStatic('blocks', 'blockmgr');
        LibFactory::GetMStatic('eshop', 'eshopmgr');
        LibFactory::GetMStatic('eshop', 'oldproductphotomgr');
        LibFactory::GetMStatic('catalog', 'productphotomgr');
        LibFactory::GetMStatic('cities', 'citiesmgr');

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");

        $this->_id = &$id;
        $this->_config = &$config;

        if ($this->_config['root']) {
                $this->_id = ($this->_config['root']);
        }

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');

        $this->catalogMgr = CatalogMgr::getInstance(false);
        $this->photoMgr = ProductPhotoMgr::getInstance(false);
        $this->blocksMgr = BlockMgr::getInstance(false);

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery-ui-1.8.23.min.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.datepicker-ru.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.timepicker.js');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/css/ui-lightness/jquery-ui-1.8.23.custom.css');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.timepicker.css');

        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-datetimepicker.min.css');

        App::$Title->AddScript('/resources/bootstrap/js/moment-with-locales.min.js');
        App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');
        App::$Title->AddScript('/resources/bootstrap/js/bootstrap-datetimepicker.min.js');

       // App::$Title->AddScript('http://momentjs.com/downloads/moment-with-locales.min.js');

        App::$Title->AddScript('/resources/scripts/themes/editors/tinymce/js/tinymce/tinymce.min.js');

        session_start();
    }

    function Action()
    {
        if($this->_PostAction()) return;
        $this->_GetAction();
    }

    function GetPage()
    {
        global $DCONFIG, $OBJECTS;
        switch($this->_page)
        {
            case 'discountcards':
                $html = $this->_GetDiscountCards();
                break;
            case 'edit_discountcard':
                $this->_title = "Просмотр информации о карте";
                $html = $this->_GetDiscountCardEdit();
                break;
            case 'ajax_discountcard_toggle_active':
                $this->_GetAjaxToggleDiscountCardActive();
                break;

             case 'service':
                $html = $this->_GetService();
                break;

            case 'orders':
                $this->_title = "Заказы";
                $html = $this->_GetOrders();
                break;
            case 'archived_orders':
                $this->_title = "Заказы";
                $html = $this->_GetArchivedOrders();
                break;

            case 'edit_order':
                $this->_title = "Редактировать заказ";
                $html = $this->_GetOrderEdit();
                break;

             case 'general_sorting':
                $this->_title = "Сортировака разделов";
                $html = $this->_GetGeneralSorting();
                break;

            case 'config_settings':
                $this->_title = "Редактировать цены";
                $html = $this->_GetConfigSettings();
                break;

            case 'product_lens':
                $this->_title = "Ростовка";
                $html = $this->_GetProductLens();
                break;
            case 'new_productlen':
                $this->_title = "Добавить длину";
                $html = $this->_GetProductLenNew();
                break;
            case 'edit_productlen':
                $this->_title = "Править длину";
                $html = $this->_GetProductLenEdit();
                break;
            case 'ajax_productlen_toggle_visible':
                $this->_GetAjaxToggleProductLenVisible();
                break;
            case 'delete_productlen':
                $this->_GetProductLenDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=product_lens&productid='.$_GET['productid']);
                break;
            case 'lens':
                $this->_title = "Длины роз";
                $html = $this->_GetLens();
                break;
            // =======================================

            case 'new_card':
                $this->_title = "Добавить открытку";
                $html = $this->_GetCardNew();
                break;
            case 'edit_card':
                $this->_title = "Править открытку";
                $html = $this->_GetCardEdit();
                break;
            case 'ajax_card_toggle_visible':
                $this->_GetAjaxToggleCardVisible();
                break;
            case 'delete_card':
                $this->_GetCardDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cards&catalog_id='.$_GET['catalog_id']);
                break;
            case 'cards':
                $this->_title = "Открытки";
                $html = $this->_GetCards();
                break;
            // =======================================

            case 'new_len':
                $this->_title = "Добавить длины роз";
                $html = $this->_GetLenNew();
                break;
            case 'edit_len':
                $this->_title = "Править длину роз";
                $html = $this->_GetLenEdit();
                break;
            case 'ajax_len_toggle_visible':
                $this->_GetAjaxToggleLenVisible();
                break;
            case 'delete_len':
                $this->_GetLenDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=lens&type_id='.$_GET['type_id']);
                break;
            case 'lens':
                $this->_title = "Длины роз";
                $html = $this->_GetLens();
                break;

            case 'new_addition':
                $this->_title = "Добавить доп. товар";
                $html = $this->_GetAdditionNew();
                break;
            case 'edit_addition':
                $this->_title = "Править доп.товар";
                $html = $this->_GetAdditionEdit();
                break;
             case 'ajax_addition_toggle_visible':
                $this->_GetAjaxToggleAdditionVisible();
                break;
            case 'delete_addition':
                $this->_GetAdditionDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=additions');
                break;
            case 'additions':
                $this->_title = "Доп. товары";
                $html = $this->_GetAdditions();
                break;

            case 'new_category':
                if(App::$User->IsInRole('e_adm_execute_section') == false && App::$User->IsInRole('e_adm_execute_users') == false) {
                    UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
                    return STPL::Fetch('admin/modules/catalog/errors');
                }
                $this->_title = "Добавить раздел";
                $html = $this->_GetCategoryNew();
                break;
            case 'edit_category':
                // if(App::$User->IsInRole('e_adm_execute_users') == false && App::$User->IsInRole('e_adm_execute_section') == false ) {
                if(App::$User->IsInRole('e_adm_execute_section') == false && App::$User->IsInRole('e_adm_execute_users') == false) {
                    UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
                    return STPL::Fetch('admin/modules/catalog/errors');
                }
                $this->_title = "Добавить раздел";
                $html = $this->_GetCategoryEdit();
                break;
            case 'ajax_category_toggle_visible':
                $this->_GetAjaxToggleCategoryVisible();
                break;
            case 'delete_category':
                $this->_GetCategoryDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'catalog':
                $this->_title = "Каталог";
                $html = $this->_GetCatalog();
                break;

            case 'products':
                $this->_title = "Товары";
                $html = $this->_GetProducts();
                break;
            case 'new_product':
                if(App::$User->IsInRole('u_bouquet_editor') == false && (App::$User->IsInRole('e_adm_execute_section') == false && App::$User->IsInRole('e_adm_execute_users') == false)) {
                    UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
                    return STPL::Fetch('admin/modules/catalog/errors');
                }
                $this->_title = "Добавить товар";
                $html = $this->_GetProductNew();
                break;
            case 'edit_product':
                $this->_title = "Редактировать товар";
                $html = $this->_GetProductEdit();
                break;
            case 'edit_filters':
                $this->_title = "Редактировать фильтры";
                $html = $this->_GetProductFiltersEdit();
                break;
            case 'edit_composition':
                $this->_title = "Редактировать состав";
                $html = $this->_GetProductCompositionEdit();
                break;
            case 'types':
                $this->_title = "Редактировать типы";
                $html = $this->_GetProductTypes();
                break;
            case 'product_type_new':
                $this->_title = "Добавить тип";
                $html = $this->_GetProductTypeNew();
                break;
            case 'product_type_edit':
                $this->_title = "Редактировать тип";
                $html = $this->_GetProductTypeEdit();
                break;
            case 'ajax_product_type_toggle_visible':
                $this->_ToggleVisibleProductType();
                break;
            case 'ajax_product_type_toggle_default':
                $this->_ToggleDefaultProductType();
                break;
            case 'ajax_product_toggle_visible':
                $this->_GetAjaxToggleProductVisible();
                break;
            case 'ajax_product_toggle_main':
                $this->_GetAjaxToggleProductMain();
                break;
            case 'ajax_product_toggle_available':
                $this->_GetAjaxToggleProductAvailable();
                break;
            case 'ajax_surcharge':
                $this->_GetAjaxSendSurcharge();
                break;
            case 'delete_product':
                $this->_GetProductDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=products&type_id='.$_GET['type_id']);
                break;

            case 'filters':
                $this->_title = "Фильтры";
                $html = $this->_GetFilters();
                break;
            case 'new_filter':
                $this->_title = "Добавить фильтр";
                $html = $this->_GetFilterNew();
                break;
            case 'edit_filter':
                $this->_title = "Редактировать фильтр";
                $html = $this->_GetFilterEdit();
                break;

            case 'decors':
                $this->_title = "Оформление";
                $html = $this->_GetDecors();
                break;
            case 'new_decor':
                $this->_title = "Добавить оформление";
                $html = $this->_GetDecorNew();
                break;
            case 'edit_decor':
                $this->_title = "Редактировать оформление";
                $html = $this->_GetDecorEdit();
                break;

            case 'compositions':
                $this->_title = "Элементы букетов";
                $html = $this->_GetCompositions();
                break;
            case 'new_member':
                $this->_title = "Добавить";
                $html = $this->_GetMemberNew();
                break;
            case 'edit_member':
                $this->_title = "Редактировать";
                $html = $this->_GetMemberEdit();
                break;
            case 'toggle_member_visible':
                $this->_ToggleVisibleMember();
                Response::Redirect("?{$DCONFIG['SECTION_ID_URL']}&action=compositions#member".$_GET['id']);
                break;

            case 'photos':
                $this->_title = "Фотографии";
                $html = $this->_GetProductPhotos();
                break;
            case 'new_photo':
                $this->_title = "Добавить фотографию";
                $html = $this->_GetProductPhotoNew();
                break;
            case 'edit_photo':
                $this->_title = "Редактировать фотографию";
                $html = $this->_GetProductPhotoEdit();
                break;
            case 'toggle_photo_visible':
                $this->_ToggleVisiblePhoto();
                Response::Redirect("?{$DCONFIG['SECTION_ID_URL']}&action=compositions#member".$_GET['id']);
                break;

            case 'settings':
                $this->_title = "Настройки";
                $html = $this->_GetSettings();
                break;

            case 'section_settings':
                $this->_title = "Настройки раздела";
                $html = $this->_GetSectionSettings();
                break;

            case 'copy':
                $this->_title = "Копировать каталог";
                $html = $this->_GetCatalogCopy();
                break;

            case 'sorting':
                $this->_title = "Сортировка товаров";
                $html = $this->_GetSorting();
                break;

            case 'edit_wedding_text':
                $this->_title = "Редактировать заголовочный текст";
                $html = $this->_GetHeaderTextEdit();
                break;

            default:
                $this->_title = "Каталог";
                $html = $this->_GetCatalog();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        $tabs = [];
        $filter = [
            'flags' => [
                'objects' => true,
                'Status' => CatalogMgr::OS_NEW,
            ],
            'field' => [],
            'dir' => [],
            'calc' => true,
            'dbg' => 0,
        ];

        list($orders, $count) = $this->catalogMgr->GetOrders($filter);
        $ord_add = "";
        if($count > 0)
            $ord_add = " (".$count.")";

        if(App::$User->IsInRole('u_order_manager')) {
            $tabs['orders'] = ['name' => 'action', 'value' => 'orders', 'text' => 'Заказы'.$ord_add];
        }

        if(App::$User->IsInRole('u_discountcard_editor')) {
            $tabs['discountcards'] = ['name' => 'action', 'value' => 'discountcards', 'text' => 'Карты скидок'];
        }

        if(App::$User->IsInRole('u_price_changer')) {
            $tabs['compositions'] = ['name' => 'action', 'value' => 'compositions', 'text' => 'Состав'];
        }

        if(App::$User->IsInRole('u_bouquet_editor')) {
            $tabs['catalog'] = ['name' => 'action', 'value' => 'catalog', 'text' => 'Каталог'];
            $tabs['additions'] = ['name' => 'action', 'value' => 'additions', 'text' => 'Доп. товары'];
            $tabs['compositions'] = ['name' => 'action', 'value' => 'compositions', 'text' => 'Состав'];
            $tabs['cards'] = ['name' => 'action', 'value' => 'cards', 'text' => 'Открытки'];
            $tabs['filters'] = ['name' => 'action', 'value' => 'filters', 'text' => 'Фильтры'];
            $tabs['general_sorting'] = ['name' => 'action', 'value' => 'general_sorting', 'text' => 'Сортировка'];
        }

        if(App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) {
            $tabs['catalog'] = ['name' => 'action', 'value' => 'catalog', 'text' => 'Каталог'];
            $tabs['additions'] = ['name' => 'action', 'value' => 'additions', 'text' => 'Доп. товары'];
            $tabs['cards'] = ['name' => 'action', 'value' => 'cards', 'text' => 'Открытки'];
            $tabs['orders'] = ['name' => 'action', 'value' => 'orders', 'text' => 'Заказы'.$ord_add];
            $tabs['filters'] = ['name' => 'action', 'value' => 'filters', 'text' => 'Фильтры'];
            $tabs['compositions'] = ['name' => 'action', 'value' => 'compositions', 'text' => 'Состав'];
            $tabs['discountcards'] = ['name' => 'action', 'value' => 'discountcards', 'text' => 'Карты скидок'];
                // ['name' => 'action', 'value' => 'settings', 'text' => 'Настройки'],
            $tabs['config_settings'] = ['name' => 'action', 'value' => 'config_settings', 'text' => 'Настройки раздела'];
                // ['name' => 'action', 'value' => 'copy', 'text' => 'Копировать каталог'],
            $tabs['general_sorting'] = ['name' => 'action', 'value' => 'general_sorting', 'text' => 'Сортировка'];
        }

        return [
            'tabs' => $tabs,
            'selected' => $this->_page,
        ];

        // return array(
        //     'tabs' => array(
        //         array('name' => 'action', 'value' => 'catalog', 'text' => 'Каталог'),
        //         array('name' => 'action', 'value' => 'additions', 'text' => 'Доп. товары'),
        //         array('name' => 'action', 'value' => 'cards', 'text' => 'Открытки'),
        //         array('name' => 'action', 'value' => 'orders', 'text' => 'Заказы'.$ord_add),
        //         array('name' => 'action', 'value' => 'filters', 'text' => 'Фильтры'),
        //         array('name' => 'action', 'value' => 'compositions', 'text' => 'Состав'),
        //         // array('name' => 'action', 'value' => 'settings', 'text' => 'Настройки'),
        //         array('name' => 'action', 'value' => 'config_settings', 'text' => 'Настройки раздела'),
        //         // array('name' => 'action', 'value' => 'copy', 'text' => 'Копировать каталог'),
        //         array('name' => 'action', 'value' => 'general_sorting', 'text' => 'Сортировка'),
        //     ),
        //     'selected' => $this->_page
        // );
    }

    function GetTitle()
    {
        return $this->_title;
    }

    private function _setMessage($message = 'Данные сохранены.') {
        $_SESSION['user_message'] = array(
            'message' => $message,
        );
    }

    private function _GetAction()
    {
        global $DCONFIG;
        switch($_GET['action'])
        {
            default:
                $this->_page = $_GET['action'];
                break;
        }
    }

    private function _PostAction()
    {
        global $DCONFIG, $OBJECTS;

        switch($_POST['action'])
        {
            case 'update_member_price':
                if($updated = $this->_PostUpdateMemberPrice())
                    //return $this->_GetCompositions();
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions');
                break;

            case 'update_members':
                if($updated = $this->_PostUpdateMembers())
                    //return $this->_GetCompositions();
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions&updated='.json_encode($updated));
                break;

            case 'load_cards':
                if($updated = $this->_PostLoadCards())
                    //return $this->_GetCompositions();
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=discountcards&updated='.json_encode($updated));
                break;

            case 'edit_discountcard':
                if($this->_PostDiscountCard())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=discountcards');
                break;

            case 'edit_order':
                if($this->_PostOrder())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=orders');
                break;
             case 'settings_config':
                if($this->_PostConfigSettings())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=config_settings');
                break;
            case 'save_cards':
                if ($this->_PostSaveCards())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cards');
                break;
            case 'new_card':
                if (($pid = $this->_PostCard()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cards');
                break;
            case 'edit_card':
                if (($pid = $this->_PostCard()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cards');
                break;

            case 'save_productlens':
                if ($this->_PostProductSaveLens())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=product_lens&productid='.$_POST['productid']);
                break;
            case 'new_productlen':
                if (($pid = $this->_PostProductLen()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=product_lens&productid='.$_POST['productid']);
                break;
            case 'edit_productlen':
                if (($pid = $this->_PostProductLen()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=product_lens&productid='.$_POST['productid']);
                break;

            case 'save_lens':
                if ($this->_PostSaveLens())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=product_lens&productid='.$_POST['productid']);
                break;
            case 'new_len':
                if (($pid = $this->_PostLen()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=lens&type_id='.$_POST['type_id']);
                break;
            case 'edit_len':
                if (($pid = $this->_PostLen()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=lens&type_id='.$_POST['type_id']);
                break;

            case 'save_additions':
                if ($this->_PostSaveAdditions())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=additions');
                break;
             case 'new_addition':
                if (($pid = $this->_PostAddition()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=additions');
                break;
            case 'edit_addition':
                if (($pid = $this->_PostAddition()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=additions');
                break;

             case 'new_category':
                if (($pid = $this->_PostCategory()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;
            case 'edit_category':
                if (($pid = $this->_PostCategory()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'save_catalog_sections':
                if ($this->_PostSaveCatalog())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'new_product':
                if (($pid = $this->_PostProduct()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_product&type_id='.$_POST['TypeID'].'&id='.$pid);
                break;
            case 'edit_product':
                if (($pid = $this->_PostProduct()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_product&type_id='.$_POST['type_id'].'&id='.$pid);
                break;
            case 'save_products_order':
                if ($this->_PostProductsOrderSave()) {
                        $add = '';
                        if(isset($_POST['type_id']))
                            $add = "&type_id=".$_POST['type_id'];
                        Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action='.$_POST['action_type'].$add);
                    }
                break;
            case 'edit_filters':
                if (($pid = $this->_PostProductFiltersEdit()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_filters&type_id='.$_POST['TypeID'].'&id='.$pid);
                break;

            case 'save_header_text':
                if($this->_PostHeaderTextSave() > 0)
                   Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');

                break;


            case 'product_type_edit':
                if (($pid = $this->_PostProductType()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$_POST['TypeID'].'&id='.$pid);
            case 'product_type_new':
                if (($pid = $this->_PostProductType()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$_POST['TypeID'].'&id='.$pid);
                break;
            case 'product_types_delete':
                if ($this->_PostProductTypeDelete())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$_POST['TypeID'].'&id='.$_POST['id']);
                break;
            case 'product_types_save':
                if ($this->_PostProductTypesSave())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$_POST['TypeID'].'&id='.$_POST['id']);
            case 'edit_composition':
                if (($pid = $this->_PostProductCompositionEdit()) > 0)
                {
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_composition&type_id='.$_POST['type_id'].'&id='.$pid.'&tid='.$_POST['tid']);
                }


            case 'new_filter':
                if ($this->_PostFilter())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;
            case 'edit_filter':
                if ($this->_PostFilter())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;
            case 'filters_delete':
                if ($this->_PostFiltersDelete())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;


            // case 'new_decor':
            //     if ($this->_PostDecor())
            //         Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=decors');
            //     break;
            // case 'edit_decor':
            //     if ($this->_PostDecor())
            //         Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=decors');
            //     break;
            // case 'decor_delete':
            //     $this->_PostDecorDelete();
            //     Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=decors');
            //     break;


            case 'new_member':
                if ($this->_PostMember())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions');
                break;
            case 'edit_member':
                if ($this->_PostMember())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions');
                break;
            case 'members_delete':
                if ($this->_PostMembersDelete())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions');
                break;
            case 'members_save':
                if ($this->_PostMembersSave())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=compositions');
                break;


            case 'new_photo':
                if ($this->_PostProductPhoto())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&treeid='.$_POST['treeid'].'&parent='.$_POST['parent'].'&id='.$_POST['productid']);
                break;
            case 'edit_photo':
                if ($this->_PostProductPhoto())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&treeid='.$_POST['treeid'].'&parent='.$_POST['parent'].'&id='.$_POST['productid']);
                break;
            case 'photos_update':
                $this->_PostUpdatePhotos();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&treeid='.$_GET['treeid'].'&parent='.$_GET['parent'].'&id='.$_GET['id']);
                break;
            case 'photos_delete':
                $this->_PostDeletePhotos();
                break;


            case 'seo':
                if ($this->_PostSectionSeo())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'settings':
                if ($this->_PostSettings())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'section_settings':
                if ($this->_PostSectionSettings())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'copy':
                if ($this->_PostCatalogCopy())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'save_sorting':
                $this->_PostSaveProductsSorting();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=sorting&type_id='.$_POST['type_id']);

            case 'copy_decor':
                if ($this->_PostCatalogCopyDecor())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;

            case 'copy_composition':
                if ($this->_PostCatalogCopyComposition())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=catalog');
                break;
        }
        return false;
    }

    private function _GetImportAdd()
    {
        global $DCONFIG, $CONFIG;
exit;
        // words
        // $pids = [
        //     // 1655,
        //     // 1651,1654, 1656, 1648,
        //     // 1649, 1657,  1652, 1659, 1647,
        //     // 1650, 1653, 1658, 1646,
        // ];

        // vases
        // $pids = [
            // 4634, 4639, 4638, 4636, 4628,
            // 4632, 4631, 4633, 4635, 4627,
            // 4629, 4625, 4626, 4624, 4637, 4630,
        // ];

        // toys
        // $pids = [
        //     // 1846,  713, 704, 701, 695, 4730,
        //     // 4731, 4728, 705, 730, 736, 725,
        //     // 724, 718, 717, 737, 727, 732,
        //     // 731, 721, 722, 723, 715, 716,
        //     // 739, 726, 735, 738, 729, 720,
        //     // 728, 733, 734, 697, 719, 703,
        //     // 702, 4727, 689, 699, 706, 707,
        //     // 1847, 709, 710, 1848, 692, 700,
        //     // 711, 693, 694, 696, 1849, 1854,
        //     // 1855, 1850, 1851, 1852, 1853,
        //     // 708, 712, 4725, 1857, 4726,
        //     // 4729, 1858, 1859, 691, 690, 698,
        // ];


        foreach($pids as $id) {
            $old_product = EshopMgr::GetInstance()->GetProduct($id);

            $Data = array(
                'Name'   => $old_product->Name,
                'Price'  => $old_product->Price,
                'Type'   => CatalogMgr::AD_TOYS,
            );

            $addition = new Addition($Data);
            $addition->Update();

            $arr_photos = [];
            if($old_product->LogotypeSmall)
            {
                $photofile = $CONFIG['engine_path'].$old_product->LogotypeSmall['f'];
                $photosize = filesize($photofile);
                $_FILES["PhotoSmall"]["name"] = $photofile;
                $_FILES["PhotoSmall"]["tmp_name"] = $photofile;
                $_FILES["PhotoSmall"]["size"] = $photosize;
                $_FILES["PhotoSmall"]["type"] = "image/jpeg";
                $_FILES["PhotoSmall"]["error"] = UPLOAD_ERR_OK;

                $arr_photos['PhotoSmall'] = ['PhotoSmall'];
            }

            if($old_product->LogotypeBig)
            {
                $photofile = $CONFIG['engine_path'].$old_product->LogotypeBig['f'];
                $photosize = filesize($photofile);
                $_FILES["PhotoBig"]["name"] = $photofile;
                $_FILES["PhotoBig"]["tmp_name"] = $photofile;
                $_FILES["PhotoBig"]["size"] = $photosize;
                $_FILES["PhotoBig"]["type"] = "image/jpeg";
                $_FILES["PhotoBig"]["error"] = UPLOAD_ERR_OK;

                $arr_photos['PhotoBig'] = ['PhotoBig'];
            }

            foreach ($arr_photos as $key => $photos)
            {
                foreach ($photos as $photoName)
                {
                    $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                    if ($del_file || is_file($_FILES[$key]['tmp_name']))
                        $addition->$photoName = null;
                    try
                    {
                        $addition->Upload($key, $photoName);
                    }

                    catch(MyException $e)
                    { var_dump($e);
                        if( $e->getCode() >  0 )
                            UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                        else
                            UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                        $addition->$photoName = null;
                        return false;
                    }
                }
            }

            $addition->Update();

            $RefParams = array(
                'AdditionID' => $addition->ID,
                'SectionID' => $this->_id,
                'IsVisible' => $old_product->IsVisible,
                'InCard' => 1,
            );
            $this->catalogMgr->UpdateAdditionAreaRef($RefParams);
        }

        echo "ok"; exit;
    }

    private function _GetImport()
    {
        exit;
        global $DCONFIG, $CONFIG;

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
                'NodeID' => 4,
            ),
            'calc' => true,
        );

        list($products, $count) = EshopMgr::GetInstance()->GetProducts($filter);

        // roses
        // $pids = [
            // 266, 259, 250, 265, 261, 247,
            // 252, 256, 238, 244, 262, 243,
            // 253, 249, 251, 240, 241, 258,
            // 248, 257, 255, 245, 267, 246,
            // 254, 260, 242, 263, 237,
        // ];
        // bouquets
        if(1) {
            //$pids = [
                // 1697,
                // 1698, 1959, 1699, 1960,
                // 1700, 1961, 1701, 1962, 1702,
                // 1704, 1705, 1706, 1707, 1703,
                // 1708, 1709, 1710, 1711, 1712,
                // 1713, 1714, 1715, 1716, 1717, 1718,
                // 1719, 1720, 1721, 1722, 1723, 1724,
                // 1725, 1726, 1727, 2092, 1728,
                // 1729, 1730, 1738, 1951, 1935,
                // 1731, 1955, 1732, 1950, 1733, 1954,
                // 1734, 1735, 1736, 1737, 1739, 1740,
                // 1930, 1741, 1937, 1742, 2091,
                // 1948, 1945, 1743, 1940, 1744,
                // 1944, 1745, 1746, 1750, 1949, 1747,
                // 1957, 1748, 1752, 1753, 1754, 1755,
                // 1756, 1757, 1758, 1759, 1760,
                // 1761, 1762, 1763, 1764, 1939, 1943,
                // 1931, 1947, 1765, 1766, 2090,
                // 1953, 1767, 1768, 1934, 1936,
                // 1769, 1770, 1952, 1956, 1771, 1772,
                // 1942, 1932, 1773, 1933, 1774, 1941,
                // 1775, 1776, 1946, 1777, 1778,
                // 1779, 1780, 1781, 1938, 1782,
                // 1958, 1783, 1784, 1785, 1786, 1787,
            //];

        }

        // wedding decor
        // $pids = [
            // 303,
            // 304, 305, 306, 307, 308,
            // 309, 310, 311, 312, 313, 314,
            // 315, 316, 317, 318, 319, 320,
            // 321, 322, 323, 324, 325, 326,
            // 327, 328, 329, 330, 331, 332,
            // 333, 334, 335, 336, 337, 338,
            // 339, 340, 341, 342, 343, 344,
            // 345, 346, 347, 348, 349, 350,
            // 351, 352, 353, 354, 355, 356,
            // 357, 358, 359, 360, 361, 362,
            // 363, 364, 365, 366, 367, 368,
            // 369, 370, 371, 372, 373, 374,
            // 375, 376, 377, 378, 379, 380,
            // 382, 383, 384, 385, 386, 387,
            // 388, 389, 391, 392, 393, 394,
            // 395, 396, 398, 399, 400, 401,
            // 402, 403, 404, 405, 409, 410,
            // 411, 412, 413, 414, 415, 416,
            // 417, 418, 419, 420, 421, 422,
            // 423, 424, 425, 426, 427, 428,
            // 429, 431, 430, 432, 433, 434,
            // 435, 436, 437, 438, 439, 440,
            // 441, 442, 443, 444, 445, 446,
            // 447, 448, 449, 450, 451, 452,
        // ];

        $pids = [
            // 19,
            // 15, 12, 11, 10, 13, 14,
            // 669, 623, 640, 509, 20, 655, 620,
            // 631, 664, 644, 665, 651, 594, 634,
            // 673, 625, 21, 638, 548, 517, 552,
            // 516, 493, 495, 520, 475, 502, 22,
            // 538, 457, 460, 478, 494, 513, 555,
            // 581, 536, 606, 23, 24, 17, 18,
            // 16, 25, 612, 26, 27, 28, 530,
            // 508, 533, 656, 30, 32, 29, 546,
            // 465, 468, 501, 681, 653, 31, 522,
            // 660, 676, 679, 588, 498, 33, 553,
            // 627, 470, 567, 583, 565, 591, 34,
            // 35, 36, 518, 456, 568, 302, 486,
            // 37, 657, 688, 529, 609, 582, 590,
            // 658, 600, 686, 491, 38, 549, 496,
            // 510, 458, 488, 514, 541, 544, 572,
            // 39, 573, 597, 598, 661, 557, 473,
            // 624, 40, 41, 42, 43, 44, 45,
            // 46, 487, 489, 506, 682, 47,
            // 48, 645, 505, 497, 539, 507,
            // 527, 49, 659, 671, 675, 574, 599,
            // 639, 512, 464, 471, 476, 50, 301,
            // 485, 499, 500, 528, 566, 519, 662,
            // 672, 472, 663, 51, 646, 649, 643, 578,
            // 523, 575, 545, 554, 616, 622, 52, 53,
            // 54, 55, 604, 650, 56, 59, 60,
            // 61, 62, 63, 64, 685, 300, 621,
            // 667, 571, 628, 611, 614, 666, 65,
            // 605, 580, 593, 678, 684, 687,
            // 683, 674, 608, 610, 66, 455, 540,
            // 526, 626, 668, 619, 670, 462,
            // 542, 484, 67, 592, 654, 463, 469,
            // 492, 569, 579, 607, 515, 596,
            // 68, 521, 477, 589, 69, 70, 57,
            // 58, 71, 74, 75, 76, 618, 78,
            // 79, 80, 633, 550, 677, 81, 680,
            // 482, 587, 480, 483, 524, 454, 461,
            // 481, 82, 490, 534, 535, 453, 585,
            // 570, 577, 467, 630, 641, 122, 648,
            // 652, 511, 479, 602, 537, 466, 551,
            // 84, 85, 86, 72, 73,
        ];
        exit;

        // echo '$pids = [';
        // foreach($products as $product) {
        //     echo $product->ID.",<br/>";
        // }
        // echo "]";
        // exit;

        // $typeid = 3; // букеты
        $typeid = 9;
        foreach($pids as $id) {
           $old_product = EshopMgr::GetInstance()->GetProduct($id);

           echo $old_product->Name."<br>";

           $Data = array(
                'Name'           => $old_product->Name,
                'TypeID'         => $typeid,
                // 'IsAdditional'   => $IsAdditional,
                // 'IsVisible'   => $IsVisible,
                // 'IsMain'      => $IsMain,
                // 'IsAvailable' => $IsAvailable,

                // 'ShortDesc'      => $ShortDesc,
                'Text'           => $old_product->Text,
                'SeoTitle'       => $old_product->SeoTitle,
                'SeoDescription' => $old_product->SeoDescription,
                'SeoKeywords'    => $old_product->SeoKeywords,
                // Только для роз
                'Count'          => 25,
                'Length'         => 40,
            );

            $product = new Product($Data);
            $product->Update();

            // Загрузка фоток.
            $arr_photos = [];
            if($old_product->LogotypeSmall)
            {
                $photofile = $CONFIG['engine_path'].$old_product->LogotypeSmall['f'];
                $photosize = filesize($photofile);
                $_FILES["PhotoSmall"]["name"] = $photofile;
                $_FILES["PhotoSmall"]["tmp_name"] = $photofile;
                $_FILES["PhotoSmall"]["size"] = $photosize;
                $_FILES["PhotoSmall"]["type"] = "image/jpeg";
                $_FILES["PhotoSmall"]["error"] = UPLOAD_ERR_OK;

                $arr_photos['PhotoSmall'] = ['PhotoSmall'];
            }

            if($old_product->LogotypeBig)
            {
                $photofile = $CONFIG['engine_path'].$old_product->LogotypeBig['f'];
                $photosize = filesize($photofile);
                $_FILES["PhotoBig"]["name"] = $photofile;
                $_FILES["PhotoBig"]["tmp_name"] = $photofile;
                $_FILES["PhotoBig"]["size"] = $photosize;
                $_FILES["PhotoBig"]["type"] = "image/jpeg";
                $_FILES["PhotoBig"]["error"] = UPLOAD_ERR_OK;

                $arr_photos['PhotoBig'] = ['PhotoBig'];
            }

            if($old_product->Photo)
            {
                $photofile = $CONFIG['engine_path'].$old_product->Photo['f'];
                $photosize = filesize($photofile);
                $_FILES["photo"]["name"] = $photofile;
                $_FILES["photo"]["tmp_name"] = $photofile;
                $_FILES["photo"]["size"] = $photosize;
                $_FILES["photo"]["type"] = "image/jpeg";
                $_FILES["photo"]["error"] = UPLOAD_ERR_OK;
                // Для отображения доп. товаров в корзине (142x122px)

                // $arr_photos['PhotoBig'] = ['PhotoBig'];
            }

            if($old_product->PhotoOffer)
            {
                $photofile = $CONFIG['engine_path'].$old_product->PhotoOffer['f'];
                $photosize = filesize($photofile);
                $_FILES["PhotoSlider"]["name"] = $photofile;
                $_FILES["PhotoSlider"]["tmp_name"] = $photofile;
                $_FILES["PhotoSlider"]["size"] = $photosize;
                $_FILES["PhotoSlider"]["type"] = "image/jpeg";
                $_FILES["PhotoSlider"]["error"] = UPLOAD_ERR_OK;

                $arr_photos['PhotoSlider'] = ['PhotoBig'];
            }

            // $arr_photos = array(
            //     'PhotoSmall' => array('PhotoSmall'), // Фото маленькое
            //     'PhotoBig' => array('PhotoBig'), // Фото большое
            //     'PhotoAdd' => array('PhotoAdd'), // Фото для доп. товара в корзине
            //     'PhotoSlider' => array('PhotoSlider'), // Фото для слайдера на главной
            // );

            foreach ($arr_photos as $key => $photos)
            {
                foreach ($photos as $photoName)
                {
                    $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                    if ($del_file || is_file($_FILES[$key]['tmp_name']))
                        $product->$photoName = null;
                    try
                    {
                        $product->Upload($key, $photoName);
                    }

                    catch(MyException $e)
                    {
                        if( $e->getCode() >  0 )
                            UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                        else
                            UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                        $product->$photoName = null;
                        return false;
                    }
                }
            }

            $product->Update();

            // gallery uploading
            $filter = array(
                'flags' => array(
                    'objects' => true,
                    'ProductID' => $old_product->ID,
                ),
                'calc' => true,
            );

            list($photos, $count) = OldProductPhotoMgr::getInstance()->GetPhotos($filter);

            foreach($photos as $photo) {
                // echo $photo->PhotoSmall['f']."<br>";
                // echo $photo->PhotoBig['f']."<br>";
                // echo $photo->Photo['f']."<br>";

                $arr_photos = [];
                if($photo->PhotoSmall)
                {
                    $photofile = $CONFIG['engine_path'].$photo->PhotoSmall['f'];
                    $photosize = filesize($photofile);
                    $_FILES["PhotoSmall"]["name"] = $photofile;
                    $_FILES["PhotoSmall"]["tmp_name"] = $photofile;
                    $_FILES["PhotoSmall"]["size"] = $photosize;
                    $_FILES["PhotoSmall"]["type"] = "image/jpeg";
                    $_FILES["PhotoSmall"]["error"] = UPLOAD_ERR_OK;

                    $arr_photos['PhotoSmall'] = ['PhotoSmall'];
                }

                if($photo->PhotoBig)
                {
                    $photofile = $CONFIG['engine_path'].$photo->PhotoBig['f'];
                    $photosize = filesize($photofile);
                    $_FILES["PhotoMiddle"]["name"] = $photofile;
                    $_FILES["PhotoMiddle"]["tmp_name"] = $photofile;
                    $_FILES["PhotoMiddle"]["size"] = $photosize;
                    $_FILES["PhotoMiddle"]["type"] = "image/jpeg";
                    $_FILES["PhotoMiddle"]["error"] = UPLOAD_ERR_OK;

                    $_FILES["PhotoLarge"]["name"] = $photofile;
                    $_FILES["PhotoLarge"]["tmp_name"] = $photofile;
                    $_FILES["PhotoLarge"]["size"] = $photosize;
                    $_FILES["PhotoLarge"]["type"] = "image/jpeg";
                    $_FILES["PhotoLarge"]["error"] = UPLOAD_ERR_OK;

                    $arr_photos['PhotoMiddle'] = ['PhotoMiddle'];
                    $arr_photos['PhotoLarge'] = ['PhotoLarge'];
                }

                if($photo->Photo)
                {
                    $photofile = $CONFIG['engine_path'].$photo->Photo['f'];
                    $photosize = filesize($photofile);
                    $_FILES["Photo"]["name"] = $photofile;
                    $_FILES["Photo"]["tmp_name"] = $photofile;
                    $_FILES["Photo"]["size"] = $photosize;
                    $_FILES["Photo"]["type"] = "image/jpeg";
                    $_FILES["Photo"]["error"] = UPLOAD_ERR_OK;

                    $arr_photos['Photo'] = ['Photo'];
                }

                $Data = array(
                    'ProductID'  => $product->ID,
                    'Name'       => $photo->Name,
                    'AltText'    => $photo->AltText,
                    'Title'      => $photo->Title,
                    'IsVisible'  => $photo->IsVisible,
                    //'IsLightbox' => $IsLightbox,
                );

                $new_photo = new ProductPhoto($Data);

                foreach ($arr_photos as $key => $photos)
                {
                    foreach ($photos as $photoName)
                    {
                        $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                        if ($del_file || is_file($_FILES[$key]['tmp_name']))
                            $new_photo->$photoName = null;
                        try
                        {
                            $new_photo->Upload($key, $photoName);
                        }

                        catch(MyException $e)
                        {
                            if( $e->getCode() >  0 )
                            {
                                UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                            }
                            else
                                UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                            $new_photo->$photoName = null;
                            return false;
                        }
                    }
                }

                $new_photo->Update();
            }


        }

        exit;
    }

    private function _GetCatalog()
    {
        global $DCONFIG, $CONFIG;

        $catalog = $this->catalogMgr->GetCatalog();

        return STPL::Fetch('admin/modules/catalog/catalog_list', array(
            'catalog' => $catalog,
            'section_id' => $this->_id,
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetService()
    {
        global $DCONFIG, $CONFIG;
        $type_id = 3;

        $filter = array(
            'flags' => array(
                'TypeID' => $type_id,
                'IsVisible' => -1,
                'CatalogID' => $this->_id,
                'all' => true,
                'with' => array('AreaRefs'),
                'objects' => true,
            ),
            'dbg' => 0,
        );

        $products = $this->catalogMgr->GetProducts($filter);
        foreach($products as $product) {
            // echo $product->name."<br>";
            $product->CachePrice($this->_id);
        }
echo "OK"; exit;
        // foreach($products as $product) {
        //     $data = array(
        //         'Name'          => 'состав',
        //         'ProductID'     => $product->ID,
        //     );

        //     $type = new Type($data);
        //     $type->Update();

        //     $RefParams = array(
        //         'SectionID' => $this->_id,
        //         'IsDefault' => 1,
        //         'IsVisible' => 1,
        //     );

        //     $type->UpdateTypeAreaRef($RefParams);
        // }

        exit;
        echo 1;
    }

    private function _GetProducts()
    {
        global $DCONFIG, $CONFIG;

        $page = App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);
        $type_id = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);
        $isvisible  = App::$Request->Get['isvisible']->Enum(-1, array(-1,0,1), Request::UNSIGNED_NUM);
        $isavailable  = App::$Request->Get['isavailable']->Enum(-1, array(-1,0,1), Request::UNSIGNED_NUM);

        $field  = App::$Request->Get['field']->Enum('name', ['name', 'article', 'isvisible', 'isavailable']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'TypeID' => $type_id,
                'IsVisible' => $isvisible,
                'IsAvailable' => $isavailable,
                'CatalogID' => $this->_id,
                'all' => true,
                'with' => array('AreaRefs'),
                'objects' => true,
            ),
            'field' => [$field],
            'dir' => [$dir],
            'dbg' => 0,
        );

        $products = $this->catalogMgr->GetProducts($filter);

        return STPL::Fetch('admin/modules/catalog/products_list', array(
            'products'    => $products,
            'isvisible'   => $isvisible,
            'isavailable' => $isavailable,
            'type_id'     => $type_id,
            'section_id'  => $this->_id,
            'page'        => $page,
            'sections'    => $this->catalogMgr->GetCatalog(),
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetProductNew()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();
        $type_id = App::$Request->Get['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $form['TypeID']     = $type_id;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']            = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
            $form['IsVisible']       = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['InSlider']        = App::$Request->Post['InSlider']->Enum(0, array(0,1));
            $form['IsShare']         = App::$Request->Post['IsShare']->Enum(0, array(0,1));
            $form['IsMain']          = App::$Request->Post['IsMain']->Enum(0, array(0,1));
            $form['IsAvailable']     = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['IsHit']           = App::$Request->Post['IsHit']->Enum(0, array(0,1));
            $form['IsNew']           = App::$Request->Post['IsNew']->Enum(0, array(0,1));
            $form['ShortDesc']       = App::$Request->Post['ShortDesc']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
            $form['Text']            = App::$Request->Post['Text']->Value();
            $form['CompositionText'] = App::$Request->Post['CompositionText']->Value();
            $form['Theme']           = App::$Request->Post['Theme']->Enum(0, array_keys(CatalogMgr::$THEMES));
            $form['Article']         = App::$Request->Post['Article']->Value();

            $form['Count']           = App::$Request->Post['Count']->Int(0, Request::UNSIGNED_NUM);
            $form['Length']          = App::$Request->Post['Length']->Int(0, Request::UNSIGNED_NUM);

            $form['SeoTitle']       = App::$Request->Post['SeoTitle']->Value();
            $form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
            $form['SeoKeywords']    = App::$Request->Post['SeoKeywords']->Value();
            // $form['SeoText']        = App::$Request->Post['SeoText']->Value();
        }
        else
        {
            $form['Name']            = '';
            $form['Article']         = '';
            $form['IsVisible']       = 0;
            $form['InSlider']        = 0;
            $form['IsMain']          = 0;
            $form['IsShare']         = 0;
            $form['IsHit']           = 0;
            $form['IsNew']           = 0;
            $form['IsAvailable']     = 0;
            $form['Length']          = 0;
            $form['Count']           = 0;
            $form['ShortDesc']       = '';
            $form['Text']            = '';
            $form['CompositionText'] = '';
            $form['Theme']           = 0;
            $form['SeoTitle']        = '';
            $form['SeoDescription']  = '';
            $form['SeoKeywords']     = '';
            // $form['SeoText']         = '';
        }

        $category = $this->catalogMgr->GetCategory($type_id);
        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
            ],
        ];

        $lens = $this->catalogMgr->GetLens($filter);

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
            ],
        ];

        return STPL::Fetch('admin/modules/catalog/edit_product', array(
            'form'        => $form,
            'action'      => 'new_product',
            'section_id'  => $this->_id,
            'sections'    => $this->catalogMgr->GetCatalog(),
            'category'    => $category,
            'lens'        => $lens,
        ));
    }

    private function _GetProductEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;


        if(App::$User->IsInRole('u_bouquet_type_editor')) {
            Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$TypeID.'&id='.$ProductID);
        } elseif(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $TypeID  = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);


        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID'] = $TypeID;
        $form['PhotoSmall']            = $product->PhotoSmall;
        $form['PhotoCart']             = $product->PhotoCart;
        $form['PhotoCartSmall']        = $product->PhotoCartSmall;
        $form['PhotoAdd']              = $product->PhotoAdd;
        $form['PhotoSlider']           = $product->PhotoSlider;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']            = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
            $form['TypeID']          = App::$Request->Post['TypeID']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));
            $form['IsVisible']       = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['InSlider']        = App::$Request->Post['InSlider']->Enum(0, array(0,1));
            $form['IsMain']          = App::$Request->Post['IsMain']->Enum(0, array(0,1));
            $form['IsShare']         = App::$Request->Post['IsShare']->Enum(0, array(0,1));
            $form['IsHit']           = App::$Request->Post['IsHit']->Enum(0, array(0,1));
            $form['IsNew']           = App::$Request->Post['IsNew']->Enum(0, array(0,1));
            $form['IsAvailable']     = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['ShortDesc']       = App::$Request->Post['ShortDesc']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
            $form['Text']            = App::$Request->Post['Text']->Value();
            $form['CompositionText'] = App::$Request->Post['CompositionText']->Value();
            $form['Theme']           = App::$Request->Post['Theme']->Enum(0, array_keys(CatalogMgr::$THEMES));
            $form['Article']         = App::$Request->Post['Article']->Value();

            $form['Count']           = App::$Request->Post['Count']->Int(0, Request::UNSIGNED_NUM);
            $form['Length']          = App::$Request->Post['Length']->Int(0, Request::UNSIGNED_NUM);

            $form['SeoTitle']        = App::$Request->Post['SeoTitle']->Value();
            $form['SeoDescription']  = App::$Request->Post['SeoDescription']->Value();
            $form['SeoKeywords']     = App::$Request->Post['SeoKeywords']->Value();
        }
        else
        {
            $form['Name']            = $product->Name;
            $form['TypeID']          = $product->TypeID;
            $form['Text']            = $product->Text;
            $form['CompositionText'] = $product->CompositionText;
            $form['Theme']           = $product->Theme;
            $form['Article']         = $product->Article;

            $form['Length']          = $product->Length;
            $form['Count']           = $product->Count;

            $form['SeoTitle']        = $product->SeoTitle;
            $form['SeoDescription']  = $product->SeoDescription;
            $form['SeoKeywords']     = $product->SeoKeywords;

            $areaRefs            = $product->GetAreaRefs($this->_id);
            $form['IsVisible']   = $areaRefs['IsVisible'];
            $form['IsMain']      = $areaRefs['IsMain'];
            $form['IsShare']     = $areaRefs['IsShare'];
            $form['IsAvailable'] = $areaRefs['IsAvailable'];
            $form['InSlider']    = $areaRefs['InSlider'];
            $form['IsHit']       = $areaRefs['IsHit'];
            $form['IsNew']       = $areaRefs['IsNew'];
        }

        $category = $product->category;
        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'ProductID' => $product->id,
            ],
        ];

        $lens = $this->catalogMgr->GetLens($filter);

        return STPL::Fetch('admin/modules/catalog/edit_product', array(
            'form'       => $form,
            'action'     => 'edit_product',
            'section_id' => $this->_id,
            'sections'   => $this->catalogMgr->GetCatalog(),
            'category'   => $category,
            'lens'       => $lens,
            'product'    => $product,
        ));
    }

    private function _GetProductFiltersEdit()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        $fParams = $product->GetFilterParam();
        $filters = $this->catalogMgr->GetFilters();

        return STPL::Fetch('admin/modules/catalog/edit_product_filters', array(
            'action'     => 'edit_filters',
            'form'       => $form,
            'filters'    => $filters,
            'fParams'    => $fParams,
            'section_id' => $this->_id,
            'product'    => $product,
            'sections'   => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetProductCompositionEdit()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false
            && (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;


        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $tid    = App::$Request->Get['tid']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $type = $this->catalogMgr->GetType($tid);

        if ($type === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;
        $form['tid']        = $type->ID;


        $only_visible = -1;
        $elements = $type->GetElements($this->_id, $only_visible);

        // $filter = [
        //     'flags' => [
        //         'objects' => true,
        //         'CatalogID' => $this->_id,
        //     ],
        //     'dbg' => 0,
        // ];

        $filter = array(
            'flags' => array(
                'IsVisible' => -1,
                'CatalogID' => $this->_id,
                'all' => true,
                'with' => array('AreaRefs'),
                'objects' => true,
            ),
            'dbg' => 0,
        );

        $members = $this->catalogMgr->GetMembers($filter);

        return STPL::Fetch('admin/modules/catalog/edit_product_composition', array(
            'action'     => 'edit_composition',
            'form'       => $form,
            'elements'   => $elements,
            'members'    => $members,
            'section_id' => $this->_id,
            'product'    => $product,
            'category'   => $product->category,
            'sections'   => $this->catalogMgr->GetCatalog(),
            'type'       => $type,
        ));
    }

    private function _GetProductTypes()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        $only_visible = false;
        $types = $product->GetTypes($this->_id, $only_visible);

        return STPL::Fetch('admin/modules/catalog/product_types', array(
            'action'        => 'types',
            'form'          => $form,
            'types'         => $types,
            'section_id'    => $this->_id,
            'product'       => $product,
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetProductTypeNew() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault']      = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']           = '';
            $form['IsVisible']      = 1;
            $form['IsDefault']      = 0;
        }

        return STPL::Fetch('admin/modules/catalog/edit_product_type', array(
            'section_id'    => $this->_id,
            'action' => 'product_type_new',
            'form' => $form,
            'product' => $product,
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetProductTypeEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $TypeID = App::$Request->Get['tid']->Int(0, Request::UNSIGNED_NUM);

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_product');
        }

        $type = $this->catalogMgr->GetType($TypeID);
        if ($type === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_type');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['tid']            = App::$Request->Post['tid']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault']      = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        }
        else
        {
            $form['tid']            = $type->ID;
            $form['Name']           = $type->Name;
            $form['IsVisible']      = $type->IsVisible;
            $form['IsDefault']      = $type->IsDefault;
        }

        return STPL::Fetch('admin/modules/catalog/edit_product_type', array(
            'section_id'    => $this->_id,
            'action' => 'product_type_edit',
            'form' => $form,
            'product' => $product,
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _ToggleVisibleProductType()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['tid']->Int(0, Request::UNSIGNED_NUM);
        $product_id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $section_id = App::$Request->Get['section_id']->Int(0, Request::UNSIGNED_NUM);

        $type = $this->catalogMgr->GetType($id);

        $product = $this->catalogMgr->GetProduct($product_id);

        if ($type === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $areaRefs = $type->GetTypeAreaRefs($this->_id);

        $IsVisible = !(int) $areaRefs['IsVisible'];

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsVisible' => $IsVisible,
        );
        $type->UpdateTypeAreaRef($RefParams);

        $product->CachePrice($section_id);

        $only_visible = true;
        $types = $product->GetTypes($this->_id, $only_visible);

        if(is_null($types)) {
            $areaRefs = $product->GetAreaRefs($this->_id);

            $filter['TypeIds'] = $product->category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $ord =  $this->catalogMgr->GetLastOrd($filter);
            $ord++;

            $RefParams = [
                'SectionID' => $this->_id,
            ];

            if(!is_null($ord)) {
                $RefParams['Ord'] = $ord;
                $product->UpdateAreaRef($RefParams);
            }
        }

        $json->send(array(
            'status' => 'ok',
            'visible' => $IsVisible,
            'typeid' => $id,
        ));
        exit;
    }

    private function _ToggleDefaultProductType()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['tid']->Int(0, Request::UNSIGNED_NUM);
        $type = $this->catalogMgr->GetType($id);

        if ($type === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $product = $this->catalogMgr->GetProduct($type->ProductID);

        if ($product === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $product->DropDefaultType($this->_id);
        $value = 1;
        $RefParams = array(
            'SectionID' => $this->_id,
            'IsDefault' => $value,
        );

        $type->UpdateTypeAreaRef($RefParams);
        $product->CachePrice($this->_id);

        $json->send(array(
            'status' => 'ok',
            'default' => $value,
            'typeid' => $id,
        ));
        exit;
    }

    private function _PostProductType()
    {
        global $CONFIG, $OBJECTS;

        $tid    = App::$Request->Post['tid']->Int(0, Request::UNSIGNED_NUM);

        $ProductID  = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return false;
        }

        $Name           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsDefault      = App::$Request->Post['IsDefault']->Enum(0, array(0,1));

        if ($tid > 0) {
            $type = $this->catalogMgr->GetType($tid);
            if ($type === null) {
                UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
                return ;
            }

            $type->Name             = $Name;
            $type->IsVisible        = $IsVisible;
            $type->IsDefault        = $IsDefault;
        } else {

            $Data = array(
                'Name'          => $Name,
                'IsVisible'     => $IsVisible,
                'IsDefault'     => $IsDefault,
                'ProductID'     => $ProductID,
            );

            $type = new Type($Data);
        }

        if ($IsDefault == 1) {
            $allTypes = true;
            foreach ($product->GetTypes($allTypes) as $dropDefType) {
                $dropDefType->IsDefault = 0;
                $dropDefType->Update();
            }
        }

        $type->Update();

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsDefault' => $IsDefault,
            'IsVisible' => $IsVisible,
        );
        $type->UpdateTypeAreaRef($RefParams);

        return $product->ID;
    }

    private function _PostProductTypeDelete()
    {
        global $OBJECTS;

        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);
        $ProductId = App::$Request->Post['id']->Int(-1, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductId);

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $type = $this->catalogMgr->GetType($id);
                if ($type === null)
                    continue ;

                $type->Remove();
            }
        }

        $product->CachePrice($this->_id);

        $this->_setMessage('Данные удалены.');
        return true;
    }

    private function _PostProductTypesSave()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);
        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);

        $ProductId = App::$Request->Post['id']->Int(-1, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductId);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $type = $this->catalogMgr->GetType($id);
                if ($type === null)
                    continue ;

                $type->Ord = $orders[$type->ID];
                $type->Update();

                // $areaRefs = $type->GetTypeAreaRefs($this->_id);

                // $RefParams = array(
                //  'SectionID' => $this->_id,
                //  'Ord' => $orders[$type->ID],
                // );
                // $type->UpdateTypeAreaRef($RefParams);
            }
        }

        $product->CachePrice($this->_id);

        $this->_setMessage();
        return true;
    }

    private function _GetAjaxToggleProductVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $product->CachePrice($this->_id);

        $areaRefs = $product->GetAreaRefs($this->_id);

        $IsVisible = !(int) $areaRefs['IsVisible'];
        if($IsVisible == 0) {
            $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $ord =  $this->catalogMgr->GetLastOrd($filter);
            $ord++;
        }

        $RefParams = [
            'SectionID' => $this->_id,
            'IsVisible' => $IsVisible,
        ];

        if(!is_null($ord))
            $RefParams['Ord'] = $ord;

        $product->UpdateAreaRef($RefParams);

        $json->send(array(
            'status' => 'ok',
            'visible' => $IsVisible,
            'productid' => $ProductID,
        ));
        exit;
    }

    private function _GetAjaxToggleProductMain()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);

        if ($product === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $areaRefs = $product->GetAreaRefs($this->_id);

        $IsMain = !(int) $areaRefs['IsMain'];

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsMain' => $IsMain,
        );
        $product->UpdateAreaRef($RefParams);

        $json->send(array(
            'status' => 'ok',
            'main' => $IsMain,
            'productid' => $ProductID,
        ));
        exit;
    }

    private function _GetAjaxSendSurcharge()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $sum = App::$Request->Get['sum']->Int(0, Request::UNSIGNED_NUM);
        $orderId = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $msg = App::$Request->Get['msg']->Int(0, Request::UNSIGNED_NUM);

        if($sum <= 0) {
            $json->send(array(
                'status' => 'ok',
                'message' => 'ОШИБКА! Сумма должна быть больше 0',
            ));
            exit;
        }

        $order = $this->catalogMgr->GetOrder($orderId);

        if(!$order) {
            $json->send(array(
                'status' => 'ok',
                'message' => 'ОШИБКА! Заказ не найден',
            ));
            exit;
        }

        $newOrder = clone $order;
        $newOrder->orderID = null;
        $newOrder->TotalPrice = $sum;
        $newOrder->Comment = 'Доплата к заказу <a href="?section_id=' . $this->_id .'&action=edit_order&id=' . $order->OrderID . '">' . $order->OrderID . '</a>';

        $newOrder->PaymentStatus = CatalogMgr::PS_NOPAID;
        $newOrder->Status = CatalogMgr::OS_NEW;
        $newOrder->PaymentType = CatalogMgr::PT_ONLINE;
        $newOrder->Update();

        $msg = STPL::Fetch('modules/catalog/mail/surcharge', [
            'domain' => $_SERVER['HTTP_HOST'],
            'date' => date('d.m.Y'),
            'sum' => $sum,
            'id' => $order->OrderID,
            'newId' => $newOrder->OrderId,
            'msg' => str_replace('{{sum}}', '<b>' . $sum . '</b>', self::$SURCHARGE_CAUSES[$msg]),
        ]);

        LibFactory::GetStatic('mailsender');
        $mail = new MailSender();
        $mail->AddAddress('from', 'no-reply@rosetta.florist', "Служба уведомлений", 'utf-8');
        $mail->AddHeader('Subject', 'Доплата за заказ №' . $order->OrderID, 'utf-8');
        $mail->body_type = MailSender::BT_HTML;
        $mail->AddAddress('to', $newOrder->CustomerEmail);
        $mail->AddBody('text', $msg, MailSender::BT_HTML, 'utf-8');
        $mail->SendImmediate();

        $json->send(array(
            'status' => 'ok',
            'message' => 'УСПЕШНО! Ссылка для оплаты отправлена',
        ));
        exit;
    }

    private function _GetAjaxToggleProductAvailable()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);
        $product->CachePrice($this->_id);

        if ($product === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $areaRefs = $product->GetAreaRefs($this->_id);

        $IsAvailable = !(int) $areaRefs['IsAvailable'];
        if($IsAvailable == 0) {
            $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $ord =  $this->catalogMgr->GetLastOrd($filter);
            $ord++;
        }

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsAvailable' => $IsAvailable,
        );

        if(!is_null($ord))
            $RefParams['Ord'] = $ord;

        $product->UpdateAreaRef($RefParams);

        $json->send(array(
            'status' => 'ok',
            'available' => $IsAvailable,
            'productid' => $ProductID,
        ));
        exit;
    }

    private function _GetProductDelete()
    {
        $ProductID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($ProductID);
        if ($product === null)
            return;

        $product->Remove();
        return;
    }

    private function _PostProductsOrderSave()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        foreach($orders as $productId => $ord)
        {
            $product = $this->catalogMgr->GetProduct($productId);
            if ($product === null)
                continue;

            $areaRefs = $product->GetAreaRefs($this->_id);

            $RefParams = array(
                'SectionID' => $this->_id,
                'Ord' => $ord,
            );

            $product->UpdateAreaRef($RefParams);

            // $product->Ord = $ord;
            // $product->Update();
        }
        return true;
    }

    private function _PostProduct()
    {
        global $CONFIG, $OBJECTS;

        $ProductID      = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $TypeID          = App::$Request->Post['TypeID']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $Name            = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
        // $IsVisible       = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsVisible       = 1;
        $InSlider        = App::$Request->Post['InSlider']->Enum(0, array(0,1));
        $IsShare         = App::$Request->Post['IsShare']->Enum(0, array(0,1));
        $IsHit           = App::$Request->Post['IsHit']->Enum(0, array(0,1));
        $IsNew           = App::$Request->Post['IsNew']->Enum(0, array(0,1));
        $IsAvailable     = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $Theme           = App::$Request->Post['Theme']->Enum(0, array_keys(CatalogMgr::$THEMES));
        $Article         = App::$Request->Post['Article']->Value();

        $Length          = App::$Request->Post['Length']->Int(0, Request::UNSIGNED_NUM);
        $Count           = App::$Request->Post['Count']->Int(0, Request::UNSIGNED_NUM);

        $ShortDesc       = App::$Request->Post['ShortDesc']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
        $Text            = App::$Request->Post['Text']->Value();
        $CompositionText = App::$Request->Post['CompositionText']->Value();

        $SeoTitle        = App::$Request->Post['SeoTitle']->Value();
        $SeoDescription  = App::$Request->Post['SeoDescription']->Value();
        $SeoKeywords     = App::$Request->Post['SeoKeywords']->Value();

        //$NameID = strtolower($NameID);
        //$NameID = preg_replace(array("@\s@","@\-@"), array("_","_"), $NameID);
        //$NameID = preg_replace("@[^a-z\_0-9]@", "", $NameID);

        if($TypeID == 0)
            UserError::AddErrorIndexed('Type', ERR_A_PRODUCT_EMPTY_TYPE);

        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_PRODUCT_EMPTY_TITLE);

        if(strlen($ShortDesc)>380)
            UserError::AddErrorIndexed('ShortDesc', ERR_A_PRODUCT_LONG_SHORTDESC);

        $category = $this->catalogMgr->GetCategory($TypeID);

        if($category->Kind == CatalogMgr::CK_ROSE)
        {
             if(intval($Count) <= 0)
             {
                 UserError::AddErrorIndexed('RoseCount', ERR_A_PRODUCT_ROSE_COUNT_EMPTY);
             }
        }

        if(UserError::IsError())
        {
            return false;
        }

        if($ProductID > 0)
        {
            $product = $this->catalogMgr->GetProduct($ProductID);

            if ($product === null) {
                UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
                return false;
            }

            $product->Name            = $Name;
            $product->Article         = $Article;
            $product->TypeID          = $TypeID;
            $product->Theme           = $Theme;
            $product->ShortDesc       = $ShortDesc;
            $product->Count           = $Count;
            $product->Length          = $Length;
            $product->Text            = $Text;
            $product->CompositionText = $CompositionText;
            $product->SeoTitle        = $SeoTitle;
            $product->SeoDescription  = $SeoDescription;
            $product->SeoKeywords     = $SeoKeywords;
        }
        else
        {
            $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $Ord =  $this->catalogMgr->GetLastOrd($filter);
            $Ord++;

            $Data = array(
                'Name'            => $Name,
                'Article'         => $Article,
                'TypeID'          => $TypeID,
                'Count'           => $Count,
                'Lenght'          => $Length,
                'Theme'           => $Theme,
                'ShortDesc'       => $ShortDesc,
                'Text'            => $Text,
                'CompositionText' => $CompositionText,
                'SeoTitle'        => $SeoTitle,
                'SeoDescription'  => $SeoDescription,
                'SeoKeywords'     => $SeoKeywords,
            );

            $product = new Product($Data);
        }

        $arr_photos = [
            'PhotoSmall'     => ['PhotoSmall'],
            'PhotoBig'       => ['PhotoBig'],
            'PhotoCart'      => ['PhotoCart'],
            'PhotoCartSmall' => ['PhotoCartSmall'],
            'PhotoAdd'       => ['PhotoAdd'],
            'PhotoSlider'    => ['PhotoSlider'],
        ];

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $product->$photoName = null;
                try
                {
                    $product->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $product->$photoName = null;
                    return false;
                }
            }
        }

        $product->Update();
        if($IsVisible == 0 || $IsAvailable == 0) {
            $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $Ord =  $this->catalogMgr->GetLastOrd($filter);
            $Ord++;
        }

        $RefParams = [
            'ProductID'   => $product->ID,
            'SectionID'   => $this->_id,
            'IsVisible'   => $IsVisible,
            'InSlider'    => $InSlider,
            'IsAvailable' => $IsAvailable,
            'IsHit'       => $IsHit,
            'IsNew'       => $IsNew,
            'IsShare'       => $IsShare,
        ];

        if(!is_null($Ord))
            $RefParams['Ord'] = $Ord;

        $this->catalogMgr->UpdateAreaRef($RefParams);


        if($ProductID == 0)
        {
            if(in_array($category->Kind, [CatalogMgr::CK_MONO, CatalogMgr::CK_FIXED, CatalogMgr::CK_ROSE])) {

                $data = array(
                    'Name'      => 'состав',
                    'ProductID' => $product->ID,
                );


                $type = new Type($data);
                $type->Update();

                 $RefParams = array(
                    'SectionID' => $this->_id,
                    'IsDefault' => 1,
                    'IsVisible' => 1,
                );

                $type->UpdateTypeAreaRef($RefParams);
            }
        }

        $this->_setMessage();
        $product->CachePrice($this->_id);
        return $product->ID;
    }

    private function _PostProductFiltersEdit() {
        global $CONFIG, $OBJECTS;

        $ProductID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $TypeID             = App::$Request->Post['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));
        $FilterParams       = App::$Request->Post['Filters']->AsArray(array(), Request::INTEGER_NUM);

        if($TypeID == 0)
            UserError::AddErrorIndexed('Type', ERR_A_PRODUCT_EMPTY_TYPE);

        if(UserError::IsError())
            return false;

        if($ProductID > 0) {
            $product = $this->catalogMgr->GetProduct($ProductID);

            if ($product === null) {
                UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
                return false;
            }

            $product->RemoveFilterParam();
            foreach($FilterParams as $filter_id => $v)
            {
                foreach($v as $param => $param_id)
                {
                    $product->AddFilterParam($filter_id, $param_id);
                }
            }

            $this->_setMessage();
        }
    }

    private function _PostProductCompositionEdit() {
        global $CONFIG, $OBJECTS;

        $tid                = App::$Request->Post['tid']->Int(0, Request::UNSIGNED_NUM);
        $ProductID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $TypeID             = App::$Request->Post['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));
        $Elements           = App::$Request->Post['Elements']->AsArray(array(), Request::INTEGER_NUM);
        // $IsVisibleEl        = App::$Request->Post['IsVisibleEl']->AsArray(array(), Request::INTEGER_NUM);
        // $Counts             = App::$Request->Post['ElCount']->AsArray(array(), Request::INTEGER_NUM);
        $Counts             = App::$Request->Post['ElCount']->AsArray(array(), Request::DECIMAL_NUM);
        $IsEditable         = App::$Request->Post['IsEditable']->Int(-1, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($ProductID);
        if($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
        }
        if($TypeID == 0)
            UserError::AddErrorIndexed('Type', ERR_A_PRODUCT_EMPTY_TYPE);

        if(UserError::IsError())
            return false;

        if($tid > 0) {
            $type = $this->catalogMgr->GetType($tid);

            if ($type === null) {
                UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
                return false;
            }

            $type->RemoveElements($this->_id);
            foreach ($Elements as $k => $v)
            {
                $ItemCount = $Counts[$k];
                $editable = intval($IsEditable[$k]);
                $IsEditable == $v? $editable = 1 : $editable = 0;


                $type->AddElement($v, $ItemCount, $this->_id, $editable );/*$visibleel*/
            }
            $product->CachePrice($this->_id);


            $category =  $product->category;

            if($category->Kind == CatalogMgr::CK_ROSE) {
                $price = $product->GetPrice($product->length, $product->count, $this->_id);
            } else {
                $type = $product->default_type;
                if($type === null)
                    $price = 0;
                else
                    $price = $type->GetPrice($this->_id);
            }

            if($price < 500) {

                $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1, 3, 10];
                $filter['SectionID'] = $this->_id;

                $ord = $this->catalogMgr->GetLastOrd($filter);
                $ord++;

                $RefParams = [
                    'SectionID' => $this->_id,
                ];

                if(!is_null($ord))
                    $RefParams['Ord'] = $ord;

                $product->UpdateAreaRef($RefParams);
            }

            $this->_setMessage();
        }

        return $product->id;
    }

    private function _GetFilters()
    {
        global $DCONFIG, $CONFIG;

        $filters = $this->catalogMgr->GetFilters();

        return STPL::Fetch('admin/modules/catalog/filters_list', array(
            'section_id'    => $this->_id,
            'filters' => $filters,
        ));
    }

    private function _GetFilterNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $params = array();
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NameID']         = App::$Request->Post['NameID']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Weight']         = App::$Request->Post['Weight']->Int(0, Request::UNSIGNED_NUM);

            $param_names    = App::$Request->Post['param_name']->AsArray();
            $param_values   = App::$Request->Post['param_value']->AsArray();

            if (is_array($param_names) && count($param_names) > 0)
            {
                foreach($param_names as $k => $v)
                    $params[] = array(
                        'Name' => $v,
                        'Value' => $param_values[$k],
                    );
            }
        }
        else
        {
            $form['NameID']         = '';
            $form['Name']           = '';
            $form['Weight']         = 0;
        }

        return STPL::Fetch('admin/modules/catalog/edit_filter', array(
            'action' => 'new_filter',
            'section_id'    => $this->_id,
            'form' => $form,
            'params' => $params,
        ));
    }

    private function _GetFilterEdit()
    {
        global $DCONFIG, $CONFIG;
        $FilterID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $filter = $this->catalogMgr->GetFilter($FilterID);
        if ($filter === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);

            return STPL::Fetch('admin/modules/catalog/edit_filter');
        }

        // $form['Created'] = $filter->Created;
        // $form['LastUpdated'] = $filter->LastUpdated;
        $form['FilterID'] = $filter->ID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NameID']         = App::$Request->Post['NameID']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Weight']         = App::$Request->Post['Weight']->Int(0, Request::UNSIGNED_NUM);

            $param_ids      = App::$Request->Post['param_id']->AsArray(array(), Request::INTEGER_NUM);
            $param_names    = App::$Request->Post['param_name']->AsArray();
            $param_values   = App::$Request->Post['param_value']->AsArray();
            $param_availability   = App::$Request->Post['param_availability']->AsArray();
            $param_ord   = App::$Request->Post['param_ord']->AsArray();

            if (is_array($param_names) && count($param_names) > 0)
            {
                foreach($param_names as $k => $v)
                    $params[$param_ids[$k]] = array(
                        'Name' => $v,
                        'Value' => $param_values[$k],
                        'IsAvailable' => $param_availability[$k],
                        'Ord' => $param_ord[$k],
                    );
            }
        }
        else
        {
            $form['NameID']     = $filter->NameID;
            $form['Name']       = $filter->Name;
            $form['Weight']     = $filter->Weight;


             $arrFilter = [
                'field' => ['Ord'],
                'dir' => ['ASC'],
            ];
            $params = $filter->GetParams($arrFilter);
        }

        return STPL::Fetch('admin/modules/catalog/edit_filter', array(
            'action'     => 'edit_filter',
            'section_id' => $this->_id,
            'form'       => $form,
            'params'     => $params,
        ));
    }

    private function _PostFilter()
    {
        global $CONFIG, $OBJECTS;

        $FilterID           = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $NameID             = App::$Request->Post['NameID']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $Name               = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $Weight             = App::$Request->Post['Weight']->Int(0, Request::UNSIGNED_NUM);

        $param_ids          = App::$Request->Post['param_id']->AsArray(array(), Request::INTEGER_NUM);
        $param_names        = App::$Request->Post['param_name']->AsArray();
        $param_values       = App::$Request->Post['param_value']->AsArray();
        $param_availability = App::$Request->Post['param_availability']->AsArray();
        $param_ord          = App::$Request->Post['param_ord']->AsArray();

        if (empty($Name))
            UserError::AddErrorIndexed('Name', ERR_A_CATALOG_EMPTY_FILTER_NAME);

        if (empty($NameID))
            UserError::AddErrorIndexed('NameID', ERR_A_CATALOG_EMPTY_FILTER_NAMEID);

        if (empty($param_names))
            UserError::AddErrorIndexed('params', ERR_A_CATALOG_EMPTY_PARAM_FILTER);

        if(UserError::IsError())
            return false;

        if ($FilterID > 0) {
            $filter = $this->catalogMgr->GetFilter($FilterID);

            $filter->NameID = $NameID;
            $filter->Name   = $Name;
            $filter->Weight = $Weight;

            $filter->Update();

            $cur_params = $filter->GetParams();
            foreach($cur_params as $k => $v)
            {
                if (!isset($param_values[$k]))
                    $filter->RemoveParam($k);
            }

            foreach($param_names as $k => $v)
            {
                $options = [
                    'value' => $param_values[$k],
                    'isavailable' => $param_availability[$k],
                    'ord' => $param_ord[$k],
                ];

                if (!isset($param_ids[$k]))
                    // $filter->AddParam($v, $param_values[$k], $param_availability[$k]);
                    $filter->AddParam($v, $options);
                else
                    // $filter->UpdateParam($param_ids[$k], $v, $param_values[$k], $param_availability[$k]);
                    $filter->UpdateParam($param_ids[$k], $v, $options);
            }
        } else {
            $Data = array(
                'Name'          => $Name,
                'NameID'        => $NameID,
                'Weight'        => $Weight,
            );

            $filter = new EFilter($Data);

            $filter->Update();

            foreach($param_names as $k => $v)
                $filter->AddParam($v, $param_values[$k]);
        }

        return true;
    }

    private function _PostFiltersDelete()
    {
        global $OBJECTS;

        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $filter = $this->catalogMgr->GetFilter($id);
                if ($filter === null)
                    continue ;

                $filter->Remove();
            }
        }
    }

    private function _GetDecors()
    {
        global $DCONFIG, $CONFIG;

        $decors = $this->catalogMgr->GetDecors(null, $this->_id);

        return STPL::Fetch('admin/modules/catalog/decors', array(
            'section_id'    => $this->_id,
            'decors' => $decors,
        ));
    }

    private function _GetDecorNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $nodes = $this->catalogMgr->getProductCategories();
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            // $form['NodeType']        = App::$Request->Post['NodeType']->Enum(0, array_keys(EShopMgr::$DECOR_NODE_TYPES));
            $form['NodeType']       = App::$Request->Post['NodeType']->Enum(0, array_keys($nodes));
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

            $DecorFrom              = App::$Request->Post['DecorFrom']->AsArray(array());
            $DecorTo                = App::$Request->Post['DecorTo']->AsArray(array());
            $DecorPrice             = App::$Request->Post['DecorPrice']->AsArray(array());

            $Ranges = array();
            foreach($DecorFrom as $k => $v)
            {
                if (empty($DecorTo[$k]) || $DecorPrice[$k] == "")
                    continue;

                $Ranges[] = array(
                    'from' => $v,
                    'to' => $DecorTo[$k],
                    'price' => $DecorPrice[$k],
                );
            }

            $form['Ranges']         = $Ranges;
        }
        else
        {
            $form['NodeType']       = 0;
            $form['Name']           = '';
            $form['Ranges']         = array();
        }

        return STPL::Fetch('admin/modules/catalog/edit_decor', array(
            'action' => 'new_decor',
            'section_id'    => $this->_id,
            'form' => $form,
            'decors' => $decors,
            'DECOR_NODE_TYPES' => $nodes,
        ));
    }

    private function _GetDecorEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $nodes = $this->catalogMgr->getProductCategories();
        $DecorID    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $decor = $this->catalogMgr->GetDecor($DecorID);
        if ($decor === false)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_decor');
        }

        $form['DecorID'] = $decor['DecorID'];
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NodeType']       = App::$Request->Post['NodeType']->Enum(0, array_keys($nodes));
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

            $DecorFrom              = App::$Request->Post['DecorFrom']->AsArray(array());
            $DecorTo                = App::$Request->Post['DecorTo']->AsArray(array());
            $DecorPrice             = App::$Request->Post['DecorPrice']->AsArray(array());

            $Ranges = array();
            foreach($DecorFrom as $k => $v)
            {
                if (empty($DecorTo[$k]) || $DecorPrice[$k] == "")
                    continue;

                $Ranges[] = array(
                    'from' => $v,
                    'to' => $DecorTo[$k],
                    'price' => $DecorPrice[$k],
                );
            }

            $form['Ranges']         = $Ranges;
        }
        else
        {
            $form['NodeType']       = $decor['NodeType'];
            $form['Name']           = $decor['Name'];
            $form['Ranges']         = $decor['Ranges'];
        }

        return STPL::Fetch('admin/modules/catalog/edit_decor', array(
            'action' => 'edit_decor',
            'section_id'    => $this->_id,
            'form' => $form,
            'decors' => $decors,
            'DECOR_NODE_TYPES' => $nodes,
        ));
    }

    private function _PostDecor()
    {
        global $CONFIG, $OBJECTS;

        $nodes = $this->catalogMgr->getProductCategories();

        $DecorID        = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $NodeType       = App::$Request->Post['NodeType']->Enum(0, array_keys($nodes));

        $DecorFrom              = App::$Request->Post['DecorFrom']->AsArray(array());
        $DecorTo                = App::$Request->Post['DecorTo']->AsArray(array());
        $DecorPrice             = App::$Request->Post['DecorPrice']->AsArray(array());

        $Ranges = array();
        foreach($DecorFrom as $k => $v)
        {
            if (empty($DecorTo[$k]) || $DecorPrice[$k] == "")
                continue;

            $Ranges[] = array(
                'from' => $v,
                'to' => $DecorTo[$k],
                'price' => $DecorPrice[$k],
            );
        }

        if (empty($Name))
            UserError::AddErrorIndexed('Name', ERR_A_CATALOG_EMPTY_MEMBER_NAME);

        if ($NodeType == 0)
            UserError::AddErrorIndexed('NodeType', ERR_A_CATALOG_NOT_SELECTED_NODE_TYPE);

        if (count($Ranges) == 0)
            UserError::AddErrorIndexed('Ranges', ERR_A_CATALOG_NOT_SELECTED_RANGES);

        if(UserError::IsError())
            return false;

        if ($DecorID > 0) {

            $decor = $this->catalogMgr->GetDecor($DecorID);
            if ($decor === false)
            {
                UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
                return;
            }

            $decor['Name']          = $Name;
            $decor['NodeType']      = $NodeType;
            $decor['Ranges']        = $Ranges;

            $this->catalogMgr->UpdateDecor($decor);

        } else {

            $Data = array(
                'Name'          => $Name,
                'NodeType'      => $NodeType,
                'Ranges'        => $Ranges,
                'SectionID'     => $this->_id,
            );

            $this->catalogMgr->AddDecor($Data);
        }

        return true;
    }

    private function _PostDecorDelete()
    {
        global $OBJECTS;

        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $decor = $this->catalogMgr->GetDecor($id);
                if ($decor === false)
                    continue ;

                $this->catalogMgr->RemoveDecor($id);
            }
        }
    }

    private function _GetCompositions()
    {
        if(!App::$User->IsInRole('u_price_changer') &&
            (App::$User->IsInRole('e_adm_execute_section') == false && App::$User->IsInRole('e_adm_execute_users') == false)) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG;

        $field  = App::$Request->Get['field']->Enum('name', ['name', 'article', 'isvisible']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'IsVisible' => -1,
                'objects' => true,
            ),
            'field' => [$field],
            'dir' => [$dir],
            'dbg' => 0,
        );

        $members = $this->catalogMgr->GetMembers($filter);


        return STPL::Fetch('admin/modules/catalog/members', array(
            'section_id' => $this->_id,
            'list'       => $members,
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetMemberNew() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false
            // && App::$User->IsInRole('u_price_changer') == false
            && (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']      = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Article']   = App::$Request->Post['Article']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Price']     = App::$Request->Post['Price']->Dec(0, Request::DECIMAL_NUM);
        }
        else
        {
            $form['Name']      = '';
            $form['IsVisible'] = 1;
            $form['Price']     = 0;
            $form['Article']   = '';
        }

        return STPL::Fetch('admin/modules/catalog/edit_member', array(
            'section_id'    => $this->_id,
            'action' => 'new_member',
            'form' => $form,
        ));
    }

    private function _GetMemberEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false
            // && App::$User->IsInRole('u_price_changer') == false
            && (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $MemberID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $member = $this->catalogMgr->GetMember($MemberID);
        if ($member === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_member');
        }

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']      = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Price']     = App::$Request->Post['Price']->Dec(0, Request::DECIMAL_NUM);
            $form['Article']   = App::$Request->Post['Article']->Value();
        }
        else
        {
            $form['Name']      = $member->Name;
            $form['IsVisible'] = $member->IsVisible;
            $form['Article']   = $member->Article;

            $memberAreaRefs = $member->GetAreaRefs($this->_id);
            $form['IsVisible']    = $memberAreaRefs['IsVisible'];
            $form['Price']        = $memberAreaRefs['Price'];
        }

        return STPL::Fetch('admin/modules/catalog/edit_member', array(
            'section_id' => $this->_id,
            'action'     => 'edit_member',
            'form'       => $form,
        ));
    }

    private function _ToggleVisibleMember()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        if(App::$User->IsInRole('u_bouquet_editor') == false
                // && App::$User->IsInRole('u_price_changer') == false
                && (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
                $json->send(array(
                'status' => 'error',
                'errors' => ['access denied'],
            ));
            exit;
        }

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $member = $this->catalogMgr->GetMember($id);

        if ($member === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $areaRefs = $member->GetAreaRefs($this->_id);
        $IsVisible = !(int) $areaRefs['IsVisible'];

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsVisible' => $IsVisible,
        );

        $member->UpdateAreaRef($RefParams);

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $IsVisible,
            'memberid' => $id,
        ));
        exit;
    }

    private function _PostMember()
    {
        global $CONFIG, $OBJECTS;

        $MemberID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $Name      = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $Article   = App::$Request->Post['Article']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $Price     = App::$Request->Post['Price']->Dec(0, Request::DECIMAL_NUM);

        if (empty($Name))
            UserError::AddErrorIndexed('Name', ERR_A_CATALOG_EMPTY_MEMBER_NAME);

        if(UserError::IsError())
            return false;

        if ($MemberID > 0) {
            $member = $this->catalogMgr->GetMember($MemberID);
            if ($member === null) {
                UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
                return ;
            }

            $member->Name     = $Name;
            $member->Article  = $Article;
            $member->IsFilter = $IsFilter;
            $member->Weight   = intval($Weight);
        } else {

            $Data = array(
                'Name'          => $Name,
                'CatalogID' => $this->_id,
            );

            $member = new Member($Data);
        }

        $member->Update();

        $RefParams = array(
            'MemberID'     => $member->ID,
            'SectionID'    => $this->_id,
            'IsVisible'    => $IsVisible,
            'Price'        => $Price,
        );
        $this->catalogMgr->UpdateMemberAreaRef($RefParams);

        $products = $member->GetProducts();
        foreach($products as $product)
            $product->CachePrice($this->_id);

        return true;
    }

    private function _PostMembersSave()
    {
        global $OBJECTS;

        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);
        $prices = App::$Request->Post['price']->AsArray(array());

        $pids = [];
        if(is_array($prices) && count($prices) > 0)
        {
            // foreach ($ids as $id)
            foreach ($prices as $id => $price)
            {
                $member = $this->catalogMgr->GetMember($id);
                if ($member === null)
                    continue;

                $RefParams = [
                    'MemberID'     => $member->ID,
                    'SectionID'    => $this->_id,
                    'Price'        => $price,
                ];
                $this->catalogMgr->UpdateMemberAreaRef($RefParams);

                $member->Update();

                $products = $member->GetProducts();
                foreach($products as $product) {
                    if(!isset($pids[$product->id]))
                        $pids[$product->id] = $product;
                }
            }

            foreach($pids as $product) {
                $product->CachePrice($this->_id);
            }
        }

        return true;
    }

    private function _PostMembersDelete()
    {
        global $OBJECTS;

        $ids = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $member = $this->catalogMgr->GetMember($id);
                if ($member === null)
                    continue ;

                $member->Remove();
            }
        }
    }


    private function _GetProductPhotos()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_type_editor')) {
            Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$TypeID.'&id='.$ProductID);
        } elseif(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $productID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($productID);

        if ($product === null) {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/photos_list');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        $field  = App::$Request->Get['field']->Enum('ord', ['ord']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'ProductID' => $productID,
                'IsVisible' => -1,
                'objects' => true,
            ),
            'field' => [$field],
            'dir' => [$dir],
            'calc'  => true,
        );

        list($photos, $count) = $this->photoMgr->GetPhotos($filter);

        return STPL::Fetch('admin/modules/catalog/photos_list', array(
            'section_id'    => $this->_id,
            'list' => $photos,
            'product' => $product,
            'form' => $form,
            'action' => 'photos',
            'sections' => $this->catalogMgr->GetCatalog(),
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetProductPhotoNew()
    {
        if(App::$User->IsInRole('u_bouquet_type_editor')) {
            Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$TypeID.'&id='.$ProductID);
        } elseif(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $productID  = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($productID);
        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/photos_list');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['AltText']        = App::$Request->Post['AltText']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Title']          = App::$Request->Post['Title']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsLightbox']     = App::$Request->Post['IsLightbox']->Enum(0, array(0,1));
            $form['Ord']            = App::$Request->Post['Ord']->Int(0, Request::UNSIGNED_NUM);
        }
        else
        {
            $form['Name']       = '';
            $form['AltText']    = '';
            $form['Title']      = '';
            $form['Ord']        = 0;
            $form['IsVisible']  = 1;
            $form['IsLightbox'] = 0;
        }

        return STPL::Fetch('admin/modules/catalog/photo_edit', array(
            'section_id'    => $this->_id,
            'product' => $product,
            'form' => $form,
            'action' => 'new_photo',
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetProductPhotoEdit()
    {
        if(App::$User->IsInRole('u_bouquet_type_editor')) {
            Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=types&type_id='.$TypeID.'&id='.$ProductID);
        } elseif(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $PhotoID    = App::$Request->Get['photoid']->Int(0, Request::UNSIGNED_NUM);
        $productID  = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);

        $product = $this->catalogMgr->GetProduct($productID);

        if ($product === null) {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/photos_list');
        }

        $photo = $this->photoMgr->GetPhoto($PhotoID);

        if ($photo === null) {
            UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/photos_list');
        }

        $form['ProductID']  = $product->ID;
        $form['TypeID']     = $product->TypeID;

        $form['PhotoSmall']  = $photo->PhotoSmall;
        $form['PhotoBig']    = $photo->PhotoBig;
        $form['Photo']       = $photo->Photo;
        $form['Created']     = $photo->Created;
        $form['LastUpdated'] = $photo->LastUpdated;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['AltText']        = App::$Request->Post['AltText']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Title']          = App::$Request->Post['Title']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsLightbox']     = App::$Request->Post['IsLightbox']->Enum(0, array(0,1));
            $form['Ord']            = App::$Request->Post['Ord']->Int(0, Request::UNSIGNED_NUM);
            $form['PhotoID']        = $photo->ID;

        } else {

            $form['PhotoID']        = $photo->ID;
            $form['Name']           = $photo->Name;
            $form['AltText']        = $photo->AltText;
            $form['Title']          = $photo->Title;
            $form['IsVisible']      = $photo->IsVisible;
            $form['IsLightbox']     = $photo->IsLightbox;
            $form['Ord']            = $photo->Ord;

        }

        return STPL::Fetch('admin/modules/catalog/photo_edit', array(
            'section_id'    => $this->_id,
            'product' => $product,
            'form' => $form,
            'action' => 'edit_photo',
            'sections' => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _PostProductPhoto()
    {
        global $CONFIG, $OBJECTS;

        $ProductID      = App::$Request->Post['productid']->Int(0, Request::UNSIGNED_NUM);
        $PhotoID        = App::$Request->Post['photoid']->Int(0, Request::UNSIGNED_NUM);
        $Name           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $AltText        = App::$Request->Post['AltText']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $Title          = App::$Request->Post['Title']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsLightbox     = App::$Request->Post['IsLightbox']->Enum(0, array(0,1));

        // if (empty($Name))
        //  UserError::AddErrorIndexed('Name', ERR_A_CATALOG_EMPTY_NAME);

        // if(UserError::IsError())
        //  return false;

        $product = $this->catalogMgr->GetProduct($ProductID);
        if ($product === null) {
            UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
            return false;
        }

        if ($PhotoID > 0) {

            $photo = $this->photoMgr->GetPhoto($PhotoID);
            if ($photo === null) {
                UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
                return false;
            }

            $photo->Name        = $Name;
            $photo->AltText     = $AltText;
            $photo->Title       = $Title;
            $photo->Ord         = $Ord;
            $photo->IsVisible   = $IsVisible;
            $photo->IsLightbox  = $IsLightbox;
        } else {

            $Data = array(
                'ProductID'  => $ProductID,
                'Name'       => $Name,
                'AltText'    => $AltText,
                'Title'      => $Title,
                'IsVisible'  => $IsVisible,
                //'IsLightbox' => $IsLightbox,
                'Ord'        => 0,
            );

            $photo = new ProductPhoto($Data);
        }

        $arr_photos = array(
            'photosmall' => array('PhotoSmall'),
            'photo' => array('Photo'),
                // 'PhotoMiddle',
                // 'PhotoLarge',
                // 'Photo',

        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $photo->$photoName = null;
                try
                {
                    $photo->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $photo->$photoName = null;
                    return false;
                }
            }
        }

        $photo->Update();
        $this->_setMessage();

        return true;
    }

    private function _ToggleVisiblePhoto()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            $json->send(array(
                'status' => 'error',
                'errors' => ['access denied'],
            ));
            exit;
        }

        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $photo = $this->photoMgr->GetPhoto($id);

        if ($photo === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $photo->IsVisible = !$photo->IsVisible;
        $photo->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $photo->IsVisible,
            'photoid' => $id,
        ));
        exit;
    }

    private function _PostUpdatePhotos()
    {
        global $OBJECTS;

        $ords  = App::$Request->Post['ord']->AsArray(array(), Request::DECIMAL_NUM);
        $ids   = App::$Request->Post['ids_action']->AsArray(array(), Request::INTEGER_NUM);

        if(is_array($ids) && count($ids) > 0)
        {
            foreach ($ids as $id)
            {
                $photo = $this->photoMgr->GetPhoto($id);
                if ($photo === null)
                    continue ;

                $photo->Ord = $ords[$id];
                $photo->Update();
            }
        }
    }

    private function _PostDeletePhotos()
    {
        global $OBJECTS;

        if(is_array($_POST['ids_action']) && count($_POST['ids_action']) > 0)
        {
            foreach ($_POST['ids_action'] as $id)
            {
                $photo = $this->photoMgr->GetPhoto($id);
                if ($photo === null)
                    continue ;

                $photo->Remove();
            }
        }
    }

    private function _GetSectionSeo()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();
        $type_id = App::$Request->Get['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $seo = $this->catalogMgr->GetSectionSeo($this->_id, $type_id);

        $form['TypeID']     = $type_id;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['SeoText']            = App::$Request->Post['SeoText']->Value();
            $form['SeoTitle']           = App::$Request->Post['SeoTitle']->Value();
            $form['SeoDescription']     = App::$Request->Post['SeoDescription']->Value();
            $form['SeoKeywords']        = App::$Request->Post['SeoKeywords']->Value();
        }
        elseif ($seo !== null) {
            $form['SeoText']            = $seo->SeoText;
            $form['SeoTitle']           = $seo->SeoTitle;
            $form['SeoDescription']     = $seo->SeoDescription;
            $form['SeoKeywords']        = $seo->SeoKeywords;
        }
        else
        {
            $form['SeoText']            = '';
            $form['SeoTitle']           = '';
            $form['SeoDescription']     = '';
            $form['SeoKeywords']        = '';
        }

        return STPL::Fetch('admin/modules/catalog/seo_edit', array(
            'section_id'    => $this->_id,
            'form' => $form,
            'action' => 'seo',
        ));
    }

    private function _PostSectionSeo()
    {
        global $CONFIG, $OBJECTS;

        $type_id = App::$Request->Post['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $SeoText            = App::$Request->Post['SeoText']->Value();
        $SeoTitle           = App::$Request->Post['SeoTitle']->Value();
        $SeoDescription     = App::$Request->Post['SeoDescription']->Value();
        $SeoKeywords        = App::$Request->Post['SeoKeywords']->Value();

        $seo = $this->catalogMgr->GetSectionSeo($this->_id, $type_id);

        if ($seo !== null) {

            $seo->SeoText           = $SeoText;
            $seo->SeoTitle          = $SeoTitle;
            $seo->SeoDescription    = $SeoDescription;
            $seo->SeoKeywords       = $SeoKeywords;
        } else {

            $Data = array(
                'SectionID'  => $this->_id,
                'TypeID'     => $type_id,
                'SeoText'    => $SeoText,
                'SeoTitle'      => $SeoTitle,
                'SeoDescription'  => $SeoDescription,
                'SeoKeywords'  => $SeoKeywords,
            );

            $seo = new Seo($Data);
        }

        $seo->Update();

        return true;
    }

    private function _GetSettings()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $settings = $this->catalogMgr->GetSettings('catalog');

        $template = STPL::Fetch('admin/modules/catalog/_settings_template', array(
            'fieldTypes' => CatalogMgr::$fieldTypes,
        ));

        return STPL::Fetch('admin/modules/catalog/settings', array(
            'section_id'    => $this->_id,
            'settings' => $settings,
            'template' => $template,
            'fieldTypes' => CatalogMgr::$fieldTypes,
            'action' => 'settings',
        ));
    }

    private function _PostSettings()
    {
        global $CONFIG, $OBJECTS;

        $fields = App::$Request->Post['Fields']->AsArray(array());
        $result = array();

        foreach($fields as $field) {
            $temp = json_decode($field);

            if( $temp === null && json_last_error() !== JSON_ERROR_NONE ||
                empty($temp->name) ||
                empty($temp->title) ||
                empty($temp->type) ||
                !($temp->name = trim($temp->name)) ||
                !($temp->title = trim($temp->title)) ||
                !array_key_exists($temp->type, CatalogMgr::$fieldTypes)
            ) {
                continue;
            }
            $options = '';
            if($temp->type == 'select' || $temp->type == 'checkbox') {
                if(empty($temp->options) || !($temp->options = trim($temp->options))) {
                    continue;
                }
                $options = array();
                foreach(explode(',', $temp->options) as $option) {
                    $options[] = trim($option);
                }
            }

            $result[] = array(
                'name' => $temp->name,
                'title' => $temp->title,
                'type' => $temp->type,
                'options' => $options,
            );
        }

        $this->catalogMgr->UpdateSettings('catalog', $result);
    }

    private function _GetSectionSettings()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();
        $type_id = App::$Request->Get['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $data = $this->catalogMgr->GetSectionSettings($type_id);
        $settings = $this->catalogMgr->GetSettings('catalog');

        $form['TypeID']     = $type_id;
        $form['Fields']     = $settings;

        if (!empty($data)) {
            $form['Data']           = $data;
        }
        else
        {
            $form['Data']           = array();
        }

        return STPL::Fetch('admin/modules/catalog/section_settings_edit', array(
            'section_id'    => $this->_id,
            'form' => $form,
            'action' => 'section_settings',
        ));
    }

    private function _PostSectionSettings()
    {
        global $CONFIG, $OBJECTS;

        $type_id = App::$Request->Post['type_id']->Enum(0, array_keys($this->catalogMgr->getProductCategories()));

        $data = App::$Request->Post['Fields']->AsArray(array());

        $this->catalogMgr->UpdateSectionSettings($type_id, $data);

        return true;
    }

    private function _GetCatalogCopy()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $catalogs = $this->catalogMgr->GetCatalogsInfo($this->_id);

        return STPL::Fetch('admin/modules/catalog/catalog_copy', array(
            'section_id'    => $this->_id,
            'catalogs' => $catalogs,
        ));
    }

    private function _PostCatalogCopy()
    {
        global $CONFIG, $OBJECTS;

        $catalogID = App::$Request->Post['cid']->Int(0, Request::UNSIGNED_NUM);
        $rewrite = App::$Request->Post['IsRewrite']->Int(0, Request::UNSIGNED_NUM);

        if ($catalogID == 0)
            return false;

        $this->catalogMgr->CopyCatalogRefs($catalogID, $this->_id, $rewrite);

        return true;
    }

    private function _PostCatalogCopyDecor()
    {
        global $CONFIG, $OBJECTS;

        $catalogID = App::$Request->Post['cid']->Int(0, Request::UNSIGNED_NUM);
        $clear = App::$Request->Post['IsClear']->Int(0, Request::UNSIGNED_NUM);

        if ($catalogID == 0)
            return false;

        $this->catalogMgr->CopyCatalogDecor($catalogID, $this->_id, $clear);

        return true;
    }

    private function _PostCatalogCopyComposition()
    {
        global $CONFIG, $OBJECTS;

        $catalogID = App::$Request->Post['cid']->Int(0, Request::UNSIGNED_NUM);
        $clear = App::$Request->Post['IsClear']->Int(0, Request::UNSIGNED_NUM);

        if ($catalogID == 0)
            return false;

        $this->catalogMgr->CopyCatalogComposition($catalogID, $this->_id, $clear);

        return true;
    }

    /*private function _PostSaveProductsSorting()
    {
        $orders       = App::$Request->Post['ord']->AsArray(array(), Request::UNSIGNED_NUM);

        foreach($orders as $productid => $order)
        {
            $product = $this->productMgr->GetProduct($productid);
            if ($product === null)
                continue;

            $product->Ord           = $order;
            $product->Update();
        }

        return true;
    }*/

    private function _GetCategoryNew()
    {
        if((App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NameID']         = App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN );
            $form['Title']          = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN );
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Kind']           = App::$Request->Post['Kind']->Enum(0, array_keys(CatalogMgr::$CTL_KIND));
            $form['Text']           = App::$Request->Post['Text']->Value();
            $form['SeoTitle']       = App::$Request->Post['SeoTitle']->Value();
            $form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
            $form['SeoKeywords']    = App::$Request->Post['SeoKeywords']->Value();
            $form['SeoText']    = App::$Request->Post['SeoText']->Value();
        }
        else
        {
            $form['NameID']         = '';
            $form['Title']          = '';
            $form['IsVisible']      = 0;
            $form['Kind']           = 0;
            $form['SeoTitle']       = '';
            $form['SeoDescription'] = '';
            $form['SeoKeywords']    = '';
            $form['SeoText']    = '';
        }

        return STPL::Fetch('admin/modules/catalog/edit_category', array(
            'form'          => $form,
            'action'        => 'new_category',
            'section_id'    => $this->_id,
        ));
    }

    private function _GetCategoryEdit()
    {
        if((App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }


        global $DCONFIG, $CONFIG, $OBJECTS;

        $CategoryID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $category = $this->catalogMgr->GetCategory($CategoryID);
        if ($category === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CATEGORY_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_category');
        }

        $form['CategoryID']  = $category->ID;

        $form['Icon']             = $category->Icon;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NameID']         = App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN );
            $form['Title']          = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN );
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Kind']           = App::$Request->Post['Kind']->Enum(0, array_keys(CatalogMgr::$CTL_KIND));

            $form['SeoTitle']       = App::$Request->Post['SeoTitle']->Value();
            $form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
            $form['SeoKeywords']    = App::$Request->Post['SeoKeywords']->Value();
            $form['SeoText']    = App::$Request->Post['SeoText']->Value();
        }
        else
        {
            $form['NameID']         = $category->NameID;
            $form['Title']          = $category->Title;
            $form['IsVisible']      = $category->IsVisible;
            $form['Kind']           = $category->Kind;

            $form['SeoTitle']       = $category->SeoTitle;
            $form['SeoDescription'] = $category->SeoDescription;
            $form['SeoKeywords']    = $category->SeoKeywords;
            $form['SeoText']    = $category->SeoText;
        }

        return STPL::Fetch('admin/modules/catalog/edit_category', array(
            'form'          => $form,
            'action'        => 'edit_category',
            'section_id'    => $this->_id,
        ));
    }

    private function _PostCategory()
    {
        global $CONFIG, $OBJECTS;

        $CategoryID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);

        $NameID         = App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN );
        $Title          = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN );
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $Kind           = App::$Request->Post['Kind']->Enum(0, array_keys(CatalogMgr::$CTL_KIND));


        $SeoTitle       = App::$Request->Post['SeoTitle']->Value();
        $SeoDescription = App::$Request->Post['SeoDescription']->Value();
        $SeoKeywords    = App::$Request->Post['SeoKeywords']->Value();
        $SeoText        = App::$Request->Post['SeoText']->Value();

        $NameID = strtolower($NameID);
        $NameID = preg_replace(array("@\s@","@\-@"), array("_","_"), $NameID);
        $NameID = preg_replace("@[^a-z\_0-9]@", "", $NameID);

        if ($Title == "")
            UserError::AddErrorIndexed('Name', ERR_A_CATALOG_EMPTY_TITLE);

        if ($NameID == "")
            UserError::AddErrorIndexed('NameID', ERR_A_CATALOG_EMPTY_NAMEID);

        if ($Kind == "")
            UserError::AddErrorIndexed('Kind', ERR_A_CATALOG_EMPTY_KIND);

        if(UserError::IsError())
            return false;

        if($CategoryID > 0)
        {
            $category = $this->catalogMgr->GetCategory($CategoryID);
            if ($category === null) {
                UserError::AddErrorIndexed('global', ERR_A_CATEGORY_NOT_FOUND);
                return false;
            }

            $category->NameID         = $NameID;
            $category->Title          = $Title;
            $category->IsVisible      = $IsVisible;
            $category->Kind           = $Kind;

            $category->SeoTitle       = $SeoTitle;
            $category->SeoDescription = $SeoDescription;
            $category->SeoKeywords    = $SeoKeywords;
            $category->SeoText    = $SeoText;
        }
        else
        {
            $Data = array(
                'NameID'         => $NameID,
                'Title'          => $Title,
                'IsVisible'      => $IsVisible,
                'Kind'           => $Kind,

                'SeoTitle'       => $SeoTitle,
                'SeoDescription' => $SeoDescription,
                'SeoKeywords'    => $SeoKeywords,
                'SeoText'    => $SeoText,
            );

            $category = new Category($Data);
        }

        $arr_photos = array(
            'Icon' => array('Icon'),
        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $category->$photoName = null;
                try
                {
                    $category->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $category->$photoName = null;
                    return false;
                }
            }
        }

        $category->Update();

        $this->_setMessage();
        return $category->ID;
    }

    private function _PostSaveCatalog()
    {
        $orders = App::$Request->Post['orders']->AsArray();
        foreach($orders as $categoryid => $ord)
        {
            $category = $this->catalogMgr->GetCategory($categoryid);
            if($category === null)
                continue;

            $category->Ord = $ord;
            $category->Update();
        }

        return true;
    }

    private function _GetAjaxToggleCategoryVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $CategoryID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $category = $this->catalogMgr->GetCategory($CategoryID);

        if ($category === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $category->IsVisible =  !$category->IsVisible;
        $category->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $category->IsVisible,
            'categoryid' => $CategoryID,
        ));
        exit;
    }

    private function _GetCategoryDelete()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $CategoryID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $category = $this->catalogMgr->GetCategory($CategoryID);
        if ($category === null)
            return;

        $filter = array(
            'flags' => array(
                'objects' => true,
                'TypeID' => $CategoryID,
                'IsVisible' => -1,
            ),
            'calc' => true,
        );

        list(, $count) = $this->catalogMgr->GetProducts($filter);
        if($count > 0)
        {
            UserError::AddErrorIndexed('HasProduct', ERR_A_CATALOG_NOT_EMPTY);
        }

        if(UserError::IsError())
            return false;

        $category->Remove();
        return true;
    }

    // =============================

    private function _GetAdditions()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG;

        $field  = App::$Request->Get['field']->Enum('name', ['name', 'article', 'isvisible', 'ord']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'objects' => true,
                'CatalogID' => $this->_id,
                'all' => true,
                'IsVisible' => $IsVisible,
                'with' => array('AdditionAreaRefs'),
                // 'IsVisible' => -1,
            ),
            'field' => [$field],
            'dir' => [$dir],
            'dbg' => 0,
        );

        $additions = $this->catalogMgr->GetAdditions($filter);
        return STPL::Fetch('admin/modules/catalog/additions_list', array(
            'additions' => $additions,
            'section_id' => $this->_id,
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetAdditionNew()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN);
            $form['Article']     = App::$Request->Post['Article']->Value(Request::OUT_HTML_CLEAN);
            $form['Description'] = App::$Request->Post['Description']->Value(Request::OUT_HTML_CLEAN);
            $form['IsVisible']   = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Price']       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        }
        else
        {
            $form['Name']        = '';
            $form['IsVisible']   = 1;
            $form['Article']     = 0;
            $form['Price']       = 0;
            $form['Description'] = '';
        }

        return STPL::Fetch('admin/modules/catalog/edit_addition', array(
            'form'          => $form,
            'action'        => 'new_addition',
            'section_id'    => $this->_id,
        ));
    }

    private function _GetAdditionEdit()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $AdditionID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $addition = $this->catalogMgr->GetAddition($AdditionID);
        if ($addition === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_ADDITION_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_addition');
        }

        $form['AdditionID']  = $addition->ID;

        $form['PhotoSmall'] = $addition->PhotoSmall;
        $form['PhotoBig']   = $addition->PhotoBig;
        $form['PhotoCart']   = $addition->PhotoCart;
        $form['PhotoCartSmall']   = $addition->PhotoCartSmall;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
            $form['Description'] = App::$Request->Post['Description']->Value(Request::OUT_HTML_CLEAN );
            $form['Article']     = App::$Request->Post['Article']->Value(Request::OUT_HTML_CLEAN );
            $form['IsVisible']   = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['Price']       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
            $form['Theme']       = App::$Request->Post['Theme']->Int(0, Request::UNSIGNED_NUM);
        }
        else
        {
            $form['Name']        = $addition->Name;
            $form['Description'] = $addition->Description;
            $form['Price']       = $addition->Price;
            $form['Article']     = $addition->Article;
            $form['Theme']       = $addition->Theme;

            $additionAreaRefs = $addition->GetAreaRefs($this->_id);
            $form['IsVisible']          = $additionAreaRefs['IsVisible'];
        }


        return STPL::Fetch('admin/modules/catalog/edit_addition', array(
            'form'          => $form,
            'action'        => 'edit_addition',
            'section_id'    => $this->_id,
        ));
    }

    private function _PostAddition()
    {
        global $CONFIG, $OBJECTS;

        $AdditionID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);

        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN);
        $Article      = App::$Request->Post['Article']->Value(Request::OUT_HTML_CLEAN);
        $Description = App::$Request->Post['Description']->Value(Request::OUT_HTML_CLEAN );
        $IsVisible   = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $Price       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        $Theme       = App::$Request->Post['Theme']->Int(0, Request::UNSIGNED_NUM);


        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_ADDITION_EMPTY_NAME);

        if(UserError::IsError())
            return false;

        if($AdditionID > 0)
        {
            $addition = $this->catalogMgr->GetAddition($AdditionID);
            if ($addition === null) {
                UserError::AddErrorIndexed('global', ERR_A_ADDITION_NOT_FOUND);
                return false;
            }

            $addition->Name        = $Name;
            $addition->Description = $Description;
            $addition->Price       = $Price;
            $addition->Article     = $Article;
            $addition->Theme       = $Theme;
        }
        else
        {
            $Data = array(
                'Name'        => $Name,
                'Description' => $Description,
                'Price'       => $Price,
                'Article'     => $Article,
                'Theme'       => $Theme,
            );

            $addition = new Addition($Data);
        }

        $addition->Update();

        $arr_photos = array(
            'PhotoSmall' => array('PhotoSmall'),
            'PhotoBig' => array('PhotoBig'),
            'PhotoCart' => array('PhotoCart'),
            'PhotoCartSmall' => array('PhotoCartSmall'),
        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $addition->$photoName = null;
                try
                {
                    $addition->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $addition->$photoName = null;
                    return false;
                }
            }
        }

        $addition->Update();

        $RefParams = array(
            'AdditionID' => $addition->ID,
            'SectionID' => $this->_id,
            'IsVisible' => $IsVisible,

        );
        $this->catalogMgr->UpdateAdditionAreaRef($RefParams);

        $this->_setMessage();
        return $addition->ID;
    }

    private function _GetAjaxToggleAdditionVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            $json->send(array(
                'status' => 'error',
                'errors' => ['access denied'],
                'additionid' => $AdditionID,
            ));
            exit;
        }

        $AdditionID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $addition = $this->catalogMgr->GetAddition($AdditionID);

        if ($addition === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        // $addition->IsVisible =  !$addition->IsVisible;
        // $addition->Update();

        $areaRefs = $addition->GetAreaRefs($this->_id);
        $IsVisible = !(int) $areaRefs['IsVisible'];

        $RefParams = array(
            'SectionID' => $this->_id,
            'IsVisible' => $IsVisible,
            'InCard'    => $InCard,
        );
        $addition->UpdateAreaRef($RefParams);

        $json->send(array(
            'status' => 'ok',
            'visible' => intval($IsVisible),
            'additionid' => $AdditionID,
        ));
        exit;
    }

    private function _PostSaveAdditions()
    {
        $orders = App::$Request->Post['orders']->AsArray();

        foreach($orders as $additionid => $ord)
        {
            $addition = $this->catalogMgr->GetAddition($additionid);
            if($addition === null)
                continue;

            // $addition->Ord = $ord;
            $RefParams = array(
                'AdditionID' => $additionid,
                'SectionID' => $this->_id,
                'Ord' => $ord,

            );
            $this->catalogMgr->UpdateAdditionAreaRef($RefParams);

            $addition->Update();
        }

        return true;
    }

    private function _GetAdditionDelete()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $AdditionID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $addition = $this->catalogMgr->GetAddition($AdditionID);
        if ($addition === null)
            return;

        $addition->Remove();
        return;
    }

    // get lens for section
    private function _GetLens()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }
        global $DCONFIG, $CONFIG;

        $typeid = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
                'CategoryID' => $typeid,
                'CatalogID' => $this->_id,
            ),
            'dbg' => 0,
        );

        $lens = $this->catalogMgr->GetLens($filter);

        return STPL::Fetch('admin/modules/catalog/lens_list', array(
            'lens' => $lens,
            'type_id' => $typeid,
            'section_id' => $this->_id,
        ));
    }

    private function _GetLenNew()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }
        global $DCONFIG, $CONFIG, $OBJECTS;

        $typeid = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Len']       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
            $form['Cost']    = App::$Request->Post['Cost']->Int(0, Request::UNSIGNED_NUM);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Len']       = 0;
            $form['Cost']      = 0;
            $form['IsVisible'] = 1;
        }

        return STPL::Fetch('admin/modules/catalog/edit_len', array(
            'form'       => $form,
            'action'     => 'new_len',
            'type_id'    => $typeid,
            'section_id' => $this->_id,
        ));
    }


    private function _GetHeaderTextEdit() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $section_id  = App::$Request->Get['section_id']->Int(0, Request::UNSIGNED_NUM);
        $type_id    = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $category = $this->catalogMgr->GetCategory($type_id);
        $NameID = strtoupper($category->NameID).'_HEADER';

        $block = $this->blocksMgr->GetBlockByNameID($NameID);


        return STPL::Fetch('admin/modules/catalog/edit_header_text', array(
            'text'       => $block['Text'],
            'block_id'   => $block['BlockID'],
            'section_id' => $section_id,
        ));


    }


    private function _PostHeaderTextSave() {
        global $CONFIG, $OBJECTS;


        $block['Text']       = App::$Request->Post['text']->Value();
        $block['BlockID']    = App::$Request->Post['block_id']->Int(0, Request::UNSIGNED_NUM);

        if ($block['BlockID'] < 1) {
            return false;
        }

        return $this->blocksMgr->UpdateBlock($block);

    }

    private function _GetLenEdit()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $CategoryID  = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $len = $this->catalogMgr->GetLen($LenID);
        if ($len === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_ADDITION_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_addition');
        }

        $form['LenID']  = $len->ID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Len']       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
            $form['Cost']      = App::$Request->Post['Cost']->Int(0, Request::UNSIGNED_NUM);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Len']       = $len->Len;
            $form['Cost']      = $len->Cost;
            $form['IsVisible'] = $len->IsVisible;
        }

        return STPL::Fetch('admin/modules/catalog/edit_len', array(
            'form'       => $form,
            'action'     => 'edit_len',
            'section_id' => $this->_id,
            'type_id'    => $CategoryID,
        ));
    }

    private function _PostLen()
    {
        global $CONFIG, $OBJECTS;

        $LenID      = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $CategoryID = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $Len       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
        $Cost      = App::$Request->Post['Cost']->Int(0, Request::UNSIGNED_NUM);
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Len == 0)
            UserError::AddErrorIndexed('Len', ERR_A_LEN_EMPTY);

        if ($Cost == 0)
             UserError::AddErrorIndexed('Retail', ERR_A_RETAIL_EMPTY_PRICE);

        if(UserError::IsError())
            return false;

        if($LenID > 0)
        {
            $len = $this->catalogMgr->GetLen($LenID);
            if ($len === null) {
                UserError::AddErrorIndexed('global', ERR_A_ADDITION_NOT_FOUND);
                return false;
            }

            $len->Len       = $Len;
            $len->Cost      = $Cost;
            $len->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
                'CategoryID' => $CategoryID,
                'Len'        => $Len,
                'Cost'       => $Cost,
                'IsVisible'  => $IsVisible,
                'CatalogID'  => $this->_id,
            );

            $len = new RoseLen($Data);
        }


        $len->Update();

        $this->_setMessage();
        return $len->ID;
    }

    private function _GetAjaxToggleLenVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            $json->send(array(
                'status'  => 'ok',
                'visible' => (int) $len->IsVisible,
                'lenid'   => $LenID,
            ));
            exit;
        }

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $len = $this->catalogMgr->GetLen($LenID);

        if ($len === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $len->IsVisible =  !$len->IsVisible;
        $len->Update();

        $json->send(array(
            'status'  => 'ok',
            'visible' => (int) $len->IsVisible,
            'lenid'   => $LenID,
        ));
        exit;
    }

    private function _PostSaveLens()
    {
        $orders = App::$Request->Post['orders']->AsArray();

        foreach($orders as $lenid => $ord)
        {
            $len = $this->catalogMgr->GetLen($lenid);
            if($len === null)
                continue;

            $len->Ord = $ord;
            $len->Update();
        }

        return true;
    }

    private function _GetLenDelete()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $len = $this->catalogMgr->GetLen($LenID);
        if ($len === null)
            return;

        $len->Remove();
        return;
    }

    //
        // Cards edit section
    // =============================

    private function _GetCards()
    {
        global $DCONFIG, $CONFIG;

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
                'CatalogID' => $this->_id,
            ),
            'dbg' => 0,
        );

        $cards = $this->catalogMgr->GetCards($filter);

        return STPL::Fetch('admin/modules/catalog/cards_list', array(
            'cards' => $cards,
            'section_id' => $this->_id,
        ));
    }

    private function _GetCardNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']       = App::$Request->Post['Name']->Value();
            $form['Price']    = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']      = '';
            $form['Price']     = 0;
            $form['IsVisible'] = 1;
        }

        return STPL::Fetch('admin/modules/catalog/edit_card', array(
            'form'       => $form,
            'action'     => 'new_card',
            'section_id' => $this->_id,
        ));
    }

    private function _GetCardEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $CardID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $card = $this->catalogMgr->GetCard($CardID);
        if ($card === null)
        {
            UserError::AddErrorIndexed('global', ERR_CARD_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_card');
        }

        $form['CardID']  = $card->ID;

        $form['Icon']             = $card->Icon;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Price']     = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
            $form['Name']      = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']      = $card->Name;
            $form['Price']     = $card->Price;
            $form['IsVisible'] = $card->IsVisible;
        }

        return STPL::Fetch('admin/modules/catalog/edit_card', array(
            'form'       => $form,
            'action'     => 'edit_card',
            'section_id' => $this->_id,
        ));
    }

    private function _GetAjaxToggleCardVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            $json->send(array(
                'status'  => 'error',
                'errors' => ['access denied'],
                'cardid'   => $CardID,
            ));
            exit;
        }

        $CardID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $card = $this->catalogMgr->GetCard($CardID);

        if ($card === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $card->IsVisible =  !$card->IsVisible;
        $card->Update();

        $json->send(array(
            'status'  => 'ok',
            'visible' => (int) $card->IsVisible,
            'cardid'   => $CardID,
        ));
        exit;
    }

    private function _PostSaveCards()
    {
        $orders = App::$Request->Post['orders']->AsArray();

        foreach($orders as $cardid => $ord)
        {
            $card = $this->catalogMgr->GetCard($cardid);
            if($card === null)
                continue;

            $card->Ord = $ord;
            $card->Update();
        }

        return true;
    }

    private function _GetCardDelete()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $CardID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $card = $this->catalogMgr->GetCard($CardID);
        if ($card === null)
            return;

        $card->Remove();
        return;
    }

    private function _PostCard()
    {
        global $CONFIG, $OBJECTS;

        $CardID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);

        $Name      = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
        $Price     = App::$Request->Post['Price']->Int(Request::UNSIGNED_NUM );
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_CARD_NAME_EMPTY);

        if(UserError::IsError())
            return false;

        if($CardID > 0)
        {
            $card = $this->catalogMgr->GetCard($CardID);
            if ($card === null) {
                UserError::AddErrorIndexed('global', ERR_A_CARD_NOT_FOUND);
                return false;
            }

            $card->Name      = $Name;
            $card->Price     = $Price;
            $card->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
                'CatalogID' => $this->_id,
                'Name'      => $Name,
                'Price'     => $Price,
                'IsVisible' => $IsVisible,
            );

            $card = new Card($Data);
        }

        $arr_photos = array(
            'Icon' => array('Icon'),
        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $card->$photoName = null;
                try
                {
                    $card->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $product->$photoName = null;
                    return false;
                }
            }
        }

        $card->Update();

        $this->_setMessage();
        return $card->ID;
    }

    public function _GetProductLens()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $productid = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);
        $product = $this->catalogMgr->GetProduct($productid);
        if($product === null) {
             UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/lens_list');
        }

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => -1,
                'ProductID' => $productid,
            ],
            'field' => ['Ord'],
            'dir' => ['ASC'],
            'calc' => false,
            'dbg' => 0,
        ];

        $lens = $this->catalogMgr->GetLens($filter);

        $form['TypeID'] = $product->category->id;


        return STPL::Fetch('admin/modules/catalog/lens_list', array(
            'action'     => 'product_lens',
            'lens'       => $lens,
            'productid'  => $productid,
            'section_id' => $this->_id,
            'product'    => $product,
            'form'       => $form,
            'sections'   => $this->catalogMgr->GetCatalog(),
        ));
    }

    private function _GetProductLenNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }


        $productid  = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Len']       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
            $form['MemberID']  = App::$Request->Post['MemberID']->Int(0, Request::UNSIGNED_NUM);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        }
        else
        {
            $form['Len']       = 0;
            $form['MemberID']  = 0;
            $form['IsVisible'] = 1;
            $form['IsDefault'] = 0;
        }

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
                // 'CatalogID' => $this->_id,
            ),
            'dbg' => 0,
        );
        $members = $this->catalogMgr->GetMembers($filter);

        return STPL::Fetch('admin/modules/catalog/edit_len', array(
            'form'       => $form,
            'action'     => 'new_productlen',
            'members'    => $members,
            'productid'  => $productid,
            'section_id' => $this->_id,
        ));
    }

    private function _GetProductLenEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $productid  = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);

        $len = $this->catalogMgr->GetLen($LenID);
        if ($len === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_LEN_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_productlen');
        }

        $product = $this->catalogMgr->GetProduct($productid);
        if ($product === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PRODUCT_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_productlen');
        }

        $form['LenID']  = $len->ID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Len']       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
            $form['MemberID']  = App::$Request->Post['MemberID']->Int(0, Request::UNSIGNED_NUM);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        }
        else
        {
            $form['Len']       = $len->Len;
            $form['MemberID'] = $len->MemberID;
            $form['IsVisible'] = $len->IsVisible;
            $form['IsDefault'] = $len->IsDefault;
        }

         $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
            ),
            'dbg' => 0,
        );
        $members = $this->catalogMgr->GetMembers($filter);

        return STPL::Fetch('admin/modules/catalog/edit_len', array(
            'form'       => $form,
            'action'     => 'edit_productlen',
            'members'    => $members,
            'section_id' => $this->_id,
            'productid'    => $productid,
        ));
    }

    private function _PostProductLen()
    {
        global $CONFIG, $OBJECTS;

        $LenID     = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $productid = App::$Request->Get['productid']->Int(0, Request::UNSIGNED_NUM);

        $Len       = App::$Request->Post['Len']->Int(0, Request::UNSIGNED_NUM);
        $MemberID  = App::$Request->Post['MemberID']->Int(0, Request::UNSIGNED_NUM);
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));

        if ($Len == 0)
            UserError::AddErrorIndexed('Len', ERR_A_LEN_EMPTY);

        if ($MemberID == 0)
             UserError::AddErrorIndexed('Member', ERR_A_LEN_MEMBER_NOT_SELECTED);

         $member = $this->catalogMgr->GetMember($MemberID);

         $product = $this->catalogMgr->GetProduct($productid);
         if($product === null)
            UserError::AddErrorIndexed('Retail', ERR_A_PRODUCT_NOT_FOUND);

        if(UserError::IsError())
        {
            return false;
        }

        if($LenID > 0)
        {
            $len = $this->catalogMgr->GetLen($LenID);
            if ($len === null) {
                UserError::AddErrorIndexed('global', ERR_A_LEN_NOT_FOUND);
                return false;
            }

            $len->Len       = $Len;
            $len->MemberID  = $MemberID;
            $len->IsVisible = $IsVisible;
            $len->IsDefault = $IsDefault;
        }
        else
        {
            $Data = array(
                'ProductID' => $productid,
                'Len'       => $Len,
                'MemberID'  => $MemberID,
                'IsVisible' => $IsVisible,
            );

            $len = new RoseLen($Data);
        }

        if($IsDefault) {
            $filter = [
                'flags' => [
                    'objects' => true,
                    'ProductID' => $productid,
                ],
                'field' => [],
                'dir' => [],
                'calc' => false,
                'dbg' => 0,
            ];

            $lens = $this->catalogMgr->GetLens($filter);
            foreach($lens as $item) {
                $item->IsDefault = 0;
                $item->Update();
            }

            $len->IsDefault = 1;

        }

        $product->CachePrice($this->_id);

        $len->Update();

        $this->_setMessage();
        return $len->ID;
    }

    private function _GetAjaxToggleProductLenVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $len = $this->catalogMgr->GetLen($LenID);

        if ($len === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $len->IsVisible =  !$len->IsVisible;
        $len->Update();

        $product = $this->catalogMgr->GetProduct($len->ProductID);
        if($product) {
            $product->CachePrice($this->_id);
        }

        $json->send(array(
            'status'  => 'ok',
            'visible' => (int) $len->IsVisible,
            'lenid'   => $LenID,
        ));
        exit;
    }

    private function _PostSaveProductLens()
    {
        $orders = App::$Request->Post['orders']->AsArray();

        foreach($orders as $lenid => $ord)
        {
            $len = $this->catalogMgr->GetLen($lenid);
            if($len === null)
                continue;

            $len->Ord = $ord;
            $len->Update();
        }

        return true;
    }

    private function _GetProductLenDelete()
    {
        if(App::$User->IsInRole('u_bouquet_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $LenID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $len = $this->catalogMgr->GetLen($LenID);

        if ($len === null)
            return;

        $len->Remove();
        $productid = $len->productid;
        $product = $this->catalogMgr->GetProduct($productid);

        $lens = $product->GetLens();
        if($lens === false) {
            $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
            $filter['SectionID'] = $this->_id;

            $ord =  $this->catalogMgr->GetLastOrd($filter);
            $ord++;

            $RefParams = [
                'SectionID' => $this->_id,
            ];

            if(!is_null($ord))
                $RefParams['Ord'] = $ord;

            $product->UpdateAreaRef($RefParams);
        }

        return;
    }

    private function _GetConfigSettings()
    {
        if((App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        $week = array(
            1 => 'пн',
            2 => 'вт',
            3 => 'ср',
            4 => 'чт',
            5 => 'пт',
            6 => 'сб',
            0 => 'вс',
        );

        return STPL::Fetch('admin/modules/catalog/config_settings', array(
            'section_id' => $this->_id,
            'action'     => 'settings_config',
            'config'     => $config,
            'week'       => $week,
            'special'    => CatalogMgr::$specialTypes
        ));
    }

    private function handleMinSteps()
    {
        $rawMinSteps = App::$Request->Post['minStep']->AsArray(array());
        $minSteps = [];

        // валидация специальных шагов
        for($i = 0; $i < count($rawMinSteps['date']); $i++) {

            // валидация даты
            $format = "d.m";
            $dateObj = DateTime::createFromFormat($format, $rawMinSteps['date'][$i]);
            if(!$dateObj) {
                UserError::AddErrorIndexed('MinStep_date', ERR_MINSTEP_INVALID_DATE);
            } else {
                $rawMinSteps['date'][$i] = $dateObj->format('d.m');
            }

            // валидация шага
            $rawMinSteps['step'][$i] = (int)$rawMinSteps['step'][$i];
            if(!is_int($rawMinSteps['step'][$i]) || $rawMinSteps['step'][$i] < 2) {
                UserError::AddErrorIndexed('MinStep_step', ERR_MINSTEP_INVALID_STEP);
            }

            // придется переделать массив в формат, в котором сохраняется график работы
            $minSteps[] = [
                'date' => $rawMinSteps['date'][$i],
                'step' => $rawMinSteps['step'][$i],
            ];
        }

        return $minSteps;
    }

    private function _PostConfigSettings()
    {
        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        $Emails = App::$Request->Post['Emails']->AsArray(array());

        $ReviewEmails = App::$Request->Post['ReviewEmails']->AsArray(array());

        $froms   = App::$Request->Post['From']->AsArray(array());
        $tos     = App::$Request->Post['To']->AsArray(array());

        // время доставки
        $deliveryFrom   = App::$Request->Post['del-from']->AsArray(array());
        $deliveryTo     = App::$Request->Post['del-to']->AsArray(array());


        $disable     = App::$Request->Post['Disable']->AsArray(array());

        // $call_froms   = App::$Request->Post['Call_From']->AsArray(array());
        // $call_tos     = App::$Request->Post['Call_To']->AsArray(array());
        // $call_disable     = App::$Request->Post['Call_Disable']->AsArray(array());

        $days     = App::$Request->Post['Days']->AsArray(array());

        $range_from = App::$Request->Post['RangeFrom']->Value(Request::OUT_HTML_CLEAN);
        $range_to = App::$Request->Post['RangeTo']->Value(Request::OUT_HTML_CLEAN);

        $notice_title = App::$Request->Post['notice_title']->Value();
        $notice_message = App::$Request->Post['notice_message']->Value();

        $cart_notice_title = App::$Request->Post['cart_notice_title']->Value();
        $cart_notice_message = App::$Request->Post['cart_notice_message']->Value();

        $call_notice_title = App::$Request->Post['call_notice_title']->Value();
        $call_notice_message = App::$Request->Post['call_notice_message']->Value();

        // $delivery_from = App::$Request->Post['delivery_from']->Value();
        // $delivery_to = App::$Request->Post['delivery_to']->Value();
        $formation = App::$Request->Post['formation']->Value();
        $time_message_delivery = App::$Request->Post['time_message_delivery']->Value();
        $time_message_pickup = App::$Request->Post['time_message_pickup']->Value();

        $rose_min = App::$Request->Post['rose_min']->Int(1, Request::UNSIGNED_NUM);
        $rose_step = App::$Request->Post['rose_step']->Int(1, Request::UNSIGNED_NUM);

        $mono_min = App::$Request->Post['mono_min']->Int(1, Request::UNSIGNED_NUM);
        $mono_step = App::$Request->Post['mono_step']->Int(1, Request::UNSIGNED_NUM);

        $discount_code     = App::$Request->Post['discount_code']->AsArray(array());

        $discount_price     = App::$Request->Post['discount_price']->Int(0, Request::UNSIGNED_NUM);

        $daysPeriod = App::$Request->Post['days_period']->Int(0, Request::UNSIGNED_NUM);

        $notice_email = App::$Request->Post['notice_email']->Int(0, Request::UNSIGNED_NUM);
        $notice_sms = App::$Request->Post['notice_sms']->Int(0, Request::UNSIGNED_NUM);

        $sms_login = App::$Request->Post['sms_login']->Value();
        $sms_password = App::$Request->Post['sms_password']->Value();

        $correction_call = App::$Request->Post['correction_call']->Int(0, Request::UNSIGNED_NUM);

        $pattern = '/^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])(:[0-5][0-9])?$/';

        $rawSpecial = App::$Request->Post['special']->AsArray(array());
        $special = [];

        $slider = App::$Request->Post['slider']->AsArray(array());

        // валидация дат, для которых указано специфическое время работы
        for($i = 0; $i < count($rawSpecial['type']); $i++) {
            // валидация типа
            if(!in_array($rawSpecial['type'][$i], array_keys(CatalogMgr::$specialTypes)))
                UserError::AddErrorIndexed('Special_type', ERR_SPECIAL_UNKNOWN_TYPE);

            // валидация даты
            $format = "d.m";
            $dateObj = DateTime::createFromFormat($format, $rawSpecial['date'][$i]);
            if(!$dateObj) {
                UserError::AddErrorIndexed('Special_date', ERR_SPECIAL_INVALID_DATE);
            } else {
                $rawSpecial['date'][$i] = $dateObj->format('d.m');
            }

            // валидация времени
            if(preg_match($pattern, $rawSpecial['from'][$i]) == 0) {
                // echo $rawSpecial['from'][$i];
                UserError::AddErrorIndexed('Special_time', ERR_SPECIAL_INVALID_TIME);
                $isSpecialFromInvalid = true;
            }

            if(preg_match($pattern, $rawSpecial['to'][$i]) == 0) {
                // echo $rawSpecial['to'][$i];
                $isSpecialToInvalid = true;
                UserError::AddErrorIndexed('Special_time', ERR_SPECIAL_INVALID_TIME);
            }

            if(!$isSpecialFromInvalid && !$isSpecialToInvalid) {
                $objFrom = new DateTime(date('d.m.Y', time())." ".$rawSpecial['from'][$i]);
                $objTo = new DateTime(date('d.m.Y', time())." ".$rawSpecial['to'][$i]);

                if($objFrom >= $objTo)
                    UserError::AddErrorIndexed('Special_invalid_time_range', ERR_SPECIAL_INVALID_TIME_RANGE);
            }

            // придется переделать массив в формат, в котором сохраняется график работы
            $special[] = [
                'type' => $rawSpecial['type'][$i],
                'date' => $rawSpecial['date'][$i],
                'from' => $rawSpecial['from'][$i],
                'to' => $rawSpecial['to'][$i],
            ];
        }

        unset($rawSpecial);

        // if(preg_match($pattern, $delivery_from) == 0) {
        //     UserError::AddErrorIndexed('DeliveryFrom_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
        // }

        // if(preg_match($pattern, $delivery_to) == 0) {
        //     UserError::AddErrorIndexed('DeliveryTo_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
        // }

        // if(preg_match($pattern, $delivery_from) && preg_match($pattern, $delivery_to)) {
        //     $objFrom = new DateTime(date('d.m.Y', time())." ".$delivery_from);
        //     $objTo = new DateTime(date('d.m.Y', time())." ".$delivery_to);

        //     if($objFrom >= $objTo)
        //         UserError::AddErrorIndexed('Delivery_InvalidRange', ERR_A_DELIVERY_TIME_INVALID_RANGE);
        // }

        foreach($froms as $k => $from) {
            // echo $from." ".$tos[$k]."<br>";
            if(preg_match($pattern, $from) == 0) {
               // echo "error 03";
                UserError::AddErrorIndexed('WorkmodeFrom_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
            }

            if(preg_match($pattern, $tos[$k]) == 0) {
                // echo "error 04";
                UserError::AddErrorIndexed('WorkmodeTo_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
            }

            if(preg_match($pattern, $from) && preg_match($pattern, $tos[$k])) {
                $objWMFrom = new DateTime(date('d.m.Y', time())." ".$from);
                $objWMTo = new DateTime(date('d.m.Y', time())." ".$tos[$k]);

                if($objWMFrom >= $objWMTo) {
                    UserError::AddErrorIndexed('Workmode_InvalidRange', ERR_A_WORKMODE_TIME_INVALID_RANGE);
                }
            }
        }

        foreach($deliveryFrom as $k => $from) {
            // echo $from." ".$tos[$k]."<br>";
            if(preg_match($pattern, $from) == 0) {
                // echo "error 01";
                UserError::AddErrorIndexed('WorkmodeFrom_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
            }

            if(preg_match($pattern, $deliveryTo[$k]) == 0) {
                // echo "error 02";
                UserError::AddErrorIndexed('WorkmodeTo_format', ERR_A_DELIVERY_TIME_INVALID_FORMAT);
            }

            if(preg_match($pattern, $from) && preg_match($pattern, $deliveryTo[$k])) {
                $objWMFrom = new DateTime(date('d.m.Y', time())." ".$from);
                $objWMTo = new DateTime(date('d.m.Y', time())." ".$deliveryTo[$k]);

                if($objWMFrom >= $objWMTo) {
                    UserError::AddErrorIndexed('Workmode_InvalidRange', ERR_A_WORKMODE_TIME_INVALID_RANGE);
                }
            }
        }

        if(UserError::IsError())
        {
            return false;
        }


        $i = 0;
        $arrEmails = array();
        foreach($Emails as $email)
            $arrEmails[++$i] = $email;

        $i = 0;
        $arrReviewEmails = array();
        foreach($ReviewEmails as $email)
            $arrReviewEmails[++$i] = $email;

        $arrWorkmode = array();
        foreach($froms as $k => $from)
        {
            $arrWorkmode[$k]['from'] = $from;
            $arrWorkmode[$k]['to'] = $tos[$k];
            $arrWorkmode[$k]['disable'] = intval($disable[$k]);
        }

        $arrDeliveryMode = array();
        foreach($deliveryFrom as $k => $from)
        {
            $arrDeliveryMode[$k]['from'] = $from;
            $arrDeliveryMode[$k]['to'] = $deliveryTo[$k];
        }

        $arrCallWorkmode = array();
        foreach($call_froms as $k => $from)
        {
            $arrCallWorkmode[$k]['from'] = $from;
            $arrCallWorkmode[$k]['to'] = $call_tos[$k];
            $arrCallWorkmode[$k]['disable'] = intval($call_disable[$k]);
        }

        $config['order_emails'] = $arrEmails;
        $config['review_emails'] = $arrReviewEmails;
        $config['workmode']   = $arrWorkmode;
        $config['deliverymode']   = $arrDeliveryMode;
        $config['special'] = $special;
        $config['minSteps'] = $this->handleMinSteps();


        // $config['time_range'] = array(
        //     'from' => $range_from,
        //     'to' => $range_to,
        // );
        $config['days']   = $days;
        $config['noorder_text'] = array(
            'title' => $notice_title,
            'message' => $notice_message,
        );

        $config['cart_noorder_text'] = array(
            'title' => $cart_notice_title,
            'message' => $cart_notice_message,
        );

        $config['time_delivery'] = [
            // 'from' => $delivery_from,
            // 'to' => $delivery_to,
            'formation' => $formation,
        ];

        $config['time_message']['delivery'] = $time_message_delivery;
        $config['time_message']['pickup'] = $time_message_pickup;

        $config['discount_code'] = $discount_code;
        $config['discount_price'] = $discount_price;

        $config['days_period'] = $daysPeriod;

        $config['rose_params']['min'] = $rose_min;
        // $config['rose_params']['step'] = $rose_step;

        $config['mono_params']['min'] = $mono_min;
        // $config['mono_params']['step'] = $mono_step;

        $config['notice']['email'] = $notice_email;
        $config['notice']['sms'] = $notice_sms;

        $config['sms']['login'] = $sms_login;
        $config['sms']['password'] = $sms_password;

        $config['correction_call'] = $correction_call;

        $config['slider'] = $slider;

        $bl->SaveConfig('module_engine', 'catalog', $config);

        return true;
    }

    private function _GetSorting() {
        global $DCONFIG, $CONFIG;

        App::$Title->AddStyle('/resources/styles/modules/catalog/admin/simplegrid.css');
        App::$Title->AddStyle('/resources/styles/modules/catalog/admin/product_sorting.css');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-1.10.2.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js');

        $type_id = App::$Request->Get['type_id']->Int(0, Request::UNSIGNED_NUM);

        $filter = array(
            'flags' => array(
                'TypeID' => $type_id,
                'CatalogID' => $this->_id,
                // 'IsVisible' => $IsVisible,
                'with' => array('AreaRefs'),
                'objects' => true,
            ),
            'field' => ['ord', 'productid'],
            'dir' => ['asc', 'desc'],
            'dbg' => 0,
        );

        $products = $this->catalogMgr->GetProducts($filter);

        $actual = App::$Request->Get['actual']->Enum(0, array(0, 1));
        $add = "";
        if($actual)
            $add = "_preview";

        return STPL::Fetch('admin/modules/catalog/general_sorting'.$add, array(
            'list'        => $products,
            'section_id' => $this->_id,
            'type_id'     => $type_id,
            'url'         => '?section_id='.$this->_id.'&action=sorting&type_id='.$type_id,
            'action_type' => 'sorting',
        ));
    }

    private function _GetGeneralSorting()
    {
       $filter = [
           'flags' => [
               'TypeID' => $type_id,
               // 'IsVisible' => 1,
               'Categories' => [1, 3, 10, 11],
               'all' => true,
               'with' => array('AreaRefs'),
               'objects' => true,
           ],
           'field' => ['ord', 'productid'],
           'dir' => ['ASC', 'DESC'],
           'dbg' => 0,
       ];

       $products = $this->catalogMgr->GetProducts($filter);

       App::$Title->AddStyle('/resources/styles/modules/catalog/admin/simplegrid.css');
       App::$Title->AddStyle('/resources/styles/modules/catalog/admin/product_sorting.css');
       App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
       App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-1.10.2.js');
       App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js');

        $actual = App::$Request->Get['actual']->Enum(0, [0, 1]);
        $add = "";
        if($actual)
            $add = "_preview";

       return STPL::Fetch('admin/modules/catalog/general_sorting'.$add, array(
           'list'        => $products,
           'section_id' => $this->_id,
           'type_id'     => $type_id,
           'url'         => '?section_id='.$this->_id.'&action=general_sorting',
           'action_type' => 'general_sorting',
       ));
   }

   private function _GetDiscountCards()
   {
        if(App::$User->IsInRole('u_discountcard_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

    // $filter = [
    //     'flags' => [
    //         'objects' => true,
    //         'OrderID' => 75,
    //     ],
    //     // 'field' => [],
    //     // 'dir' => [],
    //     'calc' => false,
    //     'dbg' => 1,
    // ];

    // $card_list = $this->catalogMgr->GetDiscountCards($filter);

        $page   = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);

        $date_from = App::$Request->Get['date_from']->Value();
        $date_to = App::$Request->Get['date_to']->Value();

        $card_from = App::$Request->Get['card_from']->Value();
        $card_to = App::$Request->Get['card_to']->Value();

        $orderid_from = App::$Request->Get['orderid_from']->Value();
        $orderid_to = App::$Request->Get['orderid_to']->Value();

        $field  = App::$Request->Get['field']->Enum('created', ['code', 'orderid', 'isactive']);
        $dir = App::$Request->Get['dir']->Enum('desc', ['asc', 'desc']);

        $filter = [
            'flags' => [
                'objects' => true,
                'Status' => $status,
                'IsArchive' => 0,
                'PaymentStatus' => $paymentstatus,
            ],
            'field' => [$field],
            'dir' => [$dir],
            'dbg' => 0,
            'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
            'limit' => self::$ROW_ON_PAGE,
            'calc' => true,
        ];

        if($date_from) {
            $date_from = date('Y-m-d', strtotime($date_from));
            $filter['flags']['DateFrom'] = $date_from;
        }

        if($date_to) {
            $date_to = date('Y-m-d', strtotime($date_to));
            $filter['flags']['DateTo'] = $date_to;
        }

        if($card_from) {
            $filter['flags']['CardFrom'] = $card_from;
        }

        if($card_to) {
            $filter['flags']['CardTo'] = $card_to;
        }

        if($orderid_from) {
            $filter['flags']['OrderIDFrom'] = $orderid_from;
        }

        if($orderid_to) {
            $filter['flags']['OrderIDTo'] = $orderid_to;
        }

        list($discountcards, $count) = $this->catalogMgr->GetDiscountCards($filter);

        $pages = Data::GetNavigationPagesNumber(
            self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
            "?section_id=". $this->_id ."&action=discountcards&field=".$field."&dir=".$dir."&date_from=".$date_from."&date_to=".$date_to."&card_from=".$card_from."&card_to=".$card_to."&orderid_from=".$orderid_from."&orderid_to=".$orderid_to."&page=@p@");

        return STPL::Fetch('admin/modules/catalog/discountcards', [
            'action'        => 'discountorders',
            'discountcards' => $discountcards,
            'section_id'    => $this->_id,
            'date_from' => $date_from != '' ? date('d.m.Y', strtotime($date_from)) : "",
            'date_to' => $date_to != '' ? date('d.m.Y', strtotime($date_to)) : "",
            'card_from' => $card_from,
            'card_to' => $card_to,
            'orderid_from' => $orderid_from,
            'orderid_to' => $orderid_to,
            'sorting' => [
                'field' => $field,
                'dir'   => $dir,
            ],
            'pages' => $pages,
        ]);
   }

   private function _GetDiscountCardEdit()
   {
        if(App::$User->IsInRole('u_discountcard_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $DiscountcardID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $discountcard = $this->catalogMgr->GetDiscountCard($DiscountcardID);
        if ($discountcard === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_DISCOUNTCARD_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/discountcard_edit');
        }

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['isactive'] = App::$Request->Post['isactive']->Enum(0, array(0,1));
        } else {
            $form['isactive'] = $discountcard->isactive;
        }

        $order = $this->catalogMgr->GetOrder($discountcard->orderid);

        return STPL::Fetch('admin/modules/catalog/discountcard_edit', array(
            'form'         => $form,
            'action'       => 'edit_discountcard',
            'section_id'   => $this->_id,
            'discountcard' => $discountcard,
            'order'        => $order,
        ));
   }

    private function _GetAjaxToggleDiscountCardActive()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        if(App::$User->IsInRole('u_discountcard_editor') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            $json->send([
                'status' => 'error',
                'errors' => ['access denied'],
            ]);
            exit;
        }

        $discountcardid  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $discountcard = $this->catalogMgr->GetDiscountCard($discountcardid);
        if ($discountcard === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $discountcard->isactive =  !$discountcard->isactive;
        $discountcard->Update();

        $json->send(array(
            'status'         => 'ok',
            'active'         => (int) $discountcard->isactive,
            'discountcardid' => $discountcardid,
        ));
        exit;
    }


    private function _PostDiscountCard()
    {
        global $CONFIG, $OBJECTS;

        $DiscountcardID          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $isactive         = App::$Request->Post['isactive']->Value(Request::OUT_HTML_CLEAN );

        if(UserError::IsError())
            return false;

        if($DiscountcardID > 0)
        {
            $discountcard = $this->catalogMgr->GetDiscountCard($DiscountcardID);
            if ($discountcard === null) {
                UserError::AddErrorIndexed('global', ERR_A_DISCOUNTCARD_NOT_FOUND);
                return false;
            }

            $discountcard->isactive = $isactive;
        }
        else
        {
            // Пока карту нельзя завести вручную
        }

        $arr_photos = array(
            // 'Icon' => array('Icon'),
        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $discountcard->$photoName = null;
                try
                {
                    $discountcard->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $discountcard->$photoName = null;
                    return false;
                }
            }
        }

        $discountcard->Update();

        return $discountcard->ID;
    }

    private function _GetOrders()
    {
         if(App::$User->IsInRole('u_order_manager') == false &&
             (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
             UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
             return STPL::Fetch('admin/modules/catalog/errors');
         }

         $page   = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);

         $status = App::$Request->Get['status']->Int(-1, Request::UNSIGNED_NUM);
         $paymentstatus = App::$Request->Get['paymentstatus']->Int(-1, Request::UNSIGNED_NUM);

         $dates = array();
         $dates['create_from'] = App::$Request->Get['create_from']->Value(Request::OUT_HTML_CLEAN);
         $dates['create_to'] = App::$Request->Get['create_to']->Value(Request::OUT_HTML_CLEAN);
         $dates['delivery_from'] = App::$Request->Get['delivery_from']->Value(Request::OUT_HTML_CLEAN);
         $dates['delivery_to'] = App::$Request->Get['delivery_to']->Value(Request::OUT_HTML_CLEAN);

         $field  = App::$Request->Get['field']->Enum('created', ['created', 'deliverydate', 'customername', 'deliverytype', 'totalprice', 'status', 'paymentstatus']);
         $dir = App::$Request->Get['dir']->Enum('desc', ['asc', 'desc']);

         $filter = [
             'flags' => [
                 'objects' => true,
                 'Status' => $status,
                 'IsArchive' => 0,
                 'PaymentStatus' => $paymentstatus,
                 'Created_from' => $dates['create_from'],
                 'Created_to' => $dates['create_to'],
                 'DeliveryDate_from' => $dates['delivery_from'],
                 'DeliveryDate_to' => $dates['delivery_to'],
             ],
             'offset'=> ($page - 1) * self::$ORDER_ROWS_COUNT,
             'limit' => self::$ORDER_ROWS_COUNT,
             'calc' => true,
             'field' => [$field],
             'dir' => [$dir],
             'dbg' => 0,
         ];

         list($orders, $count) = $this->catalogMgr->GetOrders($filter);

         $pages = Data::GetNavigationPagesNumber(
             self::$ORDER_ROWS_COUNT, self::$PAGES_ON_PAGE, $count, $page,
             "?section_id=". $this->_id ."&action=orders&field=".$field."&dir=".$dir."&create_from=".$dates['create_from']."&create_to=".$dates['create_to']."&delivery_from=".$dates['delivery_from']."&delivery_to=".$dates['delivery_to']."&status=".$status."&paymentstatus=".$paymentstatus."&page=@p@");

         return STPL::Fetch('admin/modules/catalog/orders', [
             'action'        => 'orders',
             'orders'        => $orders,
             'section_id'    => $this->_id,
             'status'        => $status,
             'paymentstatus' => $paymentstatus,
             'dates'         => $dates,
             'pages' => $pages,
             'sorting' => [
                 'field' => $field,
                 'dir' => $dir,
             ],
         ]);
    }

    private function _GetArchivedOrders()
    {
         if(App::$User->IsInRole('u_order_manager') == false &&
             (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
             UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
             return STPL::Fetch('admin/modules/catalog/errors');
         }

         $page   = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);
         $status = App::$Request->Get['status']->Int(-1, Request::UNSIGNED_NUM);
         $paymentstatus = App::$Request->Get['paymentstatus']->Int(-1, Request::UNSIGNED_NUM);

         $dates = array();
         $dates['create_from'] = App::$Request->Get['create_from']->Value(Request::OUT_HTML_CLEAN);
         $dates['create_to'] = App::$Request->Get['create_to']->Value(Request::OUT_HTML_CLEAN);
         $dates['delivery_from'] = App::$Request->Get['delivery_from']->Value(Request::OUT_HTML_CLEAN);
         $dates['delivery_to'] = App::$Request->Get['delivery_to']->Value(Request::OUT_HTML_CLEAN);

         $field  = App::$Request->Get['field']->Enum('created', ['created', 'deliverydate', 'customername', 'deliverytype', 'totalprice', 'status', 'paymentstatus']);
         $dir = App::$Request->Get['dir']->Enum('desc', ['asc', 'desc']);

         $filter = [
             'flags' => [
                 'objects' => true,
                 'Status' => $status,
                 'IsArchive' => 1,
                 'PaymentStatus' => $paymentstatus,
                 'Created_from' => $dates['create_from'],
                 'Created_to' => $dates['create_to'],
                 'DeliveryDate_from' => $dates['delivery_from'],
                 'DeliveryDate_to' => $dates['delivery_to'],
             ],
             'offset'=> ($page - 1) * self::$ORDER_ROWS_COUNT,
             'limit' => self::$ORDER_ROWS_COUNT,
             'calc' => true,
             'field' => [$field],
             'dir' => [$dir],
             'dbg' => 0,
         ];

         list($orders, $count) = $this->catalogMgr->GetOrders($filter);

         $pages = Data::GetNavigationPagesNumber(
             self::$ORDER_ROWS_COUNT, self::$PAGES_ON_PAGE, $count, $page,
             "?section_id=". $this->_id ."&action=archived_orders&field=".$field."&dir=".$dir."&create_from=".$dates['create_from']."&create_to=".$dates['create_to']."&delivery_from=".$dates['delivery_from']."&delivery_to=".$dates['delivery_to']."&status=".$status."&paymentstatus=".$paymentstatus."&page=@p@");

         return STPL::Fetch('admin/modules/catalog/orders', [
             'action'        => 'archived_orders',
             'orders'        => $orders,
             'section_id'    => $this->_id,
             'status'        => $status,
             'paymentstatus' => $paymentstatus,
             'dates'         => $dates,
             'pages' => $pages,
             'sorting' => [
                 'field' => $field,
                 'dir' => $dir,
             ],
         ]);
    }

   private function _GetOrderEdit()
   {
        if(App::$User->IsInRole('u_order_manager') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        global $DCONFIG, $CONFIG, $OBJECTS;

        $OrderID  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);


        $order = $this->catalogMgr->GetOrder($OrderID);
        $order_params['store'] = CitiesMgr::getInstance()->GetStore($order->storeid);


        if ($order === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_ORDER_NOT_FOUND);
            return STPL::Fetch('admin/modules/catalog/edit_order');
        }

        return STPL::Fetch('admin/modules/catalog/edit_order', array(
            'form'       => $form,
            'action'     => 'edit_order',
            'section_id' => $this->_id,
            'order'      => $order,
            'order_params' => $order_params,
            'causes' => static::$SURCHARGE_IDS,
        ));
   }

   private function _PostOrder()
   {
        global $DCONFIG, $CONFIG, $OBJECTS;

        LibFactory::GetStatic('bl');
        LibFactory::GetStatic('sms');
        LibFactory::GetStatic('mailsender');

        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        if(App::$User->IsInRole('u_order_manager') == false &&
            (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
            UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
            return STPL::Fetch('admin/modules/catalog/errors');
        }

        $id = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $status = App::$Request->Post['Status']->Enum(0, array_keys(CatalogMgr::$ORDER_STATUSES));
        $paymentstatus = App::$Request->Post['PaymentStatus']->Enum(0, array_keys(CatalogMgr::$PAYMENT_STATUSES));
        $isarchive = App::$Request->Post['IsArchive']->Enum(0, [0, 1]);
        $order = $this->catalogMgr->GetOrder($id);
        $old_status = $order->status;

        if($order == null)
            return false;

        if($status > 0)
            $order->status = $status;

        if($paymentstatus > 0)
            $order->paymentstatus = $paymentstatus;

        $order->isarchive = $isarchive;
        $order->Update();

        $send_mail = false;
        if($old_status != $status) {
            $msg = '';
            $mail_subject = "Статус заказа ".MAIN_DOMAIN;
            if($status == CatalogMgr::OS_ACCEPT) {
                $send_mail = true;
                $msg = "rosetta.florist: Ваш заказ №".$id." на сумму ".$order->totalprice."руб.  успешно принят в работу";
                $mail_letter = "rosetta.florist: Ваш заказ №".$id." на сумму ".$order->totalprice."руб.  успешно принят в работу";
            } elseif($status == CatalogMgr::OS_DELIVERED) {
                $send_mail = true;
                $msg = "rosetta.florist: Ваш заказ №".$id." доставлен";
                $mail_letter = "Ваш заказ №".$id." доставлен";

                $price_for_discount = $config['discount_price'];
                $discount = $config['discount_code'][CatalogMgr::DC_DISCOUNT_CODE];
                $total_price = $order->totalprice + $order->cardprice;

                $filter = [
                    'flags' => [
                        'objects' => true,
                        'OrderID' => $order->id,
                    ],
                ];

                $card_list = $this->catalogMgr->GetDiscountCards($filter);
                $has_card = false;
                if(is_array($card_list) && count($card_list) > 0) {
                    $has_card = true;
                }

                if($order->WantDiscountCard == 1
                    && $price_for_discount > 0      // установлена цена, за которую дается скидочная карта
                    && $discount > 0                // установлен размер скидки для карты
                    && $has_card == false           // на этот заказ карта не назначалась
                    && $order->DiscountCard == ''   // при заказе не была использована скидочная карта
                    && $total_price >= $price_for_discount) {

                    // Назначение скидочной карты
                    // Проверить, что этому челу уже назначали скидочную карту.
                    $card = $this->catalogMgr->GenerateDiscountCard();
                    $card->orderid = $order->id;
                    $card->update();

                    if($config['notice']['email']) {
                        $dcard_mail = new MailSender();
                        $dcard_mail->AddAddress('from', 'no-reply@rosetta.florist', "Служба уведомлений", 'utf-8');
                        $dcard_mail->AddHeader('Subject', "Скидочная карта в интернет-магазине Розетта ".$this->_env['site']['domain'], 'utf-8');
                        $dcard_mail->body_type = MailSender::BT_HTML;
                        $dcard_mail->AddAddress('to', $order->customeremail);

                        $dcard_letter = STPL::Fetch('modules/catalog/mail/discountcard', [
                            'cardcode' => $card->code,
                            'date' => CatalogMgr::$weekdate[date('w', time())].", ".date('d.m.Y', time()),
                            // 'domain' => $this->_env['site']['domain'],
                            'domain' => MAIN_DOMAIN,
                        ]);

                        $dcard_mail->AddBody('text', $dcard_letter, MailSender::BT_HTML, 'utf-8');
                        $dcard_mail->SendImmediate();
                    }

                    if($msg && $config['notice']['sms']) {
                        $sms = new SMS();
                        $result = $sms->send($order->customerphone, "rosetta.florist: Cкидка 5% на покупки по коду ".$card->code, $config['sms']['login'], $config['sms']['password']);
                    }

                } else {
                    // error_log('no card');
                }
            }

            if($msg && $config['notice']['sms']) {
                $sms = new SMS();
                $result = $sms->send($order->customerphone, $msg);
            }

            if($send_mail && $config['notice']['email']) {
                $mail = new MailSender();
                $mail->AddAddress('from', 'no-reply@rosetta.florist', "Служба уведомлений", 'utf-8');
                $mail->AddHeader('Subject', $mail_subject, 'utf-8');
                $mail->body_type = MailSender::BT_HTML;
                $mail->AddAddress('to', $order->customeremail);

                $mail->AddBody('text', $mail_letter, MailSender::BT_HTML, 'utf-8');
                $mail->SendImmediate();
            }
        }

        return true;
    }


    private function _PostUpdateMemberPrice() {
        global $DCONFIG, $CONFIG;

        $member_id  = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $value      = App::$Request->Post['value']->Dec(0, Request::DECIMAL_NUM);
        $catalog_id = App::$Request->Post['catalog_id']->Int(0, Request::UNSIGNED_NUM);

        $RefParams = [
            'MemberID'     => $member_id,
            'SectionID'    => $catalog_id,
            'Price'        => $value,
        ];

        $result = $this->catalogMgr->UpdateMemberAreaRef($RefParams);

        if($value == 0 ) {
            $products = $member->GetProducts();
            foreach($products as $product) {
                $category = $product->category;

                 if($category->Kind == CatalogMgr::CK_BOUQUET || $category->Kind == CatalogMgr::CK_MONO || $category->Kind == CatalogMgr::CK_FIXED) {

                    $type = $product->default_type;
                    if($type === null)
                        $price = 0;
                    else
                        $price = $type->GetPrice($this->_id);
                } elseif($category->Kind == CatalogMgr::CK_ROSE) {
                    $price = $product->GetPrice($product->length, $product->count, $this->_id);
                }

                if($price < 500) {
                    $filter['TypeIds'] = $category->Kind == CatalogMgr::CK_WEDDING ? [9] : [1,3,10];
                    $filter['SectionID'] = $this->_id;

                    $ord =  $this->catalogMgr->GetLastOrd($filter);
                    $ord++;

                    $RefParams = [
                        'SectionID' => $this->_id,
                    ];

                    if(!is_null($ord))
                        $RefParams['Ord'] = $ord;

                    $product->UpdateAreaRef($RefParams);
                }
            }
        }

        if($result)
            return true;
        else
            return false;
    }

    private function _PostUpdateMembers()
    {
        global $DCONFIG, $CONFIG;
        LibFactory::GetStatic('phpexcel');
        ini_set('set_execution_time', 300);
        ini_set('memory_limit', '128M');

        $uploadfile = $_FILES['update_file'];
        if(!isset($uploadfile['tmp_name']))
        {
            UserError::AddErrorIndexed('global', ERR_A_CTL_UPDATE_FILE_EMPTY);
            return false;
        }

        $inputFileType = PHPExcel_IOFactory::identify($uploadfile['tmp_name']);
        $parser = PHPExcel_IOFactory::createReader($inputFileType);
        // $parser = PHPExcel_IOFactory::createReader('Excel5');
        $parser->setReadDataOnly(true);

        // var_dump(file_exists($uploadfile['tmp_name']));

        $objPHPExcel  = $parser->load($uploadfile['tmp_name']);
        $objPHPExcel->setActiveSheetIndex(0);
        $worksheet = $objPHPExcel->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $pids = [];
        $updated = [];
        $not_used = [];
        $i = 0;
        for ($row = 1; $row <= $highestRow; ++$row)
        {
            $articleCell = $worksheet->getCellByColumnAndRow(0, $row);
            $article = $articleCell->getValue();

            if($article == '#N/A' || $article === null || mb_strlen($article) == 0)
                continue;

            $priceCell = $worksheet->getCellByColumnAndRow(1, $row);
            $price = $priceCell->getValue();
            $price = str_replace(",", ".", $price);


            $nameCell = $worksheet->getCellByColumnAndRow(2, $row);
            $name = $nameCell->getValue();

            if(is_null($name)) {
                $member = $this->catalogMgr->GetMemberByArticle($article);
            } else {
                $member = $this->catalogMgr->GetMemberByName($name);
                $member->Name = $name;
            }

            if($member == null && !is_null($name)) {
                 $Data = [
                    'Name'      => $name,
                    'CatalogID' => $this->_id,
                ];

                $member = new Member($Data);
            }

            if($member === null) {
                array_push($not_used, $this->coalesce($article, $name));
                continue;
            }

            $member->article = $article;
            $member->Update();
            $RefParams = [
                'MemberID'     => $member->ID,
                'SectionID'    => $this->_id,
                'Price'        => $price,
            ];

            $this->catalogMgr->UpdateMemberAreaRef($RefParams);

            $filter = [
                'ids' => [$member->ID],
                'CatalogID' => $this->_id,
            ];
            $city_has_member = $this->catalogMgr->GetMemberAreaRefsByIds($filter);
            foreach ($city_has_member as $value) {
                 array_push($updated, $value['MemberID']);
            }


            $products = $member->GetProducts();
            foreach($products as $product) {
                if(!isset($pids[$product->id]))
                    $pids[$product->id] = $product;

                ++$i;
                // echo $product->id."<br>";
                // $product->CachePrice($this->_id);
            }

        }

        foreach($pids as $product) {
            $product->CachePrice($this->_id);
        }

        $this->_setMessage();


        $_SESSION['not_used'] = json_encode($not_used);

        return $updated;


    }


    private function _PostLoadCards()
    {
        global $DCONFIG, $CONFIG;
        LibFactory::GetStatic('phpexcel');
        ini_set('set_execution_time', 0);
        ini_set('memory_limit', '512M');

        $uploadfile = $_FILES['update_file'];
        if(!isset($uploadfile['tmp_name']))
        {
            UserError::AddErrorIndexed('global', ERR_A_CTL_UPDATE_FILE_EMPTY);
            return false;
        }

        $inputFileType = PHPExcel_IOFactory::identify($uploadfile['tmp_name']);
        $parser = PHPExcel_IOFactory::createReader($inputFileType);
        // $parser = PHPExcel_IOFactory::createReader('Excel5');
        $parser->setReadDataOnly(true);

        // var_dump(file_exists($uploadfile['tmp_name']));

        $objPHPExcel  = $parser->load($uploadfile['tmp_name']);
        $objPHPExcel->setActiveSheetIndex(0);
        $worksheet = $objPHPExcel->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $pids = [];
        $updated = [];
        $not_used = [];
        $i = 0;
        for ($row = 1; $row <= $highestRow; ++$row)
        {
            $codeCell = $worksheet->getCellByColumnAndRow(0, $row);
            $code = $codeCell->getValue();

            $isActive = $worksheet->getCellByColumnAndRow(1, $row);
            $isActive = $isActive->getValue();
            $isActive = (int)$isActive == 1;

            if($this->catalogMgr->ValidateDiscountCard($code) == false)
                continue;

            $discountcard = $this->catalogMgr->GetDiscountCardByCode($code);
            if($discountcard === null)  {
                $data = [
                    'Code' => $code,
                    'OrderID' => 0,
                    'IsActive' => $isActive,
                ];

                $discountcard = new DiscountCard($data);
            } else {
                $discountcard->isactive = $isActive;
            }

            $discountcard->Update();

            // if(is_null($name)) {
            //     $member = $this->catalogMgr->GetMemberByArticle($article);
            // } else {
            //     $member = $this->catalogMgr->GetMemberByName($name);
            //     $member->Name = $name;
            // }

            // if($member == null && !is_null($name)) {
            //      $Data = [
            //         'Name'      => $name,
            //         'CatalogID' => $this->_id,
            //     ];

            //     $member = new Member($Data);
            // }

            // if($member === null) {
            //     array_push($not_used, $this->coalesce($article, $name));
            //     continue;
            // }
        }

        $this->_setMessage('Номера карт загружены');


        // $_SESSION['not_used'] = json_encode($not_used);

        return $updated;
    }

    private function coalesce() {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!empty($arg)) {
                return $arg;
            }
        }
        return null;
    }

}