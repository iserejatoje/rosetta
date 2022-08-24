<?

/**
	"Мои Интересы"
**/

class Widget_user_interests extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Мои интересы';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		parent::Init($path, $state, $params);
		
		if ( !isset($params['id']) )
			if ( $OBJECTS['user']->IsAuth() )
				$this->params['id'] = $OBJECTS['user']->ID;
			else
				return false;		
	}
	
	protected function OnDefault()
	{
		global $OBJECTS;
		
		$cacheid = "user|interests|".$this->params['id'];
		
		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);		
		if (
		     $user === null || 
		     ($user->Blocked == 1 && $OBJECTS['user']->ID != $user->ID)
		   )
			return '';

		return $this->Render(
			$this->config['templates']['default'], array(), array($this, '_OnDefault'), 
			false, 900, $cacheid
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		if ( $this->params['id'] == $OBJECTS['user']->ID )		
			$user = $OBJECTS['user'];
		else
			$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);
		
		$list = $user->Profile['interests']['GroupsInfo'];
		
		foreach ( $list as $gid => &$g )
		{
			if ( !is_array($g['interests']) || sizeof($g['interests']) == 0 )
			{
				unset($list[$gid]);
				continue;
			}
			
			if ( $this->config['shuffle'] === true )
				shuffle($g['interests']);
			if ( $this->config['interest_limit'] > 0 )
				$g['interests'] = array_slice($g['interests'],0,$this->config['interest_limit']);
		}
		if ( $this->config['shuffle'] === true )
			shuffle($list);
			
		if ( $this->config['group_limit'] > 0 )
			$list = array_slice($list,0,$this->config['group_limit']);
			
		return array (
			'UserID' => $user->ID,
			'list' => $list,
			'page' => $this->params['page'],
			'about' => $user->Profile['general']['About'],
		);
	}
}
?>