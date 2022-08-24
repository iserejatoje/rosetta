<?
    include_once $CONFIG['engine_path'].'include/catalog/CartTrying.php';
    // LibFactory::GetStatic('sms');
    // $sms = new SMS();
    // $result = $sms->send('+7-(950)-741-7692', 'Проверка работы смс');
    // var_dump($result); exit;

    // for ($i=0; $i < 20; $i++) {
    //     $card = $this->catalogMgr->GenerateDiscountCard();
    //     $card->orderid = 0;
    //     $card->isactive = 1;
    //     $card->update();
    // }

    App::$Title->Title = 'Корзина';

    $cart = $this->catalogMgr->GetCart();

    if(count($cart['items']) == 0) {
        return STPL::Fetch('modules/catalog/empty_cart');
    }

    if(App::$Request->requestMethod === Request::M_POST) {
        $form['firstname']  = App::$Request->Post['firstname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
        $form['middlename'] = App::$Request->Post['middlename']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
        $form['phone']      = App::$Request->Post['phone']->Phone();
        $form['address']    = App::$Request->Post['address']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
        $form['date']       = App::$Request->Post['date']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
        $form['time']       = App::$Request->Post['time']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
        $form['comment']    = App::$Request->Post['comment']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    } else {
        $form['firstname'] = '';
        $form['middlename'] = '';
        $form['phone'] = '';
        $form['address'] = '';
        $form['date'] = '';
        $form['time'] = '';
        $form['comment'] = '';
    }

    $filter = array(
        'flags' => array(
            'objects' => true,
            'IsVisible' => -1,
            'CatalogID' => App::$City->CatalogId,
        ),
        'dbg' => 0,
    );

    $cards = $this->catalogMgr->GetCards($filter);

    $filter = [
        'flags' => [
            'objects' => true,
            'CityID' => App::$City->ID,
            'IsAvailable' => 1,
        ],
        'field' => ['ord'],
        'dir' => ['ASC'],
    ];

    $districts = $this->citiesMgr->GetDistricts($filter);

    $filter = [
        'flags' => [
            'objects' => true,
            'CityID' => App::$City->ID,
            'HasPickup' => 1,
        ],
        'field' => ['ord'],
        'dir' => ['ASC'],
    ];
    $stores = $this->citiesMgr->GetStores($filter);

    $payment_types = $this->paymentMgr->GetPaymentTypes();

    // $today = date('d.m.Y', time());

    // отрефакторить этот код.
    $noorder_text = ['message' => ''];
    $time_out_range = false;
    $today = $pickup_today = date('d.m.Y', time());
    $datetime = date("d.m.Y H:i:s", time());

    // $today = '21.01.2016';
    // $datetime = '21.01.2016 00:15:00';

    // REFACTORING
    $time_delivery = CatalogMgr::TimeRangeDelivery($datetime);

    if($time_delivery['from']['timestamp'] >= $time_delivery['to']['timestamp']) {
        $today = date('d.m.Y', strtotime("+1 day"));
// $today = '21.01.2016';
        while(!CatalogMgr::isWorkingDay($today)) {
            $today = strtotime($today." + 1 day");
            $today = date('d.m.Y', $today);
        }
        $datetime_n = $today." 00:00:00";
        $time_delivery = CatalogMgr::TimeRangeDelivery($datetime_n);

        $noorder_text = ['message' => 'Сегодня (' .date("d.m.Y", time()). ') доставка заказа уже не возможна.<br/><br/><br/><br/>']; //Вы можете оформить доставку заказа на завтра.
        $time_out_range = true;
    }

    $time_pickup = CatalogMgr::TimeRangePickup($datetime);

// time_pickup неправильный!!!! в Кемерово 18:26. Доставка с 9 до 22, магазин работает с 8 до 21


    if($time_pickup['from']['timestamp'] >= $time_pickup['to']['timestamp']) {
    // if($time_pickup === false) {
        $pickup_today = date('d.m.Y', strtotime("+1 day"));
        while(!CatalogMgr::isWorkingDay($pickup_today)) {
            $pickup_today = strtotime($pickup_today." + 1 day");
            $pickup_today = date('d.m.Y', $pickup_today);
        }

        $datetime_p = $pickup_today." 00:00:00";
        $time_pickup = CatalogMgr::TimeRangePickup($datetime_p);
        $noorder_text_pickup = ['message' => 'Сегодня (' .date("d.m.Y", time()). ') оформить заказ уже нельзя.<br/><br><br>']; //<br/>Вы можете оформить заказ на завтра.<br/>
        $time_out_range_pickup = true;
    }



    $in_mode = $this->catalogMgr->InMode($today);
    $noorder_text = $in_mode == false ? $this->_config['cart_noorder_text'] : $noorder_text;

    /* определяем шаг слайдера времени доставки. */
    /* по-умолчанию равен 1 час (3600), но его можно изменить с админки для конкретной даты. */
    /* аргумент - дата в формате дд.мм */
    $minStep = $this->catalogMgr->getDeliveryStep(substr($today, 0, 5));

    return STPL::Fetch('modules/catalog/cart', array(
        'cart'                  => $cart,
        'form'                  => $form,
        'cards'                 => $cards,
        'districts'             => $districts,
        'time_delivery'         => $time_delivery,
        'time_pickup'           => $time_pickup,
        'stores'                => $stores,
        'today'                 => $today,
        'pickup_today'          => $pickup_today,
        'payment_types'         => $payment_types,
        'default_district'      => App::$City->GetDefaultDistrict(),
        'in_mode'               => $in_mode,
        'noorder_text'          => $noorder_text,
        'noorder_text_pickup'   => $noorder_text_pickup,
        'time_out_range'        => $time_out_range,
        'time_out_range_pickup' => $time_out_range_pickup,
        'discount_price'        => $this->_config['discount_price'],
        'payment_time'          => CatalogMgr::getPaymentTime($today, $time_delivery['from']['hours']),
        'daysPeriod'            => $this->_config['days_period'],
        'isCallbackShowed'      => $this->_config['correction_call'],
        'trying' => new CartTrying($cart['cart_code']),
        'minStep' => $minStep,
    ));