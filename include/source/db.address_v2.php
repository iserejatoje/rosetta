<?php

function source_db_address_v2($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location');

	$result = array();
	switch ( $params['type'] )
	{
		case 'subordinate_objects':
			
			$filter = array(
				'Type' => array(),
			);
			
			if (is_string($params['type_in']))
				$filter['Type']['in'] = explode(',', addslashes($params['type_in']));
			elseif (is_array($params['type_in']))
				$filter['Type']['in'] = $params['type_in'];

			if (!isset($params['level']))
				$params['level'] = false;
			
			if (isset($params['important']))
				$filter['Important'] = (int) $params['important'];
			
			if (isset($params['limit']) && $params['limit'] > 0)
				$filter['limit'] = (int) $params['limit'];
				
			if (isset($params['query']))
				$filter['Name'] = iconv('UTF-8', 'WINDOWS-1251', $params['query']);

			$pc = Location::ParseCode($params['parent']);
			list($data,$result['count']) = Location::GetSubordinateObjects($params['parent'], $filter, $params['level'], true);

			$result['list'] = array();			
			foreach ( $data as $v )
			{
				$result['list'][] = array(
					'id'		=> $v['Code'],
					'name'		=> $v['FullName'],
					'type'		=> $v['Type'],
					'parent'	=> $params['parent'],
				);
			}
		break;
	}

//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';
//
//	exit(
//		$json->encode($result)
//	);
	return $result;
}

?>