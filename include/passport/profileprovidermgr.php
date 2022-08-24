<?php

/**
 * Воспомогательный класс для управления провайдерами
 * @version 1.0
 * @created 27-июл-2007 9:16:59
 */
class PProfileProviderMgr
{
	private $config = array(); // провайдеры, по идее надо вынести куда-то
	private $providers = array(); // экземпляры провайдеров по пользователю и разделу
	function __construct()
	{
		$this->LoadConfig();
	}

	/**
	 * Метод фабрика, создает объект провайдера, по идентификатору раздела (связь
	 * идентификатора раздела и имени провайдера находится в конфигурационном файле)
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
		else if(!empty($this->config[$moduleName]))
		{
			if(is_file($this->config[$moduleName]['path']))
			{
				include_once $this->config[$moduleName]['path'];
				$provider = new $this->config[$moduleName]['name']($userID, $sectionID);
			}
		}
		if($provider == null)
			$provider = new PDBProfileProvider($userID, $sectionID);
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
		$this->config[$moduleName] = array(
			'path' => $providerPath,
			'name' => $providerName);
	}

	/**
	 * Загрузить конфиг
	 */
	private function LoadConfig()
	{
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