<?

class AntiFlood2
{
	// константы для генерации ключа, этим занимается сама библиотека
	const K_IP		= 0x0001;		// ip адрес компа и прокси
	const K_USER	= 0x0002;		// идентификатор пользователя
	const K_CUID	= 0x0004;		// uid из cookie пользователя от nginx, разные по сайтам

	private static $_redis	= null;
	private static $_env	= array();
	
	
	/**
	 *	Инициализация
	 *	@param string $action - наименование действия
	 *	@param int $key - тип ключа
	 *	@param int $ttl - период времени
	 *	@param int $request_count - кол-во запросов за период
	 *	@exception RuntimeMyException
	 *	@return bool
	*/
	public static function Init()
	{
		self::$_redis = LibFactory::GetInstance('redis');
		self::$_redis->Init('antiflood');
		self::_set_env();
	}
	
	
	/**
	 *	Возвращает состояние блокировки с зачислением запроса
	 *	@param string $action - наименование действия
	 *	@param int $key_template - шаблон типа ключа: или побитовая сумма  констант K_IP, K_USER, K_CUID
	 *	@param int $ttl - период времени
	 *	@param int $request_count - кол-во запросов за период
	 *	@exception InvalidArgumentMyException
	 *	@return bool
	*/
	public static function Score($action, $key_template, $ttl, $request_count = 1)
	{
		if ( !is_int($ttl) || !is_int($request_count) || $ttl <= 0 || $request_count <= 0 )
			throw new InvalidArgumentMyException('Invalid arguments supplied for function Antiflood::Score()');
		
		$action_key = self::GetKey($action, $key_template);
		
		$result = true;
		
		// устанавливается счетчик запросов
		if ( !self::$_redis->Exists($action_key) )
		{
			self::$_redis->Set($action_key, $request_count - 1, $ttl);
		}
		else
		{
			$value = self::$_redis->Get($action_key);
			
			if ( $value <= 0 )
				$result = false;
			
			$current_ttl = self::$_redis->TTL($action_key);
			
			if ( $current_ttl <= 0 )
				$current_ttl = $ttl;
			
			self::$_redis->Set(
					$action_key, 
					$value - 1, 
					$current_ttl
				);
		}
		
		return $result;
	}
	
	
	/**
	 *	Возвращает состояние блокировки
	 *	@param string $action - наименование действия
	 *	@param int $key_template - шаблон типа ключа: или побитовая сумма  констант K_IP, K_USER, K_CUID
	 *	@return bool
	*/
	public static function Check($action, $key_template)
	{
		$action_key = self::GetKey($action, $key_template);
		
		$result = true;
		
		// устанавливается счетчик запросов
		if ( !self::$_redis->Exists($action_key) )
			return true;
		
		$value = self::$_redis->Get($action_key);
		if ( $value <= 0 )
			return false;
		
		return true;
	}
	
	
	/**
	 *	Генерация ключа по наименованию действия пользователя и типу ключа
	 *	@param string $action - наименование действия
	 *	@param int $key_template - шаблон типа ключа: или побитовая сумма  констант K_IP, K_USER, K_CUID
	 *	@exception InvalidArgumentMyException
	 *	@return string
	*/
	public static function GetKey($action, $key_template)
	{
		if ( !is_string($action) || !is_int($key_template) || empty($action) || empty($key_template) )
			throw new InvalidArgumentMyException('Invalid arguments supplied for function Antiflood::GetKey()');
		
		$k[] = $action;
		if ( $key_template & self::K_IP )
			$k[] = 'ip='. self::$_env[$key_template & self::K_IP];
		if ( $key_template & self::K_USER )
			$k[] = 'user='. self::$_env[$key_template & self::K_USER];
		if ( $key_template & self::K_CUID )
			$k[] = 'cuid='. self::$_env[$key_template & self::K_CUID];
		
		return implode($k, ':');
    }
	
	private static function _set_env()
	{
		self::$_env[self::K_IP]		= $_SERVER["HTTP_REMOTE_ADDR"];
		self::$_env[self::K_USER]	= App::$User->ID;
		self::$_env[self::K_CUID]	= Request::GetUID();
    }
}

AntiFlood2::Init();

?>