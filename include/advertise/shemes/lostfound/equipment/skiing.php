<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_skiing extends AdvSheme_lostfound_equipment
{
	public $RubricID = 30;
}

class AdvIterator_lostfound_equipment_skiing extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_skiing extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Лыжи";
		parent::Store();
	}
}

?>