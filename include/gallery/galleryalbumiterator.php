<?php


/**
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:36
 */
class GalleryAlbumIterator implements Countable, Iterator
{
	private $_Mgr;
	private $_Parent;
	private $_UniqueID;
	private $data;
	private $total = 0;
	private $objects;

	/**
	 * 
	 * @param filter
	 */
	public function __construct($filter = null, $parent = null, $mgr = null)
	{
		global $OBJECTS;
		if($filter === null || $parent === null || $mgr === null)
			throw new exception("Can't create GalleryAlbumIterator object directly");

		$this->_Mgr = $mgr;
		$this->_Parent = $parent;
		$this->_UniqueID = $parent->UniqueID;

		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".$this->_Mgr->Tables['albums'];
		$sql.= " WHERE UniqueID=".$this->_UniqueID." ";
		if(isset($filter['galleryid']))
			$sql.= " AND GalleryID=".$filter['galleryid'];
			
		if(isset($filter['isnew']) && ($filter['isnew'] == 0 || $filter['isnew'] == 1))
			$sql.= " AND IsNew=".$filter['isnew'];
		
		if(isset($filter['rights']) && is_array($filter['rights']) && count($filter['rights']) > 0)
		{
			$sql.= " AND (IsVisible IN(".implode(',', $filter['rights']).")";
			$sql.= " OR UserID=".$OBJECTS['user']->ID.")";
		}
		
		if (is_array($filter['order']) && sizeof($filter['order'])) {
			$sqlo = array();
			foreach( $filter['order'] as $k => $v )
				$sqlo[] = ' '.$k.' '.$v;
			
			$sql .= ' ORDER by '.implode(', ', $sqlo);
		}
		
		//if(isset($filter['isvisible']) && ($filter['isvisible'] == 0 || $filter['isvisible'] == 1))
		//	$sql.= " AND IsVisible=".$filter['isvisible'];

		if(isset($filter['limit']))
		{
			$sql.= " LIMIT ";
			if(isset($filter['offset']))
				$sql.= $filter['offset'].",";
			$sql.= $filter['limit'];
        }
		
		$res = $this->_Mgr->DB->query($sql);
		while($row = $res->fetch_assoc())
		{
			$this->data[] = $row;
        }
		
		$sql = "SELECT FOUND_ROWS()";
		list($this->total) =  $this->_Mgr->DB->query($sql)->fetch_row();
	}

	// Iterator
	public function current()
	{
		if($this->data === null)
			return null;
			
        $k = key($this->data);
        if(!isset($this->objects[$k]))
        {
            $this->objects[$k] = GalleryAlbum::CreateFromArray($this->data[$k], $this->_UniqueID, $this->_Parent, $this->_Mgr);
        }
        return $this->objects[$k];
	}
	
	public function key () 
	{
		if($this->data !== null)
			return key($this->data);
		return null;	
	}
	
	public function next () 
	{
		if($this->data !== null)
			return next($this->data) !== false;
		return null;	
	}
	
	public function rewind () 
	{
		if($this->data !== null)
			return reset($this->data);
		return null;
	}
	
	public function valid () 
	{
		if($this->data !== null)
			return current($this->data) !== false;
		return null;	
	}
	
	// Countable
	public function count()
	{
		if($this->data === null)
			return 0;
		return sizeof($this->data);
	}
	
	// FOUND ROWS
	public function TotalCount()
	{
		return $this->total;
	}
}
?>