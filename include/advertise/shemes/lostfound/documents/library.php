<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_library extends AdvSheme_lostfound_documents
{
	public $RubricID = 20;
}

class AdvIterator_lostfound_documents_library extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_library extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Читательский билет на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>