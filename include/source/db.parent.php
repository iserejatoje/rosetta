<?php

/**
 * Получение списка организаций
 * @param boolean $params['withid'] что помещать в идентификатор, true - id из базы, false - имя из базы
 * @return array данные id - идентификатор,  name - название 
 */
function source_db_parent($params)
{
	global $DCONFIG;
	
	//$RAZDEL_ID = "84, 612, 613, 92, 85, 89, 88"; //от cheldoctor.ru

	if(empty($params['dbname']))
	   $db = DBFactory::GetInstance('business_74');
	else
           $db = DBFactory::GetInstance($params['dbname']);

	$sql = "SELECT dt.id as id, dt.name as name
			FROM orgs_enttree as et, orgs_data as dt
			WHERE dt.id = et.eid"; 
	$sql .="	AND dt.regid = '74' "; 
	$sql .="	AND et.parent in (".$params["razdel_id"].")"; 
	$sql .="	ORDER BY dt.name";
	$res = $db->query($sql);
	
	$arr = array();
	$arr[] = array('id' => 0, 'data' => '-- нет родителя --');
	while($row = $res->fetch_row())
		$arr[] = array('id' => $row[0], 'data' => $row[1]);
	return $arr;
}

?>