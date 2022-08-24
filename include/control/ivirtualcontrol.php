<?php


/**
 * контрол использующий виртуальный рендеринг
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:52
 */
interface Control_IVirtualControl
{

	public function GetSource();

	public function GetVirtualMode();

	/**
	 * 
	 * @param source
	 */
	public function SetSource($source);

	/**
	 * 
	 * @param mode
	 */
	public function SetVirtualMode($mode);

}
?>