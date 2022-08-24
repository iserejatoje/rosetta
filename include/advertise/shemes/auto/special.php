<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_special extends AdvSheme_auto
{
	public $RubricID = 15;

	public $VisibleFields = array( 'brand', 'model', 'bodytype', 'color', 'metallic',
		'year', 'mileage', 'enginepower', 'enginecapacity', 'fuel', 'status' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BodyType']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Metallic']				= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Year']					= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Mileage']				= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['EnginePower']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Fuel']					= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );				

		parent::__construct($path, $prefix);
		
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_special'));
		
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_special_options',
				'Photo'  	=> '_special_photo',
				'Favorite'  => '_special_favorites',
			)
		);	
		
		$this->Config['bodytype'] =  array (
			101 => 'Аварийно-ремонтная',
			102 => 'Автобетоносмеситель',
			103 => 'Автовышка',
			104 => 'Автодом',
			105 => 'Автокран',
			106 => 'Автопогрузчик',
			107 => 'Ассенизатор',
			108 => 'Башенный кран',
			109 => 'Бетономешалка',
			110 => 'Бетононасос',
			111 => 'Бетоносмеситель',
			112 => 'Бульдозер',
			113 => 'Бурильно-сваебойная машина',
			114 => 'Буровая установка',
			115 => 'Вакуумная машина',
			116 => 'Грейдер',
			117 => 'Дробильно-сортировочная установка',
			118 => 'Каналоочистительная машина',
			119 => 'Каток',
			120 => 'Комбайн',
			121 => 'Комбинированная',
			122 => 'Мусоровоз',
			123 => 'Пескоразбрасывающая',
			124 => 'Погрузчик',
			125 => 'Поливомоечная',
			126 => 'Подметально-уборочная',			
			127 => 'Самопогрузчик',			
			128 => 'Самосвал',			
			129 => 'Свеклоуборочный комбайн',			
			130 => 'Снегоочиститель',			
			131 => 'Трактор гусеничный',			
			132 => 'Трактор колесный',			
			133 => 'Трактор малогабаритный',			
			134 => 'Трубоукладчик',
			135 => 'Цементировочный агрегат',			
			136 => 'Экскаватор',
			137 => 'Тягач',
			138 => 'Автозаправщик',
			139 => 'Бензовоз',
		  );
	}	
}


class AdvIterator_auto_special extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM','Moderate','Remoderate','IsNew',  'Brand', 'Model', 'BodyType', 'Color', 'Metallic',
		'Year', 'Mileage', 'EnginePower', 'EngineCapacity', 'Fuel', 'Status', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_special extends Adv_auto
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
		
		if ( empty($this->data['BodyType']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BODYTYPE);
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
		
		if ( empty($this->data['Mileage']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_MILEAGE);
			$is_valid = false;
		}
				
		if ( empty($this->data['Fuel']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_FUEL);
			$is_valid = false;
		}
				
		if ( !isset($this->data['Status']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_STATUS);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>