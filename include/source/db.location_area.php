<?php

function source_db_location_area($params)
{
	global $OBJECTS;
	
	LibFactory::GetStatic('location');

	$result = array();
	
	switch ( $params['type'] )
	{
		case 'areas':
			$pc = Location::ParseCode($params['parent']);
			unset($pc['StreetCode']);
			
			$result['list'] = array();
			list($data,$result['count']) = Location::GetAreas($pc, true);
			
			foreach ( $data as $v )
			{
				$result['list'][] = array(
					'id'		=> $v['Code'],
					'name'		=> $v['FullName'],
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