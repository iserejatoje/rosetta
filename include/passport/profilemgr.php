<?
/**
 * Работа с профилями
 */
class PProfileMgr implements ArrayAccess, IDisposable
{
	static $config = array(
	);
	
	// объект профиля, все объекты создаются по мере надобности один раз
	protected $profile = array();
	private $disposed = false;
	private $user = null;
	
	public function __construct($user = null)
	{
		$this->user = $user;
	}
	
	public function __destruct()
	{
		$this->Dispose();
	}
	
	/**
	 * Удаление экземпляра
	 */   	
	public function Dispose()
	{
		if($this->disposed === false)
		{
			// бежим по детям и удаляем
			foreach(array_keys($this->profile) as $k)
			{
				if(is_a($this->profile[$k], 'IDisposable'))
				{
					$this->profile[$k]->Dispose();
					unset($this->profile[$k]);
				}
			}
			$this->disposed = true;
			unset($this->profile);
		}
	}
	
	/**
	 * Фабрика объектов профия
	 *
	 * @param string $name 
	 * @param string $folder
	 * @return PPRofileObject
	 */
	
	static function GetObject($parent, $user, $name, $folder = '')
	{
		global $CONFIG;
		// провайдер
		if(is_file($CONFIG['engine_path'].'include/passport/providers/'.$folder.'p_'.$name.'.php'))
		{
			include_once $CONFIG['engine_path'].'include/passport/providers/'.$folder.'p_'.$name.'.php';
			$cn = 'PProfile_'.str_replace('/', '_', $folder).strtolower($name);
			return new $cn($name, $parent, $user);
		}
		// папка
		else if(is_dir($CONFIG['engine_path'].'include/passport/providers/'.$folder.$name))
		{
			return new PProfileFolder($name, $parent, $user);
		}
		else
		{
			error_log('profile provider '.$name.' not found');
			return null;
		}
	}	
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		global $CONFIG;
		if(isset($this->profile[$offset]))
			return true;
		else
			// хоть директория, хоть файл
			return file_exists($CONFIG['engine_path'].'include/passport/providers/'.$offset);
	}
	
	public function offsetGet($offset)
	{
		if(isset($this->profile[$offset]))
			return $this->profile[$offset];
		else
		{
			$this->profile[$offset] = self::GetObject($this, $this->user, $offset);
			return $this->profile[$offset];
		}
	}
	
	public function offsetSet($offset, $value)
	{

	} 
	
	public function offsetUnset($offset)
	{

	}
}

/**
 * Базовый класс объекта профиля
 *
 */
abstract class PProfileObject implements ArrayAccess, IDisposable
{
	protected $index 	= ''; 		// индекс на который ссылается объект
	protected $parent 	= null;		// родитель или null
	protected $profile	= array();	// дети
	protected $user		= null;
	
	protected function __construct($index, $parent, $user)
	{
		$this->index	= $index;
		$this->parent	= $parent;
		$this->user		= $user;
	}
	
	public function GetFolder()
	{
		$path = '';
		if(is_a($this->parent, 'PProfileObject'))
			$path.= $this->parent->GetFolder();
		$path.= $this->index.'/';
		return $path;
	}
	
	// ArrayAccess
	public function offsetExists($offset){}	
	public function offsetGet($offset){}
	public function offsetSet($offset, $value){}	
	public function offsetUnset($offset){}
	
	public function Dispose()
	{
		// бежим по детям и удаляем
		foreach($this->profile as $k => $v)
			if(is_a($v, 'IDisposable'))
			{
				$v->Dispose();
				unset($v);
			}
		unset($this->profile);
	}
}

class PProfileFolder extends PPRofileObject
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);		
	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		global $CONFIG;
		$path = $this->GetFolder();
		return file_exists($CONFIG['engine_path'].'include/passport/providers/'.$path.$offset);
	}
	
	public function offsetGet($offset)
	{
		if(isset($this->profile[$offset]))
			return $this->profile[$offset];
		else
		{
			$path = $this->GetFolder();
			$this->profile[$offset] = PProfileMgr::GetObject($this, $this->user, $offset, $path);
			return $this->profile[$offset];
		}
	}
	
	public function offsetSet($offset, $value)
	{
		
	}
	
	public function offsetUnset($offset)
	{
		
	}
}

class PProfilePlain extends PProfileObject
{
	protected 	$fields 		= array();
	protected	$custom_fields 	= array();
	private 	$loaded 		= false;
	protected	$changed		= false;
	
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
	}
	
	protected function KeyExists($name)
	{
		return in_array($name, $this->fields);
	}
	
	protected function CustomKeyExists($name)
	{
		return in_array($name, $this->custom_fields);
	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		$this->GetData();
		$offset = strtolower($offset);
		if($this->CustomKeyExists($offset))
			return true;
		else if($this->KeyExists($offset))
			return true;
		else
			return false;
	}
	
	public function offsetGet($offset)
	{
		$this->GetData();
		$offset = strtolower($offset);
		if($this->CustomKeyExists($offset))
			return $this->CustomGet($offset);
		else if($this->KeyExists($offset))
			return $this->profile[$offset];
		else
			return null;
	}
	
	public function offsetSet($offset, $value)
	{
		$this->GetData();
		$this->changed = true;
		$offset = strtolower($offset);
		if($this->CustomKeyExists($offset))
		{
			return $this->CustomSet($offset, $value);
		}
		else if($this->KeyExists($offset))
		{
			$this->profile[$offset] = $value;
		}
	}
	
	public function offsetUnset($offset)
	{
	}
	
	private function GetData()
	{
		if($this->loaded === false)
		{
			$this->Load();
			$this->loaded = true;
		}
	}
	
	public function CustomGet($offset){}
	public function CustomSet($offset, $value){}
	
	public function Save(){}
	public function Load(){}
	
	// для отмены или очистки кэша
	public function SetChanged($changed)
	{
		$this->changed = $changed;
	}
	
	public function Dispose()
	{
		if($this->changed === true)
			$this->Save();
	}
}
?>