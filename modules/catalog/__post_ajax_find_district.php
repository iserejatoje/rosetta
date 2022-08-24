<?
	include_once $CONFIG['engine_path'].'include/json.php';
	$json = new Services_JSON();

	$district = App::$Request->Post['district']->Value(Request::OUT_HTML_CLEAN | Request::OUT_CHANGE_NL);

	if (strlen($district) == 0) {
		echo $json->encode(array(
			'status' => 'error',
		));
		exit;
	}

	LibFactory::GetMStatic('catalog', 'catalogmgr');
	$cityMgr = CitiesMgr::GetInstance();

	$filter = array(
		'flags' => array(
			'IsAvailable' => 1,
			'CityID' => App::$City->ID,
		),
		'filter' => array(
			'fields' => array(
				'GeoName' => 'GeoName',
			),
			'query' => $district,
		),
		'limit' => 1,
	);

	$deliveryDistricts = $cityMgr->GetDistricts($filter);

	if ($deliveryDistricts === false) {
		echo $json->encode(array(
			'status' => 'not found',
		));
		exit;
	}

	echo $json->encode(array(
		'status' => 'ok',
		'district' => $deliveryDistricts[0],
	));
	exit;