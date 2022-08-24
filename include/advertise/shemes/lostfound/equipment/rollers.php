<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_rollers extends AdvSheme_lostfound_equipment
{
	public $RubricID = 32;
}

class AdvIterator_lostfound_equipment_rollers extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_rollers extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Ролики";
		parent::Store();
	}
}

?>