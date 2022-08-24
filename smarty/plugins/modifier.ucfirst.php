<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty ucfirst modifier plugin
 *
 * Type:     modifier<br>
 * Name:     ucfirst<br>
 * Purpose:  convert first char of string to uppercase
 * @param string
 * @return string
 */
function smarty_modifier_ucfirst($string) {

/*	
        //Сделано было, когда локаль не была настроена, оставлено на всякий случай.
	$result = ucfirst(ltrim($string));
	$char = ord(substr($string,0,1));
	if (!strcmp($result,$string) && ($char>=224 && $char<=255)) {
		$result = chr($char-32).substr($string,1);
	} 
	return $result;*/
	return ucfirst(ltrim($string));
}
?>
