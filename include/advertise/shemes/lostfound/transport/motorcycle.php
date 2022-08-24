<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/transport.php';

class AdvSheme_lostfound_transport_motorcycle extends AdvSheme_lostfound_transport
{
	public $RubricID = 39;
}

class AdvIterator_lostfound_transport_motorcycle extends AdvIterator_lostfound_transport
{
}

class Adv_lostfound_transport_motorcycle extends Adv_lostfound_transport
{
	public function Store()
	{
		$this->data['opt_Title'] = "Мотоцикл ".$this->data['Brand']." ".$this->data['Model'];
		parent::Store();
	}
}

?>