<?

// проверка прав пользователя
class PRightsPassportPlugin extends PABasePassportPlugin implements ArrayAccess
{
	private $rights = array();
	
	public function __construct($user, $mgr)
	{
		parent::__construct($user, $mgr, 'Rights');
	}
	
	private function GetObject($parent, $user, $name)
	{
		global $CONFIG;
		if(is_file($CONFIG['engine_path'].'include/passport/plugins/rights/'.$name.'.php'))
		{
			include_once $CONFIG['engine_path'].'include/passport/plugins/rights/'.$name.'.php';
			$cn = 'PRights_'.strtolower($name);
			return new $cn($parent, $user);
		}
		else
		{
			error_log('rights provider '.$name.' not found');
			return null;
		}
    }
	
	public function offsetExists($offset)
	{
		global $CONFIG;
		if(isset($this->rights[$offset]))
			return true;
		else
			return file_exists($CONFIG['engine_path'].'include/passport/plugins/rights/'.$offset);
	}
	
	public function offsetGet($offset)
	{
		if(isset($this->rights[$offset]))
			return $this->rights[$offset];
		else
		{
			$this->rights[$offset] = $this->GetObject($this, $this->user, $offset);
			return $this->rights[$offset];
		}
	}
	
	public function offsetSet($offset, $value)
	{

	} 
	
	public function offsetUnset($offset)
	{

	}
}

abstract class PRightsProvider
{
	protected $user = null;
	protected $parent = null;
	function __construct($parent, $user)
	{
		$this->parent = $parent;
		$this->user=$user;
    }
	
	abstract public function GetPossible();
	abstract public function GetRights($params);
	public function GetDefault()
	{
		return 0;
    }
}

?>