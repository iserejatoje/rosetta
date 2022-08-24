<?
	$search = App::$Request->Get['search']->Value(Request::OUT_HTML_CLEAN);

	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1,
			'Search' => $search,
		),
		'dbg' => 0,
		'calc' => true
	);

	list($products, $count) = $this->catalogMgr->GetProducts($filter);

	$template = 'default';
	return STPL::Fetch('modules/catalog/'.$template, array(
		'nofilter' => true,
		'last_page' => true,
		'count'    => $count,
		'products' => $products,
	));

	exit;