<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/motors.php';

class AdvSheme_auto_motors_rus extends AdvSheme_auto_motors
{
	public $RubricID = 8;
	
	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic', 'rudder',
		'year', 'mileage', 'enginepower', 'fuel', 'drive', 'gearbox', 'status', 'enginecapacity',
		'enginetype');
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['EngineType']	= array( 'type' => 'int' );
		
		parent::__construct($path, $prefix);
	}
}

class AdvIterator_auto_motors_rus extends AdvIterator_auto_motors
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'BodyType', 'Color', 'Metallic', 'Rudder',
		'Year', 'Mileage', 'EnginePower','Moderate','Remoderate','IsNew', 'Fuel', 'Drive', 'Gearbox', 'Status', 'EngineCapacity', 'Favorite','Important',
		'EngineType', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_motors_rus extends Adv_auto_motors
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['EngineCapacity']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_ENGINECAPACITY);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>