<?php
class AppComment {
	
	public static $db = null;
	public static $tables = null;
	public static $uniqueid = null;
	private $_ID;
	private $_Name;
	private $_Text;
	private $_Created;
	private $_UniqueID;
	private $_UserID;
	private $_IsNew;
	private $_IsVisible;
	private $_IsDel;
	private $_VotePlus;
	private $_VoteMinus;
	private $_VoteCount;

	public function __construct()
	{
		LibFactory::GetStatic('datetime_my');
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		//2do прикрутить проверку ролей
		// вообще роли проверять в модуле
		/*if ($OBJECTS['user']->ID < 1 || !$OBJECTS['user']->IsInRole('a_comment_edit'))
			return false;*/
		
		if ($this->_ID == 0)
		{
			$sql = "INSERT INTO `".self::$tables['comments']."` ";
			$sql.= "SET `UserID` = '".$this->_UserID."', ";
			$sql.= "`Created` = NOW(), ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			//$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
		}
		else
		{
			$sql = "UPDATE `".self::$tables['comments']."` ";
			$sql.= "SET ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
			$sql.= "WHERE `CommentID` = ".$this->_ID;
		}

		self::$db->query($sql);
		if ($this->_ID == 0) {
			$this->_ID = self::$db->insert_id;
			
			$this->AddReference($this->_UniqueID);
		}
		return true;
	}
	
	public function AddReference($uniqueid)
	{
		$uniqueid = (array) $uniqueid;
	
		foreach ($uniqueid as $id) {
	
			$sql = 'INSERT IGNORE INTO `'.self::$tables['ref'].'` SET ';
			$sql .= ' `UniqueID` = '.(int) $id;
			$sql .= ' ,`CommentID` = '.$this->_ID;
			self::$db->query($sql);
		}
		
		$sql = 'SELECT `Created` FROM `'.self::$tables['comments'].'` WHERE ';
		$sql .= ' `CommentID` = '.$this->_ID;
		$res = self::$db->query($sql);
		
		if ( !$res || !$res->num_rows )
			return ;
			
		list($Created) = $res->fetch_row();
		
		$sql = 'UPDATE `'.self::$tables['ref'].'` SET ';
		$sql .= ' `opt_Date` = \''.$Created.'\'';
		$sql .= ' WHERE `CommentID` = '.$this->_ID;
		self::$db->query($sql);
	}

	public function RemoveReference($uniqueid) 
	{
		$uniqueid = (array) $uniqueid;
	
		foreach ($uniqueid as $id) {
	
			$sql = 'DELETE FROM `'.self::$tables['ref'].'` WHERE ';
			$sql .= ' `UniqueID` = '.(int) $id;
			$sql .= ' AND `CommentID` = '.$this->_ID;
			self::$db->query($sql);
		}
	}
	
	public function RemoveAllReference()
	{
	
		$sql = 'DELETE FROM `'.self::$tables['ref'].'` WHERE ';
		$sql .= ' `CommentID` = '.$this->_ID;
		self::$db->query($sql);
	}
	
	public function UserIsVoted($id, $user)
	{
		global $OBJECTS;
				
		$sql = "SELECT COUNT(*) FROM `".self::$tables['votes']."` ";
		$sql.= "WHERE `CommentID` = ".$id." ";
		$sql.= "AND `UserID` = ".$user." ";
		
		$res = self::$db->query($sql);
		$row = $res->fetch_row();
		if ($row[0] == 0)
			return false;
		return true;
	}
	
	public function AddVote($id, $user, $result)
	{
		global $OBJECTS;
		
		if (!in_array($result, array(1,-1)))
			return false;
		
		$sql = "UPDATE `".self::$tables['comments']."` ";
		$sql.= "SET `VoteCount` = `VoteCount` + ".intval($result)." ";
		if ($result == 1)
			$sql.= ", `VotePlus` = `VotePlus` + 1";
		elseif ($result == -1)
			$sql.= ", `VoteMinus` = `VoteMinus` + 1";
		else
			return false;
		$sql.= " WHERE `CommentID` = ".$id;
		self::$db->query($sql);
		
		$sql = "INSERT INTO `".self::$tables['votes']."` ";
		$sql.= "SET `CommentID` = ".$id.", ";
		$sql.= "`UserID` = ".$user.", ";
		$sql.= "`DateVote` = NOW()";
		self::$db->query($sql);
		
		$sql = "SELECT `VoteCount` FROM `".self::$tables['comments']."` ";
		$sql.= " WHERE `CommentID` = ".$id;
		$res = self::$db->query($sql);
		$row = $res->fetch_row();
		return $row[0];
	}
	
	public static function Remove($id)
	{
		global $OBJECTS;
		
		$sql = "UPDATE `".self::$tables['comments']."` ";
		$sql.= "SET `IsDel` = 1, `IsNew` = 0 ";
		$sql.= "WHERE `CommentID` = ".$id;
		
		self::$db->query($sql);
		
		return true;
	}
	
	public static function GetReferenceList($id)
	{	
		$sql = "SELECT `UniqueID` FROM `".self::$tables['ref']."` ";
		$sql.= "WHERE `CommentID` = ".$id;
		
		$res = self::$db->query($sql);
		if ($res->num_rows == 0)
			return null;
		
		$list = array();
		
		while ($row = $res->fetch_row()) {
			$list[] = $row[0];
		}

		return $list;
	}
	
	public static function GetComment($id)
	{	
		$sql = "SELECT c.*, r.`UniqueID` FROM `".self::$tables['comments']."` as c ";
		$sql.= "INNER JOIN `".self::$tables['ref']."` as r ON(r.`CommentID` = c.`CommentID`) ";
		$sql.= "WHERE c.`CommentID` = ".$id;
		
		$res = self::$db->query($sql);
		if ($res->num_rows == 0)
			return false;
		
		$row = $res->fetch_assoc();
		
		LibFactory::GetStatic('datetime_my');
		
		$list = array();
		$list['id'] = $id;
		$list['name'] = $row['Name'];
		$list['text'] = $row['Text'];
		$list['isvisible'] = $row['IsVisible'];
		$list['userid'] = $row['UserID'];
		$list['created'] 	= DateTime_My::NowOffset(null, strtotime($row['Created']));
		$list['uniqueid'] = $row['UniqueID'];
		$list['isnew'] = $row['IsNew'];
		$list['isdel'] = $row['IsDel'];
		$list['voteplus'] = $row['VotePlus'];
		$list['voteminus'] = $row['VoteMinus'];
		$list['votecount'] = $row['VoteCount'];

		
		return self::CreateInstance($list);
	}
	
	public static function CreateInstance($data)
	{
		$obj = new self();
		
		$obj->_ID = $data['id'];
		$obj->_Name = $data['name'];
		$obj->_Text = $data['text'];
		$obj->_Created = $data['created'];
		$obj->_UniqueID = $data['uniqueid'];
		$obj->_UserID = $data['userid'];
		$obj->_IsVisible = $data['isvisible'];
		$obj->_IsDel = $data['isdel'];
		$obj->_IsNew = $data['isnew'];
		$obj->_VotePlus = $data['voteplus'];
		$obj->_VoteMinus = $data['voteminus'];
		$obj->_VoteCount = $data['votecount'];
		
		return $obj;
	}
	
	public static function GetCommentIterator($filter)
	{
		return new AppCommentIterator(self::$db, self::$tables, $filter);
	}
	
	public function __get($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'name')
			return $this->_Name;
		elseif ($name == 'text')
			return $this->_Text;
		elseif ($name == 'created')
			return $this->_Created;
		elseif ($name == 'uniqueid')
			return $this->_UniqueID;
		elseif ($name == 'userid')
			return $this->_UserID;
		elseif ($name == 'isvisible')
			return $this->_IsVisible;
		elseif ($name == 'isnew')
			return $this->_IsNew;
		elseif ($name == 'isdel')
			return $this->_IsDel;
		elseif ($name == 'voteplus')
			return $this->_VotePlus;
		elseif ($name == 'voteminus')
			return $this->_VoteMinus;
		elseif ($name == 'votecount')
			return $this->_VoteCount;
		else
			return null;
	}
	
	public function __isset($name)
	{
		$name = strtolower($name);
		if($name == 'id' || $name == 'name' || $name == 'text' || $name == 'created' || $name == 'uniqueid' 
			|| $name == 'isvisible' || $name == 'isnew' || $name == 'userid' || $name == 'isdel'
			|| $name == 'voteplus' || $name == 'voteminus' || $name == 'votecount')
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
		elseif ($name == 'uniqueid')
			$this->_UniqueID = $value;
		elseif ($name == 'isvisible')
			$this->_IsVisible = $value;
		elseif ($name == 'isnew')
			$this->_IsNew = $value;
		elseif ($name == 'userid')
			$this->_UserID = $value;
		elseif ($name == 'isdel')
			$this->_IsDel = $value;
		elseif ($name == 'voteplus')
			$this->_VotePlus = $value;
		elseif ($name == 'voteminus')
			$this->_VoteMinus = $value;
		elseif ($name == 'votecount')
			$this->_VoteCount = $value;
	}
}
class AppCommentIterator implements Countable, Iterator
{
	private $data = null;
	private $objetcs = null;
	
	public function __construct($db, $tables, $filter)
	{	
		global $OBJECTS;
		
		$sql = 'SELECT c.*, r.`UniqueID` FROM '.$tables['ref'].' as r ';
		$sql.= 'INNER JOIN `'.$tables['comments'].'` as c ON(c.`CommentID` = r.`CommentID`) ';
		
		if (sizeof($filter['ref']) > 0){
			
			$sql .= $filter['ref']['type'].' JOIN `'.$filter['ref']['table'].'` as ref ON(ref.`'.$filter['ref']['field'].'` = r.`UniqueID`) ';
			
		}
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();
			
			if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
				$sqlt[] = " r.`UniqueID` = '".$filter['fields']['uniqueid']."' ";
			
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " c.`IsVisible` = '".$filter['fields']['isvisible']."' ";
			
			if (isset($filter['fields']['isnew']))
			{
				if ($filter['fields']['isnew'] == 0 || $filter['fields']['isnew'] == 1)
					$sqlt[] = " c.`IsNew` = '".$filter['fields']['isnew']."' ";
			}
			if (isset($filter['fields']['isdel']))
			{
				if ($filter['fields']['isdel'] == 0 || $filter['fields']['isdel'] == 1)
					$sqlt[] = " c.`IsDel` = '".$filter['fields']['isdel']."' ";
			}
			else
				$sqlt[] = " c.`IsDel` = 0 ";
			$sql.= implode(' AND ', $sqlt);
			
			if ( !empty($filter['ref']['cond']) )
				$sql .= ' AND '.$filter['ref']['cond'];
		} else if ( !empty($filter['ref']['cond']) )
			$sql .= ' WHERE '.$filter['ref']['cond'];
		
		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY c.`".implode('`, c.`', $filter['group']).'`';
		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= " ORDER BY ";
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if (strtolower($f['field']) == 'created')
					$f['field'] = 'r.opt_Date';
			
				if ( !in_array(strtolower($f['dir']), array('asc','desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = " ".$f['field']." ".$f['dir']." ";
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		if (sizeof($filter['limit']) > 0)
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

		if (isset($filter['best']))
		{
			$sql.= " WHERE r.`UniqueID` = ".$filter['best'];
			$sql.= " AND c.`VoteCount` > 0";
			$sql.= " AND c.`IsVisible` = 1";
			$sql.= " AND c.`IsDel` = 0";
			$sql.= " ORDER BY c.`VoteCount` DESC, c.`Created` DESC LIMIT 1";
		}

		LibFactory::GetStatic('datetime_my');
		$res = $db->query($sql);
		while ($row = $res->fetch_assoc())
		{
			if ( $filter['count'] === true ) {
				$this->data[] = null;
				continue ;
			}
			$list = array();
			$list['id'] 		= $row['CommentID'];
			$list['title'] 		= $row['Title'];
			$list['name'] 		= $row['Name'];
			$list['text'] 		= $row['Text'];
			$list['isvisible'] 	= $row['IsVisible'];
			$list['isnew'] 		= $row['IsNew'];
			$list['isdel'] 		= $row['IsDel'];
			$list['userid'] 	= $row['UserID'];
			$list['created'] 	= DateTime_My::NowOffset(null, strtotime($row['Created']));
			$list['uniqueid'] 	= $row['UniqueID'];
			$list['voteplus'] 	= $row['VotePlus'];
			$list['voteminus'] 	= $row['VoteMinus'];
			$list['votecount'] 	= $row['VoteCount'];
			
			$this->data[] = $list;
		}
	}
	
	// Iterator
	public function current()
	{
		if($this->data === null)
			return null;
			
        $k = key($this->data);
        if(!isset($this->objects[$k]))
        {
            $this->objects[$k] = AppComment::CreateInstance($this->data[$k]);
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
