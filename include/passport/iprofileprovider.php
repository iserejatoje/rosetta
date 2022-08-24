<?php

/**
 * Интерфейс провайдера ролей
 * @version 1.0
 * @created 27-июл-2007 9:16:56
 */
interface IPProfileProvider
{

	/**
	 * Конструктор 
	 *
	 * @param userID    пользователь
	 * @param sectionID    раздел
	 */
	function __construct($userID, $sectionID);

	/**
	 * Получение данных из профиля пользователя
	 * 
	 * @param string name имя параметра
	 * @return mixed значение
	 */
	function ValueGet($name);

	/**
	 * Сохранение данных в профиле
	 * 
	 * @param string name имя параметра
	 * @param mixed value значение
	 */
	function ValueSet($name, $value);
	
	/**
	 * Проверка существования данных
	 * 
	 * @param string name имя параметра
	 * @return bool
	 */
	function ValueIsSet($name);
	
	/**
	 * Удалить данные
	 * 
	 * @param string name имя параметра
	 */
	function ValueUnset($name);
	
	/**
	 * Удаление экземпляра провайдера, здесь производится сохранение
	 */
	function Dispose();

}
?>