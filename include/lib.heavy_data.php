<?

class Heavy_Data
{
	private static $cache = null;
	
	private static function InitCache()
	{
		if(self::$cache === null)
		{
			LibFactory::GetStatic('cache');
			self::$cache = new Cache();
			self::$cache->Init('memcache', 'heavy_data');
		}
	}

	static function SetData($source,$data)
	{
		$d = serialize($data);
		$db = DBFactory::GetInstance('public');
		$sql = "INSERT INTO heavy_data SET";
		$sql.= " name='".addslashes($source)."',";
		$sql.= " value='".addslashes($d)."'";
		$sql.= " ON DUPLICATE KEY UPDATE value='".addslashes($d)."'";
		$res = $db->query($sql);
		unset($d);
		self::InitCache();
		if( is_bool($data) && $data === false )
			self::$cache->Set($source, 'false', 86400);
		else
			self::$cache->Set($source, $data, 86400);
		return (bool)$res;
	}
	
	static function GetData($source)
	{
		self::InitCache();
		$data = self::$cache->Get($source);
		if( $data === false )
		{
			$db = DBFactory::GetInstance('public');
			$sql = "SELECT value FROM heavy_data";
			$sql.= " WHERE name='".addslashes($source)."'";
			$res = $db->query($sql);
			if($res && $row = $res->fetch_assoc())
				$data = unserialize($row['value']);
			else
				$data = null;
			
			if( is_bool($data) && $data === false )
				self::$cache->Set($source, 'false', 86400);
			else
				self::$cache->Set($source, $data, 86400);
		}
		if( is_string($data) && $data === 'false' )
			$data = false;
		return $data;
	}
}

?>
