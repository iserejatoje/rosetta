<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $params     = App::$Request->Post['params']->AsArray([]);
    $sections   = App::$Request->Post['sections']->AsArray([]);
    $from       = App::$Request->Post['minprice']->Int(0, Request::UNSIGNED_NUM);
    $to         = App::$Request->Post['maxprice']->Int(0, Request::UNSIGNED_NUM);
    $categoryid = App::$Request->Post['categoryid']->Int(-1, Request::UNSIGNED_NUM);
    $page       = App::$Request->Post['page']->Int(0, Request::UNSIGNED_NUM);

    LibFactory::GetStatic('bl');
    $bl = BLFactory::GetInstance('system/config');
    $config = $bl->LoadConfig('module_engine', 'catalog');

    /*
        пришлось изменить алгоритм фильтрации, чтобы она влияла на отображение папок.
        БЫЛО: выборка учитывает цветы в букете" -> товары фильтруются по цене в SlicePrice -> из вернувшихся id формируется конечная выборка
        Для фильтрации папок нужно:
            - фильтровать по цене потомков, а не папки
            - фильтровать по цветам в букете папку, а не потомков
            - фильтровать по наличию и потомков, и папки
        СТАЛО: выборка всех видимых букетов/папок -> фильтрация по цене (при parentId > 0 в результирующий массив добавляется id родителя, массив чистится от дубликатов)
                -> из вернувшихся id, наличия и цветов в наличии формируется конечная выборка
    */

    // фильтрация по цене
    $filter = [
        'flags' => [
            // 'TypeID' => $categoryid,
            'Categories' => [1, 3, 10, 11, 12],
            'CatalogID' => App::$City->CatalogId,
            // 'all' => true,
            'IsVisible' => 1,
            'IsAvailable' => 1,
            'with' => array('AreaRefs'),
            'objects' => true,
        ],

        'field' => ['ord', 'productid'], //'TypeID',
        'dir' => ['ASC', 'DESC'],  //'DESC',
        'dbg' => 0,
    ];

    // if(count($params) > 0) {
    //     $filter['flags']['params'] = $params;
    // }


    if(count($sections) > 0)
        $filter['flags']['sections'] = $sections;

    if($categoryid > 0) {
        $filter['flags']['TypeID'] = $categoryid;
        $category = $this->catalogMgr->GetCategory($categoryid);
        $kind = $category->kind;
    }

    $products = $this->catalogMgr->GetProducts($filter);

    // foreach ($products as $product) {
    //    $product->CachePrice(App::$City->catalog_id);
    // }

    if($from > 0 || $to > 0) {
        $pids = $this->catalogMgr->SlicePrice($products, $from, $to);

        if(!is_null($pids)) {
            $temp_count = $pids;
            $filter = [
                'flags' => [
                    'objects' => true,
                    'filtered' => $pids,
                    'IsVisible' => 1,
                    'IsAvailable' => 1,
                ],
                'dbg' => 0,
                'calc' => true,
                'field' => ['ord', 'productid'], //'TypeID',
                'dir' => ['ASC', 'DESC'],  //'DESC',
                // 'offset'=> ($page - 1) * $config['rowsonpage'],
                // 'limit' => $config['rowsonpage'],
            ];

            if(count($params) > 0) {
                $filter['flags']['params'] = $params;
            }

            list($products, $count) = $this->catalogMgr->GetProducts($filter);

            $last_page = false;
            // $pages = Data::GetNavigationPagesNumber(
            // $config['rowsonpage'], $config['pagesonpage'], $count, $page, "?p=@p@&".$url);

            // if (empty($pages['next']))
            //     $last_page = true;

        } else {
            $products = false;
        }
    }

    // ==========================================================================

    $params['products'] = $products;
    empty($params['products'])?
        $list = '<span class="not-found">Нет товаров c заданными критериями</span>' :
        $list =  STPL::Fetch('modules/catalog/products/_product_list', $params);

    // ==========================================================================
    echo $json->encode(array(
        'status' => 'ok',
        'list' => $list,
        'count' => $count,
        'last_page' => $last_page,

    ));
    exit;
