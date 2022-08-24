<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/transport.php';

class AdvSheme_lostfound_transport_moped extends AdvSheme_lostfound_transport
{
	public $RubricID = 38;
}

class AdvIterator_lostfound_transport_moped extends AdvIterator_lostfound_transport
{
}

class Adv_lostfound_transport_moped extends Adv_lostfound_transport
{
	public function Store()
	{
		$this->data['opt_Title'] = "Мопед ".$this->data['Brand']." ".$this->data['Model'];
		parent::Store();
	}
}

?>