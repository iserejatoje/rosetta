<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_credential extends AdvSheme_lostfound_documents
{
	public $RubricID = 18;
}

class AdvIterator_lostfound_documents_credential extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_credential extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Удостоверение личности на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>