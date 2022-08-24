<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/water.php';

class AdvSheme_auto_water_yachts extends AdvSheme_auto_water
{
	public $RubricID = 21;
	
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic', 'year', 'seats', 'enginepower', 'displacement', 'status' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля		
		$this->sheme['scalar_fields']['EnginePower']		= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Seats']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Displacement']	= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );			

		parent::__construct($path, $prefix);
				
		$this->Config['options'] =  array (
			250	=> 'Аудиосистема',
			251	=> 'Спидометр',
			252	=> 'Душ',
			253	=> 'Навигационные огни',
			254	=> 'Очиститель лобового стекла',
			255	=> 'Плита газовая',
			256	=> 'Прожектор',
			257	=> 'Телевизор',
			258	=> 'Холодильник',
			259	=> 'Эхолот',
			260	=> 'Якорь',
			261	=> 'Душ',
		);
		
		$this->Config['state'] = array (
			0 => 'отличное',
			1 => 'хорошее',
			2 => 'среднее',
		  );
	}
}


class AdvIterator_auto_water_yachts extends AdvIterator_auto_water
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'Color', 'Metallic',
		'Year',  'EnginePower', 'Seats','Moderate','Remoderate','IsNew', 'Displacement', 'Favorite', 'Status','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_water_yachts extends Adv_auto_water
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
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