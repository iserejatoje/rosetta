<?php

ini_set('max_execution_time', '60');

$catalog_error_code = 0;
define('ERR_A_SHARE_MASK', 0x01640000);

define('ERR_A_SHARE_EMPTY_TITLE', ERR_A_SHARE_MASK | $error_code++);
UserError::$Errors[ERR_A_SHARE_EMPTY_TITLE] = 'Не указан заголовок акции';

define('ERR_A_SHARE_EMPTY_TEXT', ERR_A_SHARE_MASK | $error_code++);
UserError::$Errors[ERR_A_SHARE_EMPTY_TEXT] = 'Не указан текст акции';

define('ERR_A_SHARE_NOT_FOUND', ERR_A_SHARE_MASK | $error_code++);
UserError::$Errors[ERR_A_SHARE_NOT_FOUND] = 'Акция не найдена';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_SHARE_MASK | $error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
	static $TITLE = 'Акции';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $_sharemgr;

	function __construct($config, $aconfig, $id)
	{
		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('shares', 'sharemgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=shares');

		$this->_sharemgr = ShareMgr::getInstance(false);

		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

		App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');

		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js');

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
			case 'new_share':
				$this->_title = "Добавить акцию";
				$html = $this->_GetShareNew();
				break;
			case 'edit_share':
				$this->_title = "Редактировать акцию";
				$html = $this->_GetShareEdit();
				break;
			case 'delete_share':
				$this->_GetShareDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=shares');
				break;
			case 'shares':
				$this->_title = "Список акций";
				$html = $this->_GetShares();
				break;
			case 'ajax_share_toggle_visible':
				$this->_GetAjaxToggleShareVisible();
				break;
			default:
				$this->_title = "Список акций";
				$html = $this->_GetShares();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'shares', 'text' => 'Акции'),
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
			case 'new_share':
                if (($pid = $this->_PostShare()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_share&id='.$pid);
                break;
            case 'edit_share':
				if (($pid = $this->_PostShare()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_share&id='.$pid);
				break;
			case 'save_shares':
				if($this->_PostSaveShares())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=shares');
		}
		return false;
	}

	private function _GetShares()
	{
		global $DCONFIG, $CONFIG;

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
			),
			'field' => array('Ord'),
			'dir' => array('ASC'),
			'dbg' => 0,
		);

		$shares = $this->_sharemgr->GetShares($filter);

		return STPL::Fetch('admin/modules/shares/shares_list', array(
			'shares'    => $shares,
			'section_id' => $this->_id,
		));
	}



	private function _GetAjaxToggleShareVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$shareid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$share = $this->_sharemgr->GetShare($shareid);
		if ($share === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}


		$share->IsVisible = !$share->IsVisible;
		$share->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $share->IsVisible,
			'shareid' => $shareid,
		));
		exit;
	}

	private function _GetShareDelete()
	{
		$shareid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$share = $this->_sharemgr->GetShare($shareid);
		if ($share === null)
			return;

		$share->Remove();
		return;
	}

	private function _PostSaveShares()
	{
		global $CONFIG, $OBJECTS;

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $shareid => $ord)
		{
			$share = $this->_sharemgr->GetShare($shareid);
			if ($share === null)
				continue;

			$share->Ord = $ord;
			$share->Update();
		}
		return true;
	}

	 private function _GetShareNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
			$form['Title']     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN );
			$form['Text']      = App::$Request->Post['Text']->Value();
			$form['BGColor']   = App::$Request->Post['BGColor']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
			$form['Title']     = '';
			$form['BGColor']   = '';
			$form['Text']      = '';
			$form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/shares/edit_share', array(
			'form'       => $form,
			'action'     => 'new_share',
			'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostShare()
    {
        global $CONFIG, $OBJECTS;

		$shareid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$Title     = App::$Request->Post['Title']->Value();
		$Text      = App::$Request->Post['Text']->Value();
		$BGColor   = App::$Request->Post['BGColor']->Value();
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Title == "")
            UserError::AddErrorIndexed('Title', ERR_A_SHARE_EMPTY_TITLE);

        if ($Text == "")
            UserError::AddErrorIndexed('Title', ERR_A_SHARE_EMPTY_TEXT);


        if(UserError::IsError())
            return false;

        if($shareid > 0)
        {
            $share = $this->_sharemgr->GetShare($shareid);
            if ($share === null) {
                UserError::AddErrorIndexed('global', ERR_A_SHARE_NOT_FOUND);
                return false;
            }

			$share->Title     = $Title;
			$share->Text      = $Text;
			$share->IsVisible = $IsVisible;
			$share->BGColor   = $BGColor;
        }
        else
        {
            $Data = array(
				'Title'     => $Title,
				'BGColor'   => $BGColor,
				'Text'      => $Text,
				'IsVisible' => $IsVisible,
            );

            $share = new Share($Data);
        }

        $arr_photos = array(
            'Thumb' => array('Thumb'),
            'SmallThumb' => array('SmallThumb'),
        );

        foreach ($arr_photos as $key => $photos)
        {
            foreach ($photos as $photoName)
            {
                $del_file 	= App::$Request->Post[ 'del_'.$key ]->Enum(0, array(0,1));

                if ($del_file || is_file($_FILES[$key]['tmp_name']))
                    $share->$photoName = null;
                try
                {
                    $share->Upload($key, $photoName);
                }

                catch(MyException $e)
                {
                	var_dump($e); exit;
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key, ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $share->$photoName = null;
                    return false;
                }
            }
        }

        // ============================
        $share->Update();
        $this->_setMessage();

        return $share->ID;
    }

    private function _GetShareEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$shareid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$share = $this->_sharemgr->GetShare($shareid);
		if ($share === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_SHARE_NOT_FOUND);
			return STPL::Fetch('admin/modules/shares/edit_share');
		}

		$form['ShareID']    = $share->ID;
		$form['Thumb']      = $share->Thumb;
		$form['SmallThumb'] = $share->SmallThumb;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Title']     = App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN);
			$form['Text']      = App::$Request->Post['Text']->Value();
			$form['BGColor']   = App::$Request->Post['BGColor']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		}
		else
		{
			$form['IsVisible'] = $share->IsVisible;
			$form['Title']     = $share->Title;
			$form['BGColor']   = $share->BGColor;
			$form['Text']      = $share->Text;
		}

		return STPL::Fetch('admin/modules/shares/edit_share', array(
			'form' 			=> $form,
			'action' 		=> 'edit_share',
			'section_id'	=> $this->_id,
		));
	}

}