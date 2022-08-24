<?
class XML2
{
	// конвертация массива в XML
	public static function ToXML($arr, $asxml = true, $root = 'root')
	{
		try
		{
			$doc = new DOMDocument('1.0', 'utf-8');
			$doc->formatOutput = true;
			$root = $doc->appendChild($doc->createElement($root));
		}
		catch(Exception $e)
		{
			return null;
		}
		
		self::buildXML($doc, $root, $arr);
		
		if($asxml)
			return $doc->saveXML();
		else
			return $doc;
	}
	
	public static function BuildXML($doc, $node, &$arr, $name = 'item')
	{
		if(!is_array($arr) || count($arr) == 0)
			return;
			
		foreach($arr as $k => $v)
		{
			if(is_array($v))
			{
				$snode = $doc->createElement($name);
				$snode->setAttribute('name', $k);
				$node->appendChild($snode);
				self::buildXML($doc, $snode, $v, $name);
			}
			elseif(is_bool($v))
			{
				$snode = $doc->createElement($name, $v?'true':'false');
				$snode->setAttribute('name', $k);
				$node->appendChild($snode);
			}
			elseif(is_scalar($v))
			{
				// все закидываем в UTF-8
				if(self::isNeedEscape($v))
				{
					$snode = $doc->createElement($name);
					$snode->setAttribute('name', $k);
					$cdata = $doc->createCDATASection($v);
					$snode->appendChild($cdata);
					$node->appendChild($snode);
				}
				else
				{
					$snode = $doc->createElement($name, $v);
					$snode->setAttribute('name', $k);
					$node->appendChild($snode);
				}
			}
		}
		return;
	}
	
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
	
	// конвертация XML в массив
	public static function FromXML($xml, $handlers = array())
	{
	
		try
		{
			$doc = new DOMDocument('1.0');
			$doc->loadXML($xml, LIBXML_NOBLANKS | LIBXML_NOCDATA);
		}
		catch(Exception $e)
		{
			return false;
		}
		self::parseXML($doc, $doc, $handlers);
		return true;
	}
	
	private static function parseXML($doc, $node, $handlers)
	{
		if($node === null)
			$node = $doc;

		if($node->hasChildNodes())
		{
			for($i = 0; $i < $node->childNodes->length; $i++)
			{
				$n = $node->childNodes->item($i);
				
				//if($n->nodeType != XML_ELEMENT_NODE)
				//	continue;
				
				$parsechildren = true;
				$nodeparse = $n;
				
				if(isset($handlers[$n->nodeName]))
				{
					// обработка
					$res = $handlers[$n->nodeName]->Parse($doc, $n);
					if(is_a($res, 'DOMNode'))
						$nodeparse = $n;
					elseif($res === null)
						$parsechildren = false;
				}
				
				if($nodeparse->hasChildNodes() && $nodeparse->firstChild->nodeType != XML_ELEMENT_NODE)
					$parsechildren = false;
				
				if($parsechildren === true)
					self::parseXML($doc, $nodeparse, $handlers);
			}
		}
	}
	
	public static function Validate($xml)
	{
		echo $xml;
		exit;
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

interface IXMLParserProvider
{
	public function Parse($doc, $node);
}
?>