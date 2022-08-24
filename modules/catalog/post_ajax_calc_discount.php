<?
include_once $CONFIG['engine_path'] . 'include/json.php';
include_once $CONFIG['engine_path'] . 'include/catalog/CartTrying.php';
$json = new Services_JSON();

$delivery_type = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
$delivery_district = App::$Request->Post['district_id']->Int(0, Request::UNSIGNED_NUM);
$discountcard = App::$Request->Post['discountcard']->Value();

//    $card_id = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);

$errors = [];
$orderErrors = CatalogMgr::$errors['order'];
$gift_card = array();

foreach ($_POST['card_id'] as $post) {
    foreach ($post as $el) {
        $item = $this->catalogMgr->GetCard($el);
        if ($item !== null || $item->isvisible !== 0) {
            $gift_card[] = $item;
        }
    }
}

$card_price = 0;

foreach ($gift_card as $post) {
    $card_price += $post->price;
}

$cart = $this->catalogMgr->GetCart();
$price = $cart['sum']['total_price'] + $card_price;

if ($delivery_type == CatalogMgr::DT_DELIVERY) {
    $default_district = $this->citiesMgr->GetDistrict($delivery_district);
    if ($default_district === null || $default_district->IsAvailable == 0)
        $default_district = App::$City->GetDefaultDistrict();
} else {
    $default_district = null;
}

$trying = new CartTrying($cart['cart_code']);

// если нет дисконтной карты либо проверка заблокирована из-за ограничения количества проверок в единицу времени
if (!$cart['cart_code'] || !$trying->can()) {
    if ($default_district)
        $price += $default_district->Price;

    $errors['discountcard'] = $trying->getMessage();
    echo $json->encode([
        'status' => 'error',
        'action' => 'block',
        'errors' => $errors,
        'price' => $price,
        'time' => $trying->getRemainingTime(),
    ]);
    exit;
}

// если карта невалидна
if ($this->catalogMgr->ValidateDiscountCard($discountcard) == false) {
    $trying->inc();

    if ($default_district)
        $price += $default_district->Price;
    $errors['discountcard'] = $orderErrors['invalidDiscountCard'];
    echo $json->encode([
        'status' => 'error',
        'action' => 'invalid_card',
        'errors' => $errors,
        'price' => $price,
    ]);
    exit;
}

$objcard = $this->catalogMgr->GetDiscountCardByCode($discountcard);

// если нет карты либо карта неактивна
// if($objcard !== null && $objcard->isactive == 0) {
if (!$objcard || $objcard->isactive == 0) {
    if ($default_district)
        $price += $default_district->Price;
    $trying->inc();
    $errors['discountcard'] = $orderErrors['inactiveDiscountCard'];
    echo $json->encode([
        'status' => 'error',
        'action' => 'invalid_card',
        'errors' => $errors,
        'price' => $price,
    ]);
    exit;
}

// если дошли сюда, карта существует и активна
// нужно сбросить счетчик попыток и применить скидку
$trying->reset();

// DEPRECATED вычисление скидки по 5й цифре кода
// $percent = $this->catalogMgr->GetDiscountByCard($discountcard);
$percent = $this->catalogMgr->GetDiscountByCard($objcard);

// пересчет корзины с учетом дисконтной карты и скидочных товаров
// $price = $this->catalogMgr->getCartPrice($cart, $price, $percent);
$price = $this->catalogMgr->getCartPrice($cart, $card_price, $percent);

if ($default_district)
    $price += $default_district->Price;

echo $json->encode([
    'status' => 'ok',
    'action' => 'calc_discount',
    'price' => $price,
    'widget' => STPL::Fetch("widgets/announce/general/cart", [
        'cart' => $cart,
    ]),
]);
exit;