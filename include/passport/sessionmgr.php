<?php

/**
 * @version 1.0
 * @created 04-мар-2008 9:26:58
 */

LibFactory::GetStatic('axarray');

class PSessionMgr extends AxArrayObject
{
	private	$user				= null;			// Текущий пользователь
	private	$usersMgr			= null;
	private	$sessionProvider	= null;
	private $isloaded			= false;
	private $timeout			= 1200;

	private $config = array(
		'provider' => array('name' => 'php'),
	);


	/**
	 * Конструктор
	 * @param User user пользователь
	 * @param UserMgr менеджер пользователей
	 */
	function __construct($user, $mgr)
	{
		global $CONFIG;

		parent::__construct();

		$this->user = $user;
		$this->usersMgr = $mgr;

		if(is_file($CONFIG['engine_path'].'include/passport/providers/sp_'.$this->config['provider']['name'].'.php'))
		{
			include_once $CONFIG['engine_path'].'include/passport/providers/sp_'.$this->config['provider']['name'].'.php';
			$class_name = 'PassportSessionProvider_'.$this->config['provider']['name'];
			$this->sessionProvider = new $class_name($this);
			$this->sessionProvider->SetID($user->ID, $user->SessionCode);
			//$this->Touch();
		}
		else
		{
			$this->sessionProvider = null;
			error_log($CONFIG['engine_path'].'include/passport/providers/sp_'.$this->config['provider']['name'].'.php not found');
		}
	}

	public function Dispose()
	{
		$this->Save();
	}

	public function __destruct()
	{
		$this->Save();
	}

	/**
	 * Установить время жизни сессии
	 * @param int время жизни
	 * @return int предыдущее время жизни
	 */
	public function SetTimeout($timeout)
	{
		$t = $this-> timeout;
		$this->timeout = $timeout;
		return $t;
	}

	/**
	 * Продлить время жзни данных сессии
	 */
	public function Touch()
	{
		if($this->sessionProvider != null)
		{
			if($this->IsChanged())
				$this->sessionProvider->Save($this->data, $this->timeout);
			else
				$this->sessionProvider->Touch($this->timeout);
		}
	}

	/**
	 * Уничтожение сессии
	 */
	public function Destroy()
	{
		$this->cache = array();

		if($this->sessionProvider != null)
			$this->sessionProvider->GC();
	}

	protected function Load()
	{
		if($this->isloaded === false)
		{
			$this->isloaded = true;
			if($this->sessionProvider != null)
				$this->data = $this->sessionProvider->Load();
		}
	}

	protected function Save()
	{
		if($this->sessionProvider != null && $this->isloaded === true)
			$this->sessionProvider->Save($this->data, $this->timeout);
	}

	// ArrayAccess
	public function offsetExists($offset)
	{
		$this->Load();
		return parent::offsetExists($offset);
	}

	public function offsetGet($offset)
	{
		$this->Load();
		return parent::offsetGet($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->Load();
		return parent::offsetSet($offset, $value);
	}

	public function offsetUnset($offset)
	{
		$this->Load();
		return parent::offsetUnset($offset);
	}
}

abstract class PassportSessionProvider
{
	protected	$name		= 'base';

	public function __construct($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Установка уникаольного идентификатора
	 * @param mixed идентификатор (число, строка, массив (внутри только числа или строки))
	 */
	public function SetID($id)
	{
		$ids = array();

		$args = func_get_args();
		foreach($args as $arg)
		{
			// объекты и ресурсы недопустимы
			if(is_object($arg) || is_resource($arg))
				throw new InvalidArgumentException();

			if(is_array($arg))
			{
				foreach($arg as $sarg)
				{
					// внутри массива только скаляр
					if(!is_scalar($sarg))
						throw new InvalidArgumentException();

					// конвертим в строку
					$ids[] = (string)$sarg;
				}
			}
			else
				$ids[] = (string)$arg; // конвертим в строку
		}

		// устанавливаем идентификатор
		$this->SetArrayID($ids);
	}

	/**
	 * Установка уникаольного идентификатора
	 * @param mixed идентификатор (число, строка, массив (внутри только числа или строки))
	 */
	abstract protected function SetArrayID($id);

	/**
	 * Чтение данных сессии
	 * @return array данные
	 */
	abstract public function Load();

	/**
	 * Запись данных
	 * @param array данные
	 * @param int время жизни в секундах
	 */
	abstract public function Save($data, $timeout);

	/**
	 * Сборка мусора
	 */
	abstract public function GC();
}

?>
