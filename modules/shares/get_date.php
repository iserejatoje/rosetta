<?
	$year = intval($this->_params['year']);
	$month = intval($this->_params['month']);
	$day = intval($this->_params['day']);

	if ($year == 0 && $month == 0 && $day == 0)
		Response::Redirect("/".App::$Env['section']."/date/".date("Y/m/d/"));

	$datearr = array(
		'year' 	=> $year,
		'month' => $month,
		'day' 	=> $day,
	);


	LibFactory::GetStatic('arrays');

	$date = implode('-', $datearr);

	if ($day == 0 && $month == 0)
		App::$Title->Title = "Новости за ".$year." год";
	elseif ($day == 0 && $month > 0)
		App::$Title->Title = "Новости за ".Arrays::$Month['subjective'][$month]." ".$year." года";
	else
		App::$Title->Title = "Новости за ".$day." ".Arrays::$Month['genitive'][$month]." ".$year." года";

	$page = App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);

	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1,
			'Period' => $datearr,
			'SectionID' => App::$Env['sectionid'],
		),
		'field' => array(
			'Created',
		),
		'dir' => array(
			'DESC',
		),
		'offset'=> ($page - 1) * $this->_config['rowsonpage'],
		'limit' => $this->_config['rowsonpage'],
		'calc'	=> true,
	);

	list($articles, $count) = $this->articlemgr->GetArticles($filter);
		
	$pages = Data::GetNavigationPagesNumber(
		$this->_config['rowsonpage'], $this->_config['pagesonpage'], $count, $page,
		"?page=@p@");
		
	return STPL::Fetch("modules/articles/date", array(
		'articles' => $articles,
		'count' => $count,
		'pages' => $pages,
		'date' => $datearr,
	));