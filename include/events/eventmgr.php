<?

/**
 * Менеджер событий
 * @updated 16-ноя-2010 16:43:00
 */
class EventMgr
{
	const REDIS_QUEUE_KEY			= 'equeue';		// Имя ключа в Редисе для харнения очереди обработчиков
	const REDIS_LOCK_KEY_PREFIX		= 'lock';		// Префикс ключей блокировки обработчиков
	
	private static $redis = null;							// Объект Redis
	
	/**
	 * Создает событие.
	 * 
	 * @param string name    Имя события. Задает путь к файлу класса события.
	 * @param array params    Данные события
	 */
	public static function Raise($name, $params = array())
	{
		if ( is_file(ENGINE_PATH. 'include/events/events/'. strtolower($name) .'.php') )
		{
			include_once ENGINE_PATH. 'include/events/events/'. strtolower($name) .'.php';
			$cn = 'Event_'. str_replace('/', '_', $name);
			if ( class_exists($cn) )
				$event =& new $cn();
			else
				throw new RuntimeMyException('Event class \''. $cn .'\' not found');
		}
		else
			throw new RuntimeMyException('Event  \''. $name .'\' not found');
		
		$event->Raise($params);
		
		unset($event, $cn);
	}
	
	/**
	 * Помещает обработчик в очередь. Возвращает флаг успеха/неуспеха
	 * 
	 * @param string name    Имя события
	 * @param array params    Параметры события
	 * @return bool
	 * @exception RuntimeBTException
	 */
	public static function PushHandlerToQueue($name, $params = array())
	{
		self::_redis_init();
		
		$data = serialize( array(
			'name' => $name,
			'params' => $params
		));
		
		return self::$redis->rPush(EventMgr::REDIS_QUEUE_KEY, $data);
	}
	
	/**
	 * Извлекает обработчик события из очереди
	 *
	 * @return array
	 * @exception RuntimeBTException
	 */
	public static function &PopHandlerFromQueue()
	{
		self::_redis_init();
		
		$data = self::$redis->lPop(EventMgr::REDIS_QUEUE_KEY);
		$data = @unserialize($data);
		
		if ( !is_array($data) || !isset($data['name']) )
			return null;
		
		return $data;
	}
	
	/**
	 * Получение длины очереди обработчиков очереди
	 *
	 * @return int
	 * @exception RuntimeBTException
	 */
	public static function GetQueueLength()
	{
		self::_redis_init();
		return self::$redis->lLen(self::REDIS_QUEUE_KEY);
	}
	
	/**
	 * Создает объект обработчика
	 * 
	 * @param array h   Параметры обработчика
	 * @return object
	 */
	public static function &GetHandler($h)
	{
		if ( is_file(ENGINE_PATH. 'include/events/handlers/'. $h['name'] .'.php') )
		{
			include_once ENGINE_PATH. 'include/events/handlers/'. strtolower($h['name']) .'.php';
			$cn = 'EventHandler_'. str_replace('/', '_', $h['name']);
			if ( class_exists($cn) )
				$handler =& new $cn($h);
			else
				throw new RuntimeMyException('Event handler class \''. $cn .'\' not found');
		}
		else
			throw new RuntimeMyException('Event handler  \''. $h['name'] .'\' not found');
		
		unset($cn);
		
		return $handler;
	}
	
	
	/**
	 * Получает статус блокировки заданного обработчика
	 *
	 * @param string name    Имя обработчика
	 * @param string key   Ключ блокировки
	 * @return int
	 * @exception RuntimeBTException
	 */
	public static function GetHandlerLockTtl($name, $key = '')
	{
		self::_redis_init();
		return self::$redis->TTL(self::REDIS_LOCK_KEY_PREFIX .':'. $name .':'. $key);
	}
	
	
	/**
	 * Устанавливает статус блокировки заданного обработчика. Возвращает флаг успеха/неуспеха
	 *
	 * @param string name    Имя обработчика
	 * @param int ttl   Период блокировки
	 * @param string key   Ключ блокировки
	 * @return bool
	 * @exception RuntimeBTException
	 */
	public static function SetHandlerLockTtl($name, $ttl, $key = '')
	{
		self::_redis_init();
		return self::$redis->Set(self::REDIS_LOCK_KEY_PREFIX .':'. $name .':'. $key, 1, $ttl);
	}
	
	/**
	 * Выполняет инициализацию Redis
	 *
	 * @exception RuntimeBTException
	 */
	private static function _redis_init()
	{
		if ( self::$redis === null )
		{
			self::$redis = LibFactory::GetInstance('redis');
			self::$redis->Init('events');
		}
	}
}


/**
 * Базовый класс события
 * @author farid
 * @created 16-ноя-2010 16:41:09
 */
abstract class AEvent
{
	private $handlers = array();	// Список обработчиков
	
	protected $params = array();	// Параметры события
	
	/**
	 * Выполняет действия обработчиков или добавляет их в очередь
	 * 
	 * @param array params    Данные события
	 */
	public function Raise($params = array())
	{
		$this->params = $params;
		$this->handlers = $this->ListHandlers();
		
		foreach ( $this->handlers as $h )
		{
			$h['params'] = array_merge( (array) $h['params'], $this->params );
			if ( $h['method'] == 'sync' )
			{
				EventMgr::GetHandler($h)->Run($h['params']);
			}
			else if ( $h['method'] == 'async' )
			{
				EventMgr::PushHandlerToQueue($h['name'], $h['params']);
			}
		}
	}
	
	/**
	 * Загружает список обработчиков в виде массива
	 *
	 * @return array
	 */
	abstract protected function &ListHandlers();
}


/**
 * Базовый класс обработчика событий
 * @author farid
 * @version 1.0
 * @updated 16-ноя-2010 16:43:00
 */
abstract class AEventHandler
{
	protected $name = '';			// Имя обработчика
	protected $method = 'sync';		// Метод
	protected $lock_key = '';		// Ключ блокировки
	protected $lock_ttl = 0;		// Время блокировки
	
	/**
	 * Конструктор класса
	 *
	 * @param array params    Параметры обработчика
	 */
	public function __construct($params)
	{
		$this->name = $params['name'];
		$this->method = $params['method'];
		$this->lock_key = $params['lock']['key'];
		$this->lock_ttl = $params['lock']['ttl'];
	}
	
	/**
	 * Запускает обработчик, вызывая HandleEvent. Возвращает false в случае неупеха.
	 * 
	 * @param params    Данные события
	 * @return bool
	 */
	public function Run($params)
	{
		if ( $this->lock_ttl > 0 && EventMgr::GetHandlerLockTtl($this->name, $this->lock_key) > 0 )
			return null;
		
		$result = $this->HandleEvent($params);
		
		if ( $this->lock_ttl > 0 )
			EventMgr::SetHandlerLockTtl($this->name, $this->lock_ttl, $this->lock_key);
		
		return $result;
	}
	
	/**
	 * Выполняет действия обработчика. Возвращает false в случае неупеха.
	 * 
	 * @param array params    Данные события
	 * @return bool
	 */
	abstract protected function HandleEvent($params);
}

?>
