<?php

ini_set('max_execution_time', '60');

$client_error_code = 0;
define('ERR_A_CLIENT_MASK', 0x01640000);

define('ERR_A_CLIENT_NOT_FOUND', ERR_A_CLIENT_MASK | $client_error_code++);
UserError::$Errors[ERR_A_CLIENT_NOT_FOUND] = 'Клиент не найдена';

define('ERR_A_CLIENT_TITLE_EMPTY', ERR_A_CLIENT_MASK | $client_error_code++);
UserError::$Errors[ERR_A_CLIENT_TITLE_EMPTY] = 'Необходим ввести название компании';

define('ERR_A_СLIENT_TEXT_EMPTY', ERR_A_CLIENT_MASK | $client_error_code++);
UserError::$Errors[ERR_A_СLIENT_TEXT_EMPTY] = 'Необходим ввести описание компании';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_CLIENT_MASK | $client_error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
    static $TITLE = 'Клиенты';

    static $ROW_ON_PAGE = 20;
    static $PAGES_ON_PAGE = 5;

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $clientmgr;

    function __construct($config, $aconfig, $id)
    {
        global $CONFIG,$DCONFIG, $OBJECTS;
        LibFactory::GetMStatic('clients', 'clientmgr');

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");


        $this->_id = &$id;
        $this->_config = &$config;

        if ($this->_config['root']) {
                $this->_id = ($this->_config['root']);
        }

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=clients');

        $this->clientmgr = ClientMgr::getInstance(false);

        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

        App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');

        App::$Title->AddScript('/resources/scripts/themes/editors/ckeditor/ckeditor.js');
        App::$Title->AddScript('/resources/scripts/themes/editors/ckeditor/elfinder/js/elfinder.min.js');
        App::$Title->AddScript('/resources/scripts/themes/editors/tinymce/js/tinymce/tinymce.min.js');
        // App::$Title->AddScript('/resources/scripts/themes/editors/tinymce/js/tinymce/langs/ru.js');

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
            case 'new_client':
                $this->_title = "Добавить компанию";
                $html = $this->_GetClientNew();
                break;
            case 'edit_client':
                $this->_title = "Редактировать компанию";
                $html = $this->_GetClientEdit();
                break;
            case 'delete_client':
                $this->_GetClientDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=clients');
                break;
            case 'clients':
                $this->_title = "Список компаниий";
                $html = $this->_GetClients();
                break;
            case 'ajax_client_toggle_visible':
                $this->_GetAjaxToggleClientVisible();
                break;
            default:
                $this->_title = "Список компаний";
                $html = $this->_GetClients();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'clients', 'text' => 'Клиенты'),
            ),
            'selected' => $this->_page
        );
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
            case 'new_client':
                if (($pid = $this->_PostClient()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=clients');
                break;
            case 'edit_client':
                if (($pid = $this->_PostClient()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=clients');
                break;
            case 'save_client':
                if($this->_PostSaveClients())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=clients');
        }
        return false;
    }

    private function _GetClients()
    {
        global $DCONFIG, $CONFIG;

        $field  = App::$Request->Get['field']->Enum('title', ['title', 'ord']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $filter = array(
            'flags' => array(
                'objects' => true,
                'IsVisible' => -1,
            ),
            'field' => [$field],
            'dir' => [$dir],
            'dbg' => 0,
        );

        $list = $this->clientmgr->GetClients($filter);

        return STPL::Fetch('admin/modules/clients/client_list', array(
            'list'       => $list,
            'section_id' => $this->_id,
            'sorting'    => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetAjaxToggleClientVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $clientid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $client = $this->clientmgr->GetClient($clientid);
        if ($client === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $client->IsVisible = !$client->IsVisible;
        $client->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $client->IsVisible,
            'clientid' => $clientid,
        ));
        exit;
    }

    private function _GetClientDelete()
    {
        $clientid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $client = $this->clientmgr->GetClient($clientid);
        if ($client === null)
            return;

        $client->Remove();
        return;
    }

    private function _PostSaveClients()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        foreach($orders as $id => $ord)
        {
            $client = $this->clientmgr->GetClient($id);
            if ($client === null)
                continue;

            $client->Ord = $ord;
            $client->Update();
        }
        return true;
    }

     private function _GetClientNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Title']     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
            $form['Sign']     = App::$Request->Post['Sign']->Value();
            $form['Text']      = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Title']     = '';
            $form['Text']      = '';
            $form['Sign']      = '';
            $form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/clients/edit_client', array(
            'form'       => $form,
            'action'     => 'new_client',
            'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostClient()
    {
        global $CONFIG, $OBJECTS;

        $clientid    = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Title     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN);
        $Sign     = App::$Request->Post['Sign']->Value();
        $Text      = App::$Request->Post['Text']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Title == "")
            UserError::AddErrorIndexed('Title', ERR_A_CLIENT_TITLE_EMPTY);

        // if ($Text == "")
        //     UserError::AddErrorIndexed('Text', ERR_A_CLIENT_TEXT_EMPTY);

        if(UserError::IsError())
        {
            return false;
        }

        if($clientid > 0)
        {
            $client = $this->clientmgr->GetClient($clientid);
            if ($client === null) {
                UserError::AddErrorIndexed('global', ERR_A_CLIENT_NOT_FOUND);
                return false;
            }

            $client->Title     = $Title;
            $client->Text      = $Text;
            $client->Sign      = $Sign;
            $client->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
                'Title'     => $Title,
                'Text'      => $Text,
                'Sign'      => $Sign,
                'IsVisible' => $IsVisible,
            );

            $client = new Client($Data);
        }

        // $client->Update();

        // ============================

        $arr_photos = [
            'PhotoSmallHover' => ['PhotoSmallHover'],
            'PhotoSmall'      => ['PhotoSmall'],
            'PhotoBig'        => ['PhotoBig'],
        ];

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $client->$photoName = null;
                try
                {
                    $client->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $client->$photoName = null;
                    return false;
                }
            }
        }

        $client->Update();
        $this->_setMessage();

        return $client->ID;
    }

    private function _GetClientEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $clientid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $client = $this->clientmgr->GetClient($clientid);
        if ($client === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_CLIENT_NOT_FOUND);
            return STPL::Fetch('admin/modules/clients/edit_client');
        }

        $form['ClientID']        = $client->ID;
        $form['PhotoSmall']      = $client->PhotoSmall;
        $form['PhotoSmallHover'] = $client->PhotoSmallHover;
        $form['PhotoBig']        = $client->PhotoBig;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Title']     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
            $form['Sign']     = App::$Request->Post['Sign']->Value();
            $form['Text']      = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['IsVisible'] = $client->IsVisible;
            $form['Title']     = $client->Title;
            $form['Sign']     = $client->Sign;
            $form['Text']      = $client->Text;
        }

        return STPL::Fetch('admin/modules/clients/edit_client', array(
            'form'       => $form,
            'action'     => 'edit_client',
            'section_id' => $this->_id,
        ));
    }
}