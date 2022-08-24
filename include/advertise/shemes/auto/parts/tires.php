<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/parts.php';

class AdvSheme_auto_parts_tires extends AdvSheme_auto_parts
{
	public $RubricID = 24;
	
	public $VisibleFields = array( 'status', 'brand', 'model', 'diameter', 'seasonality',
		'width', 'height', 'spikes', 'count' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );
		
		$this->sheme['scalar_fields']['Diameter']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Seasonality']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Width']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Height']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Spikes']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Count']				= array( 'type' => 'int' );
				
		parent::__construct($path, $prefix);
		
		$this->Config['seasonality'] =  array (
			1 => 'всесезонные',
			2 => 'зимние',
			3 => 'летние',
		);
		
		$this->Config['diameter'] =  array (12,13,14,15,16,17,18,19,20,21,22,23);
		
		$this->Config['width'] =  array (135,145,155,165,175,185,195,205,215,225,235,245,255,265,275,285,295,305,315,325,335,345,355,375,385,395,405,455);
		
		$this->Config['height'] =  array (25,30,35,40,45,50,55,60,65,70,75,80,85,90,95);
		
		$this->Config['count'] = array(1,2,3,4,5,6,7,8,9,10);
		
		$this->Config['state'] = array (
			0 => 'отличное',
			1 => 'хорошее',
			2 => 'среднее',
		  );
	}
}

class AdvIterator_auto_parts_tires extends AdvIterator_auto_parts
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM',  'Brand', 'Model', 'Diameter', 'Seasonality',
		'Width', 'Height', 'Spikes','Moderate','Remoderate','IsNew', 'Count', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_auto_parts_tires extends Adv_auto_parts
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
		
		if ( empty($this->data['Diameter']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_DIAMETER);
			$is_valid = false;
		}
		
		if ( empty($this->data['Seasonality']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_SEASONALITY);
			$is_valid = false;
		}
		
		if ( empty($this->data['Width']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_WIDTH);
			$is_valid = false;
		}
		
		if ( empty($this->data['Height']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_HEIGHT);
			$is_valid = false;
		}
		
		if ( !isset($this->data['Spikes']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_SPIKES);
			$is_valid = false;
		}
		
		if ( empty($this->data['Count']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_COUNT);
			$is_valid = false;
		}		
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>
