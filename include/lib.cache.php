<?

/**
 * @desc Работа с кэшем, с использованием стратегий поведения
 */
class Cache {

	private $trait;

	private $tobj;

	private $prefix;

	public $cache = array();

	private $default_timeout = 60;

	function __construct() {

	}

	function __destruct()
	{
		$this->Destroy();
	}
	
	function Destroy()
	{
		if ($this->tobj != null)
			$this->tobj->Destroy();
	}
	/**
	 * @desc Инициализация кэша
	 * @return true в случае успешной инициализации, false в противном случае
	 */
	function Init($trait, $prefix = '', $params = array()) {

		global $CONFIG;
		
		$start_block = microtime(true);
		
		//Мемкеш сильно тупил - сделал файловый кеш
		$trait = "php";
		$this->trait = $trait;
		$this->prefix = $prefix;
		
		if (is_file($CONFIG['engine_path'] . 'include/cache/' . $trait . '.php')) {
			include_once $CONFIG['engine_path'] . 'include/cache/' . $trait . '.php';
			$class_name = 'Cache_' . $trait . '_Trait';
			if (class_exists($class_name)) {
				
				$this->tobj = new $class_name();
				if (is_subclass_of($this->tobj, 'CacheTrait')) {
					$this->tobj->SetParent($this);

					if ($this->tobj->Init($params) === false)
						$this->tobj = null;
					
				} else {
					error_log('Class: ' . $class_name . ' is not instance of CacheTrait');
					$this->tobj = null;
				}
			} else {
				error_log('Class: ' . $class_name . ' not found');
				$this->tobj = null;
			}
		} else {
			error_log('File: ' . $CONFIG['engine_path'] . 'include/cache/' . $trait . '.php not found');
			$this->tobj = null;
		}
		
		$end_block = microtime(true);
		if ($GLOBALS['LOG_CACHE'] === true) {
			$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" . date(
					'Y-m-d H:i:s') . "\tINIT " . $this->trait . ":" . implode("|", $this->_PreparePrefix());
			$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
		}
		
		if ($this->tobj != null) {
			return true;
		} else {
			error_log('Trait can\'t create');
			return false;
		}
	}

	function IsEnabled() {

		return $this->tobj->IsEnabled();
	}

	function SetTimeout($timeout) {

		$this->default_timeout = $timeout;
	}

	/**
	 * @desc проверка наличия информации в кэше
	 * @return true если есть запись в кэше
	 */
	function IsCache($id) {

		if (false !== ( $id = $this->_PrepareId($id) )) {
			$key = $this->_GetenerateKey($id);
			
			if (isset($this->cache[$key]))
				return true;
				
			if ($this->tobj == null)
				return false;
				
			$start_block = microtime(true);
			$res = $this->tobj->IsCache($id, $key);
			
			$end_block = microtime(true);
			if ($GLOBALS['LOG_CACHE'] === true) {
				$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
					 date('Y-m-d H:i:s') . "\tIS_CACHE " . $this->trait . ":" . $key;
				$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
			}
			return $res;
		}
		return false;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет null
	 */
	function Get($id) {

		if (false !== ( $id = $this->_PrepareId($id) )) {
			$key = $this->_GetenerateKey($id);
			
			if (isset($this->cache[$key]))
				return $this->cache[$key];
			if ($this->tobj == null)
				return false;
			
			$start_block = microtime(true);
						
			if (false !== ($data = $this->tobj->Get($id)))
				$this->cache[$key] = $data;
			
			$end_block = microtime(true);
			if ($GLOBALS['LOG_CACHE'] === true) {
				$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
					 date('Y-m-d H:i:s') . "\tGET " . $this->trait . ":" . $key;
				$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
			}
			return $data;
		}
		return false;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Set($id, $value, $timeout = 0, $method = null, $tags = false) {

		$st = false;
		if (false !== ( $id = $this->_PrepareId($id) )) {
			$key = $this->_GetenerateKey($id);

			$start_block = microtime(true);
			
			if (!is_int($timeout) || $timeout < 0)
				$timeout = $this->default_timeout;
			
			$this->cache[$key] = $value;
			
			if ($this->tobj != null)
				$st = $this->tobj->Set($id, $value, $timeout, $method, $tags);
			
			$end_block = microtime(true);
			if ($GLOBALS['LOG_CACHE'] === true) {
				$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
					 date('Y-m-d H:i:s') . "\tSET " . $this->trait . ":" . $key;
				$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
			}
		}
		return $st;
	}

	/**
	 * @desc Удалить информацию из кэша
	 */
	function Remove($id) {

		$res = false;
		if (false !== ( $id = $this->_PrepareId($id) )) {
			$key = $this->_GetenerateKey($id);
			
			$start_block = microtime(true);
			
			unset($this->cache[$key]);
			if ($this->tobj != null)
				$res = $this->tobj->Remove($id);
			
			$end_block = microtime(true);
			if ($GLOBALS['LOG_CACHE'] === true) {
				$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
					 date('Y-m-d H:i:s') . "\tREMOVE " . $this->trait . ":" . $key;
				$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
			}
		}
		return $res;
	}

	function Clear($id = '') {

		$res = false;
		if (false !== ( $id = $this->_PrepareId($id) ))
			$key = $this->_GetenerateKey($id);
		elseif($id == '')
			$key = '-';
		else
			$key = '';
		
		$start_block = microtime(true);
			
		if($key=='-')
			$this->cache = array();
		elseif($key!='')
			unset($this->cache[$key]);
		if ($this->tobj != null)
		{
			if($key=='-')
				$res = $this->tobj->Clear($this->_PreparePrefix());
			elseif($key!='')
				$res = $this->tobj->Clear($id);
		}
			
		$end_block = microtime(true);
		if ($GLOBALS['LOG_CACHE'] === true) {
			$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tREMOVE " . $this->trait . ":" . $key;
			$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
		}
		return $res;
	}
	
	
	function ClearTags($tags = array())
	{
		$res = false;
		$start_block = microtime(true);
		
		if ($this->tobj != null)
			$res = $this->tobj->ClearTags($tags);
		
		$end_block = microtime(true);
		if ($GLOBALS['LOG_CACHE'] === true) {
			$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tCLEAR " . $this->trait . ":" . $dir;
			$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
		}
		return $res;
	}
	
	
	function Clear_Temp($dir = '') {
			
		$res = false;
		$start_block = microtime(true);
			
		if ($this->tobj != null)
			$res = $this->tobj->Clear_Temp($dir);
			
		$end_block = microtime(true);
		if ($GLOBALS['LOG_CACHE'] === true) {
			$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tCLEAR " . $this->trait . ":" . $dir;
			$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
		}
		return $res;
	}
	
	function GC($dir = null) {
			
		$res = false;
		$start_block = microtime(true);
			
		if ($this->tobj != null)
			$res = $this->tobj->GC($dir);
			
		$end_block = microtime(true);
		if ($GLOBALS['LOG_CACHE'] === true) {
			$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tGC " . $this->trait . ":" . $dir;
			$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
		}
		return $res;
	}
	
	/**
	 * @desc Продлить время жизни данных в кэше
	 */
	function Touch($id, $timeout = 0) {

		$res = false;
		if (false !== ( $id = $this->_PrepareId($id) )) {
			$key = $this->_GetenerateKey($id);
			$start_block = microtime(true);
			
			if (!is_int($timeout) || $timeout < 0)
				$timeout = $this->default_timeout;
			if ($this->tobj != null)
				$res = $this->tobj->Touch($id, $timeout);
			
			$end_block = microtime(true);
			if ($GLOBALS['LOG_CACHE'] === true) {
				$GLOBALS['LOG_CACHE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
					 date('Y-m-d H:i:s') . "\tTOUCH " . $this->trait . ":" . $key;
				$GLOBALS['LOG_CACHE_ERR']['all'] += ( $end_block - $start_block );
			}
		}
		return $res;
	}

	/*
	 * заполнение данных в кэш пхп, для случая если производится загрузка большого объема данных
	 * $data - ключ кэша, значение
	 */
	function _FillCache($data) {

		$this->cache = array_merge($this->cache, $data);
	}

	/**
	 * Проверяет ключ кеша на scalar||array и возвращает массив первый элемент которого префикс, в противном случае false 
	 * 
	 * @param mixed $id
	 * @return array
	 */
	function _PrepareId($id) {

		if ($id && (is_scalar($id) || is_array($id))) {
			$id = (array) $id;
			$pref = array_reverse($this->_PreparePrefix());
			foreach($pref as $v)
				array_unshift($id, $v);
			return $id;
		}
		return false;
	}
	
	/**
	* Проверяет префикс кеша, в противном случае false 
	* 
	* @return array
	*/
	function _PreparePrefix() {
		
		if (is_scalar($this->prefix) || is_array($this->prefix)) {
			$id = (array) $this->prefix;
			return $id;
		}
		return array();
	}
	
	/**
	 * Создает ключ кеша
	 *
	 * @param mixed $id
	 * @param unknown_type $sep
	 * @return unknown
	 */
	function _GetenerateKey($id, $sep = '|') {

		if (!is_array($id) && false === ( $id = $this->_PrepareId($id) ))
			return false;
		
		$a = array();
		foreach ($id as $v) {
			if (is_array($v)) {
				$v = '_array_';
			} else {
				$v = trim(preg_replace('@[\\\/\:\*\"\?\<\>\|]@', '', $v));
			}
			if($v == '')
				Data::e_backtrace(__METHOD__."(): error key: '".$v."'");
			else
				$a[] = $v;
		}
		return str_replace($sep . $sep, $sep, implode($sep, $a));
	}
}

abstract class CacheTrait {

	protected $parent;

	function __construct() {

	}

	function __desrtuct() {

	}

	final function SetParent($parent) {

		$this->parent = $parent;
	}

	/**
	 * @desc Инициализация
	 */
	abstract function Init();

	/**
	 * @desc проверка подключенности к базе
	 * @return true если подключен
	 */
	abstract function IsEnabled();

	/**
	 * @desc проверка наличия информации в кэше
	 * @return true если есть запись в кэше
	 */
	abstract function IsCache($id, $key);

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет null
	 */
	abstract function Get($id);

	/**
	 * @desc Добавить информацию в кэш
	 */
	abstract function Set($id, $value, $timeout, $tags = false, $method = null);

	/**
	 * @desc Удалить информацию из кэша
	 */
	abstract function Remove($id);

	/**
	 * @desc Удаление информации из кэша используя ключ
	 */
	abstract function Clear($id);
	
	/**
	 * @desc Удаление информации из кэша используя тэг
	 */
	abstract function ClearTags($tags = array());

	/**
	 * @desc Очистить временную папку кеша
	 */
	abstract function Clear_Temp($dir = '', $deleteMe = false);
	
	/**
	 * @desc Продлить время жизни данных в кэше
	 */
	abstract function Touch($id, $timeout);

	/**
	 * @desc Почистить мусор в кеше
	 */
	abstract function GC();

	/**
	 * @desc уничтожннин объекта, в данном методе необходимо сохранить все несохраненные данные
	 */
	function Destroy() {
		foreach ( $this as $index => $v )
			unset($this->$index);
	}
}
?>