<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();


    $key  = App::$Request->Post['key']->Value(Request::OUT_HTML_CLEAN);

    $catalogid = App::$City->CatalogId;
    $filter = array(
        'flags' => array(
            'objects' => true,
            'CatalogID' => $catalogid,
            'all' => true,
            'IsVisible' => 1,
            'with' => array('AdditionAreaRefs'),
        ),
        // 'offset'=> ($add_page - 1) * $this->_config['add_rowsonpage'],
        // 'limit' => $this->_config['add_rowsonpage'],
        'field' => ['ord'], //'TypeID',
        'dir' => ['ASC'],
        'dbg' => 0,
        'calc' => true,
    );

    $carts_additions = $this->catalogMgr->GetCart()['items'][$key]['additions'];
    $carts_additions = array_keys($carts_additions);

    list($additions, $add_count) = $this->catalogMgr->GetAdditions($filter);

    echo $json->encode(array(
        'status' => 'ok',
        'action' => 'all_adds',
        'list' => STPL::Fetch('modules/catalog/detail/_additions', ['additions' => $additions, 'carts_additions' => $carts_additions]),
        'last_page' => true,
    ));

    exit;