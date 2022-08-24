<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/lostfound/documents.php';

class AdvSheme_lostfound_documents_other extends AdvSheme_lostfound_documents
{
	public $RubricID = 21;
}

class AdvIterator_lostfound_documents_other extends AdvIterator_lostfound_documents
{
}

class Adv_lostfound_documents_other extends Adv_lostfound_documents
{
	public function Store()
	{
		$this->data['opt_Title'] = $this->data['Item']." на имя ".$this->data['OnName'];
		parent::Store();
	}
	public function IsValid()
  {
    global $OBJECTS;

    $is_valid = true;

		if (!isset($this->data['Item']) || empty($this->data['Item']) || strlen($this->data['Item']) < 4){
      $OBJECTS['uerror']->AddError(ERR_L_LOSTFOUND_ITEM);
			$is_valid = false;
		}
    return ( parent::IsValid() && $is_valid );
  }
}

?>