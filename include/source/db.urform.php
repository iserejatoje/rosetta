<?php

/**
 * Получение списка правовых форм организации
 * @param boolean $params['withid'] что помещать в идентификатор, true - id из базы, false - имя из базы
 * @return array данные id - идентификатор, data - имя
 */
function source_db_urform($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('business_74');
	$sql = "SELECT id,tname
			FROM orgs_types ORDER BY tname";
	$res = $db->query($sql);
	$arr = array();
	if($params['withid'] === true)
		$idi = 0;
	else
		$idi = 1;
	while($row = $res->fetch_row())
		$arr[] = array('id' => $row[$idi], 'data' => $row[1]);
	return $arr;
}

?>