<?
class Widget_announce_firms extends IWidget
{
	private $_db;
	private $_tree;
	private $_cache;

	public function __construct($id)
	{
		global $OBJECTS;

		parent::__construct($id);

		$this->title = 'Каталог интернет-магазинов';

		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('app_comment_tree');
		LibFactory::GetStatic('ustring');
		LibFactory::GetMStatic('tree', 'nstreemgr');
		LibFactory::GetMStatic('place', 'placemgr');
		LibFactory::GetStatic('filestore');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'widget_announce_firms');
	}

	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;

		parent::Init($path, $state, $params);

		/*
		AppCommentTree::$db = $this->_db;
		AppCommentTree::$tables = array(
			'comments' 		=> $this->config['tables']['comments'],
			'votes'			=> $this->config['tables']['comments_votes'],
			'ref'			=> $this->config['tables']['comments_ref'],
		);


		AppCommentTree::$uniqueid = 0;*/
	}
	
	protected function OnCategoryList()
	{	
		if (!isset($this->params['template']))
			$this->params['template'] = 'widgets/announce/firms/category_list';
		
		return STPL::Fetch($this->params['template'], $this->_OnCategoryList());
	}
	
	private function _OnCategoryList() 
	{
		$cacheid = 'category_list_'.$this->params['section'];
		$result = $this->_cache->get($cacheid);		
		if ($result === false) 
		{
			$bl = BLFactory::GetInstance('system/config');
			$config = $bl->LoadConfig('module_engine', 'firms');

			$db = DBFactory::GetInstance($config['db']);
			
			
			$result = array();
			
			try
			{
				$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);				
				$root = $tree->setTreeId($this->params['section']);
				$nodes = $root->getChildNodes(1,1, true);
				
				foreach($nodes as $node)
				{				
					$result['list'][$node->ID] = array(
						'url' => 'http://'.$node->NameID.".".MAIN_DOMAIN."/shops/",
						//'url' => "http://".MAIN_DOMAIN."/shops/".$this->_getNamePath($root, $node->getPath(true)),
						'name' => $node->Title,
						'count' => $node->ItemsCount,
						'icon' => $node->Icon,
					); 
				}
			}
			catch(Exception $e)
			{
				$result = array();
			}
			
			$this->_cache->set($cacheid, $result, 3600);
		}
		return $result;
	}
	
	protected function OnBestRubric()
	{
		return STPL::Fetch('widgets/announce/firms/best_rubric', $this->_OnBestRubric());
	}
	
	private function _OnBestRubric()
	{
		$cacheid = 'best_rubric_'.$this->params['section'];
		$result = $this->_cache->get($cacheid);		
		if ($result === false) 
		{
			$bl = BLFactory::GetInstance('system/config');
			$config = $bl->LoadConfig('module_engine', 'firms');

			$db = DBFactory::GetInstance($config['db']);
			
			$data = array();
			
			try
			{
				$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);
						
				$root = $tree->setTreeId($this->params['section']);
				$nodes = $root->getChildNodes(1,1, true);
				
				foreach($nodes as $node)
				{				
					$data[$node->ID] = $node->ItemsCount + $node->Views;
					$result['list'][$node->ID] = array(
						'url' => 'http://'.$node->NameID.".".MAIN_DOMAIN."/shops/",
						//'url' => "http://".MAIN_DOMAIN."/shops/".$this->_getNamePath($root, $node->getPath(true)),
						'name' => $node->Title,
						'count' => $node->ItemsCount,
						'icon' => $node->Icon,
					); 
				}
			}
			catch(Exception $e)
			{
				return array();
			}
			
			arsort($data, SORT_NUMERIC);
			$data2 = array();
			$i = 0;
			foreach ($data as $k => $v)
			{
				if ($i >= 6)
					break;
				$data2[$k] = $data[$k];
				$i++;
			}
			
			foreach($nodes as $node)
			{
				if (!isset($data2[$node->ID]))
					unset($result['list'][$node->ID]);
			}
			
			$this->_cache->set($cacheid, $result, 3600);
		}
		
		return $result;
	}
	
	protected function OnPopularShop()
	{
		return STPL::Fetch('widgets/announce/firms/popular_shop', $this->_OnPopularShop());
	}
	
	private function _OnPopularShop()
	{
		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'firms');

		$db = DBFactory::GetInstance($config['db']);

		$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);
		if ($this->params['root']) {
			$current = $tree->getNode($this->params['root']);
			$tree->setTreeId($current->treeid, false);
		} else {
			$current = $tree->setTreeId($this->params['section']);
		}
		$filter = array(
			'flags' => array(
				'IsVisible'	=> 1,
				'objects' => true,
			),

			'field'	=> array(
				'IsCommerce',
				'Views',
				'Ord',
				'Name',
			),
			'group' => array(
				'fields' => array(
					'PlaceID'
				),
			),
			'dir'	=> array(
				'DESC',
				'DESC',
				'ASC',
				'ASC',
			),
			'limit' => 3,
			
			'calc'	=> false,
		);
	
		$places = PlaceMgr::GetInstance()->GetPlaces($filter);
		
		$link = ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true);
		foreach($places as $id => $place)
		{
			$pathList = array();
			$sections = $place->GetSectionRef(true, $this->params['section']);

			foreach($sections as $section)
			{
				$node = $tree->getNode($section);
				if ($node->isLeaf())
				{
					$path_url = $this->_getNamePath($current, $node->getPath(true)).$place->ID . ".html";
				}
			}

			$list[] = array(
				'place' => $place,
				'url' => $path_url,
			);
		}

		$result = array(
			'list'	=> $list,
			'link' 	=> $link,
			'base'	=> ($current->level > 0 ? $current->NameID : ""),
		);
		//print_r($result);
		return $result;
	}
	
	protected function OnShopNews()
	{
		return STPL::Fetch('widgets/announce/firms/shop_news', $this->_OnShopNews());
	}
	
	private function _OnShopNews()
	{
		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'firms');

		$db = DBFactory::GetInstance($config['db']);

		$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);
		if ($this->params['root']) {
			$current = $tree->getNode($this->params['root']);
			$tree->setTreeId($current->treeid, false);
		} else {
			$current = $tree->setTreeId($this->params['section']);
		}
				
		$filter = array(
			'flags' => array(
				'IsVerified'=> 1,
				'IsVisible'=> 1,
			),

			'field'	=> array(
				'Created',
			),
			'dir'	=> array(
				'DESC',
			),
			'limit' => 4,
		);
		
		LibFactory::GetMStatic('place', 'placenewsmgr');
		
		$list = PlaceNewsMgr::GetInstance()->GetNewsFilter($filter);
		foreach($list as $key => &$item)
		{
			$item['Created'] = strtotime($item['Created']);
			$item['Updated'] = strtotime($item['Updated']);
			
			$place = PlaceMgr::GetInstance()->GetPlace($item['PlaceID']);
			if ($place === null)
				unset($list[$key]);
			
			$sections = $place->GetSectionRef(true, $this->params['section']);
			foreach($sections as $section)
			{
				$node = $tree->getNode($section);
				if ($node->isLeaf())
				{
					$path_url = $this->_getNamePath($current, $node->getPath(true)).$place->ID . ".html";
				}
			}
			$place->Name = stripslashes($place->Name);
			$item['place'] = $place;
			$item['url'] = $path_url;
		}
		return array(
			'list' => $list,
			'link' => ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true),
		);
	}
	
	protected function OnSearchForm()
	{	
		return STPL::Fetch('widgets/announce/firms/search_form', $this->_OnSearchForm());
	}
	
	private function _OnSearchForm() 
	{
		$query = App::$Request->Get['q']->Value(Request::OUT_HTML_CLEAN);
		$RegionID = App::$Request->Get['region']->Int(0, Request::UNSIGNED_NUM);
		
		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'firms');

		$db = DBFactory::GetInstance($config['db']);			
		$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);
		
		$node = App::$Request->Get['node']->Int(0, Request::UNSIGNED_NUM);
		if ($node > 0)
		{
			$node = $tree->GetNode($node);
			$result['nodename'] = $node->Title;
			$result['nodeid'] = $node->ID;
		}
		
		$result['query'] = $query;
		$result['RegionID'] = $RegionID;
		
		LibFactory::GetStatic('source');		
		$regions = Source::GetData('db.regions', array('country' => 'russia'));
		asort($regions);
		$result['regions'][0] = 'Вся Россия';		
		$result['regions'] = array_merge($result['regions'], $regions);

		$data = array();
		$cacheid = 'search_form'.$this->params['section'];		
		$data = $this->_cache->get($cacheid);		
		if ($data === false) 
		{
			try
			{
				$tree = new NSTreeMgr($db, $config['tables'], $config['fields']);				
				$root = $tree->setTreeId($this->params['section']);
				$nodes = $root->getChildNodes(1,1, true);
				$data[0] = "Все рубрики";
				foreach($nodes as $node)
				{				
					$data[$node->ID] = $node->Title;
				}
			}
			catch(Exception $e)
			{
				$data = array();
			}
			
			$this->_cache->set($cacheid, $data, 3600);
		}
		
		$result['list'] = $data;
		return $result;
	}

	protected function OnUserMenu() {
		global $OBJECTS, $CONFIG;


		$template = 'widgets/announce/firms/user_menu';
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];

		return STPL::Fetch($template,
			$this->_OnUserMenu()
		);
	}

	protected function _OnUserMenu() {

		return array(
			'page' => $this->params['page'],
		);
	}

	protected function OnPassportMyPage() {
		if (!isset($this->params['root']) || !Data::Is_Number($this->params['root']))
			return '';

		if ( !empty($this->params['title']) )
			$this->title = $this->params['title'];
		else if (isset($this->params['titleid']) && Data::Is_Number($this->params['titleid'])) {
			$n = STreeMgr::GetNodeByID($this->params['titleid']);
			if ( $n !== null && strlen($n->Name) > 0 )
				$this->title = $n->Name;
		}

		if (!isset($this->params['limit']) || !Data::Is_Number($this->params['limit']))
			$this->params['limit'] = 3;

		$template = 'widgets/announce/firms/passportmypage';
		return STPL::Fetch($template, $this->_OnPassportMyPage());
	}

	protected function _OnPassportMyPage() {
		global $OBJECTS;

		$cacheid = 'passportmypage_'.$this->params['root'].'_'.$this->params['limit'];

		$result = $this->_cache->get($cacheid);
		if ($result === false) {

			$filter = array(
				'flags' => array(
					'NodeID' => $this->params['root'],
					'IsVisible' => 1,
					'objects' => true
				),
				'limit' => 3,
			);

			$places = PlaceMgr::getInstance()->GetPlacesWithComments($filter);
			if (empty($places))
				return array();

			$result = array(
				'title' => $this->title,
				'places' => array(),
				'comments' => array(),
			);

			 foreach($places as $place) {
				$comment = AppCommentTree::GetComment($place->LastCommentID, true);
				if (empty($comment))
					continue ;

				$place = array(
					'PlaceID' => $place->ID,
					'Name' => $place->Name,
					'LegalType' => $place->LegalType,
					'LogotypeSmall' => $place->LogotypeSmall,
				);

				$comment['User'] = array();
				if ($comment['UserID'])
				{
					$user = $OBJECTS['usersMgr']->GetUser($comment['UserID']);
					if ( $user !== null && $user->ID > 0 ) {
						$comment['User']['Name'] = $user->Profile['general']['ShowName'];
						$comment['User']['Email'] = $user->Email;
						$comment['User']['UserID'] = $user->ID;
					}
					else
						$comment['UserID'] = 0;
				}

				$result['places'][$place['PlaceID']] = $place;
				$result['comments'][$place['PlaceID']] = $comment;
			 }

			 $this->_cache->set($cacheid, $result, 3600);
		}

		 return $result;
	}

	protected function OnMain()
	{
		global $OBJECTS, $CONFIG;

		if ( isset($this->params['root']) && empty($this->params['root']) )
			return '';
		elseif (!isset($this->params['root']))
			$this->params['root'] = array();
		else
			$this->params['root'] = (array) $this->params['root'];

		if (!isset($this->params['allow_childs']))
			$this->params['allow_childs'] = null;
		else
			$this->params['allow_childs'] = (array) $this->params['allow_childs'];

		if (!isset($this->params['IsAnnounce']) || $this->params['IsAnnounce'] != true)
			$this->params['IsAnnounce'] = false;

		if (!isset($this->params['IsLeaf']) || $this->params['IsLeaf'] != true)
			$this->params['IsLeaf'] = false;

		if( !Data::Is_Number($this->params['limit_places']) || $this->params['limit_places'] > 25)
			$this->params['limit_places'] = 0;

		if ( isset($this->params['section']) && (!Data::Is_Number($this->params['section']) || !$this->params['section']) )
			return '';

		if (!$this->params['section'] && !$this->params['root'])
			$this->params['section'] = $CONFIG['env']['sectionid'];

		if( !Data::Is_Number($this->params['lifetime']) || $this->params['lifetime'] < 600)
			$this->params['lifetime'] = 600;

		if(!isset($this->params['main_sub_limit']) || !Data::Is_Number($this->params['main_sub_limit']))
			$this->params['main_sub_limit'] = $this->config['main_sub_limit'];

		if(!isset($this->params['limit']) || !Data::Is_Number($this->params['limit']))
			$this->params['limit'] = 0;

		if (!isset($this->params['random_place']) || $this->params['random_place'] != true)
			$this->params['random_place'] = false;

		if (!isset($this->params['root_title_link']) || $this->params['root_title_link'] != true)
			$this->params['root_title_link'] = false;

		$n = STreeMgr::GetNodeByID($this->params['titleid']);

		if ( !empty($this->params['title']) )
			$this->title = $this->params['title'];
		elseif ( $n !== null && strlen($n->Name) > 0 )
			$this->title = $n->Name;

		$template = 'widgets/announce/firms/main';
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];

		return STPL::Fetch($template,
			$this->_OnMain()
		);
	}

	protected function _OnMain()
	{
		global $OBJECTS, $CONFIG;

		$cacheid = 'm'.implode('_',$this->params['root']).'_'.(int) $this->params['section'].'_'
		.(int) $this->params['random'].'_'.(int) $this->params['limit'].'_'
		.(int) $this->params['comments'].'_'.$this->params['random_place'].'_'.$this->params['limit_places'].'_'
		.(int) $this->params['IsAnnounce'].'_'.(int) $this->params['IsLeaf'].'_'.(int) $this->params['main_sub_limit'].'_'
		.(int) $this->params['main_sub_limit'].'_'.(int) $this->params['root_title_link'];

		if (is_array($this->params['allow_childs']))
			$cacheid.= '_'.implode('_',$this->params['allow_childs']);

		$result = $this->_cache->get($cacheid);
		if ($result === false) {

			$nodes = array();
			if (!empty($this->params['root'])) {
				foreach($this->params['root'] as $id) {
					$nodes[] = $this->_tree->getNode($id);
				}
			} else {
				$nodes[] = $this->_tree->setTreeId($this->params['section']);
			}

			$result['list'] = array();
			$filter = array(
				'flags' => array(
					'IsVisible'		=> 1,
					'objects'		=> false,
					'IsAnnounce'	=> 1,
					'CommerceType'	=> 1,
				),

				'field'	=> array(
					'Ord',
					'Name',
				),

				'dir'	=> array(
					'ASC',
					'ASC',
				),

				//'limit'	=> $this->params['limit_places'],

				'calc'	=> true,

			);

			$result['root_link'] = $result['link'] = ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true);

			foreach($nodes as $current) {
				$start = $this->_tree->setTreeId($current->treeid);

				$config = ModuleFactory::GetConfigById('section', $this->params['section']);
				if ($this->params['root'] && $config['root'] && $config['root'] != $this->params['root']) {
					$start = $this->_tree->getNode($config['root']);
				}

				if ($this->params['root_title_link'])
					$result['root_link'] = $result['link'].$this->_getNamePath($start, $current->getPath(true));

				$path = $current->getPath(true);
				$result['base'] = $this->_getNamePath($start, $path);

				$base = $this->_getNamePath($start, $path);

				if ($this->params['IsLeaf'] === true)
					$childs = $current->getChildNodesLeaf(0, 0, true);
				else
					$childs = $current->getChildNodes(1, 1, true);

				if (!$childs->count()) {
					//$OBJECTS['uerror']->AddError(ERR_M_FIRMS_SECTION_IS_EMPTY);
					return ;
				}

				foreach($childs as $v) {
					if (!$v->ItemsCount)
						continue ;

					if ($this->params['allow_childs'] != null && in_array($v->Id, $this->params['allow_childs']) == false)
						continue;

					if (null === ($path = $v->getPath(true)))
						continue ;

					$base = $result['base'].$this->_getNamePath($current, $path);
					if (strrpos($base, "/") != false)
						$base = substr($base, 0, strlen($base)-1);

					$places = array();
					if ($this->params['IsAnnounce'] === true) // && $v->isLeaf())
					{
						$filter['flags']['NodeID'] = $v->Id;
						list($places, $count_places) = PlaceMgr::getInstance()->GetPlaces($filter);

						if ($this->params['random_place'] === true && count($places)>0)
						{
							shuffle($places);
							$places = array(0 => $places[0]);
						}
					}

					if (is_array($places) && sizeof($places)) {
						foreach($places as &$p) {
							$p['_base'] = $this->_getBaseUrl($current, $p['PlaceID'], $v);
						}
					}

					$childs_arr = array();

					if ($this->params['IsLeaf'] == false && $this->params['main_sub_limit'] && null !== ($childs1 = $v->getChildNodes(1, 1, true))) {
						foreach($childs1 as $v1) {
							if (!$v1->ItemsCount)
								continue ;

							$places2 = array();
							if ($this->params['IsAnnounce'] === true && $v1->isLeaf())
							{
								$filter['flags']['NodeID'] = $v1->Id;

								list($places2, $count_places) = PlaceMgr::getInstance()->GetPlaces($filter);
								if ($this->params['random_place'] === true && count($places2)>0)
								{
									shuffle($places2);
									$places2 = array(0 => $places2[0]);
								}
							}

							if (is_array($places2) && sizeof($places2)) {
								foreach($places2 as &$p) {
									$p['_base'] = $this->_getBaseUrl($current, $p['PlaceID'], $v);
								}
							}

							$childs_arr[] = array(
								'NodeID'	=> $v1->Id,
								'NameID'	=> $v1->NameID,
								'Title'		=> $v1->Title,
								'ItemsCount'=> $v1->ItemsCount,
								'Places'	=> $places2,
							);
						}

						shuffle($childs_arr);
						$childs_arr = array_slice($childs_arr, 0, $this->params['main_sub_limit']);
					}

					$comment = null;
					$place = null;

					if ($this->params['comments'] === true) {

						$childsID = $v->getChildNodesID(0, 0, true);
						if (is_array($childsID) && sizeof($childsID))
						{
							foreach($childsID as $id)
							{
								if (($comment_result = $this->_get_comments_by_nodeid($id)) === null)
									continue;

								$comment = $comment_result['Comment'];
								$place = PlaceMgr::GetInstance()->GetPlace($comment_result['PlaceID']);

								$comment['User'] = array();
								if ($comment['UserID'])
								{
									$user = $OBJECTS['usersMgr']->GetUser($comment['UserID']);

									if ( $user !== null && $user->ID > 0 )
									{
										$comment['User']['Name'] = $user->Profile['general']['ShowName'];
										$comment['User']['Email'] = $user->Email;
										$comment['User']['UserID'] = $user->ID;
									}
									else
										$comment['UserID'] = 0;
								}


								$node = $this->_tree->getNode($id);
								$path = $node->getPath(true);
								$comment['_base'] = $this->_getNamePath($current, $path);
								break;
							}
						}

					}

					$result['list'][] = array(
						'NodeID'	=> $v->Id,
						'NameID'	=> $base,
						'Title'		=> $v->Title,
						'ItemsCount'=> $v->ItemsCount,
						'Childs'	=> (sizeof($childs_arr) ? $childs_arr : null),
						'Comment'	=> $comment,
						'Place'		=> $place,
						'Places'	=> $places
					);
				}
			}

			if ($this->params['random'] === true && $this->params['limit'] && $this->params['limit'] < sizeof($result['list'])) {
				shuffle($result['list']);
				$result['list'] = array_slice($result['list'], 0, $this->params['limit']);
				usort($result['list'], create_function('$a, $b',' return strcmp($a["Title"], $b["Title"]); '));
			}

			$this->_cache->set($cacheid, $result, $this->params['lifetime']);
		}

		$result['title'] = $this->title;

		$config = ModuleFactory::GetConfigById('section', $this->params['section']);
		$result['readonly'] = isset($config['readonly']) ? $config['readonly'] : false;
trace::vardump($result);
		return $result;
	}

	protected function OnMainFirms()
	{
		global $OBJECTS, $CONFIG;

		if ( isset($this->params['root']) && empty($this->params['root']) )
			return '';
		elseif (!isset($this->params['root']))
			$this->params['root'] = array();
		else
			$this->params['root'] = (array) $this->params['root'];

		if ( isset($this->params['section']) && (!Data::Is_Number($this->params['section']) || !$this->params['section']) )
			return '';

		if (!$this->params['section'] && !$this->params['root'])
			$this->params['section'] = $CONFIG['env']['sectionid'];

		if( !Data::Is_Number($this->params['lifetime']) || $this->params['lifetime'] < 600)
			$this->params['lifetime'] = 600;

		if(!isset($this->params['limit']) || !Data::Is_Number($this->params['limit']))
			$this->params['limit'] = 0;

		if (!isset($this->params['random_place']) || $this->params['random_place'] != true)
			$this->params['random_place'] = false;

		$n = STreeMgr::GetNodeByID($this->params['titleid']);

		if ( !empty($this->params['title']) )
			$this->title = $this->params['title'];
		elseif ( $n !== null && strlen($n->Name) > 0 )
			$this->title = $n->Name;

		$template = 'widgets/announce/firms/main_firms';
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];

		return STPL::Fetch($template,
			$this->_OnMainFirms()
		);
	}

	protected function _OnMainFirms()
	{
		global $OBJECTS, $CONFIG;

		$cacheid = implode('_',$this->params['root']).'_'.(int) $this->params['section'].'_'
		.(int) $this->params['random_place'].'_'.(int) $this->params['limit'];

		$result = $this->_cache->get($cacheid);
		if ($result === false) {

			$nodes = array();

			if (!empty($this->params['root'])) {
				foreach($this->params['root'] as $id) {
					$nodes[] = $this->_tree->getNode($id);
				}
			} else {
				$nodes[] = $this->_tree->setTreeId($this->params['section']);
			}

			$result['list'] = array();

			$filter = array(
				'flags' => array(
					'IsVisible'		=> 1,
					'objects'		=> false,
				),

				'field'	=> array(
					'Ord',
					'Name',
				),

				'dir'	=> array(
					'ASC',
					'ASC',
				),
				'limit'  => $this->params['limit'],
				'calc'	=> true,

			);

			foreach($nodes as $current) {
				$this->_tree->setTreeId($current->treeid, false);

				$config = ModuleFactory::GetConfigById('section', $this->params['section']);
				if ($this->params['root'] && $config['root'] && $config['root'] != $this->params['root']) {
					$start = $this->_tree->getNode($config['root']);
				} else {
					$start = $current;
				}

				if (!$current->ItemsCount)
					continue ;

				$path = $current->getPath(true);
				$result['base'] = $this->_getNamePath($start, $path);

				$places = array();
				if ($this->params['random_place'])
					$filter['offset'] = rand(0,$current->ItemsCount-$this->params['limit']);

				$filter['flags']['NodeID'] = $current->Id;
				list($places, $count_places) = PlaceMgr::getInstance()->GetPlaces($filter);

				foreach($places as $place)
				{
					if (!$place['LastCommentID'] || false === ($comment = AppCommentTree::GetComment($place['LastCommentID'], true)))
						continue ;

					$comments[$place['PlaceID']] = $comment;
					if ($comments[$place['PlaceID']]['UserID']) {
						$user = $OBJECTS['usersMgr']->GetUser($comments[$place['PlaceID']]['UserID']);
						if ( $user !== null && $user->ID > 0 )
						{
							$comments[$place['PlaceID']]['Name'] = $user->Profile['general']['ShowName'];
							$comments[$place['PlaceID']]['Email'] = $user->Email;
						}
						else
							$comments[$place['PlaceID']]['UserID'] = 0;
					}
				}

				$result['list'][] = array(
						'Places'	=> $places,
						'Comments'	=> $comments
				);
			}

			$result['link'] = ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true);
			$this->_cache->set($cacheid, $result, $this->params['lifetime']);
		} else
			$config = ModuleFactory::GetConfigById('section', $this->params['section']);

		$result['title'] = $this->title;
		$result['readonly'] = isset($config['readonly']) ? $config['readonly'] : false;

		return $result;
	}


	protected function OnDefault()
	{
		global $OBJECTS, $CONFIG;

		if ( isset($this->params['root']) && (!Data::Is_Number($this->params['root']) || !$this->params['root']) )
			return '';

		if ( isset($this->params['section']) && (!Data::Is_Number($this->params['section']) || !$this->params['section']) )
			return '';

		if ($this->params['section'] <= 0)
			return '';

		if( !Data::Is_Number($this->params['lifetime']) || $this->params['lifetime'] < 600)
			$this->params['lifetime'] = 600;

		if ( !empty($this->params['title']) )
			$this->title = $this->params['title'];
		elseif ( $this->params['titleid'] && ($n = STreeMgr::GetNodeByID($this->params['titleid'])) !== null && strlen($n->Name) > 0 )
			$this->title = $n->Name;

		$template = 'widgets/announce/firms/default';
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];

		return STPL::Fetch($template,
			$this->_OnDefault()
		);
	}

	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;

		$cacheid = 'default_'.(int) $this->params['root'].'_'.(int) $this->params['section'].'_'.(int) $this->params['comments'];

		$result = $this->_cache->get($cacheid);

		if ($result === false) {

			$result = array();

			if ($this->params['root']) {
				$current = $this->_tree->getNode($this->params['root']);
				$this->_tree->setTreeId($current->treeid, false);
			} else {
				$current = $this->_tree->setTreeId($this->params['section']);
			}

			$config = ModuleFactory::GetConfigById('section', $this->params['section']);
			if ($this->params['root'] && $config['root'] && $config['root'] != $this->params['root']) {
				$start = $this->_tree->getNode($config['root']);
			} else {
				$start = $current;
			}

			$path = $current->getPath(true);
			$base = $this->_getNamePath($start, $path);

			$result['list'] = array();
			$childs = $current->getChildNodes(1, 1, true);


			if (!sizeof($childs)) {
				$OBJECTS['uerror']->AddError(ERR_M_FIRMS_SECTION_IS_EMPTY);
				return ;
			}

			foreach($childs as $v) {
				$comment = null;
				$place = null;

				if ($this->params['comments'] === true)
				{
					$childsID = $v->getChildNodesID(0, 0, true);
					//error_log(print_r($childsID,true));
					if (is_array($childsID) && sizeof($childsID))
					{
						foreach($childsID as $id)
						{
							if (($comment_result = $this->_get_comments_by_nodeid($id)) === null)
								continue;

							$comment = $comment_result['Comment'];

							$place = PlaceMgr::GetInstance()->GetPlace($comment_result['PlaceID']);

							$comment['User'] = array();
							if ($comment['UserID'])
							{
								$user = $OBJECTS['usersMgr']->GetUser($comment['UserID']);

								if ( $user !== null && $user->ID > 0 )
								{
									$comment['User']['Name'] = $user->Profile['general']['ShowName'];
									$comment['User']['Email'] = $user->Email;
								}
								else
									$comment['UserID'] = 0;
							}

							$node = $this->_tree->getNode($id);
							$path = $node->getPath(true);
							$comment['_base'] = $this->_getNamePath($current, $path);
							break;
						}
					}

				}

				$result['list'][] = array(
					'NodeID'	=> $v->Id,
					'NameID'	=> $v->NameID,
					'Title'		=> $v->Title,
					'ItemsCount'=> $v->ItemsCount,
					'Comment'	=> $comment,
					'Place'		=> $place,
				);
			}

			$result['base'] = $base;

			$this->_cache->set($cacheid, $result, $this->params['lifetime']);
		}

		$result = array(
			'link' => ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true),
			'base' => $result['base'],
			'list' => $result['list'],
			'title' => $this->title,
			'icons' => $this->config['icons'],
		);

		return $result;
	}

	protected function OnSpec()
	{
		global $OBJECTS, $CONFIG;

		if ( isset($this->params['root']) && empty($this->params['root']) )
			return '';
		elseif (!isset($this->params['root']))
			$this->params['root'] = null;
		else
			$this->params['root'] = $this->params['root'];

		if ( isset($this->params['section']) && (!Data::Is_Number($this->params['section']) || !$this->params['section']) )
			return '';

		if (!$this->params['section'] && !$this->params['root'])
			$this->params['section'] = $CONFIG['env']['sectionid'];

		if (!isset($this->params['treeid']))
			$this->params['treeid'] = $this->params['section'];

		if (!isset($this->params['cols']) || empty($this->params['cols']))
			$this->params['cols'] = 4;

		if( !Data::Is_Number($this->params['lifetime']) || $this->params['lifetime'] < 1200)
			$this->params['lifetime'] = 1200;

		if (!isset($this->params['random_order']) || $this->params['random_order'] != true)
			$this->params['random_order'] = false;

		$n = STreeMgr::GetNodeByID($this->params['titleid']);

		if ( !empty($this->params['title']) )
			$this->title = $this->params['title'];
		elseif ( $n !== null && strlen($n->Name) > 0 )
			$this->title = $n->Name;

		$template = 'widgets/announce/firms/spec';
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];

		return STPL::Fetch($template,
			$this->_OnSpec()
		);
	}

	protected function _OnSpec()
	{
		global $OBJECTS, $CONFIG;

		$cacheid = 'spec_'.(int) $this->params['root'].'_'.(int) $this->params['treeid'];

		$result = $this->_cache->get($cacheid);
		if ($result === false)
		{
			if ($this->params['root']) {
				$current = $this->_tree->getNode($this->params['root']);

				$this->_tree->setTreeId($current->treeid, false);
			} else {
				$current = $this->_tree->setTreeId($this->params['treeid']);
			}

			$list = array();

			$filter = array(
					'flags' => array(
						'NodeID' => $current->Id,
						'CommerceType'	=> 2,
						'IsVisible'	=> 1,
						'objects' => true,
					),

					'field'	=> array(
						'Name',
					),
					'dir'	=> array(
						'DESC',
					),
					'limit' => 16,
					'calc' => true,
			);

			$PlaceMgr = PlaceMgr::getInstance();

			list($places, $count) = $PlaceMgr->GetPlaces($filter);

			if (is_array($places) && count($places)) {

				$link = ModuleFactory::GetLinkBySectionId($this->params['section'], array(), true);
				foreach($places as $id => $place)
				{
					$pathList = array();


						$sections = $place->GetSectionRef(true, $this->params['treeid']);

						foreach($sections as $section)
						{
							$node = $this->_tree->getNode($section);
							if ($node->isLeaf())
							{
								$path_list = $node->getPath(true);
								if ($path_list !== null) {
									$path_url = $this->_getNamePath($current, $path_list);
									$path_url = substr($path_url, 0, strlen($path_url)-1);
									break;
								} else
									$path_url = '';
							}
						}

						$path_url .= "/".$place->ID . ".html";

					$list[] = array(
						'place' => $place,
						'url' => $path_url,
					);
				}

				$result = array(
					'list'	=> $list,
					'link' 	=> $link,
					'base'	=> ($current->level > 0 ? $current->NameID : ""),
					'count' => $count,
					'title'	=> $this->title,
				);
			} else {
				$result = array();
			}

			$this->_cache->set($cacheid, $result, $this->params['lifetime']);
		}

		if (empty($result))
			return ;

		$result['cols']	= $this->params['cols'];
		if  ($this->params['random_order'] === true)
		{
			shuffle($result['list']);
		}

		return $result;
	}

	protected function _get_comments_by_nodeid($NodeID)
	{
		$cacheid.= 'get_comments_by_nodeid_'.(int) $NodeID;

		$result = $this->_cache->get($cacheid);
		if ($result === false) {
			$result = array(null);

			//Запрашиваем фирмы раздела
			$filter = array(
				'flags' => array(
					'NodeID'	=> $NodeID,
					'IsVisible'	=> 1,
					//'IsComments' => 1,
				),
				'field'	=> array(
					'Name',
				),
				'dir'	=> array(
					'ASC',
				),
				'calc'	=> true,
	//			'limit' => 1,
			);

			list($places, $count) = PlaceMgr::getInstance()->GetPlaces($filter);

			if (count($places) == 0)
				return null;

			//Запрашиваем комменты
			$filter = array(
				'fields' => array(
					'parent'	=> 0,
				),
				'sort' => array(
					array('field' => 'created', 'dir' => 'DESC'),
				),
				'limit' => array(
					'limit' => 1,
				),
			);

			$CommentExist = false;

			foreach($places as $place)
			{
				$filter['fields']['uniqueid'] = $place['PlaceID'];

				$comments = AppCommentTree::GetComments($filter, true);

				if ($comments)
				{
					$CommentExist = true;
					break;
				}
			}

			if ($CommentExist === true)
				 $result = array(
					'Comment'	=> $comments[key($comments)]['data'],
					'PlaceID'	=> $place['PlaceID'],
				);

			$this->_cache->set($cacheid, array($result), 3600);
		}

		return $result[0];
	}

	protected function _getBaseUrl($start, $placeid, NSTreeNode $node) {
		global $OBJECTS;
		if ($node->isLeaf())
			return $this->_getNamePath($start, $node->getPath(true));

		// если места выбранны из рубрики являющейся "веткой"
		$sections = PlaceMgr::getInstance()->GetPlaceSectionRef($placeid, $node->treeid, true);

		if (is_array($sections))
		foreach($sections as $id) {
			$pPath = $this->_tree->getNode($id)->getPath(true);
			foreach($pPath as $n) {
				if (!$n->isLeaf())
					continue ;

				return $this->_getNamePath($start, $n->getPath(true));
			}
		}
	}

	protected function _getNamePath($start, PNSTreeNodeIterator $path) {
		$base = '';
		foreach($path as $v) {
			if ($v->level <= $start->level)
				continue ;

			$base .= $v->NameID.'/';
		}
		return $base;
	}

	public function GetJSHandlers()
	{
		return array(
			);
	}
}
