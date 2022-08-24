<?php

function source_db_address($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location');

	$result = array();
	switch($params['type']) {

		case 'country_list':

			$filter['ContinentCode'] = null;
			$filter['CountryCode'] = -1;
			$result['list'] = Location::GetObjects($filter);
			unset($filter);
			
			foreach($result['list'] as &$v)
			{
				$v = array(
					'Name' => $v['Name'],
					'Code' => $v['Code'],
				);
			}
		break;
		case 'city_list':
			$code = Location::ParseCode($params['code']);
								
			$query = App::$Request->Post['query']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);

			$region = -1;
			if(isset($code['RegionCode']) && $code['RegionCode'] != '000')
				$region = $code['RegionCode'];

			if ( !empty($query) ) {

				$query = iconv('UTF-8', 'WINDOWS-1251', $query);

				// Получить объекты по имени.	
				$code['Name'] = $query;
				$code['RegionCode'] = $region;
				$code['DistrictCode'] = null;
				$code['CityCode'] = -1; 
				$code['StreetCode'] = '0000';
				$result['list'] = Location::GetObjects($code);
			} else {

				$code['RegionCode'] = $region;
				$code['DistrictCode'] = 0;
				$code['CityCode'] = -1;
				$code['Important'] = true;
				
				$page['street_count'] = Location::GetObjectsCount($code);

				if ( $count )
				{
					$code['RegionCode'] = $region;
					$code['DistrictCode'] = 0;
					$code['CityCode'] = -1;
					$code['Important'] = true;
					$result['list'] = Location::GetObjects($code);
				}		
				else
				{
					$code['RegionCode'] = $region;
					$code['DistrictCode'] = 0;
					$code['CityCode'] = -1;
					$result['list'] = Location::GetObjects($code);
				}
			}

			foreach($result['list'] as $k => $v) {

				$pc = Location::ParseCode($v['Code']);			
				$Desc = array();
				if ( $pc['VillageCode'] != '000' ) {
					$pc['VillageCode'] = '000';

					$Desc[] = Location::GetObjects(Location::ParseCode(implode('', $pc).'0000'));					
				
					if ( $pc['CityCode'] == '000' ) {

						$pc['DistrictCode'] = '000';

						$Desc[] = Location::GetObjects(Location::ParseCode(implode('', $pc).'0000'));						
					} else {
						$pc['CityCode'] = '000';

						$Desc[] = Location::GetObjects(Location::ParseCode(implode('', $pc).'0000'));						
					}
				} else if ( $pc['CityCode'] != '000' ) {
					$pc['CityCode'] = '000';

					$Desc[] = Location::GetObjects(Location::ParseCode(implode('', $pc).'0000'));					
					if ( $pc['DistrictCode'] != '000' ) {
						$pc['DistrictCode'] = '000';
						$Desc[] = Location::GetObjects(Location::ParseCode(implode('', $pc).'0000'));
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
			$code = Location::ParseCode($params['code']);

			$result['list'] = Location::GetAreas($code);
			
			foreach($result['list'] as &$v)
			{
				$v = array(
					'Name' => $v['Name'],
					'Code' => $v['Code'],
				);
			}
		break;
		
		case 'street_list':

			$code = Location::ParseCode($params['code']);
		 	$code['StreetCode'] = -1;
			//error_log(var_export($code,true));
			
			$query = App::$Request->Post['query']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
			if ( !empty($query) ) {

				$query = iconv('UTF-8', 'WINDOWS-1251', $query);
				// Получить объекты по имени.
				$code['Name'] = $query;
				$result['list'] = Location::GetObjects($code);
					
			} else {
			//	error_log(var_export($code,true));
				$result['count'] = Location::GetObjectsCount($code);
				
				if ( $result['count'] <= 200 )
				{
					$code['limit'] = 200;
					$result['list'] = Location::GetObjects($code);
				}
				else
				{
					$result['list'] = array();
				}
			}
			
			foreach($result['list'] as &$v)
			{
				$v = array(
					'Name' => $v['FullName'],//.' '.$v['Socr'].'.',
					'Code' => $v['Code'],
				);
			}

		break;
	}
	
	return $result;
}

?>
