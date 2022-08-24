<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/transport.php';

class AdvSheme_lostfound_transport_bike extends AdvSheme_lostfound_transport
{
	public $RubricID = 37;
}

class AdvIterator_lostfound_transport_bike extends AdvIterator_lostfound_transport
{
}

class Adv_lostfound_transport_bike extends Adv_lostfound_transport
{
	public function Store()
	{
		$this->data['opt_Title'] = "Велосипед ".$this->data['Brand']." ".$this->data['Model'];
		parent::Store();
	}
}

?>