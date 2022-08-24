<?php

if(1)
{
    $error_code = 0;
    define('ERR_A_PAGE_MASK', 0x00590000);
    define('ERR_A_PAGE_UNKNOWN_ERROR', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAGE_UNKNOWN_ERROR] = 'Незвестная ошибка.';

    define('ERR_A_PAGE_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAGE_NOT_FOUND] = 'Страница не найдена.';

    define('ERR_A_PAGE_NAME_EXCEED', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAGE_NAME_EXCEED] = 'Максимальная длина Названия 200 символов.';

    define('ERR_A_PAGE_NAME_EMPTY', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAGE_NAME_EMPTY] = 'Название не может быть пустым.';

    define('ERR_A_PAGE_NAMEID_EMPTY', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAGE_NAMEID_EMPTY] = 'ID домена не может быть пустым.';

    define('ERR_A_CITY_DOMAIN_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_CITY_DOMAIN_NOT_FOUND] = 'Город (домен) не найден.';

    define('ERR_A_CITY_DELIVERY_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_CITY_DELIVERY_NOT_FOUND] = 'Город доставки не найден.';

    define('ERR_A_DISTRICT_DELIVERY_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_DISTRICT_DELIVERY_NOT_FOUND] = 'Район доставки не найден.';

    define('ERR_A_STORE_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_STORE_NOT_FOUND] = 'Магазин не найден.';

    define('ERR_A_CITY_STORE_PHOTO_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_CITY_STORE_PHOTO_NOT_FOUND] = 'Фото магазина не найдено';

    define('ERR_A_STORE_EMAIL_WRONG_FORMAT', ERR_A_PAGE_MASK | $error_code++);
    UserError::$Errors[ERR_A_STORE_EMAIL_WRONG_FORMAT] = 'Неверный формат электронной почты';
}


class AdminModule
{
    static $TITLE = 'Текстовая страница';

    private $_db;

    private $_config;

    private $_page;
    private $_id;
    private $_title;
    private $citymgr;
    private $pmmgr;

    function __construct($config, $aconfig, $id) {
        global $OBJECTS;

        $this->_id = &$id;
        $this->_config = &$config;
        $this->_aconfig = &$aconfig;
        $this->_db = DBFactory::GetInstance($this->_config['db']);

        LibFactory::GetMStatic('cities', 'citiesmgr');
        LibFactory::GetMStatic('payments', 'paymentmgr');

        $this->citymgr = CitiesMgr::GetInstance();
        $this->pmmgr = PaymentMgr::GetInstance();

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");

        LibFactory::GetStatic('cache');
        LibFactory::GetStatic('data');

        App::$Title->AddScript('http://maps.api.2gis.ru/1.0');
        App::$Title->AddScript('/resources/scripts/modules/cities/cities.js');

        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-1.10.2.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js');

        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

        App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');
        App::$Title->AddScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU');
    }

    // обязательные функции
    function Action()
    {
        if($this->_PostAction()) return;
        $this->_GetAction();
    }

    function GetPage()
    {
        switch($this->_page)
        {
            // photos
            case 'new_photo':
                $this->_title = "Добавить фото";
                $html = $this->_GetPhotoNew();
                break;
            case 'edit_photo':
                $this->_title = "Редактировать";
                $html = $this->_GetPhotoEdit();
                break;
            case 'delete_photo':
                $this->_GetPhotoDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=store_photos&storeid='.$_GET['storeid']);
                break;
            case 'store_photos':
                $this->_title = "Список фотографии";
                $html = $this->_GetPhotos();
                break;
            case 'ajax_photo_toggle_visible':
                $this->_GetAjaxTogglePhotoVisible();
                break;
            // stores
            case 'stores':
                $this->_title = "Список магазинов";
                $html = $this->_GetStores();
                break;
            case 'new_store':
                $this->_title = "Добавить магазин";
                $html = $this->_GetStoreNew();
                break;
            case 'edit_store':
                $this->_title = "Редактировать магазин";
                $html = $this->_GetStoreEdit();
                break;
            case 'ajax_store_toggle_available':
                $this->_GetAjaxToggleStoreAvailable();
                break;
            case 'ajax_store_toggle_pickup':
                $this->_GetAjaxToggleStorePickup();
                break;
            case 'delete_store':
                $this->_GetStoreDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&cityid='.$_GET['cityid']);
                break;
            // delivery districts
            case 'districts':
                $this->_title = "Список районов";
                $html = $this->_GetDeliveryDistricts();
                break;
            case 'new_district':
                // $this->_title = "Добавить район";
                $html = $this->_GetDeliveryDistrictNew();
                break;
            case 'edit_district':
                $this->_title = "Редактировать район";
                $html = $this->_GetDeliveryDistrictEdit();
                break;
            case 'delete_district':
                $this->_GetDeliveryDistrictDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&cityid='.$_GET['cityid']);
                break;
            // cities domain
            case 'cities':
                $this->_title = "Список городов";
                $html = $this->_GetCities();
                break;
            case 'new_city':
                $this->_title = "Добавить город";
                $html = $this->_GetCityNew();
                break;
            case 'edit_city':
                $this->_title = "Редактировать город";
                $html = $this->_GetEditCity();
                break;
            case 'ajax_city_toggle_visible':
                $this->_GetAjaxToggleCityVisible();
                break;
            case 'ajax_city_toggle_default':
                $this->_GetAjaxToggleCityDefault();
                break;
            case 'delete_city':
                $this->_GetCityDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
                break;
            case 'delivery_cities':
                $html = $this->_GetDeliveryCities();
                break;
            case 'new_delivery':
                $this->_title = "Редактировать город";
                $html = $this->_GetDeliveryNew();
                break;
            case 'edit_delivery':
                $this->_title = "Редактировать город";
                $html = $this->_GetDeliveryEdit();
                break;
            case 'ajax_city_toggle_available':
                $this->_GetAjaxToggleDeliveryAvailable();
                break;
            case 'ajax_district_toggle_available':
                $this->_GetAjaxToggleDeliveryDistrictAvailable();
                break;
            case 'delete_delivery':
                $this->_GetDeliveryDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_GET['cityid']);
                break;
            default:
                $this->_title = "Редактировать город";
                $html = $this->_GetCities();
                break;
        }
        return $html;
    }

    function GetTabs() {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'cities', 'text' => 'Города'),
            ),
            'selected' => $this->_page);
    }

    function GetTitle() {
        return $this->_title;
    }

    // обработка запросов
    private function _PostAction() {
        global $DCONFIG, $OBJECTS;

        switch($_POST['action'])
        {
            case 'new_photo':
                if (($pid = $this->_PostPhoto()) > 0)
                {
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=store_photos&storeid='.$_POST['storeid']);
                }
                break;
            case 'edit_photo':
                if (($pid = $this->_PostPhoto()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=store_photos&storeid='.$_POST['storeid']);
                break;

            case 'save_photos':
                if (($this->_PostSavePhotos()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=store_photos&storeid='.$_POST['storeid']);
                break;
            // store actions
            case 'new_store':
                if ($this->_PostStoreNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&cityid='.$_POST['cityid']);
                break;
            case 'edit_store':
                if ($this->_PostStoreEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&cityid='.$_POST['cityid']);
                break;
            case 'save_stores':
                if ($this->_PostStoresSave())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&cityid='.$_POST['cityid']);
                break;
            // districts actions
            case 'new_district':
                if ($this->_PostDeliveryDistrictNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&cityid='.$_POST['cityid']);
                break;
            case 'edit_district':
                if ($this->_PostDeliveryDistrictEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&cityid='.$_POST['cityid']);
                break;
            case 'save_districts':
                if ($this->_PostDeliveryDistrictsSave())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
                break;

            case 'new_city':
                if ($this->_PostCityNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
                break;
            case 'edit_city':
                if ($this->_PostCityEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
                break;
            // Редирект на список доставок, а не городов/доменов.
            case 'new_delivery':
                if ($this->_PostDeliveryNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_POST['сityid']);
                break;
            case 'edit_delivery':
                if ($this->_PostDeliveryEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_POST['сityid']);
                break;
        }
        return false;
    }

    private function _GetAction() {
        global $DCONFIG;
        switch($_GET['action'])
        {
            default:
                $this->_page = $_GET['action'];
                break;
        }
    }

    private function _GetDeliveryDistricts()
    {
        $cityid     = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($cityid);
        if($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_list');
        }


        $filter = array(
            'flags' => array(
                'objects' => true,
                'CityID' => $cityid,
                'IsAvailable' => -1,
            ),
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        );
        $districts = $this->citymgr->GetDistricts($filter);

        // $crumbs = array(
        //     0 => array(
        //         'name' => 'Города',
        //         'url' => '?section_id='.$this->_id.'&action=cities',
        //     ),
        //     1 => array(
        //         'name' => 'Города доставки',
        //         'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$cityid,
        //     ),
        // );

        return STPL::Fetch('admin/modules/cities/district_list', array(
            'section_id' => $this->_id,
            'districts' => $districts,
            'cityid' => $cityid,
            'crumbs' => $crumbs,
        ));
    }

    private function _GetDeliveryDistrictNew() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $cityid      = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }

        $form = array();
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $cityid;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
            $form['Price'] = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
            $form['AccountID'] = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);
        }
        else
        {
            $form['Name']        = '';
            $form['Email']       = '';
            $form['IsAvailable'] = 1;
            $form['IsDefault'] = 0;
            $form['Price']       = 0;
            $form['AccountID']   = 0;
        }

        // $crumbs = array(
        //     0 => array(
        //         'name' => 'Города',
        //         'url' => '?section_id='.$this->_id.'&action=cities',
        //     ),
        //     1 => array(
        //         'name' => 'Города доставки',
        //         'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->ID,
        //     ),
        //     2 => array(
        //         'name' => 'Районы ('.$delivery->Name.')',
        //         'url' => '?section_id='.$this->_id.'&action=districts&deliveryid='.$delivery->ID,
        //     ),
        // );

        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
        );

        $pm_accounts = $this->pmmgr->GetAccounts($filter);

        return STPL::Fetch('admin/modules/cities/district_edit', array(
            'section_id'  => $this->_id,
            'form'        => $form,
            'action'      => 'new_district',
            // 'crumbs'      => $crumbs,
            'pm_accounts' => $pm_accounts,
        ));
    }

    private function _GetDeliveryDistrictEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id      = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $district = $this->citymgr->GetDistrict($id);
        if ($district === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_DISTRICT_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form['DistrictID'] = $district->ID;
        $form['SectionID']  = $this->_id;
        // $form['DeliveryID'] = $district->DeliveryID;
        // $delivery = $this->citymgr->GetDelivery($district->DeliveryID);
        $form['CityID'] = $district->CityID;
        $city = $this->citymgr->GetCity($form['CityID']);

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['IsDefault']   = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
            $form['Price']       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
            $form['AccountID']   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);
        }
        else
        {
            $form['Name']        = $district->Name;
            $form['Email']       = $district->Email;
            $form['IsAvailable'] = $district->IsAvailable;
            $form['IsDefault']   = $district->IsDefault;
            $form['Price']       = $district->Price;
            $form['AccountID']   = $district->AccountID;
        }

        // $crumbs = array(
        //     0 => array(
        //         'name' => 'Города',
        //         'url' => '?section_id='.$this->_id.'&action=cities',
        //     ),
        //     1 => array(
        //         'name' => 'Города доставки',
        //         'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->ID,
        //     ),
        //     2 => array(
        //         'name' => 'Районы ('.$delivery->Name.')',
        //         'url' => '?section_id='.$this->_id.'&action=districts&deliveryid='.$delivery->ID,
        //     ),
        // );

        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
        );

        $pm_accounts = $this->pmmgr->GetAccounts($filter);

        return STPL::Fetch('admin/modules/cities/district_edit', array(
            'section_id'  => $this->_id,
            'form'        => $form,
            'action'      => 'edit_district',
            // 'crumbs'      => $crumbs,
            'pm_accounts' => $pm_accounts,
        ));
    }

    private function _PostDeliveryDistrictNew()
    {
        $cityid  = App::$Request->Post['cityid']->Int(0, Request::UNSIGNED_NUM);
        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $IsDefault   = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $Price       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        $AccountID   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);

        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_district');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $data = array(
            'CityID'      => $cityid,
            'Name'        => $Name,
            'Price'       => $Price,
            // 'Email'    => $Email,
            'IsAvailable' => $IsAvailable,
            'IsDefault'   => $IsDefault,
            'AccountID'   => $AccountID,
        );

        $district = new District($data);

        if($IsDefault == 1) {
            $filter = [
                'flags' => [
                    'objects' => true,
                    'CityID' => $cityid,
                    'IsAvailable' => -1,
                ]
            ];

            $districts = $this->citymgr->GetDistricts($filter);
            foreach($districts as $delivery_district) {
                if($delivery_district->ID == $district->ID)
                    continue;

                $delivery_district->IsDefault = 0;
                $delivery_district->Update();
            }
        }

        $district->Update();

        return true;
    }

    private function _GetDeliveryDistrictDelete()
    {
        $districtid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $district = $this->citymgr->GetDistrict($districtid);
        if ($district === null)
            return;

        $district->Remove();
        return;
    }

    private function _PostDeliveryDistrictEdit()
    {
        $id          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $cityid      = App::$Request->Post['cityid']->Int(0, Request::UNSIGNED_NUM);
        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $IsDefault   = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        $Price       = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        $AccountID   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);

        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }

        $district = $this->citymgr->GetDistrict($id);
        if($district === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_DISTRICT_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }
        $old_default = $district->IsDefault;

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $district->Name        = $Name;
        $district->Email       = $Email;
        $district->Price       = $Price;
        $district->IsAvailable = $IsAvailable;
        $district->IsDefault   = $IsDefault;
        $district->AccountID   = $AccountID;
        $district->Update();

        if($IsDefault == 1 && $old_default == 0) {
            $filter = [
                'flags' => [
                    'objects' => true,
                    'CityID' => $cityid,
                    'IsAvailable' => -1,
                ]
            ];

            $districts = $this->citymgr->GetDistricts($filter);

            foreach($districts as $delivery_district) {
                if($delivery_district->ID == $district->ID)
                    continue;

                $delivery_district->IsDefault = 0;
                $delivery_district->Update();
            }
        }

        return true;
    }

    private function _GetAjaxToggleDeliveryDistrictAvailable()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $districtid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $district = $this->citymgr->GetDistrict($districtid);
        if ($district === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $district->IsAvailable = !$district->IsAvailable;
        $district->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int) $district->IsAvailable,
            'districtid' => $districtid,
        ));
        exit;
    }

    private function _PostDeliveryDistrictsSave()
    {
        $orders = App::$Request->Post['Ord']->AsArray();
        foreach($orders as $districtid => $ord)
        {
            $district = $this->citymgr->GetDistrict($districtid);
            if($district === null)
                contniue;

            $district->Ord = $ord;
            $district->Update();
        }
    }

    //  =============================

    private function _GetDeliveryCities()
    {
        $cityid     = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $filter = array(
            'flags' => array(
                'objects' => true,
                'CityID' => $cityid,
                'IsAvailable' => -1,
            ),
        );

        $delivery_cities = $this->citymgr->GetDeliveries($filter);
        return STPL::Fetch('admin/modules/cities/delivery_list', array(
            'section_id' => $this->_id,
            'delivery' => $delivery_cities,
            'cityid' => $cityid,
        ));
    }

    private function _GetDeliveryNew() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $CityID      = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form = array();
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $CityID;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']        = '';
            $form['Email']       = '';
            $form['IsAvailable'] = 1;
        }

        return STPL::Fetch('admin/modules/cities/delivery_edit', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'action'        => 'new_delivery',
        ));
    }

    private function _GetDeliveryEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $ID      = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($ID);
        if ($delivery === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form['DeliveryID'] = $delivery->ID;
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $delivery->CityID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']        = $delivery->Name;
            $form['Email']       = $delivery->Email;
            $form['IsAvailable'] = $delivery->IsAvailable;

        }

        return STPL::Fetch('admin/modules/cities/delivery_edit', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'action'        => 'edit_delivery',
        ));
    }

    private function _PostDeliveryNew()
    {
        $CityID      = App::$Request->Post['сityid']->Int(0, Request::UNSIGNED_NUM);
        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));

        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $data = array(
            'CityID'      => $CityID,
            'Name'        => $Name,
            'Email'        => $Email,
            'IsAvailable' => $IsAvailable,
        );

        $delivery = new DeliveryCity($data);
        $delivery->Update();

        return true;
    }

    private function _PostDeliveryEdit()
    {
        $ID      = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $CityID      = App::$Request->Post['сityid']->Int(0, Request::UNSIGNED_NUM);
        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $delivery = $this->citymgr->GetDelivery($ID);
        if($delivery === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $delivery->Name        = $Name;
        $delivery->Email       = $Email;
        $delivery->IsAvailable = $IsAvailable;
        $delivery->Update();

        return true;
    }

    private function _GetAjaxToggleDeliveryAvailable()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $DeliveryID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($DeliveryID);
        if ($delivery === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $delivery->IsAvailable = !$delivery->IsAvailable;
        $delivery->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int) $delivery->IsAvailable,
            'deliveryid' => $DeliveryID,
        ));
        exit;
    }

    private function _GetDeliveryDelete()
    {
        $DeliveryID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($DeliveryID);
        if ($delivery === null)
            return;

        $delivery->Remove();
        return;
    }

    private function _GetCities()
    {
        global $DCONFIG, $CONFIG;

        // $page        = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);
        $field  = App::$Request->Get['field']->Enum('name', ['name', 'isvisible']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
                // 'SectionID' => $this->_id,
            ),
            'field' => [$field],
            'dir' => [$dir],
            // 'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
            // 'limit' => self::$ROW_ON_PAGE,
            // 'calc'   => true,
            'dbg' => 0,
        );

        $cities = $this->citymgr->GetCities($filter);

        // $pages = Data::GetNavigationPagesNumber(
        //  self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
        //  "?section_id=". $this->_id ."&action=articles&page=@p@");

        return STPL::Fetch('admin/modules/cities/cities_list', array(
            'section_id' => $this->_id,
            'cities' => $cities,
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetCityNew() {

        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

        $form = array();

        $form['SectionID'] = $this->_id;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
            $form['Street'] = App::$Request->Post['Street']->Value(Request::OUT_HTML);
            $form['Domain'] = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
            $form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
            $form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Phone'] = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['Latitude'] = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
            $form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
            $form['SEOText'] = App::$Request->Post['SEOText']->Value();
            $form['Metrika'] = App::$Request->Post['Metrika']->Value();
        }
        else
        {
            $form['NameID']      = '';
            $form['Street']    = '';
            $form['Domain']    = '';
            $form['CatalogId'] = '';
            $form['PhoneCode'] = '';
            $form['Phone']     = '';
            $form['Latitude']  = '';
            $form['Longitude'] = '';
            $form['SEOText']   = '';
            $form['Metrika']   = '';
            $form['IsVisible'] = 1;
            $form['IsDefault'] = 0;
        }

        return STPL::Fetch('admin/modules/cities/edit_city', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'action'        => 'new_city',
        ));
    }

    // Редактировать
    private function _GetEditCity()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_city');
        }

        $form['CityID'] = $city->ID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['action'] = 'new_city';
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
            $form['Street'] = App::$Request->Post['Street']->Value(Request::OUT_HTML);
            $form['Domain'] = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
            $form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
            $form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Phone'] = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['Latitude'] = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
            $form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
            $form['SEOText'] = App::$Request->Post['SEOText']->Value();
            $form['Metrika'] = App::$Request->Post['Metrika']->Value();
        }
        else
        {
            $form['action']    = 'edit_city';
            $form['Name']      = $city->Name;
            $form['NameID']      = $city->NameID;
            $form['IsVisible'] = (int) $city->IsVisible;
            $form['IsDefault'] = (int) $city->IsDefault;
            $form['Street']    = $city->Street;
            $form['Domain']    = $city->Domain;
            $form['CatalogId'] = $city->CatalogId;
            $form['PhoneCode'] = $city->PhoneCode;
            $form['Phone']     = $city->Phone;
            $form['Latitude']  = $city->Latitude != "" ? $city->Latitude : 0;
            $form['Longitude'] = $city->Longitude!= "" ? $city->Longitude : 0;
            $form['SEOText']   = $city->SEOText;
            $form['Metrika']   = $city->Metrika;
        }

        return STPL::Fetch('admin/modules/cities/edit_city', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'action'        => 'edit_city',
        ));
    }

    private function _GetAjaxToggleCityVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $city->IsVisible = !$city->IsVisible;
        $city->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $city->IsVisible,
            'cityid' => $CityID,
        ));
        exit;
    }

    private function _GetAjaxToggleCityDefault()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
            ),
        );
        $cities = $this->citymgr->GetCities($filter);
        foreach ($cities as $item) {
            // $item->IsDefault = 0;
            $item->IsDefault = !$item->IsDefault;
            $item->Update();
        }

        $city->IsDefault = !$city->IsDefault;
        $city->Update();

        $json->send(array(
            'status' => 'ok',
            'default' => (int) $city->IsDefault,
            'cityid' => $CityID,
        ));
        exit;
    }

    private function _GetCityDelete()
    {
        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
            return;

        $city->Remove();
        return;
    }

    // Создать
    private function _PostCityNew()
    {
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $NameID = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        $Street = App::$Request->Post['Street']->Value(Request::OUT_HTML);
        $Domain = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
        $CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
        $PhoneCode = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
        $Phone = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
        $Latitude = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
        $Longitude = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
        $SEOText = App::$Request->Post['SEOText']->Value();
        $Metrika = App::$Request->Post['Metrika']->Value();

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('NameID', ERR_A_PAGE_NAMEID_EMPTY);

        if (strlen($Name) > 200)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);

        if (UserError::IsError())
            return false;

        $data = array(
            'SectionID'     => $this->_id,
            'Name'          => $Name,
            'NameID'        => $NameID,
            'IsVisible'     => $IsVisible,
            'IsDefault'     => $IsDefault,
            'Street'        => $Street,
            'Domain'        => $Domain,
            'CatalogId'     => $CatalogId,
            'PhoneCode'     => $PhoneCode,
            'Phone'         => $Phone,
            'Latitude'      => $Latitude,
            'Longitude'     => $Longitude,
            'SEOText'       => $SEOText,
            'Metrika'       => $Metrika,
        );

        $city = new City($data);
        $city->Update();

        return true;
    }

    // Обновить
    private function  _PostCityEdit()
    {
        $CityID    = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name      = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $NameID    = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        $Street    = App::$Request->Post['Street']->Value(Request::OUT_HTML);
        $Domain    = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
        $CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
        $PhoneCode = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
        $Phone     = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
        $Latitude  = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
        $Longitude = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
        $SEOText   = App::$Request->Post['SEOText']->Value();
        $Metrika   = App::$Request->Post['Metrika']->Value();

        $city = $this->citymgr->GetCity($CityID);
        if ($city === null)
            UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);

        if (UserError::IsError())
            return false;

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (strlen($NameID) == 0)
            UserError::AddErrorIndexed('NameID', ERR_A_PAGE_NAMEID_EMPTY);

        if (strlen($Name) > 200)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);

        if (UserError::IsError())
            return false;

        $city->Name = $Name;
        $city->NameID = $NameID;
        $city->IsVisible = $IsVisible;
        $city->IsDefault = $IsDefault;
        $city->Street = $Street;
        $city->Domain = $Domain;
        $city->CatalogId = $CatalogId;
        $city->PhoneCode = $PhoneCode;
        $city->Phone = $Phone;
        $city->Latitude = $Latitude;
        $city->Longitude = $Longitude;
        $city->SEOText = $SEOText;
        $city->Metrika = $Metrika;

        $res = $city->Update();

        return true;
    }

    // store section
    private function _GetStores()
    {
        $cityid     = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);

        $city = $this->citymgr->GetCity($cityid);
        if($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/stores_list');
        }


        $filter = array(
            'flags' => array(
                'objects' => true,
                'CityID' => $cityid,
                'IsAvailable' => -1,
            ),
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        );

        $stores = $this->citymgr->GetStores($filter);

        $crumbs = array(
            // 0 => array(
            //     'name' => 'Города',
            //     'url' => '?section_id='.$this->_id.'&action=cities',
            // ),
            // 1 => array(
            //     'name' => 'Города доставки',
            //     'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->CityID,
            // ),
        );

        return STPL::Fetch('admin/modules/cities/stores_list', array(
            'section_id' => $this->_id,
            'stores'     => $stores,
            'cityid'     => $cityid,
            'crumbs'     => $crumbs,
            'action'     => 'new_store',
            'city'       => $delivery,
        ));
    }

    private function _GetStoreNew() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $cityid      = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/store_edit');
        }

        $form = array();
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $cityid;
        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Address']     = App::$Request->Post['Address']->Value(Request::OUT_HTML);
            $form['Phone']       = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['PhoneCode']   = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Longitude']   = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
            $form['Latitude']    = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['Workmode']    = App::$Request->Post['Workmode']->Value();
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['HasPickup']   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
            $form['AccountID']   = App::$Request->Get['AccountID']->Int(0, Request::UNSIGNED_NUM);
            $form['Type'] = App::$Request->Post['Type']->Enum(0, array_keys(CitiesMgr::$TYPES));
        }
        else
        {
            $form['Name']        = '';
            $form['Address']     = '';
            $form['Email']       = '';
            $form['Phone']       = '';
            $form['Workmode']    = '';
            $form['PhoneCode']   = '';
            $form['IsAvailable'] = 1;
            $form['HasPickup']   = 1;
            $form['Longitude']   = 0;
            $form['Latitude']    = 0;
            $form['AccountID']   = 0;
            $form['Type']        = 0;
        }

        $crumbs = array(
            // 0 => array(
            //  'name' => 'Города',
            //  'url' => '?section_id='.$this->_id.'&action=cities',
            // ),
            // 1 => array(
            //  'name' => 'Города доставки',
            //  'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->ID,
            // ),
            // 2 => array(
            //  'name' => 'Районы ('.$delivery->Name.')',
            //  'url' => '?section_id='.$this->_id.'&action=districts&deliveryid='.$delivery->ID,
            // ),
        );


        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
        );

        $pm_accounts = $this->pmmgr->GetAccounts($filter);

        return STPL::Fetch('admin/modules/cities/store_edit', array(
            'section_id'  => $this->_id,
            'form'        => $form,
            'action'      => 'new_store',
            'crumbs'      => $crumbs,
            'city'        => $delivery,
            'pm_accounts' => $pm_accounts,
        ));
    }

    private function _PostStoreNew()
    {
        $cityid  = App::$Request->Post['cityid']->Int(0, Request::UNSIGNED_NUM);

        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $Phone       = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
        $PhoneCode   = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
        $Address     = App::$Request->Post['Address']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $HasPickup   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
        $Longitude   = App::$Request->Post['Longitude']->Value();
        $Latitude    = App::$Request->Post['Latitude']->Value();
        $Workmode    = App::$Request->Post['Workmode']->Value();
        $AccountID   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);
        $Type = App::$Request->Post['Type']->Enum(0, array_keys(CitiesMgr::$TYPES));

        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {

            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_store');
        }
        // if (strlen($Name) == 0)
        //  UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if ($Email == false)
            UserError::AddErrorIndexed('Email', ERR_A_STORE_EMAIL_WRONG_FORMAT);

        if (UserError::IsError())
        {
            // print_r(UserError::GetErrorsText());
            // exit;
            return false;
        }

        $data = array(
            'CityID'  => $cityid,
            'Name'        => $Name,
            'Phone'       => $Phone,
            'PhoneCode'   => $PhoneCode,
            'Email'       => $Email,
            'Address'     => $Address,
            'HasPickup'   => $HasPickup,
            'IsAvailable' => $IsAvailable,
            'Longitude'   => $Longitude,
            'Latitude'    => $Latitude,
            'Workmode'    => $Workmode,
            'AccountID'   => $AccountID,
            'Type'   => $Type,
        );

        $store = new Store($data);
        $store->Update();

        return true;
    }

    private function _GetStoreEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id      = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($id);

        if ($store === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_STORE_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/store_edit');
        }

        $form['StoreID']   = $store->ID;
        $form['SectionID'] = $store->_id;
        $form['CityID']    = $store->CityID;

        $city = $this->citymgr->GetCity($store->CityID);

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['AccountID']   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);
            $form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Address']     = App::$Request->Post['Address']->Value(Request::OUT_HTML);
            $form['Phone']       = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['PhoneCode']   = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Email']       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
            $form['HasPickup']   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
            $form['Longitude']   = App::$Request->Post['Longitude']->Value();
            $form['Latitude']    = App::$Request->Post['Latitude']->Value();
            $form['Workmode']    = App::$Request->Post['Workmode']->Value();
            $form['Type'] = App::$Request->Post['Type']->Enum(0, array_keys(CitiesMgr::$TYPES));
        }
        else
        {
            $form['Name']        = $store->Name;
            $form['Address']     = $store->Address;
            $form['Email']       = $store->Email;
            $form['IsAvailable'] = $store->IsAvailable;
            $form['HasPickup']   = $store->HasPickup;
            $form['Phone']       = $store->Phone;
            $form['PhoneCode']   = $store->PhoneCode;
            $form['Longitude']   = $store->Longitude;
            $form['Latitude']    = $store->Latitude;
            $form['AccountID']   = $store->AccountID;
            $form['Workmode']    = $store->Workmode;
            $form['Type']    = $store->Type;
        }

        $crumbs = array(
            // 0 => array(
            //     'name' => 'Города',
            //     'url' => '?section_id='.$this->_id.'&action=cities',
            // ),
            // 1 => array(
            //     'name' => 'Города доставки',
            //     'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->ID,
            // ),
            // 2 => array(
            //     'name' => 'Магазины ('.$delivery->Name.')',
            //     'url' => '?section_id='.$this->_id.'&action=stores&deliveryid='.$delivery->ID,
            // ),
        );

        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
        );

        $pm_accounts = $this->pmmgr->GetAccounts($filter);

        return STPL::Fetch('admin/modules/cities/store_edit', array(
            'section_id'  => $this->_id,
            'form'        => $form,
            'action'      => 'edit_store',
            'crumbs'      => $crumbs,
            'store'       => $store,
            'city'        => $city,
            'pm_accounts' => $pm_accounts,
        ));
    }

    private function _PostStoreEdit()
    {
        $id          = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $cityid  = App::$Request->Post['cityid']->Int(0, Request::UNSIGNED_NUM);

        $Name        = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email       = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $Phone       = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
        $PhoneCode   = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
        $Address     = App::$Request->Post['Address']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
        $HasPickup   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
        $Longitude   = App::$Request->Post['Longitude']->Value();
        $Latitude    = App::$Request->Post['Latitude']->Value();
        $Workmode    = App::$Request->Post['Workmode']->Value();
        $AccountID   = App::$Request->Post['AccountID']->Int(0, Request::UNSIGNED_NUM);
        $Type = App::$Request->Post['Type']->Enum(0, array_keys(CitiesMgr::$TYPES));

        $city = $this->citymgr->GetCity($cityid);
        if ($city === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/store_edit');
        }

        $store = $this->citymgr->GetStore($id);
        if($store === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_DISTRICT_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/store_edit');
        }

        if (UserError::IsError())
        {
            return false;
        }

        $store->Name        = $Name;
        $store->Email       = $Email;
        $store->Phone       = $Phone;
        $store->PhoneCode   = $PhoneCode;
        $store->Address     = $Address;
        $store->IsAvailable = $IsAvailable;
        $store->HasPickup   = $HasPickup;
        $store->Longitude   = $Longitude;
        $store->Latitude    = $Latitude;
        $store->Workmode    = $Workmode;
        $store->AccountID   = $AccountID;
        $store->Type   = $Type;

        $store->Update();

        return true;
    }

    private function _GetStoreDelete()
    {
        $storeid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null)
            return;

        $store->Remove();
        return;
    }

    private function _GetAjaxToggleStoreAvailable()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $storeid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $store->IsAvailable = !$store->IsAvailable;
        $store->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int) $store->IsAvailable,
            'storeid' => $storeid,
        ));
        exit;
    }

    private function _PostStoresSave()
    {
        $orders = App::$Request->Post['Ord']->AsArray();
        foreach($orders as $storeid => $ord)
        {
            $store = $this->citymgr->GetStore($storeid);
            if($store === null)
                contniue;

            $store->Ord = $ord;
            $store->Update();
        }
    }

    private function _GetAjaxToggleStorePickup()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $storeid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $store->HasPickup = !$store->HasPickup;
        $store->Update();

        $json->send(array(
            'status' => 'ok',
            'haspickup' => (int) $store->HasPickup,
            'storeid' => $storeid,
        ));
        exit;
    }

    // ==============================================================
    private function _GetPhotos()
    {
        global $DCONFIG, $CONFIG;

        $storeid = App::$Request->Get['storeid']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if($store === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_STORE_PHOTO_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_photo');
        }

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => -1,
                'StoreID' => $storeid,
            ],
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        ];

        $list = $this->citymgr->GetPhotos($filter);

        return STPL::Fetch('admin/modules/cities/store_photos', array(
            'list'       => $list,
            'action'     => 'store_photos',
            'section_id' => $this->_id,
            'store'      => $store,
            'storeid'    => $store->ID,
        ));
    }

    private function _GetAjaxTogglePhotoVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $photoid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $photo = $this->citymgr->GetPhoto($photoid);
        if ($photo === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $photo->IsVisible = !$photo->IsVisible;
        $photo->Update();

        $json->send(array(
            'status'  => 'ok',
            'visible' => (int) $photo->IsVisible,
            'photoid' => $photoid,
        ));
        exit;
    }

    private function _GetPhotoDelete()
    {
        $photoid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $photo = $this->citymgr->GetPhoto($photoid);
        if ($photo === null)
            return;

        $photo->Remove();

        return;
    }

    private function _PostSavePhotos()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        foreach($orders as $photoid => $ord)
        {
            $photo = $this->citymgr->GetPhoto($photoid);
            if ($photo === null)
                continue;

            $photo->Ord = $ord;
            $photo->Update();
        }
        return true;
    }

     private function _GetPhotoNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        $storeid    = App::$Request->Get['storeid']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_STORE_PHOTO_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_photo');
        }

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']  = App::$Request->Post['Name']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']  = '';
            $form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/cities/edit_photo', array(
            'form'       => $form,
            'action'     => 'new_photo',
            'storeid'    => $storeid,
            'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostPhoto()
    {
        global $CONFIG, $OBJECTS;

        $photoid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $storeid   = App::$Request->Post['storeid']->Int(0, Request::UNSIGNED_NUM);

        $Name      = App::$Request->Post['Name']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_PHOTO_EMPTY_NAME);

        if(UserError::IsError()) {
            return false;
        }

        if($photoid > 0)
        {
            $photo = $this->citymgr->GetPhoto($photoid);
            if ($photo === null) {
                UserError::AddErrorIndexed('global', ERR_A_CITY_STORE_PHOTO_NOT_FOUND);
                return false;
            }

            $photo->Name      = $Name;
            $photo->IsVisible = $IsVisible;
        }
        else
        {
            $Data = [
                'Name'      => $Name,
                'IsVisible' => $IsVisible,
                'StoreID'   => $storeid,
            ];

            $photo = new Photo($Data);
        }

        // ============================
        // $photo->Update();
        $arr_photos = [
            'PhotoSmall' => ['PhotoSmall'],
            'PhotoBig'   => ['PhotoBig'],
            'Photo'      => ['Photo'],
        ];

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
                        UserError::AddErrorIndexed($key, ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $photo->$photoName = null;
                    return false;
                }
            }
        }

        $photo->Update();

        return $photo->ID;
    }

    private function _GetPhotoEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $photoid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $storeid    = App::$Request->Get['storeid']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CITY_STORE_PHOTO_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_photo');
        }

        $photo = $this->citymgr->GetPhoto($photoid);
        if ($photo === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_PHOTO_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_group');
        }

        $form['PhotoID']    = $photo->id;
        $form['GroupID']    = $photo->groupid;
        $form['PhotoSmall'] = $photo->photosmall;
        $form['PhotoBig']   = $photo->photobig;
        $form['Photo']      = $photo->photo;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']      = App::$Request->Post['Name']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['IsVisible'] = $photo->IsVisible;
            $form['Name']  = $photo->Name;
        }

        return STPL::Fetch('admin/modules/cities/edit_photo', array(
            'form'       => $form,
            'action'     => 'edit_photo',
            'section_id' => $this->_id,
            'storeid'    => $storeid,
        ));
    }

    // ===============================================

}
