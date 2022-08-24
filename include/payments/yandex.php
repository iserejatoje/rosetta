<?
class Yandex extends Account
{
	// public $ID;
	// public $Name;
	// public $PaymentID;
	// private $Fields;
	// private $Login;
	// private $Pass;
	// private $Pass1;
	// private $Pass2;

	function __construct(array $info)
	{
		parent::__construct($info);
		// $info = array_change_key_case($info, CASE_LOWER);

		// if ( isset($info['accountid']) && Data::Is_Number($info['accountid']) )
		// 	$this->ID = $info['accountid'];
		// $this->Name      = $info['name'];
		// $this->PaymentID = $info['paymentid'];
		// $this->Fields    = $info['fields'];
	}


	public function RenderForm($params)
	{

		$form = '';

		if($params['paymentmethod'] == CatalogMgr::PM_YAMONEY)
		{
			$form .= '<span class="pm-notif">Перенаправление на <span class="pm-system">Яндекс.Деньги</span> для оплаты</span>';
		}
		elseif($params['paymentmethod'] == CatalogMgr::PM_CARD)
		{
			$form .= '<span class="pm-notif">Переход для оплаты заказа банковской картой';
		}

		$form .= '<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml" id="pay-form">';
		$form .= '<input type="hidden" name="receiver" value="410012859259841">';
		$form .= '<input type="hidden" name="formcomment" value="Интернет-магазин НайсПрайс. Оплата заказа №'.$params["orderid"].'">';
		$form .= '<input type="hidden" name="short-dest" value="Оплата заказа №'.$params["orderid"]. ' в магазине НайсПрайс">';
		$form .= '<input type="hidden" name="label" value="'.$params["orderid"].'">';
		$form .= '<input type="hidden" name="quickpay-form" value="small">';
		$form .= '<input type="hidden" name="targets" value="транзакция '.$params["orderid"].'">';
		$form .= '<input type="hidden" name="sum" value="'.$params["amount"].'" data-type="number" >';
		$form .= '<input type="hidden" name="comment" value="Оплата заказа в магазине НайсПрайс. Номер заказа: '.$params["orderid"].'" >';
		$form .= '<input type="hidden" name="need-fio" value="false">';
		$form .= '<input type="hidden" name="need-email" value="false" >';
		$form .= '<input type="hidden" name="need-phone" value="false">';
		$form .= '<input type="hidden" name="need-address" value="false">';
		// $form .= '<input type="hidden" name="successURL" value="http://np.homyakov.devel.zgalex.com/catalog/notification/order_checkout/?oid='.$params["orderid"].'">';
		$form .= '<input type="hidden" name="successURL" value="'.$this->successurl.'?oid='.$params["orderid"].'">';

		if($params['paymentmethod'] == CatalogMgr::PM_YAMONEY)
		{
			$form .= '<input type="hidden" name="paymentType" value="PC">';
		}
		elseif($params['paymentmethod'] == CatalogMgr::PM_CARD)
		{
			$form .= '<input type="hidden" name="paymentType" value="AC">';
		}
		$form .= '</form>';

		return $form;

	}

	public function IsValidPayment($params)
	{
		$notification_type = $params['notification_type'];
		$operation_id      = $params['operation_id'];
		$amount            = $params['amount'];
		$currency          = $params['currency'];
		$datetime          = $params['datetime'];
		$sender            = $params['sender'];
		$codepro           = $params['codepro'];
		$label             = $params['label'];
		$sha1_hash         = $params['sha1_hash'];

		$valid_str = $notification_type."&".$operation_id."&".$amount."&".$currency."&".$datetime."&".$sender."&".$codepro."&".$this->secret."&".$label;
		// notification_type&operation_id&amount&currency&datetime&sender&codepro&notification_secret&label

		$sha1 = hash("sha1", $valid_str);

		if($sha1 != $sha1_hash)
			return false;

		return true;
	}

	public function __set($name, $value)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'fields':
				$arr = array();
				foreach($value as $k => $item)
				{
					if(empty($item))
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
		switch($name)
		{
			case 'type':
				return PaymentMgr::getInstance()->GetPayment($this->PaymentID);
			case 'fields':
				return unserialize($this->Fields);
			case 'wallet':
				return $arrFields['wallet'];
			case 'secret':
				return $arrFields['secret'];
			case 'successurl':
				return $arrFields['successurl'];
		}

		return null;
	}

	function __destruct()
	{

	}
}
?>