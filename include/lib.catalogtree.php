<?

LibFactory::GetStatic('textutil');

class lib_CatalogTree
{
	public static $db = null;
	public static $prefix = array();
	public static $_regid = null;
	public static $_siteid = null;
	private static $_instance = null;

	function __construct() {
	}
	
	public function Init($db, $prefix = '', $regid = null, $siteid = null) {

		if ( self::$_instance !== null )
			return;

		if ( self::$_instance === null )
			self::$_instance = $this;

		if ( empty($db) )
			$db = 'catalog';

		if ( is_string($db) )
			 self::$db = DBFactory::GetInstance($db);
		else
			 self::$db = $db;

		self::$prefix = $prefix;
		self::$_regid = $regid;
		self::$_siteid = $siteid;
	}
	
	public function setRegionID($regid) {
		self::$_regid = $regid;
	}
	
	public function setSiteID($siteid) {
		self::$_siteid = $siteid;
	}

	static function &getInstance () {

        if ( self::$_instance === null ) {
            $cl = __CLASS__;
            self::$_instance = new $cl();
        }

        return self::$_instance;
    }

	public function GetAll($index) {
		return CatalogTreeNode::CreateInstance($index, self::$_regid, self::$_siteid);
	}
	
	public function GetByPath($path) {		
		return CatalogTreeNode::CreateInstanceByPath($path, self::$_regid, self::$_siteid);
	}

	public function normalizeNameID($name_id, $parent = null, $excl = null, $sites = array()) {

		$name_id = TextUtil::Translit($name_id);
		$name_id = preg_replace("/[^a-z0-9_]/i", "_", $name_id);
		$name_id = trim($name_id,'_');

		if ( empty($name_id) )
			return false;

		$sql = 'SELECT t.TreeID FROM '.lib_CatalogTree::$prefix.'tree t';
		if ( is_array($sites) && sizeof($sites) )
			$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON(r.TreeID = t.TreeID)';
		$sql .= ' WHERE t.TreeNameID = \''.$name_id.'\'';
		
		if ( $parent !== null )
			$sql .= ' AND t.ParentID = '.(int) $parent;
		if ( $excl !== null )
			$sql .= ' AND t.TreeID != '.(int) $excl;
		
		if ( is_array($sites) && sizeof($sites) )
			$sql .= ' AND r.SiteID IN('.implode(',', $sites).') ';

		$res = lib_CatalogTree::$db->query($sql);
		if ( $res && $res->num_rows )
			return false;

		return $name_id;
	}

	
	public function UpdateChildCount($index) {
	
		if ( $index === null || $index <= 0 )
			return ;
	
		$node = self::getInstance()->GetAll((int) $index);

		if ( $node === null )
			return ;
	
		$sql = 'SELECT COUNT(*) FROM '.self::$prefix.'tree WHERE ParentID='.$index;
		$res = self::$db->query($sql);

		$count = 0;
		if ( !$res || !$res->num_rows)
			return ;
		
		list($count) = $res->fetch_row();
		
		$sql = 'UPDATE '.self::$prefix.'tree SET ChildCount = '.$count;
		$sql .= ' WHERE TreeID = '.$index;
		self::$db->query($sql);
		
		$this->UpdateChildCount($node->parent->id);
	}
	
	///////////////////// Функции для работы с группами сайтов //////////////////////
	
	//создаёт новую группу
	public function AddSitesGroup($name) {
		
		if ( empty($name) )
			return false;
	
		$sql = "INSERT IGNORE INTO ".self::$prefix."sites_groups(`Name`)";
		$sql.= " VALUES ('".addslashes($name)."')";
		
		self::$db->query($sql);
		
		return self::$db->insert_id;		
	}
	
	
	//добавляет список сайтов в группу
	public function AddSitesGroupRefs($groupid, array $sites) {
		
		if ( empty($sites) )
			return false;
	
		foreach ($sites as $site){
			
			$sql = "INSERT IGNORE INTO ".self::$prefix."sites_groups_ref";
			$sql.= " SET GroupID = ".$groupid.", SiteID = ".$site;;
		
			self::$db->query($sql);
		}
		
		return true;		
	}
	
	//удаляет сайты из списка в группе
	public function DelSitesGroupRefs($groupid, array $sites) {
	
		if ( empty($sites) )
			return false;
	
		$sql = "DELETE FROM ".self::$prefix."sites_groups_ref";
		$sql.= " WHERE GroupID = ".$groupid." AND SiteID IN (".implode(",", $sites).")";
		
		self::$db->query($sql);
			
		return true;		
	}
	
	//удаляет список групп
	public function DelSitesGroups(array $groups) {
	
		if ( empty($groups) )
			return false;
	
		//удаляем связи
		$sql = "DELETE FROM ".self::$prefix."sites_groups_ref";
		$sql.= " WHERE GroupID IN (".implode(",", $groups).")";
		
		self::$db->query($sql);
		
		//удаляем группы
		$sql = "DELETE FROM ".self::$prefix."sites_groups";
		$sql.= " WHERE GroupID IN (".implode(",", $groups).")";
		
		self::$db->query($sql);
			
		return true;		
	}		
	
	//получает список групп
	public function GetSitesGroups() {
		
		$groups = array();
	
		$sql = "SELECT grp.`GroupID`, grp.`Name`, count(ref.GroupID) as `Count`";
		$sql.= " FROM ".self::$prefix."sites_groups_ref ref, ".self::$prefix."sites_groups grp";
		$sql.= " WHERE ref.GroupID=grp.GroupID";
		$sql.= " GROUP BY ref.GroupID";
		$sql.= " ORDER BY grp.`Name` ASC";
				
		$res = self::$db->query($sql);
		
		while($row = $res->fetch_assoc()){
			$groups[$row['GroupID']] = $row;
		}
		
		return $groups;
	}
	
	//получает имя группы по id
	public function GetSitesGroupName($groupid) {
		
		$groups = array();
	
		$sql = "SELECT `GroupID`, `Name` FROM ".self::$prefix."sites_groups";
		$sql.= " WHERE GroupID = ".intval($groupid);
				
		$res = self::$db->query($sql);
		
		if ($row = $res->fetch_assoc()){
			return $row['Name'];
		}
		
		return null;
	}
	
	//получает список сайтов в группе
	public function GetSitesByGroupID($groupid) {
		
		$sites = array();
					
		$sql = "SELECT `SiteID` FROM ".self::$prefix."sites_groups_ref";
		$sql.= " WHERE GroupID = ".intval($groupid);
				
		$res = self::$db->query($sql);
		
		while($row = $res->fetch_assoc()){
			$sites[] = $row['SiteID'];
		}
		
		return $sites;
	}
	
	//////////////////////////////////////////////////////////////////////////
}

class CatalogTreeNode
{
	private $_Nodes = array();
	private $_Parent = array();
	private $_fields = array();
	private $_regid = null;
	private $_siteid = null;

	public function __construct($fields, $parent = null, $regid = null, $siteid = null) {
		$this->_fields = array_change_key_case($fields, CASE_LOWER);
		
		$this->_Nodes = null;

		if ( $parent === null )
			$this->_Parent = $this->_fields['parentid'];
		else
			$this->_Parent = $parent;
			
		if ( $regid !== null)
			$this->_regid = $regid;
			
		if ( $siteid !== null)
			$this->_siteid = $siteid;
	}

	public static function CreateInstance($index, $regid, $siteid = null) {

		if( empty($index) )
			return new self(array(
				'TreeID'		=> 0,
				'TreeNameID'	=> '',
				'Name'			=> '',
				'Describe'		=> '',
				'ParentID'		=> null,
				'TreePath'		=> '',
				'Ord'			=> 0,
				'ChildCount'	=> 0,
				'Created'		=> '',
				'LastUpdate'	=> '',
				'IsVisible'		=> '',
			), null, $regid, $siteid);

		if ( is_int($index) ) {
			
			$sql = 'SELECT t.* FROM '.lib_CatalogTree::$prefix.'tree t';
			if ( $regid !== null )
				$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = t.TreeID) ';
			$sql .= ' WHERE t.TreeID='.$index;
			if ( $regid !== null )
				$sql .= ' AND r.RegionID = '.(int) $regid;
			if ( $siteid !== null )
				$sql .= ' AND r.SiteID = '.(int) $siteid;
		} else {
			$sql = 'SELECT t.* FROM '.lib_CatalogTree::$prefix.'tree t';
			if ( $regid !== null )
				$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = t.TreeID) ';
			$sql .= ' WHERE t.TreeNameID=\''.addslashes($index).'\'';
			if ( $regid !== null )
				$sql .= ' AND r.RegionID = '.(int) $regid;
			if ( $siteid !== null )
				$sql .= ' AND r.SiteID = '.(int) $siteid;
		}	

		$res = lib_CatalogTree::$db->query($sql);
		if($row = $res->fetch_assoc()) {
			$row['ParentID'] = (int) $row['ParentID'];
			return new self($row, null, $regid, $siteid);
		}

		return null;
	}
	
	public static function CreateInstanceByPath($path, $regid, $siteid = null) {

		if( empty($path) )
			return new self(array(
				'TreeID'		=> 0,
				'TreeNameID'	=> '',
				'Name'			=> '',
				'Describe'		=> '',
				'ParentID'		=> null,
				'TreePath'		=> '',
				'Ord'			=> 0,
				'ChildCount'	=> 0,
				'Created'		=> '',
				'LastUpdate'	=> '',
				'IsVisible'		=> '',
			), null, $regid, $siteid);

		$path = explode('/', trim($path,'/'));
			
		$nnID = array_pop($path);
		$pnnID = array_pop($path);
			
		if ( !empty($pnnID) ) {
			$sql = 'SELECT c.* FROM '.lib_CatalogTree::$prefix.'tree c';
			$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree p ON (p.TreeID = c.ParentID) ';
			if ( $regid !== null || $siteid !== null)
				$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = c.TreeID) ';
			$sql .= ' WHERE c.TreeNameID=\''.addslashes($nnID).'\' AND p.TreeNameID =\''.addslashes($pnnID).'\'';
			if ( $regid !== null )
				$sql .= ' AND r.RegionID = '.(int) $regid;
			if ( $siteid !== null )
				$sql .= ' AND r.SiteID = '.(int) $siteid;
		} else {
			$sql = 'SELECT t.* FROM '.lib_CatalogTree::$prefix.'tree t';
			if ( $regid !== null || $siteid !== null)
				$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = t.TreeID) ';
			$sql .= ' WHERE t.TreeNameID=\''.addslashes($nnID).'\'';
			if ( $regid !== null )
				$sql .= ' AND r.RegionID = '.(int) $regid;
			if ( $siteid !== null )
				$sql .= ' AND r.SiteID = '.(int) $siteid;
		}
				
		$res = lib_CatalogTree::$db->query($sql);
		if($row = $res->fetch_assoc()) {
			$row['ParentID'] = (int) $row['ParentID'];
			return new self($row, null, $regid, $siteid);
		}

		return null;
	}

	/**
	 * Создать ветку
	 *
	 * @param data array массив данных поле=>строка
	 */
	public function Create(array $data, $normalizeNameID = true) {

		if ( !sizeof($data) )
			return false;

		$data = array_change_key_case($data, CASE_LOWER);
		if ( empty($data['name']) )
			return false;

		if ( $normalizeNameID === true && false === ($data['treenameid'] = lib_CatalogTree::normalizeNameID($data['treenameid'], $this->_fields['treeid'])) )
			return false;

		$sql = 'INSERT INTO '.lib_CatalogTree::$prefix.'tree SET';
		//foreach (array_keys($this->_fields) as $name ) {
		foreach ($data as $name => $value ) {

			if ( $name == 'treeid' || $name == 'treepath' || $name == 'parentid'  )
				continue;

			//if ( !array_key_exists($name, $data) )
				//continue;

			if ( is_int($value) )
				$sql .= ' `'.$name.'` = '.$value.',';
			else
				$sql .= ' `'.$name.'` = \''.addslashes($value).'\',';
		}
		$sql.= ' ParentID='.$this->_fields['treeid'].', Created = NOW()';

		$res = lib_CatalogTree::$db->query($sql);
		if ( !$res )
			return false;

		$id = lib_CatalogTree::$db->insert_id;
		if($this->_fields['treeid'] === 0)
			$path = $id;
		else
			$path = $this->_fields['treepath'].$id;

		$sql = 'UPDATE '.lib_CatalogTree::$prefix.'tree SET ';
		$sql.= 'TreePath=\''.$path.',\' WHERE TreeID='.$id;
		lib_CatalogTree::$db->query($sql);
		lib_CatalogTree::getInstance()->UpdateChildCount($this->_fields['treeid']);
		
		return $id;
	}
	
	/**
	 * Обновить ветку
	 *
	 * @param data array массив данных поле=>строка
	 */
	public function Update(array $data, $normalizeNameID = true) {

		if ( !sizeof($data) )
			return false;

		$data = array_change_key_case($data, CASE_LOWER);
		if ( isset($data['name']) && empty($data['name']) )
			return false;

		if ( isset($data['treenameid']) && $normalizeNameID === true && false === ($data['treenameid'] = lib_CatalogTree::normalizeNameID($data['treenameid'], $this->_fields['parentid'], $this->ID)) )
			return false;

		$sql = 'UPDATE '.lib_CatalogTree::$prefix.'tree SET';		
		foreach (array_keys($this->_fields) as $name ) {

			if ( $name == 'treeid' || $name == 'treepath' || $name == 'parentid'  )
				continue;

			if ( !array_key_exists($name, $data) )
				continue;

			if ( is_int($data[$name]) )
				$sql .= ' `'.$name.'` = '.$data[$name].', ';
			else
				$sql .= ' `'.$name.'` = \''.addslashes($data[$name]).'\', ';
		}
		$sql.= ' LastUpdate = NOW() ';
		$sql.= ' WHERE TreeID='.$this->_fields['treeid'];
		
		$res = lib_CatalogTree::$db->query($sql);
		if ( !$res )
			return false;
			
		return true;
	}

	/**
	 * Удаляет ветку и всех детей
	 */
	public function Delete() {

		if ( empty($this->_fields['treeid']) )
			return ;

		if ( $this->Parent !== null )
			$parent = $this->Parent->ID;

		$ids = $this->GetAsPlainArray();
		if( is_array($ids) ) {
			$sql = 'DELETE FROM '.lib_CatalogTree::$prefix.'tree ';
			$sql.= ' WHERE TreeID IN('.implode(',', $ids).')';
			lib_CatalogTree::$db->query($sql);
			
			$sql = 'DELETE FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
			$sql.= ' WHERE TreeID IN('.implode(',', $ids).')';
			lib_CatalogTree::$db->query($sql);

		}

		if ( isset($parent) && $parent > 0 )
			lib_CatalogTree::getInstance()->UpdateChildCount($parent);
	}

	// Удаляет связь ветки с регионом
	public function RemoveRegionRefs($regid = null, $siteid = null) {

		$sql = 'DELETE FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
		$sql.= ' WHERE TreeID = '.$this->id;
		if ( $regid !== null && $regid > 0 )
			$sql .= ' AND RegionID = '.(int) $regid;
		if ( $siteid !== null && $siteid > 0)
			$sql .= ' AND SiteID = '.(int) $siteid;

		return lib_CatalogTree::$db->query($sql);
	}
	
	// Удаляет связь ветки с сайтами
	public function RemoveSitesRefs($sites = array()) {
		
		if(empty($sites))
			return true;
		
		$sql = 'DELETE FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
		$sql.= ' WHERE TreeID = '.$this->id;		
		$sql.= ' AND SiteID IN ('.implode(",", $sites).')';

		return lib_CatalogTree::$db->query($sql);		
	}
	
	// Создает связи ветки с регионами из списка
	public function CreateRegionRefs($regions) {
		
		if ( !is_array($regions) || !sizeof($regions) )
			return false;

		foreach($regions as $regid) {
			if ( $regid <= 0 )
				continue;
			
			$sql = 'INSERT IGNORE INTO '.lib_CatalogTree::$prefix.'tree_region_refs ';
			$sql.= ' SET TreeID = '.$this->id.', ';
			$sql.= ' RegionID = '.(int) $regid;
			lib_CatalogTree::$db->query($sql);
		}
		return true;
	}
	
	// Создает связи ветки с сайтами из списка
	public function CreateSitesRefs($sites) {
		
		if ( !is_array($sites) || !sizeof($sites) )
			return false;

		foreach($sites as $site) {
			
			$n = STreeMgr::GetNodeByID($site);
			
			if ( empty($n) )
				continue;
			
			$sql = 'INSERT IGNORE INTO '.lib_CatalogTree::$prefix.'tree_region_refs ';
			$sql.= ' SET TreeID = '.$this->id;
			$sql.= ', RegionID = '.$n->Regions;
			$sql.= ', SiteID = '.$n->ID;
			lib_CatalogTree::$db->query($sql);
		}
		return true;
	}
	
	// Достает связи ветки с регионами
	public function GetRegionRefs() {

		$regions = array();
		$sql = 'SELECT DISTINCT(RegionID) FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
		$sql.= ' WHERE TreeID = '.$this->id.' ';
		$res = lib_CatalogTree::$db->query($sql);

		if ( !$res || !$res->num_rows )
			return $regions;
			
		while (false != ($row = $res->fetch_row())) {
			$regions[] = $row[0];
		}

		return $regions;
	}
	
	// Достает связи ветки с сайтами
	public function GetSiteRefs() {

		$sites = array();
		$sql = 'SELECT SiteID FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
		$sql.= ' WHERE TreeID = '.$this->id.' ';
		$sql.= ' ORDER BY RegionID ASC';
		$res = lib_CatalogTree::$db->query($sql);

		if ( !$res || !$res->num_rows )
			return $sites;
			
		while (false != ($row = $res->fetch_assoc())) {
			$sites[] = $row['SiteID'];
		}

		return $sites;
	}
	
	// Достает количество связей ветки с регионами
	public function GetRegionRefsCount() {

		$count = 0;
		$sql = 'SELECT count(*) FROM (SELECT DISTINCT(RegionID) FROM '.lib_CatalogTree::$prefix.'tree_region_refs ';
		$sql.= ' WHERE TreeID = '.$this->id.') as cnt_table ';
		
		$res = lib_CatalogTree::$db->query($sql);

		if ( $res && $res->num_rows )
			list($count) = $res->fetch_row();

		return $count;
	}
	
	/**
	 * Возвращает идентификаторы интересов
	 * Вытянет все ноды рекурсивно
	 */
	public function GetAsPlainArray()
	{
		$array = array($this->id);
		if(is_array($this->Nodes) && count($this->Nodes) > 0)
			foreach($this->Nodes as $n)
				$array = array_merge($array, $n->GetAsPlainArray());
		return $array;
	}

	public function GetNodesList($filter = array()) {
		
		if ( !array_key_exists($filter['field'], $this->_fields) )
			$filter['field'] = 'Name';

		// Порядок сортировки
		$filter['dir'] = strtoupper($filter['dir']);	
		if ( $filter['dir'] != 'ASC' && $filter['dir'] != 'DESC' )
			$filter['dir'] = 'ASC';
		
		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;
		
		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;
			
		if( !isset($filter['flags']['IsVisible']) || !in_array($filter['flags']['IsVisible'], array(0,1)) )
			$filter['flags']['IsVisible'] = -1;
		
		$sql = 'SELECT * FROM '.lib_CatalogTree::$prefix.'tree WHERE ';
		$sql.= ' ParentID='.$this->_fields['treeid'];
		
		if ( $filter['flags']['IsVisible'] != -1)
			$sql .= ' AND IsVisible = '.$filter['flags']['IsVisible'];

		$sql .= ' ORDER by '.$filter['field'].' '.$filter['dir'];
		
		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}
		
		$res = lib_CatalogTree::$db->query($sql);
		$nodes = array();
		while(false != ($row = $res->fetch_assoc())) {
			if ( $filter['flags']['as_object'] === true ) {
				$row['ParentID'] = (int) $row['ParentID'];
				$nodes[] = new self($row, $this);
			} else
				$nodes[] = $row;
		}
	
		return $nodes;
	}
	
	public function GetNodesCount() {
		
		$sql = 'SELECT COUNT(*) FROM '.lib_CatalogTree::$prefix.'tree WHERE ';
		$sql.= ' ParentID='.$this->_fields['treeid'];
		
		$res = lib_CatalogTree::$db->query($sql);
		$count = 0;
		
		if ( $res && $res->num_rows )
			list($count) = $res->fetch_row();
	
		return $count;
	}
	
	public function __get($name) {
		$name = strtolower($name);
		switch($name)
		{
			case 'id':
				return $this->_fields['treeid'];
			case 'nameid':
				return $this->_fields['treenameid'];
			case 'name':
				return $this->_fields['name'];
			case 'describe':
				return $this->_fields['describe'];
			case 'created':
				return $this->_fields['created'];
			case 'lastupdate':
				return $this->_fields['lastupdate'];
			case 'nodes':	
				if($this->_Nodes === null)
				{
					$sql = 'SELECT t.* FROM '.lib_CatalogTree::$prefix.'tree t ';
					
					if ( $this->_regid !== null || $this->_siteid !== null )
						$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = t.TreeID) ';
					
					$sql.= ' WHERE t.ParentID='.$this->_fields['treeid'];
					
					if ( $this->_regid !== null )
						$sql .= ' AND r.RegionID = '.(int) $this->_regid;
					
					if ( $this->_siteid !== null )
						$sql .= ' AND r.SiteID = '.(int) $this->_siteid;
					
					$sql.= ' ORDER BY t.Ord, t.Name';
					
					$res = lib_CatalogTree::$db->query($sql);
					$this->_Nodes = array();
					while(false != ($row = $res->fetch_assoc()))
						$this->_Nodes[] = new self($row, $this, $this->_regid, $this->_siteid);
				}
				return $this->_Nodes;
			case 'parent':
				if(is_int($this->_Parent)) // родитель установлен, но данные не загружены
				{
					if($this->_Parent == 0)
						$this->_Parent = self::CreateInstance(0, $this->_regid);
					else {

						$sql = 'SELECT t.* FROM '.lib_CatalogTree::$prefix.'tree t ';
						if ( $this->_regid !== null || $this->_siteid !== null)
							$sql .= ' INNER JOIN '.lib_CatalogTree::$prefix.'tree_region_refs r ON (r.TreeID = t.TreeID) ';
						$sql.= ' WHERE t.TreeID='.$this->_Parent;
						if ( $this->_regid !== null )
							$sql .= ' AND r.RegionID = '.(int) $this->_regid;
						if ( $this->_siteid !== null )
							$sql .= ' AND r.SiteID = '.(int) $this->_siteid;

								//if ( $_GET['debug'] > 2 ) {
								//echo $sql;
								//var_dump($this->_regid);
								//}
							
						$res =  lib_CatalogTree::$db->query($sql);
						if(false != ($row = $res->fetch_assoc())) {
							$row['ParentID'] = (int) $row['ParentID'];
							$this->_Parent = new self($row, null, $this->_regid, $this->_siteid);
						} else
							$this->_Parent = null;
					}
				}
				return $this->_Parent;
			case 'path':
				return $this->_fields['treepath'];
			case 'ord':
				return $this->_fields['ord'];
			case 'order':
				return $this->_fields['ord'];
			case 'visible':
				return $this->_fields['isvisible'];
			case 'childcount':
				return $this->_fields['childcount'];
			case 'fields':
				return $this->_fields;
			case 'regionrefscount':
				return $this->GetRegionRefsCount();
			default:
				if ( isset($this->_fields[$name]) )
					return $this->_fields[$name];
				return null;
		}
	}

	public function __set($name, $value)
	{
	}

	public function __isset($name)
	{
	}

	public function __unset($name)
	{
	}
}
?>