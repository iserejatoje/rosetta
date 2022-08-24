<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_student extends AdvSheme_lostfound_documents
{
	public $RubricID = 19;
}

class AdvIterator_lostfound_documents_student extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_student extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Студенческий билет на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>