<?php

/**
 * Группа пользователей
 * @version 1.0
 * @created 27-июл-2007 9:17:01
 */
class PGroup
{
	public $Id;			// идентификатор группы
	public $Name;		// название группы
	public $Description;// описание группы

	function __construct($id = 0, $name = '', $description = '')
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->Description = $description;
	}

	/**
	 * добавить пользователя в группу
	 * 
	 * @param int userID    идентификатор пользователя
	 */
	function AddUser($userID)
	{
	}

	/**
	 * Удалить пользователя из группы
	 * 
	 * @param int userID    идентификатор пользователя
	 */
	function RemoveUser($userID)
	{
	}

	/**
	 * Добавить роль в группу 
	 *
	 * @param int sectionID    идентификатор раздела
	 * @param int roleId       имя роли
	 */
	function AddRole($sectionID, $roleId)
	{
	}

	/**
	 * Удалить роль из группы
	 * 
	 * @param int sectionID    идентификатор раздела
	 * @param int roleName     имя роли
	 */
	function RemoveRole($sectionID, $roleName)
	{
	}

}
