<<<<<<< HEAD
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

    function __construct(array $info)
    {
        parent::__construct($info);

=======
<?

class Monetka extends Account
{
    function __construct(array $info)
    {
        parent::__construct($info);
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
        $info = array_change_key_case($info, CASE_LOWER);
    }

    // public function GetPayUrl($params)
<<<<<<< HEAD

=======
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
    public function __set($name, $value)
    {
        $name = strtolower($name);
        switch($name)
        {
<<<<<<< HEAD

            case 'fields':
                $arr = array();
                foreach($value as $k => $item) {
=======
            case 'fields':
                $arr = array();
                foreach($value as $k => $item)
                {
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
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

<<<<<<< HEAD
        switch($name) {
=======
        switch($name)
        {
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
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

    public function CheckPayment($params)
    {
        // MNT_SIGNATURE = MD5(MNT_ID + MNT_TRANSACTION_ID + MNT_OPERATION_ID +MNT_AMOUNT + MNT_CURRENCY_CODE + MNT_SUBSCRIBER_ID + MNT_TEST_MODE + КОД ПРОВЕРКИ ЦЕЛОСТНОСТИ ДАННЫХ)

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

<<<<<<< HEAD
        $order = $params['order'];
        $invetory = $this->getInvetory($order);

        $payment_system = isset($params['paymentsystem']) && $params['paymentsystem'] > 0 ? $params['paymentsystem'] : $this->paymentsystemunitid;

        $types = PaymentMgr::GetInstance()->GetPaymentTypes();
=======
        $payment_system = isset($params['paymentsystem']) && $params['paymentsystem'] > 0 ? $params['paymentsystem'] : $this->paymentsystemunitid;

        $types = PaymentMgr::GetInstance()->GetPaymentTypes();

>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
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
<<<<<<< HEAD
        // $form .= "<input type='hidden' name='MNT_TEST_MODE' value='1'>";
        $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$payment_system."'>";
       // $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$this->paymentsystemunitid."'>";
       if(is_array($paymentsystemlimitids) && count($paymentsystemlimitids) > 0)
           $form .= "<input type='hidden' name='paymentSystem.limitIds' value='".implode(",", $paymentsystemlimitids).">";

           // $form .= "<input type='hidden' name='paymentSystem.limitIds' value='1020'>";

        $form .= "<input type='hidden' name='MNT_AMOUNT' value='".number_format($params['amount'], 2, ".", "")."'>";
        $form .= "<input type='hidden' name='MNT_CUSTOM1' value='".static::MODE_KASSY_PAYANYWAY."'>";
        $form .= "<input type='hidden' name='MNT_CUSTOM2' value='".$invetory."'>";
=======
        $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$payment_system."'>";
       // $form .= "<input type='hidden' name='paymentSystem.unitId' value='".$this->paymentsystemunitid."'>";
       if(is_array($paymentsystemlimitids) && count($paymentsystemlimitids) > 0)
           $form .= "<input type='hidden' name='paymentSystem.limitIds' value='".implode(",", $paymentsystemlimitids)."'>";
           // $form .= "<input type='hidden' name='paymentSystem.limitIds' value='1020'>";
        $form .= "<input type='hidden' name='MNT_AMOUNT' value='".number_format($params['amount'], 2, ".", "")."'>";
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
        $form .= "<input type='hidden' name='MNT_SIGNATURE' value='".$sign."'>";
        // $form .= "<input type='submit' value='Pay order'>";
        $form .= "</form>";

        return $form;
    }

<<<<<<< HEAD
    public function getInvetory($order)
    {
        $refs = $order->GetOrderRefs();

        $data = [];
        $data['customer'] = $order->customeremail;
        $items = [];
        foreach($refs as $item) {
            $product = $item['RealProduct'];

            $inventory = [];
            $inventory['n'] = $this->cleanProductName($product->name);
            $inventory['p'] = number_format($item['Price'], 0, '', '');
            $inventory['q'] = $item['Count'];
            $inventory['t'] = static::VAT_TYPE_1105;

            $items[] = $inventory;

            if($item['Additions']) {
                $additions = unserialize($item['Additions']);
                foreach($additions as $addition) {
                    $inventory = [];
                    $inventory['n'] = $this->cleanProductName($addition['name']);
                    $inventory['p'] = number_format($addition['price'], 0, '', '');
                    $inventory['q'] = $addition['count'];
                    $inventory['t'] = static::VAT_TYPE_1105;

                    $items[] = $inventory;
                }
            }


        }

        $data['items'] = $items;

        $jsonData = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
            return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
        }, json_encode($data));

        return $jsonData;
    }

    private function cleanProductName($value)
    {
        $result = preg_replace('/[^0-9a-zA-Zа-яА-Я ]/ui', '',
            htmlspecialchars_decode($value));
            $result = trim(mb_substr($result, 0, 12));

        return $result;
    }


    function __destruct()
    {
    }

=======
    function __destruct()
    {
    }
>>>>>>> 2d135dff864135e7a329dcd276066b70bea731fe
}

?>