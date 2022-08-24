<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_standart_checkbox extends Control_TemplateVirtualControl
{

	private $checked			= false;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_checkbox');
		$this->SetTemplate('controls/standart/checkbox/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()
	{

	}
	
	public function GetChecked()
	{
		if(isset(App::$Request->Request[$this->GetID().'_checkbox']))
			return App::$Request->Request[$this->GetID().'_value']->Value() == 'checked';
		return $this->checked;
	}
	
	public function SetChecked($checked = true)
	{
		if(is_bool($checked))
			$this->checked = $checked;
	}
}
?>