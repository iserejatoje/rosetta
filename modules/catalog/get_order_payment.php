<?
    // Проверка наличия заказа
    // Проверка статуса оплаты


    $logFile = ENGINE_PATH.'resources/log/log_order_'.$_GET['MNT_TRANSACTION_ID'].'.log';

    if(App::$User->Email == 'admin@rosetta.ru') {
        error_log("=================================".PHP_EOL, 3, $logFile);
        error_log("DEBUG ADMIN MODE".PHP_EOL, 3, $logFile);
        error_log("=================================".PHP_EOL, 3, $logFile);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    //     echo 'Admin debug mode'.PHP_EOL;
    //     error_log("Log for order №".$_GET['MNT_TRANSACTION_ID']."\n".PHP_EOL, 3, $logFile);
    //     exit;
    }

    error_log("Log for order №".$_GET['MNT_TRANSACTION_ID']."\n".PHP_EOL, 3, $logFile);
    error_log("[".date('d.m.Y H:i:s', time())."] "."\n", 3, $logFile);

    error_log(" ========== GET params ========== \n", 3, $logFile);
    foreach($_GET as $k => $v) {
        error_log($k."  ".$v."\n", 3, $logFile);
    }
    error_log(" ========== GET params ========== \n", 3, $logFile);


    $rk = $this->paymentMgr->GetDefaultAcc();
    if(!$rk) {
        error_log(' ORDER №' . $_GET['MNT_TRANSACTION_ID'] . ' ACCOUNT NOT FOUND');
        error_log("[".date('d.m.Y H:i:s', time())."] "."ACCOUNT NOT FOUND\n", 3, $logFile);
        //echo 'FAIL';
        //exit;
    } else {
        error_log("[".date('d.m.Y H:i:s', time())."] "."Payment account\t\tOK\n", 3, $logFile);
    }

    if($rk->CheckPayment($_GET) == false && App::$User->Email !== 'admin@rosetta.ru') {
    // if($rk->CheckPayment($_GET) == false) {
        error_log(' ORDER №' . $_GET['MNT_TRANSACTION_ID'] . ' SIGNATURE MISMATCH');
        error_log("[".date('d.m.Y H:i:s', time())."] "."SIGNATURE MISMATCH\n", 3, $logFile);
        echo 'FAIL CHECK SIGNATURE';
        exit;
    } else {
        error_log("[".date('d.m.Y H:i:s', time())."] "."Signature\t\tmatch\n", 3, $logFile);
    }

    // Отправка писем
    $order = $this->catalogMgr->GetOrder($_GET['MNT_TRANSACTION_ID']);

    if($order->PaymentStatus == CatalogMgr::PS_PAID && App::$User->Email !== 'admin@rosetta.ru') {
    // if($order->PaymentStatus == CatalogMgr::PS_PAID) {
        error_log(' ORDER №' . $_GET['MNT_TRANSACTION_ID'] . ' HAS ALREADY BEEN PAID');
        error_log("[".date('d.m.Y H:i:s', time())."] "."Order already payment\n", 3, $logFile);
    	echo "FAIL - ORDER ALREAY PAID";
    	exit;
    }

    if($order === null) {
    	echo "FAIL - ORDER NOT FOUND";
    	error_log($_GET['MNT_TRANSACTION_ID'].' FAIL 1');
    	exit;
    }

    error_log('NEW ORDER №' . $_GET['MNT_TRANSACTION_ID']);
    $order->PaymentStatus = CatalogMgr::PS_PAID;
    $order->Update();

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', 'no-reply@rosetta.florist', "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', $this->_env['site']['domain'].". Поступление оплаты к заказу № ".$order->id, 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    foreach($this->_config['order_emails'] as $order_email)
    {
    	$mail->AddAddress('to', $order_email);
    }

    $letter = "На сайт ".$this->_env['site']['domain']." поступила оплата заказа <br>";
    $letter .= "Номер заказа: ".$order->id."<br>";
    $letter .= "Сумма оплаты: ".$order->totalprice."руб.<br>";
    // $letter.= "<a href='http://".$this->_env['site']['domain']."/admin/site/".$this->_env['site']['domain']."/catalog/.module/?section_id=71&action=edit_order&id=".$order->id."'>Заказ №".$order->id."</a><br/>";

    // $letter.= "Для модерирования пройдите по ссылке <a href=\"http://___/admin/site/___/reviews/.module/?treelisth_scol=1&treelisth_sord=0\">ссылке</a><br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    $this->catalogMgr->ClearCart($order->cartcode);

    // $price_for_discount = $this->_config['discount_price'];
    // $discount = $this->_config['discount_code'][CatalogMgr::DC_DISCOUNT_CODE];
    // $total_price = $order->totalprice + $order->cardprice;

    // if($order->WantDiscountCard == 1
    //     && $price_for_discount > 0
    // 	&& $discount > 0
    // 	&& $order->DiscountCard == ''
    // 	&& $total_price >= $price_for_discount) {
    //     // error_log('setting discount card');
    // 	// Назначение скидочной карты
    // 	// Проверить, что этому челу уже назначали скидочную карту.
    // 	$card = $this->catalogMgr->GenerateDiscountCard();
    //     $card->orderid = $order->id;
    //     $card->update();

    // 	$mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">");
    // 	$mail->AddHeader('Subject', "Скидочная карта в интернет-магазине Розетта ".$this->_env['site']['domain'], 'utf-8');
    // 	$mail->body_type = MailSender::BT_HTML;

    // 	$mail->AddAddress('to', $order->customeremail);

    //     $letter = STPL::Fetch('modules/catalog/mail/discountcard', [
    //         'cardcode' => $card->code,
    //         'date' => CatalogMgr::$weekdate[date('w', time())].", ".date('d.m.Y', time()),
    //         'domain' => $this->_env['site']['domain'],
    //     ]);

    // 	$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    // 	$mail->SendImmediate();

    // 	$msg = "shop.ipkhratd.beget.tech: Cкидка 5% на покупки по коду ".$card->code;
    // 	LibFactory::GetStatic('sms');
    //     error_log($msg);
    //     // echo $msg; exit;
    //     $sms = new SMS();
    //     $result = $sms->send($order->customerphone, $msg);

    // } else {
    //     error_log('no card');
    // }

    LibFactory::GetMStatic('service', 'servicemgr');

    $params = [
            'SectionID' => App::$City->CatalogId,
            'Name' => ServiceMgr::$MESSAGE[ORDER],
            'Color' => ServiceMgr::$COLOR[ORDER],
        ];
    ServiceMgr::getInstance()->addAlert($params);

    error_log("[".date('d.m.Y H:i:s', time())."] "."Order payment success\n", 3, $logFile);

    // echo 'SUCCESS';
    error_log("SUCCESS\n", 3, $logFile);

    error_log("GENERATE INVETORY XML\n", 3, $logFile);
    error_log("================================\n", 3, $logFile);
    // set content-type
    $xmlInventory = $rk->getXmlInventory($order, $_GET);
    error_log($xmlInventory."\n", 3, $logFile);
    error_log("================================\n", 3, $logFile);
    header("Content-type: text/xml");
    echo $xmlInventory;

    exit;
