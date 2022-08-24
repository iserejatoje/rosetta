<?php

require_once ($CONFIG['engine_path'].'include/diaries/diaryrecordsmgr.php');
require_once ($CONFIG['engine_path'].'include/diaries/diaryrecord.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 11:36 17 ноября 2009 г.
 */
class DiaryRecordIterator implements Countable, Iterator
{
	private $data;
	private $objects;

	/**
	 * 
	 * @param filter
	 */
	public function __construct( $filter = null )
	{
		global $OBJECTS;
		if( $filter === null )
			throw new exception("Can't create DiaryRecordIterator object directly");

		$this->data = DiaryRecordsMgr::getInstance()->GetRecords( $filter, true );		
	}

	// Iterator
	public function current()
	{			
		if($this->data === null)
			return null;
			
        $k = key($this->data);
		
        if(!isset($this->objects[$k]))
        {
            $this->objects[$k] = new DiaryRecord( $this->data[$k] );
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
}
?>