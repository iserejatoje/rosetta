<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
// можно добавить маски ввода
class Control_standart_edit extends Control_TemplateControl
{
	private $multiline			= false;
	private $limit				= 0;			// без лимита

	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_edit');
		$this->SetTemplate('controls/standart/edit/default');
		$this->SetDrawContainer(false);
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()
	{

	}
	
	public function GetLimit()
	{
		return $this->limit;
	}
	
	public function GetMultiline()
	{
		return $this->multiline;
	}
	
	public function GetTitle()
	{
		if( isset(App::$Request->Request[$this->GetId().'_text']) )
			return App::$Request->Request[$this->GetId().'_text']->Value();
		else
			return parent::GetTitle();
	}
	
	public function SetLimit($limit)
	{
		if(is_numeric($limit))
			$this->limit = $limit;
	}
	
	public function SetMultiline($multiline = true)
	{
		if(is_bool($multiline))
			$this->multiline = $multiline;
	}
}
?>