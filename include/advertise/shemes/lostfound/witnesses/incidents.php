<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/witnesses.php';

class AdvSheme_lostfound_witnesses_incidents extends AdvSheme_lostfound_witnesses
{
	public $RubricID = 43;
}

class AdvIterator_lostfound_witnesses_incidents extends AdvIterator_lostfound_witnesses
{
}

class Adv_lostfound_witnesses_incidents extends Adv_lostfound_witnesses
{
	public function Store()
	{
		$this->data['opt_Title'] = "Свидетель происшествия";
		parent::Store();
	}
}

?>