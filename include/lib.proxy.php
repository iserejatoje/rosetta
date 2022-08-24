<?

class Lib_Proxy
{
	private $_db = null;
	private $_config = array(
		'tables' => array(
			'proxy' => 'proxy',
		),
	);

	private $_list = array();

	private $_last_check = 0;

	private $_last_i = 0;

	function Init()
	{
		$this->_db = DBFactory::GetInstance('public');
	}

	/**
	* Add proxy server to the DB
	*/
	public function Add($var)
	{
		if(!is_array($var))
			return false;
		if(isset($var['proxy']))
		{
			$arr = $var;
			$var = array();
			$var[$arr] = $arr;
			unset($arr);
		}
		
		if(sizeof($var)==0)
			return true;
		
		$sql = "SELECT proxy FROM ".$this->_config['tables']['proxy'];
		$sqlt = array();
		foreach($var as $i)
		{
			if(empty($i['proxy']))
				continue;
			$sqlt[] = "'".addslashes($i['proxy'])."'";
		}
		if(sizeof($sqlt))
		{
			$sql.= " WHERE proxy IN (".implode(",", $sqlt).")";
			$res = $this->_db->query($sql);
			while($row = $res->fetch_assoc())
				if(isset($var[$row['proxy']]))
					unset($var[$row['proxy']]);
		}

		$sql = "INSERT INTO ".$this->_config['tables']['proxy']." (proxy, contime, time, speed, post, referer, cookies, anon, country, code_country, date_add, date_check, uptime) VALUES ";
		$sqlt = array();
		foreach($var as $i)
		{
			if(empty($i['proxy']))
				continue;
			$sqlt[$i['proxy']] = "(";
			$sqlt[$i['proxy']].= "'".addslashes($i['proxy'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['contime'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['time'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['speed'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['post'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['referer'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['cookies'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['anon'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['country'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['code_country'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['date_add'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['date_check'])."',";
			$sqlt[$i['proxy']].= "'".addslashes($i['uptime'])."'";
			$sqlt[$i['proxy']].= ")";
		}
		if(sizeof($sqlt))
		{
			$sql.= implode(",", $sqlt);
			$this->_db->query($sql);
		}
		return true;
	}

	/**
	* Remove all proxies from the DB
	*/
	public function Truncate()
	{
		$this->_db->query("TRUNCATE ".$this->_config['tables']['proxy']);
		return true;
	}

	/**
	* Remove proxy from the DB
	*/
	public function Remove($var)
	{
		if(!is_array($var))
		{
			$arr = $var;
			$var = array();
			$var[$arr] = $arr;
			unset($arr);
		}
		
		if(sizeof($var)==0)
			return true;
		
		$sql = "DELETE FROM ".$this->_config['tables']['proxy'];
		$sqlt = array();
		foreach($var as $i)
		{
			if(empty($i))
				continue;
			$sqlt[] = "'".addslashes($i)."'";
		}
		if(sizeof($sqlt))
		{
			$sql.= " WHERE proxy IN (".implode(",", $sqlt).")";
			$this->_db->query($sql);
		}
		return true;
	}

	/**
	* Delete Proxy from cache array and from DB
	*/
	public function Bad($var)
	{
		if(!is_array($var))
		{
			$arr = $var;
			$var = array();
			$var[$arr] = $arr;
			unset($arr);
		}
		
		if(sizeof($var)==0)
			return true;
		
		foreach($var as $i)
		{
			if(empty($i))
				continue;
			if($res>=$this->_last_i)
				$this->_last_i--;
			unset($this->_list[$i]);
		}
		$this->Remove($var);
		return true;
	}

	/**
	* Get proxy
	*/
	public function GetProxy()
	{
		if( (time()-300) > $this->_last_check )
			$this->_GetProxyFromDB();
		
		if(sizeof($this->_list)==0)
			return false;
		
		$this->_last_i++;
		if($this->_last_i >= sizeof($this->_list))
			$this->_last_i = 0;
		$arr = array_slice($this->_list, $this->_last_i, 1);
		return array_pop($arr);
	}

	/**
	* Get proxy from DB
	*/
	private function _GetProxyFromDB()
	{
		$this->_list = array();

		$sql = "SELECT proxy FROM ".$this->_config['tables']['proxy'];
		$sql.= " ORDER BY speed DESC, time ASC, contime ASC, date_check DESC LIMIT 100";
		$res = $this->_db->query($sql);
		while($row = $res->fetch_assoc())
			$this->_list[$row['proxy']] = $row['proxy'];
		$this->_last_check = time();
		$this->_last_i = -1;
	}

	/**
	* Get proxy list from DB
	*/
	public function GetProxyList()
	{
		$list = array();
		$sql = "SELECT * FROM ".$this->_config['tables']['proxy'];
		$res = $this->_db->query($sql);
		while($row = $res->fetch_assoc())
			$list[] = $row;
		return $list;
	}

}

