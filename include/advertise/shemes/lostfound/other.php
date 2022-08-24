<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_other extends AdvSheme_lostfound
{
	public $RubricID = 1;

  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_other',
		'slaves' => array(
		    'Photo' 	=> '_other_photo'
		)
	);
    // скалярные поля
    $this->sheme['scalar_fields']['Color']		= array( 'type' => 'char' );

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_other extends AdvIterator_lostfound
{
}

class Adv_lostfound_other extends Adv_lostfound
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
		if (!isset($this->data['Item']) || empty($this->data['Item']) || strlen($this->data['Item']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_ITEM);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}
?>