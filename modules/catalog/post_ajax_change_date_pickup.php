<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $pickup_date = App::$Request->Post['pickup_date']->Value();

    $text = '';
    $in_mode = $this->catalogMgr->InMode($pickup_date);

    if($in_mode === false) {
        $text = $this->_config['cart_noorder_text'];
        $orderErrors = CatalogMgr::$errors['order'];
        $errors['pickup_date'] = $orderErrors['invalidDate'];
    }



    $pickup_date .= ' '.date("H:i:s", time());
    $time_pickup = CatalogMgr::TimeRangePickup($pickup_date);

    if($time_pickup['from']['timestamp'] >= $time_pickup['to']['timestamp']) {
        $today = date('d.m.Y', strtotime("+1 day"));
        $datetime = $today." 00:00:00";
        $time_pickup = CatalogMgr::TimeRangePickup($datetime);
        $text = ['message' => 'Сегодня самовывоз заказа уже не возможен.<br/>Вы можете оформить заказ на завтра.<br/><br/>'];
        $time_out_range = true;
    }
    // вернуть time range работы магазин
    // вернуть сообщение, если в указанный день заказы не принимаются.


    //до какого времени нужно оплатить
    $params['type']             = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    
    $params['pickup']['date'] = App::$Request->Post['pickup_date']->Datestamp();
    $params['pickup']['from'] = $time_pickup['from']['hours'];
    $params['pickup']['to']   = $time_pickup['to']['hours'];
    
    $payment_time = $this->get_payment_time($params);

    $cart = $this->catalogMgr->GetCart();
    // добавление ошибки дисконтной карты
    include_once $CONFIG['engine_path'].'include/catalog/CartTrying.php';
    $trying = new CartTrying($cart['cart_code']);
    if(!$trying->can()) {
        $errors['discountcard'] = $trying->getMessage();
    }

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'change_date_pickup',
        'in_mode' => $in_mode,
        'time_pickup' => $time_pickup,
        'message' => STPL::Fetch('modules/catalog/cart/_noorder_message', [
            'text' => $text,
        ]),
        'time_slider_pickup' => STPL::Fetch('modules/catalog/cart/_time_slider_pickup', [
            'from' => $time_pickup['from']['sec'],
            'to' => $time_pickup['to']['sec'],
            'payment_time' => $payment_time,
            'errors' => $errors,
        ]),

        'cart' => STPL::Fetch('widgets/announce/general/cart', ['cart' => $cart]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
        ]),

        'errors' => $errors,

    ));
    exit;

