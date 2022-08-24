<?php


/**
 * Провайдер ролей
 * @version 1.0
 * @created 27-июл-2007 9:16:57
 */
interface IRolesProvider
{
	/**
	 * 
	 * @param userID    пользователь
	 * @param sectionID    раздел
	 */
	function __construct($userID, $sectionID);

	/**
	 * Получить список ролей
	 * 
	 * @param name    Имя роли
	 */
	function GetRoles($group);
	
	/**
	 * Удаление экземпляра провайдера, здесь производится сохранение
	 */
	function Dispose();
}
?>