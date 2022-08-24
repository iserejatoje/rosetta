<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/diaries/diaryrecord.php');
require_once ($CONFIG['engine_path'].'configure/lib/diaries/error.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 14:54 16 ноября 2009 г.
 */
class DiaryRecordsMgr
{

	public $_db			= null;
	public $_tables	= array(
		'diaries'	=> 'users_diaries',
		'records'	=> 'users_diaries_records',
		'tags'	=> 'users_diaries_tags',
		'tags_ref'	=> 'users_diaries_tags_ref',
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
	
	/**
	 * 
	 * @param filter
	 */
	public function GetRecords( array $filter, $as_array = false)
	{			
		$filter = array_change_key_case($filter, CASE_LOWER);
	
		$where = array();
		
		if(isset($filter['diaryid']))
			$where[] = "rec.DiaryID=".$filter['diaryid'];
		
		if(isset($filter['isvisible']) && ($filter['isvisible'] == 0 || $filter['isvisible'] == 1))
			$where[] = "rec.IsVisible=".$filter['isvisible'];
			
		if( isset($filter['complaintcount_gt']) )
			$where[] = "rec.ComplaintCount > ".$filter['complaintcount_gt'];
		elseif( is_array($filter['complaintcount']) )
			$where[] = "rec.ComplaintCount IN (".implode(",",$filter['complaintcount']).")";
		else
			$where[] = "rec.ComplaintCount IN ( 0, 1 )";
			
		if(isset($filter['rights']) && is_array($filter['rights']) && count($filter['rights']) > 0)					
			$where[] = " rec.PublicState IN(".implode(',', $filter['rights']).")";						
			
		if(isset($filter['recordid']))
			$where[] = "rec.RecordID=".$filter['recordid'];
		
		if(isset($filter['created']))
			$where[] = "rec.Created='".$filter['created']."'";
			
		if(isset($filter['startdate']))
			$where[] = "rec.Created >= '".$filter['startdate']."'";
			
		if(isset($filter['enddate']))
			$where[] = "rec.Created <= '".$filter['enddate']."'";		
			
		if(isset($filter['title']))
			$where[] = "rec.Title LIKE '".$filter['title']."'";		
			
		if(isset($filter['ismain']))
			$where[] = "rec.IsMain = ".($filter['ismain'] > 0 ? 1 : 0);
			
		if(isset($filter['isallowcomments']) && ($filter['isallowcomments'] == 0 || $filter['isallowcomments'] == 1))
			$where[] = "rec.IsAllowComments=".$filter['isallowcomments'];
			
		if(isset($filter['isconverted']) && ($filter['isconverted'] == 0 || $filter['isconverted'] == 1))
			$where[] = "rec.IsConverted=".$filter['isconverted'];
		
		$sql = "SELECT rec.*";
				
		$sql.=" FROM ".$this->_tables['records']." rec";
		
		
		if(isset($filter['regionid'])){
				
			$where[] = "rec.RegionID=".$filter['regionid'];
		}
		
		if(isset($filter['userid'])){
			
			$where[] = "rec.UserID=".$filter['userid'];
		}
		
		if(isset($filter['ismain']))
			$where[] = "rec.IsMain='".($filter['ismain'] > 0 ? 1 : 0)."'";
		
		if ( is_array( $filter['tags'] ) ){
			$sql.= ", ".$this->_tables['tags_ref']." ref";
			$sql.= ", ".$this->_tables['tags']." tags";
			$where[] = "rec.DiaryID=ref.DiaryID";
			$where[] = "rec.RecordID=ref.RecordID";
			$where[] = "tags.TagID=ref.TagID";
			
			foreach($filter['tags'] as $tag){
				$where[] = "tags.Name='".addslashes(strtolower($tag))."'";
			}
		}
		
		$sql.= " WHERE ".implode(" AND ", $where);
						
		$sql.= " ORDER BY ";

		if ( is_array( $filter['field'] ) ){
			
			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' rec.'.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);
		} else {
		
			$sql.= " rec.`Created` DESC";
		}
		
		if( isset($filter['limit']) )
		{
			$sql.= " LIMIT ";
			
			if ( isset($filter['offset']) )
				$sql.= $filter['offset'].",";
				
			$sql.= $filter['limit'];
        }
		
		//error_log($sql);
		
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
				$data[] = new DiaryRecord($row);
			
			return $data;
		}	
	}
	
	public function GetCountRecords( array $filter )
	{			
		$filter = array_change_key_case($filter, CASE_LOWER);
		
		$where = array();
		
		if(isset($filter['diaryid']))
			$where[] = "rec.DiaryID=".$filter['diaryid'];
		
		if(isset($filter['isvisible']) && ($filter['isvisible'] == 0 || $filter['isvisible'] == 1))
			$where[] = "rec.IsVisible=".$filter['isvisible'];
			
		if( isset($filter['complaintcount_gt']) )
			$where[] = "rec.ComplaintCount > ".$filter['complaintcount_gt'];
		elseif( is_array($filter['complaintcount']) )
			$where[] = "rec.ComplaintCount IN (".implode(",",$filter['complaintcount']).")";
		else
			$where[] = "rec.ComplaintCount IN ( 0, 1 )";
			
		if(isset($filter['rights']) && is_array($filter['rights']) && count($filter['rights']) > 0)					
			$where[] = " rec.PublicState IN(".implode(',', $filter['rights']).")";	
			
		if(isset($filter['recordid']))
			$where[] = "rec.RecordID=".$filter['recordid'];
		
		if(isset($filter['created']))
			$where[] = "rec.Created='".$filter['created']."'";
			
		if(isset($filter['startdate']))
			$where[] = "rec.Created >= '".$filter['startdate']."'";
			
		if(isset($filter['enddate']))
			$where[] = "rec.Created <= '".$filter['enddate']."'";	
			
		if(isset($filter['isallowcomments']) && ($filter['isallowcomments'] == 0 || $filter['isallowcomments'] == 1))
			$where[] = "rec.IsAllowComments=".$filter['isallowcomments'];
			
		if(isset($filter['isconverted']) && ($filter['isconverted'] == 0 || $filter['isconverted'] == 1))
			$where[] = "rec.IsConverted=".$filter['isconverted'];
			
		if(isset($filter['title']))
			$where[] = "rec.Title LIKE '".$filter['title']."'";		
						
		$sql = "SELECT COUNT(*) FROM ".$this->_tables['records']." rec";
	
		if(isset($filter['regionid'])){
								
			$where[] = "rec.RegionID=".$filter['regionid'];
		}
		
		if(isset($filter['userid'])){
						
			$where[] = "rec.UserID=".$filter['userid'];
		}
		
		if(isset($filter['ismain']))
			$where[] = "rec.IsMain='".($filter['ismain'] > 0 ? 1 : 0)."'";
		
		if ( is_array( $filter['tags'] ) ){
			$sql.= ", ".$this->_tables['tags_ref']." ref";
			$sql.= ", ".$this->_tables['tags']." tags";
			$where[] = "rec.DiaryID=ref.DiaryID";
			$where[] = "rec.RecordID=ref.RecordID";
			$where[] = "tags.TagID=ref.TagID";
			
			foreach($filter['tags'] as $tag){
				$where[] = "tags.Name='".addslashes(strtolower($tag))."'";
			}
		}
		
		$sql.= " WHERE ".implode(" AND ", $where);		
		
		if( isset($filter['limit']) )
		{
			$sql.= " LIMIT ";
			
			if ( isset($filter['offset']) )
				$sql.= $filter['offset'].",";
				
			$sql.= $filter['limit'];
        }
		
		//trace::Log($sql);
		$res = $this->_db->query($sql);
		
		if ( $row = $res->fetch_row() )
			return $row[0];
		
		return false;
	}
	
	
	/**
	 * Получить записи пользователей, отмеченных флагом IsMain ("Блогеры")
	 *
	 * @param array filter - ассив параметров (
	 *								limit - кол-во записей, 
	 *								regionid - регион)
	 * @param bool as_array - если true, вернуть результат как массив
	 * @return array - массив объектов DiaryRecord или просто массив (as_array), или false в случае ошибки
	 */
	public function GetMainRecords($filter, $as_array = false)
	{
		$filter = array_change_key_case($filter, CASE_LOWER);
		
		if (!isset($filter['regionid']) || !Data::Is_Number($filter['regionid']))
			return false;
		
		if (!isset($filter['limit']) || !Data::Is_Number($filter['limit']))
			$filter['limit'] = 6;
	
		$sql = "SELECT LastRecordID FROM ".$this->_tables['diaries'];
		$sql.= " WHERE IsMain=1 AND RegionID=".$filter['regionid'];
		$sql.= " ORDER BY LastRecordDate DESC";
		$sql.= " LIMIT ".$filter['limit'];
		
		$res = $this->_db->query($sql);
		
		$records = array();
		while($row = $res->fetch_assoc())
			$records[$row['LastRecordID']] = $row['LastRecordID'];
		
		if (count($records) == 0)
			return false;
		
		$sql = "SELECT * FROM ".$this->_tables['records'];
		$sql.= " WHERE RecordID IN (".implode(',', $records).")";

		$res = $this->_db->query($sql);
		
		if ( $as_array )
		{
			while($row = $res->fetch_assoc())
				$records[$row['RecordID']] = $row;
		} 
		else 
		{
			while($row = $res->fetch_assoc())
				$records[$row['RecordID']] = new DiaryRecord($row);
		}
		
		
		return $records;
		
	}
	
	public function Dispose() {
		
	}
}
