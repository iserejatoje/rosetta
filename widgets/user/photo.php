<?

/**
	"Фотография"
**/

class Widget_user_photo extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = '';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		parent::Init($path, $state, $params);
		
		//if($OBJECTS['user']->ID != 2)
		//	return false;

		if ( !isset($params['id']) )
			if ( $OBJECTS['user']->IsAuth() )
				$this->params['id'] = $OBJECTS['user']->ID;
			else
				return false;		
	}
	
	protected function OnDefault()
	{
		global $OBJECTS;
		
		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);		
		if (
		     $user === null || 
		     ($user->Blocked == 1 && $OBJECTS['user']->ID != $user->ID)
		   )
			return '';

		return $this->Render(
			$this->config['templates']['default'], array(), array($this, '_OnDefault'), 
			false
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		if ( $this->params['id'] == $OBJECTS['user']->ID )		
			$user = $OBJECTS['user'];
		else
			$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);
			
		if(!empty($user->Profile['general']['PhotoUrl']))
			$photo = array(
				'url' => $user->Profile['general']['PhotoUrl'],
				'width' => $user->Profile['general']['PhotoWidth'],
				'height' => $user->Profile['general']['PhotoHeight'],);
		else
			$photo = array(
				'url' => $user->Profile['general']['AvatarUrl'],
				'width' => $user->Profile['general']['AvatarWidth'],
				'height' => $user->Profile['general']['AvatarHeight'],);
			
		return array (
			'UserID' => $user->ID,
			'showname' => $user->Profile['general']['ShowName'],
			'photo' => $photo,
			'isnophoto' => ($this->params['id'] == $OBJECTS['user']->ID && empty($user->Profile['general']['Avatar']) && empty($user->Profile['general']['Photo']))
		);
	}
}
?>