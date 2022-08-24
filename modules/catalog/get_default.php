<?
    LibFactory::GetStatic('bl');
    LibFactory::GetMStatic('blocks', 'blockmgr');
    LibFactory::GetMStatic('banners', 'bannermgr');
    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    // ================================
    $path = trim($this->_params['path'], "/");

    if(empty($path)) {
        Response::Status(404, RS_SENDPAGE | RS_EXIT);
    }

    $catalog = $this->catalogMgr->GetCatalogByLinkName($path);
    if($catalog === null) {
        Response::Status(404, RS_SENDPAGE | RS_EXIT);
    }

    $settings = $this->catalogMgr->GetSectionSettings($catalog['section']['id']);
    $kind = $catalog['section']['kind'];
    // ================================

    // $cause_filter = CatalogMgr::GetInstance()->GetFilterByName('cause');
    // $color_filter = CatalogMgr::GetInstance()->GetFilterByName('colors');
    // $flower_filter = CatalogMgr::GetInstance()->GetFilterByName('flowers');
    $page = 1;

    $filter = array(
        'flags' => array(
            'objects' => true,
            'IsAvailable' => 1,
            'TypeID' => $catalog['section']['id'],
        ),
        // 'offset'=> ($page - 1) * $config['rowsonpage'],
        // 'limit' => $config['rowsonpage'],
        'field' => ['ord', 'productid'],
        'dir' => ['asc', 'desc'],
        'calc'  => true,
        'dbg' => 0,
    );

    // if($kind == CatalogMgr::CK_WEDDING) {
    //     $filter['offset' ] = ($page - 1) * $config['rowsonpage'];
    //     $filter['limit'] = $config['rowsonpage'];
    // }

    list($products, $count) = CatalogMgr::GetInstance()->GetProducts($filter);




    $last_page = false;
    // $pages = Data::GetNavigationPagesNumber(
    //     $config['rowsonpage'], $config['pagesonpage'], $count, $page, "?p=@p@&".$url);

    if (empty($vars['pages']['next']))
        $last_page = true;

    $template = CatalogMgr::$CTL_KIND[$kind]['nameid'];


    $header_block = BlockMgr::getInstance()->GetBlockByNameID(strtoupper($template).'_HEADER');

    $banner = BannerMgr::getInstance()->GetBannersByPlaceID(CatalogMgr::$CTL_KIND[$kind]['placeid']);
    if(is_array($banner) && count($banner) > 0) {
        $banner = $banner[0];
    }


    $params = CatalogMgr::getInstance()->GetCategory($catalog['section']['id']);

    App::$Title->Title = $params->SeoTitle;
    App::$Title->Description = strip_tags(UString::ChangeQuotes($params->SeoDescription));
    App::$Title->Keywords = strip_tags(UString::ChangeQuotes($params->SeoKeywords));


    return STPL::Fetch('modules/catalog/products/'.$template, array(
        'section'   => $catalog['section'],
        'products'  => $products,
        'last_page' => $last_page,
        'header_block' => $header_block['Text'],
        'banner'    => $banner,
    ));