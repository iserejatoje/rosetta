<?
    include_once $CONFIG['engine_path'].'include/json.php';
    include_once $CONFIG['engine_path'].'include/osgallery/osgallerymgr.php';
    $json = new Services_JSON();

    LibFactory::GetMStatic('service', 'servicemgr');

    $section  = App::$Request->Post['section']->Value(Request::OUT_HTML_CLEAN);
    $username = App::$Request->Post['customerOfferName']->Value(Request::OUT_HTML_CLEAN);
    // $email    = App::$Request->Post['customerOfferMail']->Email(false);
    // $phone    = App::$Request->Post['customerOfferPhone']->Value(Request::OUT_HTML_CLEAN);
    $contact    = App::$Request->Post['customerOfferContact']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerOfferComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
    $date     = App::$Request->Post['customerOfferDate']->Value();

    $errors = [];
    $orderErrors = OSGalleryMgr::$errors['offer'];

    if($date) {
        list($day, $month, $year) = explode('.', $date);
        if(!checkdate($month, $day, $year) || strtotime($date) < time())
            $errors['customerOfferDate'] = $orderErrors['invalidDate'];
    }

    if (strlen($username) == 0)
        $errors['customerOfferName'] = $orderErrors['customerName'];

    // if ($email === false)
    //     $errors['customerOfferMail'] = $orderErrors['customerEmail'];

    // if (strlen($phone) == 0)
    //     $errors['customerOfferPhone'] = $orderErrors['customerPhone'];

    if (!$contact)
        $errors['customerOfferContact'] = $orderErrors['customerContact'];

    if (strlen($text) == 0)
        $errors['customerOfferComment'] = $orderErrors['Text'];

    if (sizeof($errors)) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => $errors,
        ));
        exit;
    }

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', $this->_env['site']['domain']." заказ услуги \"".$section."\" ", 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." поступил заказ на услугу \"".$section."\".<br/>";
    if($date != '') {
        $letter.= "Дата выполнения услуги ".$date."<br/>";
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
        'Name' => ServiceMgr::$MESSAGE[SERVICE].$section.'!',
        'Color' => ServiceMgr::$COLOR[SERVICE],
    ];
    ServiceMgr::getInstance()->addAlert($params);

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;