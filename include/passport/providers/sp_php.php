<?
class PassportSessionProvider_php extends PassportSessionProvider
{
	protected $id;	// идентификатор сессии
	
	private $cacher = null;
	private $loaded = false;
	private $data = null;
	private $lazy = true;
	
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->name = 'php';
		
		if($this->lazy == false)
			$this->Connect();
	}
	
	public function Connect()
	{

		if($this->cacher == null)
		{
			LibFactory::GetStatic('cache');			
			$this->cacher = new Cache();
			$this->cacher->Init('memcache', 'sessions');			
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
		if($this->loaded === false && $this->cacher != null)
		{
			$this->loaded = true;
			
			$this->data = $this->cacher->Get($this->id);			
		}
		return $this->data;
	}
	
	public function Save($data, $timeout)
	{
		$this->Connect();
		if($this->loaded === true && $this->cacher != null)
		{
			if(sizeof($data) > 0) {
				$this->cacher->Set($this->id, $data, $timeout);
			} else {
				$this->cacher->Remove($this->id);
			}
		}
	}
}
?>