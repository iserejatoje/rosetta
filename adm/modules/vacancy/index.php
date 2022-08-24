<?php

ini_set('max_execution_time', '60');

$catalog_error_code = 0;
define('ERR_A_VACANCY_MASK', 0x01640000);

define('ERR_A_VACANCY_EMPTY_POSITION', ERR_A_VACANCY_MASK | $error_code++);
UserError::$Errors[ERR_A_VACANCY_EMPTY_POSITION] = 'Не указана должность';

define('ERR_A_VACANCY_EMPTY_TEXT', ERR_A_VACANCY_MASK | $error_code++);
UserError::$Errors[ERR_A_VACANCY_EMPTY_TEXT] = 'Не заполнено описание вакансии';

define('ERR_A_VACANCY_NOT_FOUND', ERR_A_VACANCY_MASK | $error_code++);
UserError::$Errors[ERR_A_VACANCY_NOT_FOUND] = 'Вакансия не найдена';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_VACANCY_MASK | $error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
	static $TITLE = 'Вакансии';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $_vacancymgr;

	function __construct($config, $aconfig, $id)
	{
		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('vacancy', 'vacancymgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=vacancies');

		$this->_vacancymgr = VacancyMgr::getInstance(false);

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
			case 'new_vacancy':
				$this->_title = "Добавить вакансию";
				$html = $this->_GetVacancyNew();
				break;
			case 'edit_vacancy':
				$this->_title = "Редактировать вакансию";
				$html = $this->_GetVacancyEdit();
				break;
			case 'delete_vacancy':
				$this->_GetVacancyDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=vacancies');
				break;
			case 'vacancies':
				$this->_title = "Список вакансии";
				$html = $this->_GetVacancies();
				break;
			case 'ajax_vacancy_toggle_visible':
				$this->_GetAjaxToggleVacancyVisible();
				break;
			default:
				$this->_title = "Список вакансий";
				$html = $this->_GetVacancies();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'vacancies', 'text' => 'Вакансии'),
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
			case 'new_vacancy':
                if (($pid = $this->_PostVacancy()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_vacancy&id='.$pid);
                break;
            case 'edit_vacancy':
				if (($pid = $this->_PostVacancy()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_vacancy&id='.$pid);
				break;
			case 'save_vacancies':
				if($this->_PostSaveVacancies())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=vacancies');
		}
		return false;
	}

	private function _GetVacancies()
	{
		global $DCONFIG, $CONFIG;

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
			),
			'field' => array('Ord'),
			'dir' => array('ASC'),
			'dbg' => 1,
		);

		$list = $this->_vacancymgr->GetVacancies($filter);

		return STPL::Fetch('admin/modules/vacancies/vacancies_list', array(
			'list'    => $list,
			'section_id' => $this->_id,
		));
	}



	private function _GetAjaxToggleVacancyVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$vacancyid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$vacancy = $this->_vacancymgr->GetVacancy($vacancyid);
		if ($vacancy === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}


		$vacancy->IsVisible = !$vacancy->IsVisible;
		$vacancy->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $vacancy->IsVisible,
			'vacancyid' => $vacancyid,
		));
		exit;
	}

	private function _GetVacancyDelete()
	{
		$vacancyid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$vacancy = $this->_vacancymgr->GetVacancy($vacancyid);
		if ($vacancy === null)
			return;

		$vacancy->Remove();
		return;
	}

	private function _PostSaveVacancies()
	{
		global $CONFIG, $OBJECTS;

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $vacancyid => $ord)
		{
			$vacancy = $this->_vacancymgr->GetVacancy($vacancyid);
			if ($vacancy === null)
				continue;

			$vacancy->Ord = $ord;
			$vacancy->Update();
		}
		return true;
	}

	 private function _GetVacancyNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
			$form['Position']  = App::$Request->Post['Position']->Value(Request::OUT_HTML_CLEAN );
			$form['Text']      = App::$Request->Post['Text']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
			$form['Position']  = '';
			$form['Text']      = '';
			$form['IsVisible'] = 0;
        }

        return STPL::Fetch('admin/modules/vacancies/edit_vacancy', array(
			'form'       => $form,
			'action'     => 'new_vacancy',
			'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostVacancy()
    {
        global $CONFIG, $OBJECTS;

		$vacancyid = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$Position  = App::$Request->Post['Position']->Value(Request::OUT_HTML_CLEAN );
		$Text      = App::$Request->Post['Text']->Value();
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($Position == "")
            UserError::AddErrorIndexed('Position', ERR_A_VACANCY_EMPTY_POSITION);

        if ($Text == "")
            UserError::AddErrorIndexed('Title', ERR_A_VACANCY_EMPTY_TEXT);

        if(UserError::IsError())
            return false;

        if($vacancyid > 0)
        {
            $vacancy = $this->_vacancymgr->GetVacancy($vacancyid);
            if ($vacancy === null) {
                UserError::AddErrorIndexed('global', ERR_A_VACANCY_NOT_FOUND);
                return false;
            }

			$vacancy->Position  = $Position;
			$vacancy->Text      = $Text;
			$vacancy->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
				'Position'  => $Position,
				'Text'      => $Text,
				'IsVisible' => $IsVisible,
            );

            $vacancy = new Vacancy($Data);
        }

        // ============================
        $vacancy->Update();
        $this->_setMessage();

        return $vacancy->ID;
    }

    private function _GetVacancyEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$vacancyid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$vacancy = $this->_vacancymgr->GetVacancy($vacancyid);
		if ($vacancy === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_VACANCY_NOT_FOUND);
			return STPL::Fetch('admin/modules/vacancy/edit_vacancy');
		}

		$form['VacancyID']  = $vacancy->ID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Position']  = App::$Request->Post['Position']->Value(Request::OUT_HTML_CLEAN);
			$form['Text']      = App::$Request->Post['Text']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		}
		else
		{
			$form['IsVisible'] = $vacancy->IsVisible;
			$form['Position']  = $vacancy->Position;
			$form['Text']      = $vacancy->Text;
		}

		return STPL::Fetch('admin/modules/vacancies/edit_vacancy', array(
			'form'       => $form,
			'action'     => 'edit_vacancy',
			'section_id' => $this->_id,
		));
	}

}