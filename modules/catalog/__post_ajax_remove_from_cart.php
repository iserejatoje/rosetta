<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$priceid = App::$Request->Post['priceid']->Int(0, Request::UNSIGNED_NUM);
	$productid = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
	$count = App::$Request->Post['count']->Int(null, Request::UNSIGNED_NUM);

	// if ($priceid == 0) {
	// 	echo $json->encode(array(
	// 		'status' => 'error',
	// 	));
	// 	exit;
	// }

	$productPrice = $this->catalogMgr->GetPrice($priceid);


	// if ($productPrice === null) {
	// 	echo $json->encode(array(
	// 		'status' => 'error',
	// 	));
	// 	exit;
	// }

	$product = $this->catalogMgr->GetProduct($productid);
	if($product === null)
	{
		echo $json->encode(array(
			'status' => 'error',
		));
		exit;
	}

	$product->RemoveFromCart($count, $priceid);
	$cart = $this->catalogMgr->GetCart();
	if(!isset($cart['products'][$productid."_".$priceid]))
	{
		$deleted = true;
		$product_item = '';
	}
	else
	{
		$deleted = false;
		$product_item = STPL::Fetch('modules/catalog/_cart_item', $cart['products'][$productid."_".$priceid]);
	}

	echo $json->encode(array(
		'status' => 'ok',
		'deleted' => $deleted,
		'item' => $product_item,
		// 'cart_result' => STPL::Fetch('modules/catalog/_cart_result', $cart),
		'result' => STPL::Fetch('modules/catalog/_cart_result', $cart),
		'mobilecart' => STPL::Fetch('modules/catalog/_mobilecart', array('cart' => $cart)),
	));
	exit;