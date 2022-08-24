<?
class Payment
{
	public $ID;
	public $Name;
	public $NameID;
	private $Fields;
	
	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);
		
		if ( isset($info['paymentid']) && Data::Is_Number($info['paymentid']) )
			$this->ID = $info['paymentid'];
		$this->Name   = $info['name'];
		$this->NameID = $info['nameid'];
		$this->Fields = $info['fields'];
	}

	public function Update()
	{
		$info = array(
			'Name'   => $this->Name,
			'NameID' => $this->NameID,
			'Fields' => $this->Fields,
		);
		
		if ( $this->ID !== null )
		{
			$info['PaymentID'] = $this->ID;
			if (PaymentMgr::getInstance()->UpdatePayment($info) !== false) 
				return true;
		} 
		else if ( ($new_id = PaymentMgr::getInstance()->AddPayment($info)) !== false)
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

		PaymentMgr::getInstance()->RemovePayment($this->ID);
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
				foreach($value as $item)
				{
					if(empty($item))
						continue;

					$arr[] = $item;
				}
				$this->Fields = serialize($arr);
			break;
		}
		return null;
	}

	public function __get($name) 
	{
		$name = strtolower($name);
		switch($name) 
		{
			case 'fields':
				return unserialize($this->Fields);
		}

		return null;
	}

	function __destruct()
	{

	}
}
?>