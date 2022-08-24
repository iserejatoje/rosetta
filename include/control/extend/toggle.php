<?php

/**
 * @author husainov
 * @version 1.0
 * @created 11:26 13.11.2009
 */
class Control_extend_toggle extends Control_TemplateVirtualControl
{
	private $actions = array(
		true => array(),
		false => array()
	);
	private $state = false;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_toggle');
		$this->SetTemplate('controls/extend/toggle/default');
		$this->SetDrawContainer(false);
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this,
			));
	}
	
	public function PreRender()
	{
	}
	
	public function SetAction($state, $title, $url)
	{
		if ( !is_bool($state) )
			return false;
		
		$this->actions[$state]['title'] = $title;
		$this->actions[$state]['url'] = $url;
		
		return true;
	}
	
	public function GetAction($state = null)
	{
		if ( !is_bool($state) )
			return $this->actions[$this->state]['url'];
		else
			return $this->actions[$state]['url'];
	}
	
	public function GetTitle($state = null)
	{
		if ( !is_bool($state) )
			return $this->actions[$this->state]['title'];
		else
			return $this->actions[$state]['title'];
	}
	
	public function SetState($state = true)
	{
		$this->state = $state ? true : false;
	}
	
	public function GetState()
	{
		return $this->state;
	}
}
?>