<?
/**
	Организует работу разделов объявлений, имеющих большое количество подразделов. 
	@author: Хусаинов Фарид
	@date: 11:37 2 июля 2009 г.
*/

LibFactory::GetMStatic('patterns', 'querydataiterator');

/**
	Фабрика объектов схем данных
*/
class AdvMgr
{
	private static $shemes	= array();
	
	/**
		Получение схемы данных
		@param string $path - путь к схеме данных
		@param mixed $prefix - префикс таблиц; используется в случае, если в одной базе лежат таблицы нескольких разделов
		@return object
	*/
	public static function GetSheme($path, $prefix = '')
	{
		global $CONFIG;
		
		if ( !isset(self::$shemes[$path][$prefix]) )
		{
			if ( is_file($CONFIG['engine_path'].'include/advertise/shemes/'. $path .'.php'))
			{
				include_once $CONFIG['engine_path'].'include/advertise/shemes/'. $path .'.php';
				$cn = 'AdvSheme_'. str_replace('/', '_', strtolower($path));
				if ( class_exists($cn) )
					self::$shemes[$path][$prefix] = new $cn($path, $prefix);
				else
					throw new RuntimeMyException("Adv sheme class not found");
			} else
				throw new RuntimeMyException("Adv sheme not found");
		}
		
		self::$shemes[$path][$prefix]->SetConfig();
		
		return self::$shemes[$path][$prefix];
	}
	
	/**
		Удаление объектов схем
	*/
	public static function Flush()
	{
		self::$shemes = array();
	}
}

/**
	Базовый класс схемы данных
*/
class AdvShemeBase
{
	public $path 			= '';
	public $sheme 			= array();
	public $db 				= null;	
	public $from_master		= false;
	
	public $_config			= null;
	
	
	/**
		Конструктор
		@param string $path - путь к схеме данных
		@param mixed $prefix - префикс таблиц; используется в случае, если в одной базе лежат таблицы нескольких разделов
	*/
	public function __construct($path, $prefix = '')
	{
		$this->db = DBFactory::getInstance($this->sheme['db']);
		$this->path = $path;
		$this->sheme['tables']['prefix'] = $prefix;
		
		if ( !array_key_exists($this->sheme['scalar_fields']['key'], $this->sheme['scalar_fields']) )
			$this->sheme['scalar_fields'][$this->sheme['key']] = array( 'type' => 'int' );
		
		$this->sheme['stat_field'] = 'Views';
	}
	
	/**
		Уничтожение объекта
	*/
	public function Destroy()
	{
		foreach ( $this as $index => $v )
			unset($this->$index);
	}
	
	/**
		Установка конфига модуля для схемы
		Используется для задания конфига во внешних скриптах
		@param mixed $config - конфиг модуля
		@return object
	*/
	public function SetConfig($config = null)
	{
		if ( $config !== null )
			$this->_config = $config;
		else if ( !empty(App::$ModuleConfig) )
			$this->_config = App::$ModuleConfig;
	}
	
	/**
		Получение итератора записей по заданной схеме и параметрам выборки
		@param array $filter - фильтр
		@param bool $load_vectors - буферизовать векторы сразу (если они стопудово нужны для всех записей - быстрее взять их одним запросом; не надо грузить лишнего!!)
	*/
	public function GetIterator($filter = array(), $load_vectors = false)
	{
		global $CONFIG;
		
		include_once $CONFIG['engine_path'].'include/advertise/shemes/'. $this->path .'.php';

		$cn = 'AdvIterator_'. str_replace('/', '_', strtolower($this->path));
		
		if ( !class_exists($cn) )
			throw new RuntimeBTException("Adv iterator class not found");
		
		return new $cn($this, $filter, $load_vectors);
	}
	
	/**
		Получение объекта объявления по идентификатору
		Если id-шник не передан - создается новый объект
		@param int $id - id-шник объявления
		@return object
	*/
	public function GetAdv($id = null)
	{
		global $CONFIG;

		include_once $CONFIG['engine_path'].'include/advertise/shemes/'. $this->path .'.php';
		$cn = 'Adv_'. str_replace('/', '_', strtolower($this->path));

		if ( !class_exists($cn) )
			throw new RuntimeBTException("Adv class not found");
		
		try
		{
			$adv = new $cn($this, $id);
		}
		catch ( Exception $e )
		{
			return null;
		}

		return $adv;
	}
	
	/**
		Создает объект объявления из массива данных
		@param array $data - массив данных объявления
	*/
	public function CreateAdvFromArray($data)
	{
		$obj = $this->GetAdv();
		$obj->SetData($data);		
		return $obj;
	}
	
	/**
		Удаление объявления по идентификатору
		@param int $id - id-шник объявления
		@param int $userid - id-шник пользователя
		@return bool
	*/
	public function RemoveAdv($id, $userid = null)
    {
        $obj = $this->GetAdv($id);
		
        if ( $obj === null )
            return false;
		
        if( $obj->Remove() === false )
            return false;
            
 		$sql = "DELETE FROM `". $this->sheme['tables']['prefix'].$this->sheme['tables']['master'];
		$sql.= "` WHERE ". $this->sheme['key'] ." = ". $id;
		if ( $userid !== null )
			$sql.= " AND `UserID` = ". $userid;
		$this->db->query($sql);		
       
		AdvCache::getInstance()->Remove($this, $id);
        
        unset($obj);
		
        return true;
    }
}

/**
	Базовый класс итератора записей
*/
class AdvIteratorBase extends Patterns_QueryDataIterator
{
	protected $filter		= null; // фильтр
	protected $filter_index = array(); // эталонный фильтр. задает доступные поля в where и их порядок
	protected $id 			= null; // текущее значение ключевого поля
	protected $sheme 		= null; // объект схемы
	
	// общее количество выбранных записей для постраничке
	public $total = 0;
	
	/**
		Конструктор
		@param array $sheme - объект схемы данных
		@param array $filter - фильтр
		@param mixed $load_vectors - буферизовать векторы сразу (если они стопудово нужны для всех записей - быстрее взять их одним запросом, true - все, array - заданные)
	*/
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{		
		$this->sheme = $sheme;
		$this->filter = $filter;
		
		parent::__construct();
		
		// буферизация векторных полей
		if ( count($this->data) > 0 && ($load_vectors === true || is_array($load_vectors)) )
		{
			foreach ( $this->sheme->sheme['vector_fields'] as $name => $field )
			{
				if ( is_array($load_vectors) && !in_array($name,$load_vectors) )
					continue;
				
				//2do: Тут тоже надо закэшировать
				
				if ( $field['type'] == 'array' )
					$fields = implode('`, `', $field['fields']);
				else
					$fields = $name;
				
				$sql = "SELECT `". $this->sheme->sheme['key'] ."`, `". $fields ."`";
				$sql.= " FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$name] ."`";
				$sql.= " WHERE `". $this->sheme->sheme['key'] ."` IN (". implode(',', array_keys($this->data)) .")";
				
				if ( !empty($field['order']) )
					$sql.= " ORDER BY `". $field['order'] ."` ASC";
				
				//error_log($sql);
				
				if ( $this->sheme->from_master === true )
					$res = $this->sheme->db->query($sql);
				else
					$res = $this->sheme->db->query($sql);
				
				if ( $res === false )
					continue;
				
				unset($this->data[$row[$this->sheme->sheme['key']]][$name]);
				while ( $row = $res->fetch_assoc() )
				{
					if ( $field['type'] == 'array' )
						$this->data[$row[$this->sheme->sheme['key']]][$name][] = $row;
					else
						$this->data[$row[$this->sheme->sheme['key']]][$name][] = $row[$name];
				}
			}
		}
	}
	
	/**
		Уничтожение объекта
	*/
	public function Destroy()
	{
		foreach ( $this as $index => $v )
			unset($this->$index);
	}
	
	/**
		Сборка запроса
		Можно переопределять в дочерних классах в случае заковыристых запросов
		@return string
	*/
	protected function PrepareSQL()
	{
		$sql = "SELECT ";
		if ( $this->filter['distinct'] )
			$sql.= "DISTINCT ";
		if ( $this->filter['limit'] > 0 )
			$sql.= "SQL_CALC_FOUND_ROWS ";
		
		// поля
		$fields = array();
		if ( is_array($this->sheme->sheme['scalar_fields']) )
			foreach ( $this->sheme->sheme['scalar_fields'] as $name => $type )
			{
				if ( is_array($this->filter['fields']) && !in_array($name, $this->filter['fields']))
					continue;
				$fields[] = "m.`". $name ."`";
			}
		$sql.= implode(', ', $fields);
		
		$sql.= " FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['master'] ."` m";
		
		// связи
		$joins = array();
		if ( is_array($this->sheme->sheme['vector_fields']) )
		{
			foreach ( $this->sheme->sheme['vector_fields'] as $name => $type )
			{
				if ( array_key_exists($name, $this->filter) || 
					($type['type'] == 'array' && count(array_intersect($type['fields'],array_keys($this->filter)))) )
					$joins[$this->sheme->sheme['tables']['slaves'][$name]] = ' LEFT JOIN '.
						$this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$name] ." `s_". strtolower($name) .
						"` ON m.`". $this->sheme->sheme['key'] ."` = s_".  strtolower($name) .".`". $this->sheme->sheme['key'] ."`";
			}
		}
		
		if ( count($joins) )
			$sql.= implode(' ', $joins);
		
		// условия
		$where = array();
		foreach ( $this->filter_index as $name )
		{			
			if ( !array_key_exists($name, $this->filter) )
				continue;
			
			$value = $this->filter[$name];
			if ( is_array($value) )
			{
				if ( array_key_exists($name,$this->sheme->sheme['scalar_fields']) )
				{
					// условие на скалярное поле
					$type = $this->sheme->sheme['scalar_fields'][$name]['type'];
					$name = 'm.`'. $name .'`';
				}
				else if ( array_key_exists($name,$this->sheme->sheme['vector_fields']) )
				{
					// условие на векторное поле
					$type = $this->sheme->sheme['vector_fields'][$name]['type'];
					$name = 's_'. strtolower($name) .'.`'. $name .'`';
				}
				else
				{
					// условие на поле из составного векторного поля
					$v = false;
					foreach ( $this->sheme->sheme['vector_fields'] as $fname => $field )
					{
						if ( $field['type'] != 'array' || !in_array($name, $field['fields']) )
							continue;
						$v = $field;
						break;
					}
					if ( $v !== false )
					{
						$type = $v['type'];
						$name = 's_'. strtolower($fname) .'.`'. $name .'`';
					}
					else
						continue;
				}
				
				if ( is_array($value[1]) && strtolower($value[0]) != 'in' && strtolower($value[0]) != 'not in' && strtolower($value[0]) != 'between' )
				{
					$or_where = array();
					foreach ( $value[1] as $v )
					{
						if ( $type == 'char' || $type == 'date' )
							if ( strtolower($value[0]) == 'in' )
								$or_where[] = $name ." IN ('". implode("', '", array_map('add_slashes',$v)) ."')";
							else
								$or_where[] = $name ." ". $value[0] ." '". addslashes($v) ."'";
						else if ( $type == 'int' )
							if ( strtolower($value[0]) == 'in' )
								$or_where[] = $name ." IN (". implode(", ", $v) .")";
							else
							{
								if ( is_numeric($v) );
									$or_where[] = $name ." ". $value[0] ." ". $v;
							}
					}
					$where[] = '('. implode(' OR ', $or_where) .')';
				}
				else
				{
					if ( $type == 'char' )
						if ( strtolower($value[0]) == 'in' )
						{
							$where[] = $name ." IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							$where[] = $name ." NOT IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
					else if ( $type == 'date' )
						if ( strtolower($value[0]) == 'between' )
						{
							if ( $value[1][0] !== false )
								$where[] = $name ." >= ". (substr($value[1][0],0,1)=="'"?"":"'") . $value[1][0] . (substr($value[1][0],0,1)=="'"?"":"'");
							if ( $value[1][1] !== false )
								$where[] = $name ." <= ". (substr($value[1][1],0,1)=="'"?"":"'") . $value[1][1] . (substr($value[1][1],0,1)=="'"?"":"'");
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
					else if ( $type == 'int' || $type == 'float' )
						if ( strtolower($value[0]) == 'in' )
						{
							if ( !empty($value[1]) && is_array($value[1]) )
								$where[] = $name ." IN (". implode(", ", $value[1]) .")";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							if ( !empty($value[1]) && is_array($value[1]) )
								$where[] = $name ." NOT IN(". implode(", ", $value[1]) .")";
						}
						else if ( strtolower($value[0]) == 'between' )
						{
							if ( $value[1][0] !== false )
								$where[] = $name ." >= ". str_replace(',','.',$value[1][0]);
							if ( $value[1][1] !== false )
								$where[] = $name ." <= ". str_replace(',','.',$value[1][1]);
						}
						else
						{
							if ( is_numeric($value[1]) )
								$where[] = $name ." ". $value[0] ." ". $value[1];
						}
					else
						if ( strtolower($value[0]) == 'in' )
						{
							$where[] = $name ." IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							$where[] = $name ." NOT IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
				}
			}
			else if ( is_string($value) )
				$where[] = '('. $value .')';
		}
		if ( count($where) )
			$sql.= ' WHERE '. implode(' AND ', $where);
		
		// порядок
		if ( isset($this->filter['order']) )
		{
			$order = array();
			if ( is_array($this->filter['order']) )
			{
				foreach( $this->filter['order'] as $k => $field )
				{
					if ( strtolower($field) == 'rand' )
					{
						$order[] = 'RAND()';
					}
					else
					{
						if ( array_key_exists($field,$this->sheme->sheme['scalar_fields']) )
							$name = 'm.`'. $field .'`';
						if ( array_key_exists($field,$this->sheme->sheme['vector_fields']) )
							$name = 's_'. strtolower($field) .'.`'. $field .'`';
						
						$order[] =  $name ." ". strtoupper($this->filter['dir'][$k]);
					}
				}
			}
			else
			{
				if ( strtolower($this->filter['order']) == 'rand' )
				{
					$order[] = 'RAND()';
				}
				else
				{
					if ( array_key_exists($this->filter['order'],$this->sheme->sheme['scalar_fields']) )
						$name = 'm.`'. $this->filter['order'] .'`';
					if ( array_key_exists($this->filter['order'],$this->sheme->sheme['vector_fields']) )
						$name = 's_'. strtolower($this->filter['order']) .'.`'. $this->filter['order'] .'`';
					$order[] = $name ." ". strtoupper($this->filter['dir']);
				}
			}
			$sql.= " ORDER BY ". implode(', ',$order);
		}
		
		// лимит
		if ( $this->filter['offset'] > 0 || $this->filter['limit'] > 0 )
		{
			$sql.= " LIMIT ";
			if ( $this->filter['offset'] > 0 )
				$sql.= $this->filter['offset'].", ";
			if ( $this->filter['limit'] > 0 )
				$sql.= $this->filter['limit'];
		}
		
		if ( $this->filter['debug'] === true )
		{
			echo $sql. "\n";
			TRACE::Log($sql);
		}
		
		unset($fields, $where, $order, $joins);
		
		return $sql;
	}
	
	/**
		Выборка из БД
	*/
	public function getdata()
	{
		// получаем скалярные поля
		$this->data = array();
		
		
		// кэширование выборки
		/*$redis = LibFactory::GetInstance('redis');
		$redis->Init('test');
		if ( $this->sheme->from_master !== true )
		{
			$filter = $this->filter;
			ksort($filter);
			$key = 'testcache:'. $this->sheme->sheme['tables']['prefix'] .':'. $this->sheme->path .':'. md5(serialize($filter));
			
			if ( $redis->Exists($key) )
			{
				$data = $redis->Get($key);
				$data = unserialize($data);
				if ( $data )
				{
					//list($this->data, $this->total) = $data;
					
					$redis->Incr("cache_hits");
					
					//return;
				}
			}
			$redis->Incr("cache_misses");
		}
		else
			$redis->Incr("cache_master");*/
		// КОНЕЦ: кэширование выборки
		
		
		$sql = $this->PrepareSQL();
		//error_log($sql);
		
		if ( $this->sheme->from_master === true )
			$res = $this->sheme->db->query($sql);
		else
			$res = $this->sheme->db->query($sql);

		if ( $res === false )
			return;

		// кидаем в массив
		while ( $row = $res->fetch_assoc() )
			$this->data[$row[$this->sheme->sheme['key']]] = $row;
		
		if ( $this->filter['limit'] > 0 )
		{
			if ( $this->sheme->from_master === true )
				$res_c = $this->sheme->db->query("SELECT FOUND_ROWS()");
			else
				$res_c = $this->sheme->db->query("SELECT FOUND_ROWS()");
			
			if ( $res_c === false )
				return;
			
			list($this->total) = $res_c->fetch_row();
		}
		else
		{
			$this->total = count($this->data);
		}
		
		
		
		// кэширование выборки
		/*if ( $this->sheme->from_master !== true )
			$redis->Set($key, serialize(array($this->data, $this->total)), 0);*/
		// КОНЕЦ: кэширование выборки
	}
	
	/**
		Создание объекта из массива данных
		@param array $data - массив данных объекта
		@return object
	*/
	public function getobject($data)
	{
		return $this->sheme->CreateAdvFromArray($data);
	}
}



/**
	Базовый класс объявления
*/
class AdvBase implements ArrayAccess
{
	protected $iterator	= null;		// итератор
	protected $sheme 	= null; 	// схема данных	
	protected $id 		= null; 	// значение ключевого поля для этой записи	
	protected $data 	= array(); 	// массив со значениями полей
	
	/**
		Конструктор
		Возможна инициализация из id-шника
		@param object $sheme - схема данных
		@param int $id - id-шник объявления
		@param object $iterator - итератор объектов объявлений
	*/
	public function __construct($sheme, $id = null, $iterator = null)
	{
		$this->sheme = $sheme;
		$this->id = $id;
		$this->iterator = $iterator;
		
		if ( !empty($this->id) && !$this->Load() )
			throw new RuntimeMyException("Record not found");
	}
	
	/**
		Уничтожение объекта
	*/
	public function Destroy()
	{
		foreach ( $this as $index => $v )
			unset($this->$index);
	}
	
	/**
		Получение массива значений векторного поля
		@param string $offset - имя поля
	*/
	public function VectorLoad($offset)
	{
		if ( isset($this->data[$offset]) )
			return true;		
		if ( $this->id == null )
			return false;
		
		$this->data[$offset] = AdvCache::getInstance()->Load($this->sheme, $this->id, $offset);

		//error_log(print_r($this->data[$offset], true));
		if ($this->data[$offset] !== false)
			return true;

		if ( $this->sheme->sheme['vector_fields'][$offset]['type'] == 'array' )
			$sql = "SELECT `". implode('`, `', $this->sheme->sheme['vector_fields'][$offset]['fields']) ."` FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$offset] ."`";
		else
			$sql = "SELECT `". $offset ."` FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$offset] ."`";
		$sql.= " WHERE `". $this->sheme->sheme['key'] ."` = ". $this->id;
		if ( isset($this->sheme->sheme['vector_fields'][$offset]['order']) )
			$sql.= " ORDER BY `". $this->sheme->sheme['vector_fields'][$offset]['order'] ."`";

		if ( $this->sheme->from_master === true || AdvCache::getInstance()->IsEnabled() )
			$res = $this->sheme->db->query($sql);
		else
			$res = $this->sheme->db->query($sql);

		if ( $res === false )
			return false;

		if ( $res->num_rows == 0 )
		{
			$this->data[$offset] = array();
			AdvCache::getInstance()->Store($this->sheme, $this->id, $this->data[$offset], $offset);
			return true;
		}
		
		$this->data[$offset] = array();
		if ( $this->sheme->sheme['vector_fields'][$offset]['type'] == 'array' )
		{
			while ( $row = $res->fetch_assoc() )
				$this->data[$offset][] = $row;
		} else {
			while ( $row = $res->fetch_assoc() )
				$this->data[$offset][] = $row[$offset];
		}
		
		// стор именно тут из-за задержек репликации
		AdvCache::getInstance()->Store($this->sheme, $this->id, $this->data[$offset], $offset);
		
		return true;
	}
	
	/**
		Сохранение массива значений векторного поля
		@param string $offset - имя поля
		@return bool
	*/
	public function VectorStore($offset, $data)
	{
		if ( !isset($this->data[$offset]) || $this->id === null )
			return false;
		if ( array_key_exists($offset,$this->sheme->sheme['scalar_fields']) )
			return false;
		if ( $this->VectorLoad($offset) === false )
			return false;				
		if ( array_key_exists($offset,$this->sheme->sheme['vector_fields']) === false )
			return false;
		
		$table = $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$offset];
		$type = $this->sheme->sheme['vector_fields'][$offset];
		
		$sql = "DELETE FROM `". $table ."` WHERE `". $this->sheme->sheme['key'] ."` = ". $this->id;
		$this->sheme->db->query($sql);
		
		foreach ( $data as $row )
		{
			$vals = array();
			$sql = "INSERT INTO `". $table ."` SET ";
			if ( $type['type'] == 'char' || $type['type'] == 'date' )
				$vals[$offset] = "`". $offset ."` = '". addslashes($row) ."'";
			else if ( $type['type'] == 'array' ) {
				if ( is_array($row) )
				{
					foreach ( $row as $field => $v )
					{
						if ( !in_array($field, $type['fields']) )
							continue;					
						$vals[$field] = "`". $field ."` = '". $v ."'";
					}
				}
			}
			else
			{
				if ( empty($row) )
					continue;
				$vals[$offset] = "`". $offset ."` = ". $row;
			}
			
			$vals[$this->sheme->sheme['key']] = "`". $this->sheme->sheme['key'] ."` = ". $this->id;
			$sql.= implode(', ', $vals);
			
			$this->sheme->db->query($sql);
		}

	}
	
	// ArrayAccess
	public function offsetExists($offset)
	{
		return (
				in_array($offset, $this->sheme->sheme['scalar_fields']) || 
				in_array($offset, $this->sheme->sheme['vector_fields']) 
			);
	}
	
	public function offsetGet($offset) // значение поля
	{
		if ( array_key_exists($offset, $this->sheme->sheme['vector_fields']) )
		{
			if ( $this->VectorLoad($offset) === false )
				return null;
		} else if ( !array_key_exists($offset, $this->sheme->sheme['scalar_fields']) )
			return null;
		
		return $this->data[$offset];
	}
	
	public function offsetSet($offset, $value) // установка значения поля
	{
		/*if ( array_key_exists($offset, $this->sheme->sheme['scalar_fields']) )
			$this->data[$offset] = $value;
		else if ( array_key_exists($offset, $this->sheme->sheme['vector_fields']) )
			$this->VectorStore($offset, $value);	*/
		if ( array_key_exists($offset, $this->sheme->sheme['scalar_fields']) || array_key_exists($offset, $this->sheme->sheme['vector_fields']) )
			$this->data[$offset] = $value;
	}
	
	public function offsetUnset($offset) // очистка поля
	{
		unset ($this->data[$offset]);
	}
	
	/**
		Валидация данных
		Переопределяется в дочерних классах для валидации объявлений
		@return bool
	*/
	public function IsValid()
	{
		return true;
	}
	
	/**
		Загрузка записи, используя $this->id
		@return bool
	*/
	public function Load()
	{
		if ( $this->id === null )
			return false;

		$this->data = AdvCache::getInstance()->Load($this->sheme, $this->id);

		if ($this->data !== false)
			return true;
		
		$sql = "SELECT ";
		
		// поля
		$fields = array();
		foreach ( $this->sheme->sheme['scalar_fields'] as $name => $type )
			$fields[] = "`". $name ."`";
		$sql.= implode(', ', $fields);
		
		$sql.= " FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['master'] ."` m";
		$sql.= " WHERE `". $this->sheme->sheme['key'] ."` = ". $this->id;
		
		if ( $this->sheme->from_master === true || AdvCache::getInstance()->IsEnabled() )
			$res = $this->sheme->db->query($sql);
		else
			$res = $this->sheme->db->query($sql);
		
		if ( $res === false || $res->num_rows == 0 )
			return false;

		if ( false === ($this->data = $res->fetch_assoc()) )
			return false;
		
		// тут именно стор, чтобы база дозаполнила поля значениями по умолчанию
		AdvCache::getInstance()->Store($this->sheme, $this->id, $this->data);
		
		return true;
	}
	
	/**
		Cохранение записи в базу
		@return bool
	*/
	public function Store()
	{
		// пишем скалярные поля
		// обновляем id, если его нет
		// вызываем $this->VectorStore() для векторных полей
		
		if ( $this->id !== null )
		{
			$sql = "UPDATE `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['master'] ."` SET ";
		} else
			$sql.= "INSERT INTO `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['master'] ."` SET ";
		
		// поля
		$fields = array();
		foreach ( $this->sheme->sheme['scalar_fields'] as $name => $type )
		{
			if ( !array_key_exists($name, $this->data) || $name == $this->sheme->sheme['key'] )
				continue;
			if ( $type['type'] == 'int' || $type['type'] == 'float' )
				$fields[] = "`". $name ."` = ". str_replace(',', '.', floatval(str_replace(',', '.', $this->data[$name])));
			else if ( $type['type'] == 'char' )
				$fields[] = "`". $name ."` = '". addslashes($this->data[$name]) ."'";
			else if ( $type['type'] == 'date' )
			{
				if ( $this->data[$name] === null )
					$fields[] = "`". $name ."` = NULL";
				else
					$fields[] = "`". $name ."` = '". (is_numeric($this->data[$name]) ? date('Y-m-d H:i',$this->data[$name]) : addslashes($this->data[$name])) ."'";
			}
		}
		$sql.= implode(', ', $fields);
		
		if ( $this->id !== null )
			$sql.= " WHERE `". $this->sheme->sheme['key'] ."` = ". $this->id;
		
		// обновляем запись
//		print_r($this->data);
//		exit;
		//trace::log($sql);
		// error_log($sql);
//		print $sql;
//		exit;

		
//		error_log($sql);

		if ( !$this->sheme->db->query($sql) )
			return false;
		
		// обновляем id-шник для новой записи
		if ( $this->id === null )
		{
			$this->id = $this->sheme->db->insert_id;
			$this->data[$this->sheme->sheme['key']] = $this->id;
		}
		
		AdvCache::getInstance()->Remove($this->sheme, $this->id);

		// обновляем векторные поля
		foreach ( $this->sheme->sheme['vector_fields'] as $name => $type )
			$this->VectorStore($name, $this->data[$name]);
		
		return true;
	}
		
	/**
		Получение массива данных
		@param mixed $load_vectors - true - загрузить все поля, array - загрузить выбранные
		@return array
	*/
	public function GetData($load_vectors = false)
	{
		if ( $load_vectors === true || is_array($load_vectors) )
			foreach ( $this->sheme->sheme['vector_fields'] as $field => $type )
			{
				if ( is_array($load_vectors) && !in_array($field,$load_vectors) )
					continue;
				$this->VectorLoad($field);
			}
		return $this->data;
	}
	
	/**
		Заполнение объекта массивом данных
		@param array $data - массив с данными объекта
	*/
	public function SetData($data)
	{
		$this->data = array();
		if ( is_array($data) )
			foreach ( $data as $k => $v )
				if ( array_key_exists($k, $this->sheme->sheme['scalar_fields']) || array_key_exists($k, $this->sheme->sheme['vector_fields']) )
					$this->data[$k] = $data[$k];
		
		if ( !empty($this->data[$this->sheme->sheme['key']]) )
			$this->id = $this->data[$this->sheme->sheme['key']];
	}
	
	/**
		Удаление дочерних данных объявления
		@return bool
	*/
	public function Remove()
	{
		foreach ( $this->sheme->sheme['vector_fields'] as $name => $type )
		{
			$sql = "DELETE FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$name] ."`";
			$sql.= " WHERE `". $this->sheme->sheme['key'] ."` = ". $this->id;
			if ( false === $this->sheme->db->query($sql) )
				return false;
		}
		return true;
	}
	
	/**
		Увеличивает число просмотров данного объявления
		@param int $value - на сколько
	*/
	public function StatIncrement($value = 1)
	{
		AdvStat::getInstance()->Increment($this->sheme, $this->id, $value);
	}
	
	/**
		Получает число просмотров данного объявления
		@return int
	*/
	public function StatGet($with_custom = false)
	{
		return AdvStat::getInstance()->Get($this->sheme, $this->id, $with_custom);
	}

	/**
		Сбрасывает дату начала подсчета просмотров на текущую
		@return bool
	*/
	public function StatReset()
	{
		return AdvStat::getInstance()->Reset($this->sheme, $this->id);
	}
}


/**
	Класс кэша объявлений
*/
class AdvCache
{
	private $_lifetime		= 0;
	private $_cache			= null;
	private $_is_cache		= true;
	private static $_me		= null;
	
	public function __construct()
	{
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'advcache');
	}

	
	public static function getInstance()
	{
		if ( self::$_me === null )
		{
			$cl = __CLASS__;
			self::$_me = new $cl();
		}
		return self::$_me;
	}
	
	/**
		Проверка, задействован ли кэш
		@return bool
	*/
	public function IsEnabled()
	{
		return $this->_is_cache;
	}

	/**
		Включает/выключает кэширование
		@param bool $enable - вкл/выкл
	*/
	public function CacheEnable($enable = false)
	{
		$this->_is_cache = ( $enable ? true : false );
	}

	
	/**
		Задает время жизни кэша
		(по умолчанию - бесконечно)
		@param int $lifetime - время жизни
	*/
	public function SetLifetime($lifetime)
	{
		$this->_lifetime = $lifetime;
	}
	
	
	/**
		Загрузка объявления из кэша
		@param object $sheme - схема данных
		@param int $id - идентификатор объявления
		@param string $offset - имя векторного поля
	*/
	public function Load($sheme, $id, $offset = false)
	{
		if ( $offset !== false && array_key_exists( $offset, $sheme->sheme['vector_fields'] ) )
			$path = $sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id."_".$offset;
		else
			$path = $sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id;
		
		if ( $this->_is_cache !== true )
			return false;

		return $this->_cache->Get($path);
	}
	
	
	/**
		Сохранение объявления в кэш
		@param object $sheme - схема данных
		@param int $id - идентификатор объявления
		@param array $Data - данные объявления объявления
		@param string $offset - имя векторного поля
	*/
	public function Store($sheme, $id, $Data, $offset = false)
	{
		if ( $offset !== false && array_key_exists( $offset, $sheme->sheme['vector_fields'] ) )
			$path = $sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id."_".$offset;
		else
			$path = $sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id;
		
		if ( $this->_is_cache !== true )
			return false;
		
		$this->_cache->Set($path, $Data, $this->_lifetime);
	}
	
	
	/**
		Удаление объявления из кэша
		@param object $sheme - схема данных
		@param int $ids - идентификаторы объявлений
	*/
	public function Remove($sheme, $ids)
	{
		$offsets = array_keys($sheme->sheme['vector_fields']);
		
		if ( $this->_is_cache !== true )
			return false;

		if ( is_array($ids) && count($ids) > 0 )
		{
			foreach($ids as $id)
			{
				$this->_cache->Remove($sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id);
				foreach ($offsets as $offset)
					$this->_cache->Remove($sheme->path."_".$sheme->sheme['tables']['prefix']."_".$id."_".$offset);
			}
		}
		elseif ( is_numeric($ids) )
		{
			$this->_cache->Remove($sheme->path."_".$sheme->sheme['tables']['prefix']."_".$ids);
			foreach ($offsets as $offset)
				$this->_cache->Remove($sheme->path."_".$sheme->sheme['tables']['prefix']."_".$ids."_".$offset);
		}
	}
}

/**
	Подсчет статистики просмотров объявлений
*/
class AdvStat
{
	const KEY_DATE			= ':date';
	const KEY_CUSTOM		= ':custom';
	
	private $_redis			= null;
	private static $_me		= null;
	
	public function __construct()
	{
		$this->_redis = LibFactory::GetInstance('redis');
		try
		{
			$this->_redis->Init('advertise');
		}
		catch ( MyException $e ) {}
	}
	
	public static function getInstance()
	{
		if ( self::$_me === null )
		{
			$cl = __CLASS__;
			self::$_me = new $cl();
		}
		return self::$_me;
	}
	
	/**
		Увеличение счетчика просмотров
		@param object $sheme - схема данных
		@param mixed $ids - идентификатор объявления или массив идентификаторов
		@param int $value - значение
	*/
	public function Increment($sheme, $ids, $value = 1)
	{
		if ( $this->_redis === null )
			return;
		
		$ids = (array) $ids;
		foreach ( $ids as $id )
		{
			$key = $sheme->sheme['tables']['prefix'] .':'. str_replace('/','',$sheme->path) .':'. $id;
			$this->_redis->Incr($key, $value);
		}
	}
	
	/**
		Получение количества просмотров
		@param object $sheme - схема данных
		@param mixed $id - идентификатор объявления
	*/
	public function Get($sheme, $id, $custom = false)
	{
		if ( $this->_redis === null )
			return 0;

		$key = $sheme->sheme['tables']['prefix'].':'. str_replace('/','',$sheme->path) .':'. $id;
		if ($custom)
		{
			$data = $this->_redis->MGet( array($key, $key . self::KEY_CUSTOM) );
			list($date, $custom) = explode("|", $data[1]);
			$data[1] = array();

			if (is_numeric($date) && $date > 0)
			{
				$data[1]['date'] = $date;
				$data[1]['custom'] = $data[0] - $custom;
			}
			else
				$data[1] = null;

			return $data;
		}
		else
		{
			return $this->_redis->Get($key);
		}
	}

	/**
		Сброс количества просмотров и даты с объявления, указанным пользователем
		@param object $sheme - схема данных
		@param mixed $id - идентификатор объявления
	*/
	public function Reset($sheme, $id)
	{
		if ( $this->_redis === null )
			return false;

		$key = $sheme->sheme['tables']['prefix'].':'. str_replace('/','',$sheme->path) .':'. $id;
		$count = $this->_redis->Get($key);
		if (!is_numeric($count))
			$count = 0;
		$this->_redis->Set( $key . self::KEY_CUSTOM, implode("|", array(time(),$count)) );

		return true;
	}
}

?>
