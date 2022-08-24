<?php

function source_db_location_inline($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location');

	$result = array();
	
	switch ( $params['type'] )
	{
		case 'query':
			
			$filter = array(
				'Type'	=> array(),
				//'level'	=> false,
			);
			
			if (is_string($params['type_in']) && $params['type_in'])
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
				
			if (!isset($params['level']))
				$params['level'] = false;
				
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);
			
			global $OBJECTS;
			
			$pc = Location::ParseCode($params['parent']);
			$cur_level = false;

			$res = Location::GetObjects($pc);
			
			if (is_array($res) && sizeof($res))
			{
				if ($res[0]['Type'] == 2 && $params['level'] == 4)
				{
					$filter['OtherCodes'] = array($params['parent']);
				}
				else if ($res[0]['Type'] == 2 && $params['level'] == 6)
				{
					$cur_level = 6;
				}
			}
			
			if( $pc['ContinentCode'] == '000' )
			{
				list($data,$result['count']) = Location::GetObjects($filter, true);
			}
			else
			{
				list($data,$result['count']) = Location::GetSubordinateObjects($params['parent'], $filter, $cur_level/*$params['level']*/, true);	
			}
			

			$result['list'] = array();			
			foreach ( $data as $v )
			{
				$item = array(
					'id'		=> $v['Code'],
					'name'		=> $v['FullName'],
					'type'		=> $v['Type'],
				);

				$v['Code'] = Location::ParseCode($v['Code']);	
				$v['Level'] = Location::ObjectLevel($v['Code']);
				
				$parent = array();
				//if ( Location::OL_REGIONS == $v['Level'] || Location::OL_CITIES == $v['Level'] || Location::OL_VILLAGES == $v['Level'] || Location::OL_STREETS == $v['Level'] )
				//{
					$object = Location::GetParentObject($v['Code']);
					//error_log($object[0]['TransName']);
					if ( sizeof($object) )
						$parent = array(
							$object[0]['FullName']
						);					
				//}
				
				if ( is_array($object[0]) )// && (Location::OL_VILLAGES == $v['Level'] || Location::OL_VILLAGES == Location::ObjectLevel(Location::ParseCode($object[0]['Code'])))  )
				{
					$object = Location::GetParentObject(Location::ParseCode($object[0]['Code']));
					if ( sizeof($object) )
						$parent = array(
							$object[0]['FullName'],
							$parent[0],
						);
				}
				
				if ( sizeof($parent) )
				{
					$item['parent'] = $parent;
					
					// не берем объекты, для которых не удалось определить родителя
					$result['list'][] = $item;
				}
			}
		break;
	
		case 'query_suggest':

			if ( empty($params['query']) )
				break;
			
			$filter = array(
				'Type'	=> array(),
				'field' => '',
			);

			if (is_string($params['type_in']))
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
				
			if (!isset($params['level']))
				$params['level'] = false;
				
			
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);
			
			// выделим номер дома
			$house = false;
			$pattern = '@[\s\,]+(?:д|д\.|дом)?\s*(\d+[\-\s\/]?[а-яa-z]?[\-\/]*\d*)$@i';
			if ( preg_match($pattern, $filter['Name'], $matche) )
			{
				$house = str_replace(' ', '', str_replace('-', '', $matche[1]));
				$filter['Name'] = preg_replace($pattern, '', $filter['Name']);
			}
			
			$filter['Name'] = trim(str_replace(',', '', $filter['Name']));
			$filter['Name'] = $filter['Name'] .'*';
			
			LocationDataSource::UseSphinx();
			/**
				в $params['parent'] может быть несколько кодов через запятую
				это используется в  частности для ленинградской области и повзоляет получить объекты, подчиненные одному из нескольких заданных 
			*/
			if ( strpos($params['parent'], ',') !== false )
			{
				$data = array();
				$result['count'] = 0;
				
				$params['parent'] = explode(',', $params['parent']);
				
				foreach ( $params['parent'] as $parent )
				{
					list($_data,$_count) = Location::GetSubordinateObjects(trim($parent), $filter, false, true);
					$data = array_merge($data, $_data);
					$result['count'] += $_count;
				}
				
				if ( count($data) > $filter['limit'] )
				{
					$result['count'] = $filter['limit'];
					$data = array_slice($data, 0, $filter['limit']);
				}
			}
			else
			{
				list($data,$result['count']) = Location::GetSubordinateObjects($params['parent'], $filter, false, true);
			}
			LocationDataSource::UseMySQL();
			
			$result['list'] = array();
			foreach ( $data as $v )
			{
				$item = array(
					'id'		=> $v['Code'],
					'name'		=> $v['FullName'],
					'type'		=> $v['Type'],
				);
				
				$is_default = false;
				if ( $v['Code'] === $params['default_location'] )
					$is_default = true;
				
				$v['Code'] = Location::ParseCode($v['Code']);
				$item['level'] = $v['Level'] = Location::ObjectLevel($v['Code']);
				
				$default_pc = Location::ParseCode($params['default_location']);
				$use_levels = array(
					Location::OL_CONTINENTS	=> false,
					Location::OL_COUNTRIES	=> false,
					Location::OL_REGIONS	=> false,
					Location::OL_DISTRICTS	=> false,
					Location::OL_CITIES		=> false,
					Location::OL_VILLAGES	=> true,
					Location::OL_STREETS	=> true,
				);
				if ( $v['Code']['CountryCode'] != $default_pc['CountryCode'] )
				{
					$use_levels[Location::OL_COUNTRIES] = true;
					$use_levels[Location::OL_REGIONS] = true;
					$use_levels[Location::OL_CITIES] = true;
				}
				else
				{
					if ( $v['Code']['RegionCode'] != $default_pc['RegionCode'] )
						$use_levels[Location::OL_REGIONS] = true;
					else if ( $is_default || $v['Code']['DistrictCode'] != $default_pc['DistrictCode'] || $v['Code']['CityCode'] != $default_pc['CityCode'] )
						$use_levels[Location::OL_CITIES] = true;
				}
				
				$item['normal'] = Location::Normalize( $v['Code'] , $use_levels );
				if ( empty($item['normal']) )
					$item['normal'] = $item['name'];
				
				if ( $house !== false && Location::ObjectLevel($v['Code']) == Location::OL_STREETS )
				{
					$item['name'] .= ', д. '. $house;
					$item['normal'] .= ', д. '. $house;
					$item['house'] = $house;
				}
				
				
				
				$parent = array();
				$object = Location::GetParentObject($v['Code']);
				
				if ( sizeof($object) )
					$parent = array(
						$object[0]['FullName']
					);					
				
				if ( is_array($object[0]) )// && (Location::OL_VILLAGES == $v['Level'] || Location::OL_VILLAGES == Location::ObjectLevel(Location::ParseCode($object[0]['Code'])))  )
				{
					$object = Location::GetParentObject(Location::ParseCode($object[0]['Code']));
					if ( sizeof($object) )
						$parent = array(
							$object[0]['FullName'],
							$parent[0],
						);
				}
				
				if ( sizeof($parent) )
				{
					$item['parent'] = $parent;
					
					// не берем объекты, для которых не удалось определить родителя
					$result['list'][] = $item;
				}
			}
		break;
	
		case 'subordinate_objects':

			$filter = array(
				'Type'	=> array(),
				//'level'	=> false,
			);
			
			if (is_string($params['type_in']) && trim($params['type_in']) != '')
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];

			if (isset($params['important']))
				$filter['Important'] = (int) $params['important'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
				
			if (!isset($params['level']))
				$params['level'] = false;
				
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);
			
			if ($params['tree'])
				$filter['field'] = 'Type, Name';

			//global $OBJECTS;
			$pc = Location::ParseCode($params['parent']);
			
			$cur_level = false;
			//if ($OBJECTS['user']->ID == 1) {
				$res = Location::GetObjects($pc);
				if (empty($res) && $params['level'] !== false)
					$cur_level = 0;
				else if (is_array($res) && sizeof($res)) {
					if ($res[0]['Type'] == 2 && $params['level'] == 4) {
						$filter['OtherCodes'] = array($params['parent']);
						$cur_level = 4;
					} else if ($res[0]['Type'] == 2 && $params['level'] == 6) {
						//$filter['OtherCodes'] = array($params['parent']);
						$cur_level = 6;
					}
				}
			//}

			list($data,$result['count']) = Location::GetSubordinateObjects($params['parent'], $filter, $cur_level/*$params['level']*/, true);

			$result['list'] = array();
			$_used_types = array();
			if ($result['count']) {
				foreach ( $data as $v )
				{
					$result['list'][] = array(
						'id'		=> $v['Code'],
						'name'		=> ( ($params['level'] == 4 || $params['level'] == 5 || $params['tree']) ? $v['Name'] : $v['FullName'] ),
						'type'		=> $v['Type'],
						'parent'	=> $params['parent'],
					);
					$_used_types[$v['Type']] = 1;
				}
			} else if ($filter['Important']) {
				$filter['Important'] = 0;
				list($data,$result['count']) = Location::GetSubordinateObjects($params['parent'], $filter, $cur_level/*$params['level']*/, true);

				foreach ( $data as $v )
				{
					$result['list'][] = array(
						'id'		=> $v['Code'],
						'name'		=> ( ($params['level'] == 4 ||  $params['level'] == 5 || $params['tree']) ? $v['Name'] : $v['FullName'] ),
						'type'		=> $v['Type'],
						'parent'	=> $params['parent'],
					);
					$_used_types[$v['Type']] = 1;
				}
			}
			
			if ( $params['tree'] )
			{
				$_types = Location::GetAbbr(array('order'=>'SocrText'));
				foreach ( $_types as $v )
					if ( array_key_exists($v['SocrId'], $_used_types) )
						$result['types'][$v['SocrId']] = $v;
			}
		break;
		
		case 'control':
			$_params = json_decode($params['params'],true);
			
			$_params['code'] = $params['code'];
			
			foreach($_params as &$v) {
				if (is_array($v)) {
					foreach($v as &$v1) {
						if (is_string($v1))
							$v1 = iconv('utf-8', 'windows-1251', $v1);
					}
				} else if (is_string($v))
					$v = iconv('utf-8', 'windows-1251', $v);
			}
			
			LibFactory::GetStatic('stpl');
			LibFactory::GetStatic('location');
			$result['control'] = STPL::Fetch('controls/location.inline', $_params);
			
			$result['level'] = Location::ObjectLevel(Location::ParseCode($params['code']));
			$result['code'] = $params['code'];
		break;
	}

//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';
//	
//	$json->send($result);
	return $result;
}

?>
