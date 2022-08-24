<?
class Widget_announce_feedback extends IWidget
{
	protected $_db;
	private	$captcha;
	private	$_cache;
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Новости';
				
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
		
		parent::Init($path, $state, $params);
		
		LibFactory::GetStatic('ustring');
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('data');
	
	}
	
	protected function OnShowForm()
	{	
		$this->params['limit'] = intval($this->params['limit']);
		if ($this->params['limit'] <= 0)
			$this->params['limit'] = 6;
		if (!is_array($this->params['sections']) || count($this->params['sections']) == 0)
			$this->params['sections'] = array(App::$CurrentEnv['sectionid']);
		
		return STPL::Fetch("widgets/announce/article/last_article", $this->_OnLastArticle());
	}
	
	protected function _OnLastArticle()
	{
		$filter = array(
			'limit' => $this->params['limit'],
			'field' => array(
				'Date',
			),			
			'dir' => array(
				'DESC'
			),
			'sections' => $this->params['sections'],
		);
		$articles = ArticleMgr::GetInstance()->getArticles($filter);
			
		$result = array();
		foreach($articles as $article)
		{
			$result[] = array(
				'title' => $article->Title,
				'url' => $article->Url,
				'announce' => $article->Anon,
				'date' => $article->tsDate,
				'thumb' => $article->Thumb,
			);
		}		
		return array(
			'list' => $result
		);
	}
	
}