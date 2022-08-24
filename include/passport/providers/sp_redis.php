<?
class PassportSessionProvider_redis extends PassportSessionProvider
{
	protected $id;	// идентификатор сессии
	
	private $redis = null;
	private $loaded = false;
	private $data = null;
	private $lazy = true;
	
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->name = 'redis';
		
		if($this->lazy == false)
			$this->Connect();
	}
	
	public function Connect()
	{
		if($this->redis == null)
		{
			$this->redis = LibFactory::GetInstance('redis');
			$this->redis->Init('sessions');
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
	 * Загрузака данных сессии из redis
	 */
	public function Load()
	{
		$this->Connect();
		if($this->loaded === false && $this->redis != null)
		{
			$this->loaded = true;
			
			$this->data = $this->redis->Get($this->id);
			if (false !== $this->data)
				$this->data = unserialize($this->data);
		}
		return $this->data;
	}
	
	public function Save($data, $timeout)
	{
		$this->Connect();
		if($this->loaded === true && $this->redis != null)
		{
			if(sizeof($data) > 0) {
				$this->redis->Set($this->id, serialize($data), $timeout);
			} else {
				$this->redis->Remove($this->id);
			}
		}
	}
}
?>