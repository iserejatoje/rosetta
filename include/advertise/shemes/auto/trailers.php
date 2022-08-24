<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_trailers extends AdvSheme_auto
{
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic',
		'year', 'status', 'capacity' );

	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Brand']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Model']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Color']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Metallic']				= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['Year']					= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );				
		$this->sheme['scalar_fields']['Capacity']			= array( 'type' => 'int' );

		parent::__construct($path, $prefix);
		
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_trailers'));		
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_trailers_options',
				'Photo'  	=> '_trailers_photo',
				'Favorite'  => '_trailers_favorites',
			)
		);	
	}	
}


class AdvIterator_auto_trailers extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM','Moderate','Remoderate','IsNew',  'Brand', 'Model', 'Color', 'Metallic',
		'Year', 'Status', 'Capacity', 'Favorite','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_trailers extends Adv_auto
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
				
		if ( !is_numeric($this->data['Status']) )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_STATUS);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
}

?>