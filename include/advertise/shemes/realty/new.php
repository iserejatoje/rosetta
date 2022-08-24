<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty.php';

class AdvSheme_realty_new extends AdvSheme_realty
{
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Details']		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Price']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Price2']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['PriceUnit'] 		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['MapX']			= array( 'type' => 'float' );
		$this->sheme['scalar_fields']['MapY']			= array( 'type' => 'float' );
		$this->sheme['scalar_fields']['SpanX']			= array( 'type' => 'float' );
		$this->sheme['scalar_fields']['SpanY']			= array( 'type' => 'float' );
		$this->sheme['scalar_fields']['Address']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['opt_Address']		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['House'] 				= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Area'] 				= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['LandmarkID'] 		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BuildingType'] 		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Series'] 			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['DeadlineYear'] 		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['DeadlineQuarter'] 	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BuildingStage']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['RoomCount']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Floors']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Floor']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BuildingArea']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Decoration']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Windows']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Lavatory']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['ImportID']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['IsAddressValid']	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Options']			= array( 'type' => 'int' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_new extends AdvIterator_realty
{
}

class Adv_realty_new extends Adv_realty
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['RoomCount']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_ROOMCOUNT);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>