<?php

/**
 * @version 1.0
 * @created 27-июл-2007 9:16:53
 */
class PDBProfileProvider implements IPProfileProvider
{
	private $profile			= null;			// Временное хранилище настроек
	private $sectionID			= 0;			// раздел
	private $userID				= null;			// пользователь
	private $changed			= false;		// флаг изменения профиля (необходим для чистки кэша)

	/**
	 * 
	 * @param userID    пользователь
	 * @param sectionID    раздел
	 */
	function __construct($userID, $sectionID)
	{
		$this->sectionID = $sectionID;
		$this->userID = $userID;
	}

	/**
	 * Получение данных из профиля пользователя
	 * 
	 * @param string name имя параметра
	 * @return mixed значение
	 */
	function ValueGet($name)
	{
		if($this->userID > 0)
		{
			if($this->profile === null)
				$this->LoadData();
			return $this->profile[$name];
		}
		return null;
	}
	
	/**
	 * Проверка существования данных
	 * 
	 * @param string name имя параметра
	 * @return bool
	 */
	function ValueIsSet($name)
	{
		if($this->userID > 0)
		{
			if($this->profile === null)
				$this->LoadData();
			return isset($this->profile[$name]);
		}
		return null;
	}
	
	/**
	 * Удалить данные
	 * 
	 * @param string name имя параметра
	 */
	function ValueUnset($name)
	{
		if($this->userID > 0)
		{
			$this->changed = true;
			if($this->profile === null)
				$this->LoadData();
			unset($this->profile[$name]);
		}
	}

	/**
	 * Сохранение данных в профиле
	 * 
	 * @param string name имя параметра
	 * @param mixed value значение
	 */
	function ValueSet($name, $value)
	{
		if($this->userID > 0)
		{
			$this->changed = true;
			if($this->profile === null)
				$this->LoadData();
			$this->profile[$name] = $value;
		}
	}
	
	function Dispose()
	{
		$this->SaveData();
	}

	/**
	 * Загрузка данных из базы
	 */
	function LoadData()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('profile_'.$this->userID.'_'.$this->sectionID);
		else
			$this->profile = false;
		
		if($this->profile === false)
		{
			$sql = "SELECT `Data` FROM ".PUsersMgr::$tables['profile'];
			$sql.= " WHERE UserID = ".$this->userID;
			$sql.= " AND SectionID = ".$this->sectionID;
		
			if (false != ($res = PUsersMgr::$db->query($sql))) {
				$p = $res->fetch_row();
				$this->profile = unserialize($p[0]);
			} else {
				$this->profile = array();
			}
		
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('profile_'.$this->userID.'_'.$this->sectionID, $this->profile, 300); // 5 минут
		}
	}
	
	/**
	 * Сохранение данных в базу
	 */
	function SaveData()
	{
		if($this->changed === true)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile'];
			$sql.= " WHERE UserID = ".$this->userID;
			$sql.= " AND SectionID = ".$this->sectionID;
			
			if (false == ($res = PUsersMgr::$db->query($sql)))
				return false;
				
			if ($res->num_rows != 0) {
				$sql = "UPDATE ".PUsersMgr::$tables['profile']." SET ";
				$sql.= " Data = '".addslashes(serialize($this->profile))."'";
				$sql.= " WHERE UserID = ".$this->userID;
				$sql.= " AND SectionID = ".$this->sectionID;
			} else {
				$sql = "UPDATE ".PUsersMgr::$tables['profile']." SET ";
				$sql.= " Data = '".addslashes(serialize($this->profile))."'";
				$sql.= " ,UserID = ".$this->userID;
				$sql.= " ,SectionID = ".$this->sectionID;
			}
			
			PUsersMgr::$db->query($sql);
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Remove('profile_'.$this->userID.'_'.$this->sectionID);
		}
	}
}
