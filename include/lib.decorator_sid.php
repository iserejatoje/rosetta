<?

// декоратор, для установки SectionID для вызова всех методов объекта
// http://ru.wikipedia.org/wiki/%D0%94%D0%B5%D0%BA%D0%BE%D1%80%D0%B0%D1%82%D0%BE%D1%80_(%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD_%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F)
// он немного не так реализован как должен быть в идеале, это универсальный класс, который позволяет работать со всеми бубличными методами и свойствами
// - настоящий декоторатор наследуется от базового класса, этот агрегирует, не работают метода определения наследников

class DecoratorSID
{
	private $_object = null;
	private $_sid = 0;
	
	public function __construct($object = null, $sid = 0)
	{
		if($object === null)
			throw new exeption("can't use decorator without object");
		$this->_object = $object;
		$this->_sid = intval($sid);
	}
	
	public function __call($name, $params)
	{
		global $OBJECTS;
		$oldsid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $this->_sid;
		if(!is_callable(array($this->_object, $name)))
			throw new exception("can't call method: ".$name);
		$res = call_user_func_array(array($this->_object, $name), $params);
		$OBJECTS['user']->SectionID = $oldsid;
		return $res;
	}
	
	public function &__get($name)
	{
		global $OBJECTS;
		$oldsid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $this->_sid;
		$res =& $this->_object->$name;
		$OBJECTS['user']->SectionID = $oldsid;
		return $res;
	}
	
	public function __set($name, $value)
	{
		global $OBJECTS;
		$oldsid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $this->_sid;
		$this->_object->$name = $value;
		$OBJECTS['user']->SectionID = $oldsid;
	}
	
	public function __isset($name)
	{
		global $OBJECTS;
		$oldsid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $this->_sid;
		$res = isset($this->_object->$name);
		$OBJECTS['user']->SectionID = $oldsid;
		return $res;
	}
	
	public function __unset($name)
	{
		global $OBJECTS;
		$oldsid = $OBJECTS['user']->SectionID;
		$OBJECTS['user']->SectionID = $this->_sid;
		unset($this->_object->$name);
		$OBJECTS['user']->SectionID = $oldsid;
	}
}

?>