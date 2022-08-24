<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/animals.php';

class AdvSheme_lostfound_animals_cats extends AdvSheme_lostfound_animals
{
	public $RubricID = 2;
}

class AdvIterator_lostfound_animals_cats extends AdvIterator_lostfound_animals
{
}

class Adv_lostfound_animals_cats extends Adv_lostfound_animals
{
	public function Store()
	{
		$this->data['opt_Title'] = "Кошка";
		parent::Store();
	}
}

?>