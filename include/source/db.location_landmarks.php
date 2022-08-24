<?php

function source_db_location_landmarks($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location');
	
	$result = array();
	switch ( $params['type'] )
	{
		case 'query':
			
			$filter = array(
				'Type'	=> array(),
				'ActualCode' => array('not_in' => array( Location::AC_LM_OUTOFUSE ))
			);
			if (is_string($params['type_in']))
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
			
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);

			list($data,$result['count']) = Location::GetSubordinateLandmarks($params['parent'], $filter, false, true);
			
			$result['list'] = array();			
			foreach ( $data as $v )
			{
				$item = array(
					'id'		=> $v['LandmarkID'],
					'name'		=> $v['FullName'],
					'type'		=> $v['Type'],
				);

				$v['Code'] = Location::ParseCode($v['Code']);	
				$v['Level'] = Location::ObjectLevel($v['Code']);
				
				$parent = array();
				
				$object = Location::GetParentObject($v['Code']);					
				$parent = array(
					$object[0]['FullName']
				);					
				$item['parent'] = $parent;
				
				$result['list'][] = $item;
			}
		break;
	
		case 'subordinate_landmarks':

			$filter = array(
				'Type'	=> array(
					'not_in' => array(0)
				),
			);
			
			if (is_string($params['type_in']) && trim($params['type_in']) != '')
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];

			if (isset($params['important']))
				$filter['Important'] = (int) $params['important'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
				
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);

			if ($params['tree'])
				$filter['field'] = 'Type, Name';
			
			list($data,$result['count']) = Location::GetSubordinateLandmarks($params['parent'], $filter, false, true);
			
			$result['list'] = array();
			$_used_types = array();
			
			if ($result['count']) {
				foreach ( $data as $v )
				{
					$result['list'][] = array(
						'id'		=> $v['LandmarkID'],
						'name'		=> ($params['tree'] ? $v['Name'] : $v['FullName']),
						'type'		=> $v['Type'],
						'parent'	=> $params['parent'],
					);
					$_used_types[$v['Type']] = 1;
				}
			} else if ($filter['Important']) {
				$filter['Important'] = 0;
				list($data,$result['count']) = Location::GetSubordinateLandmarks($params['parent'], $filter, false, true);
				foreach ( $data as $v )
				{
					$result['list'][] = array(
						'id'		=> $v['LandmarkID'],
						'name'		=> ($params['tree'] ? $v['Name'] : $v['FullName']),
						'type'		=> $v['Type'],
						'parent'	=> $params['parent'],
					);
					$_used_types[$v['Type']] = 1;
				}
			}
			
			if ( $params['tree'] )
			{
				$_types = Location::GetAbbr();
				foreach ( $_types as $v )
					if ( array_key_exists($v['SocrId'], $_used_types) )
						$result['types'][$v['SocrId']] = $v;
			}
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