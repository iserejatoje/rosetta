<?
/**
 * Объектная обертка для массива
 * @author Данилин Дмитрий
 * @category Proxy
 */
class AxArrayObject implements ArrayAccess, Countable, Iterator
{
	protected $data = null;
	protected $parent = null;
	protected $index = null;
	protected $changed = false;
	
	/**
	 * Конструктор, возможна предварительная инициализация массивом
	 * @param array данные
	 * @param AxArrayObject родитель (для внутренних нужд)
	 * @param mixed индекс текущего среза (для внутренних нужд)
	 */
	public function __construct($data = null, $parent = null, $index = null)
	{
		if($index !== null)
			$this->index = $index;
		if($parent !== null)
			$this->parent = $parent;
		if($data !== null)
			$this->data = $data;
		if($data === null && $parent === null && $index === null)
			$this->data = array();
	}
	
	protected function setRefData(&$data)
	{
		$this->data =& $data;
	}

	/**
	 * Создание массива, используется при установке значения на несуществующем срезе	
	 */
	protected function createArray($index = null)
	{
		if($this->parent !== null && $this->index !== null)
		{
			if($this->data === null)
			{
				$this->parent->createArray($this->index);
				if($this->parent->data !== null)
				{
					$this->data =& $this->parent->data[$this->index];
				}
			}
		}
		if($index !== null)
			$this->data[$index] = array();
	}
	
	/**
	 * Установка флага изменение ветки
	 * @param bool флаг
	 */
	protected function SetChanged($val = true)
	{
		if($this->parent !== null)
			$this->parent->SetChanged($val);
		else
			$this->changed = $val;
	}
	
	/**
	 * Флаг измененности ветки
	 */
	public function IsChanged()
	{
		if($this->parent === null)
			return $this->changed;
		else
			return $this->parent->IsParent();
	}
	
	/**
	 * Копия данных среза
	 * @return mixed данные
	 */
	public function Value()
	{
		return $this->data;
	}
	
	/**
	 * Данные среза по ссылке
	 * @return reference данные
	 */
	public function &ValueByRef()
	{
		return $this->data;
	}
	
	public function __toString()
	{
		return (string)$this->data;
	}
	
	// Iterator
	private $position = null;
	public function current ()
	{
		if($this->data !== null)
		{
			if(is_array($this->data[key($this->data)]))
			{
				$obj = new AxArrayObject(null, $this, key($this->data));
				$obj->setRefData($this->data[key($this->data)]);
				return $obj;
			}
			else
				return current($this->data);
		}
		return null;	
	}
	
	public function key () 
	{
		if($this->data !== null)
			return key($this->data);
		return null;	
	}
	
	public function next () 
	{
		if($this->data !== null)
			return next($this->data) !== false;
		return null;	
	}
	
	public function rewind () 
	{
		if($this->data !== null)
			return reset($this->data);
		return null;
	}
	
	public function valid () 
	{
		if($this->data !== null)
			return current($this->data) !== false;
		return null;	
	}
	
	// Countable
	public function count()
	{
		if($this->data === null)
			return 0;
		return sizeof($this->data);
	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		if($this->data === null)
			return false;
		return isset($this->data[$offset]);
	}
	
	public function offsetGet($offset)
	{
		if($this->data === null || !isset($this->data[$offset]))
			return new AxArrayObject(null, $this, $offset);
		if(is_array($this->data[$offset]))
		{
			$obj = new AxArrayObject(null, $this, $offset);
			$obj->setRefData($this->data[$offset]);
			return $obj;
		}
		else
			return $this->data[$offset];
	}
	
	public function offsetSet($offset, $value)
	{
		if($this->data === null)
			$this->createArray();
		$this->SetChanged();
		$this->data[$offset] = $value;
	} 
	
	public function offsetUnset($offset)
	{
		$this->SetChanged();
		unset($this->data[$offset]);
	}
}
?>