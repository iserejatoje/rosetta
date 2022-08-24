<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/menu/menu.php');

class MenuMgr
{
	private $_menu = array();

	public $_db			= null;
	public $_tables		= array(
		'menu'		=> 'menu',
	);

	private $_cache		= null;

	public static $GROUPS = [
		1 => 'Группа 1',
		2 => 'Группа 2',
		3 => 'Группа 3',
		4 => 'Группа 4',
	];

	public function __construct()
	{

		$this->_db = DBFactory::GetInstance($this->dbname);
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);

		$this->_cache = $this->getCache();
	}

	public function getCache() 
	{
		LibFactory::GetStatic('cache');
			
		$cache = new Cache();
		$cache->Init('memcache', 'menumgr');
		
		return $cache;
	}
	
	static function &getInstance ($caching = true) 
	{
        static $instance;

        if (!isset($instance)) {		
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }

    /**
	 * Сформировать объект по массиву данных
	 *
	 * @param array $info - массив полей со значениями
	 * @return Объект Menu. В случае ошибки вернет null
	 */
	private function _menuObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$menu = new Menu($info);
		if (isset($info['menuid']))
			$this->_menu[ $info['menuid'] ] = $menu;

		return $menu;
	}

	/**
	* @return Объект Menu. В случае ошибки вернет null
	*/
	public function GetMenu($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( isset($this->_menu[$id]) )
			return $this->_menu[$id];

		$info = false;

		$cacheid = 'menu_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;
	
		if ($info === false)
		{
			$sql = 'SELECT * FROM '.$this->_tables['menu'].' WHERE MenuID = '.$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$menu = $this->_menuObject($info);
		return $menu;
	}

	/**
	* @return id of added menu or false
	*/
	public function AddMenu(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		unset($info['menuid']);

		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['menu'].' SET ' . implode(', ', $fields);
		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	/**
	* @return id of added menu item or false
	*/
	public function UpdateMenu(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);


		if ( !sizeof($info) || !Data::Is_Number($info['menuid']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
		{
			$fields[] = "`$k` = '".addslashes($v)."'";
		}
		$sql = 'UPDATE '.$this->_tables['menu'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE MenuID = '.$info['menuid'];

		if($this->_db->query($sql) !== false)
		{
			$cache = $this->getCache();
			$cache->Remove('menu_'.$info['menuid']);

			unset($this->_menu[$info['menuid']]);
			return $info['menuid'];
		}
			
		return false;
	}

	/**
	* @return bool
	*/
	public function RemoveMenu($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$sql = 'DELETE FROM '.$this->_tables['menu'].' WHERE MenuID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('menu_'.$id);

			unset($this->_menu[$id]);
			return true;
		}

		return false;
	}

	/**
	 * Get array of first-level menu objects with specified sectionID
	 * @param int $sectionID - sectionID of docs
	 * @return array of Doc objects or null
	 **/
	public function GetVisibleMenuBySectionID($sectionID, $parentID = 0, $isVisible = 1)
	{
		$sectionID = intval($sectionID);
		$parentID = intval($parentID);
		$isVisible = intval($isVisible);

		if ($sectionID <= 0)
			return null;

		if ( $sectionID !== null && !Data::Is_Number($sectionID) )
			return null;
		if ( $parentID !== null && !Data::Is_Number($parentID) )
			return null;
		if ( $isVisible !==-1 && $isVisible !== 0 && $isVisible !==1 )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['menu'];
		$sql .= ' WHERE SectionID = '.$sectionID;
		$sql .= ' And ParentID = '.$parentID;
		if($isVisible != -1)
			$sql .= ' AND IsVisible = '.$isVisible;
		$sql .= ' ORDER BY `Ord` ASC';

		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows )
			return null;

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ( isset($this->_menu[$row['MenuID']]) )
				$row = $this->_menu[$row['MenuID']];
			else
				$row = $this->_menuObject($row);

			$result[] = $row;
		}

		return $result;
	}
	
	/**
	 * Get array of first-level menu objects with specified sectionID
	 * @param int $sectionID - sectionID of docs
	 * @return array of Doc objects or null
	 **/
	public function GetMenuBySectionID($sectionID, $parentID = 0)
	{
		$sectionID = intval($sectionID);
		$parentID = intval($parentID);

		if ($sectionID <= 0)
			return null;

		if ( $sectionID !== null && !Data::Is_Number($sectionID) )
			return null;
		if ( $parentID !== null && !Data::Is_Number($parentID) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['menu'];
		$sql .= ' WHERE SectionID = '.$sectionID;
		$sql .= ' And ParentID = '.$parentID;
		$sql .= ' ORDER BY `Ord` ASC';


		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows )
			return null;

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ( isset($this->_menu[$row['MenuID']]) )
				$row = $this->_menu[$row['MenuID']];
			else
				$row = $this->_menuObject($row);

			$result[] = $row;
		}

		return $result;
	}
	

	/**
	 * Gets array of menu objects with ParentID = id
	 * @param int $id - id of parent menu
	 * @return array of menu objects or null
	 **/
	public function GetChildren($id)
	{
		if ( !Data::Is_Number($id) )
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['manu'];
			$sql .= ' WHERE ParentID ='.$id;
			$sql .= ' ORDER BY `Ord` ASC';
		if ( false === ($res = $this->_db->query($sql)))
			return null;

		if (!$res->num_rows )
			return null;

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ( isset($this->_menu[$row['MenuID']]) )
				$row = $this->_menu[$row['MenuID']];
			else
				$row = $this->_menuObject($row);

			$result[] = $row;

		}
		return $result;
	}
}