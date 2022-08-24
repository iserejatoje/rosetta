<?
/**
* Библиотека перкодировки
* 
* @date		$Date: 2006/09/10 13:00:00 $
*/

/**
* Зависимости:
* Lib:
*  //utf8
*/

class Lib_charsets
{
	static $Name             = "charsets";
	public $charset          = "utf-8";
	
	function Lib_charsets()
	{
		global $CONFIG, $LCONFIG;
		
//		LibFactory::GetConfig(self::$Name);
//		$this->_config = $LCONFIG[self::$Name];
	}
	
	function Init()
	{
	}

	function EncodeMimeString($input, $charset = null)
	{
		if($charset == null)	
			$charset = $this->charset;
		$preferences = array(
			"input-charset" => $charset,
			"output-charset" => $charset,
			"line-length" => 500,
			"line-break-chars" => "",//"\r\n",
			"scheme" => "Q"
		);
		return substr(iconv_mime_encode("", $input, $preferences), 2);
	}

	function DecodeMimeString($input, $charset = null)
	{
		if($charset == null)	
			$charset = $this->charset;
		// входная строка типа "=?Windows-1251?Q?=F1_=E0?="
		$pos = strpos($input, "=?");
		$w = rand(0,100);
		if ($pos !== false)
		{
			$input = strval($input);
			$len = strlen($input);
			$in_mime = false;
			for($i=0; $i<$len;)
			{
				if($in_mime === false)
				{
					$end = strpos($input, "=?", $i); // конец текста
					if($end === false)
					{// если не нашли, то дописываем остатки и выходим
						$out.= substr($input, $i);
						break;
					}
					$out.= substr($input, $i, $end - $i);
					$in_mime = true;
				}
				else
				{// если не нашли что-то, то выходим забывая про остаток
					$end = strpos($input, "?", $i + 2); // конец charset
					if($end === false)
						break;
					$end = strpos($input, "?", $end + 1); // конец enctype
					if($end === false)
						break;
					$end = strpos($input, "?=", $end + 1); // конец текста
					if($end === false)
						break;
					$out.= $this->DecodeMimeString2(substr($input, $i + 2, $end - $i - 2), $charset);
					$end+= 2;
					$in_mime = false;
				}
				$i = $end;
			}
			return $out;
		}
		else
		{
			//$cs = $this->DetectCharSet($input);
			return $this->ConvertCharSet($input, $cs, $charset);
		}
	}

	function DecodeMimeString2($str, $charset = null)
	{
		if($charset == null)	
			$charset = $this->charset;
		$a = explode("?", $str);
		$count = count($a);
		if ($count >= 3)
		{	//should be in format "charset?encoding?base64_string"
			for ($i = 2; $i < $count; $i++)
				$rest .= $a[$i];

			if( ($a[1]=="B") || ($a[1]=="b") )
				$rest = base64_decode($rest);
			else if( ($a[1]=="Q") || ($a[1]=="q") )
				$rest = quoted_printable_decode(str_replace("_", " ", $rest));
			return $this->ConvertCharSet($rest, $a[0], $charset);
		}
		else
			return $str;		//we dont' know what to do with this
	}

	function ConvertCharSet($string, $from, $to = null)
	{
		if($to == null)	
			$to = $this->charset;
		// arrays for the "convert_cyr_string" function
		$charsets = array(
			//'koi8-r' => 'k',
			//'windows-1251' => 'w',
			'iso8859-5' => 'i',
			'cp866' => 'a',// или d. см. manual
			//'x-cp866' => 'a',// или d. см. manual
			'mac' => 'm',
			//'x-mac-cyrillic' => 'm',
		);

		$from = trim(strtolower($from));
		$to = trim(strtolower($to));

		//if( $to != $from && isset($charsets[$to]) && isset($charsets[$from]) )
			//return convert_cyr_string($string, $charsets[$from], $charsets[$to]);
		/*else if($from == 'utf-8')
		{
			LibFactory::GetStatic('utf8');
			return utf8::ToUnicodeEntities($string);
		}*/
		//else
		if($from!='' && $to!='')
			return iconv($from, $to."//TRANSLIT", $string);
		else
			return $string;
	}

	// used:
	// mod_mail_common_LangDecodeSubject
	function DetectCharSet($str)
	{
		$LOWERCASE = 3; 
		$UPPERCASE = 1; 

		$charsets = Array( 
			'koi8-r' => 0, 
			'windows-1251' => 0, 
			'cp866' => 0, 
			'iso-8859-5' => 0, 
			'mac' => 0 
		); 
		for ( $i = 0, $length = strlen($str); $i < $length; $i++ )
		{ 
			$char = ord($str[$i]); 
			//non-russian characters 
			if ($char < 128 || $char > 256) continue; 

			//CP866 
			if (($char > 159 && $char < 176) || ($char > 223 && $char < 242))  $charsets['cp866']+=$LOWERCASE; 
			if (($char > 127 && $char < 160)) $charsets['cp866']+=$UPPERCASE; 

			//KOI8-R 
			if (($char > 191 && $char < 223)) $charsets['koi8-r']+=$LOWERCASE; 
			if (($char > 222 && $char < 256)) $charsets['koi8-r']+=$UPPERCASE; 

			//WIN-1251 
			if ($char > 223 && $char < 256) $charsets['windows-1251']+=$LOWERCASE; 
			if ($char > 191 && $char < 224) $charsets['windows-1251']+=$UPPERCASE; 

			//MAC 
			if ($char > 221 && $char < 255) $charsets['mac']+=$LOWERCASE; 
			if ($char > 127 && $char < 160) $charsets['mac']+=$UPPERCASE; 

			//ISO-8859-5 
			if ($char > 207 && $char < 240) $charsets['iso-8859-5']+=$LOWERCASE; 
			if ($char > 175 && $char < 208) $charsets['iso-8859-5']+=$UPPERCASE; 

		} 
		arsort($charsets); 
		return key($charsets); 
	} 


}

?>