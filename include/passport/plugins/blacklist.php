<?php
class PBlackListPassportPlugin extends PABasePassportPlugin
{
	public function __construct($user, $mgr)
	{
		parent::__construct($user, $mgr, 'BlackList');
	}
	
	public function AddToBlackList($to)
	{
		$sql = "INSERT IGNORE INTO `".PUsersMgr::$tables['messages_black_list']."` SET ";
        $sql.= " ToUserID = ".(int) $to;
		$sql.= " ,FromUserID = ".$this->user->ID;
	
		return PUsersMgr::$db->query($sql);
	}
	
	public function RemoveFromBlackList($to)
	{
		$sql = "DELETE FROM `".PUsersMgr::$tables['messages_black_list']."` WHERE ";
        $sql.= " ToUserID = ".(int) $to;
		$sql.= " AND FromUserID = ".$this->user->ID;
	
		return PUsersMgr::$db->query($sql);
	}
	
	public function GetBlackList($filter)
	{
		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		
		if($filter['offset'] < 0)
			$filter['offset'] = 0;
		
		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;
			
		$sql = "SELECT * FROM ".PUsersMgr::$tables['messages_black_list'];
        $sql.= " WHERE FromUserID = ".$this->user->ID;
		
		if ($filter['limit']) {
			if ($filter['offset'])
				$sql.= " LIMIT ".$filter['offset'].", ".$filter['limit'];
			else
				$sql.= " LIMIT ".$filter['limit'];
		}
		
		$users = array();
		if(false != ($res = PUsersMgr::$db->query($sql)))
		{		
			while(false != ($row = $res->fetch_assoc())) {
				$users[] = $row;
			}
		}
		return $users;
	}
	
	public function GetBlackListCount()
	{
		$sql = "SELECT COUNT(0) FROM ".PUsersMgr::$tables['messages_black_list'];
        $sql.= " WHERE FromUserID = ".$this->user->ID;
	
		if (false == ($res = PUsersMgr::$db->query($sql)))
			return 0;
	
		list($count) = $res->fetch_row();
		return $count;
	}
	
	public function IsInBlackList($to, $send = false)
	{
		$sql = "SELECT * FROM `".PUsersMgr::$tables['messages_black_list']."` WHERE ";
		if ($send === true)
		{
			$sql.= " ToUserID = ".$this->user->ID;
			$sql.= " AND FromUserID = ".(int) $to;
		}
		else
		{
			$sql.= " ToUserID = ".(int) $to;
			$sql.= " AND FromUserID = ".$this->user->ID;
		}
		$sql.= " LIMIT 1";
		
		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		return !($res->num_rows == 0);
	}
}
