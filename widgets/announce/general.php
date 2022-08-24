<?
class Widget_announce_general extends IWidget
{
    private $_db;
    private $_tree;
    private $_cache;

    public function __construct($id)
    {
        global $OBJECTS;

        parent::__construct($id);

        $this->title = '';

        LibFactory::GetStatic('ustring');
        LibFactory::GetMStatic('catalog', 'catalogmgr');
        LibFactory::GetMStatic('banners', 'bannermgr');
        LibFactory::GetMStatic('menu', 'menumgr');
        LibFactory::GetMStatic('shares', 'sharemgr');
        LibFactory::GetStatic('filestore');
        LibFactory::GetStatic('cache');

        $this->_cache = new Cache();
        $this->_cache->Init('php', 'widget_announce_general');
    }

    public function Init($path, $state = null, $params = array())
    {
        global $OBJECTS;

        parent::Init($path, $state, $params);
    }

    public function OnMainSlider()
    {
        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'PlaceID' => 1,
            ],
            'field' => ['Ord'],
            'dir' => ['ASC'],
            'dbg' => 0,
            'calc' => true,
        ];

        list($banners, $banner_counts) = BannerMgr::GetInstance()->GetBanners($filter);

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'InSlider' => 1,
                'IsAvailable' => 1,
                'Categories' => [1, 3, 9, 10, 11, CatalogMgr::CK_FOLDER_ID, CatalogMgr::CK_ARTIFICIAL_ID],
                'CatalogID' => App::$City->catalog_id,
            ],
            'field' => ['ord', 'productid'],
            'dir' => ['asc', 'desc'],
            'calc'  => true,
            'dbg' => 0,
        ];

        $catalogMgr = CatalogMgr::GetInstance();
        list($products, $product_counts) = $catalogMgr->GetProducts($filter);

        if($banner_counts == 0 && $product_counts == 0)
            return false;

        $prices = [];
        foreach ($products as $productIndex => $product) {

            if($product->ParentId) {
                $parent = $catalogMgr->GetProduct($product->ParentId);
                $areaRefs = $parent->GetAreaRefs(App::$City->CatalogId);
                if(!$areaRefs['IsAvailable']) {
                    unset($products[$productIndex]);
                    continue;
                }
            }

            $category = $product->category;
            if($category->kind == CatalogMgr::CK_BOUQUET) {
                $isCheckDiscount = true;
                $default_type = $product->default_type;
                $prices[$product->id] = $default_type->price;
            } elseif($category->kind == CatalogMgr::CK_FIXED) {
                $isCheckDiscount = true;
                $types = $product->types;
                $prices[$product->id] = $types[0]->GetPrice();
            } elseif($category->kind == CatalogMgr::CK_WEDDING) {
                $isCheckDiscount = true;
                $types = $product->types;
                $prices[$product->id] = $types[0]->GetPrice();
            } elseif($category->kind == CatalogMgr::CK_ARTIFICIAL) {
                $prices[$product->id] = $product->getDiscountPrice(App::$City->CatalogId);
            }

            if($isCheckDiscount) {
                $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
                if($catalogMgr->hasDiscount($areaRefs)) {
                    $prices[$product->id] = $catalogMgr->getDiscountPrice($prices[$product->id]);
                }
            }

            $rangeSections = [
                CatalogMgr::CK_MONO,
                CatalogMgr::CK_ROSE,
                CatalogMgr::CK_FOLDER,
            ];

            if(in_array($category->kind, $rangeSections)) {
                $range = $product->getPriceRange(App::$City->CatalogId);
                $prices[$product->id] = $range['MinPrice'] == $range['MaxPrice'] ?
                    $range['MinPrice'] : $range['MinPrice'] . ' - ' . $range['MaxPrice'];
            }
        }

        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        $slider = $config['slider'];

        foreach ($slider as $key => $value) {
            if($slider[$key] < 1)
                $slider[$key] = 5;
            $slider[$key] *= 1000;
        }

        return STPL::Fetch("widgets/announce/general/main_slider", [
            'banners'  => $banners,
            'products' => $products,
            'prices' => $prices,
            'slider' => $slider,
        ]);
    }


    protected function OnCatalog()
    {
        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');
        $mgr = CatalogMgr::GetInstance();

        // $filter = array(
        //     'flags' => array(
        //         'objects' => true,
        //         'IsVisible' => 1,
        //         'IsAvailable' => 1,
        //         'Categories' => [1, 3, 10, 11],
        //         'CatalogID' => App::$City->catalog_id,
        //         'with' => array('AreaRefs'),
        //     ),
        //     // 'offset'=> ($page - 1) * $config['rowsonpage'],
        //     // 'limit' => $config['rowsonpage'],
        //     'field' => ['ord', 'productid'],
        //     'dir' => ['ASC', 'DESC'],
        //     'calc'  => true,
        //     'dbg' => 0,
        // );

        // list($products, $count) = CatalogMgr::GetInstance()->GetProducts($filter);

        // foreach ($products as $product) {
        //    $product->CachePrice(App::$City->catalog_id);
        // }

        // $last_page = false;
        // $pages = Data::GetNavigationPagesNumber(
        //     $config['rowsonpage'], $config['pagesonpage'], $count, $page, "?p=@p@&".$url);

        // if (empty($vars['pages']['next']))
        //     $last_page = true;


        $filter = array(
            'flags' => array(
                'IsVisible' => 1,
                'objects' => true,
                // 'CatalogID' => $this->_id,
            ),
        );
        $composition = $mgr->GetMembers($filter);
        $template = 'default';

        $cfilter = [];
        $arrFilter = [
            'flags' => [
                'isavailable' => 1,
            ],
            'field' => ['Ord'],
            'dir' => ['ASC'],
        ];
        $filter_type = $mgr->GetFilterByName('type');
        if($filter_type !== null) {
            $params = $filter_type->GetParams($arrFilter);
            // $cfilter['type']['visible'] = array_slice($params, 0, 2);
            // $cfilter['type']['hidden'] = array_slice($params, 2, count($filter_type->params) - 2);
            $cfilter['type']['visible'] = $params;
            $cfilter['type']['hidden'] = [];
        }

        $filter_whom = $mgr->GetFilterByName('whom');
        if($filter_whom !== null) {
            $params = $filter_whom->GetParams($arrFilter);
            // $cfilter['whom']['visible'] = array_slice($params, 0, 3);
            // $cfilter['whom']['hidden'] = array_slice($params, 3, count($params) - 3);
            $cfilter['whom']['visible'] = $params;
            $cfilter['flower']['hidden'] = [];
        }


        $filter_flower = $mgr->GetFilterByName('flowers');
        if($filter_flower !== null) {
            $params = $filter_flower->GetParams($arrFilter);
            // $cfilter['flower']['visible'] = array_slice($params, 0, 3);
            // $cfilter['flower']['hidden'] = array_slice($params, 3, count($params) - 3);
            $cfilter['flower']['visible'] = $params;
            $cfilter['flower']['hidden'] = [];
        }

        $filter_cause = $mgr->GetFilterByName('cause');
        if($filter_cause !== null) {
            $params = $filter_cause->GetParams($arrFilter);
            // $cfilter['cause']['visible'] = array_slice($params, 0, 3);
            // $cfilter['cause']['hidden'] = array_slice($params, 3, count($params) - 3);
            $cfilter['cause']['visible'] = $params;
            $cfilter['cause']['hidden'] = [];
        }

        return STPL::Fetch('modules/catalog/'.$template, array(
            'section'     => $section,
            // 'count'       => $count,
            // 'products'    => $products,
            'composition' => $composition,
            'filter'      => $cfilter,
            'workmode' => $this->_get_inmode(),
            'range' => $mgr->getTotalRange(App::$City->CatalogId),
        ));
    }

    protected function _OnDefault($filter) {
        $menu_node = null;

        $iter = STreeMgr::Iterator($filter);
        foreach ($iter as $node) {
            $menu_node = $node;
        }

        if (empty($menu_node)) {
            return false;
        }

        $sectionId  = $menu_node->ID;

        $menu = MenuMgr::GetInstance()->GetMenuBySectionID($sectionId);

        if(!is_array($menu) || sizeof($menu) == 0)
            return false;

        $active_item = 0;
        $url = App::$CurrentEnv['url'];

        foreach ($menu as $item) {
            if (strpos($url, $item->Link) === 0) {
                if ($item->Link == '/' && $url != '/home/')
                    continue;
                $active_item = $item->ID;
            }
        }

        $params = array(
            'menu' => $menu,
            'active' => $active_item,
        );

        return $params;
    }

    protected function OnSidebarMenu()
    {
        $this->container = 'containers/blank.tpl';
        $filter = array(
            'parent' => App::$CurrentEnv['site']['treeid'],
            // 'type' => 2,
            // 'order' => 'ord',
            // 'module' => 'menu',
            'path' => 'sidebarmenu',
        );

        $params = $this->_OnDefault($filter);

        return STPL::Fetch("widgets/menu/sidebarmenu", $params);
    }

     protected function OnFooterMenu()
    {
        $this->container = 'containers/blank.tpl';
        $filter = array(
            'parent' => App::$CurrentEnv['site']['treeid'],
            'path' => 'sidebarmenu',
        );

        $params = $this->_OnDefault($filter);
        $groups = [];
        foreach($params['menu'] as $item) {
            if($item->groupid == 0)
                continue;
            $groups[$item->groupid][] = $item;
        }

        return STPL::Fetch("widgets/menu/footermenu", ['groups' => $groups]);
    }



    protected function OnCall()
    {
        $address_list = App::$City->address;
        $contacts = $address_list[0];

        return STPL::Fetch("widgets/announce/general/call", array(
            'phone' => $contacts->Phone[0],
        ));
    }

    // protected function OnLeftMenu()
    // {
    //  $this->container = 'containers/blank.tpl';
    //  $filter = array(
    //      'parent' => App::$CurrentEnv['site']['treeid'],
    //      // 'type' => 2,
    //      // 'order' => 'ord',
    //      // 'module' => 'menu',
    //      'path' => 'leftmenu',
    //  );

    //  $params = $this->_OnDefault($filter);

    //  return STPL::Fetch("widgets/menu/leftmenu", $params);
    // }

    // protected function OnFooterMenu()
    // {
    //  $this->container = 'containers/blank.tpl';
    //  $filter = array(
    //      'parent' => App::$CurrentEnv['site']['treeid'],
    //      // 'type' => 2,
    //      // 'order' => 'ord',
    //      // 'module' => 'menu',
    //      'path' => 'topmenu',
    //  );

    //  $params = $this->_OnDefault($filter);

    //  return STPL::Fetch("widgets/menu/footermenu", $params);
    // }

    protected function OnCatalogMenu()
    {
        return STPL::Fetch("widgets/menu/catalogmenu", array(
            'catalog' => CatalogMgr::GetInstance()->getProductTypes(),
            // 'section '
        ));
    }

    // protected function OnMobileMenu()
    // {
    //     return STPL::Fetch("widgets/menu/mobilemenu", array(
    //         'catalog' => CatalogMgr::GetInstance()->getProductTypes(),
    //         'section '
    //     ));
    // }

    public function OnCart()
    {
        $cart = CatalogMgr::GetInstance()->GetCart();

        return STPL::Fetch("widgets/announce/general/cart", array(
            'cart' => $cart,
            // 'default_pm' => CatalogMgr::PM_CASH,
        ));
    }

    private function _get_inmode()
    {
        $inmode = CatalogMgr::GetInstance()->InMode();

        LibFactory::GetStatic('bl');
        $bl = BLFactory::GetInstance('system/config');
        $config = $bl->LoadConfig('module_engine', 'catalog');

        return [
            'inmode' => $inmode,
            'notice' => $config['noorder_text'],
        ];
    }

    public function OnPhone()
    {
        $phone = App::$City->Phone;

        return STPL::Fetch("widgets/announce/general/phone", array(
            'phone' => $phone,
        ));
    }

}
