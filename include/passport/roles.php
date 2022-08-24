<?php

/**
 * Управление ролями, добавление, удаление, изменение информации, группировка ролей
 */
class PRoles
{
	/**
	 * Добавить роль
	 *
	 * @param string name имя роли (используемое при проверке)
	 * @param string russian_name русское имя роли (только для отображения)
	 * @param string description описание роли
	 * @param int treeid идентификатор ветки дерева для добавления роли
	 * @return int идентификатор роли
	 */
	static function Add($name, $russian_name, $description, $treeid = 0)
	{
		$sql = "SELECT RoleID FROM ".PUsersMgr::$tables['roles'];
        $sql.= " WHERE Name = '".addslashes($name)."'";
		if (true != ($res = PUsersMgr::$db->query($sql)))
			return 0;

		if ($res->num_rows)
			return -1;

		$sql = "INSERT INTO ".PUsersMgr::$tables['roles'];
		$sql.= " SET Name = '".addslashes($name)."'";
		if (true != ($res = PUsersMgr::$db->query($sql)))
			return 0;

		$RoleID = PUsersMgr::$db->insert_id;

		$sql = "INSERT INTO ".PUsersMgr::$tables['roles_tree_ref']." SET ";
		$sql.= " Name = '".addslashes($russian_name)."'";
		$sql.= " ,Description = '".addslashes($description)."'";
		$sql.= " ,TreeID = ".(int) $treeid;
		$sql.= " ,RoleID = ".(int) $RoleID;
		if (true != ($res = PUsersMgr::$db->query($sql)))
			return 0;

		return $RoleID;
	}

	/**
	 * Удалить роль
	 *
	 * @param int roleid идентификатор роли
	 */
	function Remove($role)
	{
		$sql = "DELETE FROM ".PUsersMgr::$tables['roles'];
		$sql.= " WHERE RoleID = ".(int) $role;
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".PUsersMgr::$tables['roles_tree_ref'];
		$sql.= " WHERE RoleID = ".(int) $role;
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".PUsersMgr::$tables['roles_ref'];
		$sql.= " WHERE RoleID = ".(int) $role;
		PUsersMgr::$db->query($sql);
	}

	/**
	 * Изменить данные о роли (имя роли поменять нельзя)
	 *
	 * @param mixed roleid идентификатор роли
	 * @param string russian_name русское имя роли (только для отображения)
	 * @param string description описание роли
	 * @param int treeid идентификатор ветки дерева для добавления роли
	 */
	function Update($roleid, $russian_name, $description, $treeid = 0)
	{
		$sql = "UPDATE ".PUsersMgr::$tables['roles_tree_ref']." SET ";
        $sql.= " Name = '".addslashes($russian_name)."'";
        $sql.= " ,Description = '".addslashes($description)."'";

		if ($treeid > 0)
			$sql.= " ,TreeID = ".(int) $treeid;

		$sql.= " WHERE RoleID = ".(int) $roleid;
		PUsersMgr::$db->query($sql);
	}

	/**
	 * Получить список ролей
	 *
	 * @param int $treeid - ветка дерева для получения списка ролей (-1 все роли)
	 * @return array (RoleID - идентификатор, TreeID - идентификатор родительской ветки, Name - имя роли, RussianName - русское имя, Description - описание)
	 */
	function GetRoles($treeid = -1, $index = 'TreeID')
	{
		$roles = array();

		$sql = "SELECT r.RoleID, rf.TreeID, r.Name, rf.Name as RussianName, rf.Description ";
		$sql.= " FROM ".PUsersMgr::$tables['roles_tree_ref']." AS rf ";
		$sql.= " INNER JOIN ".PUsersMgr::$tables['roles']." AS r ON r.RoleID = rf.RoleID ";

		if($treeid >= 0)
			$sql.= " WHERE rf.TreeID = ".(int) $treeid;

		if (true != ($res = PUsersMgr::$db->query($sql)))
			return array();

		if ($res->num_rows == 0)
			return array();

		while(false != ($row = $res->fetch_row()))
		{
			if($index == 'TreeID')
				$roles[$row[1]][] = array('RoleID' => $row[0], 'TreeID' => $row[1], 'Name' => $row[2], 'RussianName' => $row[3], 'Description' => $row[4]);
			else
				$roles[$row[0]] = array('RoleID' => $row[0], 'TreeID' => $row[1], 'Name' => $row[2], 'RussianName' => $row[3], 'Description' => $row[4]);
		}

		return $roles;
	}

	/**
	 * Получить дерево групп ролей
	 *
	 * @return Tree дерево объектов
	 */
	function GetTree()
	{
		LibFactory::GetStatic('tree');

		$sql = "SELECT TreeID, ParentID, Name, Description ";
        $sql.= " FROM ".PUsersMgr::$tables['roles_tree'];
        $sql.= " ORDER BY ParentID, Name ";

		$treedata = array();
		if (false != ($res = PUsersMgr::$db->query($sql))) {
			while(false != ($row = $res->fetch_row())) {
				$treedata[$row[0]] = array('parent' => $row[1], 'data' => array('Name' => $row[2], 'Description' => $row[3]), 'name' => $row[0]);
			}
		}

		$tree = new Tree();
		$tree->BuildTree($treedata);
		return $tree;
	}

	/**
	 * Получить дерево групп ролей
	 *
	 * @return Tree дерево объектов
	 */
	function GetFolders()
	{
		$sql = "SELECT TreeID, ParentID, Name, Description ";
        $sql.= " FROM ".PUsersMgr::$tables['roles_tree'];
        $sql.= " ORDER BY ParentID, Name ";

		$treedata = array();
		if (false != ($res = PUsersMgr::$db->query($sql))) {
			while(false != ($row = $res->fetch_row())) {
				$treedata[$row[0]] = array('Parent' => $row[1], 'Name' => $row[2], 'Description' => $row[3], 'TreeID' => $row[0]);
			}
		}
	
		return $treedata;
	}

	/**
	 * Добавить группу ролей
	 *
	 * @param string name - имя группы
	 * @param string description - описание группы
	 * @param int parentid - родитель
	 * @return int идентификатор группы
	 */
	function AddFolder($name, $description, $parentid)
	{
		$sql = "INSERT INTO ".PUsersMgr::$tables['roles_tree']." SET ";
        $sql.= " ParentID = ".(int) $parentid;
        $sql.= " ,Name = '".addslashes($name)."'";
        $sql.= " ,Description = '".addslashes($description)."'";
	
		if (true == PUsersMgr::$db->query($sql))
			return PUsersMgr::$db->insert_id;
	
		return 0;
	}

	/**
	 * Удалить группу ролей
	 *
	 * @param int treeid идентификатор группы
	 */
	function RemoveFolder($treeid)
	{
		$sql = "DELETE FROM ".PUsersMgr::$tables['roles_tree'];
		$sql.= " WHERE TreeID = ".(int) $treeid;
	
		return PUsersMgr::$db->query($sql);
	}

	/**
	 * Обновить данные о группе
	 * @param mixed treeid идентификатор группы
	 * @param string name имя группы
	 * @param string description описание группы
	 * @param int treeid идентификатор ветки дерева для перемещения группы
	 */
	function UpdateFolder($treeid, $name, $description, $parentid = -1)
	{
		$sql = "UPDATE ".PUsersMgr::$tables['roles_tree']." SET ";
        $sql.= " Name = '".addslashes($russian_name)."'";
        $sql.= " ,Description = '".addslashes($description)."'";

		if ($parentid >= 0)
			$sql.= " ,ParentID = ".(int) $parentid;

		$sql.= " WHERE TreeID = ".(int) $treeid;
		PUsersMgr::$db->query($sql);
	}

	/**
	 * Переместить роль в группу
	 */
	function MoveToFolder()
	{
	}
}

?>