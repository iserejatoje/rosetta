<?

class Lib_Dpsearch
{
	static $Name = 'dpsearch';
	private $_db				 = null;
	
	function __construct()
	{
	}
	
	function __destruct()
	{
	}
	
	function Init($region = null)
	{
		global $CONFIG, $LCONFIG;
		
		return false;
		
//		LibFactory::GetConfig(self::$Name);
//		$this->_config = $LCONFIG[self::$Name];
		$this->_config['tbl_immediate_index'] = "search_immediate_index";
//error_log('DPSEARCH: INIT1'.$region);
		switch($region)
		{
//			case 63:
//				$this->_config['db'] = "dpsearch63";
//				break;
//			case 59:
//				$this->_config['db'] = "dpsearch59";
//				break;
			case 74:
				$this->_config['db'] = "dpsearch";
				break;
			default:
				$this->_config['db'] = "dpsearch_rugion";
		}
//error_log('DPSEARCH: INIT2'.$region);
		$this->_db = DBFactory::GetInstance($this->_config['db']);
		$this->_db->query("SET NAMES cp1251");
	}
	
	public function add_in_queue($url = "")
	{
		return true;
		
//error_log('DPSEARCH: METHOD1'.$url);
		if($this->_db === null)
			return false;
//error_log('DPSEARCH: METHOD2'.$url);
		
		if($url == "")
			return false;
//error_log('DPSEARCH: METHOD3'.$url);
		
		$sql="INSERT INTO ".$this->_config["tbl_immediate_index"]." SET url='".addslashes($url)."'";
		$this->_db->query($sql);

		return true;
	}
	
}

?>
