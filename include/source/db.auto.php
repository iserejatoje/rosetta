<?php

/**
 * Получение списка объектов
 */
function source_db_auto($params)
{
	global $DCONFIG;
	
	$db = DBFactory::GetInstance('sources');
	
	$sql = "SELECT id, name, modname, parent, type, iconsmall, iconlarge";
	$sql.= " FROM automarka";
	$sql.= " WHERE isvisible=1";
		
	if( !empty($params['type']) )
	{
		if ( is_array($params['type']) )
			$sql.=" AND type IN (". implode(',', $params['type']) .")";
		else
			$sql.=" AND type=".intval($params['type']);
	}
	
	if(is_array($params['id']) && !empty($params['id']))
		$sql.= " AND id IN (".implode(",", $params['id']).")";
	elseif($params['id'] > 0)
		$sql.= " AND id=".intval($params['id']);
		
	if (is_array($params['parent']) && count($params['parent']))
		$sql.= " AND parent IN (".implode(",", $params['parent']).")";
	elseif ( $params['parent'] > 0 )
		$sql.= " AND parent={$params['parent']}";

	if ( $params['is_vip'] == true )
		$sql.=" AND ((vip=1 AND (type=1 || type=0)) || type=2)";

	/*
	if ( !empty($params['rubric']) )
	{
		$sql1 = "SELECT ID FROM `automarka_ref` WHERE";
		if ( is_array($params['rubric']) )
			$sql1.= " RubricID IN (". implode(',', $params['rubric']) .')';
		else
			$sql1.= " RubricID = ". $params['rubric'];
		$res = DBFactory::GetInstance('adv_auto')->query($sql1);
		$ids = array();
		while ( list($id) = $res->fetch_row() )
			$ids[] = $id;
		$sql.= " AND id IN (". implode(',', $ids) .")";
	}*/
	
	$sql.= " ORDER BY ord, name";
	
	$res = $db->query($sql);
	
	$arr = array();
	
	while($row = $res->fetch_row())
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1], 'modname' => $row[2], 'parent' => $row[3], 'type' => $row[4], 'icon_small' => $row[5], 'icon_large' => $row[6]);
	
	unset($res, $db, $sql);
	
	return $arr;
}

?>
