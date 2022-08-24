<?php

class Store
{
	private $_mgr;

	public $ID;
	public $DeliveryID; // Город доставки

	public $Name;
	public $Address;
	public $Created;
	public $LastUpdated;
	public $IsAvailable;
	public $PhoneCode;
	public $Phone;
	public $Latitude;
	public $Longitude;
	public $Email;
	public $HasPickup;
	public $Ord;
	public $AccountID;
	public $CityID;
    public $Workmode;
	public $Type;


	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['storeid']) && Data::Is_Number($info['storeid']) )
			$this->ID = $info['storeid'];

		$this->Created     = $info['created'];
		$this->LastUpdated = $info['lastupdated'];
		$this->DeliveryID  = intval($info['deliveryid']);
		$this->AccountID   = intval($info['accountid']);
        $this->CityID      = intval($info['cityid']);
		$this->Type      = intval($info['type']);
		$this->Name        = stripslashes($info['name']);
		$this->Address     = stripslashes($info['address']);
		$this->Email       = stripslashes($info['email']);
		$this->Phone       = stripslashes($info['phone']);
		$this->PhoneCode   = stripslashes($info['phonecode']);
		$this->Latitude    = stripslashes($info['latitude']);
		$this->Longitude   = stripslashes($info['longitude']);
		$this->Workmode    = stripslashes($info['workmode']);

		$this->IsAvailable = $info['isavailable']  ? true : false;
		$this->HasPickup = $info['haspickup']  ? true : false;

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
			'Address'     => $this->Address,
			'Email'       => $this->Email,
			'Phone'       => $this->Phone,
			'PhoneCode'   => $this->PhoneCode,
			'Latitude'    => $this->Latitude,
			'Longitude'   => $this->Longitude,
			'Workmode'    => $this->Workmode,
			'IsAvailable' => (int) $this->IsAvailable,
			'HasPickup'   => (int) $this->HasPickup,
			'DeliveryID'  => (int) $this->DeliveryID,
			'CityID'      => (int) $this->CityID,
			'Ord'         => (int) $this->Ord,
            'AccountID'   => (int) $this->AccountID,
			'Type'   => (int) $this->Type,
		);

		if ( $this->ID !== null ) {
			$info['StoreID'] = $this->ID;
			if ( false !== CitiesMgr::getInstance()->UpdateStore($info)) {
				return true;
			}
		} else if ( false !== ($new_id = CitiesMgr::getInstance()->AddStore($info))) {
			$this->ID = $new_id;

			return $new_id;
		}

		return false;
	}

	public function Remove() {
		if ( $this->ID === null)
			return false;

		CitiesMgr::getInstance()->RemoveStore($this->ID);
	}


	public function AsArray()
	{
		return array(
			'StoreID'     => $this->ID,
			'Name'        => $this->Name,
			'Address'     => $this->Address,
			'Email'       => $this->Email,
			'Phone'       => $this->Phone,
			'PhoneCode'   => $this->PhoneCode,
			'Longitude'   => $this->Longitude,
			'Latitude'    => $this->Latitude,
			'DeliveryID'  => $this->DeliveryID,
			'CityID'      => $this->CityID,
			'IsAvailable' => (int) $this->IsAvailable,
			'HasPickup'   => (int) $this->HasPickup,
			'Ord'         => (int) $this->Ord,
			'Price'       => $this->Price,
			'Workmode'    => $this->Workmode,
            'AccountID'   => $this->AccountID,
			'Type'   => $this->Type,
		);
	}

	public function __set($name, $value) {
		$name = strtolower($name);
		switch($name) {
		}
		return null;
	}

	public function __get($name) {

		$name = strtolower($name);
		switch($name) {
			case 'city':
				return CitiesMgr::getInstance()->GetCity($this->CityID);

            case 'photos':
                $filter = [
                    'flags' => [
                        'objects' => true,
                        'IsVisible' => 1,
                        'StoreID' => $this->ID,
                    ],
                    'field' => [],
                    'dir' => [],
                    'calc' => false,
                    'dbg' => 0,
                ];

                return CitiesMgr::getInstance()->GetPhotos($filter);
		}

		return null;
	}

	function __destruct()
	{

	}
}

