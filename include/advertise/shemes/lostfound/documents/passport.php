<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_passport extends AdvSheme_lostfound_documents
{
	public $RubricID = 13;
}

class AdvIterator_lostfound_documents_passport extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_passport extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Паспорт на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>