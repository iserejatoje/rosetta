<?php


/**
 * работа со структурой данных, только с ограниченными полями, используется для
 * работы с контактной информацией
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:21
 */
class lib_fieldsstruct
{

	/**
	 * список полей
	 */
	private $_fields;
	/**
	 * ассоциативный массив значений
	 */
	private $_values;

	/**
	 * 
	 * @param fields
	 */
	public function __construct(array $fields = null)
	{
		$this->_fields = $fields;
	}

	/**
	 * инициализация
	 * 
	 * @param info    массив значений
	 */
	public function Init(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);
		foreach( $this->_fields as $f ) {
			$this->_values[$f] = isset($info[$f]) ? $info[$f] : null;
		}
	
	}

	function __destruct()
	{
	}
	
	/**
	 * 
	 * @param name
	 */
	public function __get($name)
	{
		$name = strtolower($name);
		if ( isset($this->_values[$name]) )
			return $this->_values[$name];
		return null;
	}

	/**
	 * 
	 * @param name
	 * @param value
	 */
	public function __set($name, $value)
	{
		$name = strtolower($name);
		if ( isset($this->_values[$name]) )
			return $this->_values[$name] = $value;
		return null;
	}

	/**
	 * 
	 * @param name
	 */
	public function __isset($name)
	{
		$name = strtolower($name);
		return isset($this->_values[$name]);
	}

	/**
	 * 
	 * @param name
	 */
	public function __unset($name)
	{
		return false;
	}

}
?>