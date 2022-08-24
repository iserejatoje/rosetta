<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $district_id = App::$Request->Post['district_id']->Int(0, Request::UNSIGNED_NUM);
    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

    $card = $this->catalogMgr->GetCard($card_id);

    $cart = $this->catalogMgr->GetCart();

    $default_district = $this->citiesMgr->GetDistrict($district_id);

    if($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();

    $total_price = $cart['sum']['total_price'];
    if($card)
        $total_price += $card->price;

    if($default_district)
        $total_price += $default_district->Price;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'delivery_district',
        'delivery_price' => $default_district->Price,
        'content' => STPL::Fetch('modules/catalog/cart/_cart_content', [
            'cart' => $cart,
            'default_district' => $default_district,
            'delivery_type' => CatalogMgr::DT_DELIVERY,
            'card' => $card,
        ]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
        ]),
        'total_price' => $total_price,
    ));
    exit;