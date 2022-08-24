<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty number_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     number_format<br>
 * Purpose:  convert digit to string using function number_format()
 * @param int, float
 * @return string
 */
function smarty_modifier_number_format($digit, $decimals=2, $dec_point=",", $thousands_sep="")
{
	return number_format($digit, $decimals, $dec_point, $thousands_sep);
}

?> 