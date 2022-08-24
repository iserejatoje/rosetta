<?php

include_once $CONFIG['engine_path'].'include/json.php';
$json = new Services_JSON();

$productid = App::$Request->Post['productid']->Int(0, Request::UNSIGNED_NUM);
$typeid = App::$Request->Post['size']->Int(0, Request::UNSIGNED_NUM);
$count = App::$Request->Post['count']->Int(0, Request::UNSIGNED_NUM);
// roses
$roses_count = App::$Request->Post['roses_count']->Int(0, Request::UNSIGNED_NUM);
$length = App::$Request->Post['length']->Int(0, Request::UNSIGNED_NUM);
// mono
$flower_count = App::$Request->Post['flower_count']->Int(0, Request::UNSIGNED_NUM);

$product = $this->catalogMgr->GetProduct($productid);
if($product == null) {
    echo $json->encode(array(
        'status' => 'error',
        'errors' => array('product not found')
    ));
    exit;
}


$category = $product->category;
if($category->kind == CatalogMgr::CK_BOUQUET) {
    /** @var product type id $type */
    $type = $this->catalogMgr->GetType($typeid);
    if(null === $type) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => array('type not found')
        ));
        exit;
    }

    $price = $type->GetPrice();
} elseif($category->kind == CatalogMgr::CK_MONO) {
    $types = $product->GetTypes();
    $type = $types[0];
    if($type === null) {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => array('type not found')
        ));
        exit;
    }
    $price = $type->GetPrice(App::$City->CatalogId, $flower_count);
} elseif($category->kind == CatalogMgr::CK_MONO) {
    $price = $product->GetPrice($length, $flower_count);
} elseif($category->kind == CatalogMgr::CK_FIXED) {
    $type = $product->default_type;
    $price = $type->GetPrice();
} elseif($category->kind == CatalogMgr::CK_ROSE) {
    $price = $product->GetPrice($length, $roses_count);
}


$catalogId = App::$City->CatalogId;
$areaRefs = $product->GetAreaRefs($catalogId);
$discountPercent = (int) $product->getDiscountPercent($catalogId);
if($this->catalogMgr->hasDiscount($areaRefs) && $discountPercent > 0) {
    $price = $this->catalogMgr->getDiscountPrice($price, $product, $catalogId);
}

echo $json->encode(array(
    'status' => 'ok',
    'action' => 'get_price',
    'price' => $price,
));
exit;