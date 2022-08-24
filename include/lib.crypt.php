<?

class lib_crypt
{
	var $_code;
	function lib_crypt()
	{
		$this->_code = rand(10000,99999);
	}
	
	function get_uncrypt_script()
	{
		return "<script>function __func_uncrypt(key,text){out = new String();for(i = 0; i < text.length; i+=2)
	{v = (text.charCodeAt(i)-48-(text.charCodeAt(i)>64?7:0))*16+text.charCodeAt(i+1)-48-(text.charCodeAt(i+1)>64?7:0);out+=key.charAt(v);}document.write(out);}</script>";
	}
	
	function get_mail_uncrypt_script()
	{
		return "<script>function __func_muncrypt(key,text){out = new String();for(i = 0; i < text.length; i+=2)
	{v = (text.charCodeAt(i)-48-(text.charCodeAt(i)>64?7:0))*16+text.charCodeAt(i+1)-48-(text.charCodeAt(i+1)>64?7:0);out+=key.charAt(v);}document.write(out);}</script>";
	}
	
	function get_mail_uncrypt_query($text, $add='')
	{
		// вытаскивем email
		preg_match('/(\b[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\.[A-Za-z]{2,4}\b)/i', $text, $match);
		$mail = $match[1];
		// генерим массив символов из строки (в случайном порядке) и добиваем случайными символами
		$_key = "<a href=\"mailto:$mail\"";
		if(!empty($add))
			$_key.= ' '.$add;
		$_key.= ">$text</a>";
		$text = $_key;
		for($i=0;$i<16;$i++)
		{
			$v = chr(rand(32,127));
			if($v != '\'' && $v != '"' && $v != '\\')
				$_key.= $v;
		}
		$arr = array();
		for($i = 0; $i < strlen($_key); $i++)
			$arr[] = $_key{$i};
		$arr = array_unique($arr);
		shuffle($arr);
		$_key = implode('', $arr);
		for($i = 0; $i < strlen($text); $i++)
			$val.= sprintf('%02s', base_convert(strpos($_key, $text{$i}),10,16));
		$val = strtoupper($val);
		$val = str_replace("'","\\'", $val);
		return "<script>__func_muncrypt('$_key','$val');</script>";
	}
}

?>
