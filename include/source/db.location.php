<?php

/**
 * Получение списка объектов
 * @return array данные id - идентификатор, name - название цвета, value - значение
 */
function source_db_location($params) {
global $CONFIG, $OBJECTS;
	
	$db = DBFactory::GetInstance('public');
	$result = __source_db_location($params, $db);
	$db->close();
	return $result;
}
 
function __source_db_location($params, &$db)
{
global $CONFIG, $OBJECTS;
	//$db = DBFactory::GetInstance('public');
	$data = array();
	switch($params['type'])
	{
		case 'default_location':

			if (!isset($params['city']) || $params['city'] <= 0)
				return $data;

			$sql = 'SELECT CityID, RegionID, CountryID, Name ';
			$sql .=	' FROM source_location_city ';
			$sql .= ' WHERE CityID = \''.$params['city'].'\' AND ';
			$sql .= ' visible = 1';

			$res = $db->query($sql);
			if (false == ($data = $res->fetch_assoc()))
				return array();

			break;
		case 'city':
			$sql = "SELECT CityID, Name FROM source_location_city";
			$sql.= " WHERE visible = 1";
			if(is_numeric($params['region']))
				$sql.= " AND RegionID=".$params['region'];
			elseif(is_array($params['region']) && sizeof($params['region']))
				$sql.= " AND RegionID IN(".implode(',',$params['region']).")";
			if(is_numeric($params['country']))
				$sql.= " AND CountryID=".$params['country'];
			elseif(is_array($params['country']) && sizeof($params['country']))
				$sql.= " AND CountryID IN(".implode(',',$params['country']).")";
			if(is_numeric($params['id']))
				$sql.= " AND CityID=".$params['id'];
			elseif(is_array($params['id']) && sizeof($params['id']))
				$sql.= " AND CityID IN(".implode(',',$params['id']).")";
			if(!empty($params['name']))
				$sql.= " AND Name='".addslashes($params['name'])."'";
			$sql.= " ORDER BY ord, Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['CityID']] = array('name' => $row['Name']);
			}
			break;
		case 'area':
			$sql = "SELECT AreaID, CityID, Name, Short_Name FROM source_location_area";
			$sql.= " WHERE visible = 1";
			if(is_numeric($params['region']))
				$sql.= " AND RegionID=".$params['region'];
			if(is_numeric($params['city']))
				$sql.= " AND CityID=".$params['city'];
			if(is_numeric($params['id']))
				$sql.= " AND AreaID=".$params['id'];
			if(!empty($params['name']))
				$sql.= " AND Name='".addslashes($params['name'])."'";
			$sql.= " ORDER BY ord, Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['AreaID']] = array('name' => $row['Name'], 'short_name' => $row['Short_Name']);
			}
			break;
		case 'region':
			$sql = "SELECT RegionID, Name FROM source_location_region";
			$sql.= " WHERE visible = 1";
			if(is_numeric($params['country']))
				$sql.= " AND CountryID=".$params['country'];
			if(is_numeric($params['id']))
				$sql.= " AND RegionID=".$params['id'];
			if(!empty($params['name']))
				$sql.= " AND Name='".addslashes($params['name'])."'";
			$sql.= " ORDER BY ord, Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['RegionID']] = array('name' => $row['Name']);
			}
			break;
		case 'country':
			$sql = "SELECT CountryID, Name FROM source_location_country";
			$sql.= " WHERE visible = 1";
			if(is_numeric($params['id']))
				$sql.= " AND CountryID=".$params['id'];
			if(!empty($params['name']))
				$sql.= " AND Name='".addslashes($params['name'])."'";
			$sql.= " ORDER BY ord, Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['CountryID']] = array('name' => $row['Name']);
			}
			break;
		case 'street':
			$sql = "SELECT StreetID, CityID, Name FROM source_location_street";
			$sql.= " WHERE Visible = 1";
			
			if(is_numeric($params['id']))
				$sql.= " AND StreetID=".$params['id'];
			if(is_numeric($params['city']))
				$sql.= " AND CityID=".$params['city'];

			if ( isset($params['name']) )
			{
				// выборка по наименованию улицы
				if ( !isset($params['name_match']) || $params['name_match'] == 0 )
				{
					$sql.= " AND Name = '".addslashes($params['name'])."'";
				} elseif ( $params['name_match'] == 1 ) {
					$sql.= " AND Name LIKE '".addslashes($params['name'])."%'";
				} elseif ( $params['name_match'] == 2 ) {
					$sql.= " AND Name LIKE '%".addslashes($params['name'])."%'";
				}
			}
			
			$sql.= " ORDER BY ord, Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['StreetID']] = array('name' => $row['Name']);
			}
			break;
		case 'place':
			$sql = "SELECT PlaceID, Name, IsNew FROM source_location_place WHERE 1";
						
			if(is_numeric($params['id']))
				$sql.= " AND PlaceID=".$params['id'];
			if(is_numeric($params['street']))
				$sql.= " AND StreetID=".$params['street'];

			if ( isset($params['name']) )
			{
				// выборка по наименованию ориентира
				if ( !isset($params['name_match']) || $params['name_match'] == 0 )
				{
					$sql.= " AND Name = '".addslashes($params['name'])."'";
				} elseif ( $params['name_match'] == 1 ) {
					$sql.= " AND Name LIKE '".addslashes($params['name'])."%'";
				} elseif ( $params['name_match'] == 2 ) {
					$sql.= " AND Name LIKE '%".addslashes($params['name'])."%'";
				}
			}
			
			$sql.= " ORDER BY Name";
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
			{
				$data[$row['PlaceID']] = array('name' => $row['Name']);
			}
			break;
	}
	return $data;
}

?>
