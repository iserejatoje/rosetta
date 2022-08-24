<?php

if(1)
{
    $catalog_error_code = 0;
    define('ERR_A_REWARD_MASK', 0x01640000);

    define('ERR_A_WORKER_NOT_FOUND', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_WORKER_NOT_FOUND] = 'Работник не найден';

}
ini_set('max_execution_time', '60');
date_default_timezone_set(TIMEZONE);

class AdminModule
{
    static $TITLE = 'Награды';

    static $ROW_ON_PAGE = 15;
    static $PAGES_ON_PAGE = 5;
    static $ORDER_ROWS_COUNT =100;

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $rewardMgr;

    function __construct($config, $aconfig, $id)
    {
        echo 'consructor'; exit;
        static $ROW_ON_PAGE = 11;
        static $PAGES_ON_PAGE = 10;
        static $ORDER_ROWS_COUNT = 20;

        global $CONFIG,$DCONFIG, $OBJECTS;
        ini_set('memory_limit', '128M');
        LibFactory::GetMStatic('reward', 'rewardmgr');

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");

        $this->_id = &$id;
        $this->_config = &$config;

        if ($this->_config['root']) {
                $this->_id = ($this->_config['root']);
        }

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=workers');

        $this->rewardmgr = RewardMgr::GetInstance();

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
            case 'workers':
                $html = $this->_GetWorkers();
                break;

            case 'ajax_discountcard_toggle_active':
                $this->_GetAjaxToggleDiscountCardActive();
                break;

            case 'new_worker':
                $this->_title = "Добавить открытку";
                $html = $this->_GetWorkerNew();
                break;

            case 'edit_worker':
                $this->_title = "Редактировать сотрудника";
                $html = $this->_GetWorkerEdit();
                break;

            case 'ajax_worker_toggle_visible':
                $this->_GetAjaxToggleWorkerVisible();
                break;

            case 'delete_worker':
                $this->_GetWorkerDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=workers';
                break;

            default:
                $this->_title = "Сотрудники";
                $html = $this->_GetWorkers();
                break;
        }
        return $html;
    }

    function GetTabs()
    {

        $tabs = [
            ['name' => 'action', 'value' => 'workers', 'text' => 'Сотрудники'],
            ['name' => 'action', 'value' => 'rewards', 'text' => 'Награды'],
        ];

        return [
            'tabs' => $tabs,
            'selected' => $this->_page,
        ];
    }

    function GetTitle()
    {
        return $this->_title;
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

        switch($_POST['action']) {
            case 'new_worker':
                if (($pid = $this->_PostWorker()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=workers');
                break;
            case 'edit_worker':
                if (($pid = $this->_PostWorker()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=workers');
                break;
        }
        return false;
    }

    // =============================
    private function _GetWorkers()
    {
        global $DCONFIG, $CONFIG;

        // if(App::$User->IsInRole('u_bouquet_editor') == false &&
        //     (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) == false) {
        //     UserError::AddErrorIndexed('global', ERR_A_SECTION_ACCESS_DENIED);
        //     return STPL::Fetch('admin/modules/catalog/errors');
        // }

echo '123'; exit;
        $filter = [
            'flags' => [
                'objects' => true,
                'is_visible' => -1,
                'section_id' => $this->_id,
            ],
            'dbg' => 0,
        ];

        $workers = $this->rewardMgr->GetWorkers($filter);

        return STPL::Fetch('admin/modules/reward/worker_list', [
            'workers' => $workers,
            'section_id' => $this->_id,
        ]);
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

   

      
}