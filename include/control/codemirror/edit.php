<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
// можно добавить маски ввода
class Control_codemirror_edit extends Control_TemplateControl
{
	private $multiline			= false;
	private $limit				= 0;			// без лимита
	private $readonly			= false;

	function __construct($parent = null)
	{
		global $OBJECTS;
		parent::__construct($parent, 'codemirror_edit');
		$this->SetTemplate('controls/codemirror/edit/default');
		$this->SetDrawContainer(false);
		
		$OBJECTS['title']->AddStyle('/resources/styles/themes/editors/codemirror/codemirror.css');
		$OBJECTS['title']->AddScript('/resources/scripts/themes/editors/codemirror/codemirror.js');
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
	
	public function SetMultiline($multiline)
	{
		if(is_bool($multiline))
			$this->multiline = $multiline;
	}
	
	public function SetReadOnly($readonly)
	{
		if(is_bool($readonly))
			$this->readonly = $readonly;
	}
	
	public function GetReadOnly()
	{
		return $this->readonly;
	}
}
?>