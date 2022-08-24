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
 * Name:     with_href<br>
 * Purpose:  convert simple link to html href tag
 * @param string
 * @return string
 */
function smarty_modifier_with_href($string, $dont_reduce=false)
{
	// старый вариант
	//	return preg_replace("/(((http:\/\/)|(www\.))([^<>]+?))(<|>|&lt|&gt|\s|$)/e", "'<noindex><a href=\"http://$4$5\" target=\"_blank\">'.__ReduceUrl__('$1').'</a></noindex> $6'", $string);
	// новый, не трогает ссылки в тагах
	if ( $dont_reduce === true )
	{
		return preg_replace(
			"/(?(?=\<)([^>]+>)|(((http:\/\/)|(www\.))([\w\.,_\-\@%;:~\/\?\=\&\+#]+)))/e", 
// Кто закоментил эту строку и написал следующую? Объясните мне, с какого перепугу это было сделано?! Фарид.
			//"/(?(?=\<)([^>]+>)|(((http:\/\/)|(www\.))([^\s]+)))/e",
			'"$6"?"<noindex><a href=\\"http://$5$6\\" target=\\"_blank\\" rel=\\"nofollow\\">$2</a></noindex>":"$1"', 
			$string);
	} else {
		return preg_replace(
			"/(?(?=\<)([^>]+>)|(((http:\/\/)|(www\.))([\w\._\-\@%\/\?\=\&\+#]+)))/e", 
			//"/(?(?=\<)([^>]+>)|(((http:\/\/)|(www\.))([^\s]+)))/e", 
			'"$6"?"<noindex><a href=\\"http://$5$6\\" target=\\"_blank\\" rel=\\"nofollow\\">".__ReduceUrl__("$2")."</a></noindex>":"$1"', 
			$string);
	}
}

function __ReduceUrl__($full_url) {
	// if length of link more then threshold, then return only domain name
	if ( strlen($full_url) > 30 ) {
		preg_match("/^((http:\/\/)|(www\.))([^\/]+)/i", $full_url, $matches);
		$full_url = $matches[0];
	}
	return $full_url;
}

?> 
