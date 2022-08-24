<?
require_once ($CONFIG['engine_path'].'include/tree/nstreemgr.php');

class PNSTreeNodeIterator implements Countable, Iterator
{
	private $_mgr;
	private $ids = null;
	
	public function __construct($ids, NSTreeMgr $mgr)
	{
		$this->_mgr = $mgr;

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
			return $this->_mgr->getNode(current($this->ids));
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
	
	public function getData () 
	{
		return $this->ids;
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