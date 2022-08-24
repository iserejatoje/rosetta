<?

	$page = App::$Request->Get['p']->Int(1, Request::UNSIGNED_NUM);
	if (isset(App::$Request->Get['p']) && $page == 1)
	{
		Response::Status(301);
		Response::Redirect("/".$this->_env['section']."/");
	}

	$filter = array(
		'flags' => array(
			'IsVisible'	=> 1,
			'objects' => true,
		),

		'field'	=> array(
			'Created',
		),
		'dir'	=> array(
			'DESC',
		),
		'offset'=> ($page - 1) * $this->_config['rowsonpage'],
		'limit' => $this->_config['rowsonpage'],
		'calc'	=> true,
		'dbg' => 0,
	);

	list($list, $count) = $this->reviewmgr->GetReviews($filter);

	if (isset(App::$Request->Get['p']) && $page > 1 && count($list) == 0)
	{
		Response::Status(301);
		Response::Redirect("/".$this->_env['section']."/");
	}

	if(($page-1)*$this->_config['rowsonpage'] > $count)
		$page = 1;

	$pages = Data::GetNavigationPagesNumber(
		$this->_config['rowsonpage'], $this->_config['pagesonpage'], $count, $page, "?p=@p@");

	$params = array(
		'list' => $list,
		'pages' => $pages,
		'count' => $count,
	);

	return STPL::Fetch('modules/reviews/list', $params);

