<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_gloves extends AdvSheme_lostfound_clothing
{
	public $RubricID = 9;
}

class AdvIterator_lostfound_clothing_gloves extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_gloves extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Перчатки, ".$this->data['Color'];
		parent::Store();
	}
}

?>