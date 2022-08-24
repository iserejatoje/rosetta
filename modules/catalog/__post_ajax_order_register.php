<?

	$filter = array(
		'flags' => array(
			'with' => array('OrderRefs'),
			'CatalogID' => App::$City->CatalogId,
			'objects' => true,
		),
		'limit' => 1,
	);

	$orders = $this->catalogMgr->GetOrders($filter);

	foreach ($orders as $order) {
		$order->refs;
	}

// var_dump($orders); exit;

	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$deliveryAddress = App::$Request->Post['deliveryAddress']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$deliveryDate = App::$Request->Post['deliveryDate']->Datestamp();
	$deliveryTime = App::$Request->Post['deliveryTime']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$recipientName = App::$Request->Post['recipientName']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$recipientPhone = App::$Request->Post['recipientPhone']->Phone();
	$customerName = App::$Request->Post['customerName']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$customerPhone = App::$Request->Post['customerPhone']->Phone();
	$customerEmail = App::$Request->Post['customerEmail']->Email();
	$customerComment = App::$Request->Post['customerComment']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);

	$isTakePhoto = App::$Request->Post['isTakePhoto']->Enum(0, array(0,1));
	$isNotify = App::$Request->Post['isNotify']->Enum(0, array(0,1));
	$isLeaveBouquet = App::$Request->Post['isLeaveBouquet']->Enum(0, array(0,1));

	$errors = array();

	$orderErros = CatalogMgr::$errors['order'];

	if (mb_strlen($customerName) == 0)
		$errors['customerName'] = $orderErros['customerName'];

	if (mb_strlen($customerPhone) == 0)
		$errors['customerPhone'] = $orderErros['customerPhone'];
	elseif (!Data::Is_Phone($customerPhone))
		$errors['customerPhone'] = $orderErros['customerPhone'];

	if ($customerEmail === false)
		$errors['customerEmail'] = $orderErros['customerEmail'];

	if (mb_strlen($recipientName) == 0)
		$errors['recipientName'] = $orderErros['recipientName'];

	// if (mb_strlen($recipientPhone) == 0)
		// $errors['recipientPhone'] = 'Не указан номер телефона';
	// elseif (!Data::Is_Phone($Phone))
		// $errors['recipientPhone'] = 'Неверный формат номера телефона';

	if ($deliveryDate === false)
		$errors['deliveryDate'] = $orderErros['deliveryDate'];

	if (mb_strlen($deliveryAddress) == 0)
		$errors['deliveryAddress'] = $orderErros['deliveryAddress'];

	if (sizeof($errors)) {

		echo $json->encode(array(
			'status' => 'error',
			'errors' => $errors,
		));
		exit;
	}

	$cart = $this->catalogMgr->GetCart();

	$Data = array(
		'DeliveryAddress' => $deliveryAddress,
		'DeliveryDate' => $deliveryDate,
		'DeliveryTime' => $deliveryTime,
		'RecipientName' => $recipientName,
		'RecipientPhone' => $recipientPhone,
		'CustomerName' => $customerName,
		'CustomerPhone' => $customerPhone,
		'CustomerEmail' => $customerEmail,
		'CustomerComment' => $customerComment,
		'IsTakePhoto' => $isTakePhoto,
		'IsNotify' => $isNotify,
		'IsLeaveBouquet' => $isLeaveBouquet,
		'Status' => CatalogMgr::ORDER_NOT_PAID,
		'TotalPrice' => $cart['total_price'],
		'CartCode' => $this->catalogMgr->CartCode,
		'UserID' => App::$User->ID,
		'CatalogID' => App::$City->CatalogId,
	);
exit;
	$order = new Order($Data);
	$order->Update();

	echo $json->encode(array(
		'status' => 'ok',
	));
	exit;