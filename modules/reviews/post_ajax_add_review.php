<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    LibFactory::GetMStatic('service', 'servicemgr');

    $username = App::$Request->Post['customerReviewName']->Value(Request::OUT_HTML_CLEAN);
    $email    = App::$Request->Post['customerReviewMail']->Email(false);
    $phone    = App::$Request->Post['customerReviewPhone']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerReviewComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

    $errors = [];
    $orderErrors = ReviewMgr::$errors['form_request'];

    if (strlen($username) == 0)
        $errors['customerReviewName'] = $orderErrors['customerName'];

    if ($email === false)
        $errors['customerReviewMail'] = $orderErrors['customerEmail'];

    if (strlen($phone) == 0)
        $errors['customerReviewPhone'] = $orderErrors['customerPhone'];

    if (strlen($text) == 0)
        $errors['customerReviewComment'] = $orderErrors['reviewText'];

    if (sizeof($errors)) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => $errors,
        ));
        exit;
    }

    if(UserError::IsError())
    {
        echo $json->encode(array(
                'status' => 'error',
                'errors' => UserError::GetErrorsTextWithoutAnchor("\n"),
            ));

        exit;
    }

    $info = array(
        'Username'  => $username,
        'Text'      => $text,
        'Phone'     => $phone,
        'Email'     => $email,
        'IsVisible' => 0,
    );

    $review = new Review($info);
    $review->Update();

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');

    $mail->AddHeader('Subject', $this->_env['site']['domain']. " Отзыв ", 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');
    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." поступил отзыв.<br/>";
    $letter.= "Имя пользователя: ".$username."<br/>";
    $letter.= "Телефон пользователя: ".$phone."<br/>";
    $letter.= "Почта пользователя: ".$email."<br/>";
    $letter.= "Текст сообщения (отзыв):<br/>".$text."<br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    $params = [
        'SectionID' => App::$City->CatalogId,
        'Name' => ServiceMgr::$MESSAGE[REVIEW],
        'Color' => ServiceMgr::$COLOR[REVIEW],
    ];
    ServiceMgr::getInstance()->addAlert($params);

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;
