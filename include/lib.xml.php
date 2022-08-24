<?
class XML
{
	public static function isNeedEscape($str)
	{
		$len = strlen($str);
		for($i = 0; $i < $len; $i++)
		{
			$ch = substr($str, $i, 1);
			$chc = ord($ch);
			if($ch == '>' || $ch == '<' || $ch == '&')
				return true;
		}
		return false;
	}
	
	public static function escapeData($str)
	{
		if(self::isNeedEscape($str) == true)
			return "<![CDATA[".$str."]]>";
		else
			return $str;
	}
	
	public static function ToXML($arr)
	{
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		
		return $str."<root>\n".self::buildNode($arr, 1)."</root>\n";
	}
	
	private static function buildNode(&$arr, $indent)
	{
		$str = '';
		if(!is_array($arr) || count($arr) == 0)
			return '';
		foreach($arr as $k => $v)
		{
			if(is_array($v))
			{
				$str.= self::indent($indent).self::toTag($k)."\n";
				$str.= self::buildNode($v, $indent+1);
				$str.= self::indent($indent).self::toTag($k, true)."\n";
			}
			elseif(is_bool($v))
			{
				$str.= self::indent($indent).self::toTag($k);
				if($v === true)
					$str.= "true";
				else
					$str.= "false";
				$str.= self::toTag($k, true)."\n";
			}
			elseif(is_scalar($v))
			{
				$str.= self::indent($indent).self::toTag($k).self::escapeData($v).self::toTag($k, true)."\n";
			}
		}
		return $str;
	}
	
	private static function toTag($name, $closed = false)
	{
		if($closed == true)
			return "</item>";
		else
			return "<item name=\"".$name."\">";
		return $tag;
	}
	
	private static function indent($indent = 0)
	{
		return str_repeat("\t", $indent);
	}
	
	// конвертация XML в массив
	public static function FromXML($xml)
	{		
		try
		{
			$sxml = new SimpleXMLElement($xml);			
		}
		catch(Exception $e)
		{
			return null;
		}
		return self::parseXML($sxml);
	}
	
	private static function parseXML($sxml)
	{
		$arr = array();
		
		foreach($sxml as $k => $v)
		{
			$k = (string)$v['name'];
			//if(strpos($k, '_') === 0)
			//	$k = substr($k, 1);
			if(count($v->children()) == 0)
				$arr[$k] = $v;
			else
				$arr[$k] = self::parseXML($v->children());
		}
		return $arr;
	}
	
	public static function Validate($xml)
	{
		libxml_use_internal_errors(true);
		
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);

		$errors = libxml_get_errors();
		
		if (empty($errors))
		{
				return true;
		}
		
		$error = $errors[ 0 ];
		if ($error->level < 3)
		{
				return true;
		}

		$lines = explode("\n", $xml);
		$line = $lines[($error->line)-1];

		$message = $error->message.' at line '.$error->line.':<br />'.htmlspecialchars($line);

		return $message;
	}
}
?>