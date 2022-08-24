<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_technical extends AdvSheme_lostfound_documents
{
	public $RubricID = 16;
}

class AdvIterator_lostfound_documents_technical extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_technical extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Технический паспорт на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>