<?
class Widget_user_blogs extends IWidget
{
	protected $_db;
	private $_cache = null;

	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Записи в блоге';

		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('ustring');
		LibFactory::GetStatic('datetime_my');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'blogs');
	}

	public function Init($path, $state = null, $params = array())
	{
		parent::Init($path, $state, $params);

		LibFactory::GetMStatic('diaries', 'diarymgr');
	}

	protected function OnDefault()
	{
		global $OBJECTS;

		/*if ($OBJECTS['user']->ID != '888113'
		&& $OBJECTS['user']->ID != '1'
		&& $OBJECTS['user']->ID != '782423'
		)
			return false;*/

		if ($this->params['id'] <= 0)
			return false;

		$result = $this->_OnDefault();
		if ($result === false)
			return false;

		//Trace::VarDump($result);

		return STPL::Fetch("widgets/user/blogs/_states/mypage", $result );
	}

	protected function &_OnDefault()
	{
		global $OBJECTS, $CONFIG;

		$cacheid = "widget_user_blog_".$this->params['id'];

		$data = $this->_cache->get($cacheid);
		$data = false;
		if ( $data !== false )
			return $data;

		$data = array(
			'UserID' => $this->params['id'],
			'count' => 0,
			'records' => array(),
		);

		$diary = DiaryMgr::getInstance()->GetDiary($this->params['id'], $CONFIG['env']['regid']);
		if ( isset($diary) ){

			$filter = array();
			if ($this->params['id'] != $OBJECTS['user']->ID) {
				$filter['rights'] = array(2);

				if ($OBJECTS['user']->Plugins->Friends->IsFriend($this->params['id']))
					$filter['rights'][] = 1;
			}

			$data['count'] = $diary->GetCountRecords( $filter );
			if( $data['count'] > 0 ){
				$filter['limit'] = $this->config['limit'];
				$data['records'] = $diary->GetRecords( $filter );
			}
		}

		$lifetime = 600;
		if ( isset($this->params['lifetime']) && $this->params['lifetime'] > 0 )
			$lifetime = intval($this->params['lifetime']);

		$this->_cache->set($cacheid, $data, $lifetime);

		return $data;
	}
}
?>