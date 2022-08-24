<?

/**
 * Хендлер для работы с модулями
 * @package Handlers
 */

// задание по uri
// если uri строка, то в качестве источника берется остаток строки
// если uri регулярка, то в $params['index_source'] индекс из регулярки

class Handler_source extends IHandler
{
	private $json;
	private $source;

	public function Init($params)
	{
		global $CONFIG;
		// создаем окружение
		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		if(strpos($host, 'dvp.') === 0)
			$host = substr($host, 4);

		LibFactory::GetStatic('data');

		$CONFIG['env']['site']	= ModuleFactory::GetConfigById('site', STreeMgr::GetSiteIDByHost($host));
		$CONFIG['env']['site']['tree_id'] = STreeMgr::GetSiteIDByHost($host);

		$sitenode = STreeMgr::GetNodeByID($CONFIG['env']['site']['tree_id']);

		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['regid']	= Data::Is_Number($sitenode->Regions)?$sitenode->Regions:0;
		unset($host);

		if(substr($el['uri'], 0, 1) == '@' && substr($el['uri'], strlen($el['uri']) - 1, 1) == '@')
		{
			if(!isset($params['index']['source']))
				return false;
			preg_match($params['uri'], HandlerFactory::$env['uri'], $matches);
			$this->source = $matches[$params['index']['source']];
		}
		else
		{
			if(strlen($params['uri']) < strlen(HandlerFactory::$env['url']))
				$this->source = substr(HandlerFactory::$env['url'], strlen($params['uri']) );
			else
				$this->source = '';
		}
		if(empty($this->source))
			return false;
	}

	public function IsLast()
	{
		return true;
	}

	public function Run()
	{
		global $OBJECTS;

		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
		header("Pragma: no-cache");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Last-Modified: ".date("r", time() - 86400));

		$params = null;
		if($_SERVER['REQUEST_METHOD'] == 'POST')
			$params =& $_POST;
		else
			$params =& $_GET;

		LibFactory::GetStatic('source');
		$data = Source::GetData($this->source, $params);

		if($params['output_type'] == 'xml')
		{
			echo $this->encodeXML($data);
		}
		else if($params['output_type'] == 'plain')
		{
			header("Content-type: text/plain; charset=utf-8");
			echo $this->returnPlain($data);
		}
		else
		{
			// В дальнейшем выбрать один из вариантов.
			// Смотреть задачу #2849 в Redmine.
//			if(isset($params['native_ajax']))
//			{
				header('Content-type: application/json');
				//mb_convert_variables('utf-8','windows-1251',$data);
				echo json_encode($data);
				exit;
//			}
//			else
//			{
//				include_once $GLOBALS['CONFIG']['engine_path'].'include/json.php';
//				$this->json = new Services_JSON();
//				$this->json->charset = 'WINDOWS-1251';
//				echo $this->encodeJSON($data);
//			}
		}
	}

	private function encodeXML($data)
	{
		header('Content-type: text/xml; charset=utf-8');
		return $this->toXml($data, 'params', null);
	}

	private function toXml($data, $rootNodeName = 'root', $xml=null)
	{
		if (ini_get('zend.ze1_compatibility_mode') == 1)
			ini_set ('zend.ze1_compatibility_mode', 0);

		if ($xml == null)
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");

		foreach($data as $key => $value)
		{
			if (is_numeric($key))
			{
				$key = "key_". (string) $key;
			}

			//$key = preg_replace('/[^a-z]/i', '', $key);

			if (is_array($value))
			{
				$node = $xml->addChild($key);
				$this->toXml($value, $rootNodeName, $node);
			}
			else
			{
				if (is_bool($value))
					$value = ($value==true) ? "1" : "0";
				/*
				if (strlen($value)==0)
					$value="\n";
				if ($_GET['debug']> 122)
					$value = iconv("windows-1251", "utf-8", "Опаньки\n\n\n\r\n\r\n\t\t\t <a href=\"asd\"></a>\"\"</name> '123");
				else if ($_GET['debug']> 12)
					$value = htmlspecialchars((string)$value);
				else
					$value = htmlentities((string)$value);
				*/
				$value = iconv("WINDOWS-1251", "UTF-8", strval($value));
				$xml->addChild($key,$value);
			}
		}

		return $xml->asXML();
	}

	/*private function toXml($data, $rootNodeName = 'data', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}

		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}

		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = "unknownNode_". (string) $key;
			}

			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z]/i', '', $key);

			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				$this->toXml($value, $rootNodeName, $node);
			}
			else
			{
				// add single node.
                                $value = htmlentities($value);
				$xml->addChild($key,$value);
			}

		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}
*/

	private function returnPlain($data)
	{
		$res = "";
		$fields = array();
		if(is_array($data) && sizeof($data)>0)
			foreach($data as $k=> $v)
			{
				$res.= $k;
				if(is_array($v) && sizeof($v)>0)
					foreach($v as $k1=> $v1)
					{
						if(sizeof($fields)==0)
							$fields[$k1] = $k1;
						$res.= "\t".$v1;
					}
				$res.= "\n";
			}
		if(sizeof($fields)>0)
			$res = "ID\t".implode("\t", $fields)."\n".$res;
		return $res;
	}

	private function encodeJSON($data)
	{
		return $this->json->encode($data);
	}

	public function Dispose()
	{
	}
}
?>
