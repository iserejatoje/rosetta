<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $delivery_date = App::$Request->Post['delivery_date']->Value();


    // $deliveryDate = new DateTime($delivery_date);
    // $today = new DateTime('now');

    // $diff = $today->diff($deliveryDate);

    $in_mode = $this->catalogMgr->InMode($delivery_date);
    if($in_mode === false) {
        $text = $this->_config['cart_noorder_text'];
        $orderErrors = CatalogMgr::$errors['order'];
        $errors['delivery_date'] = $orderErrors['invalidDate'];
    }

    $delivery_date .= ' '.date("H:i:s", time());
    // $delivery_date = "16.01.2016 14:29:00";
    $time_delivery = CatalogMgr::TimeRangeDelivery($delivery_date);


    if($time_delivery['from']['timestamp'] >= $time_delivery['to']['timestamp']) {
        $today = date('d.m.Y', strtotime("+1 day"));
        $datetime = $today." 00:00:00";
        $time_delivery = CatalogMgr::TimeRangeDelivery($datetime);
        $noorder_text = ['message' => 'Сегодня доставка заказа уже не возможна.<br/>Вы можете оформить доставку заказа на завтра.<br/><br/>'];
        $time_out_range = true;
    }
    // вернуть time range работы магазин
    // вернуть сообщение, если в указанный день заказы не принимаются.


    // до какого времени нужно оплатить
    $params['type']             = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    
    $params['delivery']['date'] = App::$Request->Post['delivery_date']->Datestamp();
    $params['delivery']['from'] = $time_delivery['from']['hours'];
    $params['delivery']['to']   = $time_delivery['to']['hours'];
    
    $payment_time = $this->get_payment_time($params);

    $cart = $this->catalogMgr->GetCart();
    // добавление ошибки дисконтной карты
    include_once $CONFIG['engine_path'].'include/catalog/CartTrying.php';
    $trying = new CartTrying($cart['cart_code']);
    if(!$trying->can()) {
        $errors['discountcard'] = $trying->getMessage();
    }

    /* определяем шаг слайдера времени доставки. */
    /* по-умолчанию равен 1 час (3600), но его можно изменить с админки для конкретной даты. */
    /* аргумент - дата в формате дд.мм */
    $minStep = $this->catalogMgr->getDeliveryStep(substr($delivery_date, 0, 5));

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'change_date',
        'in_mode' => $in_mode,
        'time_delivery' => $time_delivery,
        'message' => STPL::Fetch('modules/catalog/cart/_noorder_message', [
            'text' => $text,
        ]),
        'time_slider' => STPL::Fetch('modules/catalog/cart/_time_slider', [
            'from' => $time_delivery['from']['sec'],
            'to' => $time_delivery['to']['sec'],
            'errors' => $errors,
            'payment_time' => $payment_time,
            'minStep' => $minStep,

        ]),
        'cart' => STPL::Fetch('widgets/announce/general/cart', ['cart' => $cart]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
        ]),
        'pickup_today' => $today,
        'errors' => $errors,


    ));
    exit;
