<?php

/**
 * Различные утилиты
 */
class PUtil
{
	public static function GetObjectsToModerate($ObjectType, $offset = 0, $limit = 0) {
		$sql = "SELECT * FROM ".PUsersMgr::$tables['object_changements'];
		$sql.= " WHERE `ObjectType` = ".$ObjectType;
		$sql.= " AND `ToModerate` = 1 ";

		if ($limit > 0) {
			if ($offset > 0)
				$sql.= " LIMIT ".(int) $offset.','.(int) $limit;
			else
				$sql.= " LIMIT ".(int) $limit;
		}

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return array();

		$list = array();
		while(false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		return $list;
	}

	public static function RefreshStatusObjectsToModerate() {
		$sql = "UPDATE ".PUsersMgr::$tables['object_changements']." SET ";
		$sql.= " `ToModerate` = 1 ";
		$sql.= " WHERE `DateDelayed` <= NOW()";

		return PUsersMgr::$db->query($sql);
	}

	public static function RemoveObjectToModerate($ObjectType, $ObjectID) {
		$sql = "DELETE FROM ".PUsersMgr::$tables['object_changements'];
		$sql.= " WHERE `ObjectType` = ".(int) $ObjectType;
		$sql.= " AND `ObjectID` = ".(int) $ObjectID;

		return PUsersMgr::$db->query($sql);
	}

	public static function UpdateObjectToModerate($ObjectType, $ObjectID, $Delay, $BadFields = '') {

		if (!in_array($Delay, array('D','M','W')))
			return false;

		$sql = "UPDATE ".PUsersMgr::$tables['object_changements']." SET ";
		$sql.= " `DelayCount` = `DelayCount`+1 ";
		$sql.= " ,`ToModerate` = 0 ";
		$sql.= " ,`BadFields` = '".addslashes($BadFields)."'";

		if ($Delay == 'D')
			$sql.= " ,`DateDelayed` = DATE_ADD(NOW(),INTERVAL 1 DAY) ";
		else if ($Delay == 'M')
			$sql.= " ,`DateDelayed` = DATE_ADD(NOW(),INTERVAL 1 MONTH) ";
		else if ($Delay == 'W')
			$sql.= " ,`DateDelayed` = DATE_ADD(NOW(),INTERVAL 1 WEEK) ";

		$sql.= " WHERE `ObjectType` = ".(int) $ObjectType;
		$sql.= " AND `ObjectID` = ".(int) $ObjectID;

		return PUsersMgr::$db->query($sql);
	}

	/**
	 * Чистка сессий пользователей
	 */
	public function ClearSessions()
	{	
		$redis = LibFactory::GetInstance('redis');
		$redis->Init('sessions');
	
		$keys = $redis->Keys('sids_*');
		foreach($keys as $key) {
			
			$members = $redis->sMembers($key);
			if (!is_array($members) || !sizeof($members))
				continue ;
			
			$mlist = array();
			foreach($members as $k => $v) {
				$mlist[$k] = 's_'.$v;
			}
			
			$mlist = $redis->MGet($mlist);
			if (!is_array($mlist))
				continue ;

			foreach($mlist as $k => $v) {
				if ($v != false)
					continue ;
					
				$redis->sRem($key, $members[$k]);
			}
		}
	}
	
	function GenerateRandomString($len)
	{
		$str = '';
		for($i = 1; $i <= $len; $i++)
		{
			$r = round(rand(0,61)) + 48;
			if($r > 57) $r = $r + 7;
			if($r > 90) $r += 6;
			$str .= chr($r);
		}
		return $str;
	}
	
	function NickName2Latin($nickname) {		
		
		$nickname = str_replace(array('А','В','Е','К','М','Н','О','Р','С','Т','Х','а','е','о','р','с','у','х'), // русские
						   array('A','B','E','K','M','H','O','P','C','T','X','a','e','o','p','c','y','x'), // латинские
						   $nickname);
		$nickname = strtolower($nickname);
		return $nickname;
	}

	public function ClearActivationCode()
	{
		$sql = "DELETE u, a FROM ".PUsersMgr::$tables["users"]." as u, ";
		$sql.= " ".PUsersMgr::$tables["email_activation"]." as a ";
		$sql.= " WHERE u.`UserID` = a.`UserID`";
		$sql.= " AND a.`Action` = 1";
		$sql.= " AND a.`Date` <= DATE_SUB(NOW(), INTERVAL 2 DAY)";
		PUsersMgr::$db->query($sql);
		
		$sql = "DELETE FROM ".PUsersMgr::$tables["email_activation"];
		$sql.= " WHERE `Action` = 2";
		$sql.= " AND `Date` <= DATE_SUB(NOW(), INTERVAL 2 DAY)";
		PUsersMgr::$db->query($sql);
	}
	
	public function ClearForgotCode()
	{
		$sql = "DELETE FROM ".PUsersMgr::$tables['forgot_codes'];
		$sql.= " WHERE `Valid` < NOW() ";
	
		PUsersMgr::$db->query($sql);
	}

}
