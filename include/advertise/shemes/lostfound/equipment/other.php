<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_other extends AdvSheme_lostfound_equipment
{
	public $RubricID = 35;
}

class AdvIterator_lostfound_equipment_other extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_other extends Adv_lostfound_equipment
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