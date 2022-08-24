<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/motors.php';

class AdvSheme_auto_motors_buses extends AdvSheme_auto_motors
{
	public $RubricID = 11;
	
	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic', 'rudder',
		'year', 'mileage', 'enginepower', 'fuel', 'drive', 'gearbox', 'status', 'enginecapacity',
		'vanvolume', 'seats');
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['VanVolume']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Seats']				= array( 'type' => 'int' );
	
		parent::__construct($path, $prefix);
		
		
		$this->Config['drive'] =  array (
				14	=> 'Передний',
				15 	=> 'Задний',
				16 	=> 'Полный',
				17 	=> 'С раздачей',				
			);
			
		$this->Config['bodytype'] =  array (
				201 => 'Вахтовый',
				202 => 'Городской',
				203 => 'Междугородный',
				204 => 'Пригородный',
				205 => 'Cпециальный',
				206 => 'Туристический',
				207 => 'Школьный',
			);
		
		$this->Config['options'] =  array (
				93	=> 'Антиблокировочная система(ABS)',
				94	=> 'Багажное отделение',
				95	=> 'Занавески',
				96	=> 'Кондиционер',
				97	=> 'Навигационная система',
				98	=> 'Ретардер',
				99	=> 'Светильники у пассажиров',
				100	=> 'Телевизор',
				101	=> 'Тонированные стекла',
				102	=> 'Туалет',				
			);
	}
}

class AdvIterator_auto_motors_buses extends AdvIterator_auto_motors
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'BodyType', 'Color', 'Metallic', 'Rudder',
		'Year', 'Mileage', 'EnginePower', 'Fuel', 'Drive', 'Gearbox', 'Status', 'EngineCapacity', 
		'VanVolume', 'Seats','Moderate','Remoderate','IsNew', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_motors_buses extends Adv_auto_motors
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