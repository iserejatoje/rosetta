<?
class Widget_catalog extends IWidget
{
	private $_db;
	private $_tree;
	private $_cache;

	public function __construct($id)
	{
		global $OBJECTS;

		parent::__construct($id);

		$this->title = 'Интернет-магазин';

		LibFactory::GetStatic('ustring');
		LibFactory::GetMStatic('catalog', 'catalogmgr');
		LibFactory::GetMStatic('catalog', 'productphotomgr');
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('cache');

		$this->_cache = new Cache();
		$this->_cache->Init('php', 'widget_announce_eshop');
	}

	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;

		parent::Init($path, $state, $params);
	}

	public function OnCitySelector()
	{
		LibFactory::GetMStatic('cities', 'citiesmgr');
		$filter = array(
			'flags' => array(
				'objects' => true,
				'withCatalog' => 1,
			),
			'field' => array(
				'Created',
			),
			'dir' => array(
				'Desc',
			),
		);

		$cities = CitiesMgr::GetInstance()->GetCities($filter);
		$delivery_list = array();
		foreach($cities as $item)
		{
			$delivery_list = $item->delivery_list;
			$dlist = array();
			foreach($delivery_list as $v)
			{
				$dlist[] = $v->Name;
			}
			if(sizeof($dlist) > 0)
				$name = implode(", ", $dlist);
			else
				$name = $item->Name;

			$deliveries[$item->ID] = $name;
		}

		// $city = App::$City != null ? App::$City : CitiesMgr::GetInstance()->GetCityInfo();
		return STPL::Fetch("widgets/eshop/cityselector", array(
			'city'   => $city,
			'cities' => $cities,
			'delivery_list' => $deliveries,
		));

	}

	public function OnCart()
	{
		return STPL::Fetch("widgets/eshop/cart", $this->_OnCart());
	}

	private function _OnCart()
	{
		$cart = CatalogMgr::GetInstance()->GetCart();

		return array(
			'price' => $cart['total_price'],
		);
	}

	public function OnMainItems()
	{
			$filter = array(
				'flags' => array(
					'CatalogID' => App::$City->CatalogId,
					'IsVisible' => 1,
					'IsMain' => 1,
					'IsAvailable' => 1,
					'with' => array('AreaRefs', 'ProductPhotos', 'Types'),
					'objects' => true,
				),
			);

			$products = CatalogMgr::GetInstance()->GetProducts($filter);
			if(sizeof($products) == 0)
				return false;

			foreach($products as $product)
			{
				// $path_url = "/catalogue/"."bla bla bla"."?all=1#!prettyPhoto[pp_gal_".$product->ID."]/0/";

				$list[] = array(
					'product' => $product,
					// 'url' => $path_url,
				);
			}

		$params = array(
			'list' => $list,
		);

		App::$Title->AddScript('/resources/scripts/modules/eshop/eshop.js');

		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/lightbox/css/lightbox.css');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/lightbox/js/lightbox.min.js');

		return STPL::Fetch('widgets/catalog/main_items', $params);
	}

	public function OnHits()
	{return false;
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/owl-carousel/owl.carousel.min.js');
		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/owl-carousel/owl.carousel.css?v=0.1.0');

		$template = "widgets/eshop/banners";
		if ($this->params['template'] != "")
			$template = $this->params['template'];
		return STPL::Fetch($template, $this->_OnHits());
	}

	private function _OnHits()
	{
		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'eshop');
		$db = DBFactory::GetInstance($config['db']);

		$nodeid = 0;
		$tree = $this->_OnTree();
		foreach($tree['childs'] as $child)
		{
			if($child->NameID === 'bouquets')
			{
				$nodeid = $child->ID;
				break;
			}

		}

		$filter = array(
			'flags' => array(
				// 'NodeID' => $current->ID,
				'IsVisible' => 1,
				'IsHit' => 1,
				'objects' => true,
			),

			'field'	=> array(
				'Ord',
			),
			'dir'	=> array(
				'ASC',
			),
			'limit' => 4,

		);

		if($nodeid > 0)
			$filter['flags']['NodeID'] = $nodeid;

		$products = EShopMgr::GetInstance()->GetProducts($filter);

		$arrProducts = array();
		foreach($products as $product)
		{
			$elements_arr = $product->GetElements();
			$arr = array();
			foreach($elements_arr as $element)
			{
				if (!$element['IsVisibleEl'])
					continue;
				$arr[] = mb_strtolower($element['Name'],'utf-8');
			}
			$compos[$product->ID] = implode(", ", $arr);
		}

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => 1,
				'PlaceID' => 1,
				'SectionID' => $this->params['sectionid'],
			),
			'field' => array('Ord'),
			'dir' => array('desc'),
		);

		$banners = BannerMgr::GetInstance()->GetBanners($filter);
		return array(
			'products' => $products,
			'banners' => $banners,
			'compos' => $compos,
		);
	}

	public function OnMobilemenu()
	{return false;
		return STPL::Fetch("widgets/eshop/mobile_menu",
			array(
				'catalog' => $this->_OnTree(),
				'menu' => $this->_OnMenu(),
		));
	}

	private function _OnMenu()
	{
		$filter = array(
			'parent' => App::$CurrentEnv['site']['treeid'],
			'type' => 2,
			'visible' => true,
			'order' => 'ord',
		);

		$iter = STreeMgr::Iterator($filter);

		foreach($iter as $node)
		{

			if($node->ID == 10)
				continue;

			$menu[$node->ID] = array(
				'url' => STreeMgr::GetLinkBySectionId($node->ID),
				'name' => $node->Name,
			);
		}

		return array(
			'menu' => $menu,
			'active' => App::$CurrentEnv['sectionid'],
			'section' => App::$CurrentEnv['section'],
		);
	}

	public function OnTree()
	{return false;
		return STPL::Fetch("widgets/eshop/tree", $this->_OnTree());
	}

	private function _OnTree()
	{
		$treeid	= $this->params['section'];

		$bl = BLFactory::GetInstance('system/config');
		$config = $bl->LoadConfig('module_engine', 'eshop');

		$db = DBFactory::GetInstance($config['db']);
		try
		{
			$tree = new EShopTreeMgr($db, $config['tables'], $config['fields']);
			$treeid = App::$City->CatalogId;
			$root = $tree->setTreeId($treeid);
		}
		catch(Exception $e)
		{
			return array();
		}

		try
		{
			$childs = $root->getChildNodes();
		}
		catch(Exception $e)
		{
			return array();
		}

		$params = array(
			'node' => $node,
			'treeid' => $treeid,
			'childs' => $childs,
			'currentnodeid' => $this->params['current'],
		);

		return $params;
	}


	protected function _getNamePath($start, ShopNodeIterator $path) {
		$base = '';
		foreach($path as $v) {
			if ($v->level <= $start->level)
				continue ;

			$base .= $v->NameID.'/';
		}
		return $base;
	}
}
