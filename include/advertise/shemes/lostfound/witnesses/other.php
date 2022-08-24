<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/witnesses.php';

class AdvSheme_lostfound_witnesses_other extends AdvSheme_lostfound_witnesses
{
	public $RubricID = 44;
}

class AdvIterator_lostfound_witnesses_other extends AdvIterator_lostfound_witnesses
{
}

class Adv_lostfound_witnesses_other extends Adv_lostfound_witnesses
{
	public function Store()
	{
		$this->data['opt_Title'] = $this->data['Item'];
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