<?php

/**
 * Получение списка новостей по id-шникам
 * @return array
 */
function source_db_news($params)
{
	global $DCONFIG;
	
	if (!isset($params['id']) || (!is_numeric($params['id']) && !is_array($params['id'])))
		return array();
		
	if (is_array($params['id']) && count($params['id']) == 0)
		return array();
	
	$db = DBFactory::GetInstance('news');
	$data = array();
	
	
	if (is_numeric($params['id']))
	{
		$sql = "SELECT NewsID, Title FROM news WHERE";
		$sql.= " NewsID = ".$params['id'];
		
		$res = $db->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$data[$row['NewsID']] = $row;
		}
	}
	else
	{
		$sql = "SELECT NewsID, Title FROM news WHERE";
		$sql.= " NewsID IN (".implode(',', $params['id']).")";
		$sql.= " AND isVisible = 1";
		
		$res = $db->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$data[$row['NewsID']] = $row;
		}
	}
	return $data;
}

?>
