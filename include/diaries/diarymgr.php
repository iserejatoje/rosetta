<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/diaries/diary.php');
require_once ($CONFIG['engine_path'].'configure/lib/diaries/error.php');

/**
 * @author Иван Чурюмов
 * @version 1.0
 * @created 14:54 16 ноября 2009 г.
 */
class DiaryMgr
{

	/**
	 * Кэш дневников
	 */
	public $_diaries = array();

	public $_db			= null;
	public $_tables	= array(
		'diaries'			=> 'users_diaries',
		'records'			=> 'users_diaries_records',
		'records_images'	=> 'users_diaries_records_images',
		'subscribe' 		=> 'users_diaries_subscribe',
		'complaint' 		=> 'users_diaries_complaints',
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
	 * Получить дневник по идентификатору
	 *
	 * @param id
	 */
	public function GetDiaryByID($id, $userid = null, $regid = null, $as_array = false)
	{

		if ( !Data::Is_Number($id) )
			return null;

		if ( !Data::Is_Number($userid) )
			$userid = null;

		if ( !Data::Is_Number($regid) )
			$regid = null;

		$sql = "SELECT * FROM ".$this->_tables['diaries'];
		$sql.= " WHERE DiaryID = ".$id;

		if ( isset( $userid ) )
			$sql.= " AND UserID = ".$userid;

		if ( isset( $regid ) )
			$sql.= " AND RegionID = ".$regid;

		//trace::Log($sql);

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {

			$info = $res->fetch_assoc();

			if ($as_array === true)
				return $info;

			$diary = $this->_diaryObject($info);

			return $diary;
		}

		return null;
	}

	/**
	 * Получить дневник по идентификатору пользователя
	 *
	 * @param id
	 */
	public function GetDiary( $userid = null, $regid = null, $as_array = false)
	{

		if ( !Data::Is_Number($userid) )
			return null;

		if ( !Data::Is_Number($regid) )
			return null;

		$sql = "SELECT * FROM ".$this->_tables['diaries'];
		$sql.= " WHERE UserID = ".$userid;
		$sql.= " AND RegionID = ".$regid;

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {

			$info = $res->fetch_assoc();

			if ($as_array === true)
				return $info;

			$diary = $this->_diaryObject($info);

			return $diary;
		}

		return null;
	}

	/**
	 * Установить всем записям пользователя флаг Блоггеров (IsMain)
	 *
	 * @param int UserID - пользователь
	 * @param int IsMain - устанавливаемый флаг
	 */
	public function SetIsMainForUser($UserID, $IsMain)
	{
		if (!Data::Is_Number($UserID) || $UserID <= 0)
			return;

		$IsMain = intval($IsMain) > 0 ? 1 : 0;

		$sql = "UPDATE ".$this->_tables['records']." SET";
		$sql.= " IsMain = ".$IsMain;
		$sql.= " WHERE UserID = ".$UserID;

		$this->_db->query($sql);
	}


	/**
	 * Получить дневники пользователя
	 *
	 * @param int userid - пользователь
	 * @return массив объектов Diary или null в случае ошибки
	 */
	public function GetDiariesByUser($userid)
	{

		if ( !Data::Is_Number($userid) )
			return null;
		$result = array();

		$sql = "SELECT * FROM ".$this->_tables['diaries'];
		$sql.= " WHERE UserID = ".$userid;

		$res = $this->_db->query($sql);
		while($info = $res->fetch_assoc())
		{
			$result[] = $this->_diaryObject($info);
		}
		if (count($result) > 0)
			return $result;

		return null;
	}


	public function GetSubscribedDiaries( $userid = null, $regid = null, $as_array = false )
	{

		if ( !Data::Is_Number($userid) )
			return false;

		$sql = "SELECT diaries.* FROM ".$this->_tables['diaries']." diaries";
		$sql.= ", ".$this->_tables['subscribe']." subscribe";
		$sql.= " WHERE diaries.DiaryID = subscribe.DiaryID";
		$sql.= " AND subscribe.UserID = ".$userid;

		if(Data::Is_Number($regid) )
			$sql.= " AND subscribe.RegionID = ".$regid;

		//trace::Log($sql);

		$res = $this->_db->query($sql);

		$result = array();

		if ($as_array === true)
			while ( $row = $res->fetch_assoc() )
				$result[] = $row;
		else
			while ( $row = $res->fetch_assoc() )
				$result[] = $this->_diaryObject($row);

		return $result;
	}


	public function IsSubscribed( $userid = null, $diaryid = null )
	{

		if ( !Data::Is_Number($userid) || !Data::Is_Number($diaryid) )
			return false;

		$sql = "SELECT * FROM ".$this->_tables['subscribe'];
		$sql.= " WHERE UserID = ".$userid;
		$sql.= " AND DiaryID = ".$diaryid;

		//trace::Log($sql);

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {

			return true;
		}

		return false;
	}


	public function Subscribe( $userid = null, $diaryid = null, $regid = null )
	{

		if ( !Data::Is_Number($userid) || !Data::Is_Number($diaryid) || !Data::Is_Number($regid) )
			return false;

		if ( ! $this->IsSubscribed($userid, $diaryid) ){

			$sql = "INSERT INTO ".$this->_tables['subscribe'];
			$sql.= " SET `UserID` = ".$userid;
			$sql.= ", `DiaryID` = ".$diaryid;
			$sql.= ", `RegionID` = ".$regid;

			//trace::Log($sql);

			if ( false === $this->_db->query($sql) )
				return false;
		}

		return true;
	}


	public function AddComplaint( $recordid , $text )
	{

		$text = trim($text);

		if ( !Data::Is_Number($recordid) || empty($text) )
			return false;

		$sql = "INSERT INTO ".$this->_tables['complaint'];
		$sql.= " SET `Text` = '".addslashes($text)."'";
		$sql.= ", `RecordID` = ".$recordid;

		//trace::Log($sql);

		if ( false === $this->_db->query($sql) )
			return false;

		$sql = "UPDATE ".$this->_tables['records'];
		$sql.= " SET `ComplaintCount` = ComplaintCount+1";
		$sql.= " WHERE `RecordID` = ".$recordid;

		//trace::Log($sql);

		if ( false === $this->_db->query($sql) )
			return false;

		return true;
	}


	public function GetComplaints( $recordid )
	{
		if ( !Data::Is_Number($recordid) )
			return false;

		$sql = "SELECT * FROM ".$this->_tables['complaint'];
		$sql.= " WHERE RecordID = ".$recordid;

		//trace::Log($sql);

		$res = $this->_db->query($sql);

		$result = array();

		while ( $row = $res->fetch_assoc() )
			$result[] = $row;

		return $result;
	}


	public function DeleteComplaints( $recordid )
	{

		if ( !Data::Is_Number($recordid) )
			return false;

		$sql = "DELETE FROM ".$this->_tables['complaint'];
		$sql.= " WHERE RecordID = ".$recordid;

		//trace::Log($sql);

		if ( false === $this->_db->query($sql) )
			return false;

		$sql = "UPDATE ".$this->_tables['records'];
		$sql.= " SET `ComplaintCount` = 0";
		$sql.= " WHERE `RecordID` = ".$recordid;

		//trace::Log($sql);

		if ( false === $this->_db->query($sql) )
			return false;

		return true;
	}


	public function UnSubscribe( $userid = null, $diaryid = null )
	{

		if ( !Data::Is_Number($userid) || !Data::Is_Number($diaryid) )
			return false;

		$sql = "DELETE FROM ".$this->_tables['subscribe'];
		$sql.= " WHERE `UserID` = ".$userid;
		$sql.= " AND `DiaryID` = ".$diaryid;

		if ( false === $this->_db->query($sql) )
			return false;

		return true;
	}


	private function _diaryObject(array $info) {

		$info = array_change_key_case($info, CASE_LOWER);

		return new Diary($info);
	}


	private function _recordObject(array $info) {

		$info = array_change_key_case($info, CASE_LOWER);

		return new DiaryRecord($info);
	}


	/**
	 * Получить запись по идентификатору
	 *
	 * @param id
	 */
	public function GetRecordByID($id, $diaryid = null, $as_array = false)
	{

		if ( !Data::Is_Number($id) )
			return null;

		if ( !Data::Is_Number($diaryid) )
			$diaryid = null;

		$sql = "SELECT * FROM ".$this->_tables['records'];
		$sql.= " WHERE RecordID = ".$id;

		if ( isset( $diaryid ) )
			$sql.= " AND DiaryID = ".$diaryid;

		//trace::Log($sql);

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {

			$info = $res->fetch_assoc();

			if ($as_array === true)
				return $info;

			$record = $this->_recordObject($info);

			return $record;
		}

		return null;
	}

	public function GetRecordByOldID($id, $regid = null, $as_array = false)
	{

		if ( !Data::Is_Number($id) )
			return null;

		if ( !Data::Is_Number($regid) )
			$regid = null;

		$sql = "SELECT * FROM ".$this->_tables['records'];
		$sql.= " WHERE OldID = ".$id;

		if ( isset( $regid ) )
			$sql.= " AND RegionID = ".$regid;

		if ( false !== ($res = $this->_db->query($sql)) && $res->num_rows ) {

			$info = $res->fetch_assoc();

			if ($as_array === true)
				return $info;

			$record = $this->_recordObject($info);

			return $record;
		}

		return null;
	}


	/**
	 * добавить дневник
	 *
	 * @param info    информация о дневнике
	 */
	public function Add(array $info)
	{
		unset($info['DiaryID']);

	//	if(empty($info['Created']))
		//	$info['Created'] = strftime("%G-%m-%d %H-%M-%S",time());

		if ( !sizeof($info) )
			return false;

		$fields = array();

		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['diaries'].' SET  ' . implode(', ', $fields);

		//trace::Log($sql);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}


	/**
	 * удалить дневник
	 *
	 * @param id    идентификатор
	 */
	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$sql = 'DELETE FROM '.$this->_tables['diaries'].' WHERE DiaryID = '.$id;

		//trace::Log($sql);

		if ( false !== $this->_db->query($sql) ) {

			$this->RemoveAllFromDiary($id);
			return true;
		}

		return false;
	}


	/**
	 * обновить информацию о дневнике
	 *
	 * @param info    информация о дневнике
	 */
	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['DiaryID']) )
			return false;

		$fields = array();

		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = "UPDATE ".$this->_tables['diaries'];
		$sql.= " SET ".implode(', ', $fields);
		$sql.= " WHERE DiaryID = ".$info['DiaryID'];

		//trace::Log($sql);

		if ( false !== $this->_db->query($sql) )
			return true;

		return false;
	}


	public function IncRecordPoints( $recordid, $points = 1 ){

			$sql = "UPDATE ".$this->_tables['records'];
			$sql.= " SET Points = Points +".$points;
			$sql.= " ,LastPointInc = NOW()";
			$sql.= " WHERE RecordID = ".$recordid;

			//trace::Log($sql);

			return $this->_db->query($sql) ;
	}

	public function DecRecordPoints( $recordid, $points = 1 ){

			$sql = "UPDATE ".$this->_tables['records'];
			$sql.= " SET Points = Points -".$points.",";
			$sql.= " LastPointInc = IF(Points=0, '0000-00-00 00:00:00', LastPointInc)";
			$sql.= " WHERE RecordID = ".$recordid;

			return $this->_db->query($sql) ;
	}


	/**
	 * обновить информацию о записи в дневнике
	 *
	 * @param info    информация о дневнике
	 */
	public function UpdateRecord( array $info )
	{
		if ( !sizeof($info) )
			return false;

		if ( !Data::Is_Number($info['RecordID']) || $info['RecordID']==0 ){

			unset( $info['RecordID'] );
			$fields = array();

			foreach( $info as $k => $v)
				$fields[] = "`$k` = '".addslashes($v)."'";

			$sql = "INSERT INTO ".$this->_tables['records'];
			$sql.= " SET ".implode(', ', $fields);
			if ( true !== $this->_db->query($sql) )
				return false;
			
			$info['RecordID'] = $this->_db->insert_id;
		} else {

			$fields = array();
			foreach( $info as $k => $v)
				$fields[] = "`$k` = '".addslashes($v)."'";

			$sql = "UPDATE ".$this->_tables['records'];
			$sql.= " SET ".implode(', ', $fields);
			$sql.= " WHERE RecordID = ".$info['RecordID'];

			if ( true !== $this->_db->query($sql) )
				return false;
		}

		$sql = 'SELECT DiaryID FROM '.$this->_tables['records'];
		$sql.= ' WHERE RecordID = '.$info['RecordID'];
		$res = $this->_db->query($sql);
			
		if ($res && $res->num_rows) {
			list($DiaryID) = $res->fetch_row();
		
			$sql = 'SELECT RecordID, Created FROM '.$this->_tables['records'];
			$sql.= ' WHERE DiaryID = '.$DiaryID;
			$sql.= ' AND PublicState = 2 ';
			$sql.= ' ORDER by Created DESC';
			$sql.= ' LIMIT 1 ';
			
			//Обновим информацию о последнем сообщении в дневнике
			if (false != ($res = $this->_db->query($sql)) && $res->num_rows) {
				list($RecordID, $Created) = $res->fetch_row();
				
				$sql = "UPDATE ".$this->_tables['diaries']." SET";
				$sql.= " LastRecordID = ".$RecordID;
				$sql.= ", LastRecordDate = '".$Created."'";
				$sql.= " WHERE DiaryID=".$DiaryID;
				$this->_db->query($sql);
			} else {				
				$sql = "UPDATE ".$this->_tables['diaries']." SET";
				$sql.= " LastRecordID = 0";
				$sql.= ", LastRecordDate = '0000-00-00'";
				$sql.= " WHERE DiaryID=".$DiaryID;
				$this->_db->query($sql);
			}
		}
		
		return true;
	}

	public function UpdateOldRecord( array $info )
	{
		if ( !sizeof($info) )
			return false;

		if ( !Data::Is_Number($info['OldID']) || $info['OldID']==0 )
			return false;

		$RecordID =  $info['RecordID'] ;
		unset( $info['RecordID'] );

		$sql = "SELECT count(*) FROM ".$this->_tables['records'];
		$sql.= " WHERE `OldID` = ".$info['OldID'];
		$sql.= " AND DiaryID = ".$info['DiaryID'];

		if ( $res = $this->_db->query($sql) ){

			$row = $res->fetch_row();

			if ( $row[0] == 0 ){

				$fields = array();

				foreach( $info as $k => $v)
					$fields[] = "`$k` = '".addslashes($v)."'";

				$sql = "INSERT INTO ".$this->_tables['records'];
				$sql.= " SET ".implode(', ', $fields);

				//trace::Log($sql);

			//	if ( false !== $this->_db->query($sql) )
				//	return $this->_db->insert_id;
				return null;

			} else {

				$fields = array();

				foreach( $info as $k => $v)
					$fields[] = "`$k` = '".addslashes($v)."'";

				$sql = "UPDATE ".$this->_tables['records'];
				$sql.= " SET Created='".$info['Created']."'";
				$sql.= " WHERE OldID = ".$info['OldID'];
				$sql.= " AND DiaryID = ".$info['DiaryID'];

				//trace::Log($sql);

				if ( false !== $this->_db->query($sql) )
					return $RecordID;

			}
		}

		return false;
	}


	public function removeRecordRef2Image($id, $pid = null) {

		if ( !Data::Is_Number($id) )
			return false;

		if ( $pid !== null && !Data::Is_Number($pid) )
			return false;

		$sql = 'DELETE FROM '.$this->_tables['records_images'];
		$sql.= ' WHERE RecordID = '.$id;

		if ($pid)
			$sql.= ' AND PhotoID = '.$pid;

		if (false !== $this->_db->query($sql))
			return true;

		return false;
	}

	public function addRecordRef2Image($id, array $pids) {
		if ( !Data::Is_Number($id) )
			return false;

		if (!sizeof($pids))
			return false;

		$pids = array_unique($pids);
		foreach($pids as $pid) {
			$sql = 'INSERT IGNORE INTO '.$this->_tables['records_images'];
			$sql.= ' SET RecordID = '.$id;
			$sql.= ' ,PhotoID = '.(int) $pid;

			if (false == $this->_db->query($sql))
				return false;
		}

		return true;
	}

	/**
	 * удалить запись из дневника
	 *
	 * @param id    идентификатор
	 */
	public function RemoveRecord($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$sql = 'SELECT DiaryID FROM '.$this->_tables['records'];
		$sql.= ' WHERE RecordID = '.$id;
		$res = $this->_db->query($sql);
			
		if (!$res || !$res->num_rows)
			return false;
			
		list($DiaryID) = $res->fetch_row();
			
		$sql = 'DELETE FROM '.$this->_tables['records'].' WHERE RecordID = '.$id;
		if ( false !== $this->_db->query($sql) ) {
			$sql = 'SELECT RecordID, Created FROM '.$this->_tables['records'];
			$sql.= ' WHERE DiaryID = '.$DiaryID;
			$sql.= ' AND PublicState = 2 ';
			$sql.= ' ORDER by Created DESC';
			$sql.= ' LIMIT 1 ';
			
			if (false != ($res = $this->_db->query($sql)) && $res->num_rows) {
				list($RecordID, $Created) = $res->fetch_row();
				
				//Обновим информацию о последнем сообщении в дневнике
				$sql = "UPDATE ".$this->_tables['diaries']." SET";
				$sql.= " LastRecordID = ".$RecordID;
				$sql.= ", LastRecordDate = '".$Created."'";
				$sql.= " WHERE DiaryID=".$DiaryID;
				$this->_db->query($sql);
			} else {
				//Обновим информацию о последнем сообщении в дневнике
				$sql = "UPDATE ".$this->_tables['diaries']." SET";
				$sql.= " LastRecordID = 0";
				$sql.= ", LastRecordDate = '0000-00-00'";
				$sql.= " WHERE DiaryID=".$DiaryID;
				$this->_db->query($sql);
			}
		
			$this->removeRecordRef2Image($id);
			return true;
		}

		return false;
	}


	/**
	 * удалить все записи из дневника
	 *
	 * @param id    идентификатор
	 */
	public function RemoveAllFromDiary($id){

		if ( !Data::Is_Number($id) )
			return false;

		$sql = 'DELETE FROM '.$this->_tables['records'].' WHERE DiaryID = '.$id;
		if ( false !== $this->_db->query($sql) ) {
			//Обновим информацию о последнем сообщении в дневнике
			$sql = "UPDATE ".$this->_tables['diaries']." SET";
			$sql.= " LastRecordID = 0";
			$sql.= ", LastRecordDate = '0000-00-00'";
			$sql.= " WHERE DiaryID=".$id;
			$this->_db->query($sql);
		
			return true;
		}

		return false;
	}

	/**
	 * Получить общее количество блогов по региону
	 *
	 * @param int RecordID - идентификатор региона
	 * @return int - количество блоговю или null в случае ошибки
	 */
	public function GetCountDiaries($RegionID)
	{
		if ( !Data::Is_Number($RegionID) )
			return null;

		$sql = "SELECT COUNT(0) FROM ".$this->_tables['diaries'];
		$sql.= " WHERE RegionID=".$RegionID;

		$res = $this->_db->query($sql);
		if( ($row = $res->fetch_row()) !== false )
			return $row[0];
		else
			return null;
	}


	public function Dispose() {

	}
}
