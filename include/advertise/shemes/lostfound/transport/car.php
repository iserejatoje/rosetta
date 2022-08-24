<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/transport.php';

class AdvSheme_lostfound_transport_car extends AdvSheme_lostfound_transport
{
	public $RubricID = 36;
}

class AdvIterator_lostfound_transport_car extends AdvIterator_lostfound_transport
{
}

class Adv_lostfound_transport_car extends Adv_lostfound_transport
{
	public function Store()
	{
		$this->data['opt_Title'] = "Автомобиль ".$this->data['Brand']." ".$this->data['Model'];
		parent::Store();
	}
}

?>