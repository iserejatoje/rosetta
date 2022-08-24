<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $section  = App::$Request->Post['section']->Value(Request::OUT_HTML_CLEAN);
    $username = App::$Request->Post['customerOfferName']->Value(Request::OUT_HTML_CLEAN);
    $email    = App::$Request->Post['customerOfferMail']->Email(false);
    $phone    = App::$Request->Post['customerOfferPhone']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerOfferComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
    $date     = App::$Request->Post['customerOfferDate']->Value();

    $errors = [];
    $orderErrors = OSGalleryMgr::$errors['offer'];

    if(isset($date)) {
        list($day, $month, $year) = explode('.', $date);
        if(!checkdate($month, $day, $year) || strtotime($date) < time())
            $errors['invalidDate'] = $orderErrors['invalidDate'];
    }

    if (strlen($username) == 0)
        $errors['customerName'] = $orderErrors['customerName'];

    if ($email === false)
        $errors['customerEmail'] = $orderErrors['customerEmail'];

    if (strlen($phone) == 0)
        $errors['customerPhone'] = $orderErrors['customerPhone'];

    if (strlen($text) == 0)
        $errors['Text'] = $orderErrors['Text'];

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
    $mail->AddHeader('Subject', "Заявка букета на сайте ".$this->_env['site']['domain'], 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." поступила заявка на букет из раздела \"".$section."\".<br/>";
    $letter.= "Его оставил пользователь с именем ".$username."<br/>";
    $letter.= "Электронная почта: ".$email."<br/>";
    $letter.= "Телефон: ".$phone."<br/>";
    $letter.= "Пожелания:<br/>".$text."<br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;