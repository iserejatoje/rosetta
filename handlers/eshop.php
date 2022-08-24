<?

class Handler_eshop extends IHandler
{
	private $json;
	private $source;
	private $_params;
	private $_db;
	private $_tree;
	private $_root;

	public function Init($params)
	{
		$this->_params = $params['params'];
	}
	
	public function IsLast()
	{
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS, $CONFIG;
		
		$this->_db = DBFactory::GetInstance('ecologystyle');
		$tree = LibFactory::GetMStatic('eshop', 'eshopmgr');
		
		$this->_tree = new EShopTreeMgr($this->_db, 'eshop_tree', array(
			'nodeid'		=> 'NodeID',
			'left'			=> 'Left',
			'right'			=> 'Right',
			'level'			=> 'Level',
			'treeid'		=> 'TreeID',
			'childscount'	=> 'ChildsCount',
			'nameid'		=> 'NameID',
		));
		
		$nodes = EShopMgr::getInstance()->GetProductSectionRef($this->_params['ProductID']);
		
		if (!is_array($nodes) || !sizeof($nodes))
			Response::Status(404, RS_SENDPAGE | RS_EXIT);

		foreach($nodes as $node) {
		
			$node = $this->_tree->getNode($node);
			$this->_root = $this->_tree->setTreeId($node->treeid);
			
			$nn = STreeMgr::GetNodeByID($node->treeid);
			
			if($nn === null || $nn->Module != 'eshop')
				continue ;
			
			if(!$nn->IsVisible || $nn->isDeleted)
				continue ;
			
			$path = $node->getPath(true);
			if (empty($path) || $this->_checkPath($path) === false)
				continue ;
			
			$config = ModuleFactory::GetConfigById('section', $node->treeid);
			if (isset($config['root'])) {			
				$this->_root = $this->_tree->getNode($config['root']);
				$this->_tree->setTreeId($this->_root->treeid, false);
			}

			$path = ModuleFactory::GetLinkBySectionId($node->treeid).$this->_getNamePath($path).$this->_params['ProductID'].'.html';

			Response::Redirect($path);
			exit;
		}

		Response::Status(404, RS_SENDPAGE | RS_EXIT);
	}
	
	protected function _getNamePath(ShopNodeIterator $path) {
		$base = '';
		foreach($path as $v) {
			if ($v->level <= $this->_root->level)
				continue ;
			
			$base .= $v->NameID.'/';
		}
		return $base;
	}
	
	protected function _checkPath(ShopNodeIterator $path) {
		foreach($path as $n) {
			if ($n->isVisible)
				continue ;
		
			return false;
		}
		return true;
	}	
	
	public function Dispose()
	{
	}
}
?>