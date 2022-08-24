<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty implode modifier plugin
 *
 * Type:     modifier<br>
 * Name:     implode<br>
 * Purpose:  implode array to string
 * @link http://smarty.php.net/manual/en/language.modifier.implode.php
 *          implode (Smarty online manual)
 * @param string
 * @param array
 * @return string
 */
function smarty_modifier_implode($string=" ", $array)
{
	$s = implode($string, $array);
	return $s;
}

?>
