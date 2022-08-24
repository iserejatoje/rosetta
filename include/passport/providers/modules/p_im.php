<?php

class PProfile_modules_im extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('messagesortord','messagesortfield', 'messagefilter'
			);
	}
	
	public function Load()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_moduleim_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_module_im'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'messagesortord' => 'd',
					'messagesortfield' => 'created',
					'messagefilter' => 0
				);
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_moduleim_'.$this->user->ID, $this->profile, 3600);
		}
	}
	
	public function Save()
	{
		if(!is_a($this->user, 'PUser') && $this->user->ID <= 0)
			return;
			
		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_moduleim_'.$this->user->ID);

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_module_im']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,MessageSortOrd = '".addslashes($this->profile['messagesortord'])."'";
		$sql.= " ,MessageSortField = '".addslashes($this->profile['messagesortfield'])."'";
		$sql.= " ,MessageFilter = '".addslashes($this->profile['messagefilter'])."'";

		PUsersMgr::$db->query($sql);
	}
}
