<?php

class District
{
    private $_mgr;

    public $ID;
    public $Created;
    public $LastUpdated;
    private $Price;
    public $IsAvailable;
    public $IsDefault;
    // public $DeliveryID;
    public $CityID;
    public $Name;
    public $Ord;
    public $AccountID;


    function __construct(array $info)
    {
        global $OBJECTS;

        $info = array_change_key_case($info, CASE_LOWER);

        if ( isset($info['districtid']) && Data::Is_Number($info['districtid']) )
            $this->ID = $info['districtid'];

        $this->Created     = $info['created'];
        $this->LastUpdated = $info['lastupdated'];
        // $this->DeliveryID  = intval($info['deliveryid']);
        $this->CityID      = intval($info['cityid']);
        $this->AccountID   = intval($info['accountid']);
        $this->IsDefault   = intval($info['isdefault']);
        $this->Name        = stripslashes($info['name']);
        // $this->Email    = stripslashes($info['email']);
        $this->Price       = Data::NormalizeFloat($info['price']);
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
            // 'Email'    => $this->Email,
            'IsAvailable' => (int)$this->IsAvailable,
            'IsDefault'   => (int)$this->IsDefault,
            // 'DeliveryID'  => (int) $this->DeliveryID,
            'CityID'      => (int)$this->CityID,
            'Price'       => Data::NormalizeFloat($this->Price),
            'Ord'         => (int)$this->Ord,
            'AccountID'   => (int)$this->AccountID,
        );

        if ( $this->ID !== null ) {
            $info['DistrictID'] = $this->ID;
            if ( false !== CitiesMgr::getInstance()->UpdateDistrict($info)) {
                return true;
            }
        } else if ( false !== ($new_id = CitiesMgr::getInstance()->AddDistrict($info))) {
            $this->ID = $new_id;

            return $new_id;
        }

        return false;
    }

    public function Remove() {
        if ( $this->ID === null)
            return false;

        CitiesMgr::getInstance()->RemoveDistrict($this->ID);
    }


    public function AsArray()
    {
        return array(
            'DistrictID'  => $this->ID,
            'Name'        => $this->Name,
            // 'DeliveryID'  => $this->DeliveryID,
            'CityID'      => $this->CityID,
            'IsAvailable' => (int) $this->IsAvailable,
            'IsDefault' => (int) $this->IsDefault,
            'Ord'         => (int) $this->Ord,
            'Price'       => $this->Price,
            'AccountID'   => $this->AccountID,
        );
    }

    public function __set($name, $value) {
        $name = strtolower($name);
        switch($name) {
            case 'price':
                $this->Price = Data::NormalizeFloat((float) $value);
            break;
        }
        return null;
    }

    public function __get($name) {

        $name = strtolower($name);
        switch($name) {
            case 'price':
                return $this->Price;
            case 'city':
                return CitiesMgr::getInstance()->GetCity($this->CityID);
            break;
        }

        return null;
    }

    function __destruct()
    {

    }
}

