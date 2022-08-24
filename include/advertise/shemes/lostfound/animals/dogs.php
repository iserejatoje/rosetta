<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/animals.php';

class AdvSheme_lostfound_animals_dogs extends AdvSheme_lostfound_animals
{
	public $RubricID = 3;
}

class AdvIterator_lostfound_animals_dogs extends AdvIterator_lostfound_animals
{
}

class Adv_lostfound_animals_dogs extends Adv_lostfound_animals
{
	public function Store()
	{
		$this->data['opt_Title'] = "Собака";
		parent::Store();
	}
}

?>