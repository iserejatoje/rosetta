<?php

ini_set('max_execution_time', '60');
ini_set('display_errors', 'on');

$catalog_error_code = 0;
define('ERR_A_BLOCK_MASK', 0x01640000);

define('ERR_A_BLOCK_EMPTY_TEXT', ERR_A_BLOCK_MASK | $error_code++);
UserError::$Errors[ERR_A_BLOCK_EMPTY_TEXT] = 'Не указан текст блока';

define('ERR_A_BLOCK_NOT_FOUND', ERR_A_BLOCK_MASK | $error_code++);
UserError::$Errors[ERR_A_BLOCK_NOT_FOUND] = 'Блок не найден';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_BLOCK_MASK | $error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
	static $TITLE = 'Доставка';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $_deliverymgr;

	function __construct($config, $aconfig, $id)
	{
		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('delivery', 'deliverymgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=blocks');

		$this->_deliverymgr = DeliveryMgr::getInstance(false);

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
			// case 'new_block':
			// 	$this->_title = "Добавить блок";
			// 	$html = $this->_GetBlockNew();
			// 	break;
			case 'edit_block':
				$this->_title = "Редактировать блок";
				$html = $this->_GetBlockEdit();
				break;
			// case 'delete_block':
			// 	$this->_GetBlockDelete();
			// 	Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=blocks');
			// 	break;
			case 'blocks':
				$this->_title = "Список блоков";
				$html = $this->_GetBlocks();
				break;
			case 'ajax_block_toggle_visible':
				$this->_GetAjaxToggleBlockVisible();
				break;
			default:
				$this->_title = "Список блоков";
				$html = $this->_GetBlocks();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'blocks', 'text' => 'Блоки'),
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
			// case 'new_block':
   //              if (($pid = $this->_PostBlock()) > 0)
   //                  Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_block&id='.$pid);
   //              break;
            case 'edit_block':
				if (($pid = $this->_PostBlock()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_block&id='.$pid);
				break;
			case 'save_blocks':
				if($this->_PostSaveBlocks())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=blocks');
		}
		return false;
	}

	private function _GetBlocks()
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

		$blocks = $this->_deliverymgr->GetBlocks($filter);

		return STPL::Fetch('admin/modules/delivery/blocks_list', array(
			'blocks'    => $blocks,
			'section_id' => $this->_id,
		));
	}

	private function _GetAjaxToggleBlockVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$blockid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$block = $this->_deliverymgr->GetBlock($blockid);
		if ($block === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}


		$block->IsVisible = !$block->IsVisible;
		$block->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $block->IsVisible,
			'blockid' => $blockid,
		));
		exit;
	}

	private function _GetBlockDelete()
	{
		$blockid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$block = $this->_deliverymgr->GetBlock($blockid);
		if ($block === null)
			return;

		$block->Remove();
		return;
	}

	private function _PostSaveBlocks()
	{
		global $CONFIG, $OBJECTS;

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $blockid => $ord)
		{
			$block = $this->_deliverymgr->GetBlock($blockid);
			if ($block === null)
				continue;

			$block->Ord = $ord;
			$block->Update();
		}
		return true;
	}

	 // private function _GetBlockNew()
  //   {
  //       global $DCONFIG, $CONFIG, $OBJECTS;

  //       $form = array();

  //       if ( App::$Request->requestMethod === Request::M_POST )
  //       {
		// 	$form['Text']      = App::$Request->Post['Text']->Value();
		// 	$form['MoreText']  = App::$Request->Post['MoreText']->Value();
		// 	$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
  //       }
  //       else
  //       {
		// 	$form['Title']     = '';
		// 	$form['MoreText']  = '';
		// 	$form['IsVisible'] = 0;
  //       }

  //       return STPL::Fetch('admin/modules/delivery/edit_block', array(
		// 	'form'       => $form,
		// 	'action'     => 'new_block',
		// 	'section_id' => $this->_id,
  //       ));
  //   }

     /**
     * @return array|bool|null
     */
    private function _PostBlock()
    {
        global $CONFIG, $OBJECTS;

		$blockid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$Text      = App::$Request->Post['Text']->Value();
		$MoreText  = App::$Request->Post['MoreText']->Value();
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Text == "")
            UserError::AddErrorIndexed('Title', ERR_A_BLOCK_EMPTY_TEXT);

        if(UserError::IsError())
            return false;

        if($blockid > 0)
        {
            $block = $this->_deliverymgr->GetBlock($blockid);
            if ($block === null) {
                UserError::AddErrorIndexed('global', ERR_A_BLOCK_NOT_FOUND);
                return false;
            }

			$block->Text      = $Text;
			$block->MoreText  = $MoreText;
			$block->IsVisible = $IsVisible;

        }
        else
        {
            $Data = array(
				'Text'      => $Text,
				'MoreText'  => $MoreText,
				'IsVisible' => $IsVisible,
            );

            $block = new Block($Data);
        }

        // ============================
        $block->Update();
        $this->_setMessage();

        return $block->ID;
    }

    private function _GetBlockEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$blockid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$block = $this->_deliverymgr->GetBlock($blockid);
		if ($block === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_BLOCK_NOT_FOUND);
			return STPL::Fetch('admin/modules/delivery/edit_block');
		}

		$form['BlockID']    = $block->ID;
		$form['ClassID']    = $block->ClassID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Text']      = App::$Request->Post['Text']->Value();
			$form['MoreText']  = App::$Request->Post['MoreText']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		}
		else
		{
			$form['IsVisible'] = $block->IsVisible;
			$form['MoreText']  = $block->MoreText;
			$form['Text']      = $block->Text;
		}

		return STPL::Fetch('admin/modules/delivery/edit_block', array(
			'form' 			=> $form,
			'action' 		=> 'edit_block',
			'section_id'	=> $this->_id,
		));
	}

}