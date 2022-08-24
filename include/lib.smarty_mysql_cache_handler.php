<?

class Lib_Smarty_mysql_cache_handler
{
	static $Name = 'smarty_mysql_cache_handler';
  /**
   * name of cache store
   *
   * @var string
   */
	private $cachename   = "";
  /**
   * use gzip commpression?
   *
   * @var boolean
   */
	private $use_gzip    = false;
  /**
   * level of gzip compression 0-9 (null - ue default)
   *
   * @var integer
   */
	private $gzip_level  = null;

	private $_db         = null;
	
	private $smarty_obj  = null;

	private $data  = array();
	
	function __construct()
	{
	}
	
	function __destruct()
	{
	}
	
	function Init($name = null, $use_gzip = null, $gzip_level = null)
	{
//		global $CONFIG, $LCONFIG;
//		
//		LibFactory::GetConfig(self::$Name);
//		$this->_config = $LCONFIG[self::$Name];
		$this->_config = array(
			'db' => 'smarty',
			'cache_pref' => 'cache_',
		);

		$this->cachename = "common";
		if($name !== null)
			$this->cachename = $name;
		if($use_gzip !== null)
			$this->use_gzip = $use_gzip;
		if($gzip_level !== null)
			$this->gzip_level = $gzip_level;
	}
	
  /**
   * some action with cache
   *
   * @param string $action name of method
   * @param string $smarty_obj link to the smarty object
   * @param string $cache_content container for cached data
   * @param string $tpl_file name of template file
   * @param string $cache_id name of cache_id
   * @param string $compile_id name of compile_id
   * @param string $exp_time expiration time
   * @return boolean
   */
	function Action($action, &$smarty_obj, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
	{
		if($this->_db === null)
		{
			$this->_db = DBFactory::GetInstance($this->_config['db']);
			$this->_db->query("SET NAMES cp1251");
		}

		$this->smarty_obj = $smarty_obj;

		/**
		* Read from cache
		*/
		if($action == 'read')
		{
			# проверки на актуальность кеша НЕТ!!! т.к. работает чистилка кеша.
			$cache_content = $this->_read($tpl_file, $cache_id, $compile_id);
			if( $cache_content === false )
			{
//				error_log(strtoupper(self::$Name).": $tpl_file read from cache 0");
				return false;
			}
			else
			{
//				error_log(strtoupper(self::$Name).": $tpl_file read from cache 1");
				return true;
			}
		}
		/**
		* Write to cache
		*/
		else if( $action == 'write' )
		{
			$expire = $this->smarty_obj->_cache_info['expires']==-1 ? time()+86400*365 : $this->smarty_obj->_cache_info['expires'];
			$cache_content = $this->_write($cache_content, $tpl_file, $cache_id, $compile_id, $expire);
			if( $cache_content === false )
			{
//				error_log(strtoupper(self::$Name).": $tpl_file write to cache 0");
				return false;
			}
			else
			{
//				error_log(strtoupper(self::$Name).": $tpl_file write to cache 1");
				return true;
			}
		}
		/**
		* Clear cache
		*/
		else if( $action == 'clear' )
		{
			return $this->_clear($tpl_file, $cache_id, $compile_id);
		}
		/**
		* It is the Asshole
		*/
		else
		{
			// ошибка, указан неизвестный метод
			$this->smarty_obj->trigger_error("cache error: unknown method: ".$action);
			return false;
		}
	}
	
  /**
   * generate unique ID of cached row
   *
   * @param string $tpl_file name of template file
   * @param string $cache_id name of cache_id
   * @param string $compile_id name of compile_id
   * @return string(32) md5()
   */
	private function _get_id($tpl_file = null, $cache_id=null, $compile_id=null)
	{
		if( $tpl_file===null )
			return "";

		if ($cache_id !== null)
			$id = ($compile_id !== null) ? $cache_id . '|' . $compile_id  : $cache_id;
		elseif($compile_id !== null)
			$id = $compile_id;

		$id.= "|" . $tpl_file;
		return md5($id);
	}
	
  /**
   * create tablefor the cache
   *
   * @return boolean
   */
	private function _create_table()
	{
		$sql = "CREATE TABLE `".$this->_config['cache_pref'].$this->cachename."` (
  `id` varchar(32) NOT NULL default '',
  `expires` int(11) unsigned NOT NULL default '0',
  `template` varchar(255) NOT NULL default '',
  `cacheid` varchar(255) NOT NULL default '',
  `compileid` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251";
		$res = $this->_db->query($sql, null, true);
		if($res == false && $this->_db->errno)
		{
			$this->smarty_obj->trigger_error("cache error: Incorrect query: ".$this->_db->error." Query: ".$sql."");
//			error_log(strtoupper(self::$Name).": create table error. (".$this->_db->error." IN query ".$sql.")");
			return false;
		}
		return true;
	}
	
  /**
   * read data from the cache
   *
   * @param string $tpl_file name of template file
   * @param string $cache_id name of cache_id
   * @param string $compile_id name of compile_id
   * @return boolean|string
   */
	private function _read($tpl_file = null, $cache_id=null, $compile_id=null)
	{
		if( $tpl_file===null )
			return false;
		$id = $this->_get_id($tpl_file, $cache_id, $compile_id);
		if(isset($this->data[$id]))
			return $this->data[$id];
		
		$sql = "SELECT * FROM ".$this->_config['cache_pref'].$this->cachename;
		$sql.= " WHERE id='".addslashes($id)."'";
		$res = $this->_db->query($sql, null, true);
		if($res == false)
		{
			if($this->_db->errno)
			{
				$err = $this->_db->error;
				if($this->_db->errno == 1146)
					if( $this->_create_table() )
						return $this->_read($tpl_file, $cache_id, $compile_id);
				$this->smarty_obj->trigger_error("cache error: Incorrect query: ".$err." Query: ".$sql);
//			error_log(strtoupper(self::$Name).": read cache error. (".$err." IN query ".$sql.")");
			}
			return false;
		}
		if($row = $res->fetch_assoc())
//			if( $row['template'] == $tpl_file && $row['cacheid'] == ($cache_id?$cache_id."|":"") && $row['compileid'] == ($compile_id?$compile_id."|":"") )
		{
			# if template expired return false;
			if($row['expires'] < time())
				return false;
				
			if($this->use_gzip && function_exists("gzuncompress"))
				$this->data[$id] = gzuncompress($row['text']);
			else
				$this->data[$id] = $row['text'];
			return $this->data[$id];
		}
		return false;
	}
	
  /**
   * write data to the cache
   *
   * @param string $cache_content container for cached data
   * @param string $tpl_file name of template file
   * @param string $cache_id name of cache_id
   * @param string $compile_id name of compile_id
   * @param string $expire expiration time
   * @return boolean
   */
	private function _write(&$cache_content, $tpl_file = null, $cache_id=null, $compile_id=null, $expire)
	{
		if( $tpl_file===null )
			return false;
		$id = $this->_get_id($tpl_file, $cache_id, $compile_id);
		$this->data[$id] = $cache_content;
		
		$sql = "REPLACE INTO ".$this->_config['cache_pref'].$this->cachename." SET";
		$sql.= " id='".addslashes($id)."',";
		$sql.= " expires='".$expire."',";
		$sql.= " template='".addslashes($tpl_file)."',";
		$sql.= " cacheid='".addslashes($cache_id?$cache_id."|":"")."',";
		$sql.= " compileid='".addslashes($compile_id?$compile_id."|":"")."',";
		if($this->use_gzip && function_exists("gzcompress"))
			$sql.= " text='".addslashes(gzcompress($cache_content, $this->gzip_level))."'";
		else
			$sql.= " text='".addslashes($cache_content)."'";
		$res = $this->_db->query($sql, null, true);
		if($res == false)
		{
			if($this->_db->errno)
			{
				$err = $this->_db->error;
				if($this->_db->errno == 1146)
					if( $this->_create_table() )
						return $this->_write($cache_content, $tpl_file, $cache_id, $compile_id);
				$this->smarty_obj->trigger_error("cache error: Incorrect query: ".$err." Query: ".$sql);
//			error_log(strtoupper(self::$Name).": write cache error. (".$err." IN query ".$sql.")");
			}
			return false;
		}
		return true;
	}
	
  /**
   * clear cache (delete some cached data)
   *
   * @param string $tpl_file name of template file
   * @param string $cache_id name of cache_id
   * @param string $compile_id name of compile_id
   * @return boolean
   */
	private function _clear($tpl_file = null, $cache_id=null, $compile_id=null)
	{
		$sql = "DELETE FROM ".$this->_config['cache_pref'].$this->cachename;
		list($sqlt, $where) = Data::SQLAddCond();
		if( $tpl_file !== null )
		{
			list($sqlt, $where) = Data::SQLAddCond($sqlt, $where);
			$sqlt.= " template = '".addslashes($tpl_file)."'";
		}
		if( $cache_id !== null )
		{
			list($sqlt, $where) = Data::SQLAddCond($sqlt, $where);
			$sqlt.= " cacheid LIKE '".addslashes($cache_id?$cache_id."|":"")."%'";
		}
		if( $compile_id !== null )
		{
			list($sqlt, $where) = Data::SQLAddCond($sqlt, $where);
			$sqlt.= " compileid LIKE '".addslashes($compile_id?$compile_id."|":"")."%'";
		}
		$sql.= $sqlt;
		$res = $this->_db->query($sql, null, true);
		if($res == false)
		{
			if($this->_db->errno)
			{
				$err = $this->_db->error;
				$this->smarty_obj->trigger_error("cache error: Incorrect query: ".$err." Query: ".$sql);
//			error_log(strtoupper(self::$Name).": clear cache error. (".$err." IN query ".$sql.")");
			}
			return false;
		}
		return true;
	}
	
}

?>