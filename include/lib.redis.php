<?
/**
 * @link http://code.google.com/p/redis/wiki/ProtocolSpecification
 * @link http://code.google.com/p/redis/wiki/CommandReference
 *
 */
class lib_Redis
{
	private $databases		= array(
		'default'		=> 0,
		'sessions'		=> 1,
		'advertise'		=> 2,
		'antiflood'		=> 3,
		'events'		=> 4,
		'queues'		=> 5,
		'passport'		=> 6,
		'domain'		=> 7,
		'exchange'		=> 8,
	);

	/**
	 * Пул сокетов. (статичная, т.к. одна на все экземпляры)
	 * Хранит ассоциативный массив сокетов по ключам вида host_ip:port
	 */
	private static $_sockets	= array();

	/**
	 * Текущая выбранная БД. (статичная, т.к. одна на все экземпляры)
	 * Хранит ассоциативный массив выбранных БД по ключам вида host_ip:port
	 */
	private static $selected_db	= array();

	public $slave			= null;

	// Текущий сокет
	private $_sock			= null;
	// Текущая БД
	private $db 			= null;
	private $db_name		= null;
	// Текущий хост
	private $host 		= null;
	private $host_ip	= null;
	// Текущий порт
	private $port 		= 6379;



	/**
	 * Метод инициализации библиотеки.
	 * @param $db текущая БД
	 * @exception RuntimeBTException
	 */
	public function Init($db)
	{
		$this->_Init($db);
		$this->slave = new self();
		$this->slave->InitSlave($db);
	}


	/**
	 * Метод инициализации слейва.
	 * @param $db текущая БД
	 * @exception RuntimeBTException
	 */
	private function InitSlave($db)
	{
		$this->_Init($db, false);
	}


	private function _Init($db = '', $master = true)
	{
		// Запрет на повторную инициализацию.
		if( $this->db !== null )
			throw new RuntimeBTException('Allready initialized.');

		if( !isset($this->databases[$db]) )
			throw new RuntimeBTException('Database not found.');

		//2do: переделать на правильные seffixы
		if ( $master === true )
			$this->host = "localhost";

		$this->db = $this->databases[$db];
		$this->db_name = $db;
	}


	/**
	 * Подключение к Редису.
	 * @exception RuntimeBTException
	 */
	private function _connect()
	{
		if( $this->host_ip === null )
			$this->host_ip = gethostbyname($this->host);
		$full_host = $this->host_ip . ':' . $this->port;

		if( !(isset(self::$_sockets[$full_host]) && is_resource(self::$_sockets[$full_host])) )
		{
			if ( false === (self::$_sockets[$full_host] = @fsockopen($this->host_ip, $this->port, $errno, $errmsg, 3)) )
			{
				$msg = 'Can not open socket to ' . $this->host_ip . ':' . $this->port;
				if ($errno || $errmsg)
					$msg .= ',' . ($errno ? ' error ' . $errno : '') . ($errmsg ? ' ' . $errmsg : '');
				throw new RuntimeBTException($msg);
			}
		}

		$this->_sock = self::$_sockets[$full_host];

		$this->select_db($full_host);
	}


	/**
	 * Отключение от Редиса.
	 * Закрытие сокета.
	 * @return bool
	 * 		true - удалось закрыть сокет,
	 * 		false - не удалось закрыть сокет.
	 */
	private static function _disconnect($full_host)
	{
		if ( !is_resource(self::$_sockets[$full_host]) )
			return true;

		// По спецификации необходимо делать QUIT.
	    // http://code.google.com/p/redis/wiki/QuitCommand
		$result = fwrite( self::$_sockets[$full_host], "QUIT\r\n");
		if ( $result === false )
			throw new RuntimeBTException('Sended Redis command QUIT. Problem with writing in socket.');

	    fclose(self::$_sockets[$full_host]);
	}


	/**
	 * Вызывается 1 раз при завершении работы движка.
	 * Задачи:
	 * - Отключение от Редиса.
	 * - Закрытие сокета.
	 */
	public static function Dispose()
	{
		foreach( self::$_sockets as $full_host => $sock )
			self::_disconnect($full_host);

		self::$_sockets = array();
	}


	/**
	 * Выбор БД.
	 * @exception RuntimeBTException
	 */
	private function select_db($full_host)
	{
		if( !isset(self::$selected_db[$full_host]) )
			self::$selected_db[$full_host] = null;

		if( $this->db === self::$selected_db[$full_host] )
			return;

		$this->write("SELECT ".$this->db."\r\n");
		if( $this->get_response() != 'OK' )
			throw new RuntimeBTException('Unknown error when selecting.');

		$this->selected_db = $this->db;
	}


	/**
	 * Запись данных в сокет.
	 */
	private function write($s)
	{
		while ($s)
		{
			$i = fwrite($this->_sock, $s);
			if ($i == 0) // || $i == strlen($s))
				break;
			$s = substr($s, $i);
		}
	}


	/**
	 * Чтение данных из сокета.
	 */
	private function read( )
	{
		if ($s = fgets($this->_sock))
			return $s;
		throw new RuntimeBTException('Cannot read from socket.');
	}


	/**
	 * Разбор ответа полученного из сокета.
	 */
	private function get_response()
	{

		$data = trim($this->read());

		$c = $data[0];
		if( strlen($data) < 2 )
			$data = null;
		else
			$data = substr($data, 1);

		switch ($c)
		{
			case '-': // Ошибка.
				throw new RuntimeBTException($data === null ? 'NULL reply' : $data);
			case '+': // Однострочный ответ.
				return $data === null ? '' : $data;
			case ':':
				if( $data === null )
					return 0;
				$is_float = (strpos($data, '.') === false && strpos($data, ',') === false ) ? false : true;
				if( $is_float )
					return (float) $data;
				else
				{
					$i = (int) $data;
					if( (string)$i != $data)
						throw new RuntimeBTException('Cannot convert data '.$c.$data.' to integer');
					return $i;
				}
			case '$': // Многострочный ответ. Массив.
				if( $data === null )
					return null;
				return $this->get_bulk_reply($c . $data);
			case '*':
				if( $data === null )
					return null;
				$num = (int) $data;
				if ((string)$num != $data)
					throw new RuntimeBTException('Cannot convert multi-response header '.$data.' to integer');
				$result = array();
				for ($i=0; $i<$num; $i++)
					$result[$i] =& $this->get_response();
				return $result;
			default:
				throw new RuntimeBTException('Invalid reply type byte: '.$c);
		}
	}


	/**
	 * Обработка многострочного ответа.
	 */
	private function get_bulk_reply($data=null)
	{
		if ($data === null)
			$data = trim($this->read());

		if ($data == '$-1')
			return null;

		$c = $data[0];
		if( strlen($data) < 2 )
			return null;

		$data = substr($data, 1);
		$bulklen = (int)$data;
		if ((string)$bulklen != $data)
			throw new RuntimeBTException('Cannot convert bulk read header '.$c.$data.' to integer');
		if ($c != '$')
			throw new RuntimeBTException('Unknown response prefix for '.$c.$data);
		$buffer = '';
		while ($bulklen)
		{
			$data = fread($this->_sock, $bulklen);
			$bulklen -= strlen($data);
			$buffer .= $data;
		}
		fread($this->_sock, 2);
		return $buffer;
	}


	/**
	 * Восстанавливает ключ
	 * @param string $key ключ кэша
	 * @return string
	 */
	public function RestoreKey($key)
	{
		return str_replace($this->prefix .':', '', $key);
	}

// Commands operating on all value types

	/**
	 * Проверка наличия ключа.
	 * @param string $key ключ кэша
	 * @return bool
	 */
	public function Exists($key)
	{
		return $this->_cmd('EXISTS',$key);
	}


	/**
	 * Удаление ключа.
	 * @param $key ключ кэша
	 */
	public function Del($key)
	{
		return $this->_cmd('DEL',$key);
	}


	/**
	 * Узнать тип данных по ключу.
	 * @param $key ключ кэша
	 * @return string
	 *		"none" if the key does not exist
	 *		"string" if the key contains a String value
	 *		"list" if the key contains a List value
	 * 		"set" if the key contains a Set value
	 *		"zset" if the key contains a Sorted Set value
	 * 		"hash" if the key contains a Hash value
	 */
	public function Type($key)
	{
		return $this->_cmd('TYPE',$key);
	}


	/**
	 * Получание ключей, удовлетворяющих заданному шаблону.
	 * !!! Не забываем про префикс, который передан в метод connection.
	 * @param string $pattern регулярное выражение
	 * 		h?llo will match hello hallo hhllo
	 * 		h*llo will match hllo heeeello
	 * 		h[ae]llo will match hello and hallo, but not hillo
	 * @return array
	 */
	public function Keys($pattern)
	{
		return $this->_cmd('KEYS',$pattern);
	}


	/**
	 * Из существующих ключей, вернуть любой.
	 * @return string
	 */
	public function RandomKey()
	{
		return $this->_cmd('RANDOMKEY');
	}


	/**
	 * Переименовать ключ $oldkey в $newkey
	 * @param string $oldkey ключ кэша
	 * @param string $newkey ключ кэша
	 * @return bool
	 */
	public function Rename($oldkey, $newkey)
	{
		return $this->_cmd('RENAME',$oldkey,$newkey);
	}


	/**
	 * Переименовать ключ $oldkey в $newkey, если $newkey отсутствует.
	 * @param string $oldkey ключ кэша
	 * @param string $newkey ключ кэша
	 * @return bool
	 */
	public function RenameNx($oldkey, $newkey)
	{
		return $this->_cmd('RENAMENX',$oldkey,$newkey);
	}


	/**
	 * Кол-во ключей в БД.
	 */
	public function dbsize()
	{
		return $this->_cmd('DBSIZE');
	}


	/**
	 * Установить время жизни для ключа.
	 * Если ключ уже имеет время жизни - оно не меняется.
	 * @param string $key ключ кэша
	 * @param int $lifetime время жизни
	 * @return bool
	 */
	public function Expire($key, $lifetime = 0)
	{
		$lifetime = intval($lifetime);
		return $this->_cmd('EXPIRE',$key,$lifetime);
	}


	/**
	 * Установить время смерти для ключа.
	 * @param string $key ключ кэша
	 * @param int $timestamp время смерти
	 * @return bool
	 */
	public function ExpireAt($key, $timestamp)
	{
		$timestamp = intval($timestamp);
		return $this->_cmd('EXPIREAT',$key,$timestamp);
	}


	/**
	 * Сброс установленных ранее времени жизни/смерти.
	 * @param string $key ключ кэша
	 */
	public function Persist($key)
	{
		return $this->_cmd('PERSIST',$key);
	}


	/**
	 * !!! ВАЖНО ДЛЯ ПОНИМАНИЯ
	 * !!! Возвращает значение установленное только EXPIRE, не EXPIREAT.
	 * Получить время жизни для ключа
	 * @param string $key ключ кэша
	 * @return int
	 */
	public function TTL($key)
	{
		return $this->_cmd('TTL',$key);
	}

// Commands operating on string values

	/**
	 * Запись данных в кэш
	 * @param string $key ключ кэша
	 * @param mixed $value значение
	 * @param int $lifetime время жизни
	 * @return bool
	 */
	public function Set($key, $value, $lifetime = 0)
	{
		$lifetime = intval($lifetime);

		if ( $lifetime > 0 )
			return $this->_cmd('SETEX',$key,$lifetime,$value);
		else
			return $this->_cmd('SET',$key,$value);
	}


	/**
	 * Получение данных из кэша
	 * @param string $key ключ кэша
	 * @return mixed
	 */
	public function Get($key)
	{
		return $this->_cmd('GET',$key);
	}


	/**
	 * Установить значение ключа $key и вернуть предыдущее его значение.
	 * @param string $key ключ кэша
	 * @param string $value новое значение
	 * @return array
	 */
	public function GetSet($key, $value)
	{
		return $this->_cmd('GETSET',$key,$value);
	}


	/**
	 * Получить несколько значений из базы.
	 * @param string $keys ключи кэша
	 * @return array
	 */
	public function MGet($keys)
	{
		if ( !is_array($keys) )
			return false;
		return $this->_cmd('MGET',$keys);
	}


	/**
	 * Записать несколько значений в кэш.
	 * @param array $data ассоциативный массив ключ-значение
	 * @param int $lifetime время жизни
	 * @return bool
	 */
	public function MSet($data, $lifetime = 0)
	{
		if( !is_array($data) )
			return false;

		$lifetime = intval($lifetime);

		if ( $lifetime > 0 )
		{
			$res = $this->_cmd('MSET',$data);

			foreach ( $data as $key => $value )
				$this->Expire($key, $lifetime);

			return $res;
		}
		else
			return $this->_cmd('MSET',$data);
	}


	/**
	 * Записать несколько значений в кэш.
	 * Ключи буду записаны, только, если они не существуют.
	 * @param array $data ассоциативный массив ключ-значение
	 * @return bool
	 */
 	public function MSetNx($data, $lifetime = 0)
 	{
		if( !is_array($data) )
			return false;

		$lifetime = intval($lifetime);

		if ( $lifetime > 0 )
		{
			$res = $this->_cmd('MSETNX',$data);

			foreach ( $data as $key => $value )
				$this->Expire($key, $lifetime);

			return $res;
		}
		else
			return $this->_cmd('MSETNX',$data);
 	}


	/**
	 * Инкремент данных в кэше.
	 * @param string $key ключ кэша
	 * @param int $value значение
	 * @return bool
	 */
	public function Incr($key, $value = 0)
	{
		$value = intval($value);
		if( $value > 0 )
			return $this->_cmd('INCRBY',$key,$value);
		else
			return $this->_cmd('INCR',$key);
	}


	/**
	 * Декремент данных в кэше
	 * @param string $key ключ кэша
	 * @param int $value значение
	 * @return bool
	 */
	public function Decr($key, $value = 0)
	{
		$value = intval($value);
		if( $value > 0 )
			return $this->_cmd('DECRBY',$key,$value);
		else
			return $this->_cmd('DECR',$key);
	}


	/**
	 * Запись данных в кэш, при условии отсутствия ключа в кэше.
	 * @param string $key ключ кэша
	 * @param mixed $value значение
	 * @param int $lifetime время жизни
	 * @return bool
	 */
	public function SetNx($key, $value, $lifetime = 0)
	{
		$lifetime = intval($lifetime);
		$result = $this->_cmd('SETNX',$key,$value);
		if( $lifetime > 0 )
			$this->Expire($key,$lifetime);
		return $result;
	}


	/**
	 * Дописывает значение указанному ключу.
	 * @param string $key ключ кэша
	 * @param int $value значение
	 * @return int длина значения после добавления
	 */
 	public function Append($key,$value)
 	{
		return $this->_cmd('APPEND',$key,$value);
	}


	/**
	 * Возвращает подстроку от значения ключа.
	 * @param $key ключ
	 * @param $start
	 * @param $end
	 * @return array
	 */
	public function Substr($key,$start,$end)
	{
		$start = intval($start);
		$end = intval($end);
		return $this->_cmd('SUBSTR',$key,$start,$end);
	}


	/**
	 * Главный метод исполняющий команды.
	 */
	private function _cmd()
	{
		if( func_num_args() == 0 )
			throw new RuntimeBTException('No arguments!');

		$cnt = func_num_args();

		$args = func_get_args();

		// Команда.
		$cmd = array_shift($args);

		$q = '';

		// Не стандартная ситуация.
		// В этих командах такой образец
		// ZUNIONSTORE Ключ количество_объединяемых_ключей Ключ1 Ключ2 ... КлючN
		// ZINTERSTORE Ключ количество_объединяемых_ключей Ключ1 Ключ2 ... КлючN
		if( $cmd == 'ZUNIONSTORE' || $cmd == 'ZINTERSTORE' )
		{
			$args = $args[0];
			$key = array_shift($args);
			$q.= "$" . strlen($key) . "\r\n" . $key . "\r\n";
			// кол-во ключей (требуется спецификация http://code.google.com/p/redis/wiki/ZunionstoreCommand)
			$q.= "$" . strlen(count($args)) . "\r\n" . count($args) . "\r\n";
			// ZINTERSTORE + $key + count($args) + ключи
			$cnt = 3 + count($args);
		}
		// В этих командах такой образец
		// MSET Ключ1 Значение1 Ключ2 Значение2 ... КлючN ЗначениеN
		// MSETNX Ключ1 Значение1 Ключ2 Значение2 ... КлючN ЗначениеN
		else if( $cmd == 'MSET' || $cmd == 'MSETNX' )
		{
			foreach ( $args as $key => $value )
			{
				if( is_array($value) )
				{
					foreach($value as $_key => $_value)
					{
						$q.= "$" . strlen($_key) . "\r\n" . $_key . "\r\n";
						$q.= "$" . strlen($_value) . "\r\n" . $_value . "\r\n";
					}

					// Для правильного подсчёта, переменная
					// оказалась массивом, поэтому учитываем не саму
					// переменную, а её элементы: ключ + значение.
					$cnt = $cnt + count( $value ) * 2;
					$cnt--;
				}
				else
				{
					$q.= "$" . strlen($key) . "\r\n" . $key . "\r\n";
					$q.= "$" . strlen($value) . "\r\n" . $value . "\r\n";
				}
			}
			unset($args);
		}


		if( is_array($args) && count($args) > 0 )
		{
			foreach( $args as $arg )
			{
				if( is_array($arg) )
				{
					if( $cmd == 'HMSET' )
					{
						foreach($arg as $k => $v)
						{
							$q.= "$" . strlen($k) . "\r\n" . $k . "\r\n";
							$q.= "$" . strlen($v) . "\r\n" . $v . "\r\n";
						}
					}
					else
					{
						foreach($arg as $v)
							$q.= "$" . strlen($v) . "\r\n" . $v . "\r\n";
					}
					$cnt = $cnt + count( $arg );
					$cnt--;
				}
				else
					$q.= "$" . strlen($arg) . "\r\n" . $arg . "\r\n";
			}
		}

		$query = "*" . $cnt . "\r\n";
		$query.= "$" . strlen($cmd) . "\r\n" . $cmd . "\r\n";
		$query.= $q;

		if ( defined("REDIS_DEBUG") && REDIS_DEBUG )
			echo $query . "\n\n";

		$this->_connect();

		$this->write($query);
		$data = $this->get_response();

		unset($q,$query,$args,$cmd);
		
		return $data;
	}

// Commands operating on lists

	/**
	 * Добавляет значение в список
	 * @param string $key ключ кэша
	 * @param mixed $value значение
	 * @param string $type L или R
	 * @return int вернёт кол-во элементов в списке после добавления
	 */
	public function lPush($key, $value)
	{
		return $this->_cmd('LPUSH',$key,$value);
	}


	/**
	 * Добавляет значение в список
	 * @param string $key ключ кэша
	 * @param mixed $value значение
	 * @param string $type L или R
	 * @return int вернёт кол-во элементов в списке после добавления
	 */
	public function rPush($key, $value)
	{
		return $this->_cmd('RPUSH',$key,$value);
	}


	/**
	 * Извлекает значени из списка слева
	 * @param string $key ключ кэша
	 * @return string
	 */
	public function lPop($key)
	{
		return $this->_cmd('LPOP',$key);
	}


	/**
	 * Извлекает значени из списка справа
	 * @param string $key ключ кэша
	 * @return string
	 */
	public function rPop($key)
	{
		return $this->_cmd('RPOP',$key);
	}


	/**
	 * Возвращает размер списка, идентифицированного ключом
	 * @param string $key ключ кэша
	 * @return int
	 */
	public function lLen($key)
	{
		return $this->_cmd('LLEN',$key);
	}


	/**
	 * Запись элемента списка
	 * @param string $key ключ кэша
	 * @param int $index индекс элемента (с 0, -1 - полседний, -2 -предпоследний и т.д.)
	 * @param mixed $value значение
	 * @return bool
	 */
	public function lSet($key, $index, $value)
	{
		$index = intval($index);
		return $this->_cmd('LSET',$key, $index, $value);
	}


	/**
	 * Получение нескольких элементов списка
	 * @param string $key ключ кэша
	 * @param int $start индекс первого элемента
	 * @param int $end индекс последнего элемента (если не указать - начиная с заданного)
	 * @return array
	 */
	public function lRange($key, $start, $end = -1)
	{
		$start = intval($start);
		$end = intval($end);
		return $this->_cmd('LRANGE',$key,$start,$end);
	}


	/**
	 * Обрезка списка по заданным границам
	 * @param string $key ключ кэша
	 * @param int $start индекс первого элемента
	 * @param int $end индекс последнего элемента (если не указать - начиная с заданного)
	 * @return array
	 */
	public function lTrim($key, $start, $end = -1)
	{
		$start = intval($start);
		$end = intval($end);
		return $this->_cmd('LTRIM',$key,$start,$end);
	}


	/**
	 * Удаление первых $count повторов заданного значения $value из списка
	 * Если $count < 0 элементы удаляются с конца списка
	 * @param string $key ключ кэша
	 * @param string $value значение
	 * @param int $count количество элементов
	 * @return int
	 */
	public function lRem($key, $value, $count = 0)
	{
		$count = intval($count);
		return $this->_cmd('LREM',$key,$count,$value);
	}

// Commands operating on sets

	/**
	 * Добавляет значение в множество
	 * @param string $key ключ кэша
	 * @param string $value значение
	 * @return bool
	 */
	public function sAdd($key, $value)
	{
		return $this->_cmd('SADD',$key,$value);
	}


	/**
	 * Проверка принадлежности элемента $value множеству $key
	 * @param string $key ключ кэша
	 * @param string $value значение
	 * @return bool
	 */
	public function sIsMember($key,$value)
	{
		return $this->_cmd('SISMEMBER',$key,$value);
	}


	/**
	 * Получение размера множества $key
	 * @param string $key ключ кэша
	 * @return bool
	 */
	public function sCard($key)
	{
		return $this->_cmd('SCARD', $key);
	}


	/**
	 * Извлечение и удаление случайного элемента из множества $key
	 * @param string $key ключ кэша
	 * @return bool
	 */
	public function sPop($key)
	{
		return $this->_cmd('SPOP', $key);
	}


	/**
	 * Извлечение множества $key
	 * @param string $key ключ кэша
	 * @return array
	 */
	public function sMembers($key)
	{
		return $this->_cmd('SMEMBERS', $key);
	}


	/**
	 * Извлечение случайного элемента из множества $key
	 * @param string $key ключ кэша
	 * @return bool
	 */
	public function sRandMember($key)
	{
		return $this->_cmd('SRANDMEMBER', $key);
	}


	/**
	 * Находит пересечение множеств
	 * @param array $keys ключи кэша
	 * @return array
	 */
	public function sInter($keys = array())
	{
		return $this->_cmd('SINTER',$keys);
	}


	/**
	 * Находит разность множеств
	 * @param array $keys ключи кэша
	 * @return array
	 */
	public function sDiff($keys = array())
	{
		return $this->_cmd('SDIFF',$keys);
	}


	/**
	 * Находит разность множеств и сохраняет в новый ключ
	 * @param string $newkey ключ для хранения результата
	 * @param array ключи кэша
	 * @return array
	 */
	public function sDiffStore($newkey,$keys=array())
	{
		array_unshift($keys,$newkey);
		return $this->_cmd('SDIFFSTORE',$keys);
	}


	/**
	 * Находит пересечение множеств
	 * @param string $newkey ключ для хранения результата
	 * @param array $keys ключи кэша
	 * @return array
	 */
	public function sInterStore($newkey,$keys=array())
	{
		array_unshift($keys,$newkey);
		return $this->_cmd('SINTERSTORE',$keys);
	}


	/**
	 * Находит объединение множеств
	 * @param array $keys
	 * @return array
	 */
	public function sUnion($keys = array())
	{
		return $this->_cmd('SUNION',$keys);
	}


	/**
	 * Находит объединение множеств и сохраняет в новый ключ
	 * @param string $newkey ключ для хранения результата
	 * @param array $keys
	 * @return array
	 */
	public function sUnionStore($newkey,$keys=array())
	{
		array_unshift($keys,$newkey);
		return $this->_cmd('SUNIONSTORE',$keys);
	}


	/**
	 * Удаляет элемент набора.
	 * @param $key
	 * @param $value
	 * @return bool
	 */
	public function sRem($key, $value)
	{
		return $this->_cmd('SREM',$key,$value);
	}


	/**
	 * Переносит значение $value из множества $key1 в множество $key2
	 * @param string $key1 исходный ключ кэша
	 * @param string $key2 конечный ключ кэша
	 * @param string $value переносимое значение
	 * @return bool
	 */
	public function sMove($key1, $key2, $value)
	{
		return $this->_cmd('SMOVE',$key1,$key2,$value);
	}


	/**
	 * Удаление данных из кэша
	 * @param mixed $keys ключ(и) кэша
	 * @return bool
	 */
	public function Remove($keys)
	{
		if ( is_array($keys) )
		{
			foreach ( $keys as $k )
				$this->Del($k);
		}
		else
			return $this->Del($keys);
	}

// Не реализованные.

	/**
	 * Select the DB with the specified index
	 */
	public function select()
	{
	}

	/**
	 * Remove all the keys from the currently selected DB
	 */
	public function flushdb()
	{
	}


	/**
	 * Remove all the keys from all the databases
	 */
	public function flushall()
	{
	}


	public function lIndex()
	{
	}


	public function blpop()
	{
	}


	public function brpop()
	{
	}


	public function rpoplpush()
	{
	}


	public function sort()
	{
	}


// Commands operating on sorted zsets (sorted sets)

	/**
	 * Добавляет значение в сортированное множество с заданным весом
	 * @param string $key ключ кэша
	 * @param mixed $value значение
	 * @param double $score вес элемента
	 * @return bool
	 */
	public function zAdd($key, $value, $score)
	{
		$score = floatval($score);
		return $this->_cmd('ZADD',$key,$score,$value);
	}


	/**
	 * Возвращает элементы сортированного множества с диапазоном веса
	 * @param string $key ключ кэша
	 * @param int $start номер первого элемента
	 * @param int $end номер последнего элемента
	 * @param bool $withscores вернуть двумерный массив с весом элементов
	 * @return array
	 */
	public function zRange($key, $start, $end, $withscores = false)
	{
		$withscores = (int) $withscores;

		// Скрытое послание идиотам, которые писали официальную документаци
		// к Редису. Вам, что трудно написать и привести пример про параметр WITHSCORES.

		// Я передавал 0,1,true,false - один хрен, Syntax Error.
	 	// Из документации и путём проб - не ясно, что передавать, какое значение :(

		// return $this->_cmd('ZRANGE',$key,$start,$end,$withscores);

		return $this->_cmd('ZRANGE',$key,$start,$end);
	}


	/**
	 * Возвращает элементы сортированного множества с заданным диапазоном в обратном порядке
	 * @param string $key ключ кэша
	 * @param int $start номер первого элемента
	 * @param int $end номер последнего элемента
	 * @param bool $withscores вернуть двумерный массив с весом эелементов
	 * @return array
	 */
	public function zReverseRange($key, $start, $end, $withscores = false)
	{
		$withscores = (int) $withscores;
		return $this->_cmd('ZREVRANGE',$key,$start,$end,$withscores);
	}


	/**
	 * Возвращает элементы сортированного множества с заданным диапазоном веса
	 * @param string $key ключ кэша
	 * @param int $start вес первого элемента
	 * @param int $end вес последнего элемента
	 * @param array $options опции: Array( withscores => TRUE,  limit => array($offset, $count) )
	 * @return array
	 */
	public function zRangeByScore($key, $start, $end, $options = array())
	{
		$start = intval($start);
		$end = intval($end);

		if( isset($options['limit']) && !isset($options['withscores']) )
		{
			$offset = intval($options['limit'][0]);
			$count = intval($options['limit'][1]);

			return $this->_cmd('ZRANGEBYSCORE',$key, $start, $end, $offset, $count);
		}
		else if( isset($options['limit']) && isset($options['withscores']) )
		{
			$offset = intval($options['limit'][0]);
			$count = intval($options['limit'][1]);

			$withscores = (int) $withscores;

			return $this->_cmd('ZRANGEBYSCORE',$key, $start, $end, $offset, $count, $withscores);
		}
		else
			return $this->_cmd('ZRANGEBYSCORE',$key, $start, $end);
	}


	/**
	 * Удаляет значение из сортированного множества
	 * @param string $key ключ кэша
	 * @param string $value значение
	 * @return bool
	 */
	public function zRem($key, $value)
	{
		return $this->_cmd('ZREM',$key,$value);
	}


	/**
	 * Удаляет элементы сортированного множества с заданным диапазоном веса
	 * @param string $key ключ кэша
	 * @param int $start вес первого элемента
	 * @param int $end вес последнего элемента
	 * @return bool
	 */
	public function zRemoveRangeByScore($key, $start, $end)
	{
		$start = intval($start);
		$end = intval($end);
		return $this->_cmd('ZREMOVERANGEBYSCORE',$key,$start,$end);
	}


	/**
	 * Возвращает количество элементов  множества с заданным диапазоном веса
	 * @param string $key ключ кэша
	 * @return int
	 */
	public function zCount($key, $start, $end)
	{
		$start = intval($start);
		$end = intval($end);
		return $this->_cmd('ZCOUNT',$key,$start,$end);
	}


	/**
	 * Возвращает количество элементов  сортированного множества
	 * @param string $key ключ кэша
	 * @return int
	 */
	public function zCard($key)
	{
		return $this->_cmd('ZCARD',$key);
	}


	/**
	 * Возвращает вес заданного элемента  сортированного множества
	 * @param string $key ключ кэша
	 * @param int $value значение элемента
	 * @return int
	 */
	public function zScore($key, $value)
	{
		return $this->_cmd('ZSCORE',$key,$value);
	}


	/**
	 * Возвращает порядок заданного элемента  сортированного множества
	 * @param string $key ключ кэша
	 * @param string $value значение элемента
	 * @return mixed
	 */
	public function zRank($key, $value)
	{
		return $this->_cmd('ZRANK',$key,$value);
	}


	/**
	 * Увеличивает вес заданного элемента сортированного множества на заданное значение
	 * @param string $key ключ кэша
	 * @param string $value элемент
	 * @param double $increment прибавка веса
	 * @return bool
	 */
	public function zIncrBy($key, $value, $increment)
	{
		$increment = floatval($increment);
		return $this->_cmd('ZINCRBY',$key,$increment,$value);
	}


	/**
	 * Находит объединение сортированных множеств
	 * @param array $keys ключи кэша, первый элемент
	 * новый ключ состоящий из элементов следующих ключей.
	 * @return array
	 */
	public function zUnionStore()
	{
		$keys = func_get_args();
		return $this->_cmd('ZUNIONSTORE',$keys);
	}


	/**
	 * Находит пересечение сортированных множеств
	 * @param array $keys ключи кэша, первый элемент
	 * новый ключ состоящий из элементов следующих ключей.
	 * @return array
	 */
	public function zInterStore($keys)
	{
		return $this->_cmd('ZINTERSTORE',$keys);
	}

// Hash Commands

	/**
	 * Запись данных в хэш-таблицу, при условии их отсутствия
	 * @param string $key ключ кэша
	 * @param string $hashKey ключ кэша
	 * @param mixed $value значение
	 * @return bool
	 */
	public function hSet($key, $hashKey, $value)
	{
		return $this->_cmd('HSET',$key,$hashKey,$value);
	}


	/**
	 * Записать ассоциативный массив в хэш-таблицу
	 * @param string $key ключ кэша
	 * @param array $data ассоциативный массив
	 * @return bool
	 */
	public function hMSet($key, $data=array())
	{
		return $this->_cmd('HMSET',$key,$data);
	}


	/**
	 * Получение данных из хэш-таблицы
	 * @param string $key ключ кэша
	 * @param string $hashKey ключ хеш-таблицы
	 * @return string
	 */
	public function hGet($key, $hashKey)
	{
		return $this->_cmd('HGET',$key,$hashKey);
	}


	/**
	 * Получить заданные элементы хэш-таблицы в виде двумерного массива
	 * @param string $key ключ кэша
	 * @param array $hashKeys ключи
	 * @return bool
	 */
	public function hMGet($key,$hashKeys=array())
	{
		return $this->_cmd('HMGET',$key,$hashKeys);
	}


	/**
	 * Получение размера хэш-таблицы
	 * @param string $key ключ кэша
	 * @return int
	 */
	public function hLen($key)
	{
		return $this->_cmd('HLEN',$key);
	}


	/**
	 * Удаление элемента хэш-таблицы
	 * @param string $key ключ кэша
	 * @param string $hashKey ключ хеш-таблицы
	 * @return int
	 */
	public function hDel($key, $hashKey)
	{
		return $this->_cmd('HDEL',$key,$hashKey);
	}


	/**
	 * Получить ключи хэш-таблицы
	 * @param string $key ключ кэша
	 * @return array
	 */
	public function hKeys($key)
	{
		return $this->_cmd('HKEYS',$key);
	}


	/**
	 * Получить элементы хэш-таблицы
	 * @param string $key ключ кэша
	 * @return array
	 */
	public function hVals($key)
	{
		return $this->_cmd('HVALS',$key);
	}


	/**
	 * Получить всю хэш-таблицу в виде двумерного массива
	 * @param string $key ключ кэша
	 * @return array
	 */
	public function hGetAll($key)
	{
		return $this->_cmd('HGETALL',$key);
	}


	/**
	 * Увеличение элемента в хэш-таблице на заданное значение
	 * @param string $key ключ кэша
	 * @param string $hashKey ключ кэша
	 * @param string $value значение
	 * @return bool
	 */
	public function hIncrBy($key, $hashKey, $value)
	{
		return $this->_cmd('HINCRBY',$key, $hashKey, $value);
	}


	/**
	 * Проверка наличия значения в хэш-таблице
	 * @param string $key ключ кэша
	 * @param string $hashKey значение
	 * @return bool
	 */
	public function hExists($key, $hashKey)
	{
		return $this->_cmd('HEXISTS',$key,$hashKey);
	}

// Разные команды

	/**
	 * Для теста.
	 * @return string PONG
	 */
	public function ping()
	{
		return $this->_cmd('PING');
	}


	/**
	 * Получение от сервера Редиса служебной информации.
	 */
	public function info()
	{
		return $this->_cmd('INFO');
	}


	/**
	 * Перенос одной записи с ключом в базу с именем $db.
	 */
	public function move($key,$db)
	{
		if( !isset($this->databases[$db]) )
			throw new RuntimeBTException('Database not found.');
		$db = $this->databases[$db];
		return $this->_cmd('MOVE',$key,$db);
	}



}

?>
