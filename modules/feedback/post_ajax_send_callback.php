<?

    include_once $CONFIG['engine_path'].'include/json.php';

    $json = new Services_JSON();



    LibFactory::GetMStatic('service', 'servicemgr');



    $customer_name  = App::$Request->Post['callback_name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);

    $customer_phone = App::$Request->Post['callback-phone']->Value();



    $message =  'Заявка на звонок: '.$customer_phone.' ('.$customer_name.')';



    LibFactory::GetStatic('mailsender');

    $mail = new MailSender();
    $mail->AddAddress('from', ROSETTA_EMAIL, "Служба уведомлений", 'utf-8');
    $mail->AddHeader('Subject', $this->_env['site']['domain'].". Заказ звонка.", 'utf-8');
    $mail->body_type = MailSender::BT_HTML;

    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');


    foreach($config['review_emails'] as $review_email)
    {
        $mail->AddAddress('to', $review_email);
    }

    $letter = "С сайта ".$this->_env['site']['domain']." заказали звонок.<br/>";
    $letter.= "Имя пользователя: ".$customer_name."<br/>";
    $letter.= "Телефон пользователя: ".$customer_phone."<br/>";
    $letter.= "--<br/>Служба уведомлений ".$this->_env['site']['domain']."<br/>";

    $mail->AddBody('html', $letter, MailSender::BT_HTML, 'utf-8');
    $mail->SendImmediate();

    $params = [
        'SectionID' => App::$City->CatalogId,
        'Name' => ServiceMgr::$MESSAGE[CALLBACK],
        'Color' => ServiceMgr::$COLOR[CALLBACK],
    ];

    ServiceMgr::getInstance()->addAlert($params);

    echo $json->encode(array(

        'status' => 'ok',

    ));



    exit;



    // $headers  = "Content-type: text/html; charset=utf-8 \r\n";



    // $mail_to = "admin@rosetta.ru";





    // if( mail($mail_to, 'ROSETTA', $message, $headers) ) {





    //     $params = [

    //         'SectionID' => App::$City->CatalogId,

    //         'Name' => ServiceMgr::$MESSAGE[CALLBACK],

    //         'Color' => ServiceMgr::$COLOR[CALLBACK],

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