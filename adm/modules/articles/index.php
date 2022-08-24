<?php

ini_set('max_execution_time', '60');

$articles_error_code = 0;
define('ERR_A_ARTICLES_MASK', 0x00580000);

define('ERR_A_ARTICLES_EMPTY_SHORTTITLE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_ARTICLES_EMPTY_SHORTTITLE] = 'Не указан краткий заголовок страницы';

define('ERR_A_ARTICLES_EMPTY_TITLE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_ARTICLES_EMPTY_TITLE] = 'Не указан заголовок страницы';

define('ERR_A_ARTICLES_EMPTY_ANNOUNCE_TEXT', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_ARTICLES_EMPTY_ANNOUNCE_TEXT] = 'Не указан краткий анонс страницы';

define('ERR_A_ARTICLES_EMPTY_TEXT', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_ARTICLES_EMPTY_TEXT] = 'Не указан текст страницы';

define('ERR_A_ARTICLES_NOT_FOUND', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_ARTICLES_NOT_FOUND] = 'Страница не найдена';

class AdminModule
{
	static $TITLE = 'Страницы';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $articleMgr;

	function __construct($config, $aconfig, $id)
	{

		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('tree_articles', 'articlemgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');

		$this->articleMgr = ArticleMgr::getInstance(false);

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
			case 'articles':
				$this->_title = "Список страниц";
				$html = $this->_GetArticles();
				break;
			case 'new_article':
				$this->_title = "Добавить страницу";
				$html = $this->_GetArticleNew();
				break;
			case 'edit_article':
				$this->_title = "Редактировать страницу";
				$html = $this->_GetArticleEdit();
				break;
			case 'ajax_article_toggle_visible':
				$this->_GetAjaxToggleArticleVisible();
				break;
			case 'ajax_article_toggle_main':
				$this->_GetAjaxToggleArticleMain();
				break;
			case 'delete_article':
				$this->_GetArticleDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
				break;

			default:
				$this->_title = "Страницы";
				$html = $this->_GetArticles();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'articles', 'text' => 'Страницы'),
			),
			'selected' => $this->_page
		);
	}

	function GetTitle()
	{
		return $this->_title;
	}

	private function _PostAction()
	{
		global $DCONFIG, $OBJECTS;

		switch($_POST['action'])
		{
			case 'new_article':
				if ($this->_PostArticleNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
				break;
			case 'edit_article':
				if ($this->_PostArticleEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
				break;
		}
		return false;
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

	private function _GetArticles()
	{
		global $DCONFIG, $CONFIG;

		$page		= App::$Request->Get['page']->Int(0, Request::UNSIGNED_NUM);

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
				'SectionID' => $this->_id,
			),
			'field' => array(
				'Date',
			),
			'dir' => array(
				'DESC',
			),
			'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
			'limit' => self::$ROW_ON_PAGE,
			'calc'	=> true,
		);

		list($articles, $count) = $this->articleMgr->GetArticles($filter);

		$pages = Data::GetNavigationPagesNumber(
			self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
			"?section_id=". $this->_id ."&action=articles&page=@p@");

		return STPL::Fetch('admin/modules/articles/articles_list', array(
			'section_id' => $this->_id,
			'articles' => $articles,
			'pages' => $pages,
		));
	}


	private function _GetArticleNew() {

		global $DCONFIG, $CONFIG, $OBJECTS;

		// App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');
		// App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.js');
		// App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/smoothness/jquery-ui-1.8.14.custom.css');
		// App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.css');

		$form = array();

		$form['SectionID'] = $this->_id;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Date']			= App::$Request->Post['Date']->Datestamp();
			$form['Time']			= App::$Request->Post['Time']->Timestamp() + $form['Date'];
			$form['ShortTitle']		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['Title']			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['AnnounceText']	= App::$Request->Post['AnnounceText']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
			$form['Text']			= App::$Request->Post['Text']->Value();
			$form['SourceLink']		= App::$Request->Post['SourceLink']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsComments']		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
			$form['IsRSS']			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
			$form['IsMain']			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
			$form['IsImportant']	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
			$form['SeoTitle'] 		= App::$Request->Post['SeoTitle']->Value();
			$form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
			$form['SeoKeywords'] 	= App::$Request->Post['SeoKeywords']->Value();
		}
		else
		{
			$form['Date'] 			= time();
			$form['Time'] 			= $form['Date'];
			$form['ShortTitle']		= '';
			$form['Title']			= '';
			$form['AnnounceText']	= '';
			$form['Text']			= '';
			$form['SourceLink']		= '';
			$form['IsVisible']		= 0;
			$form['IsComments']		= 0;
			$form['IsRSS']			= 1;
			$form['IsMain']			= 0;
			$form['IsImportant']	= 0;
			$form['SeoTitle']		= '';
			$form['SeoDescription']	= '';
			$form['SeoKeywords']	= '';
		}

		return STPL::Fetch('admin/modules/articles/edit_article', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'new_article',
		));
	}


	private function _GetArticleEdit() {
		global $DCONFIG, $CONFIG, $OBJECTS;

		// App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');
		// App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.js');
		// App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/smoothness/jquery-ui-1.8.14.custom.css');
		// App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery.ui.timepicker.css');

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->articleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_ARTICLES_NOT_FOUND);
			return STPL::Fetch('admin/modules/articles/edit_article');
		}

		$form['ArticleID']	= $article->ID;
		$form['SectionID'] 	= $this->_id;
		$form['Thumb'] 		= $article->Thumb;
		$form['Photo'] 		= $article->Photo;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Date']			= App::$Request->Post['Date']->Datestamp();
			$form['Time']			= App::$Request->Post['Time']->Timestamp() + $form['Date'];
			$form['ShortTitle']		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['Title']			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['AnnounceText']	= App::$Request->Post['AnnounceText']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
			$form['Text']			= App::$Request->Post['Text']->Value();
			$form['SourceLink']		= App::$Request->Post['SourceLink']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsComments']		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
			$form['IsRSS']			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
			$form['IsMain']			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
			$form['IsImportant']	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
			$form['SeoTitle'] 		= App::$Request->Post['SeoTitle']->Value();
			$form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
			$form['SeoKeywords'] 	= App::$Request->Post['SeoKeywords']->Value();
		}
		else
		{
			$form['Date'] 			= $article->Date;
			$form['Time'] 			= $article->Date;
			$form['ShortTitle']		= $article->ShortTitle;
			$form['Title']			= $article->Title;
			$form['AnnounceText']	= $article->AnnounceText;
			$form['Text']			= $article->Text;
			$form['SourceLink']		= $article->SourceLink;
			$form['IsVisible']		= $article->IsVisible;
			$form['IsComments']		= $article->IsComments;
			$form['IsRSS']			= $article->IsRSS;
			$form['IsMain']			= $article->IsMain;
			$form['IsImmportant']	= $article->IsImportant;
			$form['SeoTitle']		= $article->SeoTitle;
			$form['SeoDescription']	= $article->SeoDescription;
			$form['SeoKeywords']	= $article->SeoKeywords;
		}

		return STPL::Fetch('admin/modules/articles/edit_article', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'edit_article',
		));
	}

	private function _GetAjaxToggleArticleVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->articleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$article->IsVisible = !$article->IsVisible;
		$article->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $article->IsVisible,
			'articleid' => $ArticleID,
		));
		exit;
	}

	private function _GetAjaxToggleArticleMain()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->articleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$article->IsMain = !$article->IsMain;
		$article->Update();

		$json->send(array(
			'status' => 'ok',
			'main' => (int) $article->IsMain,
			'articleid' => $ArticleID,
		));
		exit;
	}

	private function _GetArticleDelete()
	{
		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->articleMgr->GetArticle($ArticleID);
		if ($article === null)
			return;

		$article->Remove();
		return;
	}

	private function _PostArticleNew()
	{
		global $CONFIG, $OBJECTS;

		$ShortTitle		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$Title			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$AnnounceText	= App::$Request->Post['AnnounceText']->Value();
		$Text			= App::$Request->Post['Text']->Value();
		$SourceLink		= App::$Request->Post['SourceLink']->Value();
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsComments		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
		$IsRSS			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
		$IsMain			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
		$IsImportant	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
		$SeoTitle		= App::$Request->Post['SeoTitle']->Value();
		$SeoDescription = App::$Request->Post['SeoDescription']->Value();
		$SeoKeywords 	= App::$Request->Post['SeoKeywords']->Value();
		$Date			= App::$Request->Post['Date']->Datestamp();
		$Time			= App::$Request->Post['Time']->Timestamp();

		if ($ShortTitle == "")
			UserError::AddErrorIndexed('ShortTitle', ERR_A_ARTICLES_EMPTY_SHORTTITLE);

		if ($Title == "")
			UserError::AddErrorIndexed('Title', ERR_A_ARTICLES_EMPTY_TITLE);

		if ($AnnounceText == "")
			UserError::AddErrorIndexed('AnnounceText', ERR_A_ARTICLES_EMPTY_ANNOUNCE_TEXT);

		if ($Text == "")
			UserError::AddErrorIndexed('Text', ERR_A_ARTICLES_EMPTY_TEXT);

		if(UserError::IsError())
			return false;

		$Data = array(
			'SectionID' 	=> $this->_id,
			'Date'			=> date("Y-m-d H:i:s", $Date + $Time),
			'ShortTitle' 	=> $ShortTitle,
			'Title' 		=> $Title,
			'AnnounceText' 	=> $AnnounceText,
			'Text' 			=> $Text,
			'SourceLink' 	=> $SourceLink,
			'IsVisible' 	=> $IsVisible,
			'IsComments' 	=> $IsComments,
			'IsRSS' 		=> $IsRSS,
			'IsMain' 		=> $IsMain,
			'IsImportant' 	=> $IsImportant,
			'SeoTitle' 		=> $SeoTitle,
			'SeoDescription'=> $SeoDescription,
			'SeoKeywords'	=> $SeoKeywords,
		);

		$article = new Article($Data);

		try {
			$article->UploadThumb();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('Thumb', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('Thumb',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);

			$article->Thumb = null;
			return false;
		}

		try {
			$article->UploadPhoto();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('Photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('Photo',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);

			$article->Photo = null;
			return false;
		}

		$article->Update();

		return true;
	}

	private function _PostArticleEdit() {
		global $CONFIG, $OBJECTS;

		$ArticleID	= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->articleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_ARTICLES_NOT_FOUND);
			return STPL::Fetch('admin/modules/articles/edit_article');
		}

		$ShortTitle		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$Title			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$AnnounceText	= App::$Request->Post['AnnounceText']->Value();
		$Text			= App::$Request->Post['Text']->Value();
		$SourceLink		= App::$Request->Post['SourceLink']->Value();
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsComments		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
		$IsRSS			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
		$IsMain			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
		$IsImportant	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
		$SeoTitle		= App::$Request->Post['SeoTitle']->Value();
		$SeoDescription = App::$Request->Post['SeoDescription']->Value();
		$SeoKeywords 	= App::$Request->Post['SeoKeywords']->Value();
		$Date			= App::$Request->Post['Date']->Datestamp();
		$Time			= App::$Request->Post['Time']->Timestamp();

		if ($ShortTitle == "")
			UserError::AddErrorIndexed('ShortTitle', ERR_A_ARTICLES_EMPTY_SHORTTITLE);

		if ($Title == "")
			UserError::AddErrorIndexed('Title', ERR_A_ARTICLES_EMPTY_TITLE);

		if ($AnnounceText == "")
			UserError::AddErrorIndexed('AnnounceText', ERR_A_ARTICLES_EMPTY_ANNOUNCE_TEXT);

		if ($Text == "")
			UserError::AddErrorIndexed('Text', ERR_A_ARTICLES_EMPTY_TEXT);

		if(UserError::IsError())
			return false;

		$del_thumb 		= App::$Request->Post['del_thumb']->Enum(0, array(0,1));
		$del_photo 		= App::$Request->Post['del_photo']->Enum(0, array(0,1));

		$article->Date			= $Date + $Time;
		$article->SectionID		= $this->_id;
		$article->ShortTitle	= $ShortTitle;
		$article->Title			= $Title;
		$article->AnnounceText	= $AnnounceText;
		$article->Text			= $Text;
		$article->SourceLink	= $SourceLink;
		$article->IsVisible		= $IsVisible;
		$article->IsComments	= $IsComments;
		$article->IsRSS			= $IsRSS;
		$article->IsMain		= $IsMain;
		$article->IsImportant	= $IsImportant;
		$article->SeoTitle		= $SeoTitle;
		$article->SeoDescription= $SeoDescription;
		$article->SeoKeywords	= $SeoKeywords;

		if ($del_thumb || is_file($_FILES['Thumb']['tmp_name']))
			$article->Thumb = null;

		try {
			$article->UploadThumb();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('Thumb', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('Thumb',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);

			$article->Thumb = null;
			return false;
		}


		if ($del_photo || is_file($_FILES['Photo']['tmp_name']))
			$article->Photo = null;

		try {
			$article->UploadPhoto();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('Photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('Photo',ERR_A_BANNERS_ERROR_UPLOAD_IMAGE);

			$article->Photo = null;
			return false;
		}

		$article->Update();

		return true;
	}
}