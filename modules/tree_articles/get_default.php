<?
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

	return STPL::Fetch("modules/tree_articles/articles_list", array(
		'parents' => $parents,
		'childs'  => $childs,
		'path'    => $node->Path,
	));