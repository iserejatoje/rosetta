<?

class Queue_redisq_Trait extends QueueTrait
{
	private $redis;

	/**
	 * @desc Инициализация
	 */
	function Init()
	{
		$this->redis = LibFactory::GetInstance('redis');
		$this->redis->Init('queues');
	}
	
	/**
	 * @desc проеверка подключенности к базе
	 * @return true если подключен
	 */
	function IsEnabled()
	{
		return $this->redis !== null;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет false
	 */
	function Pop($id)
	{
		if ( $this->IsEnabled() === false )
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;
		
		$data = false;
		
		try
		{
			$data = $this->redis->rPop($id);
		}
		catch ( RuntimeBTException $e )
		{
			return false;
		}
		
		if ( false !== ($value = unserialize($data)) )
			$data = $value;
		
		return $data;
	}
	
	
	/**
	 * @desc Добавить информацию в кэш
	 */
	function Push($id, $value, $timeout)
	{
		if ( $this->IsEnabled() === false )
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;
		
		$data = false;
		
		if ( is_array($value) )
			$value = serialize($value);
		
		try
		{
			$data = $this->redis->lPush($id, $value);
		}
		catch ( RuntimeBTException $e )
		{
			return false;
		}
		
		return $data;
	}
	
	
	/**
	 * @desc Очистить цепочку
	 */
	function Clear($id)
	{
		if ( $this->IsEnabled() === false )
			return false;
		
		if (false === ( $id = $this->PrepareId($id) ))
			return false;
		
		$data = false;
		
		try
		{
			$data = $this->redis->lTrim($id, 1, 0);
		}
		catch ( RuntimeBTException $e )
		{
			return false;
		}
		
		return $data;
	}
	
	
	private function PrepareId($path)
	{
		if ( !is_array($path) || sizeof($path) == 0)
			return false;
		
		return implode(':', $path);
	}
	
	
	function Destroy()
	{
		$this->redis = null;
		return true;
	}
}
?>