<?php

class PRolesProvider_modules extends PRolesProviderObject
{
	private $roles			= null;		// роли по разделам
	private $groles			= null;		// глобальные роли
	private $groups			= null;		// группы в которых состоит пользователь

	static $groupsTree		= null; // дерево групп

	function __construct($user, $mgr, $key)
	{
		parent::__construct($user, $mgr, $key);
	}

	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	function IsInRole($roleName, $addKey = null)
	{
		$this->GetRoles();

		if($this->user->SectionID != 0)
		{
			if($addKey !== null && isset($this->roles[$this->user->SectionID][$roleName][$addKey]))
				return $this->roles[$this->user->SectionID][$roleName][$addKey]==1?true:false;
			if(isset($this->roles[$this->user->SectionID][$roleName]['']))
				return $this->roles[$this->user->SectionID][$roleName]['']==1?true:false;
		}
		if($addKey !== null && isset($this->groles[$roleName][$addKey]))
			return $this->groles[$roleName][$addKey]==1?true:false;

		if(isset($this->groles[$roleName]['']))
			return $this->groles[$roleName]['']==1?true:false;

		return false;
	}

	private function GetRoles($caching = true)
	{
		$this->GetGroups();
		if(PUsersMgr::$cacher === null || $caching === false)
			$r = false;
		else
			$r = PUsersMgr::$cacher->Get('rolesmodules_'.$this->user->ID);
		
		if($r === false)
		{
			if($this->roles === null || $this->groles === null)
			{
				$this->roles = array();
				$this->groles = array();
				// собирем строку групп в обратном порядке
				foreach($this->groups as $group => $name)
				{
					$roles = $this->GetRolesForGroup($group);
					// накладываем роли на массивы
					foreach($roles as $role)
					{
						if($role['section'] == 0)
						{
							if(!isset($this->groles[$role['name']][$role['addkey']]) ||
									  $this->groles[$role['name']][$role['addkey']] == 1)
								$this->groles[$role['name']][$role['addkey']] = $role['action'];
						}
						else
						{
							if(!isset($this->roles[$role['section']][$role['name']][$role['addkey']]) ||
									  $this->roles[$role['section']][$role['name']][$role['addkey']] == 1)
								$this->roles[$role['section']][$role['name']][$role['addkey']] = $role['action'];
						}
					}
				}
				// добавляем роли пользователя
				$roles = $this->GetRolesForUser($this->user->ID);
				// накладываем роли на массивы
				foreach($roles as $role)
				{
					if($role['section'] == 0)
					{
						if(!isset($this->groles[$role['name']][$role['addkey']]) ||
								  $this->groles[$role['name']][$role['addkey']] == 1)
							$this->groles[$role['name']][$role['addkey']] = $role['action'];
					}
					else
					{
						if(!isset($this->roles[$role['section']][$role['name']][$role['addkey']]) ||
								  $this->roles[$role['section']][$role['name']][$role['addkey']] == 1)
							$this->roles[$role['section']][$role['name']][$role['addkey']] = $role['action'];
					}
				}
			}
			if(PUsersMgr::$cacher !== null && $caching === true)
				PUsersMgr::$cacher->Set('rolesmodules_'.$this->user->ID, array('groles' => $this->groles, 'roles' => $this->roles), 300);
		}
		else
		{
			$this->groles = $r['groles'];
			$this->roles = $r['roles'];
		}
	}

	/**
	 * Получить объекты для роли
	 *
	 * @param string roleName имя роли
	 * @return array список объектов для которых назначена данная роль
	 */
	function GetObjectsForRole($roleName, $caching = true)
	{
		$this->GetRoles($caching);
		$addkey = '';
		if(func_num_args() > 2)
		{
			$params = func_get_args();
			array_shift($params);
			array_shift($params);
			$addkey = implode('|', $params);
		}
		$objs = array();

		if(isset($this->groles[$roleName]['']) && $this->groles[$roleName][''] == 1)
			return array(0);
		if(isset($this->groles[$roleName][$addkey]) && $this->groles[$roleName][$addkey] == 1)
			return array(0);
		foreach($this->roles as $obj => $r1)
		{
			if(isset($r1[$roleName][$addkey]) || isset($r1[$roleName]['']))
			{
				if($obj == 0)
					return array(0);
				$objs[] = $obj;
			}
		}

		return $objs;
	}

	static function GetRolesForGroupAndSection($group, $section, $addkey)
	{
		return PRolesMgr::GetRolesForGroupAndSection($group, $section, $addkey);
	}

	static function GetRolesForUserAndSection($user, $section, $addkey)
	{
		return PRolesMgr::GetRolesForUserAndSection($user, $section, $addkey);
	}

	public function GetRolesForGroup($id)
	{
		return PRolesMgr::GetRolesForGroup($id);
	}

	public function GetRolesForUser($id)
	{
		return PRolesMgr::GetRolesForUser($id);
	}

	static function GetRolesForObject($group, $section)
	{
		return PRolesMgr::GetRolesForObject($group, $section);
	}

	static private function ExplodeAddKeys($keys)
	{
		return explode('|', $keys);
	}

	private function GetGroups()
	{
		if($this->groups === null)
		{
			if(PUsersMgr::$cacher !== null)
				$this->groups = PUsersMgr::$cacher->Get('rolesgroups_'.$this->user->ID);
			else
				$this->groups = false;

			if($this->groups === false)
			{
				$this->groups = array();

				$sql = "SELECT r.GroupID,g.Name FROM ".PUsersMgr::$tables['groups_ref']." as r ";
				$sql.= " INNER JOIN ".PUsersMgr::$tables['groups']." AS g ON g.GroupID = r.GroupID ";
				$sql.= " WHERE r.UserID = ".$this->user->ID;

				$res = PUsersMgr::$db->query($sql);
				while(false != ($row = $res->fetch_row())) {
					$this->groups[$row[0]] = $row[1];
				}

				if(PUsersMgr::$cacher !== null)
					PUsersMgr::$cacher->Set('rolesgroups_'.$this->user->ID, $this->groups, 3600);
			}
		}
	}
}

class PRolesProvider_modules_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return 0;
    }
}
