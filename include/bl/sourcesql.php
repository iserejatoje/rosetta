<?
abstract class Source_SourceSQL implements Source_ISourceCountable, Source_ISourceCustom, Source_ISourceData, 
	Source_ISourceFilterable, Source_ISourceIterator, Source_ISourceLimitable,
	Source_ISourceSortable
{
	private $data			= null;
	private $parent			= 0;
	private $count 			= null;
	
	private $field			= null;
	private $order			= null;
	
	private $start			= null;
	private $limit			= null;
	
	abstract public function getcountdb();
	abstract public function getcountsql();
	abstract public function getdatadb();
	abstract public function getdatasql();
	
	public function fill()
	{
		if($this->data === null)
		{
			$db = DBFactory::GetInstance($this->getdatadb());
			
			$res = $db->query($this->getdatasql());
			while($row = $res->fetch_assoc())
				$this->data[] = $row;
		}
		
		return $this->data;
	}
	
	public function count()
	{	
		if($this->count === null)
		{
			$db = DBFactory::GetInstance($this->getcountdb());
			
			$res = $db->query($this->getcountsql());
			if($row = $res->fetch_row())
				$this->count = $row[0];
			else
				$this->count = 0;
		}
		
		return $this->count;
	}
	
	private function resetcache()
	{
		$this->count = null;
		$this->data = null;
	}
	
	public function current()
	{
		if(!isset($this->data))
			$this->fill();
			
		if(!isset($this->data))
			return null;

        return current($this->data);
	}

	public function key()
	{
		if(!isset($this->data))
			$this->fill();
			
		if(isset($this->data))
			return key($this->data);
		return null;
	}

	public function next ()
	{
		if(!isset($this->data))
			$this->fill();
			
		if(isset($this->data))
			return next($this->data) !== false;
		return null;
	}

	public function rewind ()
	{
		if(!isset($this->data))
			$this->fill();
			
		if(isset($this->data))
			return reset($this->data);
		return null;
	}

	public function valid ()
	{
		if(!isset($this->data))
			$this->fill();
			
		if(isset($this->data))
			return current($this->data) !== false;
		return null;
	}
	
	public function setsort($field, $order)
	{
		if(is_string($field) && is_string($order))
		{
			$this->resetcache();
			
			$this->field = $field;
			$this->order = $order;
		}
	}
	
	public function setlimit($start, $count)
	{
		if(is_numeric($start) && is_numeric($count))
		{
			$this->resetcache();
		
			$this->start = $start;
			$this->limit = $count;
		}
	}	
	
	public function setfilter($field, $rule, $mask)
	{
	}
	
	public function setparam($param, $value)
	{
		$param = strtolower($param);
		switch($param)
		{
		case 'parent':
			if(is_numeric($value))
			{
				$this->resetcache();
				$this->parent = $value;
			}
			break;
		}
	}
}
?>