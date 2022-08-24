<?

// декоратор, для установки пространства ролей
// http://ru.wikipedia.org/wiki/%D0%94%D0%B5%D0%BA%D0%BE%D1%80%D0%B0%D1%82%D0%BE%D1%80_(%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD_%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F)
// он немного не так реализован как должен быть в идеале, это универсальный класс, который позволяет работать со всеми бубличными методами и свойствами
// - настоящий декоторатор наследуется от базового класса, этот агрегирует, не работают метода определения наследников

class DecoratorSpace
{
	private $_object = null;
	private $_space = null;
	private $_params = null;

	public function __construct($object = null, $space = '', $params = array())
	{
		if($object === null)
			throw new exeption("can't use decorator without object");
		if(empty($space))
			throw new exeption("can't use empty space");
		$this->_object = $object;
		$this->_space = $space;
		$this->_params = $params;
	}

	public function SetRoleSpaceForThisDecorator($space) // имя длинное, чтобы сложно было создать такое))))
	{
		global $OBJECTS;
		if(!empty($space))
		{
			$this->_space = $space;
			$OBJECTS['user']->Roles->SetSpace($this->_space);
		}
	}

	public function __call($name, $params)
	{
		global $OBJECTS;

		if(!is_callable(array($this->_object, $name)))
			throw new exception("can't call method: ".$name);
		
		if ($OBJECTS['user']) {
			$OBJECTS['user']->Roles->PushSpace($this->_space, $this->_params);
			$res = call_user_func_array(array($this->_object, $name), $params);
			$OBJECTS['user']->Roles->PopSpace();
		} else
			$res = call_user_func_array(array($this->_object, $name), $params);

		return $res;
	}

	public function &__get($name)
	{
		global $OBJECTS;

		if ($OBJECTS['user']) {
			$OBJECTS['user']->Roles->PushSpace($this->_space, $this->_params);
			$res =& $this->_object->$name;
			$OBJECTS['user']->Roles->PopSpace();
		} else
			$res =& $this->_object->$name;

		return $res;
	}

	public function __set($name, $value)
	{
		global $OBJECTS;
		
		if ($OBJECTS['user']) {
			$OBJECTS['user']->Roles->PushSpace($this->_space, $this->_params);
			$this->_object->$name = $value;
			$OBJECTS['user']->Roles->PopSpace();
		} else
			$this->_object->$name = $value;
	}

	public function __isset($name)
	{
		global $OBJECTS;
		
		if ($OBJECTS['user']) {
			$OBJECTS['user']->Roles->PushSpace($this->_space, $this->_params);
			$res = isset($this->_object->$name);
			$OBJECTS['user']->Roles->PopSpace();
		} else
			$res = isset($this->_object->$name);

		return $res;
	}

	public function __unset($name) {
		global $OBJECTS;
		
		if ($OBJECTS['user']) {
			$OBJECTS['user']->Roles->PushSpace($this->_space, $this->_params);
			unset($this->_object->$name);
			$OBJECTS['user']->Roles->PopSpace();
		} else
			unset($this->_object->$name);
	}

	public function getParams() {
		return $this->_params;
	}
}

?>