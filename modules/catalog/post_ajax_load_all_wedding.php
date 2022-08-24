<?
 	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$filter = [
        'flags' => [
            'CatalogID' => App::$City->CatalogId,
            'all' => true,
            'IsVisible' => 1,
            'Categories' => [9],
            'with' => array('AreaRefs'),
            'objects' => true,
        ],
        'field' => ['Ord'],
        'dir' => ['ASC'],
        'dbg' => 0,
        'calc' => true,
    ];

    list($products, $list) = $this->catalogMgr->GetProducts($filter);

    echo $json->encode(array(
		'status' => 'ok',
        'action' => 'all_weddings',
		'list' => STPL::Fetch('modules/catalog/products/_wedding_list', ['products' => $products]),
	));

    exit;