<?

class Queue_memcacheq_Trait extends QueueTrait {

	private $memcache;
	private $tries = 0;

	/**
	 * @desc Инициализация
	 */
	function Init() {

		$this->tries += 1;
		$this->memcache = null;

		$this->memcache = new Memcache();
		if ($this->memcache->connect('mcq_surbis_priv', 22201) === false) {
			$this->memcache = null;
		}
	}

	/**
	 * @desc проеверка подключенности к базе
	 * @return true если подключен
	 */
	function IsEnabled() {
		return $this->memcache !== null;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет false
	 */
	function Pop($id) {

		if ($this->IsEnabled() === false)
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;

		$data = $this->memcache->get($id);
		//var_dump($data);
		/*if (false !== ())
			return $data;
			*/
			
		return $data;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Push($id, $value, $timeout) {

		if ($this->IsEnabled() === false)
			return false;
		
		if ($timeout <= 0)
			return false;
		
		if (false === ($id = $this->PrepareId($id)))
			return false;
		
		if ($timeout > 30)
			$method = MEMCACHE_COMPRESSED;
		else
			$method = 0;

		return $this->memcache->set($id, $value, $method, $timeout);
	}

	/**
	 * @desc Очистить цепочку
	 */
	function Clear($id) {

		if ($this->IsEnabled() === false)
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;

		if (false !== ($data = $this->memcache->delete($id)))
			return $data;
			
		return false;
	}
	
	private function PrepareId($path) {

		if (is_array($path) && sizeof($path) > 1) {
			
			foreach ($path as $k=>$v) {
				$path[$k] = trim(preg_replace('~[^a-z0-9_\.-]~i', '', $v));
				
				if (!$path[$k])
					unset($path[$k]);
			}
			
			if (sizeof($path) > 1 && false != ( $path = implode('|', $path) )) {
				return $path;
			}
		}
		return false;
	}
	
	function Destroy() {
		$res = $this->memcache->close();
		$this->memcache = null;
		return $res;
	}
}
?>
