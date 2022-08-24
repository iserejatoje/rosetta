<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_camera extends AdvSheme_lostfound_electronics
{
	public $RubricID = 25;
}

class AdvIterator_lostfound_electronics_camera extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_camera extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "Фотоаппарат ".$this->data['Brand'];
		parent::Store();
	}
}

?>