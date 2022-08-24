<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/parts.php';

class AdvSheme_auto_parts_wheels extends AdvSheme_auto_parts
{
	public $RubricID = 23;
	
	public $VisibleFields = array( 'status', 'diameter', 'color',
		'sortie', 'material', 'type', 'count', 'wheelwidth', 'holediameter', 'holecount' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Diameter']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Count']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Type']					= array( 'type' => 'int' );
		
		$this->sheme['scalar_fields']['Material']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Sortie']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['WheelWidth']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['HoleDiameter']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['HoleCount']			= array( 'type' => 'int' );
				
		parent::__construct($path, $prefix);
		
		$this->Config['type'] =  array (
			1 => 'штампованные',
			2 => 'литые',
			3 => 'кованые',
			4 => 'сборные',
		);
		
		$this->Config['material'] =  array (
			1 => 'алюминиевый сплав',
			2 => 'магниевый сплав',
			3 => 'сталь',
			4 => 'сталь + алюминий',
			5 => 'титановый сплав',			
		);
		
		$this->Config['diameter'] =  array (12,13,14,15,16,17,18,19,20,21,22,23);
		
		$this->Config['wheelwidth'] =  array (4,4.5,5,5.5,6,6.5,7,7.5,8,8.5,9,9.5,10,10.5,11);
		
		$this->Config['holecount'] =  array (3,4,5,6,8,9,10);
		
		$this->Config['holediameter'] =  array (98,100,108,110,112,114,114.3,115,118,120,120.6,120.65,120.7,127,130,135,139,139.7,150,160,165,165.1,170,180,190,205,225,256,275,335);
		
		$this->Config['sortie'] =  array (-63,-50,-49,-46,-44,-40,-38,-30,-28,-25,-24,-24,-20,-19,-18,-15,-14,-13,-12,-11,-10,-6,-5,-3,0,1,2,3,5,6,7,8,99,10,11,12,13,14,15,16,16,17,18,19,20,20.5,20.8,22,23,24,25,26,27,27.5,28,29,30,30.5,31,31.5,32,33,34,35,36,36.5,37,37.5,38,38.8,39,40,40.75,41,41.2,41.3,41.5,42,42.5,43,43.5,43.8,44,44.5,45,45.5,45.7,46,47,47.5,48,49,49.5,50,50.5,50.8,51,52,52.2,52.4,52.5,53,53.3,54,55,56,57,58,59,60,60.1,62,63,63.35,64,65,66,68,70,75,83,89.1,90,102,105,105.5,107,108,110.5,115,120,123,124,132);
		
		$this->Config['count'] = array(1,2,3,4,5,6,7,8,9,10);
		
		$this->Config['colors'] = array(
			11	=> 'белый',
			26	=> 'желтый',
			31	=> 'золотистый',
			35	=> 'коричневый',
			40	=> 'красный',
			61	=> 'оранжевый',
			204	=> 'серебристый',
			204	=> 'серебристый+черный',
			116	=> 'синий',
			114	=> 'хром',
			172	=> 'черный',
		);
		
		$this->Config['state'] = array (
			0 => 'отличное',
			1 => 'хорошее',
			2 => 'среднее',
		  );
	}
}

class AdvIterator_auto_parts_wheels extends AdvIterator_auto_parts
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM', 'Diameter', 'Color',
		'Sortie', 'Material', 'Type','Moderate','Remoderate','IsNew', 'Count', 'WheelWidth', 'HoleDiameter', 'HoleCount', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_parts_wheels extends Adv_auto_parts
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['Color']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_COLOR);
			$is_valid = false;
		}
		
		if ( empty($this->data['Count']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_COUNT);
			$is_valid = false;
		}
		
		if ( empty($this->data['Diameter']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_DIAMETER);
			$is_valid = false;
		}
		
		if ( !isset($this->data['Type']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_TYPE);
			$is_valid = false;
		}
				
		return ( parent::IsValid() && $is_valid );
	}
}

?>
