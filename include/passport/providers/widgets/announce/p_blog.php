<?php

class PProfile_widgets_announce_blog extends PProfilePlain
{
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('favorites', 'isvisible', 'mydiary', 'mycomments', 'lastcomments');
	}
	
	public function Load()
	{
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_widgets_a_blog_'.$this->user->ID);
		else
			$this->profile = false;
			
		if($this->profile === false)
		{			
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_widgets_announce_blog'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			$res = PUsersMgr::$db->query($sql);
			$this->profile = $res->fetch_assoc();

			if (is_array($this->profile)) {
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				$this->profile = array(
					'favorites' => 1,
					'isvisible' => 1,
					'mydiary' => 1,
					'mycomments' => 1,
					'lastcomments' => 0
				);
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_widgets_a_blog_'.$this->user->ID, $this->profile, 3600);
		}
		
	}
	
	public function Save()
	{
		if(!is_a($this->user, 'PUser') && $this->user->ID <= 0)
			return;
			
		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_widgets_a_blog_'.$this->user->ID);

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_widgets_announce_blog']." SET ";
        $sql.= " UserID = ".$this->user->ID;
		$sql.= " ,Favorites = ".(int) $this->profile['favorites'];
		$sql.= " ,IsVisible = ".(int) $this->profile['isvisible'];
		$sql.= " ,MyDiary = ".(int) $this->profile['mydiary'];
		$sql.= " ,MyComments = ".(int) $this->profile['mycomments'];
		$sql.= " ,LastComments = ".(int) $this->profile['lastcomments'];

		PUsersMgr::$db->query($sql);
	}
}
