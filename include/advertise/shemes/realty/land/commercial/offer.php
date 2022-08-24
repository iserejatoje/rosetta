<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/land.php';

class AdvSheme_realty_land_commercial_offer extends AdvSheme_realty_land
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_land_offer',
			'slaves' => array(
				'Photo' 	=> '_land_offer_photo',
				'Options' 	=> '_land_offer_options',
				'Favorite'	=> '_land_offer_favorites',
			)
		);
		// скалярные поля
		$this->sheme['scalar_fields']['opt_Photo'] 	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Photo']		= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_land_commercial_offer extends AdvIterator_realty_land
{
}

class Adv_realty_land_commercial_offer extends Adv_realty_land
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
		/*if ( !empty($this->data['Address']) )
		{
			if ( empty($this->data['Area']) && Location::GetAreasCount(Location::ParseCode($this->data['Address'])) > 0 )
			{
				if ( is_object($OBJECTS['uerror']) )
					$OBJECTS['uerror']->AddError(ERR_L_REALTY_AREA);
				$is_valid = false;
			}
		}*/
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