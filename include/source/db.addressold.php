<?php

function source_db_address($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location_v3');
	Location_V3::SetLimit(20);

	$result = array();
	switch($params['type']) {

		case 'country_list':
			Location_V3::SetLimit(0);
			$result['list'] = Location_V3::GetCountries(null, -1);
			foreach($result['list'] as &$v)
				$v = array(
					'Name' => $v['Name'],
					'Code' => $v['Code'],
				);
		break;

		case 'city_list':
			$code = Location_V3::ParseCode($params['code']);
			$query = App::$Request->Post['query']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
			
			$region = -1;
			if(isset($code['region']) && $code['region'] != '000')
				$region = $code['region'];

			if ( !empty($query) ) {

				$query = iconv('UTF-8', 'WINDOWS-1251', $query);

				$result['list'] = Location_V3::GetObjectsByName($query,
					$code['continentcode'], $code['countrycode'], $region, null, -1 );
			} else {

				Location_V3::SetLimit(0);
				$count = Location_V3::GetCitiesCount(
					$code['continentcode'], $code['countrycode'], $region, 0, -1, 1);

				if ( $count )
					$result['list'] = Location_V3::GetCities(
						$code['continentcode'], $code['countrycode'], $region, 0, -1, 1);
				else
					$result['list'] = Location_V3::GetCities(
						$code['continentcode'], $code['countrycode'], $region, 0, -1);

			}

			foreach($result['list'] as $k => $v) {

				$pc = Location_V3::ParseCode($v['Code']);			
				$Desc = array();
				if ( $pc['placecode'] != '000' ) {
					$pc['placecode'] = '000';
					$Desc[] = Location_V3::GetObjectByCode(implode('', $pc));
				
					if ( $pc['citycode'] == '000' ) {

						$pc['regioncode'] = '000';
						$Desc[] = Location_V3::GetObjectByCode(implode('', $pc));
					} else {
						$pc['citycode'] = '000';
						$Desc[] = Location_V3::GetObjectByCode(implode('', $pc));
					}
				} else if ( $pc['citycode'] != '000' ) {
					$pc['citycode'] = '000';
					$Desc[] = Location_V3::GetObjectByCode(implode('', $pc));
					
					if ( $pc['regioncode'] != '000' ) {
						$pc['regioncode'] = '000';
						$Desc[] = Location_V3::GetObjectByCode(implode('', $pc));
					}
				}

				$result['list'][$k] = array(
					'FullName' => $v['FullName'],
					'Name' => $v['Name'],
					'Code' => $v['Code'],
				);
				
				foreach($Desc as $k1 => $v1)
					$Desc[$k1] = $v1[0]['FullName'];
				
				$result['list'][$k]['Desc'] = $Desc;
			}

		break;

		case 'region_list':
			Location_V3::SetLimit(0);
			$code = Location_V3::ParseCode($params['code']);
			$result['list'] = Location_v3::GetAreas($code['continentcode'], $code['countrucode'], $code['region'], $code['regioncode'], $code['citycode'], $code['placecode']);
			foreach($result['list'] as &$v)
				$v = array(
					'Name' => $v['Name'],
					'Code' => $v['Code'],
				);
		break;

		case 'street_list':
			
			$code = Location_V3::ParseCode($params['code']);
			$query = App::$Request->Post['query']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
			if ( !empty($query) ) {

				$query = iconv('UTF-8', 'WINDOWS-1251', $query);

				$result['list'] = Location_V3::GetStreetsByName($query,
					$code['continentcode'], $code['countrycode'], $code['region'], $code['regioncode'], $code['citycode'], $code['placecode']);
			} else {
				//error_log(var_export($code,true));
				$result['count'] = Location_v3::GetStreetsCount($code['continentcode'], $code['countrycode'], $code['region'], $code['regioncode'], $code['citycode'], $code['placecode']);

				Location_V3::SetLimit(200);
				if ( $result['count'] <= 200 )
					$result['list'] = Location_v3::GetStreets($code['continentcode'], $code['countrycode'], $code['region'], $code['regioncode'], $code['citycode'], $code['placecode']);
				else
					$result['list'] = array();
			}
			foreach($result['list'] as &$v)
				$v = array(
					'Name' => $v['FullName'],//.' '.$v['Socr'].'.',
					'Code' => $v['Code'],
				);

		break;
	}

//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';
//
//	exit(
//		$json->encode($result)
//	);
//error_log(var_export($result,true));
	return $result;
}

?>
