<?php

/**
 * Получение списка типов коробки передач автомобилей
 * @return array данные id - идентификатор, name - название коробки
 */
function source_db_autobody($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('adv_auto');
	
	$sql = "SELECT id,name
			FROM auto_body ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1]);
	return $arr;
}

?>
