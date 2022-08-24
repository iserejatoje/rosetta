<?php

class PProfile_modules_mail extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('signature','replyto','messagecolpp','addresscolpp','messagesortord',
  								'messagesortfield','addresssortord','addresssortfield','saveinsent','logoutcleartrash');
	}
	
	public function Load()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_modulemail_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_module_mail'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'signature' => '',
					'replyto' => '',
					'messagecolpp' => 25,
					'addresscolpp' => 25,
					'messagesortord' => 'd',
					'messagesortfield' => 'date',
					'addresssortord' => 'a',
					'addresssortfield' => 'email',
					'saveinsent' => 0,
					'logoutcleartrash' => 0
				);
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_modulemail_'.$this->user->ID, $this->profile, 3600);
		}
	}
	
	public function Save()
	{
		if(!is_a($this->user, 'PUser') && $this->user->ID <= 0)
			return;
			
		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_modulemail_'.$this->user->ID);

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_module_mail']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,Signature = '".addslashes($this->profile['signature'])."'";
		$sql.= " ,ReplyTo = '".addslashes($this->profile['replyto'])."'";
		$sql.= " ,MessageColPP = ".(int) $this->profile['messagecolpp'];
		$sql.= " ,AddressColPP = ".(int) $this->profile['addresscolpp'];
		$sql.= " ,MessageSortOrd = '".addslashes($this->profile['messagesortord'])."'";
		$sql.= " ,MessageSortField = '".addslashes($this->profile['messagesortfield'])."'";
		$sql.= " ,AddressSortOrd = '".addslashes($this->profile['addresssortord'])."'";
		$sql.= " ,AddressSortField = '".addslashes($this->profile['addresssortfield'])."'";
		$sql.= " ,SaveInSent = ".(int) $this->profile['saveinsent'];
		$sql.= " ,LogoutClearTrash = ".(int) $this->profile['logoutcleartrash'];

		PUsersMgr::$db->query($sql);
	}
}
