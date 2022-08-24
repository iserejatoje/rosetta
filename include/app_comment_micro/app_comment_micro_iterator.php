<?
require_once ($CONFIG['engine_path'].'include/app_comment_micro/app_comment_micro_weather.php');

class PCommentMicroIterator implements Iterator
{
	private $_list = null;	
	
	public function __construct($_list)
	{
		if(is_array($_list))
			$this->_list = $_list;		
	}
	
	// Iterator
	private $position = null;
	public function current ()
	{
		global $OBJECTS;
		if($this->_list !== null)
		{
			return app_comment_micro_weather::GetComment(current($this->_list));
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
}

?>