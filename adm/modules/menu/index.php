<?php

ini_set('max_execution_time', '60');

$menu_error_code = 0;
define('ERR_A_MENU_MASK', 0x01600000);

define('ERR_A_MENU_EMPTY_NAME', ERR_A_MENU_MASK | $error_code++);
UserError::$Errors[ERR_A_MENU_EMPTY_NAME] = 'Не указано название пункта меню';

define('ERR_A_MENU_EMPTY_LINK', ERR_A_MENU_MASK | $error_code++);
UserError::$Errors[ERR_A_MENU_EMPTY_LINK] = 'Не указана ссылка для пункта меню';

define('ERR_A_MENU_NOT_FOUND', ERR_A_MENU_MASK | $error_code++);
UserError::$Errors[ERR_A_MENU_NOT_FOUND] = 'Меню не найдено';

class AdminModule
{
	static $TITLE = 'Меню';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $menuMgr;

	function __construct($config, $aconfig, $id)
	{

		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('menu', 'menumgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=menu');

		$this->menuMgr = MenuMgr::getInstance(false);

		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery-ui-1.8.23.min.js');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.datepicker-ru.js');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.timepicker.js');
		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/css/ui-lightness/jquery-ui-1.8.23.custom.css');
		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui-1.8.23/jquery.ui.timepicker.css');
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
			case 'menu':
				$this->_title = "Меню";
				$html = $this->_GetMenu();
				break;

			case 'new_menu':
				$this->_title = "Добавить пункт меню";
				$html = $this->_GetMenuNew();
				break;
			case 'edit_menu':
				$this->_title = "Редактировать пункт меню";
				$html = $this->_GetMenuEdit();
				break;


			case 'ajax_menu_toggle_visible':
				$this->_GetAjaxToggleMenuVisible();
				break;
			case 'delete_menu':
				$this->_GetMenuDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=menu');
				break;
			default:
				$this->_title = "Меню";
				$html = $this->_GetMenu();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'menu', 'text' => 'Меню'),
			),
			'selected' => $this->_page
		);
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

		switch($_POST['action'])
		{
			case 'new_menu':
				if ($this->_PostMenu())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=menu&parent_id='.$_POST['parent_id']);
				break;
			case 'edit_menu':
				if ($this->_PostMenu())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=menu&parent_id='.$_POST['parent_id']);
				break;
			case 'save_menu_items':
				if ($this->_PostMenuItemsSave())
						Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=menu&parent_id='.$_POST['parent_id']);
				break;
		}
		return false;
	}

	private function _GetMenu()
	{
		global $DCONFIG, $CONFIG;

		$page = App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);
		$parent_id = App::$Request->Get['parent_id']->Int(0, Request::UNSIGNED_NUM);
		$IsVisible	= App::$Request->Get['isvisible']->Enum(-1, array(-1,0,1), Request::UNSIGNED_NUM);

		$menu = $this->menuMgr->GetVisibleMenuBySectionID($this->_id, $parent_id, $IsVisible);

		return STPL::Fetch('admin/modules/menu/menu_list', array(
			'menu' => $menu,
			'isvisible' => $IsVisible,
			'section_id' => $this->_id,
			'parent_id' => $parent_id,
		));
	}

	private function _GetMenuNew() 
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$form = array();

		$form['ParentID'] 	= App::$Request->Get['parent_id']->Int(0, Request::UNSIGNED_NUM);

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name']			= App::$Request->Post['Name']->Value();
			$form['Link']			= App::$Request->Post['Link']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['GroupID']		= App::$Request->Post['GroupID']->Enum(0, array_keys(MenuMgr::$GROUPS));
		}
		else
		{
			$form['Name']			= '';
			$form['Link']			= '';
			$form['IsVisible']		= 0;
			$form['GroupID']		= 0;
		}

		return STPL::Fetch('admin/modules/menu/edit_menu', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'new_menu',
		));
	}

	private function _GetMenuEdit() 
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$MenuID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$menu = $this->menuMgr->GetMenu($MenuID);

		if ($menu === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_MENU_NOT_FOUND);
			return STPL::Fetch('admin/modules/menu/edit_menu');
		}

		$form['MenuID']		= $menu->ID;
		$form['ParentID'] 	= $menu->ParentID;
		

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name']			= App::$Request->Post['Name']->Value();
			$form['Link']			= App::$Request->Post['Link']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['GroupID']		= App::$Request->Post['GroupID']->Enum(0, array_keys(MenuMgr::$GROUPS));
		}
		else
		{
			$form['Name']			= $menu->Name;
			$form['Link']			= $menu->Link;
			$form['IsVisible']		= $menu->IsVisible;
			$form['GroupID']		= $menu->GroupID;
		}

		return STPL::Fetch('admin/modules/menu/edit_menu', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'edit_menu',
		));
	}

	private function _GetAjaxToggleMenuVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$MenuID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$menu = $this->menuMgr->GetMenu($MenuID);

		if ($menu === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$menu->IsVisible = !$menu->IsVisible;
		$menu->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $menu->IsVisible,
			'menuid' => $MenuID,
		));
		exit;
	}

	private function _GetMenuDelete()
	{
		$MenuID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$menu = $this->menuMgr->GetMenu($MenuID);
		if ($menu === null)
			return;

		$menu->Remove();
		return;
	}

	private function _PostMenuItemsSave()
	{
		global $CONFIG, $OBJECTS;

		$SectionID = App::$Request->Post['section_id']->Int(0, Request::UNSIGNED_NUM);
		$ParentID      = App::$Request->Post['parent_id']->Int(0, Request::UNSIGNED_NUM);

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $menuid => $ord)
		{
			$menu = $this->menuMgr->GetMenu($menuid);
			if ($menu === null)
				continue;

			$menu->Ord = $ord;
			$menu->Update();
		}
		return true;
	}

	private function _PostMenu()
	{
		global $CONFIG, $OBJECTS;

		$MenuID		= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$ParentID	= App::$Request->Post['parent_id']->Int(0, Request::UNSIGNED_NUM);
		$Name      	= App::$Request->Post['Name']->Value();
		$Link      	= App::$Request->Post['Link']->Value();
		$IsVisible 	= App::$Request->Post['IsVisible']->Enum(0, array(0,1)); 
		$GroupID	= App::$Request->Post['GroupID']->Enum(0, array_keys(MenuMgr::$GROUPS));

		if ($Name == "")
			UserError::AddErrorIndexed('Name', ERR_A_MENU_EMPTY_TITLE);

		if ($Link == "")
			UserError::AddErrorIndexed('Text', ERR_A_MENU_EMPTY_LINK);

		if(UserError::IsError())
			return false;

		if($MenuID > 0)
		{
			$menu = $this->menuMgr->GetMenu($MenuID);

			$menu->Name = $Name;
			$menu->Link = $Link;
			$menu->IsVisible = $IsVisible;
			$menu->GroupID = $GroupID;
		}
		else
		{
			$Data = array(
				'SectionID' => $this->_id,
				'Name'      => $Name,
				'Link'      => $Link,
				'IsVisible' => $IsVisible,
				'ParentID'  => $ParentID,
				'GroupID'   => $GroupID,
			);

			$menu = new Menu($Data);
		}
		$menu->Update();
		return true;
	}
}