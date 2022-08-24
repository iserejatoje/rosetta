<?

class HandlerFactory
{
	static private $config = null;
	static $method = 'HTTP'; // заполнится в GetConfig

	static $env = array();		// окружение, по нему будет проверка

	static function GetInstance($name)
	{
		global $CONFIG;
		self::GetConfig();
		if(is_file($CONFIG['engine_path']."handlers/".$name.".php"))
		{
			include_once $CONFIG['engine_path']."handlers/".$name.".php";
			$classname = 'Handler_'.$name;
			if(class_exists($classname))
				return new $classname;
		}
		return null;
	}

	static function GetIterator()
	{
		global $CONFIG;
		self::GetConfig();
		$config = null;

		if(self::$method == 'HTTP')
			$config =& self::$config['http'];
		else if(self::$method == 'CLI')
			$config =& self::$config['cli'];

		return new RecursiveIteratorIterator(
			new HandlerRecursiveIterator($config));
	}

	static function GetConfig()
	{
		global $CONFIG;
		if(self::$config !== null)
			return;

		if(is_file($CONFIG['engine_path']."configure/handlers.php"))
			self::$config = include_once $CONFIG['engine_path']."configure/handlers.php";
		else
		{
			self::$config = array(
				'http' => array(
						array('name' =>'modules')
					)
				);
		}

		self::$env['devel'] = false;
		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		

		self::$env['uri']		= $_SERVER['REQUEST_URI'];
		$cc = strpos(self::$env['uri'], '?');
		if($cc !== false)
			self::$env['url'] = substr(self::$env['uri'], 0, $cc);
		else
			self::$env['url'] = self::$env['uri'];
		self::$env['uri']		= $_SERVER['REQUEST_URI'];
		self::$env['domain']	= $host;
		self::$env['server']	= $_SERVER['SERVER_ADDR'];
		self::$env['client']	= $_SERVER['REMOTE_ADDR'];
		self::$env['method']	= $_SERVER['REQUEST_METHOD'];		
	}

}

class HandlerRecursiveIterator implements RecursiveIterator
{
	protected $chain = array();
	protected $last = false;
	protected $prev = null;
	protected static $objects = array(); // именованные обработчики

	public function __construct($chain)
	{
		$this->chain = $chain;
	}

	public function hasChildren()
	{
		$el = current($this->chain);
		return $el['type'] == 'chain' && ($el['objects']) && sizeof($el['objects']) > 0;
    }

    public function getChildren()
{
		$el = current($this->chain);
		return new HandlerRecursiveIterator($el['objects']);
    }


	public function current()
	{
		if($this->last === true)
			return false;

		$el = current($this->chain);		
		if($el === false)
			return false;
		
		if(isset($el['object']) && isset(self::$objects[$el['object']]))
		{
			$h = self::$objects[$el['object']];
		}
		else
		{
			$h = HandlerFactory::GetInstance($el['name']);
			if(isset($el['object']))
			{
				self::$objects[$el['object']] = $h;
			}
		}
		if($h != null)
		{
			if($h->Init($el) === false)
				$h = null;

			if($h != null && $h->IsLast() === true)
			{
				$this->last = true;
			}
		}
		else
			return false;

		if($h !== null)
			$this->prev = $h;

		return $h;
	}

	public function key()
	{
		if($this->last === true)
			return false;
		return key($this->chain);
	}

	public function next()
	{
		if($this->prev !== null && $this->prev->IsLast() === true)
			$this->last = true;

		if($this->last === true)
			return false;

		// если последний элемент, выставляем флаг
		$el = current($this->chain);
		if($el['last'] === true)
			$this->last = true;

		next($this->chain);
		$this->tovalid();
	}

	public function rewind()
	{
		$this->last = false;
		$this->prev = null;
		reset($this->chain);

		// к первому валидному
		$this->tovalid();
	}

	public function valid()
	{
		if($this->last === true)
			return false;
		$el = current($this->chain);
		return $el !== false;
	}

	private function tovalid()
	{
		global $OBJECTS;
		if($this->last === true)
			return; // все равно не валидно

		// если дойдет до конца итерации, значит элемент валидный, иначе следующий и так до конца
		for(;current($this->chain) !== false; next($this->chain))
		{
			$el = current($this->chain);
	
			if(isset($el['uri']) && $el['uri'] !== '*')
			{
				if(substr($el['uri'], 0, 1) == '@' && substr($el['uri'], strlen($el['uri']) - 1, 1) == '@')
				{
					if(!preg_match($el['uri'], HandlerFactory::$env['uri'], $matches))
						continue;
					foreach($el['matches'] as $k => $m)
					{
						$this->chain[key($this->chain)]['params'][$m] = $matches[$k];
					}
				}
				else if(strlen($el['uri']) > strlen(HandlerFactory::$env['uri']) ||
						substr(HandlerFactory::$env['uri'], 0, strlen($el['uri'])) != $el['uri'])
					continue;

			}
			if(isset($el['domain']) && is_array($el['domain']))
			{
				foreach($el['domain'] as $domain)
				{

					if(substr($domain, 0, 1) == '@' && substr($domain, strlen($domain) - 1, 1) == '@')
					{
						if(!preg_match($domain, HandlerFactory::$env['domain']))
							continue;
					}
					else if($domain != HandlerFactory::$env['domain'])
						continue;
				}
			}
			if(isset($el['server']) && $el['server'] !== '*')
			{
				if(substr($el['server'], 0, 1) == '@' && substr($el['server'], strlen($el['server']) - 1, 1) == '@')
				{
					if(!preg_match($el['server'], HandlerFactory::$env['server']))
						continue;
				}
				else if($el['server'] != HandlerFactory::$env['server'])
					continue;
			}

			if(isset($el['client']) && $el['client'] !== '*')
			{
				if(substr($el['client'], 0, 1) == '@' && substr($el['client'], strlen($el['client']) - 1, 1) == '@')
				{
					if(!preg_match($el['client'], HandlerFactory::$env['client']))
						continue;
				}
				else if($el['client'] != HandlerFactory::$env['client'])
					continue;
			}

			if(isset($el['method']) && $el['method'] !== '*')
			{
				if(strtoupper($el['method']) != HandlerFactory::$env['method'])
					continue;
			}

			if(isset($el['user']) && !in_array($OBJECTS['user']->ID, $el['user']))
				continue;

			return;
		}
	}
}

abstract class IHandler implements IDisposable
{
	/**
	 * Инициализация
	 * @return bool ошибка
	 */
	abstract public function Init($params);

	/**
	 * Обработка
	 * @return bool ошибка
	 */
	abstract public function Run();

	/**
	 * Данный хендлер последний
	 * @return bool последний
	 */
	public function IsLast()
	{
		return false;
	}
}

