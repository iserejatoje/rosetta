<?php

/**
 * Получение списка объектов
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_firms_atm($params)
{
	global $DCONFIG;
	
	switch($params['type']) 
	{
		case 'atm_link':
			if(!is_numeric($params['id']) || !is_numeric($params['sectionid']))
				return null;
				
			$config = ModuleFactory::GetConfigById('section', $params['sectionid']);
			
			if (empty($config))
				return null;
		
			$dbAtm = DBFactory::GetInstance($config['db']);
			$sql = "SELECT COUNT(0) FROM ".$config['tables']['object']." WHERE";
			$sql.= " PlaceID = ".$params['id'];
			list($count) = $dbAtm->query($sql)->fetch_row();
			if ($count > 0)
				return STreeMgr::GetLinkBySectionId($params['sectionid'])."/list/".$params['id'].".html";		
			return null;		
	}
}

?>
