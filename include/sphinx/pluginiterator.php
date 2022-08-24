<?

class PSphinxPluginIterator implements Countable, Iterator
{
	private $_plugins = array();

	public function __construct(array $plugins)
	{
		$this->_plugins = $plugins;
	}
	
	// Iterator
	public function current ()
	{
		if ($this->valid())
			return Sphinx::GetPlugin(current($this->_plugins));

		return null;
	}
	
	public function key () 
	{
		return key($this->_plugins);
	}
	
	public function next () 
	{
		return next($this->_plugins);
	}
	
	public function rewind () 
	{
		return reset($this->_plugins);
	}
	
	public function valid () 
	{
		return current($this->_plugins) !== false;
	}
	
	// Countable
	public function count()
	{
		return sizeof($this->_plugins);
	}
}

?>