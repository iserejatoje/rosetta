<?

class Cache_memcache_Trait extends CacheTrait
{
	private $memcache;

	private $tries = 0;
	
	private $host = '';
	private $host_ip = '';
	private $port = 11211;

	// Кэш версий тагов
	private $_tag_versions = array();
	// Списки ключей по тэгам,  которые закэшированы либой
	private $_cached_by_tag = array();

	private $prepared_prefix = null;
	

	/**
	 * @desc Инициализация
	 */
	function Init($params = array())
	{		
		if( isset($params['host']) )
			$this->host = $params['host'];
		else
		{
			$this->host = 'localhost';
		}
		if( isset($params['port']) )
			$this->port = $params['port'];

		$this->host_ip = gethostbyname($this->host);
		if($this->host_ip == $this->host)
			error_log('WTF??? gethostbyname do not work: '.$this->host.':'.$this->host_ip);
		
		$this->tries += 1;
		$this->memcache = new Memcache();
		
		if ( $this->memcache->pconnect($this->host_ip, $this->port) === false )
			$this->memcache = null;
	}

	/**
	 * @desc проеверка подключенности к базе
	 * @return true если подключен
	 */
	function IsEnabled() {

		return $this->memcache !== null;
	}

	/**
	 * @desc проверка наличия информации в кэше
	 * @return true если есть запись в кэше
	 */
	function IsCache($id, $key) {

		if ($this->IsEnabled() === false)
			return false;
		
		$res = $this->memcache->get($id);
		if ($res !== false && !empty($res)) {
			$this->parent->_FillCache(array($key, $res));
			return true;
		}
		return false;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет false
	 */
	function Get($id)
	{
		if ($this->IsEnabled() === false)
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;
		
		$data = $this->memcache->get(MAIN_DOMAIN.$id);		
		// КОНЕЦ: работа с тэгами		
		return $data;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Set($id, $value, $timeout, $method = null, $tags = false)
	{
		if ($this->IsEnabled() === false)
			return false;
		
		if ( false === ($id = $this->PrepareId($id)) )
			return false;
		
		
			$method = MEMCACHE_COMPRESSED;
		
		// НАЧАЛО: работа с тэгами
		if ( is_array($tags) && count($tags) )
		{
			$tagVersions = array();
			foreach ( $tags as $tag )
			{
				// сохраним информацию о том, что данный глюч закэширован по тагу
				$this->_cached_by_tag[$tag][] = $id;
				
				// получим актуальную версию тага
				$tagVersion = $this->_tag_versions[$tag] ? $this->_tag_versions[$tag] : $this->parent->Get( MEMCACHE_TAGPREFIX . $tag );
				
				// если не задана - установим новую
				if ( empty($tagVersion) )
				{
					$tagVersion = md5(microtime() + rand());
					$this->parent->Set( MEMCACHE_TAGPREFIX . $tag, $tagVersion, 0 );
				}
				$tagVersions[$tag] = $tagVersion;
			}
			$value = array (
					'memcachetags' => $tagVersions,
					'data' => $value,
				);
		}
		// КОНЕЦ: работа с тэгами
		$this->memcache->set(MAIN_DOMAIN.$id, $value, $method, $timeout);
		
		return true;
	}

	/**
	 * @desc Удалить информацию из кэша
	 */
	function Remove($id) {

		if ($this->IsEnabled() === false)
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;
		
		$result = $this->memcache->delete($id, 0);
		
		return $result;
	}


	/**
	 * @desc Удалить информацию из кэша используя ключ
	 */
	function Clear($id)
	{
		return true;
	}
	

	/**
	 * @desc Удалить информацию из кэша используя тег
	 */
	function ClearTags($tags = array())
	{
		if ($this->IsEnabled() === false)
			return false;
		
		$tags = (array) $tags;
		
		foreach ( $tags as $tag )
		{
			$this->parent->Remove( MEMCACHE_TAGPREFIX . $tag );
			
			if ( !is_array($this->_cached_by_tag[$tag]) )
				continue;
			
			// удалить ключи по тегу  из кэша
			foreach ( $this->_cached_by_tag[$tag] as $key )
			{
				$result = $this->memcache->delete($key, 0);
				
				if ( $result === false )
					continue;
				
				unset($this->parent->cache[$key]);
			}
			
			unset($this->_cached_by_tag[$tag]);
		}

		return true;
	}

	/**
	 * @desc Очистить временную папку кеша
	 */
	function Clear_Temp($dir = '', $deleteMe = false) {

		return true;
	}

	/**
	 * @desc Продлить время жизни данных в кэше
	 */
	function Touch($id, $timeout) {

		if ($this->IsEnabled() === false)
			return;
				
		$key = $this->parent->_GetenerateKey($id);
			
		if (!isset($this->parent->cache[$key])) {
			$res = $this->Get($id);
			if ($res !== false)
				$this->parent->_FillCache(array($key, $res));
		}
		
		if (isset($this->parent->cache[$key]))
			$this->Set($id, $this->parent->cache[$key], $timeout);
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
	
	private function PreparePrefix() {

		if( $this->prepared_prefix !== null )
			return $this->prepared_prefix;
		
		$path = $this->parent->_PreparePrefix();
		if (is_array($path) && sizeof($path) > 0) {
			
			foreach ($path as $k=>$v) {
				$path[$k] = trim(preg_replace('~[^a-z0-9_\.-]~i', '', $v));
			}
			$this->prepared_prefix = implode("|", $path);
		}
		else
			$this->prepared_prefix = 'unknown';
		return $this->prepared_prefix;
	}
	
	/**
	 * @desc Почистить мусор в кеше
	 */
	function GC() {
	}
}
?>
