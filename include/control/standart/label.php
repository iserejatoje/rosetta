<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_standart_label extends Control_TemplateControl
{
	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_label');
		$this->SetTemplate('controls/standart/label/default');
		$this->SetDrawContainer(false);
	}
}
?>