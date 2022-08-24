<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	if($this->catalogMgr->inmode() == false)
	{
		echo $json->encode(array(
			'status' => 'ok',
			'inmode' => false
		));
		exit;
	}

	$priceid = App::$Request->Post['priceid']->Int(0, Request::UNSIGNED_NUM);
	$productid = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
	$count = App::$Request->Post['count']->Int(1, Request::UNSIGNED_NUM);

	$count = $count > 0 ? $count : 1;

	// if ($priceid == 0 && $price == 0) {
	// 	echo $json->encode(array(
	// 		'status' => 'error',
	// 	));
	// 	exit;
	// }


	if($priceid > 0)
	{
		$productPrice = $this->catalogMgr->GetPrice($priceid);

		if ($productPrice === null) {
			echo $json->encode(array(
				'status' => 'error1',
			));
			exit;
		}
	}

	$product = $this->catalogMgr->GetProduct($productid);
	if($product === null)
	{
		echo $json->encode(array(
			'status' => 'error2',
		));
		exit;
	}

	$product->AddToCart($count, $priceid, $price);
	$cart = $this->catalogMgr->GetCart();

	echo $json->encode(array(
		'status' => 'ok',
		'item' => STPL::Fetch('modules/catalog/_cart_item', $cart['products'][$productid."_".$priceid]),
		'result' => STPL::Fetch('modules/catalog/_cart_result', $cart),
		'mobilecart' => STPL::Fetch('modules/catalog/_mobilecart', array('cart' => $cart)),
	));
	exit;