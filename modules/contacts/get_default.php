<?

	$stores = App::$City->stores;

    $types = [];
    foreach($stores as $store) {
        if($store->Type == 0)
            continue;

        $types[$store->Type][] = $store;
    }

    return STPL::Fetch('modules/contacts/default', array(
    	'city' => App::$City,
		'types' => $types,
    ));