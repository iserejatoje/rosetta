<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/diaries/diarymgr.php');
require_once ($CONFIG['engine_path'].'include/diaries/diarytagmgr.php');
require_once ($CONFIG['engine_path'].'include/diaries/diaryrecord.php');
require_once ($CONFIG['engine_path'].'include/diaries/diaryrecordsmgr.php');
require_once ($CONFIG['engine_path'].'include/diaries/diaryrecorditerator.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 9:55 16 ноября 2009 г.
 */
class Diary
{
	public $ID				= null;
	public $UserID		= null;
	public $RegionID		= null;
	public $Created		= null;
	public $Records		= null;
	public $IsVisible		= null;
	public $IsDel			= null;
	public $IsConverted= null;
	public $IsMain= null;
	public $LastRecordID= null;
	public $LastRecordDate= null;
	private $currentIsMain = null;

	function __construct(array $info) {
	
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['diaryid']) && Data::Is_Number($info['diaryid']) )
			$this->ID = $info['diaryid'];

		$this->UserID = 0;
		if ( Data::Is_Number($info['userid']) )
			$this->UserID = $info['userid'];
		
		$this->RegionID = 0;
		if ( Data::Is_Number($info['regionid']) )
			$this->RegionID = $info['regionid'];

		if ( isset($info['created']) )
			$this->Created		= $info['created'];
		else
			$this->Created		= time();
			
		if ( isset($info['lastrecorddate']) )
			$this->LastRecordDate		= $info['lastrecorddate'];
		
	
		$this->IsVisible	= $info['isvisible']  ? true : false;
		$this->IsDel		= $info['isdel'] ? true : false;
		$this->IsConverted	= $info['isconverted'] ? true : false;
		$this->IsMain = $this->currentIsMain = $info['ismain'] ? true : false;
		$this->LastRecordID	= $info['lastrecordid'] > 0 ? $info['lastrecordid'] : 0;
	}
	
	
	/**
	 * сохранить информацию в базе
	 * использует метод метод DiaryMgr
	 */
	public function Update() {
	
		$info = array(
			'UserID'			=> $this->UserID,
			'RegionID'			=> $this->RegionID,
			
			'Created'			=> strftime("%G-%m-%d %H:%M:%S",$this->Created),
			
			'IsVisible'			=> (int) $this->IsVisible,
			'IsDel'				=> (int) $this->IsDel,
			'IsConverted'		=> (int) $this->IsConverted,
			'IsMain'			=> (int) $this->IsMain,
			'LastRecordDate'	=> $this->LastRecordDate,
			'LastRecordID'		=> (int) $this->LastRecordID,
		);
		
		if ( $this->ID !== null ) {
			$info['DiaryID'] = $this->ID;
			if ( false !== DiaryMgr::getInstance()->Update($info)) 
			{
				if ((int)$this->currentIsMain != (int)$this->IsMain)
					DiaryMgr::getInstance()->SetIsMainForUser($this->UserID, $this->IsMain);
				return true;
			}
		} else if ( false !== ($new_id = DiaryMgr::getInstance()->Add($info))) {
			$this->ID = $new_id;
			
			EventMgr::Raise('diaries/diary/add', array(
				'userid' => $this->UserID, 
				'regionid' => $this->RegionID
			));
			
			return $new_id;
		}

		return false;
	}


	public function Remove() {
		
		if ( $this->ID === null)
			return false;
			
		$records = $this->GetRecords( array() );
		
		if ($records !== null){
			foreach($records as $record){
			
				DiaryMgr::getInstance()->DeleteComplaints($record->ID);
				DiaryTagMgr::getInstance()->UnlinkTags( $this->ID, $record->ID );
			}
		}
		
		if (DiaryMgr::getInstance()->Remove($this->ID)) {
			EventMgr::Raise('diaries/diary/remove', array(
				'userid' => $this->UserID, 
				'regionid' => $this->RegionID
			));
		}
	}	
	
	public function Subscribe( $userid = null ) {
		
		if ( $this->ID === null)
			return false;
		
		return DiaryMgr::getInstance()->Subscribe( $userid, $this->ID, $this->RegionID);
	}
	
	public function IsSubscribed( $userid = null ) {
		
		if ( $this->ID === null)
			return false;
			
		if($userid == $this->UserID)
			return true;
		
		return DiaryMgr::getInstance()->IsSubscribed( $userid, $this->ID);
	}
	
	
	public function GetTags( array $filter, $as_array = false ){
	
		$filter['diaryid'] = $this->ID;	
		
		return DiaryTagMgr::getInstance()->GetTags( $filter, $as_array );		
	}
	
	
	/*
	* Фабричный метод для создания записей
	*/
	public function CreateRecord( $info = array() ){
	
		if ( $this->ID === null)
			return false;
				
		if ( is_array($info) ){		
			$info['diaryid'] = $this->ID;
			$info['regionid'] = $this->RegionID;
			$info['userid'] = $this->UserID;
		}
		else		
			$info = array( 
				'diaryid'	=> $this->ID,
				'regionid'	=> $this->RegionID,
				'userid'	=> $this->UserID,
			);
			
		return new DiaryRecord( $info );	
	}
	
	
	public function GetRecords( array $filter, $as_array = false ){
	
		if ( $this->ID === null)
			return null;
	
		$filter['diaryid'] = $this->ID;		
		if ($as_array === false){
		
			$iterator = new  DiaryRecordIterator( $filter );
			
			if ( $iterator->count() == 0 )
				return null;
				
			return $iterator;
		} else {
		
			$records = DiaryRecordsMgr::getInstance()->GetRecords($filter, $as_array);	
		
			if ( empty($records) )
				return null;
		
			return $records;
		}
	}
	
	public function GetCountRecords( array $filter ){
	
		if ( $this->ID === null)
			return false;
			
		$filter['diaryid'] = $this->ID;
		return DiaryRecordsMgr::getInstance()->GetCountRecords( $filter );
	}
	
	
	public function GetRecord( $id, $as_array = false ){
		
		if ( $this->ID === null || !Data::Is_Number($id) )
			return null;
	
		$filter = array(
			'diaryid'	=> $this->ID,
			'recordid'	=> $id,
		);
		
		$records = DiaryRecordsMgr::getInstance()->GetRecords($filter, $as_array);	
		
		if ( empty($records) )
			return null;
			
		return $records[0];
	}
	
	
	public function __set($name, $value) {
		
		return null;
	}
	
	
	public function __get($name) {
	
		return null;
	}
	
	
	function __destruct() {

	}
}
?>
