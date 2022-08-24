<?
class Widget_control_header_menu_bottom extends IWidget
{

	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
			
		parent::Init($path, $state, $params);			
	}
	
	protected function OnDefault()
	{
		return $this->Render(
			$this->config['templates']['default'], 
			$this->_OnDefault(),
			null,
			false);
	}
	
	protected function _OnDefault()
	{
		global $CONFIG;
		LibFactory::GetStatic('heavy_data');
		$user_count = Heavy_Data::GetData('passport/users');
		$params['user_count'] = $user_count[$CONFIG['env']['regid']]['users'];
		
		return $params;
	}
	
	public function GetJSHandlers()
	{
		return array(
			);
	}
}
?>