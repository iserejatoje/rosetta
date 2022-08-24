<?php

ini_set('max_execution_time', '60');

$articles_error_code = 0;
define('ERR_A_TREE_ARTICLES_MASK', 0x00580000);

define('ERR_A_TREE_ARTICLES_EMPTY_SHORTTITLE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_EMPTY_SHORTTITLE] = 'Не указан краткий заголовок страницы';

define('ERR_A_TREE_ARTICLES_EMPTY_TITLE', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_EMPTY_TITLE] = 'Не указан заголовок страницы';

define('ERR_A_TREE_ARTICLES_EMPTY_ANNOUNCE_TEXT', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_EMPTY_ANNOUNCE_TEXT] = 'Не указан краткий анонс страницы';

define('ERR_A_TREE_ARTICLES_EMPTY_TEXT', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_EMPTY_TEXT] = 'Не указан текст страницы';

define('ERR_A_TREE_ARTICLES_NOT_FOUND', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_NOT_FOUND] = 'Страница не найдена';

define('ERR_A_TREE_ARTICLES_EMPTY_NAMEID', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_EMPTY_NAMEID] = 'Не указано имя для ссылки';

define('ERR_A_TREE_ARTICLES_DUPLICATE_NAMEID', ERR_A_BANNERS_MASK | $error_code++);
UserError::$Errors[ERR_A_TREE_ARTICLES_DUPLICATE_NAMEID] = 'Указанное имя для ссылки уже используется';

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

	private $treeArticleMgr;

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

		$this->treeArticleMgr = TreeArticleMgr::getInstance(false);
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
			case 'seo':
				$this->_title = "Список страниц";
				$html = $this->_GetSEO();
				break;
			case 'childs_articles':
				$this->_GetChildsArticle();
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
			case 'ajax_delete_article':
				$this->_GetAjaxArticleDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
				break;

			case 'photos':
				$this->_title = "Фотографии";
				$html = $this->GetArticlePhotos();
				break;
			case 'new_photo':
				$this->_title = "Добавить фотографию";
				$html = $this->GetArticlePhotoNew();
				break;
			case 'edit_photo':
				$this->_title = "Редактировать фотографию";
				$html = $this->GetArticlePhotoEdit();
				break;
			case 'photo_toggle_visible':
				$this->GetArticlePhotoToggleVisible();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&node='.$_GET['node'].'&articleid='.$_GET['articleid']);
				break;
			case 'delete_photo':
				$this->GetArticlePhotoDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&node='.$_GET['node'].'&articleid='.$_GET['articleid']);
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
				// array('name' => 'action', 'value' => 'seo', 'text' => 'seo'),
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
				{
					if ($_POST['close'] == 1)
						Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
					else
						Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=edit_article&id='.$_POST['id']);
				}
				break;

			case 'save_photos':
				if ($this->PostSavePhotos())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&articleid='.$_POST['articleid']);
				break;
			case 'edit_seo':
				if ($this->PostSeoEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=articles');
				break;
			case 'new_photo':
				if ($this->PostArticlePhotoNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&articleid='.$_POST['articleid']);
				break;
			case 'edit_photo':
				if ($this->PostArticlePhotoEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=photos&articleid='.$_POST['articleid']);
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
				'ParentID' => 0,
			),
			'field' => array(
				'Created',
			),
			'dir' => array(
				'DESC',
			),
			'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
			'limit' => self::$ROW_ON_PAGE,
			'calc'	=> true,
		);

		list($articles, $count) = $this->treeArticleMgr->GetArticles($filter);

		$pages = Data::GetNavigationPagesNumber(
			self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
			"?section_id=". $this->_id ."&action=articles&page=@p@");


		return STPL::Fetch('admin/modules/tree_articles/articles_list', array(
			'section_id' => $this->_id,
			'articles' => $articles,
			'pages' => $pages,
		));
	}

	private function _GetChildsArticle()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$parent		= App::$Request->Get['parent']->Int(0, Request::UNSIGNED_NUM);

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
				'SectionID' => $this->_id,
				'ParentID' => $parent,
			),
			'field' => array(
				'Created',
			),
			'dir' => array(
				'DESC',
			),
		);

		$articles = $this->treeArticleMgr->GetArticles($filter);
		$json->send(array(
			'status' => 'ok',
			'html' => STPL::Fetch('admin/modules/tree_articles/level', array('articles' => $articles, 'section_id' => $this->_id)),
		));
		exit;


	}


	private function _GetArticleNew() {

		global $DCONFIG, $CONFIG, $OBJECTS;

		$ParentID = App::$Request->Get['parent']->Int(0, Request::UNSIGNED_NUM);

		$form = array();

		$form['SectionID'] = $this->_id;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['NameID']			= App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['ParentID']		= App::$Request->Post['ParentID']->Int(0, Request::UNSIGNED_NUM);
			$form['ShortTitle']		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['Title']			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['AnnounceText']	= App::$Request->Post['AnnounceText']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
			$form['Text']			= App::$Request->Post['Text']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsComments']		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
			$form['IsRSS']			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
			$form['IsMain']			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
			$form['IsImportant']	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
			$form['SeoTitle'] 		= App::$Request->Post['SeoTitle']->Value();
			$form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
			$form['SeoKeywords'] 	= App::$Request->Post['SeoKeywords']->Value();
			$form['SeoText'] 		= App::$Request->Post['SeoText']->Value();
		}
		else
		{
			$form['NameID']			= '';
			$form['ParentID']		= $ParentID;
			$form['ShortTitle']		= '';
			$form['Title']			= '';
			$form['AnnounceText']	= '';
			$form['Text']			= '';
			$form['IsVisible']		= 0;
			$form['IsComments']		= 0;
			$form['IsRSS']			= 1;
			$form['IsMain']			= 0;
			$form['IsImportant']	= 0;
			$form['SeoTitle']		= '';
			$form['SeoDescription']	= '';
			$form['SeoKeywords']	= '';
			$form['SeoText']		= '';
		}

		return STPL::Fetch('admin/modules/tree_articles/edit_article', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'new_article',
		));
	}


	private function _GetArticleEdit() {
		global $DCONFIG, $CONFIG, $OBJECTS;

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_TREE_ARTICLES_NOT_FOUND);
			return STPL::Fetch('admin/modules/tree_articles/edit_article');
		}

		$form['ArticleID']	= $article->ID;
		$form['SectionID'] 	= $this->_id;
		$form['Thumb'] 		= $article->Thumb;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['NameID']			= App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['ParentID']		= App::$Request->Post['ParentID']->Int(0, Request::UNSIGNED_NUM);
			$form['ShortTitle']		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['Title']			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
			$form['AnnounceText']	= App::$Request->Post['AnnounceText']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
			$form['Text']			= App::$Request->Post['Text']->Value();
			$form['IsVisible']		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsComments']		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
			$form['IsRSS']			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
			$form['IsMain']			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
			$form['IsImportant']	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
			$form['SeoTitle'] 		= App::$Request->Post['SeoTitle']->Value();
			$form['SeoDescription'] = App::$Request->Post['SeoDescription']->Value();
			$form['SeoKeywords'] 	= App::$Request->Post['SeoKeywords']->Value();
			$form['SeoText'] 		= App::$Request->Post['SeoText']->Value();
		}
		else
		{
			$form['NameID']			= $article->NameID;
			$form['ParentID']		= $article->ParentID;
			$form['ShortTitle']		= $article->ShortTitle;
			$form['Title']			= $article->Title;
			$form['AnnounceText']	= $article->AnnounceText;
			$form['Text']			= $article->Text;
			$form['IsVisible']		= $article->IsVisible;
			$form['IsComments']		= $article->IsComments;
			$form['IsRSS']			= $article->IsRSS;
			$form['IsMain']			= $article->IsMain;
			$form['IsImmportant']	= $article->IsImportant;
			$form['SeoTitle']		= $article->SeoTitle;
			$form['SeoDescription']	= $article->SeoDescription;
			$form['SeoKeywords']	= $article->SeoKeywords;
			$form['SeoText']		= $article->SeoText;
		}


		return STPL::Fetch('admin/modules/tree_articles/edit_article', array(
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
		$article = $this->treeArticleMgr->GetArticle($ArticleID);
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

	private function _GetSEO()
	{
		$seo = $this->treeArticleMgr->GetArticleSEO($this->_id);

		$form = array();
		if(sizeof($seo) > 0)
		{
			$form['SeoID']          = $seo['SeoID'];
			$form['SeoTitle']       = $seo['SeoTitle'];
			$form['SeoKeywords']    = $seo['SeoKeywords'];
			$form['SeoDescription'] = $seo['SeoDescription'];
			$form['SeoText']        = $seo['SeoText'];
		}
		else
		{
			$form['SeoID']          = 0;
			$form['SeoTitle']       = "";
			$form['SeoKeywords']    = "";
			$form['SeoDescription'] = "";
			$form['SeoText']        = "";
		}

		return STPL::Fetch('admin/modules/tree_articles/article_seo', array(
			'section_id' => $this->_id,
			'form' => $form,
			'action' => 'edit_seo',
		));
	}

	private function PostSeoEdit()
	{
		$SeoTitle       = App::$Request->Post['SeoTitle']->Value();
		$SeoDescription = App::$Request->Post['SeoDescription']->Value();
		$SeoKeywords    = App::$Request->Post['SeoKeywords']->Value();
		$SeoText        = App::$Request->Post['SeoText']->Value();
		$SeoID          = App::$Request->Post['SeoID']->Int(0, Request::UNSIGNED_NUM);

		$data = array(
			'SeoTitle'       => $SeoTitle,
			'SeoDescription' => $SeoDescription,
			'SeoKeywords'    => $SeoKeywords,
			'SeoText'        => $SeoText,
			'SectionID'      => $this->_id,
			'SeoID'          => $SeoID,
		);

		if($SeoID == 0)
			$this->treeArticleMgr->AddSeo($data);
		else
			$this->treeArticleMgr->UpdateSeo($data);

		return true;
	}

	private function _GetAjaxToggleArticleMain()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->treeArticleMgr->GetArticle($ArticleID);
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

	private function _GetAjaxArticleDelete()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$ArticleID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
			return;

		$parent = null;
		if ($article->ParentID > 0)
		{
			$parent = $this->treeArticleMgr->GetArticle($article->ParentID);

			$article->Remove();

			$filter = array(
				'flags' => array(
					'objects' => true,
					'IsVisible' => -1,
					'SectionID' => $this->_id,
					'ParentID' => $parent->ParentID,
				),
				'field' => array(
					'Created',
				),
				'dir' => array(
					'DESC',
				),
			);

			$articles = $this->treeArticleMgr->GetArticles($filter);
			$json->send(array(
				'status' => 'ok',
				'articleid' => $ArticleID,
				'parent' => $parent->ID,
				'parent_html' => STPL::Fetch('admin/modules/tree_articles/level', array('articles' => $articles, 'section_id' => $this->_id)),
			));
		}
		else
		{
			$article->Remove();
			$json->send(array(
				'status' => 'ok',
				'articleid' => $ArticleID,
				'parent' => $parent,
			));
		}

		exit;
	}


	private function GetArticlePhotos()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);
		$form = array();

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
			return STPL::Fetch('admin/modules/tree_articles/photos');
		}

		$filter = array(
			'flags' => array(
				'ArticleID' => $ArticleID,
				'IsVisible' => -1,
				'objects' => true,
			),
			'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
			'limit' => self::$ROW_ON_PAGE,
			'calc'	=> true,
		);

		list($photos, $count) = $this->treeArticleMgr->GetPhotos($filter);

		$pages = Data::GetNavigationPagesNumber(
			self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
			"?{$DCONFIG['SECTION_ID_URL']}&action=photos&articleid=".$ArticleID."&id=".$photoID."&page=@p@");

		$this->_title = $this->_title." (".$article->Name.")";

		return STPL::Fetch('admin/modules/tree_articles/photos', array(
			'section_id' => $this->_id,
			'photos' => $photos,
			'article' => $article,
		));
	}

	private function GetArticlePhotoNew()
	{
		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
			return STPL::Fetch('admin/modules/articles/photos');
		}

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name'] 			= App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
			$form['IsVisible'] 		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsShowList'] 	= App::$Request->Post['IsShowList']->Enum(0, array(0,1));
			$form['Ord'] 			= App::$Request->Post['Ord']->Int(0, Request::UNSIGNED_NUM);
			$form['ArticleID'] 		= App::$Request->Post['articleid']->Int(0, Request::UNSIGNED_NUM);
		}
		else
		{
			$form['Name'] 			= '';
			$form['Ord']			= 0;
			$form['IsVisible'] 		= 1;
			$form['IsShowList'] 	= 0;
			$form['ArticleID'] 		= $ArticleID;
		}

		return STPL::Fetch('admin/modules/tree_articles/edit_photo', array(
			'section_id' => $this->_id,
			'form' => $form,
			'article' => $article,
			'action' => 'new_photo',
		));
	}

	private function GetArticlePhotoEdit()
	{
		$PhotoID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
			return STPL::Fetch('admin/modules/tree_articles/photos');
		}

		$photo = $this->treeArticleMgr->GetPhoto($PhotoID);
		if ($photo === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CATALOG_NOT_FOUND);
			return STPL::Fetch('admin/modules/tree_articles/edit_photo');
		}

		$form['PhotoSmall'] = $photo->PhotoSmall;
		$form['PhotoLarge'] = $photo->PhotoLarge;

		$form['ArticleID'] 		= $ArticleID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name'] 			= App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
			$form['IsVisible'] 		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsShowList'] 	= App::$Request->Post['IsShowList']->Enum(0, array(0,1));
			$form['Ord'] 			= App::$Request->Post['Ord']->Int(0, Request::UNSIGNED_NUM);
			$form['PhotoID'] 		= $photo->ID;

		} else {

			$form['PhotoID'] 		= $photo->ID;
			$form['Name'] 			= $photo->Name;
			$form['IsVisible'] 		= $photo->IsVisible;
			$form['IsShowList'] 	= $photo->IsShowList;
			$form['Ord'] 			= $photo->Ord;

		}

		return STPL::Fetch('admin/modules/tree_articles/edit_photo', array(
			'section_id' => $this->_id,
			'form' => $form,
			'article' => $article,
			'action' => 'edit_photo',
		));
	}

	private function GetArticlePhotoToggleVisible()
	{
		$PhotoID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
			return;

		$photo = $this->treeArticleMgr->GetPhoto($PhotoID);
		if ($photo === null)
			return;

		$photo->IsVisible = !$photo->IsVisible;
		$photo->Update();
		return;
	}

	private function GetArticlePhotoDelete()
	{
		$PhotoID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
			return;

		$photo = $this->treeArticleMgr->GetPhoto($PhotoID);
		if ($photo === null)
			return;

		$photo->Remove();
		return;
	}

	private function GetArticlePhotoChangeOrd($action)
	{
		$PhotoID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$ArticleID	= App::$Request->Get['articleid']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
			return;

		$photo = $this->treeArticleMgr->GetPhoto($PhotoID);
		if ($photo === null)
			return;

		if ($action === true)
		{
			$photo->Ord++;
		}
		elseif ($photo->Ord	> 0)
			$photo->Ord--;

		$photo->Update();
		return;
	}

	private function _PostArticleNew()
	{
		global $CONFIG, $OBJECTS;

		$ParentID	= App::$Request->Post['ParentID']->Int(0, Request::UNSIGNED_NUM);
		$NameID	= App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$NameID = strtolower($NameID);
		$NameID = preg_replace(array("@\s@","@\-@"), array("_","_"), $NameID);
		$NameID = preg_replace("@[^a-z\_0-9]@", "", $NameID);

		$ShortTitle		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$Title			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$AnnounceText	= App::$Request->Post['AnnounceText']->Value();
		$Text			= App::$Request->Post['Text']->Value();
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsComments		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
		$IsRSS			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
		$IsMain			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
		$IsImportant	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
		$SeoTitle		= App::$Request->Post['SeoTitle']->Value();
		$SeoDescription = App::$Request->Post['SeoDescription']->Value();
		$SeoKeywords 	= App::$Request->Post['SeoKeywords']->Value();
		$SeoText 		= App::$Request->Post['SeoText']->Value();

		// if ($ShortTitle == "")
		// 	UserError::AddErrorIndexed('ShortTitle', ERR_A_TREE_ARTICLES_EMPTY_SHORTTITLE);

		if ($NameID == "")
			UserError::AddErrorIndexed('NameID', ERR_A_TREE_ARTICLES_EMPTY_NAMEID);

		if ($Title == "")
			UserError::AddErrorIndexed('Title', ERR_A_TREE_ARTICLES_EMPTY_TITLE);

		// if ($AnnounceText == "")
		// 	UserError::AddErrorIndexed('AnnounceText', ERR_A_TREE_ARTICLES_EMPTY_ANNOUNCE_TEXT);

		if ($Text == "")
			UserError::AddErrorIndexed('Text', ERR_A_TREE_ARTICLES_EMPTY_TEXT);

		if(UserError::IsError())
			return false;

		$Data = array(
			'SectionID' 	=> $this->_id,
			'ParentID' 		=> $ParentID,
			'NameID' 		=> $NameID,
			'ShortTitle' 	=> $ShortTitle,
			'Title' 		=> $Title,
			'AnnounceText' 	=> $AnnounceText,
			'Text' 			=> $Text,
			'IsVisible' 	=> $IsVisible,
			'IsComments' 	=> $IsComments,
			'IsRSS' 		=> $IsRSS,
			'IsMain' 		=> $IsMain,
			'IsImportant' 	=> $IsImportant,
			'SeoTitle' 		=> $SeoTitle,
			'SeoDescription'=> $SeoDescription,
			'SeoKeywords'	=> $SeoKeywords,
			'SeoText'		=> $SeoText,
		);

		$article = new TArticle($Data);

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

		$article->Update();

		return true;
	}

	private function _PostArticleEdit() {
		global $CONFIG, $OBJECTS;

		$ArticleID	= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$article = $this->treeArticleMgr->GetArticle($ArticleID);
		if ($article === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_TREE_ARTICLES_NOT_FOUND);
			return STPL::Fetch('admin/modules/tree_articles/edit_article');
		}

		$ParentID	= App::$Request->Post['ParentID']->Int(0, Request::UNSIGNED_NUM);

		$NameID	= App::$Request->Post['NameID']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$NameID = strtolower($NameID);
		$NameID = preg_replace(array("@\s@","@\-@"), array("_","_"), $NameID);
		$NameID = preg_replace("@[^a-z\_0-9]@", "", $NameID);

		$ShortTitle		= App::$Request->Post['ShortTitle']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$Title			= App::$Request->Post['Title']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
		$AnnounceText	= App::$Request->Post['AnnounceText']->Value();
		$Text			= App::$Request->Post['Text']->Value();
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsComments		= App::$Request->Post['IsComments']->Enum(0, array(0,1));
		$IsRSS			= App::$Request->Post['IsRSS']->Enum(0, array(0,1));
		$IsMain			= App::$Request->Post['IsMain']->Enum(0, array(0,1));
		$IsImportant	= App::$Request->Post['IsImportant']->Enum(0, array(0,1));
		$SeoTitle		= App::$Request->Post['SeoTitle']->Value();
		$SeoDescription = App::$Request->Post['SeoDescription']->Value();
		$SeoKeywords 	= App::$Request->Post['SeoKeywords']->Value();
		$SeoText 		= App::$Request->Post['SeoText']->Value();

		if (empty($NameID))
			UserError::AddErrorIndexed('NameID', ERR_A_TREE_ARTICLES_EMPTY_NAMEID);
		elseif (($article_old = $this->treeArticleMgr->GetArticleByNameID($NameID, $ParentID)) !== null)
			if ($article_old->ID != $article->ID)
				UserError::AddErrorIndexed('NameID', ERR_A_TREE_ARTICLES_DUPLICATE_NAMEID);

		// if ($ShortTitle == "")
		// 	UserError::AddErrorIndexed('ShortTitle', ERR_A_TREE_ARTICLES_EMPTY_SHORTTITLE);

		if ($Title == "")
			UserError::AddErrorIndexed('Title', ERR_A_TREE_ARTICLES_EMPTY_TITLE);

		// if ($AnnounceText == "")
		// 	UserError::AddErrorIndexed('AnnounceText', ERR_A_TREE_ARTICLES_EMPTY_ANNOUNCE_TEXT);

		if ($Text == "")
			UserError::AddErrorIndexed('Text', ERR_A_TREE_ARTICLES_EMPTY_TEXT);

		if(UserError::IsError())
		{
			return false;
		}

		$del_thumb 		= App::$Request->Post['del_thumb']->Enum(0, array(0,1));

		$article->SectionID		= $this->_id;
		$article->ParentID		= $ParentID;
		$article->NameID		= $NameID;
		$article->ShortTitle	= $ShortTitle;
		$article->Title			= $Title;
		$article->AnnounceText	= $AnnounceText;
		$article->Text			= $Text;
		$article->IsVisible		= $IsVisible;
		$article->IsComments	= $IsComments;
		$article->IsRSS			= $IsRSS;
		$article->IsMain		= $IsMain;
		$article->IsImportant	= $IsImportant;
		$article->SeoTitle		= $SeoTitle;
		$article->SeoDescription= $SeoDescription;
		$article->SeoKeywords	= $SeoKeywords;
		$article->SeoText		= $SeoText;

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

		$article->Update();

		return true;
	}

	private function PostArticlePhotoNew()
	{
		global $CONFIG, $OBJECTS;

		$ArticleID		= App::$Request->Post['articleid']->Int(0, Request::UNSIGNED_NUM);
		$Name			= App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));

		/*if (empty($Name))
			UserError::AddErrorIndexed('Name', ERR_A_SHARES_EMPTY_NAME);

		if(UserError::IsError())
			return false;
*/
		$Data = array(
			'ArticleID'		=> $ArticleID,
			'Name'			=> $Name,
			'IsVisible'		=> $IsVisible,
			'Ord'			=> 0,
		);

		$photo = new TreeArticlePhoto($Data);

		try {
			$photo->UploadPhotoSmall();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('photosmall', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photosmall',ERR_A_SHARES_ERROR_UPLOAD_IMAGE);
			$photo->photosmall = null;
			return false;
		}

		try {
			$photo->UploadPhotoLarge();
		} catch(MyException $e) {
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('photolarge', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photolarge',ERR_A_SHARES_ERROR_UPLOAD_IMAGE);

			$photo->photolarge = null;
			return false;
		}

		$photo->Update();

		return true;
	}

	private function PostArticlePhotoEdit()
	{
		global $CONFIG, $OBJECTS;

		$ArticleID	= App::$Request->Post['articleid']->Int(0, Request::UNSIGNED_NUM);
		$PhotoID	= App::$Request->Post['photoid']->Int(0, Request::UNSIGNED_NUM);

		$article = $this->treeArticleMgr->GetArticle($ArticleID);

		if ($article === null) {
			UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
			return ;
		}

		$photo = $this->treeArticleMgr->GetPhoto($PhotoID);
		if ($photo === null)
		{
			UserError::AddError('global', ERR_A_CATALOG_NOT_FOUND);
			return ;
		}

		$Name			= App::$Request->Post['Name']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
		$IsVisible		= App::$Request->Post['IsVisible']->Enum(0, array(0,1));

		$del_photosmall	= App::$Request->Post['del_photosmall']->Enum(0, array(0,1));
		$del_photolarge = App::$Request->Post['del_photolarge']->Enum(0, array(0,1));

		$photo->Name		= $Name;
		$photo->IsVisible	= $IsVisible;

		if ($del_photosmall || is_file($_FILES['photosmall']['tmp_name']))
			$photo->PhotoSmall = null;

		if ($del_photolarge || is_file($_FILES['photolarge']['tmp_name']))
			$photo->PhotoLarge = null;

		try
		{
			$photo->UploadPhotoSmall();
		}
		catch(MyException $e)
		{
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('photosmall', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photosmall',ERR_A_SHARES_ERROR_UPLOAD_IMAGE);

			return false;
		}

		try
		{
			$photo->UploadPhotoLarge();
		}
		catch(MyException $e)
		{
			if( $e->getCode() >  0 )
				UserError::AddErrorWithArgsIndexed('photolarge', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photolarge',ERR_A_SHARES_ERROR_UPLOAD_IMAGE);

			return false;
		}

		$photo->Update();

		return true;
	}

	private function PostSavePhotos()
	{
		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);
		if (!is_array($orders) || count($orders) == 0)
			return true;


		foreach($orders as $photoid => $value)
		{
			$photo = $this->treeArticleMgr->GetPhoto($photoid);
			if ($photo === null)
				continue;

			$photo->Ord = $value;
			$photo->Update();
		}
		return true;
	}
}