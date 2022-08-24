<?php

class PProfile_widgets_announce_weather extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('currentweather', 'city', 'showweather');
	}

	public function Load()
	{
		return;
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_widgets_a_weather_'.$this->user->ID);
		else
			$this->profile = false;

		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_widgets_announce_weather'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'currentweather' => 0,
					'showweather' => 1,
					'city' => 0
				);
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_widgets_a_weather_'.$this->user->ID, $this->profile, 3600);
		}
	}

	public function Save() {

		return;
		if(!isset($this->user->ID) || $this->user->ID <= 0)
			return;

		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_widgets_a_weather_'.$this->user->ID);

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_widgets_announce_weather']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,CurrentWeather = ".(int) $this->profile['currentweather'];
		$sql.= " ,ShowWeather = ".(int) $this->profile['showweather'];
		$sql.= " ,City = '".addslashes($this->profile['city'])."'";
			
		PUsersMgr::$db->query($sql);
	}
}
