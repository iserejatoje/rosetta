<?php
class Comments {

	public static $db = null;
	public static $tables = null;
	public static $uniqueid = null;
	public static $premoderate = null;
	private $_ID;
	private $_Parent;
	private $_Level;
	private $_Name;
	private $_Text;
	private $_Created;
	private $_UniqueID;
	private $_UserID;
	private $_IsNew;
	private $_IsVisible;
	private $_IsHidden;
	private $_IsVisibleDef;
	private $_IsDel;
	private $_VotePlus;
	private $_VoteMinus;
	private $_VoteCount;
	private $_ChildsCount;

	public function __cunstruct()
	{
	}

	public function Update()
	{
		global $OBJECTS;

		if ($this->_ID == 0)
		{
			$this->_Level = 0;
			if ($this->_Parent) {
				if (false != ($comment = AppCommentTree::GetComment($this->_Parent) ) )
					$this->_Level = $comment->level+1;
				else
					return false;
			}

			$this->_Text = preg_replace("/ +/", " ", $this->_Text);

			if ($this->_Text == "")
				return false;

			$sql = "INSERT INTO `".self::$tables['comments']."` ";
			$sql.= "SET `UserID` = '".$this->_UserID."', ";
			$sql.= "`ParentID` = '".$this->_Parent."', ";
			$sql.= "`Level` = '".$this->_Level."', ";
			$sql.= "`Created` = NOW(), ";

			if ($this->_Parent && false !== ($parent = AppCommentTree::GetComment($this->_Parent))) {
				if ($parent->isvisible  != 1 || $parent->ishidden == 1)
					$sql.= "`IsHidden` = 1, ";
			}

			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";

			$this->_IsVisibleDef = 1;
			$this->_IsVisible = 1;
		}
		else
		{
			$sql = "UPDATE `".self::$tables['comments']."` ";
			$sql.= "SET ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Created` = '".addslashes($this->_Created)."', ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
			$sql.= "WHERE `CommentID` = ".$this->_ID;
		}

		if (false !== self::$db->query($sql)) {
			if ($this->_ID == 0) {
				$this->_ID = self::$db->insert_id;

				$this->AddReference($this->_UniqueID);
			}

			if ($this->_IsVisibleDef != $this->_IsVisible)
				$this->_HideChilds($this->_ID, $this->_IsVisible);

			if ( $this->_Parent )
				self::UpdateCount($this->_Parent);

			return true;
		}

		return false;
	}

	public static function UpdateCount($ids) {

		$ids = (array) $ids;
		foreach($ids as $v)
			$v = (int) $v;

		$sql = 'SELECT COUNT(*), ParentID FROM '.self::$tables['comments'].' WHERE ';
		$sql.= ' ParentID IN('.implode(',', $ids).') AND isDel = 0 AND IsVisible = 1 ';

		if ( self::$premoderate )
			$sql.= ' AND isNew = 0 ';

		$sql.= ' GROUP by ParentID';

		if ( false == ($res = self::$db->query($sql)) )
			return ;

		while (false != ($row = $res->fetch_row())) {

			$ids = array_diff($ids, array($row[1]));

			$sql = 'UPDATE '.self::$tables['comments'].' SET ';
			$sql.= ' ChildsCount = '.$row[0];
			$sql.= ' WHERE CommentID = '.$row[1];
			self::$db->query($sql);
		}

		foreach( $ids as $id ) {
			$sql = 'UPDATE '.self::$tables['comments'].' SET ';
			$sql.= ' ChildsCount = 0';
			$sql.= ' WHERE CommentID = '.$id;
			self::$db->query($sql);
		}
	}

	public function GetChildsCount() {

		$sql = 'SELECT COUNT(*) FROM '.self::$tables['comments'].' WHERE ';
		$sql.= ' ParentID = '.$this->_ID.' AND isDel = 0 AND IsVisible = 1 ';

		if ( false == ($res = self::$db->query($sql)) )
			return 0;

		$row = $res->fetch_row();
		return $row[0];
	}

	public function AddReference($uniqueid) {
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

	public function RemoveReference($uniqueid) {
		$uniqueid = (array) $uniqueid;

		foreach ($uniqueid as $id) {

			$sql = 'DELETE FROM `'.self::$tables['ref'].'` WHERE ';
			$sql .= ' `UniqueID` = '.(int) $id;
			$sql .= ' AND `CommentID` = '.$this->_ID;
			self::$db->query($sql);
		}
	}

	public function RemoveAllReference() {

		$sql = 'DELETE FROM `'.self::$tables['ref'].'` WHERE ';
		$sql .= ' `CommentID` = '.$this->_ID;
		self::$db->query($sql);
	}

	public static function UserIsVoted($id, $user)
	{
		global $OBJECTS;

		$sql = "SELECT `UserID` FROM `".self::$tables['votes']."` ";
		$sql.= "WHERE `CommentID` = ".$id." ";

		$res = self::$db->query($sql);
		$row = $res->fetch_row();
		if ($row[0] == $user)
			return true;

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

		$sql = "SELECT count(0) FROM ".self::$tables['votes'];
		$sql.= " WHERE `CommentID` = ".(int) $id;
		$sql.= " AND `UserID` = ".(int) $user;
		
		if (false === ($res = self::$db->query($sql)))
			return false;
		
		$row = $res->fetch_row();
		
		if ($row[0] > 0)
			return false;

		$sql = "UPDATE `".self::$tables['comments']."` ";
		$sql.= "SET `VoteCount` = `VoteCount` + ".intval($result)." ";
		
		if ($result == 1)
			$sql.= ", `VotePlus` = `VotePlus` + 1";
		
		if ($result == -1)
			$sql.= ", `VoteMinus` = `VoteMinus` + 1";

		$sql.= " WHERE `CommentID` = ".$id;
		self::$db->query($sql);

		$sql = "INSERT INTO `".self::$tables['votes']."` ";
		$sql.= " SET `CommentID` = ".(int) $id.", ";
		$sql.= "`UserID` = ".(int) $user.", ";
		$sql.= "`DateVote` = NOW()";
		self::$db->query($sql);

		$sql = "SELECT `VoteCount` FROM `".self::$tables['comments']."` ";
		$sql.= " WHERE `CommentID` = ".$id;
		$res = self::$db->query($sql);
		$row = $res->fetch_row();

		return $row[0];
	}

	public static function Remove($ids)
	{
		global $OBJECTS;

		$ids = (array) $ids;
		if ( !sizeof($ids) )
			return;
		foreach($ids as &$v)
			$v = (int) $v;

		$sql = "UPDATE `".self::$tables['comments']."` ";
		$sql.= "SET `IsDel` = 1, `IsNew` = 0, `ChildsCount` = 0 ";
		$sql.= "WHERE `CommentID` IN(".implode(',', $ids).")";

		self::$db->query($sql);

		$sql = 'SELECT `CommentID` FROM '.self::$tables['comments'].' WHERE ';
		$sql.= ' ParentID IN ('.implode(',', $ids).')';

		$res = self::$db->query($sql);

		if ( $res && $res->num_rows ) {
			$ids = array();

			while ($row = $res->fetch_row()) {
				$ids[] = $row[0];
			}
			self::Remove($ids);
		}

		return true;
	}

	protected static function _HideChilds($ids, $hide)
	{
		global $OBJECTS;

		$hide = intval(!$hide);
		$ids = (array) $ids;
		if ( !sizeof($ids) )
			return;

		foreach($ids as &$v)
			$v = (int) $v;

		$sql = "UPDATE `".self::$tables['comments']."` ";
		$sql.= " SET `IsHidden` = ".$hide;
		$sql.= " WHERE `CommentID` IN(".implode(',', $ids).")";

		self::$db->query($sql);

		$sql = 'SELECT `CommentID` FROM '.self::$tables['comments'].' WHERE ';
		$sql.= ' ParentID IN ('.implode(',', $ids).')';

		$res = self::$db->query($sql);

		if ( $res && $res->num_rows ) {
			$ids = array();

			while ($row = $res->fetch_row()) {
				$ids[] = $row[0];
			}
			self::_HideChilds($ids, !$hide);
		}

		return true;
	}

	public static function GetReferenceList($id)
	{
		$sql = "SELECT `UniqueID` FROM `".self::$tables['ref']."` ";
		$sql.= "WHERE `CommentID` = ".(int) $id;

		$res = self::$db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		$list = array();

		while ($row = $res->fetch_row()) {
			$list[] = $row[0];
		}

		return $list;
	}

	public static function GetComment($id, $array = false)
	{
		$sql = "SELECT c.*, r.UniqueID FROM `".self::$tables['comments']."` as c ";
		$sql.= "INNER JOIN `".self::$tables['ref']."` as r ON(r.`CommentID` = c.`CommentID`) ";
		$sql.= "WHERE c.`CommentID` = ".(int) $id.' LIMIT 1';

		$res = self::$db->query($sql);
		if (!$res || !$res->num_rows)
			return false;

		$list = $res->fetch_assoc();
		LibFactory::GetStatic('datetime_my');

		$list['Created'] = DateTime_My::NowOffset(null, strtotime($list['Created']));

		if ($array === true)
			return $list;

		return self::CreateInstance($list);
	}

	public static function CreateInstance($data)
	{
		$obj = new self();

		$data = array_change_key_case($data, CASE_LOWER);

		$obj->_ID = $data['commentid'];
		$obj->_Parent = $data['parentid'];
		$obj->_Level = $data['level'];
		$obj->_Name = $data['name'];
		$obj->_Text = $data['text'];
		$obj->_Created = $data['created'];
		$obj->_UniqueID = $data['uniqueid'];
		$obj->_UserID = $data['userid'];
		$obj->_IsVisible = $data['isvisible'];
		$obj->_IsHidden = $data['ishidden'];

		if (!$data['isvisible'])
			$obj->_IsHidden = 1;

		$obj->_IsVisibleDef = $obj->_IsVisible;
		$obj->_IsDel = $data['isdel'];
		$obj->_IsNew = $data['isnew'];
		$obj->_VotePlus = $data['voteplus'];
		$obj->_VoteMinus = $data['voteminus'];
		$obj->_VoteCount = $data['votecount'];
		$obj->_ChildsCount = $data['childscount'];

		return $obj;
	}

	public static function GetCommentsCount($filter)
	{
		LibFactory::GetStatic('tree');
		return self::_GetCommentsCount(self::$db, self::$tables, $filter);

	}

	private static function _GetCommentsCount($db, $tables, $filter) {

		$sql = 'SELECT COUNT(*) FROM '.$tables['comments'].' as c ';
		$sql.= 'INNER JOIN `'.$tables['ref'].'` as r ON(r.`CommentID` = c.`CommentID`) ';

		if (sizeof($filter['ref']) > 0){
			$sql .= $filter['ref']['type'].' JOIN `'.$filter['ref']['table'].'` as ref ON(ref.`'.$filter['ref']['field'].'` = r.`UniqueID`) ';
		}

		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();

			if (isset($filter['fields']['parent']) && is_numeric($filter['fields']['parent']))
				$sqlt[] = " c.`ParentID` = '".(int) $filter['fields']['parent']."' ";

			if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
				$sqlt[] = " r.`UniqueID` = '".$filter['fields']['uniqueid']."' ";

			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " c.`IsVisible` = '".$filter['fields']['isvisible']."' ";

			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " c.`IsHidden` = '".intval(!$filter['fields']['isvisible'])."' ";

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

			if (isset($filter['fields']['maxlevel']) && is_numeric($filter['fields']['maxlevel']))
				$sqlt[] = " c.`Level` <= '".$filter['fields']['maxlevel']."' ";

			$sql.= implode(' AND ', $sqlt);

			if ( !empty($filter['ref']['cond']) )
				$sql .= ' AND '.$filter['ref']['cond'];
		} else if ( !empty($filter['ref']['cond']) )
			$sql .= ' WHERE '.$filter['ref']['cond'];

		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY c.`".implode('`, c.`', $filter['group']).'`';
		}

		$res = $db->query($sql);
		if ( !$res || !$res->num_rows )
			return 0;

		$count = $res->fetch_row();
		return $count[0];
	}

	public static function &GetCommentsIndex($filter) {

		$res = self::_GetComments(self::$db, self::$tables, $filter, true);
		if (empty($res))
			return $res;

		LibFactory::GetStatic('datetime_my');

		$result = array();
		while(false != ($row = $res->fetch_assoc())) {
			if (!isset($result[$row['Level']]))
				$result[$row['Level']] = array();

			if (!isset($result[$row['Level']][$row['ParentID']]))
				$result[$row['Level']][$row['ParentID']] = array();

			$result[$row['Level']][$row['ParentID']][] = $row['CommentID'];
		}

		return $result;
	}

	public static function GetComments($filter, $asArray = false)
	{
		LibFactory::GetStatic('tree');
		$list = self::_GetComments(self::$db, self::$tables, $filter);

		if ( $list === null || $asArray === true )
			return $list;

		$tree = new Tree();
		$tree->BuildTree($list);

		return $tree;
	}

	private static function _GetComments($db, $tables, $filter, $is_res = false) {
		global $OBJECTS;
		$sql = 'SELECT c.*, r.`UniqueID` FROM '.$tables['comments'].' as c ';
		$sql.= 'INNER JOIN `'.$tables['ref'].'` as r ON(r.`CommentID` = c.`CommentID`) ';

		if (sizeof($filter['ref']) > 0){

			$sql .= $filter['ref']['type'].' JOIN `'.$filter['ref']['table'].'` as ref ON(ref.`'.$filter['ref']['field'].'` = r.`UniqueID`) ';

		}

		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();

			if (isset($filter['fields']['parent']) && is_numeric($filter['fields']['parent']))
				$sqlt[] = " c.`ParentID` = '".(int) $filter['fields']['parent']."' ";

			if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
				$sqlt[] = " r.`UniqueID` = '".$filter['fields']['uniqueid']."' ";

			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible'])) {
				$sqlt[] = " c.`IsVisible` = '".$filter['fields']['isvisible']."' ";
				$sqlt[] = " c.`IsHidden` = '".intval(!$filter['fields']['isvisible'])."' ";
			}

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

			if (isset($filter['fields']['maxlevel']) && is_numeric($filter['fields']['maxlevel']))
				$sqlt[] = " c.`Level` <= '".$filter['fields']['maxlevel']."' ";

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
		$res = $db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		if ($is_res === true)
			return $res;

		LibFactory::GetStatic('datetime_my');

		while ($row = $res->fetch_assoc())
		{
			$ParentID = $row['ParentID'];
			if (isset($filter['fields']['parent']) && is_numeric($filter['fields']['parent']) && $row['ParentID'] == $filter['fields']['parent'])
				$ParentID = 0;

			$row['Created'] = DateTime_My::NowOffset(null, strtotime($row['Created']));

			$list[$row['CommentID']] = array(
				'parent'	=> $ParentID,
				'data'		=> $row,
				'name'		=> '',
				'count'		=> $row['ChildsCount']
			);
		}

		return $list;
	}

	public static function GetBestComment($filter)
	{
		return self::_GetBestComment(self::$db, self::$tables, $filter);
	}

	private static function _GetBestComment($db, $tables, $filter) {
		$sql = 'SELECT c.*, r.`UniqueID` FROM '.$tables['comments'].' as c ';
		$sql.= 'INNER JOIN `'.$tables['ref'].'` as r ON(r.`CommentID` = c.`CommentID`) WHERE ';

		if (isset($filter['fields']['uniqueid']) && is_numeric($filter['fields']['uniqueid']) && $filter['fields']['uniqueid'] > 0)
			$sql.= ' r.`UniqueID` = \''.$filter['fields']['uniqueid'].'\' AND ';

		if (isset($filter['minvotecount']))
			$sql.= ' c.`VoteCount` >= '.(int) $filter['minvotecount'].' AND c.`IsDel` = 0 ';
		else
			$sql.= ' c.`VoteCount` > 0 AND c.`IsDel` = 0 ';

		if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
			$sql.= ' AND c.`IsVisible` = \''.$filter['fields']['isvisible'].'\' ';

		if ( isset($filter['fields']['isnew']) )
			$sql.= ' AND c.`IsNew` = '.(int) $filter['fields']['isnew'];
		else {
			if ( self::$premoderate )
				$sql.= ' AND c.`IsNew` = 0 ';
		}

		$sql .= ' ORDER by c.`VoteCount` DESC LIMIT 1';

		$list = array();
		$res = $db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$row = $res->fetch_assoc();
		LibFactory::GetStatic('datetime_my');
		$row['Created'] = DateTime_My::NowOffset(null, strtotime($row['Created']));
		return $row;
	}

	public function __get($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_ID;
		elseif ($name == 'parent')
			return $this->_Parent;
		elseif ($name == 'level')
			return $this->_Level;
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
		elseif ($name == 'ishidden')
			return $this->_IsHidden;
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
		elseif ($name == 'childscount')
			return $this->_ChildsCount;
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
		elseif ($name == 'parent')
			$this->_Parent = $value;
		elseif ($name == 'level')
			$this->_Level = $value;
		elseif ($name == 'text')
			$this->_Text = $value;
		elseif ($name == 'uniqueid')
			$this->_UniqueID = $value;
		elseif ($name == 'isvisible')
			$this->_IsVisible = $value;
		elseif ($name == 'ishidden')
			$this->_IsHidden = $value;
		elseif ($name == 'created')
			$this->_Created = $value;
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
		elseif ($name == 'childscount')
			$this->_ChildsCount = $value;
	}
}
