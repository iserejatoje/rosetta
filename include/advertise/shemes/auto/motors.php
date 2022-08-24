<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_motors extends AdvSheme_auto
{
	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic', 'rudder',
		'year', 'mileage', 'enginepower', 'fuel', 'drive', 'gearbox', 'status');

	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BodyType']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Metallic']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Rudder']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Year']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Mileage']			= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['EnginePower']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Fuel']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Drive']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Gearbox']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );			

		parent::__construct($path, $prefix);
						
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_cars'));		
				
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_cars_options',
				'Photo'  	=> '_cars_photo',
				'Favorite'  => '_cars_favorites',
			)
		);				
		
	}	
}


class AdvIterator_auto_motors extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand','Moderate','Remoderate','IsNew', 'Model', 'BodyType', 'Color', 'Metallic', 'Rudder',
		'Year', 'Mileage', 'EnginePower', 'Fuel', 'Drive', 'Gearbox', 'Status', 'Favorite','Important'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_motors extends Adv_auto
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( !isset($this->data['Brand']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BRAND);
				error_log("ERR_L_AUTO_BRAND");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Model']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_MODEL);
				error_log("ERR_L_AUTO_MODEL");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['BodyType']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BODYTYPE);
				error_log("ERR_L_AUTO_BODYTYPE");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Color']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_COLOR);
				error_log("ERR_L_AUTO_COLOR");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Year']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_YEAR);
				error_log("ERR_L_AUTO_YEAR");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Mileage']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_MILEAGE);
				error_log("ERR_L_AUTO_MILEAGE");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['EnginePower']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_ENGINEPOWER);
				error_log("ERR_L_AUTO_ENGINEPOWER");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Fuel']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_FUEL);
				error_log("ERR_L_AUTO_FUEL");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Gearbox']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_GEARBOX);
				error_log("ERR_L_AUTO_GEARBOX");
			}
			$is_valid = false;
		}
						
		if ( !isset($this->data['Drive']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_DRIVE);
				error_log("ERR_L_AUTO_DRIVE");
			}
			$is_valid = false;
		}
		
		if ( !isset($this->data['Status']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_STATUS);
				error_log("ERR_L_AUTO_STATUS");
			}
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>