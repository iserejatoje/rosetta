<?php

class PProfile_themes_talk extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('signature','signaturecommerce', 'smileoff','imageoff','avataroff','imnotify','status','friendinvite',
			'communityinvite','userphotocomment','userinterestadd','userplaceadd',
			'useraddressadd','communityupdate','userupdate');
		$this->custom_fields = array('sendactions','newsfilter', 'periods', 'showsignature');
	}

	public function Load()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_themetalk_'.$this->user->ID);
		else
			$this->profile = false;

		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_theme_talk'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'signature' => '',
					'signaturecommerce' => '',
					'smileoff' => 0,
					'imageoff' => 0,
					'avataroff' => 0,
					'imnotify' => 1,
					'status' => '',
					'friendinvite' => 1440,
					'communityinvite' => 1440,
					'userphotocomment' => 60,
					'userinterestadd' => 10080,//1440,
					'userplaceadd' => 10080,//1440,
					'useraddressadd' => 10080,
					'communityupdate' => 10080,//1440,
					'userupdate' => 10080,
					'newsfilter' => '',
				);
			}

			if (PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_themetalk_'.$this->user->ID, $this->profile, 3600);
		}

	}

	public function Save()
	{
		if(!is_a($this->user, 'PUser') && $this->user->ID <= 0)
			return;

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_theme_talk']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,Signature = '".addslashes($this->profile['signature'])."'";
		$sql.= " ,SignatureCommerce = '".addslashes($this->profile['signaturecommerce'])."'";
		$sql.= " ,SmileOff = ".(int) $this->profile['smileoff'];
		$sql.= " ,ImageOff = ".(int) $this->profile['imageoff'];
		$sql.= " ,AvatarOff = ".(int) $this->profile['avataroff'];
		$sql.= " ,ImNotify = ".(int) $this->profile['imnotify'];
		$sql.= " ,`Status` = '".addslashes($this->profile['status'])."'";
		$sql.= " ,FriendInvite = ".(int)$this->profile['friendinvite'];
		$sql.= " ,CommunityInvite = ".(int) $this->profile['communityinvite'];
		$sql.= " ,UserPhotoComment = ".(int) $this->profile['userphotocomment'];
		$sql.= " ,UserInterestAdd = ".(int) $this->profile['userinterestadd'];
		$sql.= " ,UserPlaceAdd = ".(int) $this->profile['userplaceadd'];
		$sql.= " ,UserAddressAdd = ".(int) $this->profile['useraddressadd'];
		$sql.= " ,CommunityUpdate = ".(int) $this->profile['communityupdate'];
		$sql.= " ,UserUpdate = ".(int) $this->profile['userupdate'];
		$sql.= " ,NewsFilter = '".addslashes($this->profile['logoutcleartrash'])."'";

		PUsersMgr::$db->query($sql);
		
		if (PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_themetalk_'.$this->user->ID);
	}

	private $_send_actions = null;
	public function CustomSet($offset, $value)
	{
		switch($offset)
		{
			// множество фильтр новостей пользователя
			case 'newsfilter':
				if(is_array($value))
					$value = implode(',',$value);
				if(is_string($value))
					$this->profile['newsfilter'] = $value;
				break;
			case 'sendactions':
				$acts = $this->CustomGet($offset);
				$ids = implode(',',array_keys($acts));
				foreach($acts as $act => $moment)
				{
					$sql = "REPLACE INTO ".PUsersMgr::$tables['log_time_sent'];
					$sql.= " SET UserID = ".$this->user->ID;
					$sql.= " ,ActionID = ".(int) $act;
					$sql.= " ,Moment = '".strftime('%Y-%m-%d %H:%M:%S', $value)."'";

					PUsersMgr::$db->query($sql);
				}
				break;
		}
	}

	public function CustomGet($offset)
	{
		switch($offset)
		{
			case 'showsignature':
				if (trim($this->profile['signaturecommerce']) != '')
					return $this->profile['signaturecommerce'];

				return $this->profile['signature'];
			break;
			// множество фильтр новостей пользователя
			case 'newsfilter':
				if(strlen(trim($this->profile['newsfilter'])) == 0)
					return array();
				else
					return explode(',', $this->profile['newsfilter']);
			case 'periods':
				$periods = array();
				$periods[1] 																= $this->profile['imnotify'];
				$periods[2] = $periods[22]													= $this->profile['userinterestadd'];
				$periods[3] = $periods[4] = $periods[5] 									= $this->profile['userplaceadd'];
				$periods[6] 																= $this->profile['useraddressadd'];
				$periods[7] = $periods[8] = $periods[9] = $periods[10] = $periods[11] = $periods[12] = $periods[20] = $periods[24]
																							= $this->profile['communityupdate'];
				$periods[13] = $periods[14] = $periods[15] = $periods[16] = $periods[17] = $periods[18] = $periods[23]
																							= $this->profile['userupdate'];
				$periods[19] 																= $this->profile['friendinvite'];
				$periods[20] 																= $this->profile['communityinvite'];
				$periods[21] 																= $this->profile['userphotocomment'];
				return $periods;
			// информация по отправеленным действиям
			case 'sendactions':
				if($this->_send_actions === null)
				{
					$this->_send_actions = array();

					$sql = "SELECT * FROM ".PUsersMgr::$tables['log_time_sent'];
					$sql.= " WHERE UserID = ".$this->user->ID;

					$res = PUsersMgr::$db->query($sql);
					while (false != ($row = $res->fetch_assoc())) {
						$sa[$row['ActionID']] = $row['Moment'];
					}

					$tn = time();
					for($a = 1; $a <= 24; $a++)
					{
						if(isset($sa[$a]))
						{
							$tm = strtotime($sa[$a]);

							// добавляем только в случае, если прошедшее время с момента последний отправки больше периода
							if(
								($a == 1 &&
									$this->profile['imnotify'] != 0 &&
									$this->profile['imnotify']*60 < $tn-$tm) ||
								(($a == 2 || $a == 22 || $a == 23) &&
									$this->profile['userinterestadd'] != 0 &&
									$this->profile['userinterestadd']*60 < $tn-$tm) ||
								($a >= 3 && $a <= 5 &&
									$this->profile['userplaceadd'] != 0 &&
									$this->profile['userplaceadd']*60 < $tn-$tm) ||
								($a == 6 &&
									$this->profile['useraddressadd'] != 0 &&
									$this->profile['useraddressadd']*60 < $tn-$tm) ||
								((($a >= 7 && $a <= 12) || $a == 20 || $a == 24) &&
									$this->profile['communityupdate'] != 0 &&
									$this->profile['communityupdate']*60 < $tn-$tm) ||
								((($a >= 13 && $a <= 18) || $a == 23) &&
									$this->profile['userupdate'] != 0 &&
									$this->profile['userupdate']*60 < $tn-$tm) ||
								($a == 19 &&
									$this->profile['friendinvite'] != 0 &&
									$this->profile['friendinvite']*60 < $tn-$tm) ||
								($a == 20 &&
									$this->profile['communityinvite'] != 0 &&
									$this->profile['communityinvite']*60 < $tn-$tm) ||
								($a == 21 &&
									$this->profile['userphotocomment'] != 0 &&
									$this->profile['userphotocomment']*60 < $tn-$tm)
								)
							$this->_send_actions[$a] = $tm;
						}
						else
						{
							if(
								($a == 1 && 							$this->profile['imnotify'] != 0) ||
								(($a == 2 || $a == 22 || $a == 23) &&	$this->profile['userinterestadd'] != 0) ||
								($a >= 3 && $a <= 5 && 					$this->profile['userplaceadd'] != 0) ||
								($a == 6 && 							$this->profile['useraddressadd'] != 0) ||
								((($a>=7 && $a<=12) || $a==20 || $a==24) && $this->profile['communityupdate'] != 0) ||
								((($a >= 13 && $a <= 18) || $a==23) &&	$this->profile['userupdate'] != 0) ||
								($a == 19 && 							$this->profile['friendinvite'] != 0) ||
								($a == 20 && 							$this->profile['communityinvite'] != 0) ||
								($a == 21 && 							$this->profile['userphotocomment'] != 0)
								)
							$this->_send_actions[$a] = 0; // не отправляли ранее, отправляем однозначно
						}
					}
				}
				return $this->_send_actions;
		}
	}
}
