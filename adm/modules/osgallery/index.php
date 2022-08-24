<?php

ini_set('max_execution_time', '60');

$osgallery_error_code = 0;
define('ERR_A_OSGALLERY_MASK', 0x01640000);

define('ERR_A_GALLERY_GROUP_NOT_FOUND', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_GROUP_NOT_FOUND] = 'Группа не найдена';

define('ERR_A_GALLERY_PHOTO_NOT_FOUND', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_PHOTO_NOT_FOUND] = 'Фото не найдено';

define('ERR_A_GALLERY_FILTER_NOT_FOUND', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_FILTER_NOT_FOUND] = 'Фильтр не найден';

define('ERR_A_GALLERY_EMPTY_FILTER_NAME', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_EMPTY_FILTER_NAME] = 'Не указано название фильтра';

define('ERR_A_GALLERY_EMPTY_FILTER_NAMEID', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_EMPTY_FILTER_NAMEID] = 'Название ключа фильтра не указано';

define('ERR_A_GALLERY_EMPTY_PARAM_FILTER', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_GALLERY_EMPTY_PARAM_FILTER] = 'Необходимо указать хотя бы один параметр';

define('ERR_A_PHOTO_EMPTY_NAME', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_PHOTO_EMPTY_NAME] = 'Не указано название галереи.';

define('ERR_A_OSGALLERY_EMPTY_TITLE', ERR_A_OSGALLERY_MASK | $osgallery_error_code++);
UserError::$Errors[ERR_A_OSGALLERY_EMPTY_TITLE] = 'Не указано название страницы.';

class AdminModule
{
    static $TITLE = 'Галерея';

    static $ROW_ON_PAGE = 20;
    static $PAGES_ON_PAGE = 5;

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $osgallerymgr;

    function __construct($config, $aconfig, $id)
    {
        global $CONFIG,$DCONFIG, $OBJECTS;
        LibFactory::GetMStatic('osgallery', 'osgallerymgr');

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");


        $this->_id = &$id;
        $this->_config = &$config;

        if ($this->_config['root']) {
                $this->_id = ($this->_config['root']);
        }

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=page');

        $this->osgallerymgr = OSGalleryMgr::getInstance(false);

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
            case 'edit_page':
                $this->_title = "Редактировать";
                $html = $this->_GetPageEdit();
                break;

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
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=group_photos&groupid='.$_GET['groupid']);
                break;
            case 'group_photos':
                $this->_title = "Список фотографии";
                $html = $this->_GetPhotos();
                break;
            case 'ajax_photo_toggle_visible':
                $this->_GetAjaxTogglePhotoVisible();
                break;
            // ===============================
            case 'edit_filters':
                $this->_title = "Редактировать фильтры";
                $html = $this->_GetGroupFiltersEdit();
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
            case 'filters_delete':
                if ($this->_PostFiltersDelete())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;
            // ===============================
            case 'groups':
                $this->_title = "Галереи";
                $html = $this->_GetGroups();
                break;
            case 'new_group':
                $this->_title = "Добавить галерею";
                $html = $this->_GetGroupNew();
                break;
            case 'edit_group':
                $this->_title = "Редактировать";
                $html = $this->_GetGroupEdit();
                break;
            case 'delete_group':
                $this->_GetGroupDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=groups');
                break;
            case 'group_photos':
                $this->_title = "Список";
                $html = $this->_GetPhotos();
                break;
            case 'ajax_group_toggle_visible':
                $this->_GetAjaxToggleGroupVisible();
                break;
            default:
                $this->_title = "Страница";
                $html = $this->_GetPageEdit();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'edit_page', 'text' => 'Описание страницы'),
                array('name' => 'action', 'value' => 'groups', 'text' => 'Галереи'),
                array('name' => 'action', 'value' => 'filters', 'text' => 'Фильтры'),
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
            case 'new_page':
                if (($pid = $this->_PostPage()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_page');
                break;
            case 'edit_page':
                if (($pid = $this->_PostPage()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_page');
                break;

            case 'new_group':
                if (($pid = $this->_PostGroup()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=groups');
                break;
            case 'edit_group':
                if (($pid = $this->_PostGroup()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=groups');
                break;
            case 'save_groups':
                if($this->_PostSaveGroups())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=groups');

            case 'new_photo':
                if (($pid = $this->_PostPhoto()) > 0)
                {
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=group_photos&groupid='.$_POST['groupid']);
                }
                break;
            case 'edit_photo':
                if (($pid = $this->_PostPhoto()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=group_photos&groupid='.$_POST['groupid']);
                break;
            case 'save_photos':
                if($this->_PostSavePhotos())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=group_photos&groupid='.$_POST['groupid']);

            case 'new_filter':
                if ($this->_PostFilter())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;
            case 'edit_filter':
                if ($this->_PostFilter())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=filters');
                break;
            case 'edit_filters':
                if (($pid = $this->_PostGroupFiltersEdit()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_filters&id='.$pid);
                break;
        }
        return false;
    }

    private function _GetGroups()
    {
        global $DCONFIG, $CONFIG;

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => -1,
                'SectionID' => $this->_id,
            ],
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        ];

        $list = $this->osgallerymgr->GetGroups($filter);

        return STPL::Fetch('admin/modules/osgallery/group_list', array(
            'list'       => $list,
            'section_id' => $this->_id,
        ));
    }

    private function _GetAjaxToggleGroupVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $groupid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);
        if ($group === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $group->IsVisible = !$group->IsVisible;
        $group->Update();

        $json->send(array(
            'status'  => 'ok',
            'visible' => (int) $group->IsVisible,
            'groupid' => $groupid,
        ));
        exit;
    }

    private function _GetGroupDelete()
    {
        $groupid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);

        if ($group === null)
            return;

        $group->Remove();
        return;
    }

    private function _PostSaveGroups()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        foreach($orders as $groupid => $ord)
        {
            $group = $this->osgallerymgr->GetGroup($groupid);
            if ($group === null)
                continue;

            $group->Ord = $ord;
            $group->Update();
        }
        return true;
    }

     private function _GetGroupNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']  = App::$Request->Post['Name']->Value();
            $form['Text']  = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Name']  = '';
            $form['Text']  = '';
            $form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/osgallery/edit_group', array(
            'form'       => $form,
            'action'     => 'new_group',
            'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostGroup()
    {
        global $CONFIG, $OBJECTS;

        $groupid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Name      = App::$Request->Post['Name']->Value();
        $Text      = App::$Request->Post['Text']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_GALLERY_EMPTY_NAME);

        if(UserError::IsError()) {
            return false;
        }

        if($groupid > 0)
        {
            $group = $this->osgallerymgr->GetGroup($groupid);
            if ($group === null) {
                UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
                return false;
            }

            $group->Name      = $Name;
            $group->Text      = $Text;
            $group->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
                'Name'      => $Name,
                'Text'      => $Text,
                'IsVisible' => $IsVisible,
                'SectionID' => $this->_id,
            );

            $group = new OSGroup($Data);
        }

        // ============================
        $group->Update();
        $arr_photos = [
            'Thumb' => ['Thumb'],
        ];

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $group->$photoName = null;
                try
                {
                    $group->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $group->$photoName = null;
                    return false;
                }
            }
        }

        $group->Update();
        $this->_setMessage();

        return $group->ID;
    }

    private function _GetGroupEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $groupid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $group = $this->osgallerymgr->GetGroup($groupid);
        if ($group === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLARY_GROUP_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
        }

        $form['GroupID'] = $group->ID;
        $form['Thumb']   = $group->Thumb;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Name']      = App::$Request->Post['Name']->Value();
            $form['Text']      = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['IsVisible'] = $group->IsVisible;
            $form['Name']      = $group->Name;
            $form['Text']      = $group->Text;
        }

        return STPL::Fetch('admin/modules/osgallery/edit_group', array(
            'form'       => $form,
            'action'     => 'edit_group',
            'group'      => $group,
            'section_id' => $this->_id,
        ));
    }

    // ==============================================================
    private function _GetPhotos()
    {
        global $DCONFIG, $CONFIG;

        $groupid = App::$Request->Get['groupid']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);
        if($group === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
        }

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => -1,
                'GroupID' => $groupid,
            ],
            'field' => array('Ord'),
            'dir' => array('ASC'),
            'dbg' => 0,
        ];

        $list = $this->osgallerymgr->GetPhotos($filter);

        return STPL::Fetch('admin/modules/osgallery/group_photos', array(
            'list'       => $list,
            'action'     => 'group_photos',
            'section_id' => $this->_id,
            'group'      => $group,
            'groupid'    => $group->id,
        ));
    }

    private function _GetAjaxTogglePhotoVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $photoid    = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $photo = $this->osgallerymgr->GetPhoto($photoid);
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
        $photo = $this->osgallerymgr->GetPhoto($photoid);
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
            $photo = $this->osgallerymgr->GetPhoto($photoid);
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

        $groupid    = App::$Request->Get['groupid']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);
        if ($group === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLARY_GROUP_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
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

        return STPL::Fetch('admin/modules/osgallery/edit_photo', array(
            'form'       => $form,
            'action'     => 'new_photo',
            'groupid'    => $groupid,
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
        $groupid   = App::$Request->Post['groupid']->Int(0, Request::UNSIGNED_NUM);

        $Name      = App::$Request->Post['Name']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Name == "")
            UserError::AddErrorIndexed('Name', ERR_A_PHOTO_EMPTY_NAME);

        if(UserError::IsError()) {
            return false;
        }

        if($photoid > 0)
        {
            $photo = $this->osgallerymgr->GetPhoto($photoid);
            if ($photo === null) {
                UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
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
                'GroupID'   => $groupid,
            ];

            $photo = new OSPhoto($Data);
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
        $groupid    = App::$Request->Get['groupid']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);
        if ($group === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
        }

        $photo = $this->osgallerymgr->GetPhoto($photoid);
        if ($photo === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_PHOTO_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
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

        return STPL::Fetch('admin/modules/osgallery/edit_photo', array(
            'form'       => $form,
            'action'     => 'edit_photo',
            'section_id' => $this->_id,
            'groupid'    => $groupid,
        ));
    }

    // ===============================================
    private function _GetFilters()
    {
        global $DCONFIG, $CONFIG;

        $filters = $this->osgallerymgr->GetFilters();

        return STPL::Fetch('admin/modules/osgallery/filters_list', array(
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
            $form['NameID'] = '';
            $form['Name']   = '';
        }

        return STPL::Fetch('admin/modules/osgallery/edit_filter', [
            'action'     => 'new_filter',
            'section_id' => $this->_id,
            'form'       => $form,
            'params'     => $params,
        ]);
    }

    private function _GetFilterEdit()
    {
        global $DCONFIG, $CONFIG;
        $FilterID   = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $filter = $this->osgallerymgr->GetFilter($FilterID);
        if ($filter === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_FILTER_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_filter');
        }

        $form['FilterID'] = $filter->ID;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['NameID']         = App::$Request->Post['NameID']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
            $form['Name']           = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

            $param_ids          = App::$Request->Post['param_id']->AsArray(array(), Request::INTEGER_NUM);
            $param_names        = App::$Request->Post['param_name']->AsArray();
            $param_values       = App::$Request->Post['param_value']->AsArray();
            $param_availability = App::$Request->Post['param_availability']->AsArray();
            $param_ord          = App::$Request->Post['param_ord']->AsArray();

            if (is_array($param_names) && count($param_names) > 0)
            {
                foreach($param_names as $k => $v)
                    $params[$param_ids[$k]] = array(
                        'Name'        => $v,
                        'Value'       => $param_values[$k],
                        'IsAvailable' => $param_availability[$k],
                        'Ord'         => $param_ord[$k],
                    );
            }
        }
        else
        {
            $form['NameID']     = $filter->NameID;
            $form['Name']       = $filter->Name;

             $arrFilter = [
                'field' => ['Ord'],
                'dir' => ['ASC'],
            ];

            $params = $filter->GetParams($arrFilter);
        }

        return STPL::Fetch('admin/modules/osgallery/edit_filter', [
            'action'     => 'edit_filter',
            'section_id' => $this->_id,
            'form'       => $form,
            'params'     => $params,
        ]);
    }

    private function _PostFilter()
    {
        global $CONFIG, $OBJECTS;

        $FilterID           = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $NameID             = App::$Request->Post['NameID']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
        $Name               = App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

        $param_ids          = App::$Request->Post['param_id']->AsArray(array(), Request::INTEGER_NUM);
        $param_names        = App::$Request->Post['param_name']->AsArray();
        $param_values       = App::$Request->Post['param_value']->AsArray();
        $param_availability = App::$Request->Post['param_availability']->AsArray();
        $param_ord          = App::$Request->Post['param_ord']->AsArray();

        if (empty($Name))
            UserError::AddErrorIndexed('Name', ERR_A_GALLERY_EMPTY_FILTER_NAME);

        if (empty($NameID))
            UserError::AddErrorIndexed('NameID', ERR_A_GALLERY_EMPTY_FILTER_NAMEID);

        if (empty($param_names))
            UserError::AddErrorIndexed('params', ERR_A_GALLERY_EMPTY_PARAM_FILTER);

        if(UserError::IsError())
            return false;

        if ($FilterID > 0) {
            $filter = $this->osgallerymgr->GetFilter($FilterID);

            $filter->NameID = $NameID;
            $filter->Name   = $Name;

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
                    'value'       => $param_values[$k],
                    'isavailable' => $param_availability[$k],
                    'ord'         => $param_ord[$k],
                ];

                if (!isset($param_ids[$k]))
                    $filter->AddParam($v, $options);
                else
                    $filter->UpdateParam($param_ids[$k], $v, $options);
            }
        } else {
            $Data = array(
                'Name'          => $Name,
                'NameID'        => $NameID,
            );

            $filter = new OSFilter($Data);

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
                $filter = $this->osgallerymgr->GetFilter($id);
                if ($filter === null)
                    continue ;

                $filter->Remove();
            }
        }
    }

    private function _GetGroupFiltersEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $groupid  = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $group = $this->osgallerymgr->GetGroup($groupid);
        if ($group === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
            return STPL::Fetch('admin/modules/osgallery/edit_group');
        }

        $form['GroupID']  = $group->ID;
        $fParams = $group->GetFilterParam();
        $filters = $this->osgallerymgr->GetFilters();

        return STPL::Fetch('admin/modules/osgallery/edit_group_filters', array(
            'action'     => 'edit_filters',
            'form'       => $form,
            'filters'    => $filters,
            'fParams'    => $fParams,
            'section_id' => $this->_id,
            'group'    => $group,
        ));
    }

    private function _PostGroupFiltersEdit() {
        global $CONFIG, $OBJECTS;

        $groupid      = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $FilterParams = App::$Request->Post['Filters']->AsArray(array(), Request::INTEGER_NUM);

        if(UserError::IsError())
            return false;

        if($groupid > 0) {
            $group = $this->osgallerymgr->GetGroup($groupid);

            if ($group === null) {
                UserError::AddErrorIndexed('global', ERR_A_GALLERY_GROUP_NOT_FOUND);
                return false;
            }

            $group->RemoveFilterParam();
            foreach($FilterParams as $filter_id => $v)
            {
                foreach($v as $param => $param_id)
                {
                    $group->AddFilterParam($filter_id, $param_id);
                }
            }

            $this->_setMessage();
        }
    }

    private function _GetPageEdit()
    {
        global $DCONFIG, $CONFIG;

        $page = $this->osgallerymgr->GetPageBySection($this->_id);
        $form = [];
        if($page === null) {
            $form['id']        = 0;
            $form['title']     = '';
            $form['text']      = '';
            $form['addtext']   = '';
            $form['formtitle'] = '';
            $form['isvisible'] = 1;
            $form['thumb']     = '';
            $form['withdate']  = '';
            $form['theme']     = 0;
            $action            = "new_page";
        } else {
            $form['id']        = $page->id;
            $form['title']     = $page->title;
            $form['text']      = $page->text;
            $form['addtext']   = $page->addtext;
            $form['isvisible'] = $page->isvisible;
            $form['thumb']     = $page->thumb;
            $form['formtitle'] = $page->formtitle;
            $form['withdate']  = $page->withdate;
            $form['theme']     = $page->theme;
            $action            = "edit_page";
        }

        return STPL::Fetch('admin/modules/osgallery/page_editor', array(
            'form'       => $form,
            'path'       => $path,
            'section_id' => $this->_id,
            'action'     => $action,
        ));
    }

    /**
     * @return array|bool|null
     */
    private function _PostPage()
    {
        global $CONFIG, $OBJECTS;

        $id        = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $title     = App::$Request->Post['title']->Value();
        $text      = App::$Request->Post['text']->Value();
        $addtext   = App::$Request->Post['addtext']->Value();
        $formtitle = App::$Request->Post['formtitle']->Value();
        $isvisible = App::$Request->Post['isvisible']->Enum(0, array(0,1));
        $withdate  = App::$Request->Post['withdate']->Enum(0, array(0,1));
        $theme     = App::$Request->Post['theme']->Enum(0, array_keys(OSGalleryMgr::$THEMES));

        if ($title == "")
            UserError::AddErrorIndexed('title', ERR_A_OSGALLERY_EMPTY_TITLE);

        if(UserError::IsError())
            return false;

        if($id > 0)
        {
            $page = $this->osgallerymgr->GetPage($id);
            if ($page === null) {
                UserError::AddErrorIndexed('global', ERR_A_OSGALLERY_PAGE_NOT_FOUND);
                return false;
            }

            $page->title     = $title;
            $page->text      = $text;
            $page->addtext   = $addtext;
            $page->formtitle = $formtitle;
            $page->isvisible = $isvisible;
            $page->withdate  = $withdate;
            $page->theme     = $theme;
        }
        else
        {
            $Data = array(
                'title'     => $title,
                'text'      => $text,
                'addtext'   => $addtext,
                'formtitle' => $formtitle,
                'isvisible' => $isvisible,
                'withdate'  => $withdate,
                'theme'     => $theme,
                'sectionid' => $this->_id,
            );

            $page = new OSPage($Data);
        }

        // ============================
        // $page->Update();

        $arr_photos = [
            'Thumb' => ['Thumb'],
        ];

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $page->$photoName = null;
                try
                {
                    $page->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $page->$photoName = null;
                    return false;
                }
            }
        }

        $page->Update();

        $this->_setMessage();

        return $page->ID;
    }

}