<?php
class AppCommentMicro {
	
	public static $db = null;
	public static $tables = null;	
	
	protected $_data = array();
	protected $_ID;	
	protected $_Name;
	protected $_Text;
	protected $_Created;	
	protected $_UserID;
	protected $_IsNew;
	protected $_IsVisible;	
	protected $_IsDel;
	protected $_CommentDate;	
	protected $_SectionID = null;

	public function __construct($params = array())
	{
		if (!is_array($params))
			$params = (array)$params;
		if (isset($params['sectionid']))
			$this->_SectionID = intval($params['sectionid']);
		else
			$this->_SectionID = 0;
			
		$this->CheckOptions();
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		if ($this->_ID == 0)
		{
			$sql = "INSERT INTO `".self::$tables['comments']."` ";
			$sql.= "SET `UserID` = '".$this->_UserID."', ";					
			$sql.= "`Created` = NOW(), ";
			$sql.= "`SectionID` = ".addslashes($this->_SectionID).", ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
		}
		else
		{
			$sql = "UPDATE `".self::$tables['comments']."` ";
			$sql.= "SET ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Created` = '".addslashes($this->_Created)."', ";
			//$sql.= "`SectionID` = ".addslashes($this->_SectionID).", ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."', ";
			$sql.= "`moderate` = 0";
			$sql.= " WHERE `CommentID` = ".$this->_ID;
		}

		self::$db->query($sql);
		if ($this->_ID == 0) 
			$this->_ID = self::$db->insert_id;

		return true;
	}
	
	public function Complain($id)
	{
		if ($id == null || $id == 0)
			return false;
			
		$sql = "SELECT moderate FROM `".self::$tables['comments']."`";
		$sql.= " WHERE `CommentID` = '".$id."'";
		
		$res = self::$db->query($sql);
		if ( ($res = self::$db->query($sql)) == false )
			return false;

		if (($row = $res->fetch_assoc()) !== false)
			if ($row['moderate'] == 1)
				return true;
		
			
		$sql = "UPDATE `".self::$tables['comments']."`";
		$sql.= " SET `moderate` = 1";
		$sql.= " WHERE `CommentID` = '".$id."'";
		
		self::$db->query($sql);
		return true;
	}
		
	public function Remove($ids)
	{
		global $OBJECTS;
				
		$ids = (array) $ids;
		if ( !sizeof($ids) )
			return;
		foreach($ids as &$v)
			$v = (int) $v;
		
		$sql = "UPDATE `".self::$tables['comments']."`";
		$sql.= " SET `IsDel` = 1, `IsNew` = 0 ";
		$sql.= " WHERE `CommentID` IN(".implode(',', $ids).")";
		
		self::$db->query($sql);
				
		return true;
	}
		
	public function GetComment($id, $array = false)
	{	
		$sql = "SELECT * FROM ".self::$tables['comments'];	
		$sql.= " WHERE `CommentID` = ".(int) $id.' LIMIT 1';

		if (($res = self::$db->query($sql)) === false)		
			return array();
		
		if (($list = $res->fetch_assoc()) === false)
			return array();
			
		LibFactory::GetStatic('datetime_my');
		
		//$list['Created'] = DateTime_My::NowOffset(null, strtotime($list['Created']));
		
		$this->_data = $list;
		
		
		return $list;		
	}
	
	public function CreateInstance($data)
	{
		$obj = new self();
		
		$data = array_change_key_case($data, CASE_LOWER);		
		$obj->_ID = $data['commentid'];				
		$obj->_Name = $data['name'];
		$obj->_Text = $data['text'];
		$obj->_Created = $data['created'];		
		$obj->_UserID = $data['userid'];
		$obj->_IsVisible = $data['isvisible'];		
		$obj->_IsDel = $data['isdel'];
		$obj->_IsNew = $data['isnew'];
		$obj->_data = $data['data'];
		$obj->_CommentDate = Datetime_my::SimplyDate(Datetime_my::NowOffsetTime(null, strtotime($data['created'])));
		
		return $obj;
	}
	
	public function GetCommentsCount($filter)
	{
		$sql = 'SELECT COUNT(*) FROM '.self::$tables['comments'];
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();
			
			if ($this->_SectionID !== null)
				$sqlt[] = " `SectionID`='".$this->_SectionID."'";
			
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
			
			if (isset($filter['fields']['isnew']))
			{
				if ($filter['fields']['isnew'] == 0 || $filter['fields']['isnew'] == 1)
					$sqlt[] = " `IsNew` = '".$filter['fields']['isnew']."' ";
			}
			if (isset($filter['fields']['isdel']))
			{
				if ($filter['fields']['isdel'] == 0 || $filter['fields']['isdel'] == 1)
					$sqlt[] = " `IsDel` = '".$filter['fields']['isdel']."' ";
			}
			else
				$sqlt[] = " `IsDel` = 0 ";
						
			$sql.= implode(' AND ', $sqlt);
						
		} 
		
		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY `".implode('`, c.`', $filter['group']).'`';
		}

		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return 0;
		
		$count = $res->fetch_row();
		return $count[0];
	}
		
	public function GetComments($filter, $asArray = false)
	{		
		global $CONFIG;
		$sql = 'SELECT * FROM '.self::$tables['comments'];		
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();

			if ($this->_SectionID !== null)
				$sqlt[] = " `SectionID`='".$this->_SectionID."'";
				
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
							
			if (isset($filter['fields']['isnew']))
			{
				if ($filter['fields']['isnew'] == 0 || $filter['fields']['isnew'] == 1)
					$sqlt[] = " `IsNew` = '".$filter['fields']['isnew']."' ";
			}
			if (isset($filter['fields']['isdel']))
			{
				if ($filter['fields']['isdel'] == 0 || $filter['fields']['isdel'] == 1)
					$sqlt[] = " `IsDel` = '".$filter['fields']['isdel']."' ";
			}
			else
				$sqlt[] = " `IsDel` = 0 ";
			if (isset($filter['fields']['moderate']))
			{
				if ($filter['fields']['moderate'] == 0 || $filter['fields']['moderate'] == 1)
					$sqlt[] = " `moderate` = '".$filter['fields']['moderate']."' ";
			}
		
			
							
			$sql.= implode(' AND ', $sqlt);
						
		} 
		
		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY `".implode('`, `', $filter['group']).'`';
		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= " ORDER BY ";
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if (strtolower($f['field']) == 'created')
					$f['field'] = 'Created';
			
				if ( !in_array(strtolower($f['dir']), array('asc','desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = " ".$f['field']." ".$f['dir']." ";
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		if (is_array($filter['limit']) && sizeof($filter['limit']) > 0)
		{
			$sql.= " LIMIT ";
			$sqlt = array();
			if (isset($filter['limit']['offset']) && is_numeric($filter['limit']['offset']) && $filter['limit']['offset'] >= 0)
				$sql.= $filter['limit']['offset'].", ";
			else
				$sql.= "0, ";
			
			if (isset($filter['limit']['limit']) && is_numeric($filter['limit']['limit']))
				$sql.= $filter['limit']['limit'];
			else
				$sql.= 5;
		}

		$list = array();
		
		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;
		
		if ($is_res === true)
			return $res;
		
		LibFactory::GetStatic('datetime_my');
		
		while ($row = $res->fetch_assoc())
		{
			$row['Created'] = DateTime_My::NowOffset(null, strtotime($row['Created']));
		
			$list[$row['CommentID']] = array(				
				'data'		=> $row,				
			);
		}
		
		return $list;	
	}
	
	public function SetDbAndTables($db, $tables)
	{
		self::$db = $db;
		self::$tables = $tables;
	}
	
	public function __get($name)
	{
		global $OBJECTS;
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'name')
			return $this->_Name;
		elseif ($name == 'text')
			return $this->_Text;
		elseif ($name == 'created')
			return $this->_Created;		
		elseif ($name == 'isvisible')
			return $this->_IsVisible;
		elseif ($name == 'isnew')
			return $this->_IsNew;
		elseif ($name == 'isdel')
			return $this->_IsDel;	
		elseif ($name == 'user')
			return $OBJECTS['usersMgr']->GetUser($this->_UserID);	
		elseif ($name == 'data')
			return $this->_data;
		elseif ($name == 'date')
			return $this->_CommentDate;
		else
			return null;
	}
	
	public function __isset($name)
	{
		$name = strtolower($name);
		if($name == 'id' || $name == 'name' || $name == 'text' || $name == 'created' || $name == 'isvisible' 
			|| $name == 'isnew' || $name == 'userid' || $name == 'isdel')
			return true;
		else
			return false;
	}
	
	public function __unset($name)
	{
	}
	
	public function __set($name, $value)
	{
		$name = strtolower($name);
		if ($name == 'name')
			$this->_Name = $value;		
		elseif ($name == 'text')
			$this->_Text = $value;		
		elseif ($name == 'isvisible')
			$this->_IsVisible = $value;
		elseif ($name == 'created')
			$this->_Created = $value;
		elseif ($name == 'isnew')
			$this->_IsNew = $value;
		elseif ($name == 'userid')
			$this->_UserID = $value;
		elseif ($name == 'isdel')
			$this->_IsDel = $value;	
		elseif ($name == 'isdel')
			$this->_IsDel = $value;				
	}
	
	protected function CheckOptions()
	{
		if ($this->_SectionID > 0)
			return true;
		return false;
	}
}

?>
