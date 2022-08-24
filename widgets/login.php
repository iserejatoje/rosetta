<?
class Widget_login extends IWidget
{
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Авторизация';		
	}
		
	protected function OnDefault()
	{
		global $CONFIG, $OBJECTS;

		Response::NoCache();
		
		return STPL::Fetch('widgets/login/default', $this->_OnDefault());		
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS;
		
		if ($OBJECTS['user']->IsAuth()) {
			$res = array(
				'showname' 			=> $OBJECTS['user']->Profile['general']['ShowName'],
				'fullname' 			=> $OBJECTS['user']->Profile['general']['FirstName'],
				'url_current'		=> $this->params['url'],
				'url_mypage' 		=> '/account/mypage.php',
				'url_logout' 		=> '/account/logout.php'.(empty($this->params['url'])?'':'?url='.$this->params['url']),				
			);
		} else {
			$res = array(
				'url' 			=> empty($this->params['url'])?'':$this->params['url'],
				'url_current'	=> $this->params['url'],
				'url_login' 	=> '/account/login.php',
				'url_register' 	=> '/account/register.php'.(empty($this->params['url'])?'':'?url='.$this->params['url']),
				'url_forgot' 	=> '/account/forgot.php'.(empty($this->params['url'])?'':'?url='.$this->params['url']),
			);
		}
		
		return $res;
		
	}
		
}
?>