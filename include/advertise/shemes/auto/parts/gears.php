<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/parts.php';

class AdvSheme_auto_parts_gears extends AdvSheme_auto_parts
{
	public $VisibleFields = array( 'status', 'brand', 'models', 'rubric', 'name' );

	public $RubricID = 6;
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );				
		$this->sheme['scalar_fields']['Rubric']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Name']				= array( 'type' => 'char' );		

		// векторные поля		
		$this->sheme['vector_fields']['Model']			= array( 'type' => 'int', 'fields' => array('Model'));
				
		parent::__construct($path, $prefix);
		
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Model' 	=> '_parts_model',				
			)
		);
		
		$this->Config['state'] =  array (
			10 => 'Б/у',
			11 => 'Новое',
		);
	}
}

class AdvIterator_auto_parts_gears extends AdvIterator_auto_parts
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model','Moderate','Remoderate','IsNew', 'Rubric', 'Name', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_parts_gears extends Adv_auto_parts
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		/*if ( empty($this->data['Brand']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_BRAND);
			$is_valid = false;
		}
			*/			
		if ( empty($this->data['Rubric']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_RUBRIC);
			$is_valid = false;
		}
		
		if ( empty($this->data['Name']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_NAME);
			$is_valid = false;
		}				
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>