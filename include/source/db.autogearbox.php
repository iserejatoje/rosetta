<?php

/**
 * Получение списка типов кузова автомобилей
 * @return array данные id - идентификатор, name - название кузова
 */
function source_db_autogearbox($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('adv_auto');
	
	$sql = "SELECT id,name
			FROM auto_gearbox ORDER BY id";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1]);
	return $arr;
}

?>
