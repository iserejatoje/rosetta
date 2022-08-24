<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_electronics extends AdvSheme_lostfound
{
  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_technics',
		'slaves' => array(
		    'Photo' 	=> '_technics_photo'
		)
	);
    // скалярные поля
    $this->sheme['scalar_fields']['Brand']		= array( 'type' => 'char' );
    $this->sheme['scalar_fields']['Model']		= array( 'type' => 'char' );

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_electronics extends AdvIterator_lostfound
{
}

class Adv_lostfound_electronics extends Adv_lostfound
{
  const OT_OBJECT_LOST	= 0;
  const OT_OBJECT_FOUND	= 1;

  public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;
		if (!isset($this->data['Brand']) || empty($this->data['Brand']) || strlen($this->data['Brand']) < 2){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_BRAND);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}
?>