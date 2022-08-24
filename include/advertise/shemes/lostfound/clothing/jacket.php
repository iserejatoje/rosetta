<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_jacket extends AdvSheme_lostfound_clothing
{
	public $RubricID = 8;
}

class AdvIterator_lostfound_clothing_jacket extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_jacket extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Куртка, ".$this->data['Color'];
		parent::Store();
	}
}

?>