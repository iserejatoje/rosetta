<?php

/**
 * Получение списка городов для региона
 * @param int $params['region'] регион (null или не задан - текущий)
 * @param boolean $params['withid'] что помещать в идентификатор, true - id из базы, false - имя из базы
 * @return array данные id - идентификатор, data - имя
 */
function source_db_cities($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('rugion');
	
	if($params['region'] == null || empty($params['region']))
		$params['region'] = $DCONFIG['REGION'];
	
	$sql = "SELECT cid,cname,oid
			FROM city";
	if ($params['region']!=100) $sql.=" WHERE oid={$params['region']}";
	$sql.=" ORDER BY cname ASC";
	$res = $db->query($sql);
	$arr = array();
	if($params['withid'] === true)
		$idi = 0;
	else
		$idi = 1;
	while($row = $res->fetch_row())
		$arr[] = array('id' => $row[$idi], 'data' => $row[1], 'oid' => $row[2]);
	return $arr;
}

?>