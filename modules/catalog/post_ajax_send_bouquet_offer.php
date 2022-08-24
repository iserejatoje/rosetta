<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	LibFactory::GetMStatic('service', 'servicemgr');

    $id       = App::$Request->Post['id']->Value(Request::OUT_HTML_CLEAN);
    $username = App::$Request->Post['username']->Value(Request::OUT_HTML_CLEAN);
    $date     = App::$Request->Post['wedding_date']->Value();
    // $email    = App::$Request->Post['email']->Email(false);
    // $phone    = App::$Request->Post['phone']->Value(Request::OUT_HTML_CLEAN);
    $contact    = App::$Request->Post['contact']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['wishes']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

	$product = $this->catalogMgr->GetProduct($id);
	if($product === null) {
		UserError::AddErrorIndexed('productNotFound', ERR_M_CATALOG_PRODUCT_NOT_FOUND);
	}

	$errors = [];
    $orderErrors = CatalogMgr::$errors['form_request'];

    if($date) {
        list($day, $month, $year) = explode('.', $date);
        if(!checkdate($month, $day, $year) || strtotime($date) < time())
            $errors['wedding_date'] = $orderErrors['invalidDate'];
    }

    if (strlen($username) == 0)
        $errors['username'] = $orderErrors['customerName'];

    // if ($email === false)
    //     $errors['email'] = $orderErrors['customerEmail'];

    // if (strlen($phone) == 0)
    //     $errors['phone'] = $orderErrors['customerPhone'];

    if (!$contact)
        $errors['contact'] = $orderErrors['contact'];

    if (strlen($text) == 0)
        $errors['wishes'] = $orderErrors['wishText'];

    if (sizeof($errors)) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => $errors,
        ));
        exit;
    }

	LibFactory::GetStatic('mailsender');
	$mail = new MailSender();
	$mail->AddAddress('from', 'no-reply@'.$this->_env['site']['domain'], "Служба уведомлений", 'utf-8');
	$mail->AddHeader('Subject', $this->_env['site']['domain']." Заказ свадебного букета ", 'utf-8');
	$mail->body_type = MailSender::BT_HTML;

	$bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

	foreach($config['order_emails'] as $order_email)
	{
		$mail->AddAddress('to', $order_email);
	}

	$letter = "С сайта ".$this->_env['site']['domain']." поступил заказ на свадебный букет.<br/>";
    $letter.= "Артикул букета: ".$product->article."<br>";
	if($date) {
	    $letter.= "Дата выполнения заказа: ".$date."<br/>";
    }
    $letter.= "Имя пользователя: ".$username."<br/>";
	// $letter.= "Телефон пользователя: ".$phone."<br/>";
    // $letter.= "Почта пользователя: ".$email."<br/>";
	$letter.= "Контакт пользователя: ".$contact."<br/>";
	$letter.= "Текст сообщения (пожелания):<br/>".$text."<br/><br/>";

	$letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
	$mail->SendImmediate();

	$params = [
        'SectionID' => App::$City->CatalogId,
        'Name' => ServiceMgr::$MESSAGE[WEDDING],
        'Color' => ServiceMgr::$COLOR[WEDDING],
    ];
    ServiceMgr::getInstance()->addAlert($params);

	echo $json->encode(array(
		'status' => 'ok',
	));

	exit;

