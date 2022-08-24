<?

class RealtyStats
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
		$this->_cache->Init('memcache', 'realty');				
	}
	
	
	public function GetStatistic($prefix, $deal = null, $rubric = null, $subrubric = null, $room_count = 0, $area = 0)
	{		
		if ( $deal === null || $rubric === null || $subrubric === null )
		{
			$sql = "SELECT SUM(`Count`), SUM(`Delta`), SUM(`WeeklyCount`) FROM `". $prefix ."_statistic`";
			$sql.= " WHERE `Area` = '' AND `RoomCount` = 0";
			if ( $rubric !== null )			
				$sql.= " AND `Rubric` = '". $rubric ."'";
			if ( $subrubric !== null )			
				$sql.= " AND `Subrubric` = '". $subrubric ."'";

			$res = $this->_db->query($sql);
			if ( $res === false)
				return false;
			
			return $res->fetch_row();
		}
		
		if ( !isset($this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area]) )
		{
			$this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area] = $this->_cache->Get('daily_stats|'. $prefix ."|". $deal ."|". $rubric ."|". $subrubric ."|". $room_count ."|". $area);
			
			if ( !isset($this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area]) || $this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area] === false )
			{
				$sql = "SELECT `Count`, `Delta`, `WeeklyCount` FROM `". $prefix ."_statistic` ";
				$sql.= " WHERE `Deal` = '". $deal ."'";
				$sql.= " AND `Rubric` = '". $rubric ."'";
				$sql.= " AND `Subrubric` = '". $subrubric ."'";
				$sql.= " AND `RoomCount` = ". $room_count;
				$sql.= " AND `Area` = '". ($area != 0 ? $area : '') ."'";
				$res = $this->_db->query($sql);
				if ( $res === false)
					return false;
				
				$count = $res->fetch_row();
				
				$this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area] = $count;
				$this->_cache->Set('daily_stats|'. $prefix ."|". $deal ."|". $rubric ."|". $subrubric ."|". $room_count ."|". $area, $count, 300);
			}
		}
		
		return $this->_stats[$prefix][$deal][$rubric][$subrubric][$room_count][$area];
	}
	
}
?>
