<?php

class UString {
	static function ScreenHref($string)
	{
		return preg_replace(
			array(
			'@<a([^\>]+)href=([^\>]*)>([^\<]*)</a>@ime',
			),
			array(
			"'<noindex><a rel=\"nofollow\"'.stripslashes('\${1}').'href='.stripslashes('\${2}').'>$3</a></noindex>'",
			),
			$string);
	}
	
	static function Url($string, $scheme = true) {

		$string = trim($string);
		if ($scheme)
			return preg_replace("~^(([^:]+)://)?(www\.)?([a-zа-я0-9\._/-]+).*~ie",
			"(('$2' == '') ? 'http://' : '$1') . '$3$4'",$string);
		
		return preg_replace("~^(([^:]+)://)?(www\.)?([a-zа-я0-9\._/-]+).*~ie",
			"'$3$4'",$string);
	}
	
	static function CutDownStr($source, $MAX_STR_LEN)
	{
		if ( strlen($source) > $MAX_STR_LEN ) {
	        $dest = substr($source, 0, $MAX_STR_LEN);
			$dest = substr($dest, 0, strrpos($dest, " "));
			return $dest."&nbsp;...";
		} else
			return $source;
	}
	
	static function Truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
	{
		if ($length == 0)
			return '';

		$string = str_replace(",", ", ", $string);
		$string = str_replace("  ", " ", $string);

		if (strlen($string) > $length) {
			$length -= strlen($etc);
			if (!$break_words && !$middle) {
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
			}
			if(!$middle) {
				return substr($string, 0, $length).$etc;
			} else {
				return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
			}
		} else {
			return $string;
		}
	}
	
	static function AccentFirstWord($string, $accent_color, $color)
	{
		if (preg_match("@^(.*?)\s(.*?)$@", $string, $matches))
		{
			return "<span style=\"color:".$accent_color.";\">".$matches[1]."</span> <span style=\"color:".$color.";\">".$matches[2]."</span>";
		}
		return  "<span style=\"color:".$accent_color.";\">".$string."</span>";
	}
	
	static function ChangeQuotes($text)
	{
		if (is_string($text)) {
			$text = str_replace("'","&#039;",$text);
			$text = str_replace("\"","&#034;",$text);
		} elseif (is_array($text)) {
			foreach($text AS $key => $value) {
				$text[$key] = self::ChangeQuotes($text[$key]);
			}
		}
		return $text;
	}
	
	static function MailToCrypt($string)
	{
		LibFactory::GetStatic('cryptography');
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
				."Написать письмо</a>'",
				);
		return preg_replace($search, $repl, $string);
	}
	
	static function word4number($num, $f, $s, $t) {
		$num = intval($num);
    
		if($num == 1 || ($num > 20 && $num % 10 == 1))
			return $f;
		
		if(($num >= 2 && $num <= 4) || ($num % 10 >= 2 && $num % 10 <= 4 && $num > 20))
			return $s;
		
		return $t;
	}
	
	static function mail2crypt($string, $text = 'Написать письмо') {		
		LibFactory::GetStatic('cryptography');
		
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
				.$text."</a>'",
				);
		return preg_replace($search, $repl, $string);
	}
	
	static function withHref($string, $dont_reduce=false)
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
				'"$6"?"<noindex><a href=\\"http://$5$6\\" target=\\"_blank\\" rel=\\"nofollow\\">".UString::__ReduceUrl__("$2")."</a></noindex>":"$1"', 
				$string);
		}
	}

	static function __ReduceUrl__($full_url) {
		// if length of link more then threshold, then return only domain name
		if ( strlen($full_url) > 30 ) {
			preg_match("/^((http:\/\/)|(www\.))([^\/]+)/i", $full_url, $matches);
			$full_url = $matches[0];
		}
		return $full_url;
	}
}

?>
