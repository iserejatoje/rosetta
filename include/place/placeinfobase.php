<?php
require_once ($CONFIG['engine_path'].'include/place/place.php');

abstract class PlaceInfoBase
{

	function __construct()
	{
	}

	function __destruct()
	{
	}



	/**
	 * Загрузка данных
	 */
	public function Load()
	{
	}

	/**
	 * обновить информацию во временной базе
	 */
	public function SuggestUpdate()
	{

	}
	
	/**
	 * удалить информацию во временной базе
	 */
	public function SuggestRemove()
	{

	}

	/**
	 * обновить данные, вызов метода Save
	 */
	public function Update()
	{
	}

	/**
	 * получить значение
	 * 
	 * @param name
	 */
	public function Get(string $name)
	{
	}

	/**
	 * установить значение
	 * 
	 * @param value
	 * @param name
	 */
	public function Set(string $value, string $name)
	{
	}

}
?>