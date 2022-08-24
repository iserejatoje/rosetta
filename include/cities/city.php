<?
class City
{
	public $ID;
	public $Name;
	public $NameID;
	public $Street;
	public $Domain;
	public $CatalogId;
	public $PhoneCode;
	public $Phone;
	public $Latitude;
	public $Longitude;
	public $SEOText;
	public $Metrika;
	private $Created;
	private $LastUpdated;
	public $IsVisible;
    public $IsDefault;


	private $photo_file_size = 2097152; //2Mb

	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['cityid']) && Data::Is_Number($info['cityid']) )
			$this->ID = $info['cityid'];
		$this->Name        = $info['name'];
		$this->NameID        = $info['nameid'];
		$this->Street      = $info['street'];
		$this->Domain      = $info['domain'];
		$this->CatalogId   = $info['catalogid'];
		$this->PhoneCode   = $info['phonecode'];
		$this->Phone       = $info['phone'];
		$this->Latitude    = $info['latitude'];
		$this->Longitude   = $info['longitude'];
		$this->SEOText     = $info['seotext'];
		$this->Metrika     = $info['metrika'];
		$this->Created     = $info['created'];
        $this->LastUpdated = $info['lastupdated'];
		$this->IsVisible   = $info['isvisible'];
		$this->IsDefault   = $info['isdefault'];
	}

	public function Update()
	{
		$info = array(
			'Name'      => $this->Name,
			'NameID'    => $this->NameID,
			'Street'    => $this->Street,
			'Domain'    => $this->Domain,
			'CatalogId' => $this->CatalogId,
			'PhoneCode' => $this->PhoneCode,
			'Phone'     => $this->Phone,
			'Latitude'  => $this->Latitude,
			'Longitude' => $this->Longitude,
			'SEOText'   => addslashes($this->SEOText),
			'Metrika'   => addslashes($this->Metrika),
			'IsVisible' => $this->IsVisible,
            'IsDefault' => $this->IsDefault,
		);

		if ( $this->ID !== null ) {
			$info['CityID'] = $this->ID;
			if (CitiesMgr::getInstance()->UpdateCity($info) !== false)
				return true;
		} else if ( ($new_id = CitiesMgr::getInstance()->AddCity($info)) !== false) {
			$this->ID = $new_id;
			return $new_id;
		}

		return false;
	}

	public function Remove()
	{
		if ( $this->ID === null)
			return false;

		CitiesMgr::getInstance()->RemoveCity($this->ID);
	}

	public function __set($name, $value)
	{
		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

		$name = strtolower($name);
		switch($name)
		{
			case 'created':
				$this->Created = date('Y-m-d H:i:s', $value);
			case 'lastupdated':
				$this->LastUpdated = date('Y-m-d H:i:s', $value);
		}
		return null;
	}

	public function GetDefaultDistrict()
	{
		$filter = [
			'flags' => [
				'objects' => true,
				'IsVisible' => -1,
				'IsDefault' => 1,
				'CityID' => $this->ID,
			],
			'field' => [],
			'dir' => [],
			'calc' => false,
			'dbg' => 0,
		];

		$districts = CitiesMgr::getInstance()->GetDistricts($filter);

		if(count($districts) == 0) {
			unset($filter['flags']['IsDefault']);
			$districts = CitiesMgr::getInstance()->GetDistricts($filter);
		}

		return $districts[0];
	}

	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'created':
				return strtotime($this->Created);
			case 'lastupdated':
				return strtotime($this->LastUpdated);
			case 'clearseo':
				return stripcslashes($this->SEOText);
			case 'districts':
				$filter = [
					'flags' => [
						'objects' => true,
						'IsVisible' => 1,
						'CityID' => $this->ID,
					],
				];

				$districts = CitiesMgr::getInstance()->GetDistricts($filter);
				return $districts;
			break;

            case 'stores':
                $filter = [
                    'flags' => [
                        'objects' => true,
                        'IsVisible' => 1,
                        'CityID' => $this->ID,
                    ],
                    'field' => ['ord'],
                    'dir' => ['ASC'],
                ];

                $stores = CitiesMgr::getInstance()->GetStores($filter);
                return $stores;
            break;

			case 'delivery_list':
				$filter = array(
					'flags' => array(
						'objects'     => true,
						'CityID'      => $this->ID,
						'IsAvailable' => 1,
					),
				);

				$list = CitiesMgr::getInstance()->GetDeliveries($filter);
				return $list;
				break;

			case 'catalog_id':
				return $this->CatalogId;
				break;
		}

		return null;
	}

	function __destruct()
	{

	}
}
?>