<?php

class PProfile_job extends PProfilePlain
{
	private $_isloaded			= false;

	public function __construct($index, $parent, $user)
	{	
		parent::__construct($index, $parent, $user);
		
		$this->fields = array('insresume', 'tarrif');
	}

	public function Load()
	{
		if ( $this->_isloaded === true || !$this->user->ID )
			return;
		
		$this->_isloaded = true;
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_job_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_job'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			
			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				// пустой профиль
				$this->profile['insresume']			= 0;
				$this->profile['tarrif']			= 0;
			}			
			
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_job_'.$this->user->ID, $this->profile, 3600);
		}
	}

	public function Save()
	{
		if( $this->user->ID <= 0 )
			return;
		
		$this->profile['insresume'] = $this->profile['insresume'] ? 1 : 0;
		$this->profile['insresume'] = $this->profile['tarrif'] ? $this->profile['tarrif'] : 0;
		
		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_job'];
		$sql.= " SET UserID = ".$this->user->ID;
		$sql.= " ,`Tarrif` = ".(int) $this->profile['tarrif'];
		$sql.= " ,`insResume` = ".(int) $this->profile['insresume'];
		PUsersMgr::$db->query($sql);

		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_job_'.$this->user->ID);
			
		$this->_isloaded = false;
	}
}
