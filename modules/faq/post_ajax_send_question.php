<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();
    LibFactory::GetMStatic('service', 'servicemgr');

    $username = App::$Request->Post['customerQuestionName']->Value(Request::OUT_HTML_CLEAN);
    $email    = App::$Request->Post['customerQuestionMail']->Email(false);
    $phone    = App::$Request->Post['customerQuestionPhone']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerQuestionComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);

    $errors = [];
    $orderErrors = FaqMgr::$errors['form_request'];

    if (strlen($username) == 0)
        $errors['customerQuestionName'] = $orderErrors['customerName'];

    if ($email === false)
        $errors['customerQuestionMail'] = $orderErrors['customerEmail'];

    if (strlen($phone) == 0)
        $errors['customerQuestionPhone'] = $orderErrors['customerPhone'];

    if (strlen($text) == 0)
        $errors['customerQuestionComment'] = $orderErrors['questionText'];

    if (sizeof($errors)) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => $errors,
        ));
        exit;
    }

    $info = array(
        'Username'  => $username,
        'Question'  => $text,
        'Phone'     => $phone,
        'Email'     => $email,
        'IsVisible' => 0,
    );

    $question = new Question($info);
    $question->Update();

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', $this->_env['site']['domain'].". Вопрос", 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }
    $letter = "С сайта ".$this->_env['site']['domain']." задали вопрос.<br/>";
    $letter.= "Имя пользователя: ".$username."<br/>";
    $letter.= "Телефон пользователя: ".$phone."<br/>";
    $letter.= "Почта пользователя: ".$email."<br/>";
    $letter.= "Текст сообщения (вопрос):<br/>".$text."<br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('html', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    $params = [
        'SectionID' => App::$City->CatalogId,
        'Name' => ServiceMgr::$MESSAGE[FAQ],
        'Color' => ServiceMgr::$COLOR[FAQ],
    ];
    ServiceMgr::getInstance()->addAlert($params);

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;
