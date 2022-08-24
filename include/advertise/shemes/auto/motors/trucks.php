<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/motors.php';

class AdvSheme_auto_motors_trucks extends AdvSheme_auto_motors
{
	public $RubricID = 12;
	
	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic', 'rudder',
		'year', 'mileage', 'enginepower', 'fuel', 'drive', 'gearbox', 'status', 'enginecapacity',
		'cabintype', 'capacity');
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Capacity']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['CabinType']			= array( 'type' => 'int' );
		
		parent::__construct($path, $prefix);
		
		$this->Config['bodytype'] =  array (
			11 => 'Автобетононасос',
			12 => 'Автовоз',
			13 => 'Автовышка',
			14 => 'Автокран',
			15 => 'Автопоезд',
			16 => 'Автоцистерна',
			17 => 'Автоцистерна топливозаправочная',
			18 => 'Бензовоз',
			19 => 'Бетоносмеситель',
			20 => 'Бортовой грузовик',
			21 => 'Бортовой грузовик + кран',
			22 => 'Бортовой тентованный',
			23 => 'Вакуумная машина',
			24 => 'Вахтовый автобус',
			25 => 'Грузовик',
			26 => 'Лесовоз',
			27 => 'Манипулятор',
			28 => 'Мусоровоз',
			29 => 'Платформа',
			30 => 'Полуприцеп',
			31 => 'Рефрижератор',
			32 => 'Самосвал',
			33 => 'Седельный тягач',
			34 => 'Сортиментовоз',
			35 => 'Тентованный шторный',
			36 => 'Топливозаправщик',
			37 => 'Фургон',
			38 => 'Фургон изотермический',
			39 => 'Фургон мебельный',
			40 => 'Фургон промтоварный',
			41 => 'Фургон рефрижератор',
			42 => 'Шасси',
			43 => 'Эвакуатор',
		  );
		  
		  
			$this->Config['drive'] =  array (
				3	=> '4х2',
				4 	=> '4х4',
				5 	=> '6х2',
				6 	=> '6х4',
				7 	=> '6х6',
				8 	=> '8х2',
				9 	=> '8х4',
				10	=> '8х6',
				11 	=> '8х8',
				12 	=> '10х6',
				13 	=> '12х8',
			);
			
			$this->Config['gearbox'] =  array (		  
				0 => 'Автоматическая',
				2 => 'Механическая',			
			);
			
			$this->Config['options'] =  array (
				81	=> 'CD-проигрыватель',
				82	=> 'Автономный обогрев кабины',
				83	=> 'Блокировка дифференциала',
				84	=> 'Гидроусилитель руля',
				85	=> 'Горный тормоз',
				86	=> 'Интеркулер',
				87	=> 'Кондиционер',
				88	=> 'Круиз-контроль',
				89	=> 'Люк',
				90	=> 'Стояночный отопитель',
				91	=> 'Электрический прогрев двигателя',
				92	=> 'Электрозеркала',				
			);

	}
}

class AdvIterator_auto_motors_trucks extends AdvIterator_auto_motors
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'BodyType', 'Color', 'Metallic', 'Rudder',
		'Year', 'Mileage', 'EnginePower', 'Fuel', 'Drive', 'Gearbox', 'Status', 'EngineCapacity', 
		'Capacity', 'CabinType','Moderate','Remoderate','IsNew', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_motors_trucks extends Adv_auto_motors
{
}

?>