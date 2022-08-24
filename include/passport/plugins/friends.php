<?php

class PFriendsPassportPlugin extends PABasePassportPlugin
{
	public $scripts = array(
			'/_scripts/themes/frameworks/jquery/jquery.js',
			'/_scripts/themes/frameworks/jquery/jquery.mousewheel.js',
			'/_scripts/themes/frameworks/jquery/nyromodal/jquery.nyromodal-1.5.5.js',
			'/_scripts/modules/passport/friends.js',
		);

	public $styles = array(
		'/_styles/modules/passport/im_nyromodal.css',
	);

	public function __construct($user, $mgr) 
	{
		parent::__construct($user, $mgr, 'Friends');
	}
	
	/**
	 * Добавить в друзья
	 *
	 * @param int $FriendID
	 * @param string $Text - текст приглашения
	 */
	public function AddFriend($FriendID, $Text = '')
	{
		global $OBJECTS;

		if ( $this->user->IsAuth() === false )
			return false;

		if (!is_numeric($FriendID) || $FriendID <= 0)
			return false;

		$sql = "SELECT Approved FROM ".PUsersMgr::$tables['friends'];
		$sql.= " WHERE UserID=".$this->user->ID;
		$sql.= " AND FriendID=".$FriendID;
		$res = PUsersMgr::$db->query($sql);

		$date = date('Y-m-d H:i:s');
		// записи нет, приглашаем пользователя в друзья
		if ($res->num_rows == 0)
		{
			//Пользователю FriendID ставиться приглашение в друзья от текущего пользователя
			$sql = "INSERT INTO ".PUsersMgr::$tables['friends']." SET";
			$sql.= " UserID=".$FriendID;
			$sql.= ", FriendID=".$this->user->ID;
			$sql.= ", Approved=0";
			$sql.= ", Invited='".$date."'";
			PUsersMgr::$db->query($sql);

			//Текущий пользователь уже является другом FriendID
			$sql = "INSERT INTO ".PUsersMgr::$tables['friends']." SET";
			$sql.= " UserID=".$this->user->ID;
			$sql.= ", FriendID=".$FriendID;
			$sql.= ", Approved=1";
			$sql.= ", Invited='".$date."'";
			$sql.= ", ApprovalDate='".$date."'";
			PUsersMgr::$db->query($sql);


			EventMgr::Raise('passport/plugins/friends/invite', array(
				'friend' => $FriendID,
				'user' => $this->user->ID,
				'event' => 'user_friend_invite'
			));
			
			//Сообщение о приглашении
			$sql = "INSERT INTO ".PUsersMgr::$tables['friends_messages']." SET";
			$sql.= " UserID=".$this->user->ID;
			$sql.= ", FriendID=".$FriendID;
			$sql.= ", Text='".addslashes($Text)."'";
			$sql.= ", Created='".$date."'";
			PUsersMgr::$db->query($sql);
			
			$OBJECTS['log']->Log(302, $FriendID, array(
				'MessageID' => PUsersMgr::$db->insert_id
			));

			$this->clearCache($FriendID);
			return;
		}

		list($Approved) = $res->fetch_row();

		if ($Approved == 0)
		{
			$sql = "UPDATE ".PUsersMgr::$tables['friends']." SET";
			$sql.= " Approved=1";
			$sql.= ", ApprovalDate='".$date."'";
			$sql.= " WHERE UserID=".$this->user->ID;
			$sql.= " AND FriendID=".$FriendID;
			PUsersMgr::$db->query($sql);

			$OBJECTS['log']->Log(302, $FriendID, array());

			$this->clearCache($this->user->ID);
		}
        		
		return;
	}

	/**
	 * Удалить из друзей
	 *
	 * @param int $FriendID
	 */
	public function RemoveFriend($FriendID)
	{
		global $OBJECTS;

		if (!is_numeric($FriendID) || $FriendID <= 0)
			return false;

		$sql = "DELETE FROM ".PUsersMgr::$tables['friends_messages'];
		$sql.= " WHERE UserID=".$FriendID;
		$sql.= " AND FriendID=".$this->user->ID;
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".PUsersMgr::$tables['friends'];
		$sql.= " WHERE UserID=".$this->user->ID;
		$sql.= " AND FriendID=".$FriendID;
		PUsersMgr::$db->query($sql);

		$sql = "DELETE FROM ".PUsersMgr::$tables['friends'];
		$sql.= " WHERE UserID=".$FriendID;
		$sql.= " AND FriendID=".$this->user->ID;
		PUsersMgr::$db->query($sql);

		$OBJECTS['log']->Log(303, $FriendID, array());

		$this->clearCache($FriendID);
	}

	/**
	 * Возвращает массив по friendid
	 * @param int $FriendID
	 * @return array - строку из базы, или null
	 */
	private function getIsFriend($FriendID)
	{
		$result = false;
		if(PUsersMgr::$cacher !== null)
		{
			$cacheid = 'plugin_friends_isfriends_'.$this->user->ID.'_'.$FriendID;
			$result = PUsersMgr::$cacher->Get($cacheid);
		}
		
        //$result = false;
		if ($result === false)
		{
			$result = array();
			$sql = "SELECT Approved FROM ".PUsersMgr::$tables['friends'];
			$sql.= " WHERE UserID=".$this->user->ID;
			$sql.= " AND FriendID=".$FriendID;

			if (($res = PUsersMgr::$db->query($sql)) !== false)
				if (($row = $res->fetch_assoc()) !== false)
					$result['Approved'] = $row['Approved'];
			
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set($cacheid, $result, 0);
		}

		if (!isset($result['Approved']))
			return null;
		return $result['Approved'];
	}
	
	/**
	 * Выполняет запрос на проверку принадлежности к списку друзей
	 *
	 * @param int $FriendID
	 * @return bool
	 */
	public function IsFriend($FriendID)
	{
		if (!is_numeric($FriendID) || $FriendID <= 0)
			return false;

		$row = $this->getIsFriend($FriendID);
		
		return $row !== null;
	}

	//заглушка
	public function IsApprovedFriend($FriendID)
	{
		$row = $this->getIsFriend($FriendID);

		return $row !== null && $row['Approved'] = 1;
	}
	
	/**
	 * Получить список друзей или приглашение (по полю Approved)
	 * 
	 * @param int $FriendID
	 * @param array $filter
	 * @return array
	 */
	public function GetFriends($FriendID, $filter = array()) 
	{
		if(!is_numeric($FriendID) || $FriendID <= 0)
			return array();

		// Если не установлен то выбираются все друзья (даже не подтвержденные)
		if ( !isset($filter['Approved']) || !is_numeric($filter['Approved']))
			$filter['Approved'] = -1;

		// Если список просматривает другой пользователь то все не подтвержденные записи о друзьях скрываются
		if ($FriendID != $this->user->ID)
			$filter['Approved'] = 1;

		if( !isset($filter['offset']) || !is_numeric($filter['offset']) )
			$filter['offset'] = 0;
		elseif( $filter['offset'] < 0 )
			$filter['offset'] = 0;

		if( !isset($filter['limit']) || !is_numeric($filter['limit']) )
			$filter['limit'] = 0;
		elseif( $filter['limit'] < 0 )
			$filter['limit'] = 0;
		
		$sql = "SELECT FriendID FROM ".PUsersMgr::$tables['friends'];
		$sql.= " WHERE UserID=".$FriendID;

		if ($filter['Approved'] != -1)
			$sql.= " AND Approved=".(int) $filter['Approved'];

		if ($filter['limit']) {
			if ($filter['offset'])
				$sql.= " LIMIT ".$filter['offset'].", ".$filter['limit'];
			else
				$sql.= " LIMIT ".$filter['limit'];
		}
		
		if (($res = PUsersMgr::$db->query($sql)) === false)
			return array();

		$friends = array();
		while( false != ($row = $res->fetch_assoc()) ) 
		{
			$friends[] = $row;
		}

		return $friends;
	}

	/**
	 * Получить количество друзей или приглашений (по полю Approved)
	 *
	 * @param int $FriendID
	 * @param array $filter
	 * @return int
	 */
	public function GetFriendsCount($FriendID, $approved = 1)
	{
		if(!is_numeric($FriendID) || $FriendID <= 0)
			return 0;
		$approved = intval($approved);
		if ($approved !== 0 && $approved !== 1)
			return 0;
		
		$result = false;
		if(PUsersMgr::$cacher !== null) 
		{
			$cacheid = 'plugin_friends_getfriendscount_'.$FriendID.'_'.$approved;
			$result = PUsersMgr::$cacher->Get($cacheid);
		}
		//$result = false;
		if ($result === false) 
		{
			$sql = "SELECT COUNT(*) FROM ".PUsersMgr::$tables['friends']." WHERE ";
			$sql.= " UserID=".$FriendID;
			$sql.= " AND Approved=".$approved;
			
			if (false != ($res = PUsersMgr::$db->query($sql))) 
			{
				list($result) = $res->fetch_row();

				if(PUsersMgr::$cacher !== null)
					PUsersMgr::$cacher->Set($cacheid, array($result), 0);
			}
		} 
		else
		{
			$result = $result[0];
		}

		return $result;
	}
	
	public function GetFriendMessage($UserID)
	{
		if (!is_numeric($UserID) || $UserID <= 0)
			return false;

		$sql = "SELECT Text, Created FROM ".PUsersMgr::$tables['friends_messages'];
		$sql.= " WHERE UserID=".$UserID;
		$sql.= " AND FriendID=".$this->user->ID;
		$sql.= " AND Text!=''";

		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		return $res->fetch_assoc();
	}

	public function AddResponse()
	{
		global $OBJECTS;

		$OBJECTS['title']->AddScripts($this->scripts);
		$OBJECTS['title']->AddStyles($this->styles);
	}

	public function GetInviteJS($params)
	{
		return "mod_passport_friends_loader.load(".intval($params['UserID']).");";
	}

	public function GetActionJS($params)
	{
		return "mod_passport_friends_loader.".$params['action']."(".intval($params['UserID']).");";
	}

	/**
	 * Чистка кеша для связи друзей
	 *
	 * @param <type> $FriendID
	 * @return <type>
	 */
	private function clearCache($FriendID)
	{
		if(PUsersMgr::$cacher === null)
			return;
       
		PUsersMgr::$cacher->Remove('plugin_friends_isfriends_'.$this->user->ID.'_'.$FriendID);
		PUsersMgr::$cacher->Remove('plugin_friends_getfriendscount_'.$FriendID.'_0');
		PUsersMgr::$cacher->Remove('plugin_friends_getfriendscount_'.$FriendID.'_1');
        PUsersMgr::$cacher->Remove('plugin_friends_getfriendscount_'.$this->user->ID.'_0');
        PUsersMgr::$cacher->Remove('plugin_friends_getfriendscount_'.$this->user->ID.'_1');
	}
	
}