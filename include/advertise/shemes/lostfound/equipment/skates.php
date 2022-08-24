<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_skates extends AdvSheme_lostfound_equipment
{
	public $RubricID = 29;
}

class AdvIterator_lostfound_equipment_skates extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_skates extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Коньки";
		parent::Store();
	}
}

?>