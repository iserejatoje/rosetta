<?php

function source_db_shedule($params)
{
	global $CONFIG,  $OBJECTS;
	
	$db = DBFactory::GetInstance('timetable');

	$query = iconv('UTF-8', 'WINDOWS-1251', $params['query']);
	
	// Поиск по названию станции.
	if(isset($params['station'])){
		$sql = "SELECT  DISTINCT UCASE(`Name`) as Name, StationID, UCASE(`CityName`) AS CityName, CitySign  FROM `stations`";
		$sql.= " WHERE `Name` LIKE '".addslashes($query)."%' ORDER BY `Name`";				
	}	
	else
	{
		$sql = "SELECT  DISTINCT UCASE(`CityName`) as Name, StationID, CitySign FROM `stations`";
		$sql.= " WHERE `CityName` LIKE '".addslashes($query)."%' ORDER BY `CityName`";
	}

	$res = $db->query($sql);

	
	$result = '';
	$result['list'] = array();
	$i=0;
	while ( $row = $res->fetch_assoc() ){
		$item = array(
					'id'		=> $row['StationID'],//$i++,
					'name'		=> $row['Name'],
					'citysign'	=> $row['CitySign'],
					'cityname'	=> $row['CityName']
					);
		$result['list'][] =$item;	
	}
		
//	include_once ENGINE_PATH.'include/json.php';
//	$json = new Services_JSON();
//	$json->charset = 'WINDOWS-1251';
	
//	$json->send($result);
	return $result;
}
