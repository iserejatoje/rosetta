<?
/*Виджет желний*/
class Widget_user_desire extends IWidget
{
	private $_cache;
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);		
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		if (!in_array($OBJECTS['user']->ID, array(782423,6)))
			return false;		
			
		if ( $OBJECTS['user']->IsAuth() === false )
			return false;
		
		parent::Init($path, $state, $params);			
	}
		
	protected function OnDefault()	
	{
		if (isset($this->params['template']))
			$template = $this->params['template'];
		else
			$template = $this->config['templates']['default'];
		
		$cacheid = "desire|".$this->params['id']."|";
				
		return $this->Render(
			$template, 
			array(), array($this, '_OnDefault'), false, 120,$cacheid);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS;
		
				
		$userid = App::$Request->Get['id']->Int(null, Request::UNSIGNED_NUM);		
		if ($userid === null)
			return array();
		
		LibFactory::GetStatic('ustring');
		LibFactory::GetStatic('datetime_my');
		
		$filter['accesstype'] = 0; //Всем
		$user = $OBJECTS['usersMgr']->GetUser($userid);		
		if ($user === null)
			return array();
		
	
		$isFriend = $OBJECTS['user']->Plugins->Friends->IsFriend($user->ID);
		
		if ($isFriend == true)
			$filter['accesstype'] = 1; //Всем + друзьям
			
		$filter['limit'] = $this->config['limit'];	

		$result['list'] = $OBJECTS['user']->Plugins->Desire->GetDesires($userid, $filter);
		
		foreach($result['list'] as $k => $v)
		{
			$result['list'][$k]['Text'] = UString::Truncate($v['Text'], 50);
			$result['list'][$k]['url'] = "/passport/desires.php?id=".$userid."#desire".$v['DesireID'];
		}
		$result['url'] = "/passport/desires.php?id=".$userid;
		
		$result['count'] = $OBJECTS['user']->Plugins->Desire->GetDesiresCount($userid);
		
		
		return $result;
	}
}
?>