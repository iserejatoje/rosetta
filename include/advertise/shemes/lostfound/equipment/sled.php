<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_sled extends AdvSheme_lostfound_equipment
{
	public $RubricID = 33;
}

class AdvIterator_lostfound_equipment_sled extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_sled extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Санки";
		parent::Store();
	}
}

?>