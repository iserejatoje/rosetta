<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty.php';

class AdvSheme_realty_change extends AdvSheme_realty
{
	public $Rubric = 99;
	
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_change',
			'slaves' => array(
				'Object' 	=> '_change_objects',
				'Photo'		=> '_change_photo',
				'Favorite'	=> '_change_favorites',
			)
		);
		
		// скалярные поля
		$this->sheme['scalar_fields']['Sheme']		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['NeedExPay']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['OfferExPay']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['opt_Photo']	= array( 'type' => 'int' );
		
		// векторные поля
		$this->sheme['vector_fields']['Object']		= array( 'type' => 'array', 'fields' => array('ObjectType','Object','Address','House','Area','Details','opt_Address'), 'order' => 'ObjectID' );
		$this->sheme['vector_fields']['Photo']		= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );
		
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_change extends AdvIterator_realty
{
}

class Adv_realty_change extends Adv_realty
{
	const OT_OBJECT_NEEDED	= 0;
	const OT_OBJECT_OFFERED	= 1;

	public function IsValid()
	{
		global $OBJECTS;

		$is_valid = true;
		if ( count($this->data['Object']) == 0 )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_CHANGEOBJECTS);
			$is_valid = false;
		}
		else
		{
			$nc = $oc = 0;
			foreach ( $this->data['Object'] as $o )
			{
				if ( $o['ObjectType'] == self::OT_OBJECT_NEEDED ) $nc++;
				else if ( $o['ObjectType'] == self::OT_OBJECT_OFFERED )
				{
					if ( (empty($o['Address']) || $o['Address'] == 0) && $this->sheme->_config['arrays']['ChangeObjectType'][$o['Object']]['adress'] )
						$OBJECTS['uerror']->AddError(ERR_L_REALTY_ADDRESS);
					$oc++;
				}
			}
			if ( $nc == 0 || $oc == 0 )
			{
				if ( is_object($OBJECTS['uerror']) )
					$OBJECTS['uerror']->AddError(ERR_L_REALTY_CHANGEOBJECTS);
				$is_valid = false;
			}
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>