<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_shoes extends AdvSheme_lostfound_clothing
{
	public $RubricID = 10;
}

class AdvIterator_lostfound_clothing_shoes extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_shoes extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Туфли, ".$this->data['Color'];
		parent::Store();
	}
}

?>