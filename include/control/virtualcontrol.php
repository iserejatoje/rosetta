<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:54
 */
abstract class Control_VirtualControl extends Control_Control implements Control_IVirtualControl
{

	private $source					= null;
	private $virtualmode			= false;

	function __construct($parent = null, $name = 'control')
	{
		parent::__construct($parent, $name);
	}

	function __destruct()
	{
	}



	public function GetSource()
	{
		return $this->source;
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
		if(is_a($source, 'ISource'))
			$this->source = $source;
	}

	/**
	 * 
	 * @param mode
	 */
	public function SetVirtualMode($mode)
	{
		if(is_bool($mode))
			$this->mode = $mode;
	}

}
?>