<?

    include_once $CONFIG['engine_path'].'include/json.php';

    $json = new Services_JSON();



    LibFactory::GetMStatic('service', 'servicemgr');



    $customer_name  = App::$Request->Post['letter_name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);
    $customer_email = App::$Request->Post['letter_email']->Email();
    $customer_message = App::$Request->Post['letter_text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);


    $headers  = "Content-type: text/html; charset=utf-8 \r\n";



    // $mail_to = "admin@rosetta.ru";



    // $msg = "Контактные данные клиента: \r\n<br/>";

    // $msg .= "Имя: ".$customer_name."\r\n<br/>";

    // $msg .= "Email: ".$customer_email."\r\n<br/>";

    // $msg .= "Сообщение: \r\n<br/>";

    // $msg .= $customer_message;



    LibFactory::GetStatic('mailsender');

    $mail = new MailSender();

    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', $this->_env['site']['domain'].". Письмо.", 'utf-8');
    $mail->body_type = MailSender::BT_HTML;



    $bl = BLFactory::GetInstance('system/config');

    $config = $bl->LoadConfig('module_engine', 'catalog');



    foreach($config['review_emails'] as $review_email)

    {

        $mail->AddAddress('to', $review_email);

    }

    $letter = "С сайта ".$this->_env['site']['domain']." написали письмо.<br/>";

    $letter.= "Имя пользователя: ".$customer_name."<br/>";

    $letter.= "Почта пользователя: ".$customer_email."<br/>";

    $letter.= "Текст сообщения:<br/>".$customer_message."<br/><br/>";

    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";



    $mail->AddBody('html', $letter, MailSender::BT_HTML, 'utf-8');

    $mail->SendImmediate();



    $params = [

        'SectionID' => App::$City->CatalogId,

        'Name' => ServiceMgr::$MESSAGE[FEEDBACK],

        'Color' => ServiceMgr::$COLOR[FEEDBACK],

    ];



    ServiceMgr::getInstance()->addAlert($params);



    echo $json->encode(array(

        'status' => 'ok',

    ));



    exit;



    // if( mail( $mail_to, 'Отзыв из сайта ROSETTA', $msg, $headers) ) {



    //     $params = [

    //         'SectionID' => App::$City->CatalogId,

    //         'Name' => ServiceMgr::$MESSAGE[FEEDBACK],

    //         'Color' => ServiceMgr::$COLOR[FEEDBACK],

    //     ];

    //     ServiceMgr::getInstance()->addAlert($params);



    //     echo $json->encode(array(

    //         'status' => 'ok',

    //     ));

    // } else {

    //     echo $json->encode(array(

    //         'status' => 'error',

    //     ));

    // }



    exit;