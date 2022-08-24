<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_scarf extends AdvSheme_lostfound_clothing
{
	public $RubricID = 45;
}

class AdvIterator_lostfound_clothing_scarf extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_scarf extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Шарф, ".$this->data['Color'];
		parent::Store();
	}
}

?>