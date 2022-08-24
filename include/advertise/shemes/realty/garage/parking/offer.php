<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/garage.php';

class AdvSheme_realty_garage_parking_offer extends AdvSheme_realty_garage
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_parking_offer',
			'slaves' => array(
				'Photo' 	=> '_parking_offer_photo',
				'Options' 	=> '_parking_offer_options',
				'Favorite'	=> '_parking_offer_favorites',
			)
		);
		// скалярные поля
		$this->sheme['scalar_fields']['LandArea']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['opt_Photo'] 	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Photo']		= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_garage_parking_offer extends AdvIterator_realty_garage
{
}

class Adv_realty_garage_parking_offer extends Adv_realty_garage
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['Address']) || $this->data['Address'] == 0 )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_ADDRESS);
			$is_valid = false;
		}
		if ( !empty($this->data['Address']) )
		{
			if ( empty($this->data['Area']) && Location::GetAreasCount(Location::ParseCode($this->data['Address'])) > 0 )
			{
				if ( is_object($OBJECTS['uerror']) )
					$OBJECTS['uerror']->AddError(ERR_L_REALTY_AREA);
				$is_valid = false;
			}
		}
		if ( empty($this->data['LandArea']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_LANDAREA);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>