<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/animals.php';

class AdvSheme_lostfound_animals_birds extends AdvSheme_lostfound_animals
{
	public $RubricID = 4;
}

class AdvIterator_lostfound_animals_birds extends AdvIterator_lostfound_animals
{
}

class Adv_lostfound_animals_birds extends Adv_lostfound_animals
{
	public function Store()
	{
		$this->data['opt_Title'] = "Птица";
		parent::Store();
	}
}

?>