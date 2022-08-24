<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/foreign.php';

class AdvSheme_realty_foreign_secondary extends AdvSheme_realty_foreign
{
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Decoration'] = array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Lifetime']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Floor']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Windows']	= array( 'type' => 'int' );
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_foreign_secondary extends AdvIterator_realty_foreign
{
}

class Adv_realty_foreign_secondary extends Adv_realty_foreign
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