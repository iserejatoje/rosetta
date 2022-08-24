<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/electronics.php';

class AdvSheme_lostfound_electronics_pda extends AdvSheme_lostfound_electronics
{
	public $RubricID = 26;
}

class AdvIterator_lostfound_electronics_pda extends AdvIterator_lostfound_electronics
{
}

class Adv_lostfound_electronics_pda extends Adv_lostfound_electronics
{
	public function Store()
	{
		$this->data['opt_Title'] = "КПК ".$this->data['Brand'];
		parent::Store();
	}
}

?>