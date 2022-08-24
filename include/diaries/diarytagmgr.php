<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/diaries/diarytag.php');
require_once ($CONFIG['engine_path'].'configure/lib/diaries/error.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 14:54 16 ноября 2009 г.
 */
class DiaryTagMgr
{

	public $_db			= null;
	public $_tables	= array(
		'diaries'		=> 'users_diaries',
		'records'		=> 'users_diaries_records',
		'tags'			=>' users_diaries_tags',
		'tags_ref'		=> 'users_diaries_tags_ref',
	);

	
	public function __construct($caching = true)	{
	
		LibFactory::GetStatic('data');		

		$this->_db = DBFactory::GetInstance('blogs');
		
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_DIARIES_CANT_CONNECT_TODB', ERR_L_DIARIES_CANT_CONNECT_TODB);
	}
	
	
	static function &getInstance () {
	
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }
	
		
	public function GetTag( $diaryid, $recordid = null, $as_array = false ){
	
		$where = array();
		if ( Data::Is_Number($diaryid) )			
			$where[] = "`DiaryID` = ".$diaryid;
		else
			return false;
			
		if ( Data::Is_Number($recordid) )			
			$where[] = "`RecordID` = ".$recordid;
		
		$sql = "SELECT * FROM ".$this->_tables['tags']." tags";
		$sql.= ", ".$this->_tables['tags_ref']." ref";
		$sql.= " WHERE tags.TagID = ref.TagID";
		$sql.= " AND ".implode(" AND ", $where);
	
		//trace::Log($sql);
	
		$res = $this->_db->query($sql);
		
		if ( $as_array ){
		
			if ($row = $res->fetch_assoc())
				return $row;			
		} else {
		
			if ($row = $res->fetch_assoc())
				return new DiaryTag($row);
		}
	
		return false;
	}
	
	public function LinkTag( $tagid, DiaryRecord $record ){
	//public function LinkTag( $tagid, $diaryid, $recordid, $regionid ){
	
		$where = array();
		if ( Data::Is_Number($tagid)  && isset($record) ){	
			$where[] = "`TagID` = ".$tagid;
			$where[] = "`DiaryID` = ".$record->DiaryID;
			$where[] = "`RecordID` = ".$record->ID;
			//$where[] = "`RegionID` = ".$regionid;
		}
		else
			return false;
				
		/*
		
		$sql = 'INSERT INTO '.$table;
		$sql.= ' (`fid`, `date`, `counts`)';
		$sql.= ' VALUES '.implode(',', $data);
		$sql.= ' ON DUPLICATE KEY UPDATE `Points` = `Points` + 1';
		$this->db->query($sql);
		
		*/
				
		$sql = "SELECT count(*) FROM ".$this->_tables['tags_ref'];		
		$sql.= " WHERE ".implode(" AND ", $where);
	
		//error_log($sql);
	
		$res = $this->_db->query($sql);
		//error_log(print_r($res, true));
		
		if ( ($row = $res->fetch_row() ) !== false){
		
		//error_log(print_r($row, true));
		
			if ( $row[0] > 0 )
				return true;
			
			$sql = "INSERT IGNORE INTO ".$this->_tables['tags_ref'];
			$sql.= " SET `TagID` = ".$tagid;
			$sql.= ", `DiaryID` = ".$record->DiaryID;
			$sql.= ", `RecordID` = ".$record->ID;
			$sql.= ", `RegionID` = ".$record->RegionID;
			$sql.= ", `opt_Created` = '".strftime("%G-%m-%d %H:%M:%S", $record->Created)."'";
			
			//error_log($sql);
			
			$this->_db->query($sql);			
			
			if ( false !== $this->_db->query($sql) )
			{
				$sql = "UPDATE ".$this->_tables['tags'];
				$sql.= " SET Points = Points + 1";
				$sql.= " WHERE TagID = ".$tagid;
			
				$this->_db->query($sql);
				return true;			
			}
		}	
		
		return false;
	}
	
	
	public function UpdateOptDate( DiaryRecord $record ){
	
		if ( !isset($record) )			
			return false;
			
		$sql = "UPDATE ".$this->_tables['tags_ref'];
		$sql.= " SET `opt_Created` = '".strftime("%G-%m-%d %H:%M:%S", $record->Created)."'";
		$sql.= " WHERE RecordID = ".$record->ID;
		$sql.= " AND DiaryID = ".$record->DiaryID;
		
		$this->_db->query($sql);
	}
	
	
	public function UnlinkTag( $tagid, $diaryid, $recordid ){
	
		$where = array();
		if ( Data::Is_Number($diaryid) 
			&& Data::Is_Number($recordid) 
			&& Data::Is_Number($tagid)
		){	
			$where[] = "`TagID` = ".$tagid;
			$where[] = "`DiaryID` = ".$diaryid;
			$where[] = "`RecordID` = ".$recordid;
		}
		else
			return false;
				
		$sql = "DELETE FROM ".$this->_tables['tags_ref'];		
		$sql.= " WHERE ".implode(" AND ", $where);
		
		//trace::Log($sql);
		
		if ( false !== $this->_db->query($sql) ){
		
			$sql = "UPDATE ".$this->_tables['tags'];
			$sql.= " SET Points = Points - 1";
			$sql.= " WHERE TagID = ".$tagid;
			
			$this->_db->query($sql);
			
			return true;				
		}
		
		return false;
	}
	
	
	public function UnlinkTags( $diaryid, $recordid ){
	
		$where = array();
		if ( Data::Is_Number($diaryid) 
			&& Data::Is_Number($recordid) 			
		){				
			$where[] = "`DiaryID` = ".$diaryid;
			$where[] = "`RecordID` = ".$recordid;
		}
		else
			return false;
		
		$filter = array();
		$filter['diaryid'] = $diaryid;
		$filter['recordid'] = $recordid;			
				
		$old = $this->GetTags( $filter , true);
		
		foreach ( $old as $tag ){
			$tag =$this->Create( $tag['Name'] );
			if ( !empty($tag) )
				$this->UnlinkTag( $tag->ID, $diaryid, $recordid );
			else
				return false;
		}			
		
		return true;
	}
		

	/**
	 * 
	 * @param filter
	 */
	public function GetTags( array $filter, $as_array = false ){
	
		$filter = array_change_key_case($filter, CASE_LOWER);
		
		$where = array();
		
		if(isset($filter['diaryid']))
			$where[] = "DiaryID=".$filter['diaryid'];
			
		if(isset($filter['recordid']))
			$where[] = "RecordID=".$filter['recordid'];	
			
		if(isset($filter['regionid']))
			$where[] = "`RegionID`=".$filter['regionid'];	
			
		if(is_array($filter['records_ids']))
			$where[] = "RecordID IN (".implode(",", $filter['records_ids']).")";
			
		$where[] = 'ref.TagID = tags.TagID';
						
		$sql = "SELECT DISTINCT(`Name`) FROM ".$this->_tables['tags']." tags";
		$sql.= ", ".$this->_tables['tags_ref']." ref";		
		$sql.= " WHERE ".implode(" AND ", $where);		
		
		$sql.= " ORDER BY ";
				
		if ( is_array( $filter['field'] ) ){
			
			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);
		} else {
		
			$sql.= " tags.`Points` DESC";
		}
		
		if( isset($filter['limit']) )
		{
			$sql.= " LIMIT ";
			
			if ( isset($filter['offset']) )
				$sql.= $filter['offset'].",";
				
			$sql.= $filter['limit'];
        }
		
		//trace::Log($sql);
		
		$res = $this->_db->query($sql);
		
		$data = array();
		
		if ( $as_array ){
		
			while($row = $res->fetch_assoc()){				
				$data[] = $row;
			}
			
			return $data;
		} else {
			
			while($row = $res->fetch_assoc())		
				$data[] = new DiaryTag($row);
			
			return $data;
		}	
	}
	
	public function Create( $name )	{
	
		$name = strtolower( trim( $name ) );
		
		if ( empty($name) )
			return false;
		
		$sql = "SELECT * FROM ".$this->_tables['tags'];
		$sql.= " WHERE `Name` ='".addslashes($name)."'";
		
		
		//trace::Log($sql);
		
		$res = $this->_db->query($sql);
		
		if ( $row = $res->fetch_assoc() ){
		
			return new DiaryTag( $row );
		} else {		
				
			$sql = "INSERT INTO ".$this->_tables['tags'];
			$sql.= " SET `Name` = '".addslashes($name)."'";
			
			//trace::Log($sql);
			
			if ( false !== $this->_db->query($sql) ){
				$row = array( 'Name' => $name, 'TagID' => $this->_db->insert_id );
				return new DiaryTag( $row );
			}
		
		} 	

		return false;
	}
	
	public function Dispose() {
		
	}
}
