<?
class Robokassa
{
	public $ID;
	public $Name;
	public $PaymentID;
	private $Fields;
	
	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);
		
		if ( isset($info['accountid']) && Data::Is_Number($info['accountid']) )
			$this->ID = $info['accountid'];
		$this->Name      = $info['name'];
		$this->PaymentID = $info['paymentid'];
		$this->Fields    = $info['fields'];
	}

	public function Update()
	{
		$info = array(
			'PaymentID' => $this->PaymentID,
			'Fields'    => $this->Fields,
			'Name'    => $this->Name,
		);

		if ( $this->ID !== null )
		{
			$info['AccountID'] = $this->ID;
			if (PaymentMgr::getInstance()->UpdateAccount($info) !== false) 
				return true;
		} 
		else if ( ($new_id = PaymentMgr::getInstance()->AddAccount($info)) !== false)
		{
			$this->ID = $new_id;
			return $new_id;
		}
		
		return false;
	}
	
	public function Remove() 
	{	
		if ( $this->ID === null)
			return false;

		PaymentMgr::getInstance()->RemoveAccount($this->ID);
	}

	public function __set($name, $value) 
	{	
		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

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
			case 'merchant':
				return $arrFields['Merchant'];
		}

		return null;
	}

	function __destruct()
	{

	}
}
?>