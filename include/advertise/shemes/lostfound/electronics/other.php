<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_other extends AdvSheme_lostfound_electronics
{
	public $RubricID = 28;
}

class AdvIterator_lostfound_electronics_other extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_other extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = $this->data['Item']." ".$this->data['Brand'];
		parent::Store();
	}
	public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;

		if (!isset($this->data['Item']) || empty($this->data['Item']) || strlen($this->data['Item']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_ITEM);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}

?>