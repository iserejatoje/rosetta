<?php

ini_set('max_execution_time', '60');

$news_error_code = 0;
define('ERR_A_NEWS_MASK', 0x01640000);

define('ERR_A_NEWS_NOT_FOUND', ERR_A_NEWS_MASK | $news_error_code++);
UserError::$Errors[ERR_A_NEWS_NOT_FOUND] = 'Новость не найдена';

define('ERR_A_NEWS_TITLE_EMPTY', ERR_A_NEWS_MASK | $news_error_code++);
UserError::$Errors[ERR_A_NEWS_TITLE_EMPTY] = 'Необходим ввести заголовок';

define('ERR_A_NEWS_ANNOUNCE_EMPTY', ERR_A_NEWS_MASK | $news_error_code++);
UserError::$Errors[ERR_A_NEWS_ANNOUNCE_EMPTY] = 'Необходим ввести анонс новости';

define('ERR_A_NEWS_TEXT_EMPTY', ERR_A_NEWS_MASK | $news_error_code++);
UserError::$Errors[ERR_A_NEWS_TEXT_EMPTY] = 'Необходим ввести текст новости';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_NEWS_MASK | $news_error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
    static $TITLE = 'Новости';

    static $ROW_ON_PAGE = 20;
    static $PAGES_ON_PAGE = 5;

    private $_db;
    private $_config;
    private $_aconfig;
    private $_page;
    private $_id;
    private $_title;
    private $_params;

    private $newsmgr;

    function __construct($config, $aconfig, $id)
    {
        global $CONFIG,$DCONFIG, $OBJECTS;
        LibFactory::GetMStatic('news', 'newsmgr');

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");


        $this->_id = &$id;
        $this->_config = &$config;

        if ($this->_config['root']) {
                $this->_id = ($this->_config['root']);
        }

        $this->_db = DBFactory::GetInstance($this->_config['db']);

        if (empty($_GET['action']) && empty($_POST['action']))
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=news');

        $this->newsmgr = NewsMgr::getInstance(false);

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
            case 'new_news':
                $this->_title = "Добавить новость";
                $html = $this->_GetNewsNew();
                break;
            case 'edit_news':
                $this->_title = "Редактировать новость";
                $html = $this->_GetNewsEdit();
                break;
            case 'delete_news':
                $this->_GetNewsDelete();
                Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=news');
                break;
            case 'news':
                $this->_title = "Список новостей";
                $html = $this->_GetNews();
                break;
            case 'ajax_news_toggle_visible':
                $this->_GetAjaxToggleNewsVisible();
                break;
            default:
                $this->_title = "Список новостей";
                $html = $this->_GetNews();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        return array(
            'tabs' => array(
                array('name' => 'action', 'value' => 'news', 'text' => 'Новости'),
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
            case 'new_news':
                if (($pid = $this->_PostNews()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=news&id='.$pid);
                break;
            case 'edit_news':
                if (($pid = $this->_PostNews()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=news&id='.$pid);
                break;
            case 'save_news':
                if($this->_PostSaveNews())
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=news');
        }
        return false;
    }

    private function _GetNews()
    {
        global $DCONFIG, $CONFIG;

        $field  = App::$Request->Get['field']->Enum('title', ['published', 'title', 'isvisible', 'ord']);
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

        $list = $this->newsmgr->GetNewsList($filter);

        return STPL::Fetch('admin/modules/news/news_list', array(
            'list'       => $list,
            'section_id' => $this->_id,
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
        ));
    }

    private function _GetAjaxToggleNewsVisible()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $newsid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $news = $this->newsmgr->GetNews($newsid);
        if ($news === null)
        {
            $json->send(array('status' => 'error'));
            exit;
        }

        $news->IsVisible = !$news->IsVisible;
        $news->Update();

        $json->send(array(
            'status' => 'ok',
            'visible' => (int) $news->IsVisible,
            'newsid' => $newsid,
        ));
        exit;
    }

    private function _GetNewsDelete()
    {
        $newsid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $news = $this->newsmgr->GetNews($newsid);
        if ($news === null)
            return;

        $news->Remove();
        return;
    }

    private function _PostSaveNews()
    {
        global $CONFIG, $OBJECTS;

        $orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0)
            return true;

        foreach($orders as $newsid => $ord)
        {
            $news = $this->newsmgr->GetNews($newsid);
            if ($news === null)
                continue;

            $news->Ord = $ord;
            $news->Update();
        }
        return true;
    }

     private function _GetNewsNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Title']     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
            $form['Published'] = App::$Request->Post['Published']->Value();
            $form['Announce']  = App::$Request->Post['Announce']->Value();
            $form['Text']      = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
            $form['Title']     = '';
            $form['Published'] = '';
            $form['Announce']  = '';
            $form['Text']      = '';
            $form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/news/edit_news', array(
            'form'       => $form,
            'action'     => 'new_news',
            'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostNews()
    {
        global $CONFIG, $OBJECTS;

        $newsid    = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $Title     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN );
        $Announce  = App::$Request->Post['Announce']->Value();
        $Published = App::$Request->Post['Published']->Value();
        $Text      = App::$Request->Post['Text']->Value();
        $IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Title == "")
            UserError::AddErrorIndexed('Title', ERR_A_NEWS_TITLE_EMPTY);

        if ($Announce == "")
            UserError::AddErrorIndexed('Announce', ERR_A_NEWS_ANNOUNCE_EMPTY);

        if ($Text == "")
            UserError::AddErrorIndexed('Text', ERR_A_NEWS_TEXT_EMPTY);

        if(UserError::IsError())
        {
            return false;
        }

        if($newsid > 0)
        {
            $news = $this->newsmgr->GetNews($newsid);
            if ($news === null) {
                UserError::AddErrorIndexed('global', ERR_A_NEWS_NOT_FOUND);
                return false;
            }

            $news->Title     = $Title;
            $news->Announce  = $Announce;
            $news->Text      = $Text;
            $news->IsVisible = $IsVisible;
            $news->Published = $Published;
        }
        else
        {
            $Data = array(
                'Published' => date('Y-m-d', strtotime($Published)),
                'Title'     => $Title,
                'Announce'  => $Announce,
                'Text'      => $Text,
                'IsVisible' => $IsVisible,
            );

            $news = new News($Data);
        }

        $news->Update();

        // ============================

        $arr_photos = [
            'Photo' => ['Photo'],
        ];

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $news->$photoName = null;
                try
                {
                    $news->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key,ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $news->$photoName = null;
                    return false;
                }
            }
        }

        $news->Update();
        $this->_setMessage();

        return $news->ID;
    }

    private function _GetNewsEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $newsid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $news = $this->newsmgr->GetNews($newsid);
        if ($news === null)
        {
            UserError::AddErrorIndexed('global', ERR_A_NEWS_NOT_FOUND);
            return STPL::Fetch('admin/modules/news/edit_news');
        }

        $form['NewsID'] = $news->ID;
        $form['Photo']  = $news->Photo;

        if ( App::$Request->requestMethod === Request::M_POST )
        {
            $form['Title']     = App::$Request->Post['Title']->Value();
            $form['Published'] = App::$Request->Post['Published']->Value();
            $form['Announce']  = App::$Request->Post['Announce']->Value();
            $form['Text']      = App::$Request->Post['Text']->Value();
            $form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        }
        else
        {
            $form['IsVisible'] = $news->IsVisible;
            $form['Published'] = $news->Published;
            $form['Title']     = $news->Title;
            $form['Announce']  = $news->Announce;
            $form['Text']      = $news->Text;
        }

        return STPL::Fetch('admin/modules/news/edit_news', array(
            'form'       => $form,
            'action'     => 'edit_news',
            'section_id' => $this->_id,
        ));
    }

}