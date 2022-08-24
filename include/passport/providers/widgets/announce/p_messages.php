<?php

class PProfile_widgets_announce_messages extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('isvisible');
	}
	
	public function Load()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_widgets_a_messages_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_widgets_announce_im'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'isvisible' => 1
				);
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_widgets_a_messages_'.$this->user->ID, $this->profile, 3600);
		}
		
	}
	
	public function Save()
	{
		if(!is_a($this->user, 'PUser') && $this->user->ID <= 0)
			return;
			
		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_widgets_announce_im']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,IsVisible = ".(int) $this->profile['isvisible'];
			
		PUsersMgr::$db->query($sql);
			
		if (PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_widgets_a_messages_'.$this->user->ID);
	}
}
