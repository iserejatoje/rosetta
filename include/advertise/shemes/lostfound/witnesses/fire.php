<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/witnesses.php';

class AdvSheme_lostfound_witnesses_fire extends AdvSheme_lostfound_witnesses
{
	public $RubricID = 41;
}

class AdvIterator_lostfound_witnesses_fire extends AdvIterator_lostfound_witnesses
{
}

class Adv_lostfound_witnesses_fire extends Adv_lostfound_witnesses
{
	public function Store()
	{
		$this->data['opt_Title'] = "Свидетель пожара";
		parent::Store();
	}
}

?>