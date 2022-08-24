<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/place/placeextralocation.php');
require_once ($CONFIG['engine_path'].'configure/lib/place/error.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 16:43 23 октября 2009 г.
 */
class PlaceExtraLocationMgr
{
	/**
	 * Кэш мест
	 */
	public $_ext_locations = array();

	public $_db			= null;
	public $_tables		= array(
		'extra_location'	=> 'place_extra_location',
	);

	public function __construct()
	{
		LibFactory::GetStatic('data');

		$this->_db = DBFactory::GetInstance('places');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);
	}

	static function &getInstance () {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }

	/**
	 * получить список адресов
	 *
	 * @param placeid    идентификатор места
	 */
	public function GetExtraLocations( $placeid , $use_master = false ){
		
		if ( !Data::Is_Number($placeid) )
			return false;
			
		if ( isset( $this->_ext_locations[$placeid]) )
			return $this->_ext_locations[$placeid];
		
		$sql = "SELECT * FROM ".$this->_tables['extra_location'];
		$sql.= " WHERE `PlaceID`=".$placeid;
		
		if ($use_master)
			$res = $this->_db->query($sql);
		else
			$res = $this->_db->query($sql);
		
		$locations = array();
		while ( $row = $res->fetch_assoc() )
				$locations[$row['LocID']] = new PlaceExtraLocation($row);		
		
		$this->_ext_locations[$placeid] = $locations;
		
		return $this->_ext_locations[$placeid];		
	}
	
	/**
	 * получить адрес
	 *
	 * @param id    идентификатор адреса
	 */
	public function GetExtraLocation( $id ){
		
		if ( !Data::Is_Number($id) )
			return false;
				
		$sql = "SELECT * FROM ".$this->_tables['extra_location'];
		$sql.= " WHERE `LocID`=".$id;
		
		$res = $this->_db->query($sql);
				
		if ( $row = $res->fetch_assoc() )
				return new PlaceExtraLocation($row);		
			
		return false;		
	}

	/**
	 * добавить адрес
	 *
	 * @param info    информация об адресе
	 * @param placeid    ID места
	 */
	public function Add(array $info, $placeid)
	{
		unset($info['LocID']);
		if ( !sizeof($info) )
			return false;

		$info['PlaceID'] = $placeid;
		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['extra_location'].' SET ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	 * удалить адрес
	 *
	 * @param id    идентификатор
	 */
	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$loc = $this->GetExtraLocation($id);
		
		unset($this->_ext_locations[$loc->$PlaceID]);
					
		$sql = 'DELETE FROM '.$this->_tables['extra_location'].' WHERE LocID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{			
			return true;
		}

		return false;
	}
	
	/**
	 * удалить все адреса для места
	 *
	 * @param placeid    идентификатор места
	 */
	public function RemoveAllForPlace($placeid)
	{
		if ( !Data::Is_Number($placeid) )
			return false;

		$sql = 'DELETE FROM '.$this->_tables['extra_location'].' WHERE `PlaceID` = '.$placeid;
		if ( false !== $this->_db->query($sql) )
		{
			unset($this->_ext_locations[$placeid]);
			return true;
		}

		return false;
	}

	/**
	 * обновить информацию об адресе
	 *
	 * @param info    информация об адресе
	 */
	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['LocID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE '.$this->_tables['extra_location'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE LocID = '.$info['LocID'];

		if ( false !== $this->_db->query($sql) )
			return true;

		return false;
	}

	public function Dispose()
	{
		if(!empty($this->_ext_locations)) {
			foreach($this->_ext_locations as $k => $v) {
				$this->_ext_locations[$k] = null;
			}
		}

		$this->_ext_locations = null;
		$this->_ext_locations = array();
	}
}

?>
