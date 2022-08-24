<?php

class emysqli extends mysqli
{
	private $host = null;
	private $host_ip = null;
	private $username = null;
	private $passwd = null;
	private $dbname = null;
	private $port = null;
	private $socket = null;
	private $is_connected = false;

	private $is_log = false;


	static private $profiling = false;
	// в случае использования профайлинга хранит все конекты, чтобы потом показать
	static private $connections = array();

	public function __construct($host=null, $username=null, $passwd=null, $dbname=null, $port=null, $socket=null, $host_slave = null)
	{
		$this->host = $host;
		$this->host_ip = $this->host;
		$this->username = $username;
		$this->passwd = $passwd;
		$this->dbname = $dbname;
		$this->port = $port;
		$this->socket = $socket;
	}

	static public function SetProfiling($enabled)
	{
		if(is_bool($enabled))
			self::$profiling = $enabled;
	}

	static public function GetProfiling()
	{
		return self::$profiling;
	}

	static public function GetProfiles()
	{
		$profiles = array();
		foreach(self::$connections as $c)
		{
			$res = $c->query('show profiles');
			$profile = array(
				'title' => 'Host: '.$c->GetHostIP().' DB: '.$c->GetDBName(),
				'profile' => array());
			while($row = $res->fetch_assoc())
			{
				$profile['profile'][] = array(
					'id' => $row['Query_ID'],
					'time' => $row['Duration'],
					'query' => $row['Query']
				);
			}

			$profiles[] = $profile;

			if($c->slave !== null)
			{
				$res = $c->query('show profiles');
				$profile = array(
					'title' => 'Host: '.$c->GetHostIP().' DB: '.$c->GetDBName(),
					'profile' => array());
				while($row = $res->fetch_assoc())
				{
					$profile['profile'][] = array(
						'id' => $row['Query_ID'],
						'time' => $row['Duration'],
						'query' => $row['Query']
					);
				}

				$profiles[] = $profile;
			}
		}

		return $profiles;
	}

	public function GetHost()
	{
		return $this->host;
	}

	public function GetHostIP()
	{
		return $this->host_ip;
	}

	public function GetDBName()
	{
		return $this->dbname;
	}

	public function __destruct()
	{
		$close = "not_opened";
		if($this->is_connected === true)
		{
			$close = "opened";
			if(parent::close())
			{
				$close = "closed";
				$this->is_connected = false;
			}
		}
	}

	public function SetHost($host)
	{
		$this->host = $host;
		$this->host_ip = gethostbyname($this->host);
		$this->Close();
		return true;
	}

	public function Close()
	{
		global $OBJECTS;
		if($this->is_connected === true)
		{
			$this->is_connected = false;
			return parent::close();
		}
		return false;
	}

	private function __connect()
	{
		global $OBJECTS;
		$start_block = microtime(true);

		parent::__construct($this->host_ip, $this->username, $this->passwd, $this->dbname, $this->port, $this->socket);

		if ( mysqli_connect_errno() === 0 )
			$this->is_connected = true;
		else
			$this->is_connected = false;

		if ( $this->is_connected === false )
			return false;

		if( App::$Terminal === App::TM_HTTP )
			parent::query('SET wait_timeout=10, interactive_timeout=10');
		parent::query('SET NAMES utf8');

		$end_block = microtime(true);

		if(self::$profiling === true)
		{
			parent::query('set profiling=1');
		}

		return true;
	}

	public function ping()
	{
		global $OBJECTS;

		$res = parent::ping();
		if($res === true)
		{
			if( App::$Terminal === App::TM_HTTP )
				parent::query('SET wait_timeout=10, interactive_timeout=10');
			parent::query('SET NAMES utf8');
		}
		return $res;
	}

	public function query($query, $resmode = MYSQLI_STORE_RESULT)
	{
		global $OBJECTS;
		$start_block = microtime(true);

		if($this->is_connected === false)
			if($this->__connect() === false)
			{
				error_log("EMySQLi: Can't connect to mysql server. (".mysqli_connect_errno().") ".mysqli_connect_error());
				return false;
			}


		$res = parent::query($query, $resmode);

		if($res === false)
		{
			$errstr = 'mysql error: '.($this->error).chr(10).'in query: '.$query;
			$errinfo = debug_backtrace();
			$errstr.= chr(10).'file: '.$errinfo[0]['file'].' line: '.$errinfo[0]['line'].chr(10);

			trigger_error($errstr, E_USER_WARNING);
		}


		return $res;
	}

	public function multi_query($query)
	{
		global $OBJECTS;
		if($this->is_connected === false)
			if($this->__connect() === false)
			{
				trigger_error("EMySQLi: Can't connect to mysql server. (".mysqli_connect_errno().") ".mysqli_connect_error(), $force ? E_USER_WARNING : E_USER_ERROR);
				return false;
			}

		if($this->ping() === false)
		{
			$errstr = 'mysql error: (PING) '.($this->error).chr(10).'in query: '.$query;
			$errinfo = debug_backtrace();
			$errstr.= chr(10).'file: '.$errinfo[0]['file'].' line: '.$errinfo[0]['line'].chr(10);
			trigger_error($errstr, E_USER_WARNING);
		}
		$start_block = microtime(true);

		$res = parent::multi_query($query);
		if($res === false)
		{
			$errstr = 'mysql error: '.($this->error).chr(10).'in query: '.$query;
			$errinfo = debug_backtrace();
			$errstr.= chr(10).'file: '.$errinfo[0]['file'].' line: '.$errinfo[0]['line'].chr(10);
			trigger_error($errstr, E_USER_WARNING);
		}


		$end_block = microtime(true);

		return $res;
	}

	/**
	 * Вызов процедуры, для одного результата, после работы необходимо почистить
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string)
	 * @param ... параметры
	 */
	public function call($proc, $type = '')
	{
		$this->call_handler(func_get_args());
		return parent::store_result();
	}

	/**
	 * Вызов процедуры, для одного результата, возвращает строку
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string)
	 * @param ... параметры
	 */
	public function call_row($proc, $type = '')
	{
		$this->call_handler(func_get_args());
		$row = null;
		if($res = parent::store_result())
		{
			if($r = $res->fetch_row())
				$row = $r;
		}
		$this->free_results($res);
		return $row;
	}

	/**
	 * Вызов процедуры, для одного результата, возвращает строку
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string)
	 * @param ... параметры
	 */
	public function call_assoc($proc, $type = '')
	{
		$this->call_handler(func_get_args());
		$row = null;
		if($res = parent::store_result())
		{
			if($r = $res->fetch_assoc())
				$row = $r;
		}
		$this->free_results($res);
		return $row;
	}

	/**
	 * Вызов процедуры, для одного результата, возвращает первый элемент первой строки
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string)
	 * @param ... параметры
	 */
	public function call_scalar($proc, $type = '')
	{
		$this->call_handler(func_get_args());
		$val = null;
		if($res = parent::store_result())
		{
			if($r = $res->fetch_row())
				$val = $r[0];
		}
		$this->free_results($res);
		return $val;
	}

	/**
	 * Вызов процедуры, по окончании очистить ресурсы
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string)
	 * @param ... параметры
	 */
	public function call_multi($proc, $type = '')
	{
		return $this->call_handler(func_get_args());
	}

	/**
	 * Вызов процедуры и освобождение ресурсов (INSERT, UPDATE, DELETE)
	 * @param string имя процедуры
	 * @param string типы (i - integer, d - double, s - string, a - as is)
	 * @param ... параметры
	 */
	public function call_free($proc, $type = '')
	{
		$res = $this->call_handler(func_get_args());
		$this->free_results();
		return $res;
	}

	private function call_handler($params)
	{
		$proc = array_shift($params);
		$type = array_shift($params);
		$query = "CALL ".$proc."(";
		$pquery = '';
		foreach($params as $k => $v)
		{
			if(strlen($pquery) > 0)
				$pquery.=',';
			switch(substr($type, $k, 1))
			{
				case "i":
					$pquery.= intval($v);
					break;
				case "d":
					$pquery.= doubleval($v);
					break;
				case "s":
					$pquery.= "'".addslashes($v)."'";
					break;
				case "a":
					$pquery.= $v;
					break;
			}
		}
		$query.= $pquery.')';
		return $this->multi_query($query);
	}

	/**
	 * чистка всех оставшихся результатов
	 */
	public function free_results($res = null)
	{
		if($res != null)
			$res->close();
		do
		{
			if($res = parent::store_result())
				$res->close();
		}while(parent::next_result());
	}
}

