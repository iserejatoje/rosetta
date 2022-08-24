<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_moto extends AdvSheme_auto
{
	public $VisibleFields = array('brand', 'model', 'bodytype', 'color', 'metallic',
		'year', 'mileage', 'enginepower', 'enginecapacity', 'fuel', 'status', 'modification');

	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['BodyType']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Metallic']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Year']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Mileage']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['EnginePower']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['EngineCapacity']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Fuel']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Modification']		= array( 'type' => 'char' );

		parent::__construct($path, $prefix);
		
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_moto'));	
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_moto_options',
				'Photo'  	=> '_moto_photo',
				'Favorite'  => '_moto_favorites',
			)
		);	

		$this->Config['bodytype'] = array(
			150	=> 'Allround',
			151	=> 'Naked bike',
			152	=> 'Speedway',
			153	=> 'Super motard',
			154	=> 'Внедорожный Эндуро',
			155	=> 'Детский',
			156	=> 'Дорожный',
			157	=> 'Кастом',
			158	=> 'Классик',
			159	=> 'Кросс',
			160	=> 'Круизер',
			161	=> 'Минибайк',
			162	=> 'Прототип',
			163	=> 'Спорт-байк',
			164	=> 'Спорт-туризм',
			165	=> 'Супер-спорт',
			166	=> 'Трайки',
			167	=> 'Туризм',
			168	=> 'Туристический Эндуро',
			169	=> 'Чоппер',
		);
		
		$this->Config['options'] =  array (
			200	=> 'ABS (антиблокировочная система)',
			201	=> 'Электростартер',
		);
	}
}


class AdvIterator_auto_moto extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model','Moderate','Remoderate','IsNew', 'BodyType', 'Color', 'Metallic',
		'Year', 'Mileage', 'EnginePower', 'EngineCapacity', 'Fuel', 'Status', 'Modification', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_moto extends Adv_auto
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( !isset($this->data['Brand']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BRAND);
			$is_valid = false;
		}
		
		if ( !isset($this->data['Model']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_MODEL);
			$is_valid = false;
		}
		
		if ( !isset($this->data['BodyType']) )
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