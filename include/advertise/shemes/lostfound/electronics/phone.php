<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_phone extends AdvSheme_lostfound_electronics
{
	public $RubricID = 23;
}

class AdvIterator_lostfound_electronics_phone extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_phone extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "Телефон ".$this->data['Brand'];
		parent::Store();
	}
}

?>