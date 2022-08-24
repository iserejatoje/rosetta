<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/trailers.php';

class AdvSheme_auto_trailers_cargo extends AdvSheme_auto_trailers
{
	
	public $RubricID = 14;
	
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic',
		'year', 'status', 'capacity', 'bodytype', 'axiscount' );

	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['BodyType']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['AxisCount']			= array( 'type' => 'int' );
		
		parent::__construct($path, $prefix);
		
		$this->Config['options'] =  array (
				130	=> 'Антиблокировочная система(ABS)',
				131	=> 'Пневмо подвеска',
				132	=> 'Дисковые тормоза',				
			);
			
		$this->Config['bodytype'] =  array (
			71 => 'Автовоз',
			72 => 'Автоцистерна',
			73 => 'Контейнеровоз',
			74 => 'Полуприцеп',
			75 => 'Полуприцеп бортовой',
			76 => 'Полуприцеп низкорамный трал',
			77 => 'Полуприцеп рефрижератор',
			78 => 'Полуприцеп самосвальный',
			79 => 'Полуприцеп тентованный',
			80 => 'Полуприцеп тяжеловоз',
			81 => 'Полуприцеп электростанция',
			82 => 'Прицеп',
			83 => 'Прицеп бортовой',
			84 => 'Прицеп самосвальный',
			85 => 'Прицеп тентованный',
			86 => 'Прицеп тяжеловоз',
			87 => 'Прицеп фургон',
			88 => 'Прицеп шасси',
			89 => 'Рефрижератор',
			90 => 'Сортиментовоз',
			91 => 'Фургон',
			92 => 'Фургон изотермический',
			93 => 'Фургон мебельный',
			94 => 'Фургон промтоварный',
			95 => 'Фургон рефрижератор',
			96 => 'Цементовоз',			
		  );
	}
}

class AdvIterator_auto_trailers_cargo extends AdvIterator_auto_trailers
{	
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'Color', 'Metallic',
		'Year', 'Status', 'Capacity','Moderate','Remoderate','IsNew', 'BodyType', 'AxisCount', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_trailers_cargo extends Adv_auto_trailers
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
	
		if ( empty($this->data['BodyType']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BODYTYPE);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>