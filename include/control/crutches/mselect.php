<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_crutches_mselect extends Control_TemplateControl
{

	private $action			= '';
	private $url_ajax		= '';
	private $items			= array();

	function __construct($parent = null)
	{
		parent::__construct($parent, 'crutches_mselect');
		$this->SetTemplate('controls/crutches/mselect/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()
	{

	}
	
	public function GetUrl()
	{
		return $this->url;
	}
	
	public function SetUrl($url)
	{
		if(is_string($url))
			$this->url = $url;
	}
	
	public function GetAction()
	{
		return $this->action;
	}
	
	public function SetAction($action)
	{
		if(is_string($action))
			$this->action = $action;
	}
	
	public function GetItems()
	{
		return $this->action;
	}
	
	public function SetItems($items)
	{
		if(is_array($items))
			$this->items = $items;
	}
	
	public function GetSelected()
	{
		return App::$Request->Request[$this->GetID().'_id']->Int(0);
	}
}
?>