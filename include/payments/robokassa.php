<?
class Robokassa extends Account
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

	public function GetPayUrl($params)
	{
		// if(empty($params['OutSum']) || $params['OutSum'] == 0)
		// 	return false;

		// if(empty($params['InvID']) || $params['InvID'] == 0)
		// 	return false;

		$pay_params = array(
			'MrchLogin'      => $this->Login,
			'OutSum'         => $params['OutSum'],
			'InvId'          => $params['InvId'],
			'Desc'           => $params['Desc'],
			'SignatureValue' => $this->GenerateMD5($params['OutSum'], $params['InvId']),
			'IncCurrLabel'   => "",
			'Culture'        => "ru",
			'Encoding'       => "utf-8",
		);

		$str = array();
		foreach($pay_params as $k => $v)
			$str[] = $k."=".$v;

		if(MODE == 'dev')
			$url = "http://test.robokassa.ru/Index.aspx?".implode('&',$str);			
		else
			$url = "https://merchant.roboxchange.com/Index.aspx?".implode('&',$str);

		return $url;
	}


	public function GenerateMD5($summ, $invid, $hash)
	{
		if($hash)
			return md5($this->Login.":".$summ.":".$invid.":".$this->pass1.":shphash=".$hash);
		else
			return md5($this->Login.":".$summ.":".$invid.":".$this->pass1);
	}

	public function GeneratePaymentMD5($summ, $invid, $hash)
	{
		if($hash)
			return strtoupper(md5($summ.":".$invid.":".$this->pass2.":shphash=".$hash));
		else
			return strtoupper(md5($summ.":".$invid.":".$this->pass2));
	}

	public function GenerateFailureMD5($summ, $invid, $hash)
	{
		return md5($summ.":".$invid.":".self::$mrh_pass.":shphash=".$hash);
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
			case 'login':
				return $arrFields['login'];
			case 'pass':
				return $arrFields['pass'];
			case 'pass1':
				return $arrFields['pass1'];
			case 'pass2':
				return $arrFields['pass2'];
		}

		return null;
	}

	function __destruct()
	{

	}
}
?>