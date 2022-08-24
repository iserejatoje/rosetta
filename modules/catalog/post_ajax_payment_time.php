<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    

    $params['type']             = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    
    $params['delivery']['date'] = App::$Request->Post['delivery_date']->Datestamp();
    $params['delivery']['from'] = App::$Request->Post['time-delivery-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    $params['delivery']['to']   = App::$Request->Post['time-delivery-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    
    $params['pickup']['date']   = App::$Request->Post['pickup_date']->Datestamp();
    $params['pickup']['from']   = App::$Request->Post['time-pickup-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    $params['pickup']['to']     = App::$Request->Post['time-pickup-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    
    $payment_time = $this->get_payment_time($params);
    
    // добавление ошибки дисконтной карты
    include_once $CONFIG['engine_path'].'include/catalog/CartTrying.php';
    $cart = $this->catalogMgr->GetCart();
    $trying = new CartTrying($cart['cart_code']);
    if(!$trying->can()) {
        $payment_time['errors']['discountcard'] = $trying->getMessage();
    }

    echo $json->encode(['payment_time' => $payment_time]);
    exit;