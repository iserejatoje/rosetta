<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_employment extends AdvSheme_lostfound_documents
{
	public $RubricID = 17;
}

class AdvIterator_lostfound_documents_employment extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_employment extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Трудовая книжка на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>