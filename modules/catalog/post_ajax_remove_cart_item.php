<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $key = App::$Request->Post['key']->Value();
    $delivery_type = App::$Request->Post['delivery_type']->Int(0, Request::UNSIGNED_NUM);
    $delivery_district = App::$Request->Post['delivery_district']->Int(0, Request::UNSIGNED_NUM);
//    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

    $card_price = 0;
    foreach ($_POST['card_id'] as $post) {
        foreach ($post as $el) {
            $item = $this->catalogMgr->GetCard($el);
            if ($item !== null || $item->isvisible !== 0) {
                $card[] = $item;
                $card_price += $item->price;
            }
        }
    }


    list($productid, $typeid, $currenttime) = explode("_", base64_decode($key));

    $options = [
        'productid'   => $productid,
        'typeid'      => $typeid,
        'currenttime' => $currenttime,
    ];


    $this->catalogMgr->RemoveFromCart($options);

    $cart = $this->catalogMgr->GetCart();

    $default_district = $this->citiesMgr->GetDistrict($delivery_district);
    if($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();

    $total_price = $cart['sum']['total_price'];

    if (count($card) > 0) {
        foreach ($card as $post) {
            $total_price += $post->price;
        }
    }

    $card_available = false;
    if($total_price > $this->_config['discount_price'])
        $card_available = true;

    if($default_district)
        $total_price += $default_district->Price;

    $summary_count = count($cart['items']);

    echo $json->encode([
        'status' => 'ok',
        'action' => 'remove_item',
        'key' => $key,
        'count' => $summary_count,
        'cart_url' => '/catalog/order/cart',
        'content' => STPL::Fetch('modules/catalog/cart/_cart_content', [
            'cart' => $cart,
            'default_district' => $default_district,
            'card' => $card,
        ]),
        'widget' => STPL::Fetch("widgets/announce/general/cart", [
            'cart' => $cart,
            'more' => [
                $card_price,
            ]
        ]),
        'total_price' => $total_price,
        'card_available' => $card_available,
    ]);
    exit;