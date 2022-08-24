<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    LibFactory::GetMStatic('service', 'servicemgr');

    $username = App::$Request->Post['customerOfferName']->Value(Request::OUT_HTML_CLEAN);
    $email    = App::$Request->Post['customerOfferEmail']->Email(false);
    $phone    = App::$Request->Post['customerOfferPhone']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerOfferComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
    // $date     = App::$Request->Post['customerOfferDate']->Value();

    $errors = [];
    $orderErrors = BlockMgr::$errors['form_request'];

    if(isset($date)) {
        list($day, $month, $year) = explode('.', $date);
        if(!checkdate($month, $day, $year) || strtotime($date) < time())
            $errors['invalidDate'] = $orderErrors['invalidDate'];
    }

    if (strlen($username) == 0)
        $errors['customerOfferName'] = $orderErrors['customerName'];

    if ($email === false)
        $errors['customerOfferEmail'] = $orderErrors['customerEmail'];

    if (strlen($phone) == 0)
        $errors['customerOfferPhone'] = $orderErrors['customerPhone'];

    if (strlen($text) == 0)
        $errors['customerOfferComment'] = $orderErrors['wishText'];

    if (sizeof($errors)) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => $errors,
        ));
        exit;
    }


    // LibFactory::GetStatic('mailsender');
    // $mail = new MailSender();
    // $mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">");
    // $mail->AddHeader('Subject', "Заявка на оформление корпоративного букета на сайте ".$this->_env['site']['domain'], 'utf-8');
    // $mail->body_type = MailSender::BT_HTML;

    // $bl = BLFactory::GetInstance('system/config');
    // $config = $bl->LoadConfig('module_engine', 'catalog');

    // foreach($config['review_emails'] as $review_email)
    // {
    //     $mail->AddAddress('to', $review_email);
    // }

    // $letter = "С сайта ".$this->_env['site']['domain']." поступила заявка на корпоративный букет.<br/>";
    // $letter.= "Его оставил пользователь с именем ".$username."<br/>";
    // $letter.= "Электронная почта: ".$email."<br/>";
    // $letter.= "Телефон: ".$phone."<br/>";
    // $letter.= "На дату: ".$date."<br/>";
    // $letter.= "Пожелания:<br/>".$text."<br/><br/>";
    // $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    // $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    // $mail->SendImmediate();

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', "Служба уведомлений ".$this->_env['site']['domain']." <mailer@".$this->_env['site']['domain'].">", null, "utf-8");
    $mail->AddHeader('Subject', $this->_env['site']['domain']." заказ услуги \"Обслуживание корпоративных клиентов\" ", 'utf-8');

    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." поступил заказ на услугу \"Обслуживание корпоративных клиентов\".<br/>";
    if($date != '') {
        $letter.= "Дата выполнения услуги ".$date."<br/>";
    }
    $letter.= "Имя пользователя: ".$username."<br/>";
    $letter.= "Телефон пользователя: ".$phone."<br/>";
    $letter.= "Почта пользователя: ".$email."<br/>";
    $letter.= "Текст сообщения (пожелания):<br/>".$text."<br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";


    $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

     $params = [
        'SectionID' => App::$City->CatalogId,
        'Name' => ServiceMgr::$MESSAGE[CORPORATE_CUSTOMERS],
        'Color' => ServiceMgr::$COLOR[CORPORATE_CUSTOMERS],
    ];
    ServiceMgr::getInstance()->addAlert($params);

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;
