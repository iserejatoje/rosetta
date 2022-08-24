<?php

if(1)
{
    $error_code = 0;
    define('ERR_A_PM_MASK', 0x00590000);

    define('ERR_A_PM_UNKNOWN_ERROR', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PM_UNKNOWN_ERROR] = 'Незвестная ошибка.';

    define('ERR_A_PAYMENT_NAME_EMPTY', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAYMENT_NAME_EMPTY] = 'не указано название платежной системы';

    define('ERR_A_PAYMENT_NAMEID_EMPTY', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAYMENT_NAMEID_EMPTY] = 'Необходимо указать название класса';

    define('ERR_A_PAYMENT_NOT_FOUND', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAYMENT_NOT_FOUND] = 'Платежная система не найдена.';

    define('ERR_A_PAYMENT_TYPE_NOT_SELECTED', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAYMENT_TYPE_NOT_SELECTED] = 'Не выбран тип платежной системы';

    define('ERR_A_PAYMENT_ACCOUNT_NOT_FOUND', ERR_A_PM_MASK | $error_code++);
    UserError::$Errors[ERR_A_PAYMENT_ACCOUNT_NOT_FOUND] = 'Параметры платежной системы не найдены';
}


class AdminModule
{
    static $TITLE = 'Текстовая страница';

    private $_db;

    private $_config;

    private $_page;
    private $_id;
    private $_title;
    private $pmmgr;

    function __construct($config, $aconfig, $id)
    {
        global $OBJECTS;

        $this->_id = &$id;
        $this->_config = &$config;
        $this->_aconfig = &$aconfig;
        $this->_db = DBFactory::GetInstance($this->_config['db']);

        LibFactory::GetMStatic('payments', 'paymentmgr');

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
        if ($this->_PostAction()) return;
        $this->_GetAction();
    }

    function GetPage()
    {
        switch ($this->_page) {
            case 'settings':
                $this->_title = "Настройки";
                $html = $this->_GetSettings();
                break;
            // payment types
            case 'payments':
                $this->_title = "Список типов ПС";
                $html = $this->_GetPayments();
                break;
            case 'new_payment':
                $this->_title = "Добавить ПС";
                $html = $this->_GetPaymentNew();
                break;
            case 'edit_payment':
                $this->_title = "Добавить ПС";
                $html = $this->_GetPaymentEdit();
                break;
            case 'delete_payment':
                $this->_GetPaymentDelete();
                Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=payments');
                break;
            // ==============================
            // payment types
            case 'accounts':
                $this->_title = "Список типов ПС";
                $html = $this->_GetAccounts();
                break;
            case 'new_account':
                $this->_title = "Добавить ПС";
                $html = $this->_GetAccountNew();
                break;
            case 'edit_account':
                $this->_title = "Добавить ПС";
                $html = $this->_GetAccountEdit();
                break;
            case 'delete_account':
                $this->_GetAccountDelete();
                Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=accounts');
                break;
            case 'ajax_get_payment_fields':
                $this->_GetAjaxPaymentFields();
                break;
            // ==============================
            /*
                        case 'new_store':
                            $this->_title = "Добавить магазин";
                            $html = $this->_GetStoreNew();
                            break;
                        case 'edit_store':
                            $this->_title = "Редактировать магазин";
                            $html = $this->_GetStoreEdit();
                            break;
                        case 'ajax_store_toggle_pickup':
                            $this->_GetAjaxToggleStorePickup();
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
                            Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_GET['deliveryid']);
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
                            */
            default:
                $this->_title = "Список платежных систем";
                $html = $this->_GetPayments();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'payments', 'text' => 'Типы платежных систем'),
                array('name' => 'action', 'value' => 'accounts', 'text' => 'Аккаунты платежные системы'),
                array('name' => 'action', 'value' => 'settings', 'text' => 'Настройки'),
            ),
            'selected' => $this->_page);
    }

    function GetTitle()
    {
        return $this->_title;
    }

    // обработка запросов
    private function _PostAction()
    {
        global $DCONFIG, $OBJECTS;

        switch ($_POST['action']) {
            case 'settings':
                if ($this->_PostSettings())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=settings');
                break;
            // account actions
            case 'new_account':
                if ($this->_PostAccountNew())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=accounts');
                break;
            case 'edit_account':
                if ($this->_PostAccountEdit())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=accounts');
                break;
            // payment actions
            case 'new_payment':
                if ($this->_PostPaymentNew())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=payments');
                break;
            case 'edit_payment':
                if ($this->_PostPaymentEdit())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=payments');
                break;

            /*
            case 'save_stores':
                if ($this->_PostStoresSave())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&deliveryid='.$_POST['deliveryid']);
                break;
            // districts actions
            case 'new_district':
                if ($this->_PostDeliveryDistrictNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
                break;
            case 'edit_district':
                if ($this->_PostDeliveryDistrictEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
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
                */
        }
        return false;
    }

    private function _GetAction()
    {
        global $DCONFIG;
        switch ($_GET['action']) {
            default:
                $this->_page = $_GET['action'];
                break;
        }
    }

    // Payment accounts

    private function _GetAccounts()
    {
        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
            'dbg' => 0,
        );

        $accounts = $this->pmmgr->GetAccounts($filter);

        return STPL::Fetch('admin/modules/payments/accounts_list', array(
            'section_id' => $this->_id,
            'accounts' => $accounts,
            'crumbs' => $crumbs,
            'action' => 'new_account',
        ));
    }

    private function _GetAccountNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;


        $form = array();
        // $form['SectionID'] = $this->_id;
        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['PaymentID'] = App::$Request->Post['PaymentID']->Value(Request::OUT_HTML);
            $form['Fields'] = App::$Request->Post['Fields']->AsArray();
        } else {
            $form['Name'] = '';
            $form['PaymentID'] = 0;
            $form['Fields'] = array();
        }

        $payments = $this->_get_payments();
        return STPL::Fetch('admin/modules/payments/account_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_account',
            'crumbs' => $crumbs,
            'payments' => $payments,
        ));
    }

    private function _GetAccountEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $account = $this->pmmgr->GetAccount($id);
        if ($account === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAYMENT_ACCOUNT_NOT_FOUND);
            return STPL::Fetch('admin/modules/payments/account_edit');
        }

        $form['AccountID'] = $account->ID;
        $form['PaymentID'] = $account->PaymentID;
        $form['SectionID'] = $account->_id;

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['PaymentID'] = App::$Request->Post['PaymentID']->Int(0, Request::UNSIGNED_NUM);
            $fields = App::$Request->Post['Fields']->AsArray();
        } else {
            $form['Name'] = $account->Name;
            $form['PaymentID'] = $account->PaymentID;
            // $fields            = $account->Fields;
            $fields = $this->_get_account_fields($account->PaymentID, $id);
        }


        return STPL::Fetch('admin/modules/payments/account_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'html' => STPL::Fetch('admin/modules/payments/payment_accounts', array(
                'fields' => $fields,
            )),
            'action' => 'edit_account',
            'crumbs' => $crumbs,
            'payments' => $this->_get_payments(),
        ));
    }


    private function _GetAjaxPaymentFields()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $paymentid = App::$Request->Get['paymentid']->Int(0, Request::UNSIGNED_NUM);
        $accountid = App::$Request->Get['accountid']->Int(0, Request::UNSIGNED_NUM);

        if ($paymentid == 0) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $fields = $this->_get_account_fields($paymentid, $accountid);
        if (sizeof($fields) == 0) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $json->send(array(
            'status' => 'ok',
            'html' => STPL::Fetch('admin/modules/payments/payment_accounts', array(
                'fields' => $fields,
            )),
        ));

    }

    private function _PostAccountNew()
    {
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $PaymentID = App::$Request->Post['PaymentID']->Int(0, Request::UNSIGNED_NUM);
        $fields = App::$Request->Post['fields']->AsArray();
        $values = App::$Request->Post['field_vals']->AsArray();

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAYMENT_NAME_EMPTY);

        if ($PaymentID == 0)
            UserError::AddErrorIndexed('Type', ERR_A_PAYMENT_TYPE_NOT_SELECTED);

        if (UserError::IsError()) {
            return false;
        }

        $payment = $this->pmmgr->GetPayment($PaymentID);
        if ($payment === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAYMENT_NOT_FOUND);
            return STPL::Fetch('admin/modules/payments/account_edit');
        }

        $arr = array();
        foreach ($fields as $k => $field) {
            if (empty($field))
                continue;

            $val = $values[$field];
            $arr[$field] = $val;
        }

        $data = array(
            'Name' => $Name,
            'PaymentID' => $PaymentID,
            'Fields' => serialize($arr),
        );

        $cls = $payment->NameID;
        if (class_exists($cls))
            $account = new $cls($data);
        else
            $account = new Account($data);

        $account->Update();

        return true;
    }

    private function _PostAccountEdit()
    {
        $id = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $PaymentID = App::$Request->Post['PaymentID']->Int(0, Request::UNSIGNED_NUM);
        $fields = App::$Request->Post['fields']->AsArray();
        $values = App::$Request->Post['field_vals']->AsArray();

        $account = $this->pmmgr->GetAccount($id);
        if ($account === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAYMENT_ACCOUNT_NOT_FOUND);
            return STPL::Fetch('admin/modules/payments/account_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAYMENT_NAME_EMPTY);

        if ($PaymentID == 0)
            UserError::AddErrorIndexed('Type', ERR_A_PAYMENT_TYPE_NOT_SELECTED);

        if (UserError::IsError()) {
            return false;
        }

        $arr = array();
        foreach ($fields as $k => $field) {

            if (empty($field))
                continue;
            $val = $values[$field];

            $arr[$field] = $val;
        }

        $account->Name = $Name;
        $account->PaymentID = $PaymentID;
        $account->Fields = $arr;

        $account->Update();

        return true;
    }

    private function _GetAccountDelete()
    {
        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $account = $this->pmmgr->GetAccount($id);
        if ($account === null)
            return;

        $account->Remove();
        return;
    }

    private function _get_payments()
    {
        $filter = array(
            'flags' => array(
                'objects' => true,
            ),
            'dbg' => 0
        );

        return $this->pmmgr->GetPayments($filter);
    }

    private function _get_account_fields($paymentid, $accountid = 0)
    {
        $fields = array();
        if ($accountid > 0) {
            $account = $this->pmmgr->GetAccount($accountid);

            if ($account !== null && $paymentid == $account->PaymentID) {
                foreach ($account->Fields as $field => $val)
                    $fields[$field] = $val;
            }
        }

        // if(sizeof($fields) == 0)
        // {
        $pm = $this->pmmgr->GetPayment($paymentid);
        if ($pm === null)
            return array();

        foreach ($pm->Fields as $field) {
            if (isset($fields[$field]))
                continue;

            $fields[$field] = "";
        }
        // }

        return $fields;
    }

    // Payment system section
    private function _GetPayments()
    {
        // $filter = array(
        //  'flags' => array(
        //      'objects' => true,
        //  ),
        //  'dbg' => 0
        // );

        // $payments = $this->pmmgr->GetPayments($filter);

        $payments = $this->_get_payments();

        // $crumbs = array(
        //  0 => array(
        //      'name' => 'Города',
        //      'url' => '?section_id='.$this->_id.'&action=cities',
        //  ),
        //  1 => array(
        //      'name' => 'Города доставки',
        //      'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->CityID,
        //  ),
        // );

        return STPL::Fetch('admin/modules/payments/payments_list', array(
            'section_id' => $this->_id,
            'payments' => $payments,
            'crumbs' => $crumbs,
            'action' => 'new_payment',
        ));
    }

    private function _GetPaymentNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;


        $form = array();
        // $form['SectionID'] = $this->_id;
        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['Fields'] = App::$Request->Post['Fields']->AsArray();
        } else {
            $form['Name'] = '';
            $form['NameID'] = '';
            $form['Fields'] = array();
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

        return STPL::Fetch('admin/modules/payments/payment_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_payment',
            'crumbs' => $crumbs,
        ));
    }

    private function _GetPaymentEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $payment = $this->pmmgr->GetPayment($id);
        if ($payment === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAYMENT_NOT_FOUND);
            return STPL::Fetch('admin/modules/payments/payment_edit');
        }

        $form['PaymentID'] = $payment->ID;
        $form['SectionID'] = $payment->_id;

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['Fields'] = App::$Request->Post['Fields']->AsArray();
        } else {
            $form['Name'] = $payment->Name;
            $form['NameID'] = $payment->NameID;
            $form['Fields'] = $payment->Fields;
        }

        /*$crumbs = array(
            0 => array(
                'name' => 'Города',
                'url' => '?section_id='.$this->_id.'&action=cities',
            ),
            1 => array(
                'name' => 'Города доставки',
                'url' => '?section_id='.$this->_id.'&action=delivery_cities&id='.$delivery->ID,
            ),
            2 => array(
                'name' => 'Магазины ('.$delivery->Name.')',
                'url' => '?section_id='.$this->_id.'&action=stores&deliveryid='.$delivery->ID,
            ),
        );*/

        return STPL::Fetch('admin/modules/payments/payment_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'edit_payment',
            'crumbs' => $crumbs,
        ));
    }

    private function _PostPaymentNew()
    {
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $NameID = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
        $Fields = App::$Request->Post['Fields']->AsArray();

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAYMENT_NAME_EMPTY);

        if (strlen($NameID) == 0)
            UserError::AddErrorIndexed('NameID', ERR_A_PAYMENT_NAMEID_EMPTY);

        if (UserError::IsError()) {
            print_r(UserError::GetErrorsText());
            exit;
            return false;
        }

        $arr = array();
        foreach ($Fields as $item) {
            if (empty($item))
                continue;

            $arr[] = $item;
        }

        $data = array(
            'Name' => $Name,
            'NameID' => $NameID,
            'Fields' => serialize($arr),
        );

        $payment = new Payment($data);
        $payment->Update();

        return true;
    }

    private function _PostPaymentEdit()
    {
        $id = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $NameID = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
        $Fields = App::$Request->Post['Fields']->AsArray();

        $payment = $this->pmmgr->GetPayment($id);
        if ($payment === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAYMENT_NOT_FOUND);
            return STPL::Fetch('admin/modules/payments/payment_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAYMENT_NAME_EMPTY);

        if (strlen($NameID) == 0)
            UserError::AddErrorIndexed('NameID', ERR_A_PAYMENT_NAMEID_EMPTY);

        if (UserError::IsError()) {
            return false;
        }

        if (UserError::IsError()) {
            return false;
        }

        $payment->Name = $Name;
        $payment->NameID = $NameID;
        $payment->Fields = $Fields;

        $payment->Update();

        return true;
    }

    private function _GetPaymentDelete()
    {
        $paymentid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $payment = $this->pmmgr->GetPayment($paymentid);
        if ($payment === null)
            return;

        $payment->Remove();
        return;
    }

    // end: Payment account setcion
    // ============================================

    private function _GetDeliveryDistricts()
    {
        $deliveryid = App::$Request->Get['deliveryid']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($deliveryid);
        if ($delivery === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_list');
        }


        $filter = array(
            'flags' => array(
                'objects' => true,
                'DeliveryID' => $deliveryid,
                'IsAvailable' => -1,
            ),
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        );
        $districts = $this->citymgr->GetDistricts($filter);

        $crumbs = array(
            0 => array(
                'name' => 'Города',
                'url' => '?section_id=' . $this->_id . '&action=cities',
            ),
            1 => array(
                'name' => 'Города доставки',
                'url' => '?section_id=' . $this->_id . '&action=delivery_cities&id=' . $delivery->CityID,
            ),
        );

        return STPL::Fetch('admin/modules/cities/district_list', array(
            'section_id' => $this->_id,
            'districts' => $districts,
            'deliveryid' => $deliveryid,
            'crumbs' => $crumbs,
        ));
    }

    private function _GetDeliveryDistrictNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $deliveryid = App::$Request->Get['deliveryid']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($deliveryid);
        if ($delivery === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }

        $form = array();
        $form['SectionID'] = $this->_id;
        $form['DeliveryID'] = $deliveryid;
        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email'] = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
            $form['Price'] = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        } else {
            $form['Name'] = '';
            $form['Email'] = '';
            $form['IsAvailable'] = 1;
            $form['Price'] = 0;
        }

        $crumbs = array(
            0 => array(
                'name' => 'Города',
                'url' => '?section_id=' . $this->_id . '&action=cities',
            ),
            1 => array(
                'name' => 'Города доставки',
                'url' => '?section_id=' . $this->_id . '&action=delivery_cities&id=' . $delivery->ID,
            ),
            2 => array(
                'name' => 'Районы (' . $delivery->Name . ')',
                'url' => '?section_id=' . $this->_id . '&action=districts&deliveryid=' . $delivery->ID,
            ),
        );

        return STPL::Fetch('admin/modules/cities/district_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_district',
            'crumbs' => $crumbs,
        ));
    }

    private function _GetDeliveryDistrictEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $district = $this->citymgr->GetDistrict($id);
        if ($district === null) {
            UserError::AddErrorIndexed('global', ERR_A_DISTRICT_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form['DistrictID'] = $district->ID;
        $form['SectionID'] = $this->_id;
        $form['DeliveryID'] = $district->DeliveryID;
        $delivery = $this->citymgr->GetDelivery($district->DeliveryID);

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email'] = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
            $form['Price'] = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);
        } else {
            $form['Name'] = $district->Name;
            $form['Email'] = $district->Email;
            $form['IsAvailable'] = $district->IsAvailable;
            $form['Price'] = $district->Price;

        }

        $crumbs = array(
            0 => array(
                'name' => 'Города',
                'url' => '?section_id=' . $this->_id . '&action=cities',
            ),
            1 => array(
                'name' => 'Города доставки',
                'url' => '?section_id=' . $this->_id . '&action=delivery_cities&id=' . $delivery->ID,
            ),
            2 => array(
                'name' => 'Районы (' . $delivery->Name . ')',
                'url' => '?section_id=' . $this->_id . '&action=districts&deliveryid=' . $delivery->ID,
            ),
        );

        return STPL::Fetch('admin/modules/cities/district_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'edit_district',
            'crumbs' => $crumbs,
        ));
    }

    private function _PostDeliveryDistrictNew()
    {
        $deliveryid = App::$Request->Post['deliveryid']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
        $Price = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);

        $delivery_city = $this->citymgr->GetDelivery($deliveryid);
        if ($delivery_city === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_district');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $data = array(
            'DeliveryID' => $deliveryid,
            'Name' => $Name,
            'Price' => $Price,
            // 'Email'       => $Email,
            'IsAvailable' => $IsAvailable,
        );

        $district = new District($data);
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
        $id = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $deliveryid = App::$Request->Post['deliveryid']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
        $Price = App::$Request->Post['Price']->Int(0, Request::UNSIGNED_NUM);

        $delivery_city = $this->citymgr->GetDelivery($deliveryid);
        if ($delivery_city === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }

        $district = $this->citymgr->GetDistrict($id);
        if ($district === null) {
            UserError::AddErrorIndexed('global', ERR_A_DISTRICT_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/district_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $district->Name = $Name;
        $district->Email = $Email;
        $district->Price = $Price;
        $district->IsAvailable = $IsAvailable;
        $district->Update();

        return true;
    }

    private function _GetAjaxToggleDeliveryDistrictAvailable()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $districtid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $district = $this->citymgr->GetDistrict($districtid);
        if ($district === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $district->IsAvailable = !$district->IsAvailable;
        $district->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int)$district->IsAvailable,
            'districtid' => $districtid,
        ));
        exit;
    }

    private function _PostDeliveryDistrictsSave()
    {
        $orders = App::$Request->Post['Ord']->AsArray();
        foreach ($orders as $districtid => $ord) {
            $district = $this->citymgr->GetDistrict($districtid);
            if ($district === null)
                contniue;

            $district->Ord = $ord;
            $district->Update();
        }
    }

    //  =============================

    private function _GetDeliveryCities()
    {
        $cityid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
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

    private function _GetDeliveryNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $CityID = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form = array();
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $CityID;
        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email'] = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
        } else {
            $form['Name'] = '';
            $form['Email'] = '';
            $form['IsAvailable'] = 1;
        }

        return STPL::Fetch('admin/modules/cities/delivery_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_delivery',
        ));
    }

    private function _GetDeliveryEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $ID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($ID);
        if ($delivery === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $form['DeliveryID'] = $delivery->ID;
        $form['SectionID'] = $this->_id;
        $form['CityID'] = $delivery->CityID;

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['Email'] = App::$Request->Post['Email']->Value(Request::OUT_HTML);
            $form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
        } else {
            $form['Name'] = $delivery->Name;
            $form['Email'] = $delivery->Email;
            $form['IsAvailable'] = $delivery->IsAvailable;

        }

        return STPL::Fetch('admin/modules/cities/delivery_edit', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'edit_delivery',
        ));
    }

    private function _PostDeliveryNew()
    {
        $CityID = App::$Request->Post['сityid']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));

        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $data = array(
            'CityID' => $CityID,
            'Name' => $Name,
            'Email' => $Email,
            'IsAvailable' => $IsAvailable,
        );

        $delivery = new DeliveryCity($data);
        $delivery->Update();

        return true;
    }

    private function _PostDeliveryEdit()
    {
        $ID = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $CityID = App::$Request->Post['сityid']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $Email = App::$Request->Post['Email']->Value(Request::OUT_HTML);
        $IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0, 1));
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DOMAIN_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        $delivery = $this->citymgr->GetDelivery($ID);
        if ($delivery === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/delivery_edit');
        }

        if (strlen($Name) == 0)
            UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

        if (UserError::IsError())
            return false;

        $delivery->Name = $Name;
        $delivery->Email = $Email;
        $delivery->IsAvailable = $IsAvailable;
        $delivery->Update();

        return true;
    }

    private function _GetAjaxToggleDeliveryAvailable()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $DeliveryID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $delivery = $this->citymgr->GetDelivery($DeliveryID);
        if ($delivery === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $delivery->IsAvailable = !$delivery->IsAvailable;
        $delivery->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int)$delivery->IsAvailable,
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

    // private function _GetCities()
    // {
    //  global $DCONFIG, $CONFIG;

    //  // $page        = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);

    //  $filter = array(
    //      'flags' => array(
    //          'objects' => true,
    //          'IsVisible' => -1,
    //          // 'SectionID' => $this->_id,
    //      ),
    //      'field' => array(
    //          'Date',
    //      ),
    //      'dir' => array(
    //          'DESC',
    //      ),
    //      // 'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
    //      // 'limit' => self::$ROW_ON_PAGE,
    //      // 'calc'   => true,
    //  );

    //  $cities = $this->citymgr->GetCities($filter);

    //  // $pages = Data::GetNavigationPagesNumber(
    //  //  self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
    //  //  "?section_id=". $this->_id ."&action=articles&page=@p@");

    //  return STPL::Fetch('admin/modules/cities/cities_list', array(
    //      'section_id' => $this->_id,
    //      'cities' => $cities,
    //      // 'pages' => $pages,
    //  ));
    // }

    private function _GetCityNew()
    {

        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

        $form = array();

        $form['SectionID'] = $this->_id;

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0, 1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0, 1));
            $form['Street'] = App::$Request->Post['Street']->Value(Request::OUT_HTML);
            $form['Domain'] = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
            $form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
            $form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Phone'] = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['Latitude'] = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
            $form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
            $form['SEOText'] = App::$Request->Post['SEOText']->Value();
            $form['Metrika'] = App::$Request->Post['Metrika']->Value();
        } else {
            $form['NameID'] = '';
            $form['Street'] = '';
            $form['Domain'] = '';
            $form['CatalogId'] = '';
            $form['PhoneCode'] = '';
            $form['Phone'] = '';
            $form['Latitude'] = '';
            $form['Longitude'] = '';
            $form['SEOText'] = '';
            $form['Metrika'] = '';
            $form['IsVisible'] = 1;
            $form['IsDefault'] = 0;
        }

        return STPL::Fetch('admin/modules/cities/edit_city', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_city',
        ));
    }

    // Редактировать
    private function _GetEditCity()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
            UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/edit_city');
        }

        $form['CityID'] = $city->ID;

        if (App::$Request->requestMethod === Request::M_POST) {
            $form['action'] = 'new_city';
            $form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
            $form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0, 1));
            $form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0, 1));
            $form['Street'] = App::$Request->Post['Street']->Value(Request::OUT_HTML);
            $form['Domain'] = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
            $form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
            $form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
            $form['Phone'] = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
            $form['Latitude'] = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
            $form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
            $form['SEOText'] = App::$Request->Post['SEOText']->Value();
            $form['Metrika'] = App::$Request->Post['Metrika']->Value();
        } else {
            $form['action'] = 'edit_city';
            $form['Name'] = $city->Name;
            $form['NameID'] = $city->NameID;
            $form['IsVisible'] = (int)$city->IsVisible;
            $form['IsDefault'] = (int)$city->IsDefault;
            $form['Street'] = $city->Street;
            $form['Domain'] = $city->Domain;
            $form['CatalogId'] = $city->CatalogId;
            $form['PhoneCode'] = $city->PhoneCode;
            $form['Phone'] = $city->Phone;
            $form['Latitude'] = $city->Latitude != "" ? $city->Latitude : 0;
            $form['Longitude'] = $city->Longitude != "" ? $city->Longitude : 0;
            $form['SEOText'] = $city->SEOText;
            $form['Metrika'] = $city->Metrika;
        }

        return STPL::Fetch('admin/modules/cities/edit_city', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'edit_city',
        ));
    }

    private function _GetAjaxToggleCityVisible()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $city->IsVisible = !$city->IsVisible;
        $city->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int)$city->IsVisible,
            'cityid' => $CityID,
        ));
        exit;
    }

    private function _GetAjaxToggleCityDefault()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $city = $this->citymgr->GetCity($CityID);
        if ($city === null) {
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
            $item->IsDefault = 0;
            $item->Update();
        }

        $city->IsDefault = !$city->IsDefault;
        $city->Update();

        $json->send(array(
            'status' => 'ok',
            'default' => (int)$city->IsDefault,
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
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0, 1));
        $IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0, 1));
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
            'SectionID' => $this->_id,
            'Name' => $Name,
            'NameID' => $NameID,
            'IsVisible' => $IsVisible,
            'IsDefault' => $IsDefault,
            'Street' => $Street,
            'Domain' => $Domain,
            'CatalogId' => $CatalogId,
            'PhoneCode' => $PhoneCode,
            'Phone' => $Phone,
            'Latitude' => $Latitude,
            'Longitude' => $Longitude,
            'SEOText' => $SEOText,
            'Metrika' => $Metrika,
        );

        $city = new City($data);
        $city->Update();

        return true;
    }

    // Обновить
    private function  _PostCityEdit()
    {
        $CityID = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
        $NameID = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0, 1));
        $IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0, 1));
        $Street = App::$Request->Post['Street']->Value(Request::OUT_HTML);
        $Domain = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
        $CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
        $PhoneCode = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
        $Phone = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
        $Latitude = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
        $Longitude = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
        $SEOText = App::$Request->Post['SEOText']->Value();
        $Metrika = App::$Request->Post['Metrika']->Value();

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
        $deliveryid = App::$Request->Get['deliveryid']->Int(0, Request::UNSIGNED_NUM);

        $delivery = $this->citymgr->GetDelivery($deliveryid);
        if ($delivery === null) {
            UserError::AddErrorIndexed('global', ERR_A_CITY_DELIVERY_NOT_FOUND);
            return STPL::Fetch('admin/modules/cities/stores_list');
        }


        $filter = array(
            'flags' => array(
                'objects' => true,
                'DeliveryID' => $deliveryid,
                'IsAvailable' => -1,
            ),
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        );

        $stores = $this->citymgr->GetStores($filter);

        $crumbs = array(
            0 => array(
                'name' => 'Города',
                'url' => '?section_id=' . $this->_id . '&action=cities',
            ),
            1 => array(
                'name' => 'Города доставки',
                'url' => '?section_id=' . $this->_id . '&action=delivery_cities&id=' . $delivery->CityID,
            ),
        );

        return STPL::Fetch('admin/modules/cities/stores_list', array(
            'section_id' => $this->_id,
            'stores' => $stores,
            'deliveryid' => $deliveryid,
            'crumbs' => $crumbs,
            'action' => 'new_store',
            'city' => $delivery,
        ));
    }


    private function _GetAjaxToggleStoreAvailable()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $storeid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $store->IsAvailable = !$store->IsAvailable;
        $store->Update();

        $json->send(array(
            'status' => 'ok',
            'available' => (int)$store->IsAvailable,
            'storeid' => $storeid,
        ));
        exit;
    }

    private function _PostStoresSave()
    {
        $orders = App::$Request->Post['Ord']->AsArray();
        foreach ($orders as $storeid => $ord) {
            $store = $this->citymgr->GetStore($storeid);
            if ($store === null)
                contniue;

            $store->Ord = $ord;
            $store->Update();
        }
    }

    private function _GetAjaxToggleStorePickup()
    {
        include_once ENGINE_PATH . 'include/json.php';
        $json = new Services_JSON();

        $storeid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $store = $this->citymgr->GetStore($storeid);
        if ($store === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $store->HasPickup = !$store->HasPickup;
        $store->Update();

        $json->send(array(
            'status' => 'ok',
            'haspickup' => (int)$store->HasPickup,
            'storeid' => $storeid,
        ));
        exit;
    }

    private function _GetSettings()
    {
        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'payments');

        return STPL::Fetch('admin/modules/payments/settings', array(
            'section_id' => $this->_id,
            'action'     => 'settings',
            'config'     => $config,
        ));
    }

    private function _PostSettings()
    {
        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'payments');

        $system_name = App::$Request->Post['system_name']->AsArray();
        $system_class = App::$Request->Post['$system_class']->AsArray();
        $system_enabled = App::$Request->Post['system_enabled']->AsArray();
        $system_nofolding = App::$Request->Post['system_nofolding']->AsArray();

        $type_name = App::$Request->Post['type_name']->AsArray();
        $type_class = App::$Request->Post['type_class']->AsArray();
        $type_enabled = App::$Request->Post['type_enabled']->AsArray();
        $type_haslabel = App::$Request->Post['type_haslabel']->AsArray();

        $arrPaymentTypes = [];
        foreach($system_name as $k => $group_name) {
            $types = [];
            foreach($type_name[$k] as $code => $name) {
                $types[$code]['code'] = $code;
                $types[$code]['name'] = $name;
                $types[$code]['class'] = $type_class[$k][$code];
                $types[$code]['enabled'] = intval($type_enabled[$k][$code]);
                $types[$code]['haslabel'] = intval($type_haslabel[$k][$code]);

                $arrPaymentTypes[$k]['name'] = $group_name;
                $arrPaymentTypes[$k]['enabled'] = intval($system_enabled[$k]);
                $arrPaymentTypes[$k]['nofolding'] = intval($system_nofolding[$k]);
                $arrPaymentTypes[$k]['class'] = $system_class[$k];
                $arrPaymentTypes[$k]['list'] = $types;
            }
        }

        $config['payment_types'] = $arrPaymentTypes;
        $bl->SaveConfig('module_engine', 'payments', $config);

        return true;
    }
}
