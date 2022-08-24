<?php

/**
 * Работа с группами
 * @version 1.0
 * @created 27-июл-2007 9:17:02
 */
class PGroupMgr
{

	function __construct()
	{
	}

	/**
	 * Создать группу
	 *
	 * @param string name			имя группы
	 * @param string description	описание группы
	 */
	static function Create($name, $description)
	{
		$sql = "INSERT INTO ".PUsersMgr::$tables['groups']." SET ";
        $sql.= " Name = '".addslashes($name)."'";
        $sql.= " ,Description = '".addslashes($description)."'";

		if($val !== PUsersMgr::$db->query($sql))
			return PUsersMgr::$db->insert_id;
		else
			return 0;
	}

	/**
	 * Удалить группу
	 *
	 * @param id    идентификатор группы
	 */
	static function Remove($id)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = "DELETE FROM ".PUsersMgr::$tables['groups'];
		$sql.= " WHERE GroupID = ".(int) $id;

		if (false == PUsersMgr::$db->query($sql))
			return false;

		$sql = "DELETE FROM ".PUsersMgr::$tables['groups_ref'];
		$sql.= " WHERE GroupID = ".(int) $id;
		PUsersMgr::$db->query($sql);

		return true;
	}

	/**
	 * Изменить данные группы группу
	 *
	 * @param id    идентификатор группы
	 */
	static function Update($id, $name, $description)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = "UPDATE ".PUsersMgr::$tables['groups']." SET ";
		$sql.= " Name = '".addslashes($name)."'";
        $sql.= " ,Description = '".addslashes($description)."'";
        $sql.= " WHERE GroupID = ".(int) $id;

		return PUsersMgr::$db->query($sql);
	}

	/**
	 * Изменить статус блокировки группы
	 *
	 * @param int  идентификатор группы
	 * @param bool блокировка
	 */
	static function Block($id, $block = true)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;

		$block = ($block === true ? 1 : 0);

		$sql = "UPDATE ".PUsersMgr::$tables['groups']." SET ";
		$sql.= " Blocked = ".$block;
        $sql.= " WHERE GroupID = ".(int) $id;

		return PUsersMgr::$db->query($sql);
	}

	/**
	 * получить группу по имени
	 *
	 * @param groupName    имя группы
	 */
	static function GetGroupByName($groupName)
	{
	}

	/**
	 * получить группу
	 *
	 * @param groupID    идентификатор группы
	 */
	static function GetGroup($id)
	{
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = "SELECT GroupID, Name, Description ";
        $sql.= " FROM ".PUsersMgr::$tables['groups'];
        $sql.= " WHERE GroupID = ".(int) $id;

 		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		$row = $res->fetch_row();
		if($row !== false)
			return new PGroup($row[0], $row[1], $row[2]);

		return false;
	}

	static function GetGroupsForUser($user_id)
	{
		if (!is_numeric($user_id) || $user_id < 0)
			return array();

		$sql = "SELECT GroupID FROM ".PUsersMgr::$tables['groups_ref'];
        $sql.= " WHERE UserID = ".$user_id;

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return array();

		if ($res->num_rows == 0)
			return array();

		$groups = array();
		while(false != ($row = $res->fetch_row())) {
			$groups[] = $row[0];
		}

		return $groups;
	}

	/**
	 * Добавить группы для пользователя
	 * @param int идентификатор пользователя
	 * @param int/array идентификатор группу
	 * @param bool true добавить false удалить
	 */
	static function SetGroupsForUser($user_id, $group_id, $isset)
	{
		if (!is_numeric($user_id) || $user_id < 0)
			return false;

		if(!is_array($group_id))
			$group_id = array($group_id);

		foreach($group_id as $v) {
			if (!is_numeric($v) || $v <= 0)
				continue ;

			if ($isset) {
				$sql = "INSERT IGNORE INTO ".PUsersMgr::$tables['groups_ref'];
				$sql.= " SET UserID = ".(int) $user_id;
            	$sql.= " ,GroupID = ".(int) $v;
			} else {
				$sql = "DELETE FROM ".PUsersMgr::$tables['groups_ref'];
				$sql.= " WHERE UserID = ".(int) $user_id;
				$sql.= " AND GroupID = ".(int) $v;
			}

			PUsersMgr::$db->query($sql);
		}

		if(PUsersMgr::$cacher !== null)
			PUsersMgr::ClearCache(PUsersMgr::CH_ROLES, array('userid' => $user_id));
	}

	/**
	 * получить дерево групп
	 *
	 * @return Tree дерево объектов
	 */
	static function GetGroups()
	{
		$sql = "SELECT * FROM ".PUsersMgr::$tables['groups'];
        $sql.= " ORDER BY Name ";

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return array();

		if ($res->num_rows == 0)
			return array();

		$groups = array();
		while(false != ($row = $res->fetch_row())) {
			$groups[] = array('GroupID' => $row[0], 'Name' => $row[1], 'Description' => $row[2], 'Blocked' => $row[3]);
		}

		return $groups;
	}
}
