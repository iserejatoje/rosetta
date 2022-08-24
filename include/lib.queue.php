<?

/**
 * @desc Работа с кэшем, с использованием стратегий поведения
 */
class Queue {

	private $trait;
	private $tobj;
	private $prefix;
	private $default_timeout = 60;

	function __construct() {
		
	}

	/**
	 * @desc Инициализация кэша
	 * @return true в случае успешной инициализации, false в противном случае
	 */
	function Init($trait, $prefix = '') {

		global $CONFIG;
		
		$start_block = microtime(true);
		
		$this->trait = $trait;
		$this->prefix = $prefix;
		
		if (is_file($CONFIG['engine_path'] . 'include/queue/' . $trait . '.php')) {
			include_once $CONFIG['engine_path'] . 'include/queue/' . $trait . '.php';
			
			$class_name = 'Queue_' . $trait . '_Trait';
			if (class_exists($class_name)) {
				
				$this->tobj = new $class_name();
				if (is_subclass_of($this->tobj, 'QueueTrait')) {
					$this->tobj->SetParent($this);

					if ($this->tobj->Init() === false)
						$this->tobj = null;
					
				} else {
					error_log('Class: ' . $class_name . ' is not instance of QueueTrait');
					$this->tobj = null;
				}
			} else {
				error_log('Class: ' . $class_name . ' not found');
				$this->tobj = null;
			}
		} else {
			error_log('File: ' . $CONFIG['engine_path'] . 'include/queue/' . $trait . '.php not found');
			$this->tobj = null;
		}
		
		$end_block = microtime(true);
		if ($GLOBALS['LOG_QUEUE'] === true) {
			$GLOBALS['LOG_QUEUE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" . date(
					'Y-m-d H:i:s') . "\tINIT " . $this->trait . ":" . implode("|", $this->_PreparePrefix());
			$GLOBALS['LOG_QUEUE_ERR']['all'] += ( $end_block - $start_block );
		}
		
		if ($this->tobj === null) {
			error_log('Trait can\'t create');
			return false;
		}
		
		return true;
	}

	function IsEnabled() {

		return $this->tobj->IsEnabled();
	}

	function SetTimeout($timeout) {
		$this->default_timeout = $timeout;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет false
	 */
	function Pop($id) {

		if ($this->tobj == null)
			return false;
	
		if (false === ( $id = $this->_PrepareId($id) ))
			return false;			

		$start_block = microtime(true);
		$result = $this->tobj->Pop($id);
		$end_block = microtime(true);
		
		if ($GLOBALS['LOG_QUEUE'] === true) {
			$key = $this->_GetenerateKey($id);

			$GLOBALS['LOG_QUEUE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tPOP " . $this->trait . ":" . $key;
			$GLOBALS['LOG_QUEUE_ERR']['all'] += ( $end_block - $start_block );
		}
		
		return $result;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Push($id, $value, $timeout = 0) {

		if (false === ( $id = $this->_PrepareId($id) ))
			return false;			

		if ($timeout == 0)
			$timeout = $this->default_timeout;

		$start_block = microtime(true);
		
		$result = false;
		if ($this->tobj != null)
			$result = $this->tobj->Push($id, $value, $timeout);
		
		$end_block = microtime(true);
		if ($GLOBALS['LOG_QUEUE'] === true) {
			$key = $this->_GetenerateKey($id);
			
			$GLOBALS['LOG_QUEUE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\tSET " . $this->trait . ":" . $key;
			$GLOBALS['LOG_QUEUE_ERR']['all'] += ( $end_block - $start_block );
		}
		
		return $result;
	}

	function Clear($id) {

		if (false === ( $id = $this->_PrepareId($id) ))
			return false;			

		$start_block = microtime(true);
		
		$result = false;
		if ($this->tobj != null)
			$result = $this->tobj->Clear($id);
			
		$end_block = microtime(true);
		if ($GLOBALS['LOG_QUEUE'] === true) {
			$key = $this->_GetenerateKey($id);

			$GLOBALS['LOG_QUEUE_ERR']['buffer'][] = number_format($end_block - $start_block, 6, ",", " ") . "\t" .
				 date('Y-m-d H:i:s') . "\Clear " . $this->trait . ":" . $key;
			$GLOBALS['LOG_QUEUE_ERR']['all'] += ( $end_block - $start_block );
		}
		return $result;
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
	
	function Destroy() {

		if ($this->tobj != null)
			$this->tobj->Destroy();
	}
	
	function __desrtuct() {

		if ($this->tobj != null)
			$this->tobj->Destroy();
	}
}

abstract class QueueTrait {

	protected $parent;

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
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет null
	 */
	abstract function Pop($id);

	/**
	 * @desc Добавить информацию в кэш
	 */
	abstract function Push($id, $value, $timeout);

	/**
	 * @desc Удаление информации из кэша используя ключ
	 */
	abstract function Clear($id);

	/**
	 * @desc уничтожннин объекта, в данном методе необходимо сохранить все несохраненные данные
	 */
	function Destroy() {

	}
}
?>
