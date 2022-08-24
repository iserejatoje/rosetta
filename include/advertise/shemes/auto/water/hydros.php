<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/water.php';

class AdvSheme_auto_water_hydros extends AdvSheme_auto_water
{
	public $RubricID = 20;
	
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic', 'year', 'enginecapacity', 'enginepower', 'motohours', 'type', 'status' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['EngineCapacity']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['EnginePower']		= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['MotoHours']		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Type']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );			

		parent::__construct($path, $prefix);
		
		$this->Config['type'] = array(
			1	=> 'Cпортивно-туристический',
			2	=> 'Спортивный',
			3	=> 'Спортивный стоячий',
			4	=> 'Туристический',
		);
		
		$this->Config['options'] =  array (
			250	=> 'Противоугонная система',
			251	=> 'Спидометр',
			252	=> 'Реверс',
			253	=> 'Умный руль',
		);
		
		$this->Config['state'] = array (
			0 => 'отличное',
			1 => 'хорошее',
			2 => 'среднее',
		  );
	}
}


class AdvIterator_auto_water_hydros extends AdvIterator_auto_water
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details','Type',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'Color', 'Metallic',
		'Year', 'EngineCapacity','Moderate','Remoderate','IsNew', 'EnginePower', 'MotoHours', 'Favorite', 'Status','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_water_hydros extends Adv_auto_water
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
			
		if ( empty($this->data['EngineCapacity']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_M_AUTO_ENGINECAPACITY);
			$is_valid = false;
		}
		
		if ( empty($this->data['Type']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_M_AUTO_TYPE);
			$is_valid = false;
		}
		
		if ( !isset($this->data['Status']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_M_AUTO_STATUS);
				error_log("ERR_M_AUTO_STATUS");
			}
			$is_valid = false;
		}
						
		return ( parent::IsValid() && $is_valid );
	}
}

?>