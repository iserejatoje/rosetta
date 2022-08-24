<?php

class PProfile_themes_blogs extends PProfilePlain
{

	public function __construct($index, $parent, $user)
	{	
		parent::__construct($index, $parent, $user);
		
		$this->fields = array('ismain', 'position');
	}

	public function Load()
	{
		if ( !$this->user->ID )
			return;
		
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_blogs_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{		
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_themes_blogs'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				// пустой профиль
				$this->profile['ismain'] = 0;
                                $this->profile['position'] = '';
			}
			
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_blogs_'.$this->user->ID, $this->profile, 3600);
		}
	}

	public function Save()
	{
		if( $this->user->ID <= 0 )
			return;

                if (strlen($this->profile['position']) > 255)
                    $this->profile['position'] = substr($this->profile['position'], 0, 255);

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_themes_blogs']." SET ";
                $sql.= " UserID = ".$this->user->ID;
		$sql.= ", IsMain = ".($this->profile['ismain'] ? 1 : 0);
                $sql.= ", Position = '".addslashes($this->profile['position'])."'";

		PUsersMgr::$db->query($sql);

		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_blogs_'.$this->user->ID);
	}
}
