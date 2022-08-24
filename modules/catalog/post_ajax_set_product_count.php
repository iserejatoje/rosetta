<?php
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $key = App::$Request->Post['key']->Value();
    $counts = App::$Request->Post['count']->AsArray();
    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);
    $delivery_type = App::$Request->Post['delivery_type']->Int(0, Request::UNSIGNED_NUM);
    $delivery_district = App::$Request->Post['delivery_district']->Int(0, Request::UNSIGNED_NUM);
    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

    $card = $this->catalogMgr->GetCard($card_id);

    list($productid, $curtypeid, $currenttime) = explode("_", base64_decode($key));
    $count = $counts[$key];

    $product = $this->catalogMgr->GetProduct($productid);
    $category = $product->category;

    if ($product === null ) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => ['product not found']
        ));
        exit;
    }

    $options = [
        'key'         => $key,
        'productid'   => $productid,
        'curtypeid'   => $curtypeid,
        'currenttime' => $currenttime,
        'typeid'      => $typeid,
        'count'       => $count,
        'kind'        => $category->kind,
        // 'typeid'      => $typeid,
        'card_type'   => $card_type,
        'card_text'   => $card_type > 0 ? $card_text : '',
        'additions'   => $adds,
    ];

    $params = [];
    if($category->kind == CatalogMgr::CK_ROSE)
    {
        $length = $this->catalogMgr->GetLen($lengthid);
        if($length !== null) {
            $params['lengthid']    = $lengthid;
            $params['length']      = $length->Len;
            $params['roses_count'] = $roses_count;
        }
    }

    $this->catalogMgr->UpdateCart($options);
    $cart = $this->catalogMgr->GetCart();

    $default_district = $this->citiesMgr->GetDistrict($delivery_district);
    if($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();

    $total_price = $cart['sum']['total_price'];
    if($card)
        $total_price += $card->price + (3000*200);

    $card_available = false;
    if($total_price > $this->_config['discount_price'])
        $card_available = true;

    if($default_district)
        $total_price += $default_district->Price;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'set_count',
        'key' => $key,
        'errors' => [],
        'item' => STPL::Fetch('modules/catalog/cart/_cart_item', [
            'cart_items' => $cart['items'],
            'item' => $cart['items'][$key],
            'key' => $key,
            'category' => $product->category,
        ]),
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
