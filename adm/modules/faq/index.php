<?php

ini_set('max_execution_time', '60');

$faq_error_code = 0;
define('ERR_A_FAQ_MASK', 0x01640000);

define('ERR_A_FAQ_QUESTION_NOT_FOUND', ERR_A_FAQ_MASK | $faq_error_code++);
UserError::$Errors[ERR_A_FAQ_QUESTION_NOT_FOUND] = 'Вопрос не найден';

define('ERR_A_FAQ_EMPTY_QUESTION', ERR_A_FAQ_MASK | $faq_error_code++);
UserError::$Errors[ERR_A_FAQ_EMPTY_QUESTION] = 'Необходим ввести текст вопроса';

define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_FAQ_MASK | $faq_error_code++);
UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

class AdminModule
{
	static $TITLE = 'Вопрос-ответ';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $faqmgr;

	function __construct($config, $aconfig, $id)
	{
		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('faq', 'faqmgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=questions');

		$this->faqmgr = FaqMgr::getInstance(false);

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
			case 'new_question':
				$this->_title = "Добавить вопрос";
				$html = $this->_GetQuestionNew();
				break;
			case 'edit_question':
				$this->_title = "Редактировать вопрос";
				$html = $this->_GetQuestionEdit();
				break;
			case 'delete_question':
				$this->_GetQuestionDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=questions');
				break;
			case 'questions':
				$this->_title = "Список вопросов";
				$html = $this->_GetQuestions();
				break;
			case 'ajax_question_toggle_visible':
				$this->_GetAjaxToggleQuestionVisible();
				break;
			case 'ajax_question_toggle_answered':
				$this->_GetAjaxToggleQuestionAnswered();
				break;
			default:
				$this->_title = "Список вопрос";
				$html = $this->_GetQuestion();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'questions', 'text' => 'Вопросы'),
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
			case 'new_question':
                if (($pid = $this->_PostQuestion()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_question&id='.$pid);
                break;
            case 'edit_question':
				if (($pid = $this->_PostQuestion()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_question&id='.$pid);
				break;
			case 'save_questions':
				if($this->_PostSaveQuestion())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=questions');
		}
		return false;
	}

	private function _GetQuestions()
	{
		global $DCONFIG, $CONFIG;

        $field  = App::$Request->Get['field']->Enum('question', ['question', 'isvisible', 'ord', 'isanswered', 'Created']);
        $dir = App::$Request->Get['dir']->Enum('asc', ['asc', 'desc']);

        $isanswered = App::$Request->Get['isanswered']->Int(-1, Request::UNSIGNED_NUM);

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
				'IsAnswered' => $isanswered,
			),
			'field' => [$field],
            'dir' => [$dir],
			'dbg' => 0,
		);

		$list = $this->faqmgr->GetQuestions($filter);

		return STPL::Fetch('admin/modules/faq/question_list', array(
			'list'    => $list,
			'section_id' => $this->_id,
            'sorting' => [
                'field' => $field,
                'dir' => $dir,
            ],
            'field' => $field, 
            'dir' => $dir,
            'isanswered' => $isanswered,
		));
	}



	private function _GetAjaxToggleQuestionVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$questionid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$question = $this->faqmgr->GetQuestion($questionid);
		if ($question === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$question->IsVisible = !$question->IsVisible;
		$question->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $question->IsVisible,
			'questionid' => $questionid,
		));
		exit;
	}

	private function _GetAjaxToggleQuestionAnswered()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$questionid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$question = $this->faqmgr->GetQuestion($questionid);
		if ($question === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$question->IsAnswered = !$question->IsAnswered;
		$question->Update();

		$json->send(array(
			'status' => 'ok',
			'answered' => (int) $question->IsAnswered,
			'questionid' => $questionid,
		));
		exit;
	}

	private function _GetQuestionDelete()
	{
		$questionid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$question = $this->faqmgr->GetQuestion($questionid);
		if ($question === null)
			return;

		$question->Remove();
		return;
	}

	private function _PostSaveQuestion()
	{
		global $CONFIG, $OBJECTS;

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $questionid => $ord)
		{
			$question = $this->faqmgr->GetQuestion($questionid);
			if ($question === null)
				continue;

			$question->Ord = $ord;
			$question->Update();
		}
		return true;
	}

	 private function _GetQuestionNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
			$form['Question']  = App::$Request->Post['Question']->Value();
			$form['Answer']    = App::$Request->Post['Question']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
        }
        else
        {
			$form['Question']  = '';
			$form['Answer']    = '';
			$form['IsVisible'] = 0;
        }

        $form['Email']     = $question->Email;
		$form['Phone']     = $question->Phone;
		$form['Username']  = $question->Username;

        return STPL::Fetch('admin/modules/faq/edit_question', array(
			'form'       => $form,
			'action'     => 'new_question',
			'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostQuestion()
    {
        global $CONFIG, $OBJECTS;

		$questionid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$QuestionText = App::$Request->Post['Question']->Value(Request::OUT_HTML_CLEAN );
		$Answer       = App::$Request->Post['Answer']->Value();
		$IsVisible    = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

        if ($QuestionText == "")
            UserError::AddErrorIndexed('QuestionText', ERR_A_FAQ_EMPTY_QUESTION);

        if(UserError::IsError())
            return false;

        if($questionid > 0)
        {
            $question = $this->faqmgr->GetQuestion($questionid);
            if ($question === null) {
                UserError::AddErrorIndexed('global', ERR_A_FAQ_QUESTION_NOT_FOUND);
                return false;
            }

			$question->Question  = $QuestionText;
			$question->Answer    = $Answer;
			$question->IsVisible = $IsVisible;
        }
        else
        {
            $Data = array(
				'Question'  => $QuestionText,
				'Answer'    => $Answer,
				'IsVisible' => $IsVisible,
            );

            $question = new Question($Data);
        }

        // ============================
        $question->Update();
        $this->_setMessage();

        return $question->ID;
    }

    private function _GetQuestionEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$questionid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$question = $this->faqmgr->GetQuestion($questionid);
		if ($question === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_FAQ_QUESTION_NOT_FOUND);
			return STPL::Fetch('admin/modules/faq/edit_question');
		}

		$form['QuestionID']  = $question->ID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Question']  = App::$Request->Post['Question']->Value();
			$form['Answer']      = App::$Request->Post['Answer']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));

			$form['Email']     = '';
			$form['Phone']     = '';
			$form['Username']  = '';
		}
		else
		{
			$form['IsVisible'] = $question->IsVisible;
			$form['Question']  = $question->Question;
			$form['Answer']    = $question->Answer;
			$form['Email']     = $question->Email;
			$form['Phone']     = $question->Phone;
			$form['Username']  = $question->Username;
		}

		return STPL::Fetch('admin/modules/faq/edit_question', array(
			'form'       => $form,
			'action'     => 'edit_question',
			'section_id' => $this->_id,
		));
	}

}