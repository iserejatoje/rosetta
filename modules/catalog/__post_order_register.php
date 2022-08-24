<?

	$address   = App::$Request->Post['address']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$date      = App::$Request->Post['date']->Datestamp();
	$time      = App::$Request->Post['time']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$firstname = App::$Request->Post['firstname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$phone     = App::$Request->Post['phone']->Phone();
	$comment   = App::$Request->Post['comment']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);

	if (mb_strlen($firstname) == 0)
		UserError::AddErrorIndexed('firstname', ERR_M_CATALOG_FIRSTNAME_EMPTY);

	if (mb_strlen($phone) == 0)
		UserError::AddErrorIndexed('phone', ERR_M_CATALOG_EMPTY_PHONE);
	elseif (!Data::Is_Phone($phone))
		UserError::AddErrorIndexed('phone', ERR_M_CATALOG_WRONG_PHONE_FORMAT);

	if ($date === false)
		UserError::AddErrorIndexed('date', ERR_M_CATALOG_WRONG_FORMAT_DATE);

	if (mb_strlen($address) == 0)
		UserError::AddErrorIndexed('address', ERR_M_CATALOG_EMPTY_DELIVERY_ADDRESS);

	if(UserError::IsError())
	{
		return false;
	}


	$cart = $this->catalogMgr->GetCart();

	$Data = array(
		'address'      => $address,
		'deliverdate'  => $date,
		'deliverytime' => $time,
		'firstname'    => $firstname,
		'phone'        => $phone,
		'comment'      => $comment,
		'status'       => CatalogMgr::ORDER_NOT_PAID,
		'totalprice'   => $cart['total_price'],
		'cartcode'     => $this->catalogMgr->CartCode,
		'userid'       => App::$User->ID,
		'catalogid'    => App::$City->CatalogId,
	);

	$order = new Order($Data);
	$order->Update();

// 	foreach($cart['products'] as $item)
// 	{
// 		if($item['product'] === null)
// 			continue;

// 		if($item['product']->IsVisible == 0)
// 			continue;

// 		$params = array(
// 			'productid'  => $item['product']->ID,
// 			'priceid'    => $item['priceid'],
// 			'count'      => $item['count'],
// 			'price'      => $item['price'],
// 			'totalprice' => ($item['count'] * $item['price']),
// 		);

// 		$order->AddItem($params);
// 	}
// exit;
echo "OK";
exit;
	echo $json->encode(array(
		'status' => 'ok',
	));
	exit;