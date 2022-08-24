<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/new.php';

class AdvSheme_realty_new_offer extends AdvSheme_realty_new
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_new_offer',
			'slaves' => array(
				'Photo' 	=> '_new_offer_photo',
				'Options' 	=> '_new_offer_options',
				'Favorite'	=> '_new_offer_favorites',
			)
		);
		
		// скалярные поля
		$this->sheme['scalar_fields']['opt_Photo'] 	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Photo']		= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_new_offer extends AdvIterator_realty_new
{
}

class Adv_realty_new_offer extends Adv_realty_new
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
		if ( empty($this->data['BuildingType']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_BUILDINGTYPE);
			$is_valid = false;
		}
		if ( empty($this->data['Series']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_SERIES);
			$is_valid = false;
		}
		if ( empty($this->data['Floors']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_FLOORS);
			$is_valid = false;
		}
		if ( empty($this->data['Floor']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_FLOOR);
			$is_valid = false;
		}
		if ( empty($this->data['BuildingArea']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_BUILDINGAREA);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>