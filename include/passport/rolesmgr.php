<?php

/**
 * Управление ролями
 * @version 1.0
 * @created 27-июл-2007 9:17:00
 */
class PRolesMgr implements IDisposable
{
	private $user			= null;		// Пользователь
	private $usersMgr		= null;

	static $groupsTree		= null;		// дерево групп

	static private $keyProviders	= array();	// провайдеры создателей ключей)

	private $currentProvider = null;	// текущий провайдер
	private $providers		= array();	// подгруженные пространства
	private $spacesStack	= array();	// стек пространств
	private $currentSpace	= null;
	private $currentKey		= null;

	/**
	 * Конструктор
	 * @param user    текщий пользователь
	 * @param mgr     менеджер пользователей
	 */
	function __construct($user, $mgr)
	{
		$this->user = $user;
		$this->usersMgr = $mgr;
		$this->SetSpace('modules');
	}

	function Dispose()
	{
	}

	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	function IsInRole($roleName, $addKey = null)
	{
		return $this->currentProvider->IsInRole($roleName, $addKey);
	}

	/**
	 * Получить объекты для роли
	 *
	 * @param string roleName имя роли
	 * @return array список объектов для которых назначена данная роль
	 */
	function GetObjectsForRole($roleName, $caching = true)
	{
		return $this->currentProvider->GetObjectsForRole($roleName, $caching);
	}

	private function GetProviderName($name)
	{
		global $CONFIG;

		$cn = 'PRolesProvider_'.strtolower($name);
		if(class_exists($cn))
			return $cn;
		elseif(is_file($CONFIG['engine_path'].'include/passport/rproviders/'.$name.'.php'))
		{
			include_once $CONFIG['engine_path'].'include/passport/rproviders/'.$name.'.php';
			if(class_exists($cn))
			{
				$cnk = $cn.'_KeyCreator';
				if(class_exists($cnk))
					self::$keyProviders[$name] = new $cnk;
				else
					error_log("Can't create role key creator provider.");
				return $cn;
			}
			else
				error_log("Can't create role provider.");
        }
		return null;
    }

	public function SetSpace($space, $params = null)
	{

		$name = $this->GetProviderName($space);
		$key = self::$keyProviders[$space]->CreateKey($params);
		if(!isset($this->providers[$space][$key]))
			$this->providers[$space][$key] = new $name($this->user, $this->usersMgr, $params);

		$this->currentProvider = $this->providers[$space][$key];
		$this->currentSpace = $space;
		$this->currentKey = $key;
    }

	public function PushSpace($space = null, $params = null)
	{
		array_push($this->spacesStack, array($this->currentSpace, $this->currentKey));
		if($space != null)
			$this->SetSpace($space, $params);
    }

	public function PopSpace()
	{
		$up = array_pop($this->spacesStack);
		if($up === null)
		{
			Data::e_backtrace("Can't pop space");
			exit;
        }

		$this->currentProvider = $this->providers[$up[0]][$up[1]];
		$this->currentSpace = $up[0];
		$this->currentKey = $up[1];
    }

	//2do: утащить методы из этого класса
	static function GetRolesForGroupAndSection($group, $section, $addkey)
	{
		$sql = "SELECT GroupID, SectionID, RoleID, AddKey, Action ";
		$sql.= " FROM ".PUsersMgr::$tables['group_roles_ref'];
		$sql.= " WHERE GroupID = ".(int) $group;
		$sql.= " AND SectionID = ".(int) $section;

		if (true != ($res = PUsersMgr::$db->query($sql)))
			return array();

		if (!$res->num_rows)
			return array();

		$roles = array();
		while(false != ($row = $res->fetch_assoc())) {
			$roles[] = $row;
		}

		return self::FilterByAddKey($roles, $addkey);
	}

	static function GetRolesForUserAndSection($user, $section, $addkey)
	{
		$sql = "SELECT UserID, SectionID, RoleID, AddKey, Action ";
		$sql.= " FROM ".PUsersMgr::$tables['roles_ref'];
		$sql.= " WHERE UserID = ".(int) $user;
		$sql.= " AND SectionID = ".(int) $section;

		if (true != ($res = PUsersMgr::$db->query($sql)))
			return array();

		if (!$res->num_rows)
			return array();

		$roles = array();
		while(false != ($row = $res->fetch_assoc())) {
			$roles[] = $row;
		}

		return self::FilterByAddKey($roles, $addkey);
	}

	static private function FilterByAddKey($roles, $addkey)
	{
		$r = array();
		foreach($roles as $role)
		{
			if(strlen($addkey) === 0)
			{
				if(strlen($role['AddKey']) === 0)
					$r[] = $role;
			}
			else
			{
				$aks = self::ExplodeAddKeys($role['AddKey']);
				if(in_array($addkey, $aks) === true)
					$r[] = $role;
			}
		}
		return $r;
	}

	static function SetRoleForUser($user, $section, $role, $addkey, $permission)
	{
		if($addkey != null && strlen($addkey) != 0)
		{
			$aks = array();

			$sql = "SELECT UserID, SectionID, RoleID, AddKey, Action ";
			$sql.= " FROM ".PUsersMgr::$tables['roles_ref'];
			$sql.= " WHERE UserID = ".(int) $user;
			$sql.= " AND SectionID = ".(int) $section;

			$res = PUsersMgr::$db->query($sql);
			while(false != ($row = $res->fetch_assoc()))
			{
				if($row['AddKey'] != null && $row['RoleID'] == $role)
				{
					$aks[$row['Action']] = self::ExplodeAddKeys($row['AddKey']);
				}
			}

			if($permission == 0)
			{
				$aks[1] = array_diff((array)$aks[1], array($addkey));
				$aks[-1] = array_diff((array)$aks[-1], array($addkey));
			}
			else
			{
				// добавляем
				if(!in_array($addkey, (array)$aks[$permission]))
					$aks[$permission][] = $addkey;

				// удаляем из противоположного
				$aks[-$permission] = array_diff((array)$aks[-$permission], array($addkey));
			}

			self::_setRoleForUser($user, $section, $role, implode('|', (array)$aks[1]), 1);
			self::_setRoleForUser($user, $section, $role, implode('|', (array)$aks[-1]), -1);
		}
		else
			self::_setRoleForUser($user, $section, $role, null, $permission);

		PUsersMgr::ClearCache(PUsersMgr::CH_ROLES, array('userid' => $user));
	}

	private static function _setRoleForUser($UserID, $SectionID, $RoleID, $AddKey, $Action) {

		if (is_null($AddKey)) {
			if ($Action == 0) {
				$sql = "DELETE FROM ".PUsersMgr::$tables['roles_ref'];
	        	$sql.= " WHERE UserID = ".(int) $UserID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
	            $sql.= " AND ISNULL(AddKey) ";
				
				PUsersMgr::$db->query($sql);
			} else {
				$sql = "SELECT count(*) FROM ".PUsersMgr::$tables['roles_ref'];
	        	$sql.= " WHERE UserID = ".(int) $UserID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
	            $sql.= " AND ISNULL(AddKey) ";
			
				if (true != ($res = PUsersMgr::$db->query($sql)))
					return ;
					
				list($count) = $res->fetch_row();
				
				if ($count == 0) {
					$sql = "INSERT INTO ".PUsersMgr::$tables['roles_ref']." SET ";
					$sql.= " UserID = ".(int) $UserID;
					$sql.= " ,SectionID = ".(int) $SectionID;
					$sql.= " ,RoleID = ".(int) $RoleID;
					$sql.= " ,AddKey = NULL ";
					$sql.= " ,Action = ".(int) $Action;
				
					PUsersMgr::$db->query($sql);
				} else {
					$sql = "UPDATE ".PUsersMgr::$tables['roles_ref']." SET ";
					$sql.= " UserID = ".(int) $UserID;
					$sql.= " ,AddKey = NULL ";
					$sql.= " ,Action = ".(int) $Action;
					$sql.= " WHERE UserID = ".(int) $UserID;
					$sql.= " AND SectionID = ".(int) $SectionID;
					$sql.= " AND RoleID = ".(int) $RoleID;
					$sql.= " AND ISNULL(AddKey) ";
					
					PUsersMgr::$db->query($sql);
				}
			}
		} else {
			if ($Action == 0)
				return ;
		
			$sql = "SELECT count(*) FROM ".PUsersMgr::$tables['roles_ref'];
			$sql.= " WHERE UserID = ".(int) $UserID;
			$sql.= " AND SectionID = ".(int) $SectionID;
			$sql.= " AND RoleID = ".(int) $RoleID;
			$sql.= " AND Action = ".(int) $Action;
			$sql.= " AND !ISNULL(AddKey) ";
		
			if (true != ($res = PUsersMgr::$db->query($sql)))
				return ;
				
			list($count) = $res->fetch_row();
			if ($count == 0) {
				if (strlen($AddKey) != 0) {
					$sql = "INSERT INTO ".PUsersMgr::$tables['roles_ref']." SET ";
					$sql.= " UserID = ".(int) $UserID;
					$sql.= " ,SectionID = ".(int) $SectionID;
					$sql.= " ,RoleID = ".(int) $RoleID;
					$sql.= " ,AddKey = '".addslashes($AddKey)."' ";
					$sql.= " ,Action = ".(int) $Action;
				
					PUsersMgr::$db->query($sql);
				}
			} else {
				if (strlen($AddKey) == 0) {
					$sql = "DELETE FROM ".PUsersMgr::$tables['roles_ref'];
				} else {
					$sql = "UPDATE ".PUsersMgr::$tables['roles_ref']." SET ";
					$sql.= " AddKey = '".addslashes($AddKey)."' ";
					$sql.= " ,RoleID = ".(int) $RoleID;
				}
				
				$sql.= " WHERE UserID = ".(int) $UserID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
				$sql.= " AND !ISNULL(AddKey) ";
				$sql.= " AND Action = ".(int) $Action;
				
				PUsersMgr::$db->query($sql);
			}
		}
	}
	
	static function SetRoleForGroup($group, $section, $role, $addkey, $permission)
	{
		if($addkey != null && strlen($addkey) != 0)
		{
			$aks = array();

			$sql = "SELECT GroupID, SectionID, RoleID, AddKey, Action ";
			$sql.= " FROM ".PUsersMgr::$tables['group_roles_ref'];
			$sql.= " WHERE GroupID = ".(int) $group;
			$sql.= " AND SectionID = ".(int) $section;

			$res = PUsersMgr::$db->query($sql);
			while(false != ($row = $res->fetch_assoc()))
			{
				if($row['AddKey'] != null && $row['RoleID'] == $role)
				{
					$aks[$row['Action']] = self::ExplodeAddKeys($row['AddKey']);
				}
			}

			if($permission == 0)
			{
				$aks[1] = array_diff((array)$aks[1], array($addkey));
				$aks[-1] = array_diff((array)$aks[-1], array($addkey));
			}
			else
			{
				// добавляем
				if(!in_array($addkey, (array)$aks[$permission]))
					$aks[$permission][] = $addkey;

				// удаляем из противоположного
				$aks[-$permission] = array_diff((array)$aks[-$permission], array($addkey));
			}

			self::_setRoleForGroup($group, $section, $role, implode('|', (array)$aks[1]), 1);
			self::_setRoleForGroup($group, $section, $role, implode('|', (array)$aks[-1]), -1);
		}
		else
			self::_setRoleForGroup($group, $section, $role, NULL, $permission);

		PUsersMgr::ClearCache(PUsersMgr::CH_ROLES, array('groupid' => $group));
	}

	private static function _setRoleForGroup($GroupID, $SectionID, $RoleID, $AddKey, $Action) {

		if (is_null($AddKey)) {
			if ($Action == 0) {
				$sql = "DELETE FROM ".PUsersMgr::$tables['group_roles_ref'];
	        	$sql.= " WHERE GroupID = ".(int) $GroupID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
	            $sql.= " AND ISNULL(AddKey) ";
				
				PUsersMgr::$db->query($sql);
			} else {
				$sql = "SELECT count(*) FROM ".PUsersMgr::$tables['group_roles_ref'];
	        	$sql.= " WHERE GroupID = ".(int) $GroupID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
	            $sql.= " AND ISNULL(AddKey) ";
			
				if (true != ($res = PUsersMgr::$db->query($sql)))
					return ;
					
				list($count) = $res->fetch_row();
				
				if ($count == 0) {
					$sql = "INSERT INTO ".PUsersMgr::$tables['group_roles_ref']." SET ";
					$sql.= " GroupID = ".(int) $GroupID;
					$sql.= " ,SectionID = ".(int) $SectionID;
					$sql.= " ,RoleID = ".(int) $RoleID;
					$sql.= " ,AddKey = NULL ";
					$sql.= " ,Action = ".(int) $Action;
				
					PUsersMgr::$db->query($sql);
				} else {
					$sql = "UPDATE ".PUsersMgr::$tables['group_roles_ref']." SET ";
					$sql.= " GroupID = ".(int) $GroupID;
					$sql.= " ,AddKey = NULL ";
					$sql.= " ,Action = ".(int) $Action;
					$sql.= " WHERE GroupID = ".(int) $GroupID;
					$sql.= " AND SectionID = ".(int) $SectionID;
					$sql.= " AND RoleID = ".(int) $RoleID;
					$sql.= " AND ISNULL(AddKey) ";
					
					PUsersMgr::$db->query($sql);
				}
			}
		} else {
			if ($Action == 0)
				return ;
		
			$sql = "SELECT count(*) FROM ".PUsersMgr::$tables['group_roles_ref'];
			$sql.= " WHERE GroupID = ".(int) $GroupID;
			$sql.= " AND SectionID = ".(int) $SectionID;
			$sql.= " AND RoleID = ".(int) $RoleID;
			$sql.= " AND Action = ".(int) $Action;
			$sql.= " AND !ISNULL(AddKey) ";
		
			if (true != ($res = PUsersMgr::$db->query($sql)))
				return ;
				
			list($count) = $res->fetch_row();
			if ($count == 0) {
				if (strlen($AddKey) != 0) {
					$sql = "INSERT INTO ".PUsersMgr::$tables['group_roles_ref']." SET ";
					$sql.= " GroupID = ".(int) $GroupID;
					$sql.= " ,SectionID = ".(int) $SectionID;
					$sql.= " ,RoleID = ".(int) $RoleID;
					$sql.= " ,AddKey = '".addslashes($AddKey)."' ";
					$sql.= " ,Action = ".(int) $Action;
				
					PUsersMgr::$db->query($sql);
				}
			} else {
				if (strlen($AddKey) == 0) {
					$sql = "DELETE FROM ".PUsersMgr::$tables['group_roles_ref'];
				} else {
					$sql = "UPDATE ".PUsersMgr::$tables['group_roles_ref']." SET ";
					$sql.= " AddKey = '".addslashes($AddKey)."' ";
					$sql.= " ,RoleID = ".(int) $RoleID;
				}
				
				$sql.= " WHERE GroupID = ".(int) $GroupID;
				$sql.= " AND SectionID = ".(int) $SectionID;
				$sql.= " AND RoleID = ".(int) $RoleID;
				$sql.= " AND !ISNULL(AddKey) ";
				$sql.= " AND Action = ".(int) $Action;
				
				PUsersMgr::$db->query($sql);
			}
		}
	}
	
	public function GetRolesForGroup($id)
	{
		if(PUsersMgr::$cacher !== null)
			$roles = PUsersMgr::$cacher->Get('rolesforgroup_'.$id);
		else
			$roles = false;

		if($roles === false)
		{
			$roles = array();

			$sql = "SELECT role.Name, ref.SectionID, ref.AddKey, ref.Action, ref.RoleID ";
			$sql.= " FROM ".PUsersMgr::$tables['group_roles_ref']." as ref ";
			$sql.= " INNER JOIN ".PUsersMgr::$tables['roles']." as role ON role.RoleID = ref.RoleID ";
			$sql.= " WHERE ref.GroupID = ".(int) $id;

			$res = PUsersMgr::$db->query($sql);
			while(false != ($row = $res->fetch_row()))
			{
				if(strlen($row[2]) > 0)
				{
					$addkeys = self::ExplodeAddKeys($row[2]);
					foreach($addkeys as $key)
					{
						$roles[] = array(
							'name' => $row[0],
							'section' => $row[1],
							'addkey' => $key,
							'action' => $row[3],
							'id' => $row[4],
						);
					}
				}
				else
				{
					$roles[] = array(
						'name' => $row[0],
						'section' => $row[1],
						'addkey' => '',
						'action' => $row[3],
						'id' => $row[4],
					);
				}
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('rolesforgroup_'.$id, $roles, 300);
		}

		return $roles;
	}

	public function GetRolesForUser($id)
	{
		if(PUsersMgr::$cacher !== null)
			$roles = PUsersMgr::$cacher->Get('rolesforuser_'.$id);
		else
			$roles = false;
			
		if($roles === false)
		{
			$roles = array();

			$sql = "SELECT role.Name, ref.SectionID, ref.AddKey, ref.Action, ref.RoleID ";
			$sql.= " FROM ".PUsersMgr::$tables['roles_ref']." as ref ";
			$sql.= " INNER JOIN ".PUsersMgr::$tables['roles']." as role ON role.RoleID = ref.RoleID ";
			$sql.= " WHERE ref.UserID = ".(int) $id;
			
			$res = PUsersMgr::$db->query($sql);
			while(false != ($row = $res->fetch_row()))
			{
				if(strlen($row[2]) > 0)
				{
					$addkeys = self::ExplodeAddKeys($row[2]);
					foreach($addkeys as $key)
					{
						$roles[] = array(
								'name' => $row[0],
								'section' => $row[1],
								'addkey' => $key,
								'action' => $row[3],
								'id' => $row[4],
								);
					}
				}
				else
				{
					$roles[] = array(
							'name' => $row[0],
							'section' => $row[1],
							'addkey' => '',
							'action' => $row[3],
							'id' => $row[4],
							);
				}
			}
			
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('rolesforuser_'.$id, $roles, 300);
		}

		return $roles;
	}

	static function GetRolesForObject($group, $section)
	{	
		$sql = "SELECT GroupID, SectionID, RoleID, AddKey, Action ";
		$sql.= " FROM ".PUsersMgr::$tables['group_roles_ref'];
		$sql.= " WHERE GroupID = ".(int) $group;
		$sql.= " AND SectionID = ".(int) $section;
		
		if (true != ($res = PUsersMgr::$db->query($sql)))
			return array();

		if (!$res->num_rows)
			return array();

		$roles = array();
		while(false != ($row = $res->fetch_assoc())) {
			$roles[$row['RoleID']] = $row;
		}

		return $roles;
	}

	static private function ExplodeAddKeys($keys)
	{
		return explode('|', $keys);
	}
}

abstract class PRolesProviderObject
{
	protected $user				= null;		// Пользователь
	protected $usersMgr			= null;
	protected $params			= null;		// ключ

	function __construct($user, $mgr, $params)
	{
		$this->user = $user;
		$this->usersMgr = $mgr;
		$this->params = $params;
	}

	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	abstract function IsInRole($roleName, $addKey = null);

	/**
	 * Получить объекты для роли
	 *
	 * @param string roleName имя роли
	 * @return array список объектов для которых назначена данная роль
	 */
	abstract function GetObjectsForRole($roleName, $caching = true);
}

abstract class PRolesProviderBaseKeyCreator
{
	abstract public function CreateKey($params);
}

