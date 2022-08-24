<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_standart_button extends Control_TemplateControl
{

	private $type			= 'button';
	private $js				= '';

	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_button');
		$this->SetTemplate('controls/standart/button/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()
	{

	}
	
	public function GetJS()
	{
		return $this->js;
	}
	
	public function GetType()
	{
		return $this->type;
	}
	
	public function SetJS($js)
	{
		if(is_string($js))
			$this->js = $js;
	}
	
	// на button цепляется js обработчик
	public function SetType($type = 'button')
	{
		if($type == 'button' || $type == 'submit' || $type == 'reset')
			$this->type = $type;
	}
}
?>