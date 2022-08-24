<?
	if (isset($this->_params['path'])) {
		$path = $this->_params['path'];
		$len = strlen($path);
		if (strrpos($path, "/") == $len-1)
			$path = substr($path, 0, $len - 1);
	}

	$nameids = explode("/", $path);
	if (!is_array($nameids) || count($nameids) == 0)
		Response::Status(404, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);

	$is_preview = App::$Request->Get['preview']->Enum(0, array(0,1)) > 0;

	$parent = 0;
	$article = null;
	$counter = 0;

	$parents = array();
	foreach($nameids as $nameid)
	{
		$article = $this->articlemgr->GetArticleByNameID($nameid, $parent);

		if ($article === null)
			Response::Status(404, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);

		if ($is_preview === false)
		{
			if ($article->IsVisible === false)
				Response::Status(404, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);
		}
		$counter++;
		$parent = $article->ID;

		// $parents[] = $article;
	}

	if ($counter < count($nameids))
		Response::Status(404, Response::STATUS_SENDPAGE | Response::STATUS_EXIT);

	$article->UpdateViews();

	App::$Title->Title = $article->Title;
	App::$Title->Description = UString::Truncate(strip_tags(UString::ChangeQuotes($article->AnnounceText)), 500);
	App::$Title->Add('meta', array('name' => 'title', 'content' => UString::ChangeQuotes($article->Title)));

	if ($article->SeoTitle != "")
		App::$Title->Title = $article->SeoTitle;

	App::$Title->Description = $article->SeoDescription;
	App::$Title->Keywords = $article->SeoKeywords;

	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1,
			'ParentID' => 0,
			'SectionID' => App::$Env['sectionid'],
		),
	);

	$parents = $this->articlemgr->GetArticles($filter);
	$childs = array();

	foreach($parents as $section)
	{
		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => 1,
				'ParentID' => $section->ID,
			),
		);

		$child = $this->articlemgr->GetArticles($filter);

		if(is_array($child) && sizeof($child) > 0)
			$childs[$section->ID] = $child;
	}

	$node = STreeMgr::GetNodeById(App::$Env['sectionid']);

	if($article->NameID === 'preimuschestva_natjazhnyh_potolkov' && $childs > 0)
		$tpl = "modules/tree_articles/pages/page_advantage";
	else
		$tpl = "modules/tree_articles/articles_list";

	return STPL::Fetch($tpl, array(
		'parents' => $parents,
		'childs'  => $childs,
		'article' => $article,
		'path'    => $node->Path,

	));