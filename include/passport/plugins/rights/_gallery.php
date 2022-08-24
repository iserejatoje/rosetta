<?

class PRights_gallery_passport extends PRightsProvider
{
	static private $possible = array(
		'только мне',
		'всем',
		'только зарегистрированным',
		'только друзьям',
		);
		
	public function GetPossible()
	{
		return self::$possible;
    }

	public function GetRights($params)
	{
		global $OBJECTS;
		
		$rights = array(1);
		if($this->user->IsAuth())
			$rights[] = 2;
				
		if(empty($params['id']) || !is_numeric($params['id']))
			return $rights;
			
		$owner = $OBJECTS['usersMgr']->GetUser($params['id']);
		
		if ($this->user->Plugins->Friends->IsApprovedFriend($owner->ID))
			$rights[] = 3;		
				
		return $rights;
    }
	
	public function GetDefault()
	{
		return 1;
	}
}

?>