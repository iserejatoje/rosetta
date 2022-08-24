<?
class PPlugins implements IDisposable
{
	private $user;					// объект пользователя
	private $mgr;					// менеджер	
	private $plugins = array();		// плагины пользователя

	public function __construct($user, $mgr)
	{
		$this->user = $user;
		$this->mgr = $mgr;
	}
	
	public function Dispose()
	{
		foreach($this->plugins as $plugin)
		{
			$plugin->Dispose();
			unset($plugin);
		}
	}
	
	public function __get($plugin)
	{
		if(isset($this->plugins[$plugin]))
			return $this->plugins[$plugin];
			
		$this->plugins[$plugin] = $this->LoadPlugin($plugin);
			
		return $this->plugins[$plugin];
	}
	
	private function LoadPlugin($plugin)
	{
		global $CONFIG;
		$fname = $CONFIG['engine_path'].'include/passport/plugins/'.strtolower($plugin).'.php';
		if(is_file($fname))
		{
			include_once $fname;
			$cname = 'P'.$plugin.'PassportPlugin';
			return new $cname($this->user, $this->mgr);
		}
		else
			Data::e_backtrace('Plugin '.$plugin.' not found');
			
		return null;
	}
}

abstract class PABasePassportPlugin implements IDisposable
{
	protected $user;		// объект пользователя
	protected $mgr;			// менеджер	
	protected $name;		// имя плагина
	
	public function __construct($user, $mgr, $name)
	{
		$this->name = $name;
		$this->mgr = $mgr;
		$this->user = $user;
	}
	
	// конструктор наследника должен быть вида
	//public function __construct($user)
	//{
	//	parent::__construct($user, 'имя плагина');
	//}
	
	public function Dispose()
	{
		
	}
	
	public function GetName()
	{
		return $this->name;
	}
	
	public function GetUser()
	{
		return $this->user;
	}
}
?>