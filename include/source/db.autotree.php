<?php

/**
 * Получение списка объектов
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_autotree($params)
{
	global $DCONFIG;
	if(!isset($params['type']))
		return array();
	$db = DBFactory::GetInstance('rugion');
	
	$sql = "SELECT id,name,modname,parent,type
			FROM automarka
			WHERE type={$params['type']} AND visible=1";
	if($params['id'] > 0)
		$sql.= " AND id={$params['id']}";
	if($params['parent'] > 0)
		$sql.= " AND parent={$params['parent']}";
	if($params['is_vip'] == true)
		$sql.=" AND ((vip=1 AND (type=1 || type=0))||type=2)"; 
	$sql.= " ORDER BY ord, name"; 
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1], 'modname' => $row[2], 'parent' => $row[3], 'type' => $row[4]);
	return $arr;
}

?>
