<?
define('CLOG_STANDART', 0);
define('CLOG_MAIL', 1);
define('CLOG_HOST', 2);
define('CLOG_FILE', 3);

define('CLOG_FREE', 0);
define('CLOG_DEBUG', 1);
define('CLOG_WARNING', 2);
define('CLOG_ERROR', 3);
define('CLOG_SECURITY', 4);

class lib_log
{
	private $_path;
	private $_type;
	private $_headers;
	
	function __construct()
	{
	}
	
	public function Init($type = 'standart', $path = "", $info = null)
	{
		switch($type)
		{
		case 'standart':
			$this->_type = CLOG_STANDART;
			break;
		case 'mail':
			$this->_type = CLOG_MAIL;
			break;
		case 'host':
			$this->_type = CLOG_HOST;
			break;
		case 'file':
			$this->_type = CLOG_FILE;
			break;
		}
		$this->_path = $path;
		if($info == null)	
			$info = "Log event";
		if($type == CLOG_MAIL)
			$this->_headers = "To: $path\nSubject:{$info}\nX-Mailer:System\nMIME-Version: 1.0\nContent-Type: text/plain; charset=windows-1251;\n";
		$this->GenFileName();
	}
	
	// генерация имени файла:
	// in: $prefix - префикс имени файла
	// ex: GetFileName("log/error_") установит имя "log/error_YYYY-MM-DD
	public function GenFileName($prefix = "", $post = "")
	{
		if($this->_type == CLOG_FILE)
		{
			$this->_path.= $prefix;
			$this->_path.= date("Y-m-d");
			$this->_path.= $post;
			return true;
		}
		return false;
	}
	
	public function Debug($format)
	{
		$args = func_get_args();
		array_shift($args);
		$this->__Log(CLOG_DEBUG, $format, $args);
	}
	
	public function Error($format)
	{
		$args = func_get_args();
		array_shift($args);
		$this->__Log(CLOG_ERROR, $format, $args);
	}
	
	public function Warning($format)
	{
		$args = func_get_args();
		array_shift($args);
		$this->__Log(CLOG_WARNING, $format, $args);
	}
	
	public function Log($format)
	{
		$args = func_get_args();
		array_shift($args);
		$this->__Log(CLOG_FREE, $format, $args);
	}
	
	public function Security($format)
	{
		$args = func_get_args();
		array_shift($args);
		array_push($args, "IP: ".getenv("REMOTE_ADDR"));
		array_push($args, "IPFW: ".getenv("HTTP_X_FORWARDED_FOR"));
		array_push($args, "cook: ".getenv("HTTP_COOKIE"));
		$this->__Log(CLOG_SECURITY, $format, $args);
	}
	
	private function __Log($type, $format = null, $args)
	{
		$str = date("Y-m-d H:i:s ");
		if($format === null)
			$format = $this->GetTemplateString(count($args));
		switch($type)
		{
		case CLOG_DEBUG:
			$str.= "Debug\t";
			break;
		case CLOG_WARNING:
			$str.= "Warning\t";
			break;
		case CLOG_ERROR:
			$str.= "Error\t";
			break;
		case CLOG_SECURITY:
			$str.= "Security\t";
			break;
		}
		$str.= vsprintf($format, $args)."\n";
		error_log($str, $this->_type, $this->_path, $this->_headers);
	}

	private function GetTemplateString($count = 0, $del = "\t")
	{
		$str = '';
		if($count < 1)
			return $str;
		for($i=1;$i<=$count;$i++)
			$str .= ($i>1?$del:'').'%'.$i.'$s';
		return $str;
	}
}
?>