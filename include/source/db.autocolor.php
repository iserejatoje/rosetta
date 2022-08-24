<?php

/**
 * Получение списка цветов автомобилей
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_autocolor($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('adv_auto');
	
	$sql = "SELECT id,name,value
			FROM auto_color ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1], 'value' => $row[2]);
	return $arr;
}

?>
