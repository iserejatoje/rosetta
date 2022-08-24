<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:53
 */
abstract class Control_TemplateVirtualControl extends Control_Control implements Control_IVirtualControl, Control_ITemplateControl
{

	private $source				= null;
	private $template			= array();
	private $virtualmode		= false;

	function __construct($parent = null, $name = 'control')
	{
		parent::__construct($parent, $name);
		$this->SetTemplate('container', 'controls/_containers/default');
	}

	function __destruct()
	{
	}
	
	public function Init($params)
	{
		parent::Init($params);
		
		if(isset($params['source']) && is_a($params['source'], 'Source_ISource'))
			$this->SetSource($params['source']);
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

	public function GetSource()
	{
		return $this->source;
	}

	/**
	 * 
	 * @param index
	 */
	public function GetTemplate($index = 'default')
	{
		return $this->template[$index];
	}

	public function GetVirtualMode()
	{
		return $this->virtualmode;
	}

	/**
	 * 
	 * @param source
	 */
	public function SetSource($source)
	{
		if(is_a($source, 'Source_ISource') || $source === null)
			$this->source = $source;
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

	/**
	 * 
	 * @param mode
	 */
	public function SetVirtualMode($mode)
	{
		if(is_bool($mode))
			$this->virtualmode = $mode;
	}
	
	public function Display($vars = array(), $index = 'default')
	{
		STPL::Display($this->template[$index], $vars);
	}
	
	public function Fetch($vars = array(), $index = 'default')
	{
		return STPL::Fetch($this->template[$index], $vars);
	}
}
?>