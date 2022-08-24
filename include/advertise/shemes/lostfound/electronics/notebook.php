<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_notebook extends AdvSheme_lostfound_electronics
{
	public $RubricID = 22;
}

class AdvIterator_lostfound_electronics_notebook extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_notebook extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "Ноутбук ".$this->data['Brand'];
		parent::Store();
	}
}

?>