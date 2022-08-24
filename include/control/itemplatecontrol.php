<?php


/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:53
 */
interface Control_ITemplateControl
{

	/**
	 * 
	 * @param index
	 */
	public function GetTemplate($index = 'default');

	/**
	 * 
	 * @param template
	 * @param index
	 */
	public function SetTemplate($index, $template = null);
	
	public function Display($vars = array(), $index = 'default');
	public function Fetch($vars = array(), $index = 'default');

}
?>