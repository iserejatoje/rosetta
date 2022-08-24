<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     url<br>
 * Purpose:  convert link
 * @param string
 * @return string
 */
function smarty_modifier_url($string, $scheme = true)
{

	if ($scheme)
		return preg_replace("~^((.+)://)?(www\.)?([\~a-z0-9\._/-]+).*~ie",
			"(('$2' == '') ? 'http://' : '$1') . '$3$4'",$string);
		
	return preg_replace("~^((.+)://)?(www\.)?([\~a-z0-9\._/-]+).*~ie",
		"'$3$4'",$string);
}

?> 