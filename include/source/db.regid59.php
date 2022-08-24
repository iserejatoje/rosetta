<?php

/**
 * Получение списка регионов
 * @param boolean $params['withid'] что помещать в идентификатор, true - id из базы, false - имя из базы
 * @return array данные id - идентификатор, regid - номер региона, name - название региона (ХХ.ru - область)
 */
function source_db_regid59($params)
{
	global $DCONFIG;
	if(empty($params['dbname']))
	   $db = DBFactory::GetInstance('region_59');
    else
        $db = DBFactory::GetInstance($params['dbname']);
	
	$sql = "SELECT id,regid,name
			FROM orgs_regid ORDER BY regid";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[] = array('id' => $row[1], 'data' => $row[2]);
	return $arr;
}

?>