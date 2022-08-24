<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_military extends AdvSheme_lostfound_documents
{
	public $RubricID = 15;
}

class AdvIterator_lostfound_documents_military extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_military extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = "Военный билет на имя ".$this->data['OnName'];
		parent::Store();
	}
}

?>