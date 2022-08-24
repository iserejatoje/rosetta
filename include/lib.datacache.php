<?

class Lib_Datacache
{
	static $Name = 'datacache';
	private $cachename   = "";
	public $data         = null;
	
	function __construct()
	{
	}
	
	function __destruct()
	{
	}
	
	function Init()
	{
		global $CONFIG, $LCONFIG;
		
		LibFactory::GetConfig(self::$Name);
		$this->_config = $LCONFIG[self::$Name];
	}
	
	function Start($name = null, $dir = null)
	{
		if($name !== null)
			$this->cachename = $name;
		if($dir !== null)
			$this->_config['cache_dir'] = $dir;
	}
	
	public function iscache()
	{
		$args = array();
		if(func_num_args() > 0)
			$args = func_get_args();
		else
			return false;
		$file = $this->_config['cache_dir'] . $this->cachename . (count($args)>0?"_".implode("_", $args):"");
//error_log('MOD_MAIL: datacache->iscache('.$file.')');
		return $this->__iscache($file);
	}
	
	public function load()
	{
		$args = array();
		if(func_num_args() > 0)
			$args = func_get_args();
		else
			return null;
		$file = $this->_config['cache_dir'] . $this->cachename . (count($args)>0?"_".implode("_", $args):"");
//error_log('MOD_MAIL: datacache->load('.$file.')');
		return $this->__load($file);
	}
	
	public function save()
	{
		$args = array();
		if(func_num_args() > 1)
			$args = func_get_args();
		else
			return null;
		$value = array_shift($args);
		$file = $this->_config['cache_dir'] . $this->cachename . (count($args)>0?"_".implode("_", $args):"");
//error_log('MOD_MAIL: datacache->save('.$file.')');
		return $this->__save($file, $value);
	}
	
	public function delete()
	{
		$args = array();
		if(func_num_args() > 1)
			$args = func_get_args();
		else
			return null;
		$file = $this->_config['cache_dir'] . $this->cachename . (count($args)>0?"_".implode("_", $args):"");
		return $this->__delete($file);
	}
	
	public function clear()
	{
		$args = array();
		if(func_num_args() > 0)
			$args = func_get_args();
		$suffix = $this->cachename . (count($args)>0?"_".implode("_", $args):"");
		return $this->__clear($suffix);
	}
	
	private function __iscache($file = null, $cache = true)
	{
		if($file === null)
			return false;
		if(isset($this->data[$file]) && $cache === true)
			return true;
		if(is_file($file))
			return true;
		return false;
	}

	private function __load($file = null, $cache = true)
	{
		if($file === null)
			return null;
		if(isset($this->data[$file]) && $cache === true)
			return $this->data[$file];
		if(is_file($file))
			if( ($content = @file_get_contents($file)) !== false )
				return unserialize($content);
		return null;
	}

	private function __save($file = null, $value = null)
	{
		if($file === null)
			return false;
		$this->data[$file] = $value;
		return @file_put_contents($file, serialize($value));
	}
	
	private function __delete($file = null)
	{
		if($file === null)
			return false;
		if(is_file($file))
			@unlink($file);
	}
	
	private function __clear($suffix = "")
	{
		if(!is_dir($this->_config['cache_dir']))
			return true;
		$dir = new DirectoryIterator($this->_config['cache_dir']);
		for($dir->rewind(); $dir->valid(); $dir->next()) 
		{
			if($dir->isDot())
				continue;
			if(!$dir->isWritable() && !$dir->isReadable())
				continue;

			if(preg_match("@^".$suffix."@", $dir->getFilename()))
				$this->__delete($dir->getPathname());
		}
		$this->data = null;
		return true;
	}
	
}

?>