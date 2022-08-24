<?php


/**
 * @version 1.0
 * @created 27-июл-2007 9:16:59
 */
class PRoleProviderMgr
{
	private $providers = array(); // экземпляры провайдеров по пользователю и разделу

	function __construct()
	{
		$this->LoadConfig();
	}

	/**
	 * Создать объект обрабочика роли для раздела
	 *
	 * @param moduleName   имя модуля (известно в движке)
	 * @param userID	   идентификатор пользователя
	 * @param sectionID    идентификатор раздела
	 */
	function GetInstance($moduleName, $userID, $sectionID)
	{
		$provider = null;
		if(!empty($this->providers[$userID][$sectionID]))
			return $this->providers[$userID][$sectionID];
		else if(!empty(Registry::$Config['providers']['passport']['role'][$moduleName]))
		{
			if(is_file($Config['providers']['passport']['role'][$moduleName]['path']))
			{
				include_once $Config['providers']['passport']['role'][$moduleName]['path'];
				$provider = new $Config['providers']['passport']['role'][$moduleName]['name']($userID, $sectionID);
			}
		}
		if($provider == null)
			$provider = new DBRoleProvider($userID, $sectionID);
		$this->providers[$userID][$sectionID] = $provider;
		return $provider;
	}

	/**
	 * Зарегистрировать свой провайдер
	 * 
	 * @param string moduleName имя модуля
	 * @param string providerPath путь провайдера
	 * @param string providerName имя провайдера
	 */
	function AddProvider($moduleName, $providerPath, $providerName)
	{
		$Config['providers']['passport']['role'][$moduleName] = array(
				'path' => $providerPath,
				'name' => $providerName);
	}
	
	/**
	 * Удаление экземпляра провайдера
	 */
	public function Dispose()
	{
		foreach($this->providers as $p_)
			foreach($p_ as $provider)
				$provider->Dispose();
	}
}
?>