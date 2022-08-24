<?php

class DeliveryCity
{
	private $_mgr;

	public $ID;
	public $Created;
	public $LastUpdated;
	// private $Price;
	public $IsAvailable;
	public $CityID;
	public $Name;
	public $Email;
	public $Ord;


	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['deliveryid']) && Data::Is_Number($info['deliveryid']) )
			$this->ID = $info['deliveryid'];

		$this->Created     = $info['created'];
		$this->LastUpdated = $info['lastupdated'];
		$this->CityID      = intval($info['cityid']);
		$this->Name        = stripslashes($info['name']);
		$this->Email        = stripslashes($info['email']);
		// $this->Price    = Data::NormalizeFloat($info['price']);
		$this->IsAvailable = $info['isavailable']  ? true : false;

		$this->Ord = 0;
		if ( isset($info['ord']) )
			$this->Ord = (int) $info['ord'];
	}

	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод 
	 */
	public function Update()
	{
		$info = array(
			'Name'        => $this->Name,
			'Email'       => $this->Email,
			'IsAvailable' => (int) $this->IsAvailable,
			'CityID'      => (int) $this->CityID,
			'Ord'         => (int) $this->Ord,
		);

		if ( $this->ID !== null ) {
			$info['DeliveryID'] = $this->ID;
			if ( false !== CitiesMgr::getInstance()->UpdateDelivery($info)) {
				return true;
			}
		} else if ( false !== ($new_id = CitiesMgr::getInstance()->AddDelivery($info))) {
			$this->ID = $new_id;

			return $new_id;
		}

		return false;
	}

	public function Remove() {
		if ( $this->ID === null)
			return false;

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsAvailable' => -1,
				'DeliveryID' => $this->ID,
			),
		);

		$districts = CitiesMgr::getInstance()->GetDistricts($filter);
		foreach($districts as $district)
			$district->Remove();

		$stores = CitiesMgr::getInstance()->GetStores($filter);
		foreach($stores as $store)
			$store->Remove();

		CitiesMgr::getInstance()->RemoveDelivery($this->ID);
	}


	public function AsArray()
	{
		return array(
			'DeliveryID'  => $this->ID,
			'Name'        => $this->Name,
			'Email'        => $this->Email,
			'CityID'      => $this->CityID,
			'IsAvailable' => (int) $this->IsAvailable,
			'Ord'         => (int) $this->Ord,
			// 'Price'       => $this->Price,
		);
	}


	public function __set($name, $value) {
		$name = strtolower($name);
		switch($name) {
			// case 'price':
			// 	$this->Price = Data::NormalizeFloat((float) $value);
			// break;
		}
		return null;
	}

	public function __get($name) {

		$name = strtolower($name);
		switch($name) {
		}

		return null;
	}

	function __destruct()
	{

	}
}

