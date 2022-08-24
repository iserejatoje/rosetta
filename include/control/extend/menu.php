<?php

/**
 * @author danilin, husainov
 * @version 2.0
 * @created 14:27 12.11.2009
 */
class Control_extend_menu extends Control_TemplateVirtualControl
{

	private $items			= array();

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_menu');
		$this->SetTemplate('controls/extend/menu/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'items' => $this->items
			)
		));
	}
	
	public function PreRender()
	{

	}
	
	public function AddItem($title, $url = '', $action = '')
	{
		$item = new Control_extend_menu_item($title, $url, $action);
		$this->items[] = $item;
		return $item;
	}
}

class Control_extend_menu_item
{
	public $items = array();
	
	public $title = '';
	public $url = '';
	public $action = '';
	
	function __construct($title, $url = '', $action = '')
	{
		$this->title = $title;
		$this->url = $url;
		$this->action = $action;
	}
	
	public function AddItem($title, $url = '', $action = '')
	{
		$item = new Control_extend_menu_item($title, $url, $action);
		$this->items[] = $item;
		return $item;
	}
}

?>
