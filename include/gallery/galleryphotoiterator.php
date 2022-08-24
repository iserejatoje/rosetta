<?php


/**
 * @author Данилин Дмитрий
 * @version 1.0
 * @created 27-авг-2008 14:07:35
 */
class GalleryPhotoIterator implements Countable, Iterator
{
	protected $_Mgr = null;
	private $_Parent = null;
	protected $data = array();
	protected $total = 0;
	protected $objects = array();

	/**
	 * 
	 * @param filter
	 */
	public function __construct($filter = null, $parent = null, $mgr = null)
	{
		global $OBJECTS;
		if($filter === null || $parent === null || $mgr === null)
			throw new exception("Can't create GalleryPhotoIterator object directly");

		$this->_Mgr = $mgr;
		$this->_Parent = $parent;

		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".$this->_Mgr->Tables['photos'];
		$sql.= " WHERE 1=1 ";
		if(isset($filter['albumid']))
			$sql.= " AND AlbumID=".$filter['albumid'];
			
		if(isset($filter['isnew']) && ($filter['isnew'] == 0 || $filter['isnew'] == 1))
			$sql.= " AND IsNew=".$filter['isnew'];
			
		if(isset($filter['rights']) && is_array($filter['rights']) && count($filter['rights']) > 0)
		{
			$sql.= " AND (IsVisible IN(".implode(',', $filter['rights']).")";
			$sql.= " OR UserID=".$OBJECTS['user']->ID.")";
		} else if (isset($filter['isvisible']) && ($filter['isvisible'] == 0 || $filter['isvisible'] == 1))
			$sql.= " AND IsVisible=".$filter['isvisible'];
		
		if (isset($filter['skip'])) {
			$sql.= " AND PhotoID ! = ".(int) $filter['skip'];
		}
		
		//if(isset($filter['isvisible']) && ($filter['isvisible'] == 0 || $filter['isvisible'] == 1))
		//	$sql.= " AND IsVisible=".$filter['isvisible'];

		if (isset($filter['rand']) && $filter['rand'] === true)
			$sql.= " ORDER by RAND() ";
		else {
			if (isset($filter['next'])) {
				$photo = $parent->GetPhoto((int) $filter['next']);
				
				$sql.= " AND PhotoID != ".(int) $filter['next'];
				$sql.= " AND `Order` >= '".$photo->Order."'";
				$sql.= " ORDER by `Order` ASC ";
			} else if (isset($filter['prev'])) {
				$photo = $parent->GetPhoto((int) $filter['prev']);
				
				$sql.= " AND PhotoID != ".(int) $filter['prev'];
				$sql.= " AND `Order` <= '".$photo->Order."'";
				$sql.= " ORDER by `Order` DESC ";
			} else if ($filter['dir'] == 'desc')
				$sql.= " ORDER by `Order` DESC, Created DESC ";
			else 
				$sql.= " ORDER by `Order` ASC, Created ASC ";
		}

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
            $this->objects[$k] = GalleryPhoto::CreateFromArray($this->data[$k], $this->_Parent, $this->_Mgr);
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