<?php

include_once $CONFIG['engine_path'].'include/json.php';
$json = new Services_JSON();

// general
$count = App::$Request->Post['count']->Int(1, Request::UNSIGNED_NUM);
$productid = App::$Request->Post['productid']->Int(0, Request::UNSIGNED_NUM);

// roses
$roses_count = App::$Request->Post['roses_count']->Int(0, Request::UNSIGNED_NUM);
$length = App::$Request->Post['length']->Int(0, Request::UNSIGNED_NUM);

// mono
$flower_count = App::$Request->Post['flower_count']->Int(0, Request::UNSIGNED_NUM);

// bouquets
$typeid = App::$Request->Post['size']->Int(0, Request::UNSIGNED_NUM);

// additions
$additions = App::$Request->Post['adds']->AsArray();

$count = $count > 0 ? $count : 1;
$catalogid = App::$City->CatalogId;

$product = $this->catalogMgr->GetProduct($productid);
if ($product === null ) {
    echo $json->encode(array(
        'status' => 'error',
        'errors' => ['product not found']
    ));
    exit;
}

$areaRefs = $product->GetAreaRefs($catalogid);
if ($areaRefs['IsVisible'] == 0 ) {
    echo $json->encode(array(
        'status' => 'error',
        'errors' => ['product not found']
    ));
    exit;
}

$category = $product->category;
if ($category->kind == CatalogMgr::CK_BOUQUET && $typeid == 0) {
    echo $json->encode(array(
        'status' => 'error',
        'errors' => ['bouquet type is not selected'],
    ));
    exit;
} elseif($category->kind == CatalogMgr::CK_ROSE) {
    // length check,
    // roses_count check,
}

// preparing params
$adds = [];
foreach($additions as $additionid => $add_count)
{
    $addition = $this->catalogMgr->GetAddition($additionid);
    if($addition === null)
        continue;

    $areaRefs = $addition->GetAreaRefs($catalogid);
    if($areaRefs['IsVisible'] == 0)
        continue;

    // $adds[$additionid] = $add_count;
    $adds[$additionid] = 1;
}
$options = [
    'count'        => $count,
    'kind'         => $category->kind,
    'typeid'       => $typeid,
    'additions'    => $adds,
];

$params = [];
if($category->kind == CatalogMgr::CK_ROSE)
{
    $params['length']      = $length;
    $params['roses_count'] = $roses_count;
}

if($category->kind == CatalogMgr::CK_MONO) {
    $params['flower_count'] = $flower_count;
}

$options['params'] = $params;

$key = $product->AddToCart($options);
$cart = $this->catalogMgr->GetCart();

// adds

echo $json->encode(array(
    'status' => 'ok',
    'action' => 'add_to_cart',
    'key' => $key,
    'cart' => STPL::Fetch('widgets/announce/general/cart', ['cart' => $cart]),
    'widget' => STPL::Fetch("widgets/announce/general/cart", [
        'cart' => $cart,
    ]),
));
exit;