<?

class PUsersIterator implements Countable, Iterator
{
	private $ids = null;
	
	public function __construct($ids)
	{
		if(is_array($ids))
			$this->ids = $ids;
	}
	
	// Iterator
	private $position = null;
	public function current ()
	{
		global $OBJECTS;
		if($this->ids !== null)
		{
			return $OBJECTS['usersMgr']->GetUser(current($this->ids));
		}
		return null;	
	}
	
	public function key () 
	{
		if($this->ids !== null)
			return key($this->ids);
		return null;	
	}
	
	public function next () 
	{
		if($this->ids !== null)
			return next($this->ids) !== false;
		return null;	
	}
	
	public function rewind () 
	{
		if($this->ids !== null)
			return reset($this->ids);
		return null;
	}
	
	public function valid () 
	{
		if($this->ids !== null)
			return current($this->ids) !== false;
		return null;	
	}
	
	// Countable
	public function count()
	{
		if($this->ids === null)
			return 0;
		return sizeof($this->ids);
	}
}

?>