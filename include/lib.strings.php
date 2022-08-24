<?

/**
	Работа со строками
*/

class Strings {

	/**
	 * Purpose:  Truncate a string to a certain length if necessary,
	 *		   optionally splitting in the middle of a word, and
	 *		   appending the $etc string or inserting $etc into the middle.
	 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
	 *		  truncate (Smarty online manual)
	 * @param string
	 * @param integer
	 * @param string
	 * @param boolean
	 * @param boolean
	 * @return string
	 */
	static function Truncate ($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
	{
		if ( $length == 0 )
			return '';
		
		$string = str_replace(",", ", ", $string);
		$string = str_replace("  ", " ", $string);
		
		if ( strlen($string) > $length )
		{
			$length -= strlen($etc);
			if (!$break_words && !$middle)
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
			if ( !$middle )
				return substr($string, 0, $length).$etc;
			else
				return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
		} else
			return $string;
	}

	static function mailto_crypt2($string, $text = 'Написать письмо')
	{
		LibFactory::GetStatic('cryptography');
		//include_once("engine/include/lib.cryptography.php");
		$search = array(
				'/<a([^>]*)href=["\']?mailto:\s*([0-9a-z\.\_\-]+@[0-9a-z\.\_\-]+\.[a-z]{2,4})["\']?([^>]*)>(.+?)<\/a>/ie',
				'/([0-9a-z\.\_\-]+@[0-9a-z\.\_\-]+\.[a-z]{2,4})/ie',
				);
		$repl = array(
				"'<a'.stripslashes('\${1}').'href=\"http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${2}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode('$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]'))).'\""
				." onclick=\"window.open(\'http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${2}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode('$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]'))).'\', \'ublock\',\'width=480,height=440,resizable=1,menubar=0,scrollbars=0\').focus(); return false;\"\${3}>"
				."'.(strpos('\${4}', '@')===false?'\${4}':'Написать письмо').'" // проверяем наличие emailа  втексте ссылки
				."</a>'",
				"'<a href=\"http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${1}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode('$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]'))).'\""
				." onclick=\"window.open(\'http://rugion.ru/feedback/mailto.php?m='.urlencode(base64_encode(Cryptography::xsx_encode('\${1}'))).'&u='.urlencode(base64_encode(Cryptography::xsx_encode('$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]'))).'\', \'ublock\',\'width=480,height=440,resizable=1,menubar=0,scrollbars=0\').focus(); return false;\">"
				."".$text."</a>'",
				);
		return preg_replace($search, $repl, $string);
	}

}

?>
