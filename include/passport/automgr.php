<?php

/**
 * Управление автомобилями пользователей
 */
class PAutoMgr
{
	public static $db;
	
	function __construct()
	{
	}
	
	static function &getInstance () 
	{
        static $instance;
        if ( !isset($instance))
		{
            $cl = __CLASS__;
            $instance = new $cl();
        }
        return $instance;
    }
	
	public static function GetAutoUsers($filter)
	{
		$sql = "SELECT DISTINCT u.`UserID` FROM `".PUsersMgr::$tables['profile_auto']."` u";
		$sql.= ' INNER JOIN '.PUsersMgr::$tables['users'].' as us ON(us.`UserID` = u.`UserID`) ';
		$where = " WHERE us.`IsDel` = 0 ";
		
		// анкета
		if ( is_array($filter['anketa']) )
		{
			if ( isset($filter['anketa']['DrivingStyle']) && (int) $filter['anketa']['DrivingStyle'] > 0 )
				$where.= " AND  u.`DrivingStyle` = " . intval($filter['anketa']['DrivingStyle']);
			if ( isset($filter['anketa']['Tuning']) && (int) $filter['anketa']['Tuning'] > 0 )
				$where.= " AND  u.`Tuning` = " . intval($filter['anketa']['Tuning']);
			if ( isset($filter['anketa']['RightWheel']) && (int) $filter['anketa']['RightWheel'] > 0 )
				$where.= " AND  u.`RightWheel` = " . intval($filter['anketa']['RightWheel']);
			
			if ( isset($filter['anketa']['AutoSport']) && (int) $filter['anketa']['AutoSport'] > 0 )
				$where.= " AND  u.`AutoSport` & " . intval($filter['anketa']['AutoSport']) . " > 0";
			if ( isset($filter['anketa']['AutoThemes']) && (int) $filter['anketa']['AutoThemes'] > 0 )
				$where.= " AND  u.`AutoThemes` & " . intval($filter['anketa']['AutoThemes']) . " > 0";
			if ( isset($filter['anketa']['Expert']) && (int) $filter['anketa']['Expert'] > 0 )
				$where.= " AND  u.`Expert` & " . intval($filter['anketa']['Expert']) . " > 0";
			
			if ( isset($filter['anketa']['ExpertOther']) && !empty($filter['anketa']['ExpertOther']) )
				$where.= " AND  u.`ExpertOther` LIKE '" . addslashes($filter['anketa']['ExpertOther']) ."%'";
			if ( isset($filter['anketa']['regionid']) && is_numeric($filter['anketa']['regionid']) )
				$where.= " AND  u.`RegionID` = " . (int) $filter['anketa']['regionid'];
		}
		
		// основные поля авто
		$cwhere = '';
		if ( isset($filter['marka']) && (int) $filter['marka'] > 0 )
			$cwhere.= " AND c.`MarkaID` = " . intval($filter['marka']);
		if ( isset($filter['model']) && (int) $filter['model'] > 0 )
			$cwhere.= " AND c.`ModelID` = " . intval($filter['model']);
		if ( isset($filter['wheeltype']) && (int) $filter['wheeltype'] >= 0 && $filter['wheeltype'] < 3 )
			$cwhere.= " AND c.`WheelType` = " . intval($filter['wheeltype']);
		if ( isset($filter['volume_min']) && (int) $filter['volume_min'] > 0 )
			$cwhere.= " AND c.`Volume` >= " . intval($filter['volume_min']);
		if ( isset($filter['volume_max']) && (int) $filter['volume_max'] > 0 )
			$cwhere.= " AND c.`Volume` <= ".$filter['volume_max'];
		if ( isset($filter['year_min']) && (int) $filter['year_min'] > 0 )
			$cwhere.= " AND c.`Year` >= " . intval($filter['year_min']);
		if ( isset($filter['year_max']) && (int) $filter['year_max'] > 0 )
			$cwhere.= " AND c.`Year` <= " . intval($filter['year_max']);
		if ( isset($filter['photo']) && (int) $filter['photo'] == 1 )
			$cwhere.= " AND c.`LargePhoto` != ''";
		if ( isset($filter['regionid']) && is_numeric($filter['regionid']) )
			$cwhere.= " AND c.`RegionID` = ".(int) $filter['regionid'];
		
		if ( $cwhere != '' ) {
			// основные поля
			$sql = "SELECT c.UserID FROM `".PUsersMgr::$tables['profile_auto_cars']."` c";
			$sql.= ' INNER JOIN '.PUsersMgr::$tables['users'].' as us ON(us.`UserID` = c.`UserID`) ';
			$where = " WHERE us.`IsDel` = 0 ";
			//$sql.= " INNER JOIN `profile_auto_cars` c ON u.UserID = c.UserID";
		}
				
		$sql.= $where.$cwhere;
		
		if ( !isset($filter['offset']) || !is_numeric($filter['offset']) )
			$filter['offset'] = 0;
		if ( $filter['offset'] < 0) $filter['offset'] = 0;
		
		if ( !isset($filter['limit']) || !is_numeric($filter['limit']) )
			$filter['limit'] = 0;
		
		if ( $filter['offset'] > 0 || $filter['limit'] > 0 )
		{
			$sql.= " LIMIT ";
			if ( $filter['offset'] > 0 )
				$sql.= $filter['offset'].", ";
			if ( $filter['limit'] > 0 )
				$sql.= $filter['limit'];
		}		
		
		$ids = array();
		$res = PUsersMgr::$db->query($sql);		
		while ( list($id) = $res->fetch_row() ) {
			$ids[] = array( 'UserID' => $id );
		}
		
		return $ids;
	}

	public static function GetAutoUsersCount($filter)
	{
		// основные поля
		$sql = "SELECT count(DISTINCT u.`UserID`) FROM `".PUsersMgr::$tables['profile_auto']."` u";
		$sql.= ' INNER JOIN '.PUsersMgr::$tables['users'].' as us ON(us.`UserID` = u.`UserID`) ';
		$where = " WHERE us.`IsDel` = 0 ";
		
		// анкета
		if ( is_array($filter['anketa']) )
		{
			if ( isset($filter['anketa']['DrivingStyle']) && (int) $filter['anketa']['DrivingStyle'] > 0 )
				$where.= " AND  u.`DrivingStyle` = " . intval($filter['anketa']['DrivingStyle']);
			if ( isset($filter['anketa']['Tuning']) && (int) $filter['anketa']['Tuning'] > 0 )
				$where.= " AND  u.`Tuning` = " . intval($filter['anketa']['Tuning']);
			if ( isset($filter['anketa']['RightWheel']) && (int) $filter['anketa']['RightWheel'] > 0 )
				$where.= " AND  u.`RightWheel` = " . intval($filter['anketa']['RightWheel']);
			
			if ( isset($filter['anketa']['AutoSport']) && (int) $filter['anketa']['AutoSport'] > 0 )
				$where.= " AND  u.`AutoSport` & " . intval($filter['anketa']['AutoSport']) . " > 0";
			if ( isset($filter['anketa']['AutoThemes']) && (int) $filter['anketa']['AutoThemes'] > 0 )
				$where.= " AND  u.`AutoThemes` & " . intval($filter['anketa']['AutoThemes']) . " > 0";
			if ( isset($filter['anketa']['Expert']) && (int) $filter['anketa']['Expert'] > 0 )
				$where.= " AND  u.`Expert` & " . intval($filter['anketa']['Expert']) . " > 0";
			
			if ( isset($filter['anketa']['ExpertOther']) && !empty($filter['anketa']['ExpertOther']) )
				$where.= " AND  u.`ExpertOther` LIKE '" . addslashes($filter['anketa']['ExpertOther']) ."%'";
				
			if ( isset($filter['anketa']['regionid']) && is_numeric($filter['anketa']['regionid']) )
				$where.= " AND  u.`RegionID` = " . (int) $filter['anketa']['regionid'];
		}
		
		// основные поля авто
		$cwhere = '';
		if ( isset($filter['marka']) && (int) $filter['marka'] > 0 )
			$cwhere.= " AND c.`MarkaID` = " . intval($filter['marka']);
		if ( isset($filter['model']) && (int) $filter['model'] > 0 )
			$cwhere.= " AND c.`ModelID` = " . intval($filter['model']);
		if ( isset($filter['wheeltype']) && (int) $filter['wheeltype'] >= 0 && $filter['wheeltype'] < 3 )
			$cwhere.= " AND c.`WheelType` = " . intval($filter['wheeltype']);
		if ( isset($filter['volume_min']) && (int) $filter['volume_min'] > 0 )
			$cwhere.= " AND c.`Volume` >= " . intval($filter['volume_min']);
		if ( isset($filter['volume_max']) && (int) $filter['volume_max'] > 0 )
			$cwhere.= " AND c.`Volume` <= ".$filter['volume_max'];
		if ( isset($filter['year_min']) && (int) $filter['year_min'] > 0 )
			$cwhere.= " AND c.`Year` >= " . intval($filter['year_min']);
		if ( isset($filter['year_max']) && (int) $filter['year_max'] > 0 )
			$cwhere.= " AND c.`Year` <= " . intval($filter['year_max']);
		if ( isset($filter['photo']) && (int) $filter['photo'] == 1 )
			$cwhere.= " AND c.`LargePhoto` != ''";
		if ( isset($filter['regionid']) && is_numeric($filter['regionid']) )
			$cwhere.= " AND c.`RegionID` = ".(int) $filter['regionid'];
		
		if ( $cwhere != '' ) {
			// основные поля
			$sql = "SELECT count(*) FROM `".PUsersMgr::$tables['profile_auto_cars']."` c";
			$sql.= ' INNER JOIN '.PUsersMgr::$tables['users'].' as us ON(us.`UserID` = c.`UserID`) ';
			$where = " WHERE us.`IsDel` = 0 ";
			//$sql.= " INNER JOIN `profile_auto_cars` c ON u.UserID = c.UserID";
		}
		
		$sql.= $where.$cwhere;

		list($count) = PUsersMgr::$db->query($sql)->fetch_row();
		return $count;
	}

}
