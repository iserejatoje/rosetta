<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$priceid = App::$Request->Post['priceid']->Int(0, Request::UNSIGNED_NUM);
	$productid = App::$Request->Post['productid']->Int(0, Request::UNSIGNED_NUM);
	$count = App::$Request->Post['count']->Int(1, Request::UNSIGNED_NUM);

	$count = $count > 0 ? $count : 1;

	// if ($priceid == 0 && $price == 0) {
	// 	echo $json->encode(array(
	// 		'status' => 'error',
	// 		'errors' => array('price_not_found' => 'Неизвестная цена' )
	// 	));
	// 	exit;
	// }


	if($priceid > 0)
	{
		$productPrice = $this->catalogMgr->GetPrice($priceid);

		if ($productPrice === null) {
			echo $json->encode(array(
				'status' => 'error',
				'errors' => array('price_not_found' => 'Неизвестная цена' )
			));
			exit;
		}
	}

	$product = $this->catalogMgr->GetProduct($productid);
	if($product === null)
	{
		echo $json->encode(array(
			'status' => 'error',
			'errors' => array('product_not_found' => 'Продукт не найден' )
		));
		exit;
	}

	$product->AddToCart($count, $priceid);
	$cart = $this->catalogMgr->GetCart();

	echo $json->encode(array(
		'status' => 'ok',
		'product_item' => STPL::Fetch('modules/catalog/_product_item', $cart['products'][$productid."_".$priceid]),
		'cart_result' => STPL::Fetch('modules/catalog/_cart_result', $cart),
	));
	exit;