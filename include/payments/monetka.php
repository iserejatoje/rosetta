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
        // $form .= "<input type='hidden' name='paymentSystem.unitId' value='2243990'>";
        // $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$this->paymentsystemunitid."'>";
/*        if(is_array($paymentsystemlimitids) && count($paymentsystemlimitids) > 0)
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


    private function getCardDiscountPrice($order, $discount)
    {
        // Костыль, отключающий применение скидки открытке
        $discount = 0;

        if($order->cardname) {
            return $this->calcDiscountPrice($order->cardprice, $discount);
        }

        return 0;
    }

    private function calcDiscountPrice($price, $discount)
    {
        if($discount == 0) {
            return $price;
        }

        return round($price - (($price / 100) * $discount), 1);
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
        $inventoryValue = $doc->createElement('VALUE', $this->getJsonInventoryForXml($order));

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

        if($order->deliveryprice) {
            $deliveryKey = $doc->createElement('KEY', 'DELIVERY');
            $deliveryValue = $doc->createElement('VALUE', number_format($order->deliveryprice, 2, '.', ''));

            $attributeDelivery->appendChild($deliveryKey);
            $attributeDelivery->appendChild($deliveryValue);
        }

        return $doc->saveXML();

    }

    public function getJsonInventoryForXml($order)
    {
        $items = [];
        $refs = $order->getOrderRefs();
        $info = $this->getActualProductInfo($order);


        $items = [];
        foreach($info['products'] as $key => $productItem) {
            $inventory = [];
            $inventory['name'] = $productItem['name'];
            $inventory['price'] = number_format($productItem['price'], 2, '.', '');
            $inventory['quantity'] = $productItem['count'];
            $inventory["vatTag"] = static::VAT_TYPE_1105;

            $items[] = $inventory;

            $additions = $info['additions'][$key];
            foreach($additions as $addition) {
                $inventory = [];
                $inventory['name'] = $addition['name'];
                $inventory['price'] = number_format($addition['price'], 2, '.', '');
                $inventory['quantity'] = $addition['count'];
                $inventory["vatTag"] = static::VAT_TYPE_1105;

                $items[] = $inventory;
            }
        }

        if($order->cardname) {
            $items[] = [
                "name" => $this->cleanProductName($order->cardname),
                "price" => number_format($info['card'], 2, '.', ''),
                "quantity" => 1,
                "vatTag" => static::VAT_TYPE_1105,
            ];
        }

        $jsonData = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
            return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
        }, json_encode($items));

        return $jsonData;
    }

    private function getActualProductInfo($order)
    {
        $info = $this->getProductsInfo($order);
        return $info;
        // $actualInfo = $this->acutalizeInfo($info, $order);

        // return $actualInfo;
    }

    // Получние информации по компонентам заказа (название, количество, цена)
    private function getProductsInfo($order)
    {
        $discount = $this->getDiscount($order);
        $orderItems = $order->getOrderRefs();

        $products = [];
        $additions = [];
        foreach($orderItems as $k => $item) {

            $typedProduct = CatalogMgr::getInstance()->GetProduct($item['ProductID']);

            $areaRefs = null;
            $productDiscountPercent = 0;
            if($typedProduct) {
                $areaRefs = $typedProduct->GetAreaRefs($order->catalogid);
                $productName = $this->cleanProductName($typedProduct->getInvetoryName($item));
                $key = $item['ProductID']."_".$item['TypeID']."_".$item['CurrentTime'];
                $productDiscountPercent = (int) $typedProduct->getDiscountPercent(App::$City->CatalogId);
            } else {
                $productName = $this->cleanProductName($item['Name']);
                $key = $k;
            }

            if($this->hasDiscount($areaRefs)) {
                if($productDiscountPercent > $discount) {
                    $price = $item['BouquetPrice'];
                } else {
                    $price = $this->calcDiscountPrice($item['ClearPrice'], $discount);
                }
            } else {
                $price = $this->getProductPriceWithDiscount($item, $discount);
            }

            $products[$key] = [
                'price' => $price,
                'count' => $item['Count'],
                'name' => $productName,
            ];

            $additions[$key] = $this->getAdditionsInfo($item['Additions'], $discount);
        }

        $card = $this->getCardDiscountPrice($order, $discount);

        return [
            'products' => $products,
            'additions' => $additions,
            'card' => $card,
        ];
    }

    /**
     * проверяет, установлена ли скидка на товар
     *
     * @param array $areaRefs
     * @return boolean
     */
    public function hasDiscount($areaRefs)
    {
        return isset($areaRefs['ExcludeDiscount']) && $areaRefs['ExcludeDiscount'];
    }

    // DELETE
    // Приведение цены - то есть чтобы сумма товаров в заказе с учетом скидки равнялась стоимости заказа с учетом скидки

//     private function acutalizeInfo($info, $order)
//     {
//         $totalPrice = 0;
//         $priceWithoutDelivery = $order->totalprice - $order->deliveryprice;

//         $productsInfo = $info['products'];
//         foreach($productsInfo as $key => $productItem) {
//             // calc total price for products
//             $totalPrice += $productItem['price'] * $productItem['count'];

//             // calc total price for additions
//             $additions = $info['additions'][$key];
//             foreach($additions as $key => $addition) {
//                 $totalPrice += $addition['price'] * $addition['count'];
//             }
//         }

//         $totalPrice += $prices['card'];
//         $delta = $totalPrice - $priceWithoutDelivery;


// $actualInfo = $info;

//         return $actualInfo;

//     }

    private function getProductPriceWithDiscount($item, $discount)
    {
        return $this->calcDiscountPrice($item['BouquetPrice'], $discount);
    }

    /**
    * Get info about additions (name, price with discount, count)
    *
    * @param array additions
    * @return array
    */
    private function getAdditionsInfo($additions, $discount)
    {
        if(!$additions) {
            return [];
        }

        $addItems = unserialize($additions);
        $prices = [];
        foreach($addItems as $item) {
            $prices[$item['article']] = [
                'price' => $this->calcDiscountPrice($item['price'], $discount),
                'count' => $item['count'],
                'name' => $this->cleanProductName($item['name']),
            ];
        }

        return $prices;
    }

    function __destruct()
    {
    }

}

?>