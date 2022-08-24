<?php

function source_db_location_v3($params) 
{
	global $OBJECTS;
	LibFactory::GetStatic('location_v3');
	
	$data = array();
	
	// типы для снт и гск
	$gg_types = array(
		'garden' => array(12, 75, 92), // дп, сад, снт
		'garage' => array(86) // гск
	);
	
	switch($params['type']) {
	
/* поиск по коду */
	
		// поиск всех населённых пунктов области
		// citycode - код областного центра (города) для определения continentcode, countrycode и т.д.
		// code - можно задавать код конкретного насел. пункта
		// imp - важность
		// exception_codes - массив исключений, содержит Code насел. пунктов, которые нужно исключить из выборки
		case 'city_search':
			$citycode = $params['citycode']; // код областного центра
			$code = isset($params['code']) ? $params['code'] : null; // код насел. пункта
			$types = (isset($params['types']) && is_array($params['types'])) ? $params['types'] : null;
			$imp = isset($params['imp']) ? $params['imp'] : -1;
			$exception_codes = isset($params['exception_codes']) ? $params['exception_codes'] : null;
			$is_reverce = isset($params['is_reverce']) ? $params['is_reverce'] : 1; // прямой или обратный порядок
			$cut_last_cnt = isset($params['cut_last_cnt']) ? $params['cut_last_cnt'] : 2; // кол-во отсекаемых элементов
			
			if(null !== $code)
			{
				$dc = Location_v3::ParseCode($code);
				$data = Location_v3::GetPlaces($dc['continentcode'], $dc['countrycode'], $dc['region'], $dc['regioncode'], $dc['citycode'], $dc['placecode'], $types, $imp);
			}
			else {
				$pc = Location_v3::ParseCode($citycode);
				$data = Location_v3::GetPlaces($pc['continentcode'], $pc['countrycode'], $pc['region'], null, -1, null, $types, $imp);
			}

			foreach($data as $k => $v)
			{
				if(null !== $exception_codes && in_array($v['Code'], $exception_codes))
					unset($data[$k]);
				else {
					$full_info = Location_v3::GetFullInfo($v['Code']);

					$s_full = _full_info_to_str($full_info, $is_reverce, $cut_last_cnt);

					$np = end($full_info);

					// проверка, есть ли у насел. пункта районы
					if(Location_v3::GetAreasCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_areas = 1;
					else
						$is_areas = 0;
						
					// проверка, есть ли у насел. пункта улицы
					if(Location_v3::GetStreetsCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_streets = 1;
					else
						$is_streets = 0;
					
					$data[$k]['full_str'] = $s_full;
					$data[$k]['is_areas'] = $is_areas;
					$data[$k]['is_streets'] = $is_streets;
				}
			}
		break;
		
		// поиск объектов, подчинённых code
		case 'object_search':
			$code = $params['Code'];
			$types = (isset($params['types']) && is_array($params['types'])) ? $params['types'] : null;
			$imp = isset($params['imp']) ? $params['imp'] : -1;
			$exception_codes = isset($params['exception_codes']) ? $params['exception_codes'] : null;
			$is_reverce = isset($params['is_reverce']) ? $params['is_reverce'] : 1; // прямой или обратный порядок
			$cut_last_cnt = isset($params['cut_last_cnt']) ? $params['cut_last_cnt'] : 2; // кол-во отсекаемых элементов
			
			// отключающие флаги
			$no_full_info = isset($params['no_full_info']) ? true : false;
			$no_areas = isset($params['no_areas']) ? true : false;
			$no_streets = isset($params['no_streets']) ? true : false;
			
			$pc = Location_v3::ParseCode($code);
			
			$data = Location_v3::GetPlaces($pc['continentcode'], $pc['countrycode'], $pc['region'], null, null, null, $types, $imp);
			
			foreach($data as $k => $v)
			{
				if(null !== $exception_codes && in_array($v['Code'], $exception_codes))
					unset($data[$k]);
				else {
					if(!$no_full_info)
					{
						$full_info = Location_v3::GetFullInfo($v['Code']);

						$s_full = _full_info_to_str($full_info, $is_reverce, $cut_last_cnt);

						$np = end($full_info);
					}
					else
						$np = $v;
					
					// проверка, есть ли у насел. пункта районы
					if(!$no_areas && Location_v3::GetAreasCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_areas = 1;
					else
						$is_areas = 0;
						
					// проверка, есть ли у насел. пункта улицы
					if(!$no_streets && Location_v3::GetStreetsCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_streets = 1;
					else
						$is_streets = 0;
					
					$data[$k]['full_str'] = $s_full;
					$data[$k]['is_areas'] = $is_areas;
					$data[$k]['is_streets'] = $is_streets;
				}
			}
		break;
		
		// поиск гск и снт, подчинённых code
		case 'gg_search':
			$code = $params['Code'];
			$obj = $params['obj'];  // ключ "garden" или "garage"
			
			if ( !$code || !$obj )
				exit('');
			
			$pc = Location_v3::ParseCode($code);
			
			$data = Location_v3::GetPlaces($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], $gg_types[$obj]);
			
			if(null === $data || !sizeof($data))
				$data = Location_v3::GetStreets($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], null, $gg_types[$obj]);
		break;
		
		// поиск всех улиц населённого пункта
		case 'street_search':
			$code = $params['Code']; // код населённого пункта
			
			$use_gg = isset($params['use_gg']) ? $params['use_gg'] : false; // использовать гск и снт в выборке
			$types = $use_gg ? null : array('not_in' => array_merge($gg_types['garage'], $gg_types['garden']));
			
			if(isset($params['types']))
				$types['in'] = $params['types'];
			
			$pc = Location_v3::ParseCode($code);
			
			$data = Location_v3::GetStreets($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], null, $types);
		break;
		
		// выборка районов насел. пункта
		case 'getregions':
			$code = $params['Code'];
				
			$pc = Location_v3::ParseCode($code);
			
			$data = Location_V3::GetAreas($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode']);
		break;
		
		// получение лимитированного списка объектов (например, для блоков множественного выбора в realty, где есть постраничная навигация внутри блока)
		case 'getobjects': 
			$code = $params['Code'];
			$obj = $params['obj']; // 'street', 'garden', 'garage'
			$types = $params['types'];

			$limit = $params['limit'];
			$offset = $params['offset'];
			
			$pc = Location_V3::ParseCode($code);
			
			if(null !== $pc)
			{
				$curr_limit = Location_V3::GetLimit();
				Location_V3::SetLimit($limit);

				$curr_offset = Location_V3::GetOffset();
				Location_V3::SetOffset($offset);

				$data = Location_V3::GetStreets($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], null, $types);
				
				if(null === $data && $obj != 'street')
					$data = Location_V3::GetPlaces($pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], $types);

				Location_V3::SetLimit($curr_limit);
				Location_V3::SetOffset($curr_offset);
			}
		break;
		
		// получение в одну строку полной информации об объекте по Code
		// fl_need_full - нужна ли информация по FullInfo
		case 'get_fullinfo_to_str':
			$fl_need_full = isset($params['fl_need_full']) ? $params['fl_need_full'] : false;
			$is_reverce = isset($params['is_reverce']) ? $params['is_reverce'] : 1; // прямой или обратный порядок
			$cut_last_cnt = isset($params['cut_last_cnt']) ? $params['cut_last_cnt'] : 2; // кол-во отсекаемых элементов

			$code = $params['Code'];
			
			$full_info = Location_v3::GetFullInfo($code);

			$data['full_string'] = _full_info_to_str($full_info, $is_reverce, $cut_last_cnt);
			
			if($fl_need_full)
				$data['full_info'] = $full_info;
		break;
		
/* поиск по названию */
		
		// поиск по названию насел. пункта
		case 'city_search_by_name':
			$city_name = $params['name'];
			$code = $params['citycode'];
			$types = (isset($params['types']) && is_array($params['types'])) ? $params['types'] : null;
			$exception_codes = isset($params['exception_codes']) ? $params['exception_codes'] : null;
			$is_reverce = isset($params['is_reverce']) ? $params['is_reverce'] : 1; // прямой или обратный порядок
			$cut_last_cnt = isset($params['cut_last_cnt']) ? $params['cut_last_cnt'] : 2; // кол-во отсекаемых элементов
			
			if (!$city_name || !$code)
				exit('');
		
			$pc = Location_v3::ParseCode($code);
			
			$data = Location_v3::GetObjectsByName($city_name, $pc['continentcode'], $pc['countrycode'], $pc['region'], null, null, null, $types);
			
			foreach($data as $k => $v)
			{
				if(null !== $exception_codes && in_array($v['Code'], $exception_codes))
					unset($data[$k]);
				else {
					$full_info = Location_v3::GetFullInfo($v['Code']);
					
					$s_full = _full_info_to_str($full_info, $is_reverce, $cut_last_cnt);
					
					$np = end($full_info);
					
					// проверка, есть ли у насел. пункта районы
					if(Location_v3::GetAreasCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_areas = 1;
					else
						$is_areas = 0;
						
					// проверка, есть ли у насел. пункта улицы
					if(Location_v3::GetStreetsCount($np['ContinentCode'], $np['CountryCode'], $np['Region'], $np['RegionCode'], $np['CityCode'], $np['PlaceCode']) > 0)
						$is_streets = 1;
					else
						$is_streets = 0;
					
					$data[$k]['full_str'] = $s_full;
					$data[$k]['is_areas'] = $is_areas;
					$data[$k]['is_streets'] = $is_streets;
				}
			}
		break;
		
		// поиск снт и гск по названию
		case 'gg_search_by_name':
			$gg_name = $params['name'];
			$code = $params['Code'];
			$obj = $params['obj'];  // ключ "garden" или "garage"

			if ( !$gg_name || !$code || !$obj )
				exit('');

			$pc = Location_v3::ParseCode($code);

			$data = Location_v3::GetObjectsByName($gg_name, $pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], $gg_types[$obj]);

			if(null === $data || !sizeof($data))
				$data = Location_v3::GetStreetsByName($gg_name, $pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], $gg_types[$obj]);
		break;

		case 'street_search_by_name':
			$street_name = $params['name'];
			$code = $params['Code']; // код населённого пункта
			
			$use_gg = isset($params['use_gg']) ? $params['use_gg'] : false; // использовать гск и снт в выборке
			$types = $use_gg ? null : array('not_in' => array_merge($gg_types['garage'], $gg_types['garden']));
			
			if(isset($params['types']))
				$types['in'] = $params['types'];
			
			if ( !$street_name || !$code ) 
				exit('');

			$pc = Location_v3::ParseCode($code);
			
			$data = Location_v3::GetStreetsByName($street_name, $pc['continentcode'], $pc['countrycode'], $pc['region'], $pc['regioncode'], $pc['citycode'], $pc['placecode'], $types);
		break;
	}
	
	return $data;
}



/* *
*
* Получение полного имени в одну строку - в обратном порядке, чтоб соответствовало набору в suggest'е
*
* @author Шайтанова Валентина
* @return string
* @param full_info array массив с полной информацией об объекте
* @param is_reverce bool флаг, показывающий, идти по массиву в "прямом" порядке (0) или в обратном (1)
* @param cut_last_cnt int кол-во "отсекаемых" элементов (для отключения страны и материка)
*
*/
function _full_info_to_str($full_info, $is_reverce = 1, $cut_last_cnt = 2)
{
	$s_full = '';
	 
	if(is_array($full_info) && is_numeric($is_reverce))
	{
		if($is_reverce)
		{
			for($i = count($full_info) - 1; $i >= $cut_last_cnt; $i--)
			{
				$s_full .= $full_info[$i]['FullName'].', ';
			}
		}
		else {
			for($i = $cut_last_cnt; $i < count($full_info); $i++)
			{
				$s_full .= $full_info[$i]['FullName'].', ';
			}
		}
		
		$s_full = substr($s_full, 0, strlen($s_full) - 2);
	}

	return $s_full;
}

?>