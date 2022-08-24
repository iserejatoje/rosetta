<?php

ini_set('max_execution_time', '60');


$banners_error_code = 0;
define('ERR_A_BANNERS_MASK', 0x00580000);

define('ERR_A_BANNERS_EMPTY_PLACE_NAME', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_EMPTY_PLACE_NAME] = 'Не указано имя баннерного места.';

define('ERR_A_BANNERS_NOT_SELECTED_PLACE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_NOT_SELECTED_PLACE] = 'Выберите баннерное место';

define('ERR_A_BANNERS_NOT_SELECTED_TYPE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_NOT_SELECTED_TYPE] = 'Выберите тип баннера';

define('ERR_A_BANNERS_NOT_SELECTED_TYPE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_NOT_SELECTED_TYPE] = 'Не указан тип объекта';

define('ERR_A_BANNERS_NOT_FOUND', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_NOT_FOUND] = 'Объект не найден';


define('ERR_A_BANNERS_NOT_SELECTED_ROOMTYPE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_NOT_SELECTED_ROOMTYPE] = 'Не выбран тип помещения';


define('ERR_A_BANNERS_EMPTY_FLOOR', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_EMPTY_FLOOR] = 'Не указан этаж';

define('ERR_A_BANNERS_EMPTY_SQUARE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_EMPTY_SQUARE] = 'Площадь должна быть больше нуля';

define('ERR_A_BANNERS_EMPTY_COSTM2', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_EMPTY_COSTM2] = 'Цена за кв. метр должна быть больше нуля';

define('ERR_A_BANNERS_WRONG_EMAIL', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_BANNERS_WRONG_EMAIL] = 'Неверный формат Email';


class AdminModule
{

    static $TITLE = 'Баннеры';
    static $ROW_ON_PAGE = 20;
    static $PAGES_ON_PAGE = 5;

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $bannerMgr;

    function __construct($config, $aconfig, $id)
    {
        global $CONFIG,$DCONFIG, $OBJECTS;

        LibFactory::GetMStatic('banners', 'bannermgr');
        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");

        $this->_id = &$id;
        $this->_config = &$config;

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=banners');

        $this->bannerMgr = BannerMgr::getInstance(false);

        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');
        App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');
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
            case 'banners':
                $this->_title = "Список баннеров";
                $html = $this->_GetBanners();
                break;
            case 'new_banner':
                $this->_title = "Добавить баннер";
                $html = $this->_GetBannerNew();
                break;
            case 'edit_banner':
                $this->_title = "Редактировать баннер";
                $html = $this->_GetBannerEdit();
                break;
            case 'ajax_banner_toggle_visible':
                $this->_GetAjaxToggleBannerVisible();
                break;
            case 'delete_banner':
                $this->_GetBannerDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=banners');
                break;
            case 'places':
                $this->_title = "Баннерное места";
                $html = $this->_GetPlaces();
                break;
            case 'new_place':
                $this->_title = "Добавить баннерное место";
                $html = $this->_GetPlaceNew();
                break;
            case 'edit_place':
                $this->_title = "Редактировать баннерное место";
                $html = $this->_GetPlaceEdit();
                break;
            case 'ajax_place_toggle_visible':
                $this->_GetAjaxTogglePlaceVisible();
                break;
            case 'delete_place':
                $this->_GetPlaceDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=places');
                break;
            default:
                $this->_title = "Баннеры";
                $html = $this->_GetBanners();
                break;
        }

        return $html;
    }



    function GetTabs()
    {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'banners', 'text' => 'Баннеры'),
                array('name' => 'action', 'value' => 'places', 'text' => 'Баннерные места'),
            ),
            'selected' => $this->_page
        );
    }

    function GetTitle()
    {
        return $this->_title;
    }

    private function _PostAction()
    {
        global $DCONFIG, $OBJECTS;

        switch($_POST['action'])
        {
            case 'save_banners':
                if ($this->_PostSaveBanners())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=banners');
                break;
            case 'new_banner':
                if ($this->_PostBannerNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=banners');
                break;
            case 'edit_banner':
                if ($this->_PostBannerEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=banners');
                break;
            case 'new_place':
                if ($this->_PostPlaceNew())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=places');
                break;
            case 'edit_place':
                if ($this->_PostPlaceEdit())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=places');
                break;
        }
        return false;
    }

    private function _GetAction()
    {
        global $DCONFIG;
        switch($_GET['action']) {
            case 'search':
                $this->_page = 'search';
                $this->_params['filter'] = $_GET['filter'];
                $this->_params['options'] = (isset($_GET['options']) && is_array($_GET['options'])) ? $_GET['options'] : array();
                $this->_params['group'] = $_GET['group'];
                $this->_params['and'] = $_GET['and'];
                $this->_params['visible'] = $_GET['visible'];
                $this->_params['page'] = (int) $_GET['page'];

                if ($this->_params['page'] <= 0)
                    $this->_params['page'] = 1;

                break;
            default:
                $this->_page = $_GET['action'];
                break;
        }
    }

    private function _GetBanners()
    {
        global $DCONFIG, $CONFIG;

        $page       = App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);
        $PlaceID    = App::$Request->Get['placeid']->Int(-1, Request::UNSIGNED_NUM);
        $Type       = App::$Request->Get['type']->Int(-1, Request::UNSIGNED_NUM);
        $IsVisible  = App::$Request->Get['isvisible']->Enum(-1, array(-1,0,1));

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => $IsVisible,
                'PlaceID' => $PlaceID,
                'Type' => $Type,
                'SectionID' => $this->_id,
            ),
            'field' => array(
                'Ord',
            ),
            'dir' => array(
                'DESC',
            ),
            'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
            'limit' => self::$ROW_ON_PAGE,
            'calc'  => true,
        );

        list($banners, $count) = $this->bannerMgr->GetBanners($filter);

        // $pages = Data::GetNavigationPagesNumber(
        //  self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
        //  "?section_id=". $this->_id ."&action=banners&page=@p@");

        $pages = Data::GetNavigationPagesNumber(
            self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
            "?section_id=". $this->_id ."&action=banners&isvisible=".$IsVisible."&placeid=".$PlaceID."&type=".$Type."&page=@p@");

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
            ),
        );

        $places = $this->bannerMgr->GetPlaces($filter);

        return STPL::Fetch('admin/modules/banners/banners_list', array(
            'section_id' => $this->_id,
            'banners' => $banners,
            'places' => $places,
            'PlaceID' => $PlaceID,
            'Type' => $Type,
            'IsVisible' => $IsVisible,
            'pages' => $pages,
        ));

    }

    private function _GetBannerNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.js');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/smoothness/jquery-ui-1.8.14.custom.css');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.css');

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST ) {
            $form['PlaceID']        = App::$Request->Post['PlaceID']->Int(0, Request::UNSIGNED_NUM);
            $form['Type']           = App::$Request->Post['Type']->Enum(0, array_keys(BannerMgr::$TYPES));
            $form['Width']          = App::$Request->Post['Width']->Value();
            $form['Height']         = App::$Request->Post['Height']->Value();
            $form['Url']            = App::$Request->Post['Url']->Value();
            $form['BannerText']     = App::$Request->Post['BannerText']->Value();
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }  else {
            $form['PlaceID']    = 0;
            $form['Type']       = 0;
            $form['Width']      = 0;
            $form['Height']     = 0;
            $form['Url']        = '';
            $form['BannerText'] = '';
            $form['IsVisible']  = 1;
        }

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
            ),
        );

        $places = $this->bannerMgr->GetPlaces($filter);

        return STPL::Fetch('admin/modules/banners/edit_banner', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'places'        => $places,
            'types'         => BannerMgr::$TYPES,
            'action'        => 'new_banner',
        ));

    }

    private function _GetBannerEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.js');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/smoothness/jquery-ui-1.8.14.custom.css');
        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.css');

        $BannerID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $banner = $this->bannerMgr->GetBanner($BannerID);
        if ($banner === null) {
            UserError::AddErrorIndexed('global', ERR_A_BANNERS_NOT_FOUND);
            return STPL::Fetch('admin/modules/banners/edit_banner');
        } else {
            $form['File'] = $banner->File;
        }

        if ( App::$Request->requestMethod === Request::M_POST ) {
            $form['PlaceID']       = App::$Request->Post['PlaceID']->Int(0, Request::UNSIGNED_NUM);
            $form['Type']          = App::$Request->Post['Type']->Enum(0, array_keys(BannerMgr::$TYPES));
            $form['Width']         = App::$Request->Post['Width']->Value();
            $form['Height']        = App::$Request->Post['Height']->Value();
            $form['Email']         = App::$Request->Post['Email']->Value();
            $form['Url']           = App::$Request->Post['Url']->Value();
            $form['BannerText']    = App::$Request->Post['BannerText']->Value();
            $form['IsVisible']     = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
       } else {
            $form['BannerID']      = $banner->ID;
            $form['PlaceID']       = $banner->PlaceID;
            $form['Type']          = $banner->Type;
            $form['Width']         = $banner->Width;
            $form['Height']        = $banner->Height;
            $form['Url']           = $banner->Url;
            $form['BannerText']    = $banner->BannerText;
            $form['IsVisible']     = $banner->IsVisible;
        }

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => 1,
            ),
        );

        $places = $this->bannerMgr->GetPlaces($filter);

        return STPL::Fetch('admin/modules/banners/edit_banner', array(
            'section_id'    => $this->_id,
            'form'          => $form,
            'places'        => $places,
            'types'         => BannerMgr::$TYPES,
            'action'        => 'edit_banner',
        ));

    }

    private function _GetAjaxToggleBannerVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $BannerID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $banner = $this->bannerMgr->GetBanner($BannerID);
        if ($banner === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $banner->IsVisible = !$banner->IsVisible;
        $banner->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $banner->IsVisible,
            'bannerid' => $BannerID,
        ));

        exit;

    }

    private function _GetBannerDelete()
    {
        $BannerID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $banner = $this->bannerMgr->GetBanner($BannerID);
        if ($banner === null)
            return;

        $banner->Remove();
        return;
    }



    private function _GetPlaces()
    {
        global $DCONFIG, $CONFIG;

        $page   = App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
            ),
            'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
            'limit' => self::$ROW_ON_PAGE,
            'calc'  => true,
        );



        list($places, $count) = $this->bannerMgr->GetPlaces($filter);

        $pages = Data::GetNavigationPagesNumber(
            self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
            "?section_id=". $this->_id ."&action=places&page=@p@");

        return STPL::Fetch('admin/modules/banners/places_list', array(
            'section_id' => $this->_id,
            'places' => $places,
            'pages' => $pages,
        ));

    }

    private function _GetPlaceNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();
        if ( App::$Request->requestMethod === Request::M_POST ) {
            $form['Name']           = App::$Request->Post['Name']->Value();
            $form['Interval']       = App::$Request->Post['Interval']->Int(10, Request::UNSIGNED_NUM);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        } else {
            $form['Name']      = '';
            $form['Interval']  = 10;
            $form['IsVisible'] = 1;
        }

        return STPL::Fetch('admin/modules/banners/edit_place', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'new_place',
        ));
    }

    private function _GetPlaceEdit() {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $PlaceID    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $place = $this->bannerMgr->GetPlace($PlaceID);
        if ($place === null) {
            UserError::AddErrorIndexed('global', ERR_A_BANNERS_NOT_FOUND);
            return STPL::Fetch('admin/modules/banners/edit_banner');
        }

        if ( App::$Request->requestMethod === Request::M_POST ) {
            $form['Name']           = App::$Request->Post['Name']->Value();
            $form['Interval']       = App::$Request->Post['Interval']->Int(10, Request::UNSIGNED_NUM);
            $form['IsVisible']      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        } else {
            $form['Name']           = $place->Name;
            $form['Interval']       = $place->Interval;
            $form['IsVisible']      = $place->IsVisible;
        }

        return STPL::Fetch('admin/modules/banners/edit_place', array(
            'section_id' => $this->_id,
            'form' => $form,
            'action' => 'edit_place',
        ));

    }

    private function _GetAjaxTogglePlaceVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $PlaceID    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $place = $this->bannerMgr->GetPlace($PlaceID);
        if ($place === null) {
            $json->send(array('status' => 'error'));
            exit;
        }

        $place->IsVisible = !$place->IsVisible;
        $place->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $place->IsVisible,
            'placeid' => $PlaceID,
        ));
        exit;
    }

    private function _GetPlaceDelete()
    {
        $PlaceID    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $place = $this->bannerMgr->GetPlace($PlaceID);

        if ($place === null) {
            return;
        }

        $place->Remove();
        return;
    }

    private function _PostBannerNew()
    {
        global $CONFIG, $OBJECTS;

        $PlaceID    = App::$Request->Post['PlaceID']->Int(0, Request::UNSIGNED_NUM);
        $Type       = App::$Request->Post['Type']->Enum(0, array_keys(BannerMgr::$TYPES));
        $Url        = App::$Request->Post['Url']->Value();
        $Width      = App::$Request->Post['Width']->Int(0, Request::UNSIGNED_NUM);
        $Height     = App::$Request->Post['Height']->Int(0, Request::UNSIGNED_NUM);
        $BannerText = App::$Request->Post['BannerText']->Value();

        if ($PlaceID == 0) {
            UserError::AddErrorIndexed('PlaceID', ERR_A_BANNERS_NOT_SELECTED_PLACE);
        }

        if ($Type == 0) {
            UserError::AddErrorIndexed('Type', ERR_A_BANNERS_NOT_SELECTED_TYPE);
        }

        if(UserError::IsError()) {
            return false;
        }

        $place = $this->bannerMgr->GetPlace($PlaceID);
        $place->Banners++;
        $place->Update();

        $Data = array(
            'PlaceID'       => $PlaceID,
            'Type'          => $Type,
            'Width'         => $Width,
            'Height'        => $Height,
            'Url'           => $Url,
            'BannerText'    => $BannerText,
            'IsVisible'     => $IsVisible,
        );

        $banner = new Banner($Data);

        try {
            $banner->UploadFile();
        } catch(MyException $e) {
            if( $e->getCode() >  0 ) {
                UserError::AddErrorWithArgsIndexed('File', $e->getCode(), $e->getUserErrorArgs());
            } else {
                UserError::AddErrorIndexed('File',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);
            }

            $banner->File = null;
            return false;
        }

        $banner->Update();

        return true;
    }

    private function _PostBannerEdit()
    {
        global $CONFIG, $OBJECTS;

        $BannerID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $banner = $this->bannerMgr->GetBanner($BannerID);
        if ($banner === null) {
            UserError::AddErrorIndexed('global', ERR_A_BANNERS_NOT_FOUND);
            return false;
        }

        $PlaceID = App::$Request->Post['PlaceID']->Int(0, Request::UNSIGNED_NUM);
        $place = $this->bannerMgr->GetPlace($PlaceID);
        if ($place === null) {
            UserError::AddErrorIndexed('global', ERR_A_BANNERS_NOT_FOUND);
            return false;
        }

        $Type           = App::$Request->Post['Type']->Enum(0, array_keys(BannerMgr::$TYPES));
        $Url            = App::$Request->Post['Url']->Value();
        $Width          = App::$Request->Post['Width']->Int(0, Request::UNSIGNED_NUM);
        $Height         = App::$Request->Post['Height']->Int(0, Request::UNSIGNED_NUM);
        $BannerText     = App::$Request->Post['BannerText']->Value();
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        $del_file       = App::$Request->Post['del_file']->Enum(0, array(0,1));

        if ($PlaceID == 0) {
            UserError::AddErrorIndexed('PlaceID', ERR_A_BANNERS_NOT_SELECTED_PLACE);
        }

        if ($Email != "" && !Data::Is_Email($Email)) {
            UserError::AddErrorIndexed('Email', ERR_A_BANNERS_WRONG_EMAIL);
        }

        if ($Type == 0) {
            UserError::AddErrorIndexed('Type', ERR_A_BANNERS_NOT_SELECTED_TYPE);
        }

        if(UserError::IsError()) {
            return false;
        }

        if ($banner->PlaceID != $PlaceID) {
            $old_place = $this->bannerMgr->GetPlace($banner->PlaceID);

            if ($old_place !== null) {
                $old_place->Banners--;
                $old_place->Update();
            }

            $place->Banners++;
            $place->Update();
        }

        $banner->PlaceID       = $PlaceID;
        $banner->Type          = $Type;
        $banner->Url           = $Url;
        $banner->Width         = $Width;
        $banner->Height        = $Height;
        //$banner->RemovalDate = $RemovalDate + $RemovalTime;
        $banner->BannerText    = $BannerText;
        $banner->IsVisible     = $IsVisible;

        if ($del_file || is_file($_FILES['File']['tmp_name']))
            $banner->File = null;

        try {
            $banner->UploadFile();
        } catch(MyException $e) {
            if( $e->getCode() >  0 ) {
                UserError::AddErrorWithArgsIndexed('File', $e->getCode(), $e->getUserErrorArgs());
            } else {
                UserError::AddErrorIndexed('File',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);
            }

            $banner->File = null;

            return false;
        }

        $banner->Update();

        return true;
    }

    private function _PostPlaceNew()
    {
        global $CONFIG, $OBJECTS;

        $Name           = App::$Request->Post['Name']->Value();
        $Interval       = App::$Request->Post['Interval']->Int(10, Request::UNSIGNED_NUM);
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if (empty($Name)) {
            UserError::AddErrorIndexed('Name', ERR_A_BANNERS_EMPTY_PLACE_NAME);
        }

        if(UserError::IsError()) {
            return false;
        }

        $Data = array(
            'Name'          => $Name,
            'Interval'      => $Interval,
            'IsVisible'     => $IsVisible,
        );

        $place = new BannerPlace($Data);
        $place->Update();
        return true;
    }

    private function _PostPlaceEdit()
    {
        global $CONFIG, $OBJECTS;

        $PlaceID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $place = $this->bannerMgr->GetPlace($PlaceID);
        if ($place === null)  {
            UserError::AddErrorIndexed('global', ERR_A_BANNERS_NOT_FOUND);
            return false;
        }

        $Name           = App::$Request->Post['Name']->Value();
        $IsVisible      = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if (empty($Name)) {
            UserError::AddErrorIndexed('Name', ERR_A_BANNERS_EMPTY_PLACE_NAME);
        }

        if(UserError::IsError()) {
            return false;
        }

        $place->Name        = $Name;
        $place->IsVisible   = $IsVisible;
        $place->Update();

        return true;
    }


    private function getDatetimeRule($dates, $times)
    {
        if ($dates === null && $times === null) {
            return null;
        }

        $cnt  = count($dates);
        $result = array();
        for($i = 0; $i < $cnt; $i++) {
            $rule_date = "*";
            $rule_time = "*";

            if (preg_match("@^(\d{2}|\*)\.(\d{2}|\*)\.(\d{4}|\*)$@", $dates[$i], $matches))
                $rule_date = $dates[$i];

            if (preg_match("@^(\d{2}|\*):(\d{2}|\*)$@", $times[$i], $matches))
                $rule_time = $times[$i];

            $result[$i] = $rule_date.",".$rule_time;
        }

        return $result;
    }


    private function _PostSaveBanners()
    {
        $orders = App::$Request->Post['orders']->AsArray();
        foreach($orders as $bannerid => $ord) {
            $banner = $this->bannerMgr->GetBanner($bannerid);

            if($banner === null) {
                continue;
            }

            $banner->Ord = $ord;
            $banner->Update();
        }
    }
}