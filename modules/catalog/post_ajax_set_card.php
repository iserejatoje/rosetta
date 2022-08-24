<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);
    $delivery_type = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
    $district_id       = App::$Request->Post['district_id']->Int(0, Request::UNSIGNED_NUM);

    $card = $this->catalogMgr->GetCard($card_id);
    if($card_id > 0 && ($card == null || $card->isvisible == 0)) {
         echo $json->encode(array(
            'status' => 'error',
            'errors' => ['card not found']
        ));
        exit;
    }

    $cart = $this->catalogMgr->GetCart();

    $delivery_price = 0;
    if($delivery_type == CatalogMgr::DT_DELIVERY) {
        $default_district = $this->citiesMgr->GetDistrict($district_id);
        if($default_district === null || $default_district->IsAvailable == 0)
            $default_district = App::$City->GetDefaultDistrict();

        $delivery_price = $default_district->Price;
    }


    $total_price = $cart['sum']['total_price'];
    if($card)
        $total_price += $card->price;

    $card_available = false;
    if($total_price > $this->_config['discount_price'])
        $card_available = true;

    if($default_district)
        $total_price += $delivery_price;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'set_card',
        'key' => $add_key,
        'content' => STPL::Fetch('modules/catalog/cart/_cart_content', [
            'cart' => $cart,
            'default_district' => $default_district,
            'delivery_type' => $delivery_type,
            'card' => $card,
        ]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
            'more' => [
                $card->price,
            ]
        ]),
        'total_price' => $total_price,
        'card_available' => $card_available,
    ));

    exit;
