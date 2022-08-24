<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$members = App::$Request->Post['members']->AsArray(array());
	$typeid = App::$Request->Post['typeid']->Int(0, Request::UNSIGNED_NUM);
	$page = App::$Request->Post['page']->Int(0, Request::UNSIGNED_NUM);

	$filter = array(
		'flags' => array(
			'objects' => true,
			'IsVisible' => 1,
		),
		'field' => array('Ord'),
		'dir' => array('ASC'),
		'offset'=> ($page - 1) * $this->_config['rowsonpage'],
		'limit' => $this->_config['rowsonpage'],
		'calc' => true,
		'dbg' => 0,
	);

	if(!isset($members['all']) && count($members) > 0)
	{
		$filter['flags']['composition'] = $members;
		$arrUrl = array();
		foreach($members as $k => $v)
			$arrUrl[] = "members[".$k."]=".$v;

		$url = implode("&", $arrUrl);
	}

	if($typeid > 0)
		$filter['flags']['TypeID'] = $typeid;

	list($products, $count) = $this->catalogMgr->GetProducts($filter);

	if(($page-1)*$this->_config['rowsonpage'] > $count)
		$page = 1;


	$last_page = false;
	$pages = Data::GetNavigationPagesNumber(
		$this->_config['rowsonpage'], $this->_config['pagesonpage'], $count, $page, "?p=@p@&".$url);

	if (empty($pages['next']))
		$last_page = true;

	$cart = $this->catalogMgr->GetCart();
	$in_cart = array();

	foreach($cart['products'] as $item)
	{
		$in_cart[] = $item['product']->ID;
	}


	echo $json->encode(array(
		'status' => 'ok',
		'last_page' => $last_page,
		'html' => STPL::Fetch("modules/catalog/_product_list", array(
			'products' => $products,
			'count' => $count,
			'in_cart' => $in_cart,
		)),
	));

	exit;