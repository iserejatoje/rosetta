<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $username = App::$Request->Post['customerOfferName']->Value(Request::OUT_HTML_CLEAN);
    $email    = App::$Request->Post['customerOfferMail']->Email(false);
    $phone    = App::$Request->Post['customerOfferPhone']->Value(Request::OUT_HTML_CLEAN);
    $text     = App::$Request->Post['customerOfferComment']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
    $date     = App::$Request->Post['customerOfferDate']->Value();

    if (strlen($username) == 0)
        UserError::AddErrorIndexed('customerQuestionName', ERR_M_QUESTION_EMPTY_AUTHOR);

    if (App::$Request->Post['Email']->Value() != "" && $Email === false)
        UserError::AddErrorIndexed('customerQuestionMail', ERR_M_QUESTION_INCORRECT_EMAIL);

    if (strlen($phone) == 0)
        UserError::AddErrorIndexed('customerQuestionPhone', ERR_M_QUESTION_EMPTY_PHONE);

    if (strlen($text) == 0)
        UserError::AddErrorIndexed('customerQuestionComment', ERR_M_QUESTION_EMPTY_TEXT);

    if(UserError::IsError())
    {
        echo $json->encode(array(
                'status' => 'error',
                'errors' => UserError::GetErrorsTextWithoutAnchor("\n"),
            ));

        exit;
    }

    LibFactory::GetStatic('mailsender');
    $mail = new MailSender();
    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', "Заявка на оформление корпоративного букета на сайте ".$this->_env['site']['domain'], 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." поступила заявка на корпоративный букет.<br/>";
    $letter.= "Его оставил пользователь с именем ".$username."<br/>";
    $letter.= "Электронная почта: ".$email."<br/>";
    $letter.= "Телефон: ".$phone."<br/>";
    $letter.= "На дату: ".$date."<br/>";
    $letter.= "Пожелания:<br/>".$text."<br/><br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    echo $json->encode(array(
        'status' => 'ok',
    ));

    exit;
