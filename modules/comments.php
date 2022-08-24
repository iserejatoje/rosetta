<?

LibFactory::GetStatic('application');
class Mod_Comments extends ApplicationBaseMagic
{
	protected $_db;
	protected $_params;
	protected $_UniqueID; //id новости
	protected $_CommentID; //id текущего комментария
	protected $_Rating; //тип рейтингов
	protected $_preModerate; //тип рейтингов
	protected $_showCommentForm = true; //показывать форму добавления комментариев
	protected $_showCommentFormAuthOnly = false;
	protected $_Url;
	protected $_caсheid;
	protected $_cache;
	protected $_RoleKey;
	protected $_ShowComment;

	function __construct()
	{	global $OBJECTS;

		parent::__construct('comments');

		LibFactory::GetStatic('comments');
		LibFactory::GetStatic('cache');
	}

	public function Init($params = array())
	{
		global $OBJECTS, $CONFIG;
		
		$this->_page = 'default';
		
		$this->_db = DBFactory::GetInstance($this->_config['db']);

		$this->_Url = HandlerFactory::$env['uri'];

		if( is_array($params) && sizeof($params)>0 )
		{
			if(isset($params['page']))
			{
				$this->_page = $params['page'];
				$this->_linked = true;
			}

			$this->_UniqueID = $params['id'];
			$this->_Rating = $params['rating'];

			$this->_cache = new Cache();
			$this->_cache->Init('memcache', 'app_comment3_'.$CONFIG['env']['sectionid']);

			$this->_preModerate = (bool) $this->_config['premoderate'];
			if ( $params['premoderate'] !== null )
				$this->_preModerate = $params['premoderate'];

			$this->_cacheid = stripslashes($params['folder']).'|'.$params['name'].'|'.$this->_UniqueID;
			
			AppCommentTree::$db = $this->_db;
			AppCommentTree::$tables = $this->_config['tables'];
			AppCommentTree::$uniqueid = $this->_UniqueID;
			AppCommentTree::$premoderate = $this->_preModerate;

			LibFactory::GetStatic('subsection');
			if(!empty($this->_config['subsection']['sectionid']))
				$this->_ssp = SubsectionProviderFactory::GetInstance($this->_config['subsection']['sectionid']);
	        else
	            $this->_ssp = SubsectionProviderFactory::GetInstance($this->_env['sectionid']);
			
			if (isset($params['showcommentform']))
				$this->_showCommentForm = $params['showcommentform'] === true;
			
			$this->_showCommentFormAuthOnly = $params['showcommentformauthonly'];
				
			if(isset($params['rolekey']))
				$this->_RoleKey = $params['rolekey'];
			else
				$this->_RoleKey = $this->SSP($this->_UniqueID);
		}
	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if( is_array($params) && sizeof($params)>0 )
		{

			$this->_UniqueID = $params['params']['id'];
			$this->_cacheid = stripslashes($params['params']['folder']).'|'.$params['params']['name'].'|'.$this->_UniqueID;

			AppCommentTree::$db = $this->_db;
			AppCommentTree::$tables = $this->_config['tables'];
			AppCommentTree::$uniqueid = $this->_UniqueID;

			LibFactory::GetStatic('subsection');
			if(!empty($this->_config['subsection']['name']) && !empty($this->_config['subsection']['folder']))
				$this->_ssp = SubsectionProviderFactory::GetInstanceApp($this->_config['subsection']['name'], $this->_config['subsection']['folder']);
	        elseif(!empty($this->_config['subsection']['sectionid']))
				$this->_ssp = SubsectionProviderFactory::GetInstance($this->_config['subsection']['sectionid']);
			else
	            $this->_ssp = SubsectionProviderFactory::GetInstanceApp($this->Name, $this->Folder);


			$this->_RoleKey = $this->SSP($this->_UniqueID);
		}
	}
	public function AppInitAfterLinked($params = array())
	{
		global $OBJECTS, $CONFIG;

		parent::AppInitAfterLinked($params);

		$this->_caсheid = stripslashes($this->Folder).'|'.stripslashes($this->Name).'|'.$this->_UniqueID;

		AppCommentTree::$db = $this->_db;
		AppCommentTree::$tables = $this->_config['tables'];
		AppCommentTree::$uniqueid = $this->_UniqueID;

		LibFactory::GetStatic('subsection');
		if(!empty($this->_config['subsection']['name']) && !empty($this->_config['subsection']['folder']))
			$this->_ssp = SubsectionProviderFactory::GetInstanceApp($this->_config['subsection']['name'], $this->_config['subsection']['folder']);
        elseif(!empty($this->_config['subsection']['sectionid']))
			$this->_ssp = SubsectionProviderFactory::GetInstance($this->_config['subsection']['sectionid']);
		else
            $this->_ssp = SubsectionProviderFactory::GetInstanceApp($this->Name, $this->Folder);


		if(!isset($this->_RoleKey))
			$this->_RoleKey = $this->SSP($this->_UniqueID);


	}
	
	
	public function &GetPropertyByRef($name)
	{
		$name = strtolower($name);
		if ($name == 'id')
			return $this->_CommentID;
		elseif ($name == 'rolekey')
			return $this->_RoleKey;

		return parent::GetPropertyByRef($name);
	}

	public function SetPropertyByRef($name, &$value)
	{
		$name = strtolower($name);
		if ($name == 'parentid')
		{
			$this->_UniqueID =& $value;
		}
		elseif ($name == 'rolekey')
		{
			$this->_RoleKey = $value;
		}
		elseif ($name == 'isshowcommentform')
		{
			$this->_showCommentForm = $value;
			
		}
		
	}

	public function SSP($id)
	{
		if($this->_ssp !== null)
			return $this->_ssp->CreateKey(array('id' => $id));
		else
			return 's'.$id;
	}

	protected function prepareCommentsTree(&$comments) {

		unset($comments['count'], $comments['id'], $comments['name'], $comments['parent']);
		if ( !empty($comments['data']) )
			$this->prepareComment($comments['data']);

		if ( !empty( $comments['nodes'] ) ) {
			foreach ($comments['nodes'] as &$comment) {
				$this->prepareCommentsTree($comment);
			}
		}
	}

	protected function prepareComment(&$comment) {
		global $OBJECTS;
		
		$comment['Rating'] = $this->_Rating;
		$comment['Url'] = $this->_Url;

		$comment['CanDelete'] = false;
		
		$comment['User']['Name'] = '';
		$comment['User']['InfoUrl'] = '';
		if ( !empty($comment['UserID']) ) {
			$user = $OBJECTS['usersMgr']->GetUser($comment['UserID']);

			if ( $user !== null && $user->ID > 0 ) {
				$comment['User']['Name'] = $user->Profile['general']['ShowName'];
				$comment['User']['InfoUrl'] = $user->Profile['general']['InfoUrl'];

				$comment['User']['Avatar'] = array(
					'avatarurl'		=> $user->Profile['general']['AvatarSmallUrl'],
					'avatarwidth'	=> $user->Profile['general']['AvatarSmallWidth'],
					'avatarheight'	=> $user->Profile['general']['AvatarSmallHeight'],
				);
			}
		}
	}

	protected function &GetCommentsIndexSlice($page) {

		if ($page <= 0)
			$page = 1;

		$index = $this->GetCommentsIndex();
		if ($index === null)
			return null;

		$slice_cid = 'comments_index_slice_'.$this->_UniqueID.'_'.(int) $page;
		$slice = $this->_cache->get($slice_cid);
		if ($slice === false) {

			$slice = array();

			$slice['index'] = &$index;
			if (is_array($index) && sizeof($index))
				$index[0][0] = array_slice($index[0][0],
					($page-1) * $this->_config['row_on_page'], $this->_config['row_on_page']);
			else
				return null;

			$ids = array();
			$slice['data'] = array();
			foreach($index as $level => $parents) {
				$ids[$level] = array();
				foreach(array_keys($parents) as $parent) {
					if ($level && !in_array($parent, $ids[$level-1])) {

						unset($index[$level][$parent]);
						continue ;
					}

					$ids[$level] = array_merge($ids[$level], $index[$level][$parent]);
					foreach($index[$level][$parent] as $comment) {
						$slice['data'][$comment] = AppCommentTree::GetComment($comment, true);
						$this->prepareComment($slice['data'][$comment]);
					}
				}
			}

			$this->_cache->set($slice_cid, $slice, 300);
		}

		return $slice;
	}

	protected function &GetCommentsIndex() {

		$filter = array(
			'fields' => array(
				'uniqueid'	=> $this->_UniqueID,
				'isvisible'	=> 1,
				'isnew' => ($this->_preModerate ? 0 : null),
			),
			'sort' => array(
				array('field' => 'opt_Date', 'dir' => 'asc'),
			),
		);

		$index = AppCommentTree::GetCommentsIndex($filter);
		if (!(is_array($index) && sizeof($index)))
			return null;

		return $index;
	}
}
?>