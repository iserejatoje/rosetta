<?
class PassportSessionProvider_memcache extends PassportSessionProvider
{
	protected $id;	// идентификатор сессии
	
	private $memcache = null;
	private $loaded = false;
	private $data = null;
	private $lazy = true;
	private $host = 'mcpassportsess_surbis_priv';
	
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->name = 'memcache';
		
		if($this->lazy == false)
			$this->Connect();
	}
	
	public function Connect()
	{
		if($this->memcache == null)
		{
			$this->memcache = new Memcache();
			if($this->memcache->pconnect($this->host, 11211) === false) // сессионный
			{
				error_log('Can\'t connect to memcache');
				$this->memcache = null;
			}
		}
	}
	
	/**
	 * Установка уникального идентификатора
	 * @param mixed идентификатор (число, строка, массив (внутри только числа или строки))
	 */
	public function SetArrayID($id)
	{
		$this->id = 'sd_'.implode('|', $id);
	}
	
	/**
	 * Продлить время жизни данных в кэше
	 */
	function Touch($timeout)
	{
		$this->Load();
		$this->Save($this->data, $timeout);
	}
	
	/**
	 * Сборка мусора, здесь удаление записи
	 */
	public function GC()
	{
		$this->data = array();
		$this->Save($this->data, 1);
	}
	
	/**
	 * Загрузака данных сессии из memcache
	 */
	public function Load()
	{
		$this->Connect();
		if($this->loaded === false && $this->memcache != null)
		{
			$this->loaded = true;
			
			$this->data = $this->memcache->get($this->id);

			$this->data = unserialize($this->data);
		}
		return $this->data;
	}
	
	public function Save($data, $timeout)
	{
		$this->Connect();
		if($this->loaded === true && $this->memcache != null)
		{	
			if(sizeof($data) > 0) 
				$this->memcache->set($this->id, serialize($data), MEMCACHE_COMPRESSED, $timeout);
			else 
				$this->memcache->delete($this->id);
		}
	}
}
?>
