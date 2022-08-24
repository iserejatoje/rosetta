<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/clothing.php';

class AdvSheme_lostfound_clothing_sneakers extends AdvSheme_lostfound_clothing
{
	public $RubricID = 7;
}

class AdvIterator_lostfound_clothing_sneakers extends AdvIterator_lostfound_clothing
{
}

class Adv_lostfound_clothing_sneakers extends Adv_lostfound_clothing
{
	public function Store()
	{
		$this->data['opt_Title'] = "Кроссовки, ".$this->data['Color'];
		parent::Store();
	}
}

?>