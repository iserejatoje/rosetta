<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/houses.php';

class AdvSheme_realty_houses_offer extends AdvSheme_realty_houses
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_houses_offer',
			'slaves' => array(
				'Photo' 	=> '_houses_offer_photo',
				'Options' 	=> '_houses_offer_options',
				'Favorite'	=> '_houses_offer_favorites',
			)
		);
		// скалярные поля
		$this->sheme['scalar_fields']['opt_Photo'] 	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Photo']		= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_houses_offer extends AdvIterator_realty_houses
{
}

class Adv_realty_houses_offer extends Adv_realty_houses
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
		if ( empty($this->data['BuildingArea']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_BUILDINGAREA);
			$is_valid = false;
		}
		if ( empty($this->data['LandArea']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_LANDAREA);
			$is_valid = false;
		}
		if ( empty($this->data['HouseType']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_HOUSETYPE);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>