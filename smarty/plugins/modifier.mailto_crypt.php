<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     mailto_crypt<br>
 * Date:     March 27, 2008
 * Purpose:  crypt string
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|mailto_crypt}
 * @link 
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_mailto_crypt($string)
{
	include_once(ENGINE_PATH."include/lib.cryptography.php");
	$search = array(
			'/<a([^>]*)href=["\']?mailto:\s*([0-9a-z\.\_\-]+@[0-9a-z\.\_\-]+\.[a-z]{2,4})["\']?([^>]*)>(.+?)<\/a>/ie',
			'/([0-9a-z\.\_\-]+@[0-9a-z\.\_\-]+\.[a-z]{2,4})/ie',
			);
	$repl = array(
			"'<a'.stripslashes('\${1}').'href=\"http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${2}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode(\$_SERVER['SERVER_NAME'].\$_SERVER['REQUEST_URI']))).'\""
			." onclick=\"window.open(\'http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${2}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode(\$_SERVER['SERVER_NAME'].\$_SERVER['REQUEST_URI']))).'\', \'ublock\',\'width=480,height=440,resizable=1,menubar=0,scrollbars=0\').focus(); return false;\"\${3}>"
			."'.(strpos('\${4}', '@')===false?'\${4}':'Написать письмо').'" // проверяем наличие emailа  втексте ссылки
			."</a>'",
			"'<a href=\"http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${1}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode(\$_SERVER['SERVER_NAME'].\$_SERVER['REQUEST_URI']))).'\""
			." onclick=\"window.open(\'http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${1}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode(\$_SERVER['SERVER_NAME'].\$_SERVER['REQUEST_URI']))).'\', \'ublock\',\'width=480,height=440,resizable=1,menubar=0,scrollbars=0\').focus(); return false;\">"
			."Написать письмо</a>'",
			);

	return preg_replace($search, $repl, $string);
}

/* vim: set expandtab: */

?>
