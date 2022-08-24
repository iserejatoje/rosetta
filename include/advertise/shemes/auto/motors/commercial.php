<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/motors.php';

class AdvSheme_auto_motors_commercial extends AdvSheme_auto_motors
{
	public $RubricID = 13;
	
	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic', 'rudder',
		'year', 'mileage', 'enginepower', 'fuel', 'drive', 'gearbox', 'status', 'enginecapacity',
		'vanvolume', 'seats', 'capacity');
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['VanVolume']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Seats']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Capacity']			= array( 'type' => 'int' );
		
		parent::__construct($path, $prefix);
		
		$this->Config['bodytype'] =  array (
				30	=> 'Автобус',
				31 	=> 'Бортовой грузовик',
				32 	=> 'Внедорожник',
				33 	=> 'Микроавтобус',
				34 	=> 'Минивэн',
				35 	=> 'Пикап',
				36 	=> 'Рефрижератор',
				37 	=> 'Фургон',
				38 	=> 'Фургон грузовой',
				39 	=> 'Фургон изотермический',
				40 	=> 'Фургон промтоварный',
				41 	=> 'Фургон рефрижератор',
				42 	=> 'Шасси',
				43 	=> 'Эвакуатор',
			);
		
		$this->Config['drive'] =  array (
				14	=> 'Передний',
				15 	=> 'Задний',
				16 	=> 'Полный',
				17 	=> 'С раздачей',				
			);
			
		$this->Config['gearbox'] =  array (
				0	=> 'автоматическая',
				1 	=> 'вариаторная',
				2 	=> 'механическая',
				4 	=> 'секвентальная',				
			);
			
		$this->Config['options'] =  array (
				110	=> 'ABS (антиблокировочная система)',
				111	=> 'CD Чейнджер',
				112	=> 'CD проигрыватель',
				113	=> 'MP3 проигрыватель',
				114	=> 'Автономный обогрев кабины',
				115	=> 'Боковые подушки безопасности водителя и переднего пассажира',
				116	=> 'Боковые шторки безопасности',
				117	=> 'Гидроусилитель руля',
				118	=> 'Кондиционер',
				119	=> 'Круиз-контроль',
				120	=> 'Люк',
				121	=> 'Магнитола',
				122	=> 'Подушка безопасности водителя',
				123	=> 'Подушка безопасности переднего пассажира',
				124	=> 'Сигнализация',
				125	=> 'Стояночный отопитель',
				126	=> 'Центральный замок',
				127	=> 'Электрический прогрев двигателя',
				128	=> 'Электрозеркала',
				129	=> 'Электростеклоподъемники',
			);
	}
}

class AdvIterator_auto_motors_commercial extends AdvIterator_auto_motors
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'BodyType', 'Color', 'Metallic', 'Rudder',
		'Year', 'Mileage', 'EnginePower', 'Fuel', 'Drive', 'Gearbox', 'Status', 'EngineCapacity', 
		'VanVolume', 'Seats','Moderate','Remoderate','IsNew', 'Capacity', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_motors_commercial extends Adv_auto_motors
{
}

?>