<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function smarty_modifier_accentfirstword($string, $accent_color, $color)
{

	if (preg_match("@^(.*?)\s(.*?)$@", $string, $matches))
		{
			return "<span style=\"color:".$accent_color.";\">".$matches[1]."</span> <span style=\"color:".$color.";\">".$matches[2]."</span>";
		}
		return  "<span style=\"color:".$accent_color.";\">".$string."</span>";
}

/* vim: set expandtab: */


