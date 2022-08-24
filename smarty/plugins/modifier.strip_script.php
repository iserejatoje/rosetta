<?
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip_script modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip<br>
 * Purpose:  Removes all javascript
 */

function smarty_modifier_strip_script($string)
{
	// вырезаем все содержимое блока <script>..</script>
	$string = preg_replace("@<script[^>]*>(.*)</script>@im","",$string);
	
	// вырезаем вызовы событий
	$string = preg_replace('@(<[^<]+)on[a-zA-Z]+\s*=\s*\"[^\"]*\"@im',"\\1",$string);
	$string = preg_replace("@(<[^<]+)on[a-zA-Z]+\s*=\s*\'[^\']*\'@im","\\1",$string);
	
	return $string;
}

?>