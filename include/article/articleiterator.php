<?
require_once ($CONFIG['engine_path'].'include/article/articlemgr.php');

class ArticleIterator implements Countable, Iterator
{
	private $_list = null;
	private $_resultCount = 0;
	
	public function __construct($_list, $_resultCount = null)
	{
		if(is_array($_list) && sizeof($_list))
			$this->_list = $_list;
		$this->_resultCount = $_resultCount;
	}
	
	// Iterator
	private $position = null;
	public function current ()
	{
		global $OBJECTS;

		if($this->_list !== null)
		{
			return Article::CreateInstance(current($this->_list));
		}
		return null;	
	}
	
	public function key () 
	{
		if($this->_list !== null)
			return key($this->_list);
		return null;	
	}
	
	public function next () 
	{
		if($this->_list !== null)
			return next($this->_list) !== false;
		return null;	
	}
	
	public function rewind () 
	{
		if($this->_list !== null)
			return reset($this->_list);
		return null;
	}
	
	public function valid () 
	{
		if($this->_list !== null)
			return current($this->_list) !== false;
		return null;	
	}
	
	// Countable
	public function count()
	{
		if($this->_list === null)
			return 0;
		return sizeof($this->_list);
	}
	
	public function &__get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'resultcount':
				if ( $this->_resultCount === null )
					return $this->count();
				return $this->_resultCount;
			default:
				return null;
		}
	}
}

?>