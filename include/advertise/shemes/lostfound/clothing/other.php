<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_other extends AdvSheme_lostfound_clothing
{
	public $RubricID = 12;
}

class AdvIterator_lostfound_clothing_other extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_other extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = $this->data['Item'].", ".$this->data['Color'];
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