<?
class PRolesProvider_news_magic extends PRolesProviderObject
{
	/**
	 * Проверка принадлежности роли
	 * @param roleName    Роль
	 */
	function IsInRole($roleName, $addKey = null)
	{
		return true;
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

class PRolesProvider_news_magic_KeyCreator extends PRolesProviderBaseKeyCreator
{
	public function CreateKey($params)
	{
		return $params['id'];
    }
}
?>