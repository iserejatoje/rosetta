<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:53
 */
abstract class Control_TemplateControl extends Control_Control implements Control_ITemplateControl
{

	private $template			= array();

	function __construct($parent = null, $name = 'control')
	{
		parent::__construct($parent, $name);
		$this->SetTemplate('container', 'controls/_containers/default');
	}


	/**
	 * 
	 * @param index
	 */
	public function GetTemplate($index = 'default')
	{
		return $this->template[$index];
	}
	
	public function Render()
	{
		$this->PreRender();
		if($this->GetVisible() === true && $this->renderbuffer === null)
			$this->renderbuffer = $this->RenderContainer($this->Draw());
			
		return $this->renderbuffer;
	}
	
	// рендерит рамку вокруг контрола исходя из базовых параметров
	private function RenderContainer($html)
	{
		if($this->GetDrawContainer() === true)
		{
			return $this->Fetch(array(
				'this' => $this,
				'private' => array(
					'control' => $html)
			),
			'container');
		}
		else
		{
			return $html;
		}
	}

	/**
	 * 
	 * @param template
	 * @param index
	 */
	public function SetTemplate($index, $template = null)
	{
		if($template === null)
		{
			$template = $index;
			$index = 'default';
		}
		$this->template[$index] = $template;
	}
	
	public function Draw()
	{
		return $this->Fetch();
	}
	
	public function Display($vars = array(), $index = 'default')
	{
		$vars['this'] = $this;
		STPL::Display($this->template[$index], $vars);
	}
	
	public function Fetch($vars = array(), $index = 'default')
	{
		$vars['this'] = $this;
		return STPL::Fetch($this->template[$index], $vars);
	}
}
?>