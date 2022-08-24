<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty round modifier plugin
 *
 * Type:     modifier<br>
 * Name:     round<br>
 * Purpose:  convert digit to string using function round()
 * @param int, float
 * @return string
 */
function smarty_modifier_round($digit, $precision=0)
{
	return round($digit, $precision);
}

?> 