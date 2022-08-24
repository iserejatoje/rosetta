<?php

/**
 * Получение списка улиц для города
 * @param int $params['city'] идентификатор города
 * @return array данные id - идентификатор, data - имя
 */
function source_db_streets($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('rugion');

	if (!isset($params['city']) || !$params['city']) {
		$params['city'] = 499;
	} else $params['city'] = (int) $params['city'];

	$sql = "SELECT sid,name,cid
			FROM street";
	$sql.=" WHERE cid={$params['city']}";
	$sql.=" ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'data' => $row[1], 'cid' => $row[2]);
	return $arr;
}

?>