<?
/**
* Библиотека работы с IMAP
* Пределана из Iloha MIME Library (IML)
* (C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
*
*	PURPOSE:
*		Provide functions for handling mime messages.
*	USAGE:
*		Use iil_C_FetchStructureString to get IMAP structure stirng, then pass that through
*		$this->GetRawStructureArray() to get root node to a nested data structure.
*		Pass root node to the $this->GetPart*() functions to retreive individual bits of info.
*
* 
* @date		$Date: 2006/09/10 13:00:00 $
*/

/**
* Зависимости:
* Lib:
* 
*/

class Lib_mime
{
	static $Name             = "mime";
	public $types            = array(
		0=>"text",
		1=>"multipart",
		2=>"message",
		3=>"application",
		4=>"audio",
		5=>"image",
		6=>"video",
		7=>"other"
	);
	public $encodings        = array(
		0=>"7bit",
		1=>"8bit",
		2=>"binary",
		3=>"base64",
		4=>"quoted-printable",
		5=>"other"
	);
	public $structure_str    = "";
	public $structure        = array();
	public $parts            = array();
	private $verbose         = 0;
	
	function Lib_mime()
	{
		global $CONFIG, $LCONFIG;
		
//		LibFactory::GetConfig(self::$Name);
//		$this->_config = $LCONFIG[self::$Name];
	}
	
	function Init($structure_str = "")
	{
		if(is_array($structure_str))
		{
			$this->structure_str = "";
			$this->structure = $structure_str;
			$this->parts = array();
		}
		else
		{
			$this->structure_str = $structure_str;
			$this->structure = array();
			$this->parts = array();
			$this->GetRawStructureArray();
		}
		if($_GET['debug']>2)
			$this->verbose = 1;
	}

	function ClosingParenPos($str, $start)
	{
		$level=0;
		$len = strlen($str);
		$in_quote = 0;
		for($i=$start; $i<$len; $i++)
		{
			if ($str[$i]=="\"" && $i>0 && $str[$i-1]!="\\")
				$in_quote = ($in_quote + 1) % 2;
			if (!$in_quote)
			{
				if ($str[$i]=="(")
					$level++;
				else if (($level > 0) && ($str[$i]==")"))
					$level--;
				else if (($level == 0) && ($str[$i]==")"))
					return $i;
			}
		}
		return false;
	}

	function ParseBSString($str)
	{	
if ($this->verbose)
	echo "<br>".$str."<br><br>";
		$id = 0;
		$a = array();
		$len = strlen($str);
    
		$in_quote = 0;
		for ($i=0; $i<$len; $i++)
		{
			if ($str[$i] == "\"")
			{
				$in_quote = ($in_quote + 1) % 2;				
			}
			else if (!$in_quote)
			{
				if ($str[$i] == " ")
				{
					if ( !isset($a[$id]) )
						$a[$id] = false;
					$id++; //space means new element
				}
				else if ($str[$i]=="(")
				{ //new part
					$i++;
					$endPos = $this->ClosingParenPos($str, $i);
					if($endPos === false)
						break;
					$partLen = $endPos - $i;
					$part = substr($str, $i, $partLen);
					$a[$id] = $this->ParseBSString($part); //send part string
//					if ($this->verbose)
//					{
//						echo "{>".$endPos."}<br>";
//						flush();
//					}
					$i = $endPos;
				}
				else
					$a[$id].=$str[$i]; //add to current element in array
			}
			else if ($in_quote)
			{
				if ($str[$i]=="\\")
				{
					$i++; //escape backslashes
					$a[$id].= $str[$i];
				}
				else
					$a[$id].=$str[$i]; //add to current element in array
			}
		}
		reset($a);
		return $a;
	}

	function GetRawStructureArray()
	{
		$line = substr($this->structure_str, 1, strlen($this->structure_str) - 2);
		$line = str_replace(")(", ") (", $line);
//if ($this->verbose)
//{
//	echo "<br>".$line."<br>";
//}

		$struct = $this->ParseBSString($line);
		if((strcasecmp($struct[0], "message")==0) && (strcasecmp($struct[1], "rfc822")==0))
			$this->structure = array($struct);
		else
			$this->structure = $struct;
if ($this->verbose)
{
	echo "<br><pre>";
	print_r($this->structure);
	echo "</pre><br>";
}
	}

	function GetSubMessage($part = '')
	{
		$parent = $this->GetPartArray($part, false);

		if ((strcasecmp($parent[0], "message")==0) && (strcasecmp($parent[1], "rfc822")==0))
			return $parent[7];
		else
			return array();
	}
	
	function GetPartArray($part = '')
	{
	// $message надо убрать, потому как он теперь не нужен...	
	
		if( $part =='' )
			return $this->structure;
//		else if( isset($this->parts[$part][($message?1:0)]) )
//			return $this->parts[$part][($message?1:0)];

		$arr_part = explode(".", $part);
		$a = $this->structure;
		$cur_part = "";
		if(!is_array($a))
			return false;
/*if ( $_GET['debug'] > 10 ) {
	echo "a: <textarea style='width:100%;height:500px;'>"; print_r($a); echo "</textarea>"; }*/

		foreach($arr_part as $k=>$v)
		{
			$cur_part .= ($cur_part?".":"").$v;
			$a = $a[$v - 1];
			if ( ($cur_part!=$part) && (strcasecmp($a[0], "message") == 0) && (strcasecmp($a[1], "rfc822") == 0) )
				$a = $a[8];
			if(!is_array($a))
				return false;
//			$this->parts[$cur_part][($message?1:0)] = $a;
		}
		return $a;
//		return $this->parts[$part][($message?1:0)];
	}
	
	function GetNumParts($part = null)
	{
		$parent = $this->GetPartArray($part);
//echo "$part : $message<textarea style='width:100%;height:300px;'>"; print_r($parent); echo "</textarea>";

		if ( (strcasecmp($parent[0], "message")==0) && (strcasecmp($parent[1], "rfc822")==0))
			$parent = $parent[8];

		$c = 0;
		if(count($parent)>0)
			foreach( $parent as $key => $val )
			{
				if (is_array($val))
					$c++;
				else
					break;
			}
		return $c;
	}

	function GetPartTypeString(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return "MULTIPART/".$part_a[count($part_a)-4];
			else if ( $part_a[0] !== false && $part_a[1] !== false )
				return $part_a[0]."/".$part_a[1];
			else
				return "application/octet-stream";
		}
		else
			return false;
	}

	function GetPartTypeCode(&$part_a)
	{
		if($part_a)
		{
			if (is_array($part_a[0]))
				$str = "multipart";
			else
				$str = $part_a[0];

			$code = array_search(strtolower($str), $this->types);
			if($code === false)
				return array_search('other', $this->types);

			return $code;
		}
		else
			return -1;
	}

	function GetPartEncodingCode(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
				$str = $part_a[5];

			$code = array_search(strtolower($str), $this->encodings);
			if($code === false)
				return array_search('other', $this->encodings);

			return $code;
		}
		else
			return -1;
	}

	function GetPartEncodingString(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
				return $part_a[5];
		}
		else
			return -1;
	}

	function GetPartSize(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
				return $part_a[6];
		}
		else
			return -1;
	}

	function GetPartID(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
				return $part_a[3];
		}
		else
			return -1;
	}

	function GetPartDisposition(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
			{
				$id = count($part_a) - 2;
				// если часть не помечена как вложение, но нам его девать некуда - мы делаем его вложением.
				if($part_a[0] != "text" && !is_array($part_a[$id]))
				{
					if (is_array($part_a[2]))
					{
						$name="";
						foreach($part_a[2] as $key=>$val)
							if ( (strcasecmp($val, "name")==0) || (strcasecmp($val, "filename")==0)) 
								$name = $part_a[2][$key+1];
					}
					if($name)
						$part_a[$id] = array("attachment",	array("filename", $name));
				}
				if (is_array($part_a[$id]))
					return $part_a[$id][0];
				else
					return "";
			}
		}
		else
			return "";
	}

	function GetPartName(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
			{
				$name = "";
				if (is_array($part_a[2]))
				{
					//first look in content type
					$name="";
					foreach($part_a[2] as $key=>$val)
						if ( (strcasecmp($val, "name")==0) || (strcasecmp($val, "filename")==0)) 
							$name = $part_a[2][$key+1];
				}
				if (empty($name))
				{
					//check in content disposition
					$id = count($part_a) - 2;
					if ( is_array($part_a[$id]) && is_array($part_a[$id][1]) )
					{
						$array = $part_a[$id][1];
						foreach($array as $key=>$val)
							if ((strcasecmp($val, "name")==0)||(strcasecmp($val, "filename")==0)) 
								$name=$array[$key+1];
					}
				}
				return $name;
			}
		}
		else
			return "";
	}

	function GetPartCharset(&$part_a)
	{
		if ($part_a)
		{
			if (is_array($part_a[0]))
				return -1;
			else
			{
				if (is_array($part_a[2]))
				{
					$name="";
					foreach($part_a[2] as $key=>$val)
						if (strcasecmp($val, "charset")==0)
							$name = $part_a[2][$key+1];
					return $name;
				}
				else
					return "";
			}
		}
		else
			return "";
	}

	function GetPartField($part = null, $fields = array(), $for_message = false)
	{
		$part_a = $this->GetPartArray($part);

/*if ( $_GET['debug'] > 10 ) {
	echo "part: $part <textarea style='width:100%;height:500px;'>"; print_r($part_a); echo "</textarea>"; }*/

		if ( !$for_message && (strcasecmp($part_a[0], "message")==0) && (strcasecmp($part_a[1], "rfc822")==0))
			$part_a = $part_a[8];

		$data = array();
		if(!is_array($fields))
			$fields = array($fields);
		
		if(count($fields))
			foreach($fields as $v)
				switch($v)
				{
				case 'typestring':
					$data[$v] = $this->GetPartTypeString($part_a);
					break;
				case 'typecode':
					$data[$v] = $this->GetPartTypeCode($part_a);
					break;
				case 'charset':
					$data[$v] = $this->GetPartCharset($part_a);
					break;
				case 'disposition':
					$data[$v] = $this->GetPartDisposition($part_a);
					break;
				case 'encodingcode':
					$data[$v] = $this->GetPartEncodingCode($part_a);
					break;
				case 'encodingstring':
					$data[$v] = $this->GetPartEncodingString($part_a);
					break;
				case 'id':
					$data[$v] = $this->GetPartID($part_a);
					break;
				case 'name':
					$data[$v] = $this->GetPartName($part_a);
					break;
				case 'size':
					$data[$v] = $this->GetPartSize($part_a);
					break;
				}
		return $data;
	}

	// выводит массив всех вложений
	function GetPartList($part = null, $fields = null)
	{
		if($part == null)
			$part = "";
		if($fields == null)
			$fields = array('typecode', 'disposition', 'typestring','id','name','encodingstring', 'charset');
		$data = array();
		$num_parts = $this->GetNumParts($part);
		
/*if ( $_GET['debug'] > 10 )
	echo "num_parts = $num_parts<br/>";*/
		
		for ($i = 0; $i<$num_parts; $i++)
		{
			$part_code = $part.($part==""?"":".").($i+1);

/*if ( $_GET['debug'] > 10 )
	echo "partcode=$part_code ";*/

			$arr = $this->GetPartField($part_code, array('typecode', 'disposition'), true);
			$part_type = $arr['typecode'];
			$part_disposition = $arr['disposition'];
			// $part_type==2 - это message. мы не будем разворачивать мессадж.
			if( (strcasecmp($part_disposition, "attachment")!=0) && ($part_type == 1))
				$data += $this->GetPartList($part_code, $fields);
			else
				$data[$part_code] = $this->GetPartField($part_code, $fields, true);
		}
		
/*if ( $_GET['debug'] > 10 ) {
	echo "partlist ($part : $message) <textarea style='width:100%;height:500px;'>"; print_r($data); echo "</textarea>"; }*/
	
		return $data;
	}

	function GetAttList($part = null, $fields = null)
	{
		$list = $this->GetPartList($part, $fields);
		$list1 = array();
		if(count($list)>0)
			foreach($list as $k=>$v)
			{
				if($v['disposition'] == "attachment")
					$list1[$k] = $v;
			}
		return $list1;
	}

}

?>