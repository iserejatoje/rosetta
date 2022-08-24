<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_player extends AdvSheme_lostfound_electronics
{
	public $RubricID = 24;
}

class AdvIterator_lostfound_electronics_player extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_player extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "Аудиоплеер ".$this->data['Brand'];
		parent::Store();
	}
}

?>