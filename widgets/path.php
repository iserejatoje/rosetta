<?
class Widget_path extends IWidget
{
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'path';
	}

	public function Init($path, $state = null, $params = array())
	{
		parent::Init($path, $state, $params);
	}

	protected function OnCatalog()
	{
		$currentNodeId = $this->params['nodeid'];
		$treeid	= $this->params['treeid'];
		$productid	= intval($this->params['mobileproductid']);
		$page	= $this->params['page'];

		if(!empty($this->params[$page."_title"]))
			return STPL::Fetch("widgets/path/default", array('title' => $this->params[$page."_title"]));

		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'eshop');

		$db = DBFactory::GetInstance($config['db']);
		try
		{
			$tree = new EShopTreeMgr($db, $config['tables'], $config['fields']);
			$root = $tree->setTreeId($treeid);
			$currentNode = $tree->GetNode($currentNodeId);
		}
		catch(Exception $e)
		{
			error_log($e->GetMessage());
			return '';
		}

		if(is_null($currentNode))
		{
			error_log("curentNode is null");
			return '';
		}

		$list = $currentNode->getPath();
		return STPL::Fetch("widgets/path/catalog", array('list' => $list, 'productid' => $productid));
	}

	protected function OnDefault()
	{
		$page	= $this->params['page'];

		if(!empty($this->params[$page."_title"]))
			return STPL::Fetch("widgets/path/default", array('title' => $this->params[$page."_title"]));

		return STPL::Fetch("widgets/path/default");
	}
}
