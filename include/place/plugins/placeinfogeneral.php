<?php
require_once ($CONFIG['engine_path'].'include/place/placeinfobase.php');

/**
 * Простая базовая реализация класса информации о месте.
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:20
 */
class PlaceInfoGeneral extends PlaceInfoBase
{

	/**
	 * данные
	 */
	private $data;
	private $_place;

	public function Init($place) {
		$this->_place = $place;
	}
	
	/**
	 * Загрузка данных
	 */
	public function Load()
	{
		$this->data = array(
			'community' => null,
		);
	}

	/**
	 * обновить информацию во временной базе
	 */
	public function SuggestUpdate()
	{
		return true;
	}
	
	/**
	 * удалить информацию во временной базе
	 */
	public function SuggestRemove()
	{
		return true;
	}
	
	/**
	 * сохранение данных
	 */
	public function Update()
	{
		return true;
	}

	/**
	 * получить значение
	 * 
	 * @param name
	 */
	public function Get($name)
	{
		if ( $this->data === null )
			$this->Load();

		$name = strtolower($name);
		return $this->data[$name];
	}

	/**
	 * установить значение
	 * 
	 * @param value
	 * @param name
	 */
	public function Set($name, $value)
	{
		if ( $this->data === null )
			$this->Load();
	
		$name = strtolower($name);
		return $this->data[$name] = $value;
	}
	
	public function ValueIsSet($name)
	{
		return $this->Get($name) !== null;
	}
}
?>