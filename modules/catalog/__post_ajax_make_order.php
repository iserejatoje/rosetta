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

	$street      = App::$Request->Post['customerStreet']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$firstname   = App::$Request->Post['customerName']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$apartment   = App::$Request->Post['customerApartment']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$house       = App::$Request->Post['customerHouse']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$house       = App::$Request->Post['customerHouse']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
	$paymenttype = App::$Request->Post['customerPaymenttype']->Int(CatalogMgr::PM_CASH, array_keys(CatalogMgr::$PM_TYPES));

	$phone     = App::$Request->Post['customerPhone']->Phone();
	$comment   = App::$Request->Post['customerComment']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);

	if (mb_strlen($firstname) == 0)
		UserError::AddErrorIndexed('customerName', ERR_M_CATALOG_FIRSTNAME_EMPTY);

	if (mb_strlen($phone) == 0)
		UserError::AddErrorIndexed('customerPhone', ERR_M_CATALOG_EMPTY_PHONE);
	elseif (!Data::Is_Phone($phone))
		UserError::AddErrorIndexed('customerPhone', ERR_M_CATALOG_WRONG_PHONE_FORMAT);

	if (mb_strlen($street) == 0)
		UserError::AddErrorIndexed('customerStreet', ERR_M_CATALOG_EMPTY_DELIVERY_ADDRESS);


	if(UserError::IsError())
	{
		return false;
	}

	$cart = $this->catalogMgr->GetCart();

	$Data = array(
		'street'      => $street,
		'house'       => $house,
		'firstname'   => $firstname,
		'paymenttype' => $paymenttype,
		'apartment'   => $apartment,
		'phone'       => $phone,
		'comment'     => $comment,
		'status'      => CatalogMgr::ORDER_NOT_PAID,
		'price'       => $cart['total_price'],
		'delivery'    => $cart['delivery'],
		'totalprice'  => ($cart['total_price'] + $cart['delivery']),
		'cartcode'    => $this->catalogMgr->CartCode,
		'userid'      => App::$User->ID,
		'catalogid'   => App::$City->CatalogId,
	);

	$order = new Order($Data);
	$order->Update();
	$refs = $order->refs;

	$result = $this->catalogMgr->SendToFrontpad($order->ID);

	// email notification
	$total = intval($order->TotalPrice);
	$subj = "Новый заказ на сайте ".$this->_env['site']['domain'];

	$header = "Content-Type: text/html ; charset=utf-8;\nMIME-Version: 1.0\nFrom: ".$this->_env['site']['domain']." <remind@".$this->_env['site']['domain'].">\n";
	$msg  = "Здравствуйте Оператор сайта ".$this->_env['site']['domain']."<br/><br/>";
	$msg .= "Поступил новый заказ<br/>";
	$msg .= "Заказ #".$order->ID."<br>";
	$msg .= "Сумма заказа: ".$order->Price."р.<br/>";
	$msg .= "Доставка: ".$order->Delivery."р.<br/>";
	$msg .= "Адресс: ".$order->Street." д.".$order->House." кв.".$order->Apartment."<br/>";
	$msg .= "Телефон: ".$order->Phone."<br/>";
	$msg .= "Комментарий: ".$order->Comment."<br/>";
	$msg .= "<br/><b>Состав заказа:</b><br/>";

	foreach($refs as $k => $item)
	{
		$msg .= $item['RealProduct']->Name." - ".$item['Count']."шт.<br>";
	}

	$msg .= "<br>Итоговая стоимость заказа: ".$order->TotalPrice.".руб<br/><br/>";
	$msg .= "С уважением,<br/>&nbsp;&nbsp;&nbsp;Служба обработки заказов ".$this->_env['site']['domain'];

	foreach($this->_config['call_email'] as $email)
	{
		mail($email, $subj, $msg, $header);
	}
	// ==========================================

	if($paymenttype == CatalogMgr::PM_ONLINE)
	{
		$out_summ = number_format(($order->TotalPrice + $order->Delivery), 2, '.', '');
		$pay_params = array(
			'OutSum' => $out_summ,
			'InvId'  => $order->ID,
			'Desc'   => "Заказ в магазине ВкусныеСуши",
		);

		$rk = $this->paymentMgr->GetDefaultAcc();
		$url = $rk->GetPayUrl($pay_params);
	}
	else
	{
		$url = "/catalog/notification/order_accepted/";
	}

	echo $json->encode(array(
		'status' => 'ok',
		'url' => $url,
	));

	exit;