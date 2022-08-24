<?

class Lib_Session Implements ArrayAccess
{
	static $Name = 'session';
	public $id           = null;
	public $sname        = null;
	public $lifetime     = null;
	public $restart_time = null;
	public $data         = null;
	private $service     = null;
	private $ended       = false;
	
	function __construct()
	{
	}
	
	function __destruct()
	{
		if(!$this->ended)
		{
			$this->service['last_read'] = time();
			$this->__WriteSession();
		}
	}
	
	function Init()
	{
		global $CONFIG, $LCONFIG;
		
		LibFactory::GetConfig(self::$Name);
		$this->_config = $LCONFIG[self::$Name];
		if(isset($this->_config['session_name']))
			$this->sname = $this->_config['session_name'];
		if(isset($this->_config['lifetime']))
			$this->lifetime = $this->_config['lifetime'];
		if(isset($this->_config['restart_time']))
			$this->restart_time = $this->_config['restart_time'];
		// Clear session dir, if havn't CRON
		if( $this->_config['realtimeclear'] )
			$this->__ClearSessionDir();
echo "<textarea style='width:100%;height:500px;'>"; print_r($this->_config); echo "</textarea>";
	}
	
	public function Start($id = null, $name = null, $lifetime = null, $restart_time = null)
	{
		// NAME
		if($name !== null)
			$this->sname = $name;
		// ID
		if(isset($_COOKIE[$this->sname]))
			$this->id = $_COOKIE[$this->sname];
		if($id !== null)
			$this->id = $id;
		// TIME
		if($lifetime !== null)
			$this->lifetime = $lifetime;
		// TIME
		if($time !== null)
			$this->restart_time = $restart_time;

		if( !$this->__ReadSession() || $this->id === null )
			$this->__generate_id();
		
		if( ($this->service['restart'] + $this->restart_time) < time() )
			$this->__ReStartSession();
	}
	
	public function End()
	{
		$this->ended = true;
		$this->__DeleteSession();
		$this->__set_cookie("");
	}
	
	private function __ReStartSession()
	{
		$this->__DeleteSession();
		$this->__generate_id();
	}
	
	private function __ReadSession($file = null)
	{
		if($file === null)
			$file = $this->_config['session_dir'].$this->sname."_".$this->id;
		if(is_file($file))
			if( ($content = @file_get_contents($file)) !== false )
			{
				$arr = unserialize($content);
				$this->data = isset($arr['data'])?$arr['data']:null;
				$this->service = isset($arr['service'])?$arr['service']:null;
				return true;
			}
		return false;
	}

	private function __WriteSession($file = null)
	{
		if($file === null)
			$file = $this->_config['session_dir'].$this->sname."_".$this->id;
		$arr = array(
			'service' => $this->service,
			'data' => $this->data
		);
		file_put_contents($file, serialize($arr));
	}
	
	private function __DeleteSession($file = null)
	{
		if($file === null)
			$file = $this->_config['session_dir'].$this->sname."_".$this->id;
		if(is_file($file))
			@unlink($file);
	}
	
	private function __ClearSessionDir()
	{
		$dir = new DirectoryIterator($this->_config['session_dir']);
		for($dir->rewind(); $dir->valid(); $dir->next()) 
		{
			if($dir->isDot())
				continue;
			if(!$dir->isWritable() && !$dir->isReadable())
				continue;

			if( $this->__ReadSession($dir->getPathname()) )
				if( ($this->service['created'] + $this->service['lifetime']) < time() )
					$this->__DeleteSession($dir->getPathname());
		}
		$this->service = null;
		$this->data = null;
	}
	
	private function __generate_id()
	{
		$this->id = md5(uniqid(rand(), true));

		$this->__set_cookie();
		
		if(!isset($this->service['created']))
			$this->service['created'] = time();
		$this->service['restart'] = time();
		$this->service['lifetime'] = $this->lifetime;
	}

	public function set_lifetime($lifetime)
	{
		if(!Data::Is_Number($lifetime))
			return false;
		$this->lifetime = $lifetime;

		$this->__set_cookie();
		
		if(!isset($this->service['created']))
			$this->service['created'] = time();
		$this->service['restart'] = time();
		$this->service['lifetime'] = $this->lifetime;
	}
	
	private function __set_cookie($value = null)
	{
//		if(preg_match("@^http\:\/\/(.+?)$@", $CFG["web"], $rg))
//			$domain = ".".$rg[1];
//		else
			$domain = null;
		if($value === null)
			$value = $this->id;

		//set domain 
		if(0 === strpos($_SERVER['SERVER_NAME'], 'm.'))
		{
			$deskDomain = substr($_SERVER['SERVER_NAME'], 2);
			$mobileDomain = $_SERVER['SERVER_NAME'];
		}
		else
		{
			$deskDomain = $_SERVER['SERVER_NAME'];
			$mobileDomain = 'm.'.$_SERVER['SERVER_NAME'];
		}

		setcookie($this->sname, $value, time() + $this->lifetime, "/", $deskDomain);
		setcookie($this->sname, $value, time() + $this->lifetime, "/", $mobileDomain);
	}



	
	// {{{ Implements ArrayAccess
	function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}
	function offsetGet($offset)
	{
		if(isset($this->data[$offset]))
			return $this->data[$offset];
		else
			return null;
	}
	function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}
	function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}
	// }}}

}

?>