<?

class RequestTrait Implements ArrayAccess
{

	private $requestObject = null;

	function __construct(&$ro)
	{
		$this->requestObject =& $ro;
	}

	public function UUID($default = false) {
		if (uuid_is_valid($this->requestObject) === true)
			return $this->requestObject;

		return $default;
	}

	public function Value($flags = null) {
		if ($flags === null)
    		return $this->requestObject;

    	if( App::IsEncode() === true )
		{
			$buf = $this->_value($this->requestObject, $flags);
			return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
		}
		else
			return $this->_value($this->requestObject, $flags);
	}

	private function _value($value, $flags) {

		if ( is_array($value) ) {
			foreach ($value as &$_)
				$_ = $this->_value($_, $flags);
			return $value;
		}

		if ($flags & Request::OUT_HTML_CLEAN)
    		$value = strip_tags(html_entity_decode($value));

    	if ($flags & (Request::OUT_HTML_AREA | Request::OUT_HTML | Request::OUT_CHANGE_TAGS)) {
    		$value = str_replace("<","&lt;",$value);
			$value = str_replace(">","&gt;",$value);
		}

    	if ($flags & (Request::OUT_HTML_AREA | Request::OUT_HTML | Request::OUT_CHANGE_QUOTES)) {
    		$value = str_replace("'","&#039;",$value);
			$value = str_replace("\"","&quot;",$value);
		}

    	if ($flags & (Request::OUT_CHANGE_NL))
    		$value = nl2br($value);

    	if ($flags & (Request::OUT_REMOVE_NL))
    		$value = preg_replace(array("/\n/", "/\r/"), array('',''),$value);

    	return trim($value);
	}

	public function Int($default = false, $flags = Request::SIGNED_NUM) {

		if ( $flags === null )
			return $this->Value();

		if ( false !== ($_ = $this->_int($this->requestObject, $flags)) )
			return $_;

		return $default;
	}

	private function _int($value, $flags, $default = false) {

		if( strpos($value, '-') !== 0 && ctype_digit((string) $value) )
		{
			return intval($value);
		}
		else if( strpos($value, '-') === 0 )
		{
			$value = substr($value, 1);
			if ( $flags & Request::SIGNED_NUM && ctype_digit((string) $value))
				return -1*intval($value);
		}

		return $default;
	}

	public function Dec($default = false, $flags = Request::SIGNED_NUM) {

		if ( $flags === null )
			return $this->Value();
		if ( false !== ($_ = $this->_dec($this->requestObject, $flags)) )
			return $_;

		return $default;
	}

	private function _dec($value, $flags, $default = false) {

		$r = localeconv();
		$value = str_replace($r['decimal_point'], '.', $value);

		list ($num, $dec) = explode('.',$value,2);
       	$dec = ( $dec === null || strlen($dec) == 0) ? '0' : $dec;

		if ( false !== $this->_int($num, $flags) && false !== $this->_int($dec, Request::UNSIGNED_NUM) ) {
			return (float) "$num.$dec";
		}

		return $default;
	}

	public function Alpha($default = false) {

	   return $this->_alpha($this->requestObject, $default);
	}

	private function _alpha($value, $default) {

		if ( ctype_alpha((string) $value) )
			return $value;

		return $default;
	}

	public function AlNum($default = false) {
		return $this->_alnum($this->requestObject, $default);
	}

	private function _alnum($value, $default) {
		 if ( ctype_alnum((string) $value) )
			return $value;

		return $default;
	}

	public function Email($default = false) {
    	if( App::IsEncode() === true )
		{
			$buf = $this->_email($this->requestObject, $default);
			if( is_string($buf) )
				return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
			else
				return $buf;
		}
		else
			return $this->_email($this->requestObject, $default);
	}

	private function _email($value, $default) {
		$value = trim($value);
		if ( Data::Is_Email($value) )
			return $value;

		return $default;
		//return htmlentities($default, ENT_QUOTES, 'cp1251');
	}

	public function Phone($default = false) {
    	if( App::IsEncode() === true )
		{
			$buf = $this->_phone($this->requestObject, $default);
			if( is_string($buf) )
				return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
			else
				return $buf;
		}
		else
			return $this->_phone($this->requestObject, $default);
	}

	private function _phone($value, $default) {
		$value = trim($value);
		if ( Data::Is_Phone($value) )
			return $value;

		return $default;
	}

	public function Url($default = false, $encode = true) {
    	if( App::IsEncode() === true )
		{
			$buf = $this->_url($this->requestObject, $default, $encode);
			return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
		}
		else
			return $this->_url($this->requestObject, $default, $encode);
	}

	public function Datestamp($default = false, $format = null) {
    	if( App::IsEncode() === true )
		{
			$buf = $this->_datestamp($this->requestObject, $default, $format);
			if( is_string($buf) )
				return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
			else
				return $buf;
		}
		else
			return $this->_datestamp($this->requestObject, $default, $format);
	}

	private function _datestamp($value, $default, $format) {
		$value = trim($value);
		if ( ($value = strtotime($value)) === false )
			return $default;

		if ($format === null)
			return $value;

		return date($format, $value);
	}

	private function _url($value, $default, $encode) {

		$value = urldecode($value);

		$value = strip_tags($value);
		$trans_tbl = array(
			    'Ў' => '&iexcl;',
			    'ў' => '&cent;',
			    'Ј' => '&pound;',
			    '¤' => '&curren;',
			    'Ґ' => '&yen;',

			    '¦' => '&brvbar;',
			    '§' => '&sect;',
			    'Ё' => '&uml;',
			    '©' => '&copy;',
			    'Є' => '&ordf;',
			    '«' => '&laquo;',

			    '¬' => '&not;',
			    '­' => '&shy;',
			    '®' => '&reg;',
			    'Ї' => '&macr;',
			    '°' => '&deg;',
			    '±' => '&plusmn;',

			    'І' => '&sup2;',
			    'і' => '&sup3;',
			    'ґ' => '&acute;',
			    'µ' => '&micro;',
			    '¶' => '&para;',
			    '·' => '&middot;',

			    'ё' => '&cedil;',
			    '№' => '&sup1;',
			    'є' => '&ordm;',
			    '»' => '&raquo;',
			    'ј' => '&frac14;',
			    'Ѕ' => '&frac12;',

			    'ѕ' => '&frac34;',
			    'ї' => '&iquest;',

			    '"' => '&quot;',
			    '\'' => '&#39;',
			    '<' => '&lt;',
			    '>' => '&gt;',

		);


		//get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
		unset($trans_tbl['&']);

		$value = strtr($value, $trans_tbl);

	    if(get_magic_quotes_gpc ()) {
	        $value = stripslashes ($value);
	    }
	    $value = addcslashes($value, "\n\r\\");

	    if ( $encode )
			$value = urlencode($value);

		if ( strlen($value) > 0)
			return $value;

		return $default;
	}

	public function Bool($default = false)
	{
		if($this->requestObject)
			return true;
		else
			return false;
	}

	public function Enum($default = null, $set = null, $flags = null)
	{
		if(!is_array($set))
			return $default;

		if ($flags & Request::INTEGER_NUM)
			$v = $this->_int($this->requestObject, $flags, $default);
		elseif ($flags & Request::DECIMAL_NUM)
			$v = $this->_dec($this->requestObject, $flags, $default);
		elseif ($flags & Request::ALPHA)
			$v = $this->_alpha($this->requestObject, $default);
		elseif ($flags & Request::ALPHA_NUM)
			$v = $this->_alnum($this->requestObject, $default);
		elseif ($flags & Request::EMAIL)
			$v = $this->_email($this->requestObject, $default);
		elseif ($flags & Request::URL)
			$v = $this->_url($this->requestObject, $default);
		else
			$v = $this->_value($this->requestObject, $flags);

		if( App::IsEncode() === true && is_string($v) )
			$v = iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $v);

		if(in_array($v, $set)) {
	    	/*if( App::IsEncode() === true )
			{
				$buf = $this->requestObject;
				return iconv(App::GetExternalEncoding(), App::GetInternalEncoding(), $buf);
			}
			else*/
				return $v;
		}
		else
			return $default;
	}

	public function AsArray($default = null, $flags = null) {
		if ( $flags === null )
			return $this->Value();

	   	return $this->_asarray($this->requestObject, $flags, $default);
	}

	private function _asarray($array, $flags, $default) {

		if ( is_array($array) ) {
			foreach( $array as &$v) {

				if ( is_array($v) ) {
					$v = $this->_AsArray($v, $flags, $default);
					continue;
				}

				if ($flags & Request::INTEGER_NUM)
					$v = $this->_int($v, $flags, 0);
				elseif ($flags & Request::DECIMAL_NUM)
					$v = $this->_dec($v, $flags, 0);
				elseif ($flags & Request::VALUE)
					$v = $this->_value($v, $flags);
				elseif ($flags & Request::ALPHA)
					$v = $this->_alpha($v, '');
				elseif ($flags & Request::ALPHA_NUM)
					$v = $this->_alnum($v, '');
				elseif ($flags & Request::EMAIL)
					$v = $this->_email($v, '');
				elseif ($flags & Request::URL)
					$v = $this->_url($v, '');
				else
					$v = $this->_value($v, $flags);
			}
			return $array;
		}

		return $default;
	}

	function Extract($name)
	{
		parse_str(urldecode($this->requestObject), $arr);
		return App::$Request->AddCustomTrait($name, $arr);
	}

	function GetUrl($keys, $use_keys = true, $numeric_prefix = '', $arg_separator = '&', $with_uri = false, $with_domain = false)
	{
		$url = '';

		if($with_domain)
		{
			$host = $_SERVER['HTTP_HOST'];
			if(strpos($host, 'www.') === 0)
				$host = substr($host, 4);
			if(strpos($host, 'dvp.') === 0)
				$host = substr($host, 4);
			$url.= 'http://'.$host;
		}

		if($with_uri)
		{
			$pos = strpos($_SERVER['REQUEST_URI'], '?');
			if($pos === false)
				$url.= $_SERVER['REQUEST_URI'];
			else
				$url.= substr($_SERVER['REQUEST_URI'], 0, $pos);
		}

		$keys = array_flip($keys);

		if($use_keys === true)
			$data = array_intersect_key($this->requestObject,$keys);
		else
			$data = array_diff_key($this->requestObject,$keys);

		$url.= '?'.http_build_query($data,$numeric_prefix,$arg_separator);
		return $url;
	}

    function offsetExists($offset)
    {
        return isset($this->requestObject[$offset]);
    }

    function offsetGet($offset)
    {
		if(isset($this->requestObject[$offset]))
			return new self($this->requestObject[$offset]);
		else
			return new RequestEmptyTrait();
    }

    function offsetSet($offset, $value)
    {
        $this->requestObject[$offset] = $value;
    }

    function offsetUnset($offset)
    {
        unset($this->requestObject[$offset]);
    }

    function __toString() {
    	if ( isset($this->requestObject) )
    		return (string) $this->requestObject;
    	return false;
    }
}

class RequestEmptyTrait Implements ArrayAccess
{
	function __call($name, $params)
	{
		$name = strtolower($name);
		if ( isset($params[0]) && $name != 'value' )
			return $params[0];
		return null;
	}

	public function Bool($defaul = false)
	{
		return $default;
	}

    function offsetExists($offset)
    {
        return false;
    }

    function offsetGet($offset)
    {
		return null;
    }

    function offsetSet($offset, $value)
    {
    }

    function offsetUnset($offset)
    {
    }
}

class Request
{
	const SIGNED_NUM 	= 0x00000002;
	const UNSIGNED_NUM 	= 0x00000004;
	const INTEGER_NUM 	= 0x00000008;
	const DECIMAL_NUM 	= 0x00000010;
	const ALPHA 		= 0x00000020;
	const ALPHA_NUM 	= 0x00000040;
	const EMAIL 		= 0x00000080;
	const URL 			= 0x00000100;
	const VALUE 		= 0x00008000;

	const OUT_HTML			= 0x00000200;
	const OUT_HTML_AREA		= 0x00000400;
	const OUT_HTML_CLEAN	= 0x00000800;
	const OUT_CHANGE_NL		= 0x00001000;
	const OUT_CHANGE_TAGS	= 0x00002000;
	const OUT_CHANGE_QUOTES	= 0x00004000;
	const OUT_REMOVE_NL		= 0x00008000;

	const M_POST		= 1;
	const M_GET			= 2;

	const D_POST		= 2;
	const D_GET			= 4;
	const D_FILES		= 8;

	private $postObject = null;
	private $getObject = null;
	private $cookieObject = null;
	private $serverObject = null;
	private $customObjects = array();
	private $customData = array();
	public $requestMethod = null;

	function __construct()
	{
		$this->requestMethod = $_SERVER['REQUEST_METHOD']=='POST' ? self::M_POST : self::M_GET;
	}

	/**
	 * Возвращает UID пользователя из _COOKIE!!!!
	 */
	static public function GetUID()
	{
		if ($_COOKIE['pscode'])
			return $_COOKIE['pscode'];

		$res = '';
		foreach($_COOKIE as $k=>$v)
			if(substr($k, 0, 4) == 'uid_')
			{
				$res = $v;
				break;
			}
		return $res;
	}

	/**
	 * Добавляет свой массив для обработки
	 * @param string обработчик
	 * @param array массив для обработки
	 */
	function AddCustomTrait($name, &$array)
	{
		if(is_string($name) && is_array($array))
		{
			$this->customObjects[$name] = null;
			$this->customData[$name] =& $array;
		}
		return null;
	}

	static function log($flags) {
		global $OBJECTS;

		LibFactory::GetStatic('filestore');

		list($usec, $sec) = explode(" ", microtime());

		$requestId = $sec.'_'.$usec;
		$requestId.= $_SERVER['UNIQUE_ID'];

		$root = LOG_PATH.'request/';
		$path = FileStore::GetPath_NEW($requestId,3,3);

		if (trim($path) == '')
			return ;

		if (!FileStore::CreateDir_NEW($root.$path))
			return ;

		$request = array(
			'UserID' => (int) $OBJECTS['user']->ID,
			'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
			'REQUEST_TIME' => $_SERVER['REQUEST_TIME'],
			'HTTP_HOST' => $_SERVER['HTTP_HOST'],
			'REDIRECT_URL' => $_SERVER['REDIRECT_URL'],
			'_GET' => array(),
			'_POST' => array(),
			'_FILES' => array(),
		);

		if ($flags & self::D_POST)
			$request['_POST'] = $_POST;

		if ($flags & self::D_GET)
			$request['_GET'] = $_GET;

		if ($flags & self::D_FILES) {
			$request['_FILES'] = $_FILES;
			if (is_array($request['_FILES']) && sizeof($request['_FILES'])) {
				foreach($request['_FILES'] as $k => $v) {

					if (is_string($v['name'])) {
						if (is_file($v['tmp_name']) && copy($v['tmp_name'], $root.$path.'/'.$v['name']))
							$v['tmp_name'] = $root.$path.'/'.$v['name'];
						else
							$v['tmp_name'] = null;

						$request['_FILES'][$k] = $v;
						continue ;
					}

					foreach($v as $k1 => $v1)
						$request['_FILES'][$k][$k1] = array($v1);

					foreach($request['_FILES'][$k] as $k1 => $v1) {
						foreach($v1 as $k2 => $v2) {

							if ($k1 != 'tmp_name')
								continue ;

							if (is_file($v['tmp_name']) && copy($v2, $root.$path.'/'.$v['name']))
								$v1[$k2] = $root.$path.'/'.$v1[$k2]['name'];
							else
								$v1[$k2] = null;
						}
						$request['_FILES'][$k][$k1] = $v1;
					}
				}
			}
		}

		file_put_contents($root.$path.'/request.php', "<?\nreturn ".var_export($request, true).";\n\n");
		file_put_contents($root.'/request.log', $request['REQUEST_TIME'].' '.$path.PHP_EOL, FILE_APPEND);
	}

	function &__get($name)
	{
		if(isset($this->customData[$name]) || isset($this->customObjects[$name]))
		{
			if($this->customObjects[$name] === null)
				$this->customObjects[$name] = new RequestTrait($this->customData[$name]);
			return $this->customObjects[$name];
		}
		switch($name)
		{
			case 'Cookie':
				if ( $this->cookieObject === null )
					$this->cookieObject = new RequestTrait($_COOKIE);

				return $this->cookieObject;
			case 'Get':
				if ( $this->getObject === null )
					$this->getObject = new RequestTrait($_GET);

				return $this->getObject;
			case 'Post':
				if ( $this->postObject === null )
					$this->postObject = new RequestTrait($_POST);

				return $this->postObject;
			case 'Request':
				if($this->requestMethod == self::M_POST)
				{
					if ( $this->postObject === null )
						$this->postObject = new RequestTrait($_POST);

					return $this->postObject;
				}
				else
				{
					if ( $this->getObject === null )
						$this->getObject = new RequestTrait($_GET);

					return $this->getObject;
				}
			case 'Server':
				if ( $this->serverObject === null )
					$this->serverObject = new RequestTrait($_SERVER);

				return $this->serverObject;
			default:
				return null;
		}
	}
}
