<?php
/**
 * @author husainov
 * @version 1.0
 * @created 14:16 12.11.2009
 */

class Control_standart_hidden extends Control_TemplateControl
{
	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_hidden');
		$this->SetTemplate('controls/standart/hidden/default');
		$this->SetDrawContainer(false);
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()	{}
	
	public function GetTitle()
	{
		if( isset(App::$Request->Request[$this->GetId().'_hidden']) )
			return App::$Request->Request[$this->GetId().'_hidden']->Value();
		else
			return parent::GetTitle();
	}
}
?>