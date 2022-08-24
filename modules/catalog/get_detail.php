<?

    $config = $this->_config;
    $product = $this->catalogMgr->GetProduct($this->_params['id']);

    if($product === null)
        Response::Status(404, RS_SENDPAGE | RS_EXIT);

    App::$Title->Title = strip_tags(UString::ChangeQuotes($product->SeoTitle)) ?: $product->Name;
    App::$Title->Description = strip_tags(UString::ChangeQuotes($product->SeoDescription));
    App::$Title->Keywords = strip_tags(UString::ChangeQuotes($product->SeoKeywords));

    $catalogid = App::$City->CatalogId;

    $category = $product->category;
    $areaRefs = $product->GetAreaRefs($catalogid);
    // if($areaRefs['IsVisible'] == 0 || $areaRefs['IsAvailable'] == 0)
    //     Response::Status(404, RS_SENDPAGE | RS_EXIT);

    $filter = [
        'flags' => [
            'objects' => true,
            'IsVisible' => true,
            'CategoryID' => $category->id,
            'CatalogID' => $catalogid,
        ],
    ];

    $add_page = 1;
    $filter = array(
        'flags' => array(
            'objects' => true,
            'CatalogID' => $catalogid,
            'all' => true,
            'IsVisible' => 1,
            'with' => array('AdditionAreaRefs'),
        ),
        'field' => ['ord'],
        'dir' => ['asc'],
        'offset'=> ($add_page - 1) * $this->_config['add_rowsonpage'],
        'limit' => $this->_config['add_rowsonpage'],

        'dbg' => 0,
        'calc' => true,
    );

    list($additions, $add_count) = $this->catalogMgr->GetAdditions($filter);

    $add_pages = Data::GetNavigationPagesNumber(
            $this->_config['add_rowsonpage'], $this->_config['add_pagesonpage'], $add_count, $add_page, "?p=@p@");

    $settings = $this->catalogMgr->GetSectionSettings($category->id);

    $template = CatalogMgr::$CTL_KIND[$category->kind]['nameid'];

    $params = [
        'product'   => $product,
        'category'  => $category,
        'additions' => $additions,
        'template'  => $template,
        'add_pages' => $add_pages,
    ];

    if($category->kind == CatalogMgr::CK_BOUQUET)
    {
        $types = $product->getTypes($catalogid);
        $default_type = $product->default_type;

        $params['types']       = $types;
        // $params['composition'] = $product->compositiontext;
        $params['price'] = $default_type->price;
    } elseif($category->kind == CatalogMgr::CK_MONO) {
        $types = $product->types;

        $composition = $types[0]->compositions;

        $params['type']       = $types[0];
        $params['composition'] = $composition;
        // $params['composition'] = $compositiontext;
        $params['price'] = $types[0]->GetPrice();
        $params['min'] = isset($config['mono_params']['min']) ? $config['mono_params']['min'] : 1;
        $params['step'] = isset($config['mono_params']['step']) ? $config['mono_params']['step'] : 1;
    } elseif($category->kind == CatalogMgr::CK_ROSE) {
        $lens = $product->GetLens();        

        $params['lens'] = $lens;
        $params['default_len'] = $product->GetDefaultLen();
        $params['price'] = $product->GetPrice();

        $params['min'] = isset($config['rose_params']['min']) ? $config['rose_params']['min'] : 1;
        $params['step'] = isset($config['rose_params']['step']) ? $config['rose_params']['step'] : 1;
    } elseif($category->kind == CatalogMgr::CK_FIXED) {
        $types = $product->types;
        // $composition_str = $types[0]->str_compositions;
        $params['price'] = $types[0]->GetPrice();
        // $params['composition'] = $composition_str;
        // $params['composition'] = $product->compositiontext;
    } elseif($category->kind == CatalogMgr::CK_WEDDING) {
        $types = $product->types;
        $params['price'] = $types[0]->GetPrice();
        // $params['composition'] = $product->compositiontext;
    }

    if($this->catalogMgr->hasDiscount($areaRefs)) {
        $params['price'] = $this->catalogMgr->getDiscountPrice($params['price'], $product, $catalogId);
    }

    return STPL::Fetch('modules/catalog/detail', $params);