<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/witnesses.php';

class AdvSheme_lostfound_witnesses_accident extends AdvSheme_lostfound_witnesses
{
	public $RubricID = 42;
}

class AdvIterator_lostfound_witnesses_accident extends AdvIterator_lostfound_witnesses
{
}

class Adv_lostfound_witnesses_accident extends Adv_lostfound_witnesses
{
	public function Store()
	{
		$this->data['opt_Title'] = "Свидетель ДТП";
		parent::Store();
	}
}

?>