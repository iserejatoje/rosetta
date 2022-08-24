<?php

class PlaceExtraLocation
{
	public $ID;
	public $PlaceID;
	public $Location;
	public $LandmarkID;
	public $House;
	public $Phones;
	public $Text;
	
	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['locid']) && Data::Is_Number($info['locid']) )
			$this->ID = $info['locid'];

		$this->PlaceID = 0;
		if ( Data::Is_Number($info['placeid']) )
			$this->PlaceID = $info['placeid'];
		
		$this->Location		= $info['location'];
		
		$this->House			= str_replace("-", " ", $info['house']);
		
		$this->Text			= $info['text'];
		$this->Phones			= $info['phones'];

		$this->LandmarkID	= 0;
		if (isset($info['landmarkid']) && Data::Is_Number($info['landmarkid']))
			$this->LandmarkID		= $info['landmarkid'];
	}
	
	public function Remove() {
		if ( $this->ID === null)
			return false;
		
		PlaceExtraLocationMgr::getInstance()->Remove($this->ID);
	}
	
	public function Update()
	{
		$info = array(
			'PlaceID'			=> $this->PlaceID,
			'Location'		=> $this->Location,
			'House'			=> $this->House,
			'Phones'			=> $this->Phones,
			'LandmarkID'	=> intval($this->LandmarkID),
			'Text'				=> $this->Text,
		);

		if ( $this->ID !== null ) {
			$info['LocID'] = $this->ID;
			return PlaceExtraLocationMgr::getInstance()->Update($info);
		
		} else if ( false !== ($new_id = PlaceExtraLocationMgr::getInstance()->Add($info))) {
			$this->ID = $new_id;
		
			return $new_id;
		}

		return false;
	}
	
	public function __set($name, $value) {
		return null;
	}

	public function __get($name) {
		return null;
	}

	function __destruct(){

	}
}