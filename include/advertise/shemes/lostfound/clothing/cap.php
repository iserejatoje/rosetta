<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_cap extends AdvSheme_lostfound_clothing
{
	public $RubricID = 11;
}

class AdvIterator_lostfound_clothing_cap extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_cap extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Шапка, ".$this->data['Color'];
		parent::Store();
	}
}

?>