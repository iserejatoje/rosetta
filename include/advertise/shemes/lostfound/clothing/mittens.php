<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_mittens extends AdvSheme_lostfound_clothing
{
	public $RubricID = 6;
}

class AdvIterator_lostfound_clothing_mittens extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_mittens extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Варежки, ".$this->data['Color'];
		parent::Store();
	}
}

?>