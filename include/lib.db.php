<?

// присутствует рекурсия вызовов в цепочке GetInstance -> GetInfo -> GetInstance
class DBFactory
{
	private static $cache = array(
		'links' => array(),
		'info' => array(
			
		),
	);
	
	protected static $usemcache = false;
	protected static $mcache = null;
	protected static $mtimeout = 300;
	protected static $initialized = false;
	
	const MODE_DATA = 1;
	const MODE_OBJECT = 2;
	
	public static function Init()
	{
		if(self::$initialized === false)
		{
			if(self::$mcache === null)
			{
				LibFactory::GetStatic('cache');
				self::$mcache = new Cache();
				if(self::$usemcache === true)
					self::$mcache->Init('memcache', 'app_sdb');
				else
					self::$mcache->Init('dummy', 'app_sdb');
			}
			self::$initialized = true;
		}
	}

	static function GetInstance($name, $persist = false)
	{
		global $CONFIG;
		if(!isset(self::$cache['links'][$name]))
		{
			$info = self::GetInfo($name);
			if($info === null)
				return false; // было давно, менять не буду
			
			self::$cache['links'][$name] = new emysqli('localhost', DB_USER, DB_PASSWORD, DB_NAME);

			if($persist === true)
				self::$cache['links'][$name]->query('SET wait_timeout=86400');
		}
		return self::$cache['links'][$name];
	}
	
	static function Store($name, $host, $user, $pass)
	{
		$sql = "INSERT INTO db";
		$sql.= " SET";
		$sql.= " name='".addslashes($name)."',";
		$sql.= " host='".addslashes($host)."',";
		$sql.= " user='".addslashes($user)."',";
		$sql.= " pass='".addslashes($pass)."'";
		$sql.= " ON DUPLICATE KEY UPDATE";
		$sql.= " host='".addslashes($host)."',";
		$sql.= " user='".addslashes($user)."',";
		$sql.= " pass='".addslashes($pass)."'";
		self::GetInstance('site')->query($sql);
	
		self::ClearMCache($name);
		self::ClearCache($name);
	}
	
	static function Remove($name)
	{
		$sql = "DELETE FROM db WHERE name='".addslashes($name)."'";
		self::GetInstance('site')->query($sql);
	
		self::ClearMCache($name);
		self::ClearCache($name);
	}
	
	static function GetInfo($name)
	{
		$host_token = str_replace("_", "-", $name);
		return array(
			'host' => 'localhost',			
			'user' => $name,
			'pass' => $name,
			'name' => $name,
		);		
	}
	
	// чистка кэша PHP
	static function ClearCache($name = null)
	{
		if($name === null)
		{
			// оставить данные о бд site
			$data = array('site' => self::$cache['info']['site']);
			unset(self::$cache['info']);
			self::$cache['info'] = $data;
			
			unset(self::$cache['links']);
		}
		else
		{
			if($name != 'site')
				unset(self::$cache['info'][$name]);
			unset(self::$cache['links'][$name]);
		}
	}
	
	// чистить memcache
	static function ClearMCache($name)
	{
		self::$mcache->Remove('db_'.$name);
	}
	
	static function Iterator($mode = self::MODE_DATA)
	{
		return new DBIterator(self::$mcache, self::$mtimeout, $mode);
	}
}

class DBIterator implements iterator, countable
{
	private $data = array();
	static private $cache = null;
	private $mcache = null;
	private $mtimeout = null;
	private $mode;
	public function __construct($cacher, $timeout, $mode = DBFactory::MODE_DATA)
	{
		$this->mcache = $cacher;
		$this->mtimeout = $timeout;
		if($mode != DBFactory::MODE_DATA && $mode != DBFactory::MODE_OBJECT)
			$mode = DBFactory::MODE_DATA;
		$this->mode = $mode;
		
		if(self::$cache === null)
		{
			self::$cache = $this->mcache->Get('dblist');
			if(self::$cache === false)
			{
				$sql = "SELECT * FROM db";
				$res = DBFactory::GetInstance('site')->query($sql);
				while($row = $res->fetch_assoc())
					self::$cache[$row['name']] = $row;
				$this->mcache->Set('dblist', self::$cache, $this->mtimeout);
			}
		}
		$this->data = self::$cache;
	}
	
	public function count()
	{
		return count($this->data);
	}
	
	// Iterator
	private $iterator = null;
	public function current ()
	{
		if($this->mode == DBFactory::MODE_DATA)
			return current($this->data);
		else
		{
			$c = current($this->data);
			return DBFactory::GetInstance($c['name']);
		}
	}
	
	public function key () 
	{
		return key($this->data);	
	}
	
	public function next () 
	{
		return next($this->data);
	}
	
	public function rewind () 
	{
		return reset($this->data);
	}
	
	public function valid () 
	{
		return current($this->data) !== false;
	}
}

DBFactory::Init();
