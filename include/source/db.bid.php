<?php

/**
 * Получение списка районов города
 * @param boolean $params['withid'] что помещать в идентификатор, true - id из базы, false - имя из базы
 * @return array данные id - идентификатор,  name - название 
 */
function source_db_bid($params)
{
	global $DCONFIG;
	if(empty($params['dbname']))
	   $db = DBFactory::GetInstance('business_74');
	else
           $db = DBFactory::GetInstance($params['dbname']);
	
	$sql = "SELECT id,name
			FROM orgs_borough ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	$arr[] = array('id' => 0, 'data' => '-- нет района --');
	while($row = $res->fetch_row())
		$arr[] = array('id' => $row[0], 'data' => $row[1]);
	return $arr;
}

?>