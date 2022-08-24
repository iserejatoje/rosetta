<?php

/**
 * @version 1.0
 * @created 27-июл-2007 9:16:54
 */
class DBRoleProvider
{
	/**
	 * Получить список ролей
	 * 
	 * @param group    Имя группы
	 */
	function GetRoles($group)
	{
		if (!is_numeric($group) || $group < 0)
			return array();
	
		$sql = "SELECT role.Name, ref.SectionID, ref.AddKey, ref.Action, ref.RoleID ";
		$sql.= " FROM ".PUsersMgr::$tables['group_roles_ref']." as ref ";
		$sql.= " INNER JOIN ".PUsersMgr::$tables['roles']." as role ON role.RoleID = ref.RoleID ";
		$sql.= " WHERE ref.GroupID = ".(int) $group;

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return array();
			
		if ($res->num_rows)
			return array();
	
		$roles = array();
		while(false != ($row = $res->fetch_row())) {
			if (!is_array($roles[$row[1]]))
				$roles[$row[1]] = array();
		
			$roles[$row[1]][$row[0]] = array('action' => $row[2]);
		}
		
		return $roles;
	}

	/**
	 * Удаление экземпляра провайдера, здесь производится сохранение
	 */
	function Dispose()
	{
	}
}
