<?
LibFactory::GetMStatic('svoi', 'communitymgr');
class PRights_gallery_svoi extends PRightsProvider
{
	static private $possible = array(
		'только мне',
		'всем',
		'только зарегистрированным',
		'участникам сообщества',
		'модераторам сообщества',
		//'владельцу сообщества',		
		);
		
	public function GetPossible()
	{
		return self::$possible;
    }

	public function GetRights($params)
	{
		$rights = array(1);
		if($this->user->IsAuth())
			$rights[] = 2;
			
		if(empty($params['id']) || !is_numeric($params['id']))
			return $rights;
			
		$c = CommunityMgr::getInstance()->GetCommunity($id);
		if($c !== null)
		{
			$ui = $c->GetUserInfo($this->user->ID);
			$type = $ui['Type'];
		}
		else
			return $rights;
		
		LibFactory::GetMStatic('svoi', 'community');
		switch($type)
		{
			/*case Community::UserOwner:
				$rights[] = 5;*/
			case Community::UserModerator:
				$rights[] = 4;
			case Community::User:
				$rights[] = 3;
        }
		
		return $rights;
    }
	
	public function GetDefault()
	{
		return 1;
	}
}

?>