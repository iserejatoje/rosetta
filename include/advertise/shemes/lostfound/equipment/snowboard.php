<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/equipment.php';

class AdvSheme_lostfound_equipment_snowboard extends AdvSheme_lostfound_equipment
{
	public $RubricID = 34;
}

class AdvIterator_lostfound_equipment_snowboard extends AdvIterator_lostfound_equipment
{
}

class Adv_lostfound_equipment_snowboard extends Adv_lostfound_equipment
{
	public function Store()
	{
		$this->data['opt_Title'] = "Сноуборд";
		parent::Store();
	}
}

?>