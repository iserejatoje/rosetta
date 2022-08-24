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
 * Name:     screen_href<br>
 * Purpose:  screen html href tags with tags <noindex></noindex>
 * @param string
 * @return string
 */
function smarty_modifier_screen_href($string)
{
//return preg_replace("/<[aA].+>?<\/[aA]>/Um", "<noindex>$0</noindex>", $string);
	return preg_replace(
		array(
		//'@<a([^\>]+)href=([\'"])([^\2]*?)\2([^\>]*)>([^\<]*)</a>@im',
		'@<a([^\>]+)href=([^\>]*)>([^\<]*)</a>@ime',
		),
		array(
		//'<noindex><a rel="nofollow"$1href=$2$3$2$4>$5</a></noindex>',
		"'<noindex><a rel=\"nofollow\"'.stripslashes('\${1}').'href='.stripslashes('\${2}').'>$3</a></noindex>'",
		#'<noindex><a rel="nofollow"$1href=$2$3>$4</a></noindex>',
		),
		$string);
}

?> 
