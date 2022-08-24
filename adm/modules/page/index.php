<?php

$error_code = 0;
define('ERR_A_PAGE_MASK', 0x00590000);
define('ERR_A_PAGE_UNKNOWN_ERROR', ERR_A_PAGE_MASK | $error_code++);
UserError::$Errors[ERR_A_PAGE_UNKNOWN_ERROR] = 'Незвестная ошибка.';

define('ERR_A_PAGE_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
UserError::$Errors[ERR_A_PAGE_NOT_FOUND] = 'Страница не найдена.';

define('ERR_A_PAGE_ANNOUNCETEXT_EXCEED', ERR_A_PAGE_MASK | $error_code++);
UserError::$Errors[ERR_A_PAGE_ANNOUNCETEXT_EXCEED] = 'Максимальная длина анонса 500 символов.';

define('ERR_A_PAGE_NAME_EXCEED', ERR_A_PAGE_MASK | $error_code++);
UserError::$Errors[ERR_A_PAGE_NAME_EXCEED] = 'Максимальная длина Названия 200 символов.';

define('ERR_A_PAGE_NAME_EMPTY', ERR_A_PAGE_MASK | $error_code++);
UserError::$Errors[ERR_A_PAGE_NAME_EMPTY] = 'Название не может быть пустым.';


class AdminModule
{
	static $TITLE = 'Текстовая страница';

	private $_db;
	
	private $_config;
	
	private $_page;
	private $_id;
	private $_title;
	private $pagemgr;
	

	function __construct($config, $aconfig, $id) {
		global $OBJECTS;

		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}
		
		$this->_aconfig = &$aconfig;
		$this->_db = DBFactory::GetInstance($this->_config['db']);
				
		LibFactory::GetMStatic('page', 'pagemgr');
		$this->pagemgr = PageMgr::GetInstance();

		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('data');
	}
	
	
	
	// обязательные функции
	function Action() 
	{
		
		if( $this->_Post_Action() )
			return;
		
		$this->_Get_Action();
	}

	function GetPage()
	{
		switch($this->_page)
		{
			case 'create_page':
				$this->_title = "Страница";
				$html = $this->_GetEditPage();
				break;
			case 'update_page':
				$this->_title = "Страница";
				$html = $this->_GetEditPage();
				break;
			default:
				$this->_title = "Страница";
				$html = $this->_GetEditPage();
				break;
		}
		return $html;
	}
	
	function GetTabs() {
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'create_page', 'text' => 'Статья'),				
				),
			'selected' => $this->_page);
	}

	function GetTitle() {
		return $this->_title;
	}

	// обработка запросов
	private function _Post_Action() {
		global $DCONFIG;

		switch($_POST['action']) {
			
			case 'create_page':
				if ($this->_PostCreatePage() === true)
					Response::Redirect("?{$DCONFIG['SECTION_ID_URL']}&action=update_page");
				break;
			case 'update_page':
				if ($this->_PostUpdatePage() === true)
					Response::Redirect("?{$DCONFIG['SECTION_ID_URL']}");
				break;
		}
		
		return false;
	}

	private function _Get_Action() {
		global $DCONFIG;
		
		switch($_GET['action']) {
			case 'create_page':
				$this->_page = 'create_page';
				break;
			case 'update_page':
				$this->_page = 'update_page';
				break;				
			default:
				$this->_page = 'create_page';
				break;
		}
	}

	// Редактировать новость
	private function _GetEditPage()
	{
		global $CONFIG, $DCONFIG;
		
		$page = $this->pagemgr->GetPageBySectionID($this->_id);
		if ($page === null)
		{
			$form['action'] = 'create_page';
			$form['Name'] = '';
			$form['IsVisible'] = 1;
			$form['Text'] = '';
			$form['AnnounceText'] = '';			
			
			$DCONFIG['tpl']->assign('action', 'new_page');
		}
		else
		{
			$form['action'] = 'update_page';
			$form['Name'] = $page->Name;
			$form['IsVisible'] = (int) $page->IsVisible;
			$form['Text'] = $page->Text;
			$form['AnnounceText'] = $page->AnnounceText;
			
			$DCONFIG['tpl']->assign('action', 'edit_page');
		}
		
		if ( App::$Request->requestMethod === Request::M_POST ) 
		{
			$form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['Text'] = App::$Request->Post['Text']->Value();
			$form['AnnounceText'] = App::$Request->Post['AnnounceText']->Value();
		}
		
		$DCONFIG['tpl']->assign('form', $form);
		return $DCONFIG['tpl']->fetch('page/edit.tpl');
	}

	// Создать новость
	private function _PostCreatePage()
	{	
		$Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$Text = App::$Request->Post['Text']->Value();
		$AnnounceText = App::$Request->Post['AnnounceText']->Value();
		
		if (strlen($Name) == 0)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);
		
		if (strlen($Name) > 200)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);
		
		if (strlen($AnnounceText) > 500)
			UserError::AddErrorIndexed('AnnounceText', ERR_A_PAGE_ANNOUNCETEXT_EXCEED);
		
		if (UserError::IsError())
			return false;
		
		$data = array(
			'SectionID'		=> $this->_id,
			'Name'			=> $Name,
			'IsVisible'		=> $IsVisible,
			'AnnounceText'	=> $AnnounceText,
			'Text'			=> $Text,
		);
		
		$page = new Page($data);
		$page->Update();
		
		return true;
	}

	// Обновить новость
	private function _PostUpdatePage()
	{
		$Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$Text = App::$Request->Post['Text']->Value();
		$AnnounceText = App::$Request->Post['AnnounceText']->Value();
		
		$page = $this->pagemgr->GetPageBySectionID($this->_id);
		if ($page === null)
			UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);
			
		if (UserError::IsError())
			return false;
		
		if (strlen($Name) == 0)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);
		
		if (strlen($Name) > 200)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);
		
		if (strlen($AnnounceText) > 500)
			UserError::AddErrorIndexed('AnnounceText', ERR_A_PAGE_ANNOUNCETEXT_EXCEED);
		
		if (UserError::IsError())
			return false;
			
		$page->Name = $Name;
		$page->IsVisible = $IsVisible;
		$page->AnnounceText = $AnnounceText;
		$page->Text = $Text;
		
		$page->Update();
		
		return true;
	}
}
