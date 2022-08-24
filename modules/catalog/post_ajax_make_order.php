<?
include_once $CONFIG['engine_path'] . 'include/json.php';
$json = new Services_JSON();

$confirmation = App::$Request->Post['confirmation']->Int(0, array(0, 1));
$isAccept = App::$Request->Post['isAccept']->Int(0, array(0, 1));

$storeid = App::$Request->Post['pickup_store']->Int(0, Request::UNSIGNED_NUM);
$delivery_address = App::$Request->Post['delivery_address']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
$delivery_type = App::$Request->Post['delivery_type']->Enum(CatalogMgr::DT_DELIVERY, array_keys(CatalogMgr::$DT_TYPES));
$delivery_date = App::$Request->Post['delivery_date']->Datestamp();
$pickup_date = App::$Request->Post['pickup_date']->Datestamp();
// $delivery_date     = App::$Request->Post['delivery_date']->Value();
$district_id = App::$Request->Post['district_id']->Int(0, Request::UNSIGNED_NUM);
$delivery_from = App::$Request->Post['time-delivery-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
$delivery_to = App::$Request->Post['time-delivery-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);


$pickup_delivery_from = App::$Request->Post['time-pickup-from']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
$pickup_delivery_to = App::$Request->Post['time-pickup-to']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);

$discountcard = App::$Request->Post['discountcard']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);

$recipient_name = App::$Request->Post['recipient_name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
// $recipient_phone   = App::$Request->Post['recipient_phone']->Phone();
$recipient_phone = App::$Request->Post['recipient_phone']->Value();

$customer_name = App::$Request->Post['customer_name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
// $customer_phone    = App::$Request->Post['customer_phone']->Phone();
$customer_phone = App::$Request->Post['customer_phone']->Value();
$customer_email = App::$Request->Post['customer_email']->Email();

$contact_name = App::$Request->Post['contact_name']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);
// $contact_phone     = App::$Request->Post['contact_phone']->Phone();
$contact_phone = App::$Request->Post['contact_phone']->Value();
$contact_email = App::$Request->Post['contact_email']->Email();


//    $card_id           = App::$Request->Post['card_id']->Int(0, Request::UNSIGNED_NUM);
//    $card_text         = App::$Request->Post['card_text']->Value(Request::OUT_HTML_CLEAN | Request::OUT_REMOVE_NL);


$card_id = $_POST['card_id'];
$card_text = $_POST['card_text'];

$correction_call = App::$Request->Post['correction_call']->Enum(0, array(0, 1, 2));

$not_flower_notify = App::$Request->Post['not_flower_notify']->Enum(0, array(0, 1));

$wantdiscountcard = App::$Request->Post['want_discount_card']->Enum(0, array(0, 1));

$payment_system = App::$Request->Post['payment_system']->Int(0, Request::UNSIGNED_NUM);

$postcard_array = array();

foreach ($card_text as $index => $postcard_text__arr) {

    foreach ($postcard_text__arr as $postcard_text) {

        // Проверка на эмодзи
        $copy_card_text = $postcard_text;
        $replaced_emoji_card_text = "";
        for ($i = 0; $i < mb_strlen($copy_card_text); $i++) {
            $char = mb_substr($copy_card_text, $i, 1);
            if (strlen($char) == 4) {
                $replaced_emoji_card_text .= ':emoji:';
            } else {
                $replaced_emoji_card_text .= $char;
            }
        }

        $postcard_array[$index][] = $replaced_emoji_card_text;
    }
}

//echo '<pre>' . var_export($postcard_array, true) . '</pre>';
//die();

$errors = [];
$orderErrors = CatalogMgr::$errors['order'];

$delivery_date_str = date('d.m.Y', $delivery_date);
list($day, $month, $year) = explode('.', $delivery_date_str);

// if(!checkdate($month, $day, $year))
//     $errors['delivery_date'] = $orderErrors['invalidDate'];


if ($confirmation == 0)
    $errors['confirmation'] = $orderErrors['noConfirmation'];

if ($isAccept == 0)
    $errors['isAccept'] = 'Поле обязательно';

// if($correction_call == 1) {
//     if (mb_strlen($recipient_phone) == 0)
//         $errors['recipient_phone'] = $orderErrors['recipientPhone'];
//     elseif (!Data::Is_Phone($recipient_phone))
//         $errors['recipient_phone'] = $orderErrors['recipientPhone'];
// }

// if ($delivery_date === false)
//     $errors['deliveryDate'] = $orderErrors['deliveryDate'];

// if (mb_strlen($recipientPhone) == 0)
// $errors['recipientPhone'] = 'Не указан номер телефона';
// elseif (!Data::Is_Phone($Phone))
// $errors['recipientPhone'] = 'Неверный формат номера телефона';

$delivery_price = 0;
$delivery_area = '';
$store_addres = '';


$current_date = date('d.m.Y', time());
$bl = BLFactory::GetInstance('system/config');
$config_catalog = $bl->LoadConfig('module_engine', 'catalog');

$not_working_days = $config_catalog['days'];

/* если установлено ограничение периода заказа */
$daysPeriod = $config_catalog['days_period'];
$_period = time() + 60 * 60 * 24 * 180;
if ($daysPeriod > 0) {
    $_period = time() + $daysPeriod * 60 * 60 * 24;
}

if ($delivery_type == CatalogMgr::DT_DELIVERY) {
    $store_address = ' ';
    if (mb_strlen($delivery_address) == 0) {
        $errors['delivery_address'] = $orderErrors['deliveryAddress'];
    }

    if (mb_strlen($customer_name) == 0)
        $errors['customer_name'] = $orderErrors['customerName'];

    if (mb_strlen($customer_phone) == 0) {
        $errors['customer_phone'] = $orderErrors['customerPhone'];
    }
    // elseif (!Data::Is_Phone($customer_phone))
    //     $errors['customer_phone'] = $orderErrors['customerPhone'];

    if ($customer_email === false)
        $errors['customer_email'] = $orderErrors['customerEmail'];

    if ($correction_call == 0) {
        $errors['correction_call'] = $orderErrors['deliveryTime'];
    }

    if (mb_strlen($recipient_name) == 0)
        $errors['recipient_name'] = $orderErrors['recipientName'];

    $district = CitiesMgr::GetInstance()->GetDistrict($district_id);
    if ($district !== null) {
        $delivery_price = $district->Price;
        $delivery_area = $district->Name;
    }

    // if (mb_strlen($recipient_phone) == 0 || !Data::Is_Phone($recipient_phone))
    if (mb_strlen($recipient_phone) == 0) {
        $errors['recipient_phone'] = $orderErrors['recipientPhone'];
    }

    // echo $delivery_date, " :: ",strtotime($delivery_date), " - ", strtotime($current_date);
    // if($delivery_date < time()) {

    $delivery_day_month = date('d.m', $delivery_date);

    if ($delivery_date < strtotime($current_date) || in_array($delivery_day_month, $not_working_days) || $delivery_date > $_period) {
        $errors['delivery_date'] = $orderErrors['invalidDate'];
    }

    if ($correction_call == 2 && !CatalogMgr::validateTime('delivery', $delivery_date, $delivery_from, $delivery_to)) {
        $errors['time-delivery-from'] = $config_catalog['time_message']['delivery'];
    }

    $delivery_time = $delivery_from . " - " . $delivery_to;
} elseif ($delivery_type == CatalogMgr::DT_PICKUP) {
    $store = $this->citiesMgr->GetStore($store_id);
    if ($store !== null)
        $store_address = $store->Address;

    if (mb_strlen($contact_name) == 0)
        $errors['contact_name'] = $orderErrors['customerName'];

    if (mb_strlen($contact_phone) == 0) {
        $errors['contact_phone'] = $orderErrors['customerPhone'];
    }
    // elseif (!Data::Is_Phone($contact_phone))
    //     $errors['contact_phone'] = $orderErrors['customerPhone'];

    if ($storeid == 0) {
        $errors['pickup_store'] = $orderErrors['pickupStore'];
    }

    $pickup_day_month = date('d.m', $pickup_date);

    if ($pickup_date < strtotime($current_date) || in_array($pickup_day_month, $not_working_days) || $pickup_date > $_period) {
        $errors['pickup_date'] = $orderErrors['invalidDate'];
    }

    if ($contact_email === false)
        $errors['contact_email'] = $orderErrors['customerEmail'];


    if (!CatalogMgr::validateTime('pickup', $pickup_date, $pickup_delivery_from, $pickup_delivery_to)) {
        $errors['time-pickup-from'] = $config_catalog['time_message']['pickup'];
    }

    $customer_name = $contact_name;
    $customer_phone = $contact_phone;
    $customer_email = $contact_email;
    $delivery_time = $pickup_delivery_from . " - " . $pickup_delivery_to;
    $delivery_date = $pickup_date;
    $correction_call = 2; // время указано. Для самовывоза другого значения быть не может
}

$cart = $this->catalogMgr->GetCart();

if (sizeof($errors)) {

    // добавление ошибки дисконтной карты
    include_once $CONFIG['engine_path'] . 'include/catalog/CartTrying.php';
    $trying = new CartTrying($cart['cart_code']);
    if (!$trying->can()) {
        $errors['discountcard'] = $trying->getMessage();
    }

    echo $json->encode(array(
        'status' => 'error',
        'errors' => $errors,
    ));
    exit;
}

$card_prices_all = 0;
if (count($card_id) > 0) {
    foreach ($card_id as $index => $postcards) {
        foreach ($postcards as $postcard) {

            $card = $this->catalogMgr->GetCard($postcard);

            if ($card !== null || $card->isvisible !== 0) {
                $card_ids[$index][] = $card->id;
                $card_prices[$index][] = $card->price;
                $card_prices_all = intval($card_prices_all) + intval($card->price);
                $card_names[$index][] = $card->name;
                $card_product_id[$index][] = $_POST['order_card_id'][$index];
            }
        }
    }
} else {
    $card_ids = 0;
    $card_text = '';
    $replaced_emoji_card_text = '';
    $card_prices = 0;
    $card_names = '';
}

// применение скидочной карты
if ($this->catalogMgr->ValidateDiscountCard($discountcard)) {
    $objcard = $this->catalogMgr->GetDiscountCardByCode($discountcard);

    if ($objcard !== null && $objcard->isactive == 0) {
        $discount = 0;
    } else {
        $discount = $this->catalogMgr->GetDiscountByCard($objcard);
    }
} else {
    $discount = 0;
}

if ($cart['sum']['total_price'] == 0) {
    echo $json->encode(array(
        'status' => 'error',
        'action' => 'cart_is_empty',
    ));
    exit;
}

$total_price = $cart['sum']['total_price'] + $card_prices_all;

// пересчет корзины с учетом дисконтной карты и скидочных товаров
// $total_price = $this->catalogMgr->getCartPrice($cart, $total_price, $discount);
$total_price = $this->catalogMgr->getCartPrice($cart, $card_prices_all, $discount);

$total_price += $delivery_price;

/*$price_wo_delivery = $cart['sum']['total_price'] + $card_prices_all;
$discounted_price = floor($price_wo_delivery - $price_wo_delivery * $discount/100);
$total_price = $discounted_price + $delivery_price;*/

$data = [
    'CartCode' => $this->catalogMgr->CartCode,
    'UserID' => App::$User->ID,
    'CatalogID' => App::$City->CatalogId,
    'StoreID' => $storeid,
    'StoreAddress' => $store_address,
    'DeliveryAddress' => $delivery_address,
    'DeliveryDate' => $delivery_date,
    'DeliveryType' => $delivery_type,
    'DistrictID' => $district_id,
    'DeliveryTime' => $delivery_time,
    'RecipientName' => $recipient_name,
    'RecipientPhone' => $recipient_phone,
    'CorrectionCall' => intval($correction_call),
    'NotFlowerNotify' => intval($not_flower_notify),
    'CustomerName' => $customer_name,
    'CustomerPhone' => $customer_phone,
    'CustomerEmail' => $customer_email,
    'PaymentType' => CatalogMgr::PT_ONLINE,
    'PaymentAcType' => $payment_type,
    'PaymentSystem' => $payment_system,
    'CardID' => $card_ids,
    'CardText' => $postcard_array,
    'CardName' => $card_names,
    'CardProductId' => $card_product_id,
    'CardPrice' => $card_prices,
    'TotalPrice' => $total_price,
    'Status' => CatalogMgr::OS_NEW,
    'PaymentStatus' => CatalogMgr::PS_NOPAID,
    'DeliveryPrice' => $delivery_price,
    'DeliveryArea' => $delivery_area,
    'DiscountCard' => $discountcard,
    'WantDiscountCard' => $wantdiscountcard,
];


$order = new Order($data);
$order->Update();

if ($order === null) {
    $errors['noCreateOrder'] = $orderErrors['noCreateOrder'];
}

if (sizeof($errors)) {
    echo $json->encode([
        'status' => 'error',
        'errors' => $errors,
    ]);
    exit;
}

// $out_summ = number_format(($total_price), 2, '.', '');
// $pay_params = array(
//     'OutSum' => $out_summ,
//     'InvId'  => $order->id,
// );

// $rk = $this->paymentMgr->GetDefaultAcc();
// $url = $rk->GetPayUrl($pay_params);

// ==================================

LibFactory::GetStatic('mailsender');
$mail = new MailSender();
$mail->AddAddress('from', 'no-reply@rosetta.florist', "Служба уведомлений", 'utf-8');
$mail->AddHeader('Subject', $this->_env['site']['domain'] . " Заказ букета " . $order->id, 'utf-8');
$mail->body_type = MailSender::BT_HTML;

$bl = BLFactory::GetInstance('system/config');
$config = $bl->LoadConfig('module_engine', 'catalog');

foreach ($config['order_emails'] as $order_email) {
    $mail->AddAddress('to', $order_email);
}

// $mail->AddAddress('to', 'terpinc0de@mail.ru');

$letter = "С сайта " . $this->_env['site']['domain'] . " поступил заказ на букет<br/>";
$letter .= "Номер заказа: " . $order->id . "<br>";
$letter .= "Дата выполнения заказа: " . date("d.m.Y", $order->deliverydate) . "<br/>";
if ($order->correctioncall == 1) {
    $time_range = 'уточнить у получателя';
} elseif ($order->correctioncall == 2) {
    $time_range = $order->deliverytime;
}
$letter .= "Период времени выполнения заказа: " . $time_range . "<br/>";
$letter .= "Имя пользователя: " . $order->customername . "<br/>";
$letter .= "Телефон пользователя: " . $order->customerphone . "<br/>";
$letter .= "Почта пользователя: " . $order->customeremail . "<br/>";
if ($order->deliverytype == CatalogMgr::DT_DELIVERY) {
    $letter .= "Доставка курьером<br/>";
    $letter .= "Адрес доставки: " . $order->deliveryaddress . "<br/>";
    $letter .= "Район доставки: " . $order->deliveryarea . "<br/>";
} elseif ($order->deliverytype == CatalogMgr::DT_PICKUP) {
    $store = CitiesMgr::getInstance()->GetStore($order->storeid);
    $letter .= "Самовывоз<br/>";
    $letter .= "Салон самовывоза:" . $store->Name . "<br>";
}

$letter .= "Имя получателя:" . $order->recipientname . "<br>";
$letter .= "Телефон получателя:" . $order->recipientphone . "<br>";
if ($order->notflowernotify == 0)
    $letter .= "Говорить, что цветы<br/>";
else
    $letter .= "Не говорить, что цветы<br/>";


////////// Информация об открытках ////////////

$postcards_array = CatalogMgr::getInstance()->GetOrderPostcards($order->id);

//////////////////////////////////////////////

$letter .= '<hr>';

foreach ($order->refs as $item) {
    $letter .= "<b>Артикул букета: " . $item['RealProduct']->article . "</b><br>";

    if ($item['Additions']) {
        $additions = unserialize($item['Additions']);
        foreach ($additions as $addition) {
            $letter .= "Артикул доп. товара: " . $addition['article'] . "<br>";
        }
    }

    if (count($postcards_array) == 0) {
        $postcard_letter_text .= "&nbsp;&nbsp;&nbsp;&nbsp;Без открытки<br/>";
    }

    foreach ($postcards_array[$item['ProductID']] as $postcard) {
        $letter .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $postcard['Name'] . "<br>";
        $letter .= "&nbsp;&nbsp;&nbsp;&nbsp;Текст открытки: " . $postcard['postcard_text'] . "<br>";
    }

}

$letter .= '<hr>';
$letter .= '<a href="' . App::$Protocol . $this->_env['site']['domain'] . '/admin/site/' . $this->_env['site']['domain'] . '/catalog/.module/?section_id=71&action=edit_order&id=' . $order->id . '">Перейти к заказу №' . $order->id . '</a><br>';

$letter .= "--<br/>Служба уведомлений " . $this->_env['site']['domain'] . "<br/>";


$mail->AddBody('text', $letter, MailSender::BT_HTML, 'utf-8');
$mail->SendImmediate();

// ==================================

echo $json->encode(array(
    'status' => 'ok',
    'action' => 'make_order',
    'url' => App::$Protocol . $_SERVER['HTTP_HOST'] . '/catalog/payment/' . $order->id . '/',
));
exit;