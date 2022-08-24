<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_equipment extends AdvSheme_lostfound
{
  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_equipment',
		'slaves' => array(
		    'Photo' 	=> '_equipment_photo'
		)
	);
    // скалярные поля
    $this->sheme['scalar_fields']['Brand']		= array( 'type' => 'char' );
    $this->sheme['scalar_fields']['Size']		= array( 'type' => 'char' );

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_equipment extends AdvIterator_lostfound
{
}

class Adv_lostfound_equipment extends Adv_lostfound
{
  const OT_OBJECT_LOST	= 0;
  const OT_OBJECT_FOUND	= 1;

  public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;
    return ( parent::IsValid() && $is_valid );
  }
}
?>