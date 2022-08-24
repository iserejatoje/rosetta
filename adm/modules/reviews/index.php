<?php

$error_code = 0;
define('ERR_A_REVIEWS_MASK', 0x00590000);
define('ERR_A_REVIEWS_UNKNOWN_ERROR', ERR_A_REVIEWS_MASK | $error_code++);
UserError::$Errors[ERR_A_REVIEWS_UNKNOWN_ERROR] = 'Незвестная ошибка.';


class AdminModule
{
	static $TITLE = 'Отзывы';

	static $ROW_ON_PAGE = 20;
	static $PAGE_ON_PAGE = 10;

	private $_db;

	private $_config;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	function __construct($config, $aconfig, $id) {
		global $OBJECTS;

		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		LibFactory::GetMStatic('reviews', 'reviewmgr');
		$this->reviewmgr = ReviewMgr::GetInstance();

		LibFactory::GetStatic('data');

		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

		App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');

		session_start();
	}
	// обязательные функции
	function Action() {

		if( $this->_Post_Action() )
			return;
		$this->_Get_Action();
	}

	function GetPage()
	{
		switch($this->_page)
		{
			case 'hided_list':
				$html = $this->GetReviewsList(0);
				break;
			case 'visible_list':
				$html = $this->GetReviewsList(1);
				break;
			case 'toggle_visible':
				$this->GetToggleVisible();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL']);
				break;
			default:
				$this->_title = "Список отзывов для модерации";
				$html = $this->GetReviewsList(0);
				break;
		}
		return $html;
	}

	function GetTabs() {
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'hided_list', 'text' => 'Список отзывов для модерации'),
				array('name' => 'action', 'value' => 'visible_list', 'text' => 'Список видимых отзывов'),
				),
			'selected' => $this->_page);
	}

	function GetTitle() {
		return $this->_title;
	}

	// обработка запросов
	private function _Post_Action()
	{
		global $DCONFIG;
		

		$_POST['visible'] == '1'?	$redirect = 'visible_list' : $redirect = 'hided_list';
		

		switch($_POST['action'])
		{


			case 'save':
				$this->PostSaveReviews();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action='.$redirect);
				break;
			case 'hide':
				$this->PostHideReviews();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action='.$redirect);
				break;
			case 'visible':
				$this->PostVisibleReviews();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action='.$redirect);
				break;
			case 'delete':
				$this->PostDeleteReviews();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action='.$redirect);
				break;
		}
	}

	private function _Get_Action()
	{
		global $DCONFIG;

		switch($_GET['action']) {
			case 'hided_list':
				$this->_page = 'hided_list';
				break;
			case 'visible_list':
				$this->_page = 'visible_list';
				break;
			case 'toggle_visible':
				$this->_page = 'toggle_visible';
				break;
			default:
				$this->_page = 'hided_list';
				break;
		}
	}

	private function GetReviewsList($visible)
	{
		global $DCONFIG;

		$page	= App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);

		if(isset(App::$Request->Get['visible'])) {
			$visible = App::$Request->Get['visible']->Int(0, Request::UNSIGNED_NUM);
		}

		
		$field	 = App::$Request->Get['field']->Enum('Created', ['Created', 'Username', 'Text', 'AnswerText']);
		$dir	 = App::$Request->Get['dir']->Enum('DESC', ['ASC', 'DESC']);


		$visible == 0? $action = 'hided_list': $action = 'visible_list'; 

		$filter = array(
			'flags' => array(
				'IsVisible' => $visible,
				'objects'   => true,
				// 'SectionID' => $this->_id,
			),
			'field' => [$field],
			'dir' => [$dir],
			'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
			'limit' => self::$ROW_ON_PAGE,
			'calc'	=> true,
			'dbg' => 0,
			'action' => $action,
		);

		list($reviews, $count) = $this->reviewmgr->GetReviews($filter);

		$pages = Data::GetNavigationPagesNumber(
			self::$ROW_ON_PAGE, self::$PAGE_ON_PAGE, $count, $page,
			"?{$DCONFIG['SECTION_ID_URL']}&action=".$this->_page."&page=@p@");

		// $DCONFIG['tpl']->assign('list', $reviews);
		// $DCONFIG['tpl']->assign('pages', $pages);

		if($visible)
			$action = "visible_list";
		else
			$action = "hided_list";

		return STPL::Fetch('admin/modules/reviews/list', array(
			'list' => $reviews,
			'pages' => $pages,
			'section_id' => $this->_id,
			'action' => $action,
			'visible' => $visible,
			'sorting' => [
				'field' => $field,
				'dir'	=> $dir,
			],
		));
	}

	private function GetToggleVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$review = $this->reviewmgr->GetReview($id);
		if ($review === null)
			return false;

		$review->IsVisible = !$review->IsVisible;
		$review->Update();


		$json->send(array(
			'status' => 'ok',
			'visible' => $review->IsVisible,
			'reviewid' => $id,
		));
		exit;
	}

	private function PostSaveReviews()
	{

		
		if(is_array($_POST['ids_action']) && count($_POST['ids_action']) > 0)
		{

			foreach ($_POST['ids_action'] as $id)
			{
				$review = $this->reviewmgr->GetReview($id);
				if ($review === null)
					continue;


				$review->Username = App::$Request->Post['Username'][$id]->Value(Request::OUT_HTML_CLEAN);
				//$review->Title = App::$Request->Post['Title'][$id]->Value(Request::OUT_HTML_CLEAN);
				$review->Text = App::$Request->Post['Text'][$id]->Value();
				$review->AnswerText = App::$Request->Post['AnswerText'][$id]->Value();
				
				$review->Update();
			}
		}
	}

	private function PostHideReviews()
	{
		if(is_array($_POST['ids_action']) && count($_POST['ids_action']) > 0)
		{
			foreach ($_POST['ids_action'] as $id)
			{
				$review = $this->reviewmgr->GetReview($id);
				if ($review === null)
					continue;

				$review->IsVisible = false;

				$review->Update();
			}
		}
	}

	private function PostVisibleReviews()
	{
		if(is_array($_POST['ids_action']) && count($_POST['ids_action']) > 0)
		{
			foreach ($_POST['ids_action'] as $id)
			{
				$review = $this->reviewmgr->GetReview($id);
				if ($review === null)
					continue;

				$review->IsVisible = true;


				$review->Update();
			}
		}
	}

	private function PostDeleteReviews()
	{
		if(is_array($_POST['ids_action']) && count($_POST['ids_action']) > 0)
		{
			foreach ($_POST['ids_action'] as $id)
			{
				$review = $this->reviewmgr->GetReview($id);
				if ($review === null)
					continue;

				$review->Remove();
			}
		}
	}
}

