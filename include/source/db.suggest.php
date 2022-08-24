<?php

/**
 * Получение списка улиц для города
 * @param int $params['city'] идентификатор города
 * @return array данные id - идентификатор, data - имя
 */
function source_db_suggest($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('takemix');

	$sql = "SELECT Name FROM streets";
	$sql.= " WHERE Name LIKE '%".$params['query']."%'";
	if(isset($params['cityid']) && $params['cityid'] > 0)
		$sql .= " AND CityID = ".$params['cityid'];
	$sql.=" ORDER BY name";

	$res = $db->query($sql);
	$arr = array();

	$arr['query'] = $params['query'];
	while($row = $res->fetch_assoc())
		$arr['suggestions'][] = $row['Name'];
	return $arr;
}

?>