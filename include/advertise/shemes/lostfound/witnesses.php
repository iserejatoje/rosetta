<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_witnesses extends AdvSheme_lostfound
{
  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_witnesses',
		'slaves' => array(
		    'Photo' 	=> '_witnesses_photo'
		)
	);

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_witnesses extends AdvIterator_lostfound
{
}

class Adv_lostfound_witnesses extends Adv_lostfound
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