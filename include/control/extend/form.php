<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_extend_form extends Control_TemplateControl
{

	private $items			= array();
	private $buttons		= array();
	private $allowbuttons	= array('back', 'submit', 'reset');
	private $onsubmitjs		= array();
	private $method			= 'post';
	private $enctype		= 'application/x-www-form-urlencoded';

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_form');
		$this->SetTemplate('controls/extend/form/default');
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

	}
	
	public function AddItem($title, $ctrl)
	{
		$item = array(
			'id' => $ctrl->GetID(),
			'title' => $title,
			'ctrl' => $ctrl,
		);
		
		$this->items[$ctrl->GetID()] = $item;
	}
	
	public function GetButtons()
	{
		return $this->buttons;
	}
	
	public function GetControl($id)
	{
		return $this->items[$id]['ctrl'];
	}
	
	public function GetMethod()
	{
		return $this->method;
	}
	
	public function GetEncType()
	{
		return $this->enctype;
	}
	
	public function GetOnSubmitJS()
	{
		return $this->onsubmit;
	}
	
	public function AddButton($button, $params = array())
	{
		if(is_string($button))
		{
			if(in_array($button, $this->allowbuttons) && !in_array($button, $this->buttons))
			{
				$btype = $button;
				$btn = ControlFactory::GetInstance('standart/button', null, array('id' => $this->GetID().$button));
				if(is_string($params['title']))
					$btn->SetTitle($params['title']);
				else
				{
					switch($button)
					{
					case 'submit':			$title = 'Принять';			break;
					case 'reset':			$title = 'Очистить';		break;
					case 'back':			$title = 'Назад';			break;
					}
					$btn->SetTitle($title);
				}
				if($button == 'back')
				{
					$btype = 'button';
					$btn->SetJS('location.href="'.$params['url'].'"');
				}
				$btn->SetType($btype);
				$btn->SetDrawContainer(false);
				$this->buttons[$button] = $btn;					
			}
		}
	}
	
	public function SetMethod($method)
	{
		$method = strtolower($method);
		if($method=='post' || $method=='get')
			$this->method = $method;
	}
	
	public function SetEncType($enctype)
	{
		$this->enctype = strtolower($enctype);
	}
	
	// пока такой вариант
	public function SetOnSubmitJS($onsubmit)
	{
		if(is_string($onsubmit))
			$this->onsubmitjs = $onsubmit;
	}
}
?>