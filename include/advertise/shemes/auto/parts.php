<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto.php';

class AdvSheme_auto_parts extends AdvSheme_auto
{
	public $VisibleFields = array( 'status' );
	
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['Status']				= array( 'type' => 'int' );		
		
		parent::__construct($path, $prefix);
		
		$this->sheme['tables'] = array_merge( $this->sheme['tables'], array(	'master' => '_parts'));		
		$this->sheme['tables']['slaves'] = array_merge( 
			$this->sheme['tables']['slaves'], 
			array(	
				'Options' 	=> '_parts_options',
				'Photo'  	=> '_parts_photo',
				'Favorite'  => '_parts_favorites',
			)
		);	
	}	
}


class AdvIterator_auto_parts extends AdvIterator_auto
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo', 'CityCode','Moderate','Remoderate','IsNew', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM', 'Status','Important', 'ImportID'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto_parts extends Adv_auto
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
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