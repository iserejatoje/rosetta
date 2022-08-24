<?php

class Metrika {
	
	const I_SECONDS		= 1;
	const I_MINUTES		= 2;
	const I_HOURS		= 3;
	const I_DAYS		= 4;
	const I_MONTHS 		= 5;
	const I_YEARS 		= 6;
	
	private $server = 'mongodb://metrika.w.mongo';
	private $mongo = null;
	private $db = null;
	
	private static $_me	= null;
	
	
	/**
	 * Инициализация
	 * Создание подключения и объекта Д
	 * 
	 * @param string $_server Параметры сервера
	 * @exception RuntimeMyException
	 */
	function __construct($_server = null)
	{
		if ( $_server === null )
			$_server = $this->server . INTERNAL_SUFFIX;
		
		$this->mongo = new Mongo($_server);
		if ( $this->mongo === null )
			throw new RuntimeMyException("Can't create MongoDB connection");
		
		$this->db = $this->mongo->metrika;
		
		if ( $this->db === null )
			throw new RuntimeMyException("Can't connect to MongoDB 'metrika'");
	}
	
	
	/**
	 * Синглтон
	 */
	public static function getInstance($_server = null)
	{
		if ( self::$_me === null )
		{
			$cl = __CLASS__;
			self::$_me = new $cl($_server);
		}
		return self::$_me;
	}
	
	
	/**
	 * Инкремент счетчика
	 * Для поиска документа использется полное соответствие полей-документов заданным значениям
	 * 
	 * @param string $name  Имя счетчика
	 * @param int $interval  Интервал счетчика  
	 * @param int $value  Значение инкремента
	 * @param array $sections  Дополнительные разрезы
	 * @param int $time  Время счетчика
	 * @return boolean
	 * @exception RuntimeMyException
	 */
	public function Incr($name, $interval, $value = 1, $sections = null, $time = null)
	{
		$collection = $this->db->selectCollection($name);
		if ( $collection === null )
		{
			$collection = $this->db->createCollection($name);
			if ( $collection === null )
				throw new RuntimeMyException("Can't create metrika collection '". $name ."'");
			
			$collection->ensureIndex( array('date' => 1) );
			$collection->ensureIndex( array('date.year' => 1) );
			$collection->ensureIndex( array('date.month' => 1, 'date.year' => 1) );
			$collection->ensureIndex( array('date.day' => 1, 'date.month' => 1, 'date.year' => 1) );
			$collection->ensureIndex( array('date.hour' => 1, 'date.day' => 1, 'date.month' => 1, 'date.year' => 1) );
			$collection->ensureIndex( array('date.min' => 1, 'date.hour' => 1, 'date.day' => 1, 'date.month' => 1, 'date.year' => 1) );
			$collection->ensureIndex( array('date.sec' => 1, 'date.min' => 1, 'date.hour' => 1, 'date.day' => 1, 'date.month' => 1, 'date.year' => 1) );
			
			$collection->ensureIndex( array('sections' => 1) );
			// создавать составные индексы для разрезов не имеет смысла, т.к., они могут меняться
		}
		
		$object = array( 'date' => array() );
		
		// дата и время счетчика
		if ( $time === null )
			$time = time();
		$object['date'] = self::formDate($time, $interval);
		if ( $object['date'] === false )
			throw new RuntimeMyException("Can't create date for metrika counter");;
		
		$object['timestamp'] = mktime($object['date']['hour'], $object['date']['min'], $object['date']['sec'], $object['date']['month'], $object['date']['day'], $object['date']['year']);
		
		// разрезы
		if ( is_array($sections) )
			$object['sections'] = $sections;
		
		$nattempts = 5;
		$retry = false;
		do
		{
			$row = $collection->findOne($object, array('_id', 'count'));
			if ( $row == null )
			{
				$object['count'] = intval($value);
				$collection->insert($object);
			}
			else
			{
				$collection->update(array('_id' => $row['_id'], 'count' => $row['count']), array('$inc' => array('count' => intval($value))));
				$error = $collection->findOne(array('getlasterror' => 1));
				if ( $error['ok'] == 1 && $error['n'] == 0 )
				{
					$retry = true;
					$nattempts--;
				}
			}
		}
		while ( $retry && $nattempts > 0 );
		
		if ( $nattempts < 0 )
			throw new RuntimeMyException("Metrika::Incr() failed");
		
		return true;
	}
	
	
	/**
	 * Получение суммы по счетчикам, заданным запросом
	 * 
	 * @param string $name  Имя счетчика
	 * @param array $date  Фильтр даты
	 * @param array $sections  Разрезы
	 * @return int
	 * @exception RuntimeMyException
	 */
	public function Sum($name, $date, $sections = null)
	{
		$collection = $this->db->selectCollection($name);
		if ( $collection === null )
			throw new RuntimeMyException("Can't create metrika collection '". $name ."'");
		
		$query = array('date' => $date);
		if ( is_array($sections) )
			$query['sections'] = $sections;
		
		$query = self::_prepareQuery($query);
		
		$cursor = $collection->find($query);
		
		$count = 0;
		foreach ( $cursor as $row )
			$count += $row['count'];
		
		return $count;
	}
	
	
	/**
	 * Получает агрегированные данные счетчика
	 * (SQL SELECT SUM(count))
	 * 
	 * @param string $name  Имя счетчика
	 * @param array $groupby  Список полей для агрегации (SQL GROUP BY)
	 * @param array $query  Параметры фильтра (SQL WHERE)
	 * @param array $sort  Параметры сортировки (SQL SORT)
	 * @param int $limit  Количество записей в выборке
	 * @return array
	 * @exception RuntimeMyException
	 */
	public function Group($name, $by, $query = null, $sort = null, $limit = null)
	{
		$map = "
			function() {
				emit(". self::_prepareGroupBy($by) .", this.count); 
			}
		"; 
		
		$reduce = "
			function(key, values) {
				var count = 0;
				for ( var i in values ) count += values[i];
				return count; 
			}
		";
		
		$command = array(
			'mapreduce'	=> $name,
			'map'		=> $map,
			'reduce'	=> $reduce,
		);
		
		//echo "MAP:\n". $map ."\n";
		//echo "REDUCE:\n". $reduce ."\n";
		
		if ( is_array($query) )
		{
			$command['query'] = self::_prepareQuery($query);
			//echo "QUERY:\n\t". json_encode($command['query']) ."\n";
		}
		if ( is_array($sort) )
		{
			$command['sort'] = self::_prepareQuery($sort);
			//echo "SORT:\n\t".  json_encode($command['sort']) ."\n";
		}
		if ( intval($limit) > 0 )
		{
			$command['limit'] = intval($limit);
			//echo "LIMIT:\n\t". $command['limit'] ."\n";
		}
		
		if ( $_GET['log_db'] === 'true' )
			trace::log(json_encode($command));
		
		$log = $this->db->command($command);
		if ( $log['ok'] == 0 )
			throw new RuntimeMyException("Metrika::Group() failed: ". $log['errmsg']);
		
		$data = array();
		$result = $this->db->selectCollection($log['result'])->find();
		if ( $result === null )
			return $data;
		
		//echo "RESULT:\n";
		foreach ( $result as $row )
		{
			if ( $row['_id']['sections'] === null )
				unset($row['_id']['sections']);
			
			$data[] = $row;
			//echo "\t". json_encode($row) ."\n";
		}
		
		return $data;
	}
	
	
	/**
	 * Получает агрегированное количество счетчиков
	 * (SQL SELECT COUNT(*))
	 * 
	 * @param string $name  Имя счетчика
	 * @param array $groupby  Список полей для агрегации (SQL GROUP BY)
	 * @param array $query  Параметры фильтра (SQL WHERE)
	 * @param array $sort  Параметры сортировки (SQL SORT)
	 * @param int $limit  Количество записей в выборке
	 * @return array
	 * @exception RuntimeMyException
	 */
	public function Count($name, $by, $query = null, $sort = null, $limit = null)
	{
		$map = "
			function() {
				emit(". self::_prepareGroupBy($by) .", 1); 
			}
		"; 
		
		$reduce = "
			function(key, values) {
				var count = 0;
				for ( var i in values ) count += values[i];
				return count; 
			}
		";
		
		$command = array(
			'mapreduce'	=> $name,
			'map'		=> $map,
			'reduce'	=> $reduce,
		);
		
		
		//echo "MAP:\n". $map ."\n";
		//echo "REDUCE:\n". $reduce ."\n";
		
		if ( is_array($query) )
		{
			$command['query'] = self::_prepareQuery($query);
			//echo "QUERY:\n\t". json_encode($command['query']) ."\n";
		}
		if ( is_array($sort) )
		{
			$command['sort'] = self::_prepareQuery($sort);
			//echo "SORT:\n\t".  json_encode($command['sort']) ."\n";
		}
		if ( intval($limit) > 0 )
		{
			$command['limit'] = intval($limit);
			//echo "LIMIT:\n\t". $command['limit'] ."\n";
		}
		
		if ( $_GET['log_db'] === 'true' )
			trace::log(json_encode($command));
		
		$log = $this->db->command($command);
		if ( $log['ok'] == 0 )
			throw new RuntimeMyException("Metrika::Count() failed: ". $log['errmsg']);
		
		$data = array();
		$result = $this->db->selectCollection($log['result'])->find();
		if ( $result === null )
			return $data;
		
		//echo "RESULT:\n";
		foreach ( $result as $row )
		{
			if ( $row['_id']['sections'] === null )
				unset($row['_id']['sections']);
			
			$data[] = $row;
			//echo "\t". json_encode($row) ."\n";
		}
		
		return $data;
	}
	
	
	/**
	 * Формирует дату для фильтра или инкремента
	 * 
	 * @param int $time  Время
	 * @param int $interval  Интервал формирования даты
	 * @return array
	 */
	public function formDate($time, $interval)
	{
		$date = false;
		
		$s = idate('s', $time);
		$i = idate('i', $time);
		$H = idate('H', $time);
		$d = idate('d', $time);
		$m = idate('m', $time);
		$Y = idate('Y', $time);
		
		if ( self::I_SECONDS >= $interval && $s !== false )
			$date['sec'] = $s;
		if ( self::I_MINUTES >= $interval && $i !== false )
			$date['min'] = $i;
		if ( self::I_HOURS >= $interval && $H !== false )
			$date['hour'] = $H;
		if ( self::I_DAYS >= $interval && $d !== false )
			$date['day'] = $d;
		if ( self::I_MONTHS >= $interval && $m !== false )
			$date['month'] = $m;
		if ( self::I_YEARS >= $interval && $Y !== false )
			$date['year'] = $Y;
		
		return $date;
	}
	
	
	/**
	 * Возвращает полный список счетчиков
	 * 
	 * @return array
	 */
	public function listCounters()
	{
		$result = array();
		
		$counters = $this->db->listCollections();
		
		foreach ( $counters as $counter )
			$result[] = $counter->getName();
		
		return $result;
	}
	
	
	/**
	 * Удаляет счетчики с заданными параметрами
	 * Возвращает true в случае успеха
	 * 
	 * @param string $name
	 * @param array $query
	 * @return bool
	 */
	public function removeCounters($name, $query = array())
	{
		$collection = $this->db->selectCollection($name);
		if ( $collection === null )
			return false;
		
		if ( $collection->remove($query) )
			return true;
		
		return false;
	}
	
	
	/**
	 * Подготавливает запрос для фильтра, разворачивая условия для поддокументов
	 * {date:{month:1}}  ->  {date.month:1}
	 * {date:{$exist:true}}  ->  {date:{$exist:true}}
	 * 
	 * @param array $query  Запрос
	 * @param string $key  Префикс ключа
	 * @return array
	 */
	private static function _prepareQuery($query, $key = '')
	{
		$result = array();
		foreach ( $query as $k => $v )
		{
			$_key = ($key ? $key.'.' : '') . $k;
			if ( is_array($v) )
			{
				$first = key($v);
				if ( substr($first, 0, 1) == '$' )
					$result[$_key] = $v;
				else
					$result = array_merge($result, self::_prepareQuery($v, $_key));
			}
			else
				$result[$_key] = $v;
		}
		
		return $result;
	}
	
	
	/**
	 * Подготавливает ключ для агрегации
	 * {date:{month:1}}  ->  {date:{month:this.date.month}}
	 * 
	 * @param array $by  Параметры агрегации
	 * @param string $key  Префикс ключа
	 * @return string
	 */
	private static function _prepareGroupBy($by, $key = '')
	{
		$result = array();
		foreach ( $by as $k => $v )
		{
			$_key = ($key ? $key.'.' : '');
			if ( is_array($v) )
				$result[$k] = self::_prepareGroupBy($v, $_key . $k);
			else
				$result[$v] = 'this.'. $_key . $v;
		}
		
		return str_replace('"','', json_encode($result));
	}
}
