<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_camcorder extends AdvSheme_lostfound_electronics
{
	public $RubricID = 27;
}

class AdvIterator_lostfound_electronics_camcorder extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_camcorder extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "Видеокамера ".$this->data['Brand'];
		parent::Store();
	}
}

?>