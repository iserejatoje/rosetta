<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
// выборки всякие, вид зависит от шаблона
class Control_standart_select extends Control_TemplateControl
{

	private $items			= array();
	private $type			= 'single';
	private $rows			= 2;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_select');
		$this->SetTemplate('controls/standart/select/dropdown');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'items' => $this->items),
			));
	}
	
	public function PreRender()
	{
		if(isset(App::$Request->Request[$this->GetID().'_value']))
		{
			$items = App::$Request->Request[$this->GetID().'_value']->AsArray(VALUE);
			foreach($this->items as $index => $item)
				$this->items[$index]['selected'] = in_array($index, $items);
		}
	}
	
	public function AddItem($index, $title, $selected = false)
	{
		$this->items[$index] = array(
			'id' => $index,
			'title' => $title,
			'selected' => $selected
		);
	}
	
	public function GetItems()
	{
		return $this->items;
	}
	
	public function GetItem($id)
	{
		return $this->items[$id];
	}
	
	public function GetSelected()
	{
		if(isset(App::$Request->Request[$this->GetID().'_value']))
			return App::$Request->Request[$this->GetID().'_value']->AsArray(VALUE);
		else
		{
			$selected = array();
			foreach($this->items as $i)
				if($i['selected'] == true)
					$selected[] = $i['index'];
			return $selected;
		}
	}
	
	public function SetSelected($index, $selected = true)
	{
		if(isset($this->items[$index]) && is_bool($selected))
			$this->items[$index]['selected'] = $selected;
	}
	
	public function GetRows()
	{
		return $this->rows;
	}
	
	public function SetRows($rows)
	{
		if(is_numeric($rows))
			$this->rows = $rows;
	}
	
	public function GetType()
	{
		return $this->type;
	}
	
	
	public function SetType($type)
	{
		if($type == 'single' || $type == 'multi')
			$this->type = $type;
	}
}
?>