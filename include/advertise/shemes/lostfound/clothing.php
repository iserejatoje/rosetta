<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_clothing extends AdvSheme_lostfound
{
  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_clothing',
		'slaves' => array(
		    'Photo' 	=> '_clothing_photo'
		)
	);
    // скалярные поля
    $this->sheme['scalar_fields']['Size']		= array( 'type' => 'char' );
    $this->sheme['scalar_fields']['Color']		= array( 'type' => 'char' );

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_clothing extends AdvIterator_lostfound
{
}

class Adv_lostfound_clothing extends Adv_lostfound
{
  const OT_OBJECT_LOST	= 0;
  const OT_OBJECT_FOUND	= 1;

  public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;
		if (!isset($this->data['Color']) || empty($this->data['Color']) || strlen($this->data['Color']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_COLOR);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}
?>