<?
	include_once $CONFIG['engine_path'].'include/json.php';

    $json = new Services_JSON();

    $delivery_type = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    $delivery_district = App::$Request->Post['district_id']->Int(0, Request::UNSIGNED_NUM);
    // $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);


    $params['type']             = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    
    $params['delivery']['date'] = App::$Request->Post['delivery_date']->Datestamp();
    $params['delivery']['from'] = App::$Request->Post['time-delivery-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    $params['delivery']['to']   = App::$Request->Post['time-delivery-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    
    $params['pickup']['date']   = App::$Request->Post['pickup_date']->Datestamp();
    $params['pickup']['from']   = App::$Request->Post['time-pickup-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    $params['pickup']['to']     = App::$Request->Post['time-pickup-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
    
    $payment_time = $this->get_payment_time($params);

    $card = array();
    foreach ($_POST['card_id'] as $post) {
        foreach ($post as $el) {
            $item = $this->catalogMgr->GetCard($el);
            if ($item !== null || $item->isvisible !== 0) {
                $card[] = $item;
            }
        }
    }

    $cart = $this->catalogMgr->GetCart();

    // js убирает все ошибки на форме, когда получает ответ из этого контроллера.
    // нужно оставить ошибку об использованных попытках ввода карты.
    include_once $CONFIG['engine_path'].'include/catalog/CartTrying.php';
    $trying = new CartTrying($cart['cart_code']);
    if(!$trying->can()) {
        $payment_time['errors']['discountcard'] = $trying->getMessage();
    }

    if($delivery_type == CatalogMgr::DT_DELIVERY) {
    	$default_district = $this->citiesMgr->GetDistrict($delivery_district);
	    if($default_district === null || $default_district->IsAvailable == 0)
	        $default_district = App::$City->GetDefaultDistrict();
    } else {
    	$default_district = null;
    }

    $total_price = $cart['sum']['total_price'];

    $card_price = 0;

    if (count($card) > 0) {
        foreach ($card as $post) {
            $total_price += $post->price;
            $card_price += $post->price;
        }
    }

    if($default_district)
        $total_price += $default_district->Price;

    echo $json->encode(array(
        'status' => 'ok',
	    'action' => 'delivery_type',
        'content' => STPL::Fetch('modules/catalog/cart/_cart_content', [
            'cart' => $cart,
            'default_district' => $default_district,
            'delivery_type' => $delivery_type,
            'card' => $card,
        ]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
            'more' => [
                $card_price,
            ]
        ]),
        'total_price' => $total_price,
        'payment_time' => $payment_time, 
        
    ));
    exit;