<?php
class AppNews {
	
	public static $db = null;
	public static $tables = null;
	public static $uniqueid = null;
	private $_ID;
	private $_Title;
	private $_Text;
	private $_Created;
	private $_UniqueID;
	private $_IsVisible;
	private $_IsSticked;
	private $_UserID;
	private $_Image;
	private $_IsComments;
	
	public function __cunstruct()
	{
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		if ($this->_ID == 0)
		{
			$sql = "INSERT INTO `".self::$tables['article']."` ";
			$sql.= "SET `UniqueID` = '".$this->_UniqueID."', ";
			$sql.= "`UserID` = '".$this->_UserID."', ";
			$sql.= "`Created` = NOW(), ";
			$sql.= "`Title` = '".addslashes($this->_Title)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsSticked` = '".addslashes($this->_IsSticked)."', ";
			$sql.= "`IsComments` = '".addslashes($this->_IsComments)."'";
		}
		else
		{
			$sql = "UPDATE `".self::$tables['article']."` ";
			$sql.= "SET ";
			$sql.= "`Title` = '".addslashes($this->_Title)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsSticked` = '".addslashes($this->_IsSticked)."', ";
			$sql.= "`IsComments` = '".addslashes($this->_IsComments)."'";
			$sql.= "WHERE `NewsID` = ".$this->_ID;
		}
		
		self::$db->query($sql);
		if ($this->_ID == 0)
			$this->_ID = self::$db->insert_id;

		return true;
	}
	
	public static function Remove($id)
	{
		global $OBJECTS;
		
		$sql = "UPDATE `".self::$tables['article']."` ";
		$sql.= "SET `IsDel` = 1 ";
		$sql.= "WHERE `NewsID` = ".$id;
		
		self::$db->query($sql);
		
		return true;
	}
	
	public static function GetNews($id)
	{
		$sql = "SELECT * FROM `".self::$tables['article']."` ";
		$sql.= "WHERE `NewsID` = ".$id;
		
		$res = self::$db->query($sql);
		if ($res->num_rows == 0)
			return false;
		
		$row = $res->fetch_assoc();
		
		$list = array();
		$list['id'] = $id;
		$list['title'] = $row['Title'];
		$list['text'] = $row['Text'];
		$list['isvisible'] = $row['IsVisible'];
		$list['issticked'] = $row['IsSticked'];
		$list['iscomments'] = $row['IsComments'];
		$list['userid'] = $row['UserID'];
		$list['created'] = $row['Created'];
		$list['uniqueid'] = $row['UniqueID'];
		
		return self::CreateInstance($list);
	}
	
	public static function CreateInstance($data)
	{
		$obj = new self();
		
		$obj->_ID = $data['id'];
		$obj->_Title = $data['title'];
		$obj->_Text = $data['text'];
		$obj->_Created = $data['created'];
		$obj->_UniqueID = $data['uniqueid'];
		$obj->_UserID = $data['userid'];
		$obj->_IsComments = $data['iscomments'];
		$obj->_IsVisible = $data['isvisible'];
		$obj->_IsSticked = $data['issticked'];
		
		return $obj;
	}
	
	public static function GetNewsIterator($filter)
	{
		return new AppNewsIterator(self::$db, self::$tables, $filter);
	}
	
	public function __get($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'title')
			return $this->_Title;
		elseif ($name == 'text')
			return $this->_Text;
		elseif ($name == 'created')
			return $this->_Created;
		elseif ($name == 'uniqueid')
			return $this->_UniqueID;
		elseif ($name == 'isvisible')
			return $this->_IsVisible;
		elseif ($name == 'issticked')
			return $this->_IsSticked;
		elseif ($name == 'userid')
			return $this->_UserID;
		elseif ($name == 'image')
			return $this->_Image;
		elseif ($name == 'iscomments')
			return $this->_IsComments;
		else
			return null;
	}
	
	public function __isset($name)
	{
		$name = strtolower($name);
		if($name == 'id' || $name == 'title' || $name == 'text' || $name == 'created' || $name == 'uniqueid' 
			|| $name == 'isvisible' || $name == 'issticked' || $name == 'userid' || $name == 'image' ||$name == 'iscomments')
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
		elseif ($name == 'text')
			$this->_Text = $value;
		elseif ($name == 'uniqueid')
			$this->_UniqueID = $value;
		elseif ($name == 'isvisible')
			$this->_IsVisible = $value;
		elseif ($name == 'issticked')
			$this->_IsSticked = $value;
		elseif ($name == 'userid')
			$this->_UserID = $value;
		elseif ($name == 'image')
			$this->_Image = $value;
		elseif ($name == 'iscomments')
			$this->_IsComments = $value;
	}
}
class AppNewsIterator implements Countable, Iterator
{
	private $data = null;
	private $objetcs = null;
	
	public function __construct($db, $tables, $filter)
	{

		$sql = "SELECT * FROM ".$tables['article'];
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();
			
			if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
				$sqlt[] = " `UniqueID` = '".$filter['fields']['uniqueid']."' ";
			
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
			
			if (isset($filter['fields']['issticked']) && is_numeric($filter['fields']['issticked']))
				$sqlt[] = " `IsSticked` = '".$filter['fields']['issticked']."' ";
				
			$sqlt[] = " `IsDel` = 0 ";
			$sql.= implode(' AND ', $sqlt);
		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= " ORDER BY ";
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ($f['field'] == 'issticked')
					$f['field'] = 'IsSticked';
				
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
			$list['id'] = $row['NewsID'];
			$list['title'] = $row['Title'];
			$list['text'] = $row['Text'];
			$list['isvisible'] = $row['IsVisible'];
			$list['issticked'] = $row['IsSticked'];
			$list['iscomments'] = $row['IsComments'];
			$list['userid'] = $row['UserID'];
			$list['created'] = $row['Created'];
			$list['uniqueid'] = $row['UniqueID'];
			
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
            $this->objects[$k] = AppNews::CreateInstance($this->data[$k]);
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