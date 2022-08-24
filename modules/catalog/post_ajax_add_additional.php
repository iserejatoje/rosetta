<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    // general
    $key = App::$Request->Post['key']->Value();
    $addid = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
    $catalogid = App::$City->CatalogId;

    list($productid, $curtypeid, $currenttime) = explode("_", base64_decode($key));

    $product = $this->catalogMgr->GetProduct($productid);
    if ($product === null ) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => ['product not found']
        ));
        exit;
    }
    $category = $product->category;

    $areaRefs = $product->GetAreaRefs($catalogid);
    if ($areaRefs['IsVisible'] == 0 ) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => ['product not found']
        ));
        exit;
    }

    $adds = [];
    $addition = $this->catalogMgr->GetAddition($addid);
    if($addition === null) {
        echo $json->encode([
            'status' => 'error',
        ]);
        exit;
    }

    $areaRefs = $addition->GetAreaRefs($catalogid);
    if($areaRefs['IsVisible'] == 0) {
        echo $json->encode([
            'status' => 'error',
        ]);
        exit;
    }

    $adds[$addid] = 1;

    $cart = $this->catalogMgr->GetCart();
    $item = $cart['items'][$key];
    $count = $item['count'];
    $additions = $item['additions'];

    foreach($additions as $additionid => $add_count) {
        if($additionid == $addid)
            $adds[$additionid] = $add_count + 1;
        else
            $adds[$additionid] = 1;
    }

    $options = [
        'key'         => $key,
        'productid'   => $productid,
        'curtypeid'   => $curtypeid,
        'currenttime' => $currenttime,
        'count'       => $count,
        'kind'        => $category->kind,
        'additions'   => $adds,
    ];

    $this->catalogMgr->UpdateCart($options);
    $cart = $this->catalogMgr->GetCart();

    echo $json->encode([
        'status' => 'ok',
        'action' => 'add_to_cart',
        'key' => $key,
        'cart' => STPL::Fetch('widgets/announce/general/cart', ['cart' => $cart]),
        'widget' => STPL::Fetch('widgets/announce/general/cart', [
            'cart' => $cart,
        ]),
    ]);
    exit;