<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_licence extends AdvSheme_lostfound_documents
{
	public $RubricID = 14;
}

class AdvIterator_lostfound_documents_licence extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_licence extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Водительское удостоверение на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>