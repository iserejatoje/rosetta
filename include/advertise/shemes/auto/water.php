<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_water extends AdvSheme_auto
{
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic', 'year' );

	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Metallic']				= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Year']					= array( 'type' => 'int' );	

		parent::__construct($path, $prefix);
		
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_water'));		
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_water_options',
				'Photo'  	=> '_water_photo',
				'Favorite'  => '_water_favorites',
			)
		);
	}
}


class AdvIterator_auto_water extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID','Moderate','Remoderate','IsNew', 'AllowIM',  'Brand', 'Model', 'Color', 'Metallic',
		'Year', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_water extends Adv_auto
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['Brand']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BRAND);
			$is_valid = false;
		}
		
		if ( empty($this->data['Model']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_MODEL);
			$is_valid = false;
		}
				
		if ( empty($this->data['Color']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_COLOR);
			$is_valid = false;
		}
		
		if ( empty($this->data['Year']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_YEAR);
			$is_valid = false;
		}
					
		return ( parent::IsValid() && $is_valid );
	}
}

?>