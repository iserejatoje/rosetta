<?
class PRolesProvider_test extends PRolesProviderObject
{
	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	function IsInRole($roleName, $addKey = null)
	{
		if($this->params['id'] % 2 == 1 && ($roleName == 'role1' || $roleName == 'role3'))
			return true;
		elseif($this->params['id'] % 2 == 0 && ($roleName == 'role2' || $roleName == 'role4'))
			return true;
		return false;
	}
	
	/**
	 * Получить объекты для роли
	 *
	 * @param string roleName имя роли
	 * @return array список объектов для которых назначена данная роль
	 */
	function GetObjectsForRole($roleName, $caching = true)
	{
		return array();
	}
}

class PRolesProvider_test_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>