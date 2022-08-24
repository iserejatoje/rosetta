<?php

/**
 * Получение списка объектов
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_firms_afisha($params)
{
	global $DCONFIG;
	
	if(!is_numeric($params['id']) && !is_numeric($params['regid']))
		return array();
	$db = DBFactory::GetInstance('afisha');
	
	switch($params['type']) 
	{
		case 'afisha_link':		
			$sql = "SELECT p.id, t.name, p.name placename, p.sectionid FROM  places p";
			$sql.= " INNER JOIN types t ON (p.tid=t.id) WHERE";
			$sql.= " Region=".$params['regid'];
			$sql.= " AND PlaceID=".$params['id'];
			
			$res = $db->query($sql);
			if (($row = $res->fetch_assoc()) != false)
			{
				$sql = "SELECT COUNT(0) FROM seances WHERE";
				$sql.= " pid=".$row['id']." AND ";
				$sql.= " from_date<=CURRENT_DATE()"." AND ";
				$sql.= " to_date>=CURRENT_DATE()";
				list($count) = $db->query($sql)->fetch_row();
				
				if ($count > 0)
					return STreeMgr::GetLinkBySectionId($row['sectionid']).$row['name']."/".$row['placename']."/";		
			}
			return null;
		
		default:			
			
			$sql = "SELECT count(*),tname,pname FROM(";
			$sql.= "SELECT count(*),t.name as tname,p.name as pname";
			$sql.= " FROM places as p inner join seances as s on s.pid=p.id";
			$sql.= " inner join events as e on e.id=s.eid";
			$sql.= " inner join types as t on t.id=p.tid";
			$sql.= " WHERE p.fid=".intval($params['id'])." and s.to_date>NOW() and p.region=".intval($params['regid']);
			$sql.= " GROUP BY e.id) AS t2 GROUP BY tname,pname";

			$res = $db->query($sql);
			
			$arr = array();
			if($row = $res->fetch_row())
				$arr = array('count' => $row[0],'type' => $row[1],'name' => $row[2], 'url' => '/afisha/'.$row[1].'/'.$row[2]);
			return $arr;
	}
}

?>
