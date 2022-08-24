<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_racket extends AdvSheme_lostfound_equipment
{
	public $RubricID = 31;
}

class AdvIterator_lostfound_equipment_racket extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_racket extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Ракетка";
		parent::Store();
	}
}

?>