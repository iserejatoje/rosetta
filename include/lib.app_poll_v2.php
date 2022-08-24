<?php
class AppPoll_v2 {
	
	public static $db = null;
	public static $tables = null;
	public static $uniqueid = null;
	private $_ID;
	private $_Title;
	private $_Created;
	private $_UserID;
	private $_IsVisible;
	private $_Answers = null;
	private $_Type;
	private $_MultiMin;
	private $_MultiMax;
	private $_Votes;
	private $_IsClosed;
	
	public function __construct()
	{
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		if ($this->_ID == 0)
		{
			$sql = "INSERT INTO `".self::$tables['poll']."` ";
			$sql.= "SET `UserID` = '".intval($this->_UserID)."', ";
			$sql.= "`UniqueID` = '".intval($this->uniqueid)."', ";
			$sql.= "`Type` = '".intval($this->_Type)."', ";
			$sql.= "`Created` = NOW(), ";
			$sql.= "`Title` = '".addslashes($this->_Title)."', ";
			$sql.= "`MultiMax` = '".intval($this->_MultiMax)."', ";
			$sql.= "`MultiMin` = '".intval($this->_MultiMin)."', ";
			$sql.= "`IsVisible` = '".intval($this->_IsVisible)."', ";
			$sql.= "`Votes` = '".intval($this->_Votes)."', ";
			$sql.= "`IsClosed` = '".intval($this->_IsClosed)."'";
		}
		else
		{
			$sql = "UPDATE `".self::$tables['poll']."` ";
			$sql.= "SET ";
			$sql.= "`Title` = '".addslashes($this->_Title)."', ";
			$sql.= "`MultiMax` = '".intval($this->_MultiMax)."', ";
			$sql.= "`MultiMin` = '".intval($this->_MultiMin)."', ";
			$sql.= "`IsVisible` = '".intval($this->_IsVisible)."', ";
			$sql.= "`Type` = '".intval($this->_Type)."', ";
			$sql.= "`IsClosed` = '".intval($this->_IsClosed)."' ";
			$sql.= "WHERE `PollID` = ".intval($this->_ID);
		}

		self::$db->query($sql);
		
		if ($this->_ID == 0)
			$this->_ID = self::$db->insert_id;
		return true;
	}
	
	public static function Remove($id)
	{
		global $OBJECTS;
		
		$sql = "UPDATE `".self::$tables['poll']."` ";
		$sql.= "SET `IsDel` = 1 ";
		$sql.= "WHERE `PollID` = ".$id;
		
		self::$db->query($sql);
		
		$sql = "UPDATE `".self::$tables['poll_answer']."` ";
		$sql.= "SET `IsDel` = 1 ";
		$sql.= "WHERE `PollID` = ".$id;
		
		self::$db->query($sql);
		
		$sql = "UPDATE `".self::$tables['poll_voted']."` ";
		$sql.= "SET `IsDel` = 1 ";
		$sql.= "WHERE `PollID` = ".$id;
		
		self::$db->query($sql);
		
		return true;
	}
	
	public static function GetPoll($id)
	{
		$sql = "SELECT * FROM `".self::$tables['poll']."` ";
		$sql.= "WHERE `PollID` = ".$id;
		
		$res = self::$db->query($sql);
		if ($res->num_rows == 0)
			return false;
		
		$row = $res->fetch_assoc();
		
		$list = array();
		$list['id'] = $id;
		$list['userid'] = $row['UserID'];
		$list['uniqueid'] = $row['UniqueID'];
		$list['type'] = $row['Type'];
		$list['created'] = $row['Created'];
		$list['title'] = $row['Title'];
		$list['isvisible'] = $row['IsVisible'];
		$list['multimax'] = $row['MultiMax'];
		$list['multimin'] = $row['MultiMin'];
		$list['votes'] = $row['Votes'];		
		$list['isclosed'] = $row['IsClosed'];
		
		return self::CreateInstance($list);
	}
	
	public static function CreateInstance($data)
	{
		$obj = new self();
		
		$obj->_ID = $data['id'];
		$obj->_UserID = $data['userid'];
		$obj->_UniqueID = $data['uniqueid'];
		$obj->_Type = $data['type'];
		$obj->_Created = $data['created'];
		$obj->_Title = $data['title'];
		$obj->_IsVisible = $data['isvisible'];
		$obj->_MultiMax = $data['multimax'];
		$obj->_MultiMin = $data['multimin'];
		$obj->_Votes = $data['votes'];
		$obj->_IsClosed = $data['isclosed'];
		$obj->_Answers = new AppPollAnswerIterator(self::$db, self::$tables, $obj);

		return $obj;
	}
	
	public static function GetPollsIterator($filter)
	{
		return new AppPollIterator(self::$db, self::$tables, $filter);
	}
	
	public function GetAnswer($id)
	{
		$sql = "SELECT * FROM `".self::$tables['poll_answer']."` ";
		$sql.= "WHERE `PollAnswerID` = '".$id."' AND `IsDel` != 1";
		
		$res = self::$db->query($sql);
		
		if ($res->num_rows == 0)
			return false;
			
		$row = $res->fetch_assoc();
		
		$list = array();
		$list['id'] = $row['PollAnswerID'];
		$list['text'] = $row['Text'];
		$list['votes'] = $row['Votes'];
		
		return AppPollAnswer::CreateInstance($list, $this);
	}
	
	public function RemoveAnswer($id)
	{
		global $OBJECTS;
			
		$sql = "UPDATE `".self::$tables['poll_answer']."` ";
		$sql.= "SET `IsDel` = 1 ";
		$sql.= "WHERE `PollAnswerID` = ".$id;
		
		self::$db->query($sql);
		
		return true;
	}
	
	public function CreateAnswer()
	{
		global $OBJECTS;
		
		return new AppPollAnswer($this); 
	}
	
	public function UpdateAnswer($obj)
	{
		global $OBJECTS;
		
		if ($obj->ID == 0)
		{
			$sql = "INSERT INTO `".self::$tables['poll_answer']."` ";
			$sql.= "SET `PollID` = '".intval($obj->Parent->ID)."', ";
			$sql.= "`Text` = '".addslashes($obj->Text)."'";
		}
		else
		{
			$sql = "UPDATE `".self::$tables['poll_answer']."` ";
			$sql.= "SET ";
			$sql.= "`Text` = '".addslashes($obj->Text)."' ";
			$sql.= "WHERE `PollAnswerID` = ".$obj->ID;
		}
		
		self::$db->query($sql);
		
		return true;
		
	}
	
	public function AddAnswerVotes($id)
	{
		global $OBJECTS;
		
		/*
		* $this->_Type:
		*	1 - Можно выбрать только 1 вариант ответа
		*	2 - Можно выбрать несколько вариантов ответа
		*/

		if ($this->_Type == 1)
		{
			if (is_array($id))
				return false;
			
			$sql = "UPDATE `".self::$tables['poll_answer']."` SET ";
			$sql.= "`Votes` = `Votes` + 1 ";
			$sql.= "WHERE `PollAnswerID` = ".$id;
			self::$db->query($sql);
			
			$sql = "UPDATE `".self::$tables['poll']."` SET ";
			$sql.= "`Votes` = `Votes` + 1 ";
			$sql.= "WHERE `PollID` = ".$this->_ID;
			self::$db->query($sql);
			
			$sql = "INSERT INTO `".self::$tables['poll_voted']."` SET ";
			$sql.= "`PollID` = ".$this->_ID.", ";
			$sql.= "`UserID` = ".$OBJECTS['user']->ID;
			self::$db->query($sql);
			
			return true;
		}
		elseif ($this->_Type == 2)
		{
			if (!is_array($id) || sizeof($id) < 1)
				return false;
			
			if (sizeof($id) < $this->_MultiMin || sizeof($id) > $this->_MultiMax)
				return false;
			
			$sql = "UPDATE `".self::$tables['poll_answer']."` SET ";
			$sql.= "`Votes` = `Votes` + 1 ";
			$sql.= "WHERE `PollAnswerID` IN (".implode(',', $id).")";
			self::$db->query($sql);
			
			$sql = "UPDATE `".self::$tables['poll']."` SET ";
			$sql.= "`Votes` = `Votes` + 1 ";
			$sql.= "WHERE `PollID` = ".$this->_ID;
			self::$db->query($sql);
			
			$sql = "INSERT INTO `".self::$tables['poll_voted']."` SET ";
			$sql.= "`PollID` = ".$this->_ID.", ";
			$sql.= "`UserID` = ".$OBJECTS['user']->ID;
			self::$db->query($sql);
			
			return true;
		}
	}
	
	public function IsClientVoted($params)
	{
		if (isset($params['userid']))
		{
			$sql = "SELECT COUNT(*) FROM `".self::$tables['poll_voted']."` ";
			$sql.= "WHERE `UserID` = '".$params['userid']."' ";
			$sql.= "AND `PollID` = '".$this->_ID."' ";
			$sql.= "AND `IsDel` != 1";
			
			$res = self::$db->query($sql);
			$row = $res->fetch_row();
			
			if ($row[0] > 0)
				return true;
			else
				return false;
		}

		return false;
	}
	
	public function IhisAnswereInPoll($id)
	{
		if (is_array($id))
		{
			if (sizeof($id) < 1 || empty($id[0]))
				return false;
				
			$sql = "SELECT COUNT(*) FROM `".self::$tables['poll_answer'];
			$sql.= "` WHERE `PollID` = '".$this->_ID."' AND `PollAnswerID` IN (".implode(',', $id).") AND `IsDel` != 1";
			$res = self::$db->query($sql);
			$row = $res->fetch_row();
			if ($row[0] != sizeof($id))
				return false;
			
			return true;
		}
		else
		{
			if (!is_numeric($id) || $id < 1)
				return false;
			
			$sql = "SELECT COUNT(*) FROM `".self::$tables['poll_answer'];
			$sql.= "` WHERE `PollID` = '".$this->_ID."' AND `PollAnswerID` = '".intval($id)."' AND `IsDel` != 1";
			
			$res = self::$db->query($sql);
			$row = $res->fetch_row();
			if ($row[0] == 0)
				return false;
			
			return true;
		}
	}
	
	public function __get($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'userid')
			return $this->_UserID;
		elseif ($name == 'uniqueid')
			return $this->_UniqueID;
		elseif ($name == 'type')
			return $this->_Type;
		elseif ($name == 'created')
			return $this->_Created;
		elseif ($name == 'title')
			return $this->_Title;
		elseif ($name == 'isvisible')
			return $this->_IsVisible;
		elseif ($name == 'multimax')
			return $this->_MultiMax;
		elseif ($name == 'multimin')
			return $this->_MultiMin;
		elseif ($name == 'votes')
			return $this->_Votes;
		elseif ($name == 'isclosed')
			return $this->_IsClosed;
		elseif ($name == 'answers')
			return $this->_Answers;
		else
			return null;
	}
	
	public function __isset($name)
	{
		$name = strtolower($name);
		if($name == 'id' || $name == 'userid' || $name == 'uniqueid' || $name == 'type' || $name == 'created' 
			|| $name == 'title' || $name == 'isvisible' || $name == 'multimax' || $name == 'multimin' ||$name == 'votes'
			|| $name == 'isclosed')
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
		if ($name == 'title')
			$this->_Title = $value;
		if ($name == 'type')
			$this->_Type = $value;
		elseif ($name == 'isvisible')
			$this->_IsVisible = $value;
		elseif ($name == 'multimax')
			$this->_MultiMax = $value;
		elseif ($name == 'multimin')
			$this->_MultiMin = $value;
		elseif ($name == 'userid' && $this->_ID == 0)
			$this->_UserID = $value;
		elseif ($name == 'uniqueid' && $this->_ID == 0)
			$this->uniqueid = $value;
		elseif ($name == 'id')
			$this->_ID = $value;
		elseif ($name == 'isclosed')
			$this->_IsClosed = $value;
	}
}

class AppPollAnswer {
	private $_ID;
	private $_Parent;
	private $_Text;
	private $_Votes;

	public function __construct($parent, $id = 0)
	{
		$this->_ID = $id;
		$this->_Parent = $parent;
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		$this->_Parent->UpdateAnswer($this);

		return true;
	}
	
	public static function Remove($id)
	{
		global $OBJECTS;
		
		$this->_Parent->RemoveAnswer($id);
		
		return true;
	}
	
	public static function CreateInstance($data, $parent)
	{
		$obj = new self($parent, $data['id']);
		$obj->_Text = $data['text'];
		$obj->_Votes = $data['votes'];
		
		return $obj;
	}
	
	public function __get($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'parent')
			return $this->_Parent;
		elseif ($name == 'text')
			return $this->_Text;
		elseif ($name == 'votes')
			return $this->_Votes;
		else
			return null;
	}
	
	public function __isset($name)
	{
		$name = strtolower($name);
		if($name == 'id' || $name == 'parent' || $name == 'text' || $name == 'votes')
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
		if ($name == 'text')
			$this->_Text = $value;
	}
}

class AppPollIterator implements Countable, Iterator
{
	private $data = null;
	private $objetcs = null;
	
	public function __construct($db, $tables, $filter)
	{

		$sql = "SELECT * FROM ".$tables['poll'];
		$sql.= " WHERE ";
		if (sizeof($filter['fields']) > 0)
		{
			$sqlt = array();
			
			if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
				$sqlt[] = " `UniqueID` = '".$filter['fields']['uniqueid']."' ";
			
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
			
			if (isset($filter['fields']['pollid']) && is_numeric($filter['fields']['pollid']))
				$sqlt[] = " `PollID` = '".$filter['fields']['pollid']."' ";
			
			if (isset($filter['fields']['isclosed']) && is_numeric($filter['fields']['isclosed']))
				$sqlt[] = " `IsClosed` = '".$filter['fields']['isclosed']."' ";
			
			$sqlt[] = " `IsDel` = 0 ";
			$sql.= implode(' AND ', $sqlt);

		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= " ORDER BY ";
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ($f['field'] == 'created')
					$f['field'] = 'Created';
				
				if ($f['dir'] == 'asc')
					$f['dir'] = 'ASC';
				
				if ($f['dir'] == 'desc')
					$f['dir'] = 'DESC';
				
				$sqlt[] = " `".$f['field']."` ".$f['dir']." ";
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

		
		$res = $db->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$list = array();
			$list['id'] = $row['PollID'];
			$list['userid'] = $row['UserID'];
			$list['uniqueid'] = $row['UniqueID'];
			$list['type'] = $row['Type'];
			$list['created'] = $row['Created'];
			$list['title'] = $row['Title'];
			$list['isvisible'] = $row['IsVisible'];
			$list['multimax'] = $row['MultiMax'];
			$list['multimin'] = $row['MultiMin'];
			$list['votes'] = $row['Votes'];
			$list['isclosed'] = $row['IsClosed'];
			
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
            $this->objects[$k] = AppPoll::CreateInstance($this->data[$k]);
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

class AppPollAnswerIterator implements Countable, Iterator
{
	private $data 		= null;
	private $objetcs 	= null;
	private $parent 	= null;
	
	public function __construct($db, $tables, $parent)
	{
		$sql = "SELECT * FROM `".$tables['poll_answer']."` ";
		$sql.= "WHERE ";
		$sql.= "`PollID` = '".$parent->ID."' ";
		$sql.= "AND `IsDel` = 0";
		
		$res = $db->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$list = array();
			$list['id'] = $row['PollAnswerID'];
			$list['text'] = $row['Text'];
			$list['votes'] = $row['Votes'];
			
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
            $this->objects[$k] = AppPollAnswer::CreateInstance($this->data[$k], $this->parent);
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