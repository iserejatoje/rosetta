<?
	$article = $this->articlemgr->GetArticle($this->_params['articleid']);
	if ($article === null)
	{
		Response::Status(404);
		return STPL::Fetch('modules/shares/404');
	}

	if ($article->IsVisible === false)
	{
		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}

	$article->UpdateViews();

	$this->ArticleID = $article->ID;
	$this->Date = strtotime($article->Created);

	App::$Title->Description = UString::Truncate(strip_tags(UString::ChangeQuotes($article->AnnounceText)), 500);
	App::$Title->Add('meta', array('name' => 'title', 'content' => UString::ChangeQuotes($article->Title)));


	if ($article->SeoTitle != "")
		App::$Title->Title = $article->SeoTitle;

	App::$Title->Description = $article->SeoDescription;
	App::$Title->Keywords = $article->SeoKeywords;

	list($articles, $count) = $this->articlemgr->GetArticles($filter);
	$node = STreeMgr::GetNodeById(App::$Env['sectionid']);

	return STPL::Fetch("modules/articles/article", array(
		'article' => $article,
		'title' => $node->Name,
	));