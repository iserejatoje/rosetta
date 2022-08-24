<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty floor modifier plugin
 *
 * Type:     modifier<br>
 * Name:     floor<br>
 * Purpose:  convert digit to string using function floor()
 * @param int, float
 * @return string
 */
function smarty_modifier_floor($digit)
{
	return floor($digit);
}

?>