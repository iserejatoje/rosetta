<?
class Widget_user_forum extends IWidget
{
	protected $_db;
	private $_cache = null;

	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Записи в форуме';

		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('ustring');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'forum');
	}

	public function Init($path, $state = null, $params = array())
	{
		parent::Init($path, $state, $params);

		LibFactory::GetMStatic('diaries', 'diarymgr');
	}

	protected function OnDefault()
	{
		global $OBJECTS;

		if (App::$User->ID != 1)
			return false;

		if ($this->params['id'] <= 0)
			return false;

		$result = $this->_OnDefault();
		if ($result === false)
			return false;

		return STPL::Fetch("widgets/user/forum/_states/mypage", $result );
	}

	protected function &_OnDefault()
	{
		global $OBJECTS, $CONFIG;

		return array();
		$cacheid = "widget_user_forum_".$this->params['id'];

		$lib_forum = LibFactory::GetInstance('themes');
		$lib_forum->Init(5040);

		// получаем данные
		$themes = $lib_forum->GetLastThemeUser($this->params['id'], $this->config['limit'],true);

		// режем bb-теги в сообщениях
		for ($i=0; $i<count($themes); $i++) {
			$themes[$i]['message'] = Data::BBTagsRemove($themes[$i]['message']);


		}

		trace::vardump($themes);

		return array();

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
				$filter['limit'] = 4;
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