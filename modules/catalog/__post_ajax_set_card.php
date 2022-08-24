<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

    $card = $this->catalogMgr->GetCard($card_id);
    if($card_id > 0 && ($card == null || $card->isvisible == 0)) {
         echo $json->encode(array(
            'status' => 'error',
            'errors' => ['card not found']
        ));
        exit;
    }

    $cart = $this->catalogMgr->GetCart();

    $default_district = $this->citiesMgr->GetDistrict($delivery_district);
    if($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();

    $total_price = $cart['sum']['total_price'];
    if($card)
        $total_price += $card->price;

    $card_available = false;
    if($total_price > $this->_config['discount_price'])
        $card_available = true;

    if($default_district)
        $total_price += $default_district->Price;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'set_card',
        'key' => $add_key,
        'content' => STPL::Fetch('modules/catalog/cart/_cart_content', [
            'cart' => $cart,
            'default_district' => $default_district,
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
