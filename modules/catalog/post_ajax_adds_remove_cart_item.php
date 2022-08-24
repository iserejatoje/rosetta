<?
	include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

	$add_key = App::$Request->Post['key']->Value();
    // $counts = App::$Request->Post['adds_count']->AsArray();
    $counts = App::$Request->Post['count']->AsArray();

    // $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

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

    list($key, $addid) = explode("_", $add_key);
    list($productid, $curtypeid, $currenttime) = explode("_", base64_decode($key));

    $product = $this->catalogMgr->GetProduct($productid);
    $category = $product->category;

    if ($product === null ) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => ['product not found']
        ));
        exit;
    }

    $cart = $this->catalogMgr->GetCart();
    $additions = $cart['items'][$key]['additions'];

    $catalogid = App::$City->CatalogId;

    $adds = [];
    foreach($additions as $additionid => $item)
    {
        $addition = $this->catalogMgr->GetAddition($additionid);
        if($addition === null)
            continue;

        if($additionid == $addid)
        	continue;

        $areaRefs = $addition->GetAreaRefs($catalogid);
        if($areaRefs['IsVisible'] == 0)
            continue;


    	$adds[$additionid] = $item['count'];
    }

    $count = $counts[$key];
    $options = [
        'key'         => $key,
        'productid'   => $productid,
        'curtypeid'   => $curtypeid,
        'currenttime' => $currenttime,
        'count'       => $count,
        'kind'        => $category->kind,
        // 'typeid'      => $typeid,
        'additions'   => $adds,
    ];

    $this->catalogMgr->UpdateCart($options);

    $cart = $this->catalogMgr->GetCart();
    $additions = $cart['items'][$key]['additions'];

    $default_district = $this->citiesMgr->GetDistrict($delivery_district);
    if($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();

    $total_price = $cart['sum']['total_price'];

    foreach ($card as $post) {
        $total_price += $post->price;
    }

    $card_available = false;
    if($total_price > $this->_config['discount_price'])
        $card_available = true;

    if($default_district)
        $total_price += $default_district->Price;

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'remove_adds',
        'key' => $add_key,
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
        'card_available' => $card_available ,
    ));

    exit;