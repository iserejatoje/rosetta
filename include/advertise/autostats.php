<?

class AutoStats
{
	protected $_db = null;
	protected $_cache = null;
	protected $_stats = array();
	
	static function &getInstance($db) 
	{
		static $instance;
		if ( !isset($instance))
		{
			$cl = __CLASS__;
			$instance = new $cl($db);
		}
		return $instance;
	}

	public function __construct($db)
	{
		$this->_db = DBFactory::getInstance($db);
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'auto');				
	}
	
	
	public function GetStatistic($prefix, $rubric = null, $subrubric = null, $brand = 0)
	{		
		if ( $rubric === null || $subrubric === null )
		{
			$sql = "SELECT SUM(`Count`), SUM(`Delta`), SUM(`WeeklyCount`) FROM `". $prefix ."_statistic`";
			$sql.= " WHERE `BrandID` = ". $brand;
			if ( $rubric !== null )			
				$sql.= " AND `Rubric` = '". $rubric ."'";
			if ( $subrubric !== null )			
				$sql.= " AND `Subrubric` = '". $subrubric ."'";
			
			$res = $this->_db->query($sql);
			if ( $res === false)
				return false;
			
			return $res->fetch_row();
		}
		
		if ( !isset($this->_stats[$prefix][$rubric][$subrubric][$brand]) )
		{
			$this->_stats[$prefix][$rubric][$subrubric][$brand] = $this->_cache->Get('daily_stats|'. $prefix ."|". $rubric ."|". $subrubric ."|". $brand);
			
			if ( !isset($this->_stats[$prefix][$rubric][$subrubric][$brand]) || $this->_stats[$prefix][$rubric][$subrubric][$brand] === false )
			{
				$sql = "SELECT `Count`, `Delta`, `WeeklyCount` FROM `". $prefix ."_statistic` ";
				$sql.= " WHERE `Rubric` = '". $rubric ."'";
				$sql.= " AND `Subrubric` = '". $subrubric ."'";
				$sql.= " AND `BrandID` = ". $brand;
				$res = $this->_db->query($sql);
				if ( $res === false)
					return false;
				
				$count = $res->fetch_row();
				
				$this->_stats[$prefix][$rubric][$subrubric][$brand] = $count;
				$this->_cache->Set('daily_stats|'. $prefix ."|". $rubric ."|". $subrubric ."|". $brand, $count, 300);
			}
		}
		
		return $this->_stats[$prefix][$rubric][$subrubric][$brand];
	}
	
}
?>
