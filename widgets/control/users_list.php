<?
class Widget_control_users_list extends IWidget
{
	//protected $params = null;
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
	}

	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;

		$this->params = $params;
		if(isset($OBJECTS['title']))
			$OBJECTS['user']->Plugins->Messages->AddResponse();

		parent::Init($path, $state, $params);
		
		if ( !empty($params['config']) )
			$this->LoadConfig($params['config']);
	}

	protected function OnDefault()
	{
		switch($this->params['type']) {
			case 'moderators':
				$this->title = 'Модераторы';
			break;
			default:
				$this->title = 'Участники';
			break;
		}
	
		if(!isset($this->params['place']))
			$this->params['place'] = 'default';
		$template = $this->config['templates']['places'][$this->params['place']];

		$cacheid = "ulist|{$this->params['id']}|{$this->params['type']}|{$this->params['source']}|{$this->params['limit']}|{$this->params['place']}";
		$res = $this->Render(
			$template,
			array(),
			array($this, '_OnDefault'),
			false,
			120,
			$cacheid);
		return $res;
	}

	protected function _OnDefault()
	{
		global $OBJECTS;

		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('source');
		
		$data = Source::GetData($this->params['source'], array(
					'id' => $this->params['id'],
					'type' => $this->params['type'],
					'limit' => $this->params['limit']));
		
		$res = array(
				'url_all' => $data['urltofulllist'],
				'show_url_all' => $data['count'] > $this->params['limit'] ? true : false,
				'obj_id' => $this->params['id'],
				'users' => $data['users'],
				'users_count' => $data['count'],
				'title' => $this->title,//$data['title'],
				'templates' => array('users_block' => $this->config['templates']['users_block'][$this->params['place']]),
				);

		return $res;
	}
		
	public function GetJSHandlers()
	{
		return array(
			);
	}
}
?>