<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound.php';

class AdvSheme_lostfound_documents extends AdvSheme_lostfound
{
  public function __construct($path, $prefix = '')
  {
    $this->sheme['tables'] = array(
	    'master' => '_documents',
		'slaves' => array(
		    'Photo' 	=> '_documents_photo'
		)
	);
    // скалярные поля
    $this->sheme['scalar_fields']['Number']		= array( 'type' => 'char' );
    $this->sheme['scalar_fields']['OnName']		= array( 'type' => 'char' );

    // векторные поля
	$this->sheme['vector_fields']['Photo']			= array( 'type' => 'array', 'fields' => array('PhotoLarge', 'PhotoSmall'), 'order' => 'PhotoID' );

	parent::__construct($path, $prefix);
  }
}

class AdvIterator_lostfound_documents extends AdvIterator_lostfound
{
}

class Adv_lostfound_documents extends Adv_lostfound
{
  const OT_OBJECT_LOST	= 0;
  const OT_OBJECT_FOUND	= 1;

  public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;
		if (!isset($this->data['OnName']) || empty($this->data['OnName']) || strlen($this->data['OnName']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_ONNAME);
			$is_valid = false;
		}
		if (!isset($this->data['Number']) || empty($this->data['Number']) || strlen($this->data['Number']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_NUMBER);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}
?>