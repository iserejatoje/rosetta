<?
abstract class Patterns_QueryDataIterator implements Countable, Iterator
{
	protected $data		= array();
	private $objects	= array();

	/**
	 *
	 * @param filter
	 */
	public function __construct()
	{
		global $OBJECTS;

		$this->getdata();
	}

	// формирование данных
	abstract public function getdata();
	// создание объекта
	public function getobject($data)
	{
		return $data;
	}

	// Iterator
	public function current()
	{
		if($this->data === null)
			return null;

        $k = key($this->data);
        if(!isset($this->objects[$k]))
        {
			$this->objects[$k] = $this->getobject($this->data[$k]);
        }
        return $this->objects[$k];
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
}
?>