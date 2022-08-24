<?php

/**
 * @version 1.0
 * @created 27-июл-2007 9:16:58
 */
class PProfileMgr implements ArrayAccess
{
	private $user				= null;			// Текущий пользователь
	private $profileProviders	= array();		// провайдеры профилей по разделам
	private $usersMgr			= null;
	

	/**
	 * 
	 * @param User user пользователь
	 * @param UserMgr менеджер пользователей
	 */
	function __construct($user, $mgr)
	{
		$this->user = $user;
		$this->usersMgr = $mgr;
	}

	/**
	 * Получение значение из профиля 
	 *
	 * @param string name имя параметра
	 * @return mixed значение
	 */
	function Get($name)
	{
		if(empty($this->profileProviders[$this->user->SectionID]))
			$this->profileProviders[$this->user->SectionID] = $this->usersMgr->profileProviderMgr->GetInstance($this->user->ModuleName, $this->user->ID, $this->user->SectionID);
		return $this->profileProviders[$this->user->SectionID]->ValueGet($name);
	}

	/**
	 * Установить значение параметра профиля
	 * 
	 * @param string name имя параметра
	 * @param value значение
	 */
	function Set($name, $value)
	{
		if($this->user->IsInRole('l_passport_profile_change'))
		{
			if(empty($this->profileProviders[$this->user->SectionID]))
				$this->profileProviders[$this->user->SectionID] = $this->usersMgr->profileProviderMgr->GetInstance($this->user->ModuleName, $this->user->ID, $this->user->SectionID);
			$this->profileProviders[$this->user->SectionID]->ValueSet($name, $value);
		}
	}
	
	/**
	 * Проверка существования данных
	 * 
	 * @param string name имя параметра
	 * @return bool
	 */
	function ValueIsSet($name)
	{
		if(empty($this->profileProviders[$this->user->SectionID]))
			$this->profileProviders[$this->user->SectionID] = $this->usersMgr->profileProviderMgr->GetInstance($this->user->ModuleName, $this->user->ID, $this->user->SectionID);
		return $this->profileProviders[$this->user->SectionID]->ValueIsSet($name);
	}
	
	/**
	 * Удалить данные
	 * 
	 * @param string name имя параметра
	 */
	function ValueUnset($name)
	{
		if($this->user->IsInRole('l_passport_profile_change'))
		{
			if(empty($this->profileProviders[$this->user->SectionID]))
				$this->profileProviders[$this->user->SectionID] = $this->usersMgr->profileProviderMgr->GetInstance($this->user->ModuleName, $this->user->ID, $this->user->SectionID);
			$this->profileProviders[$this->user->SectionID]->ValueUnset($name);
		}
	}
	
	// ArrayAccess
	function offsetExists($offset)
	{
		return $this->ValueIsSet($offset);
	}
	
	function offsetGet($offset)
	{
		return $this->Get($offset);
	}
	
	function offsetSet($offset, $value)
	{
		$this->Set($offset, $value);
	} 

	function offsetUnset($offset)
	{
		$this->ValueUnset($offset);
	}
}

?>