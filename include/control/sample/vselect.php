<?
class Control_sample_vselect extends Control_TemplateVirtualControl
{
	private $field;
	function __construct($parent = null)
	{
		parent::__construct($parent, 'sample_vselect');
		$this->SetTemplate('controls/standart/select/dropdown');
		$this->SetVirtualMode(true); // виртуальный режим
	}
	
	public function Draw()
	{
		$items = $this->GetSource();
		
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'items' => $items,
				'field' => $this->field,
			)));
	}
	
	public function SetField($name)
	{
		$this->field = $name;
	}
}
?>