<?php

class Monetka extends Account
{

    const MODE_KASSY_PAYANYWAY = 1;

    const VAT_TYPE_1104 = 1103; // - НДС 0%
    const VAT_TYPE_1103 = 1103; // - НДС 10%
    const VAT_TYPE_1102 = 1102; // - НДС 18%
    const VAT_TYPE_1105 = 1105; // - НДС не облагается
    const VAT_TYPE_1107 = 1107; // - НДС с рассч. ставкой 10%
    const VAT_TYPE_1106 = 1106; // - НДС с рассч. ставкой 18%

    const RESULT_CODE = 200;

    function __construct(array $info)
    {
        parent::__construct($info);

        $info = array_change_key_case($info, CASE_LOWER);
    }

    // public function GetPayUrl($params)

    public function __set($name, $value)
    {
        $name = strtolower($name);
        switch($name)
        {

            case 'fields':
                $arr = array();
                foreach($value as $k => $item) {
                    if(!isset($item))
                        continue;
                    $arr[$k] = $item;
                }

                $this->Fields = serialize($arr);
            break;
        }

        return null;
    }

    public function __get($name)
    {
        $arrFields = unserialize($this->Fields);
        $name = strtolower($name);

        switch($name) {
            case 'type':
                return PaymentMgr::getInstance()->GetPayment($this->PaymentID);
            case 'fields':
                return unserialize($this->Fields);
            default:
                return $arrFields[$name];
        }

        return null;
    }

    public function CalcSignature($params)
    {
        // MNT_SIGNATURE = MD5(MNT_ID + MNT_TRANSACTION_ID + MNT_AMOUNT + MNT_CURRENCY_CODE +MNT_SUBSCRIBER_ID + ТЕСТОВЫЙ РЕЖИМ + КОД ПРОВЕРКИ ЦЕЛОСТНОСТИ ДАННЫХ)

        $sign = md5($this->mnt_id.$params['orderid'].number_format($params['amount'], 2, ".", "").$this->mnt_currency_code."".$this->mnt_test_mode.$this->code_corrector);

        return $sign;
    }

    public function CalcXmlSignature($params)
    {
        // md5(MNT_RESULT_CODE + MNT_ID + MNT_TRANSACTION_ID + Код проверки целостности данных)

        return md5(static::RESULT_CODE.$this->mnt_id.$params['MNT_TRANSACTION_ID'].$this->code_corrector);
    }

    public function CheckPayment($params)
    {
        // MNT_SIGNATURE = MD5(MNT_ID + MNT_TRANSACTION_ID + MNT_OPERATION_ID +MNT_AMOUNT + MNT_CURRENCY_CODE + MNT_SUBSCRIBER_ID + MNT_TEST_MODE + КОД ПРОВЕРКИ ЦЕЛОСТНОСТИ ДАННЫХ)

        // $sign = $this->CalcXmlSignature($params);

        $sign = md5($params['MNT_ID'].$params['MNT_TRANSACTION_ID'].$params['MNT_OPERATION_ID'].number_format($params['MNT_AMOUNT'], 2, ".", "").$params['MNT_CURRENCY_CODE']."".$params['MNT_TEST_MODE'].$this->code_corrector);

        if($sign == $params['MNT_SIGNATURE'])
            return true;
        else
            return false;
    }

    public function RenderForm($params)
    {
        if(!isset($params['orderid']) || $params['orderid'] == 0)
            return false;

        $order = $params['order'];
                    // $invetory = $this->getInventory($order);
                    // $xmlInventory = $this->getXmlInventory($order, ['MNT_TRANSACTION_ID' => 'abc-123-asd-567']);
                    // header("Content-type: text/xml");
                    // echo $xmlInventory;
                    // exit;

        $payment_system = isset($params['paymentsystem']) && $params['paymentsystem'] > 0 ? $params['paymentsystem'] : $this->paymentsystemunitid;

        $types = PaymentMgr::GetInstance()->GetPaymentTypes();
        $paymentsystemlimitids = [];

        foreach($types as $id => $type) {
            foreach($type['list'] as $id => $item) {
                $paymentsystemlimitids[] = $id;
            }
        }

        $sign = $this->CalcSignature($params);
        $form = "<form method='post' action='https://www.payanyway.ru/assistant.htm' id='order-payment-form'>";
        $form .= "<input type='hidden' name='MNT_ID' value='".$this->mnt_id."'>";
        $form .= "<input type='hidden' name='MNT_TRANSACTION_ID' value='".$params['orderid']."'>";
        $form .= "<input type='hidden' name='MNT_CURRENCY_CODE' value='".$this->mnt_currency_code."'>";
        // $form .= "<input type='hidden' name='MNT_TEST_MODE' value='".$this->mnt_test_mode."'>";
        // $form .= "<input type='hidden' name='MNT_TEST_MODE' value='1'>";
        $form .= "<input type='hidden' name='paymentSystem.unitId' value='card'>";
       // $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$this->paymentsystemunitid."'>";
/*       if(is_array($paymentsystemlimitids) && count($paymentsystemlimitids) > 0)
           $form .= "<input type='hidden' name='paymentSystem.limitIds' value='".implode(",", $paymentsystemlimitids)."''>";*/

           // $form .= "<input type='hidden' name='paymentSystem.limitIds' value='1020'>";

        $form .= "<input type='hidden' name='MNT_AMOUNT' value='".number_format($params['amount'], 2, ".", "")."'>";
        // $form .= "<input type='hidden' name='MNT_CUSTOM1' value='".static::MODE_KASSY_PAYANYWAY."'>";
        // $form .= "<input type='hidden' name='MNT_CUSTOM2' value='".$invetory."'>";
        $form .= "<input type='hidden' name='MNT_SIGNATURE' value='".$sign."'>";
        // $form .= "<input type='submit' value='Pay order'>";
        $form .= "</form>";

        return $form;
    }

    public function getInventory($order)
    {
        $refs = $order->GetOrderRefs();

        $prices = $this->getFixedPrices($order);

        $data = [];
        // $data['customer'] = $order->customeremail;
        $items = [];
        $productPrices = $prices['products'];
        foreach($refs as $item) {
            $product = $item['RealProduct'];
            $addPrices = $prices['adds'][$product->productid];

            $typedProduct = CatalogMgr::getInstance()->GetProduct($product->productid);
            $productName = $typedProduct->getInvetoryName($item);
            // $category = $product->category;
            // $params = unserialize($item['Params']);
            // $productName = $this->getProductName($product, $category, $item);
               // $prodPrice = $item['Price'] * $item['Count'];

            $inventory = [];
            $inventory['n'] = $this->cleanProductName($productName);
            // $inventory['p'] = number_format($item['Price'], 0, '.', '');
            $inventory['p'] = number_format($productPrices[$product->productid], 2, '.', '');
            $inventory['q'] = $item['Count'];
            $inventory['t'] = static::VAT_TYPE_1105;

            $items[] = $inventory;

            if($item['Additions']) {
                $additions = unserialize($item['Additions']);
                foreach($additions as $addition) {
                    // $addPrice = $addition['price'] * $addition['count'];
                    $inventory = [];
                    $inventory['n'] = $this->cleanProductName($addition['name']);
                    // $inventory['p'] = number_format($addition['price'] * , 0, '.', '');
                    $inventory['p'] = number_format($addPrices[$addition['article']] , 2, '.', '');
                    $inventory['q'] = $addition['count'];
                    $inventory['t'] = static::VAT_TYPE_1105;

                    $items[] = $inventory;
                }
            }
        }

        if($order->cardname) {
            $items[] = [
                'n' => $this->cleanProductName($order->cardname),
                'p' => number_format($prices['card'], 2, '.', ''),
                'q' => 1,
                't' => static::VAT_TYPE_1105,
            ];
        }

        $data['items'] = $items;

        $jsonData = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
            return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
        }, json_encode($data));

        return $jsonData;
    }

    public function getInventoryForXml($order)
    {
        $refs = $order->GetOrderRefs();

        $prices = $this->getFixedPrices($order);

        $data = [];
        // $data['customer'] = $order->customeremail;
        $items = [];
        $productPrices = $prices['products'];
        foreach($refs as $item) {
            $product = $item['RealProduct'];
            $addPrices = $prices['adds'][$product->productid];

            $typedProduct = CatalogMgr::getInstance()->GetProduct($product->productid);
            $productName = $typedProduct->getInvetoryName($item);
            // $category = $product->category;
            // $params = unserialize($item['Params']);
            // $productName = $this->getProductName($product, $category, $item);
               // $prodPrice = $item['Price'] * $item['Count'];

            $inventory = [];
            $inventory["name"] = $this->cleanProductName($productName);
            // $inventory['p'] = number_format($item['Price'], 0, '.', '');
            $inventory["price"] = number_format($productPrices[$product->productid], 2, '.', '');
            $inventory["quantity"] = $item['Count'];
            $inventory["vatTag"] = static::VAT_TYPE_1105;

            $items[] = $inventory;

            if($item['Additions']) {
                $additions = unserialize($item['Additions']);
                foreach($additions as $addition) {
                    // $addPrice = $addition['price'] * $addition['count'];
                    $inventory = [];
                    $inventory["name"] = $this->cleanProductName($addition['name']);
                    // $inventory['p'] = number_format($addition['price'] * , 0, '.', '');
                    $inventory["price"] = number_format($addPrices[$addition['article']] , 2, '.', '');
                    $inventory["quantity"] = $addition['count'];
                    $inventory["vatTag"] = static::VAT_TYPE_1105;

                    $items[] = $inventory;
                }
            }
        }

        if($order->cardname) {
            $items[] = [
                "name" => $this->cleanProductName($order->cardname),
                "price" => number_format($prices['card'], 2, '.', ''),
                "quantity" => 1,
                "vatTag" => static::VAT_TYPE_1105,
            ];
        }

        // $data['items'] = $items;

        $jsonData = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
            return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
        }, json_encode($items));

        return $jsonData;
    }

    // Вернуть цены товаров с учетом скидки и подогнанную под сумму заказа (без учета стоимости доставки)
    public function getFixedPrices($order)
    {
        $prices = $this->getPrices($order);
        return $this->validatePrices($prices, $order);
    }

    private function validatePrices($prices, $order)
    {
        // echo 'Original prices\n';
        // print_r($prices);
        // ============================
        // $prodPrices = $prices['products'];
        // $newPrice =  current($prodPrices) - 3;
        // $key = key($prodPrices);
        // $prices['products'][$key] = $newPrice;
        // echo 'Faked prices\n';
        // print_r($prices);
        // exit;
        // ============================
        $totalPrice = 0;
        $priceWithoutDelivery = $order->totalprice - $order->deliveryprice;

        $productPrices = $prices['products'];
        $addPrices  = $prices['adds'];
        foreach($productPrices as $productId => $price) {
            $totalPrice += $price;
            if(isset($addPrices[$productId])) {
                foreach($addPrices[$productId] as $price) {
                    $totalPrice += $price;
                }
            }
        }

        $totalPrice += $prices['card'];
        $totalPrice = floor($totalPrice);
        $delta = $totalPrice - $priceWithoutDelivery;

        // Проверка сходимости цен
        // т.е. сумма стоимости всех товаров в заказе после применения скидки на каждый отдельный товар
        // должна совпадает со стоимостью заказа за вычитом стоимости доставки
        if($delta != 0) {
            $prodPrices = $prices['products'];
            $newPr =  current($prodPrices) - $delta;
            $key = key($prodPrices);
            $prices['products'][$key] = $newPr;
        }

        return $prices;

        // if($delta == 0) {
        //     return $prices;
        // } else {
        //     $newPr =  current($prodPrices) - $delta;
        //     $key = key($prodPrices);
        //     $prices['products'][$key] = $newPr;
        // }
    }

    private function getPrices($order)
    {
        $discount = $this->getDiscount($order);

        $refs = $order->GetOrderRefs();

        foreach($refs as $item) {
            $productId = $item['ProductID'];
            // $products[$productId] = $discountPrice;
            $products[$productId] = $this->getProductDiscountPrices($item, $discount);
            $adds[$productId] = $this->getAddDiscountPrices($item['Additions'], $discount);
        }

        $card = $this->getCardDiscountPrice($order, $discount);

        return [
            'products' => $products,
            'adds' => $adds,
            'card' => $card,
        ];
    }

    private function getCardDiscountPrice($order, $discount)
    {
        if($order->cardname) {
            return $this->calcDiscountPrice($order->cardprice, $discount);
        }

        return 0;
    }

    private function getProductDiscountPrices($item, $discount)
    {
        $count = $item['Count'];
        $price = $item['Price'];
        // $priceItem = $price * $count;

        return $this->calcDiscountPrice($count * $price, $discount);
    }

    private function getAddDiscountPrices($additions, $discount)
    {
        if(!$additions) {
            return [];
        }

        $list = unserialize($additions);
        $prices = [];
        foreach($list as $addition) {
            $addPrice = $addition['price'] * $addition['count'];
            $prices[$addition['article']] = $this->calcDiscountPrice($addPrice, $discount);
        }

        return $prices;

    }

    private function calcDiscountPrice($price, $discount)
    {
        if($discount == 0) {
            return $price;
        }

        return floor($price - (($price / 100) * $discount));
    }

    private function getDiscount($order)
    {
        if($order->discountcard === null) {
            return 0;
        }

        $discountCard = CatalogMgr::getInstance()->GetDiscountCardByCode($order->discountcard);
        if($discountCard && $discountCard->isactive == 1) {
            return $discountCard->discount;
        }

        return 0;
    }

            private function getProductName($product, $category, $item)
            {
                $type = ucfirst(CatalogMgr::$CTL_KIND[$category->kind]['nameid']);
                $methodName = 'get'.$type.'Name';

                if(method_exists($this, $methodName)) {
                    return $this->$methodName($product, $item);
                }
            }

            private function getBouquetName($product, $item)
            {
                return $product->name.' '.$item['BouquetType'];
            }

            private function getRoseName($product, $item)
            {
                $params = unserialize($item['Params']);
                return $product->name.' '.$params['roses_count'].' шт. '.$params['length'].' см.';
            }

            private function getMonoName($product, $item)
            {
                $params = unserialize($item['Params']);
                return $product->name.' '.$params['flower_count'].' шт. ';
            }

    private function cleanProductName($value)
    {
        // для передачи через форму
        // $result = preg_replace('/[^0-9a-zA-Zа-яА-Я ]/ui', '', htmlspecialchars_decode($value));
        // $result = trim(mb_substr($result, 0, 12));
        // $result = trim($result);

        // для xml
        $result = trim(preg_replace("/&?[a-z0-9]+;/i", "", htmlspecialchars($value)));

        return $result;
    }

    public function getXmlInventory($order, $params)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->formatOutput = true;

        $root = $doc->createElement('MNT_RESPONSE');
        $doc->appendChild($root);

        $mntId = $doc->createElement('MNT_ID', $this->mnt_id);
        $mntTransactionId = $doc->createElement('MNT_TRANSACTION_ID', $params['MNT_TRANSACTION_ID']);
        $mntResultCode = $doc->createElement('MNT_RESULT_CODE', static::RESULT_CODE);
        $mntSignature = $doc->createElement('MNT_SIGNATURE', $this->CalcXmlSignature($params));
        $mntAttributes = $doc->createElement('MNT_ATTRIBUTES');

        $root->appendChild($mntId);
        $root->appendChild($mntTransactionId);
        $root->appendChild($mntResultCode);
        $root->appendChild($mntSignature);
        $root->appendChild($mntAttributes);

        // Inventory
        $attributeInventory = $doc->createElement('ATTRIBUTE');
        $mntAttributes->appendChild($attributeInventory);

        $inventoryKey = $doc->createElement('KEY', 'INVENTORY');
        $inventoryValue = $doc->createElement('VALUE', $this->getInventoryForXml($order));

        $attributeInventory->appendChild($inventoryKey);
        $attributeInventory->appendChild($inventoryValue);

        // customer
        $attributeCustomer = $doc->createElement('ATTRIBUTE');
        $mntAttributes->appendChild($attributeCustomer);

        $customerKey = $doc->createElement('KEY', 'CUSTOMER');
        $customerValue = $doc->createElement('VALUE', $order->customeremail);

        $attributeCustomer->appendChild($customerKey);
        $attributeCustomer->appendChild($customerValue);

        // Delivery
        $attributeDelivery = $doc->createElement('ATTRIBUTE');
        $mntAttributes->appendChild($attributeDelivery);

        $deliveryKey = $doc->createElement('KEY', 'DELIVERY');
        $deliveryValue = $doc->createElement('VALUE', number_format($order->deliveryprice, 2, '.', ''));

        $attributeDelivery->appendChild($deliveryKey);
        $attributeDelivery->appendChild($deliveryValue);

        return $doc->saveXML();

    }


    function __destruct()
    {
    }

}

?>