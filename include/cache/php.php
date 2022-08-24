<?

class Cache_php_Trait extends CacheTrait {

	private $cache_dir = PHP_CACHE_DIR;
	
	private $work_dir = '';
	
	private $temp_dir = '';

	private $dir_umask = 0000;

	private $file_umask = 0111;

	private $enabled = false;

	function __construct() {
		$this->cache_dir = $this->cache_dir.'/'; 
		parent::__construct();
	}

	/**
	 * @desc Инициализация
	 */
	function Init() {

		$this->enabled = true;
		
		if (!is_dir($this->cache_dir)) {
			$this->enabled = false;
			error_log('PHP Cache: root directory is not exists "'.$this->cache_dir.'"');
		}

		$this->work_dir = realpath($this->cache_dir.'work');
		$this->temp_dir = realpath($this->cache_dir.'temp');
		if (!is_dir($this->work_dir) || !is_writable($this->work_dir)) {
			$this->enabled = false;
			error_log('PHP Cache: work directory is not exists or not writeable "'.$this->work_dir.'"');
		}
		if (!is_dir($this->temp_dir) || !is_writable($this->temp_dir)) {
			$this->enabled = false;
			error_log('PHP Cache: temp directory is not exists or not writeable  "'.$this->temp_dir.'"');
		}
		
		return $this->enabled && $this->work_dir && $this->temp_dir;
	}

	/**
	 * @desc проеверка подключенности к базе
	 * @return true если подключен
	 */
	function IsEnabled() {

		return $this->enabled;
	}

	/**
	 * @desc проверка наличия информации в кэше
	 * @return true если есть запись в кэше
	 */
	function IsCache($id, $key) {

		$res = $this->Get($id);
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
	function Get($id) {

		if ($this->IsEnabled() === false)
			return false;
		
		if (false === ($file = $this->_path($id)))
			return false; 
		
		$file = $this->work_dir . '/' . $file;
		
		if (is_file($file . '.php') && is_file($file . '.time')) {
			$time = @file_get_contents($file . '.time');
			if ($time && $time >= time()) {
				return include ( $file . '.php' );
			}
		}
		return false;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Set($id, $value, $timeout, $method = null, $tags = false)
	{
		
		if ($this->IsEnabled() === false)
			return false;
		
		
		$path = $this->_path($id);
		
		if ($path && $timeout > 0) {
			$path = $this->work_dir . '/' . $path;
			if (!is_dir(dirname($path)))
				$this->_create_dir(dirname($path));
			
			$value = var_export($value, true);
			if ($value !== null) {
				
				$umask = @umask($this->file_umask);
				$path = pathinfo($path);
				
				// Файл данных
				$fData = tempnam($path['dirname'], 'data');
				// Файл с временем жизни кеша
				$fTime = tempnam($path['dirname'], 'time');
				// Имя файла созданное по ключу
				$file = $path['dirname'] . '/' . $path['basename'];
				
				if (file_put_contents($fData, '<? return ' . $value . ';?>')>0 && file_put_contents($fTime, time()+$timeout)>0) {
					
					rename($fData, $file . '.php');
					rename($fTime, $file . '.time');
					chmod($file . '.php', 0777 ^ $this->file_umask);
					chmod($file . '.time', 0777 ^ $this->file_umask);
					
					@umask($umask);
					return true;
				}
				@unlink($fTime);
				@unlink($fData);
				@umask($umask);
			}
		}
		return false;
	}

	/**
	 * @desc Удалить информацию из кэша
	 */
	function Remove($id) {

		if ($this->IsEnabled() === false)
			return false;
			
		if (false === ($path = $this->_path($id)))
			return false;

		$path = $this->work_dir . '/' . $path;
		if (is_file($path.'.time'))
			unlink($path.'.time');
			
		if (is_file($path.'.php'))
			unlink($path.'.php');

		return true;
	}
	

	/**
	 * @desc Удалить информацию из кэша используя тег
	 */
	function ClearTags($tags = array())
	{
		return true;
	}
	
	/**
	 * @desc Удалить информацию из кэша используя ключ
	 */
	function Clear($id) {
				

		if ($this->IsEnabled() === false)
			return false;
		
		if ($id) {
			if (false === ($path = $this->_path($id)))
				return false;

			if(is_file($this->work_dir . '/' . $path . '.php'))
				return $this->Remove($id);
				
			if(!is_dir($this->work_dir . '/' . $path))
				return false;
		}
		else
			return false;
				
		// не можем удалять начало нашего хранилища
		if(strpos($this->work_dir, $this->work_dir . '/' . $path) === 0)
			return false;

		// все что за пределами хранилища тоже удалять нельзя :)
		if(strpos($this->work_dir . '/' . $path, $this->work_dir) !== 0)
			return false;
			
		$tmpnam = str_replace('/', '_', $path).time();
		if(is_dir($this->work_dir . '/' . $path))
			return rename($this->work_dir . '/' . $path, $this->temp_dir . '/' . $tmpnam);
		else
			return false;
	}

	/**
	 * @desc Очистить временную папку кеша
	 */
	function Clear_Temp($dir = '', $deleteMe = false) {
		
		if ($this->IsEnabled() === false)
			return false;

		if (!$dir) {
			$_dir = $this->temp_dir;
		} else {
			$_dir = $this->temp_dir . $dir;
		}
		$_dir = realpath($_dir);

		// все что за пределами хранилища тоже удалять нельзя :)
		if(strpos($_dir, $this->temp_dir) !== 0)
			return false;
		
		if(!$dh = @opendir($_dir)) 
			return false;
    	
		while (false !== ($obj = readdir($dh))) {
	        if($obj=='.' || $obj=='..') continue;
        	if (!@unlink($_dir . '/' . $obj)) 
        		$this->Clear_Temp($dir . '/' . $obj, true);
	    }
    	
    	closedir($dh);
	    if ($deleteMe)
        	@rmdir($_dir);
		
		return true;
	}
	
	/**
	 * @desc Почистить мусор в кеше
	 */
	function GC($dir = null) {
		
		if ($this->IsEnabled() === false)
			return false;

		if ($dir === null) {
			$_dir = $this->work_dir;
		} else {
			if( strpos($dir, '/') !== 0 )
				$_dir = $this->work_dir . $dir;
			else
				$_dir = $dir;
		}
		$_dir = preg_replace('@/+$@', '', $_dir);

		// все что за пределами хранилища тоже удалять нельзя :)
		if(strpos($_dir, $this->work_dir) !== 0)
			return false;

		if(!$dh = @opendir($_dir)) 
			return false;
    	
		$now = time();
		$wd_len = strlen($this->work_dir);
		$deleteMe = true;
		while (false !== ($obj = readdir($dh))) {
	        if($obj=='.' || $obj=='..') continue;
			
			$path = $_dir.'/'.$obj;
			if( is_dir($path) )
			{
				if( $this->GC($path) === false )
					$deleteMe = false;
			}
			else if( is_file($path) )
			{
				if( preg_match('@^(.+)\.time$@', $obj, $rg) )
				{
					$fTime = file_get_contents($path);
					if( $fTime === false || $fTime < $now )
					{
						$path2 = $_dir.'/'.$rg[1].'.php';
						if( is_file($path2) )
						{
							//echo 'delete file: '.$path2."\n";
							unlink($path2);
							if( is_file($path) )
								unlink($path);
						}
					}
					else
						$deleteMe = false;
				}
				else if( preg_match('@^.+\.php$@', $obj) )
				{
					// nenf ниче делать не надо.
				}
				else
					$deleteMe = false;
			}
			else
				$deleteMe = false;
	    }
    	closedir($dh);
		
		/**
		* Если в папке нет ничего, то можно удалять
		*/
	    if( $deleteMe === true && $dir !== null )
		{
			//echo 'delete dir: '.$_dir."\n";
			if( is_dir($_dir) )
				$deleteMe = rmdir($_dir);
		}
		
		return $deleteMe;
	}
	
	/**
	 * @desc Продлить время жизни данных в кэше
	 */
	function Touch($id, $timeout) {
		
		$res = false;
		if ($this->IsEnabled() !== false) {

			$path = $this->_path($id);
			if ($path && $timeout > 0) {
				$path = $this->cache_dir . 'work/' . $path.'.time';
				if (is_file($path)) {
					if(file_put_contents($path, time()+$timeout))
						$res = true;
				}
			}
		}
		return $res;
	}

	private function _path($path) {

		if (is_array($path) && sizeof($path) > 1) {
			
			$_path = array();
			foreach ($path as $k=>$v) {
				$kkkk = trim(preg_replace('@[\/\:\*"\?\<\>\|]@', '', $v));
				if($kkkk== '')
					Data::e_backtrace(__METHOD__."(): error key: '".$v."'");
				else
					$_path[$k] = $kkkk;
			}

			if (sizeof($_path) > 1 && false != ( $_path = implode('/', $_path) )) {
				return $_path;
			}
		}
		return false;
	}

	private function _path_unpack($path) {

		return explode("/", $path);
	}

	private function _create_dir($path) {

		if (is_dir($path))
			return true;
			
		// не можем создать начало нашего хранилища
		if (strpos($this->work_dir, $path) === 0)
			return true;
			
		// все что за пределами хранилища тоже трогать нельзя :)
		if (strpos($path, $this->work_dir) !== 0)
			return false;
		
		$rg = array();
		if (preg_match('@^(.+\/)[^\/]+\/?$@', $path, $rg))
			$tempnam = $rg[1];
		
		if (!is_dir($tempnam) && $this->_create_dir($tempnam) === false)
			return false;
		
		$umask = @umask($this->dir_umask);
		if (mkdir($path)) {
			@umask($umask);
			return true;
		} else {
			@umask($umask);
			return false;
		}
	}
}
?>
