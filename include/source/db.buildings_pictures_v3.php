<?php

/**
 * Получение фотографий объекта по определенному адресу
 * @return array данные PictureID - идентификатор, ImageSmall - малое изображение, ImageBig - большое изображение
 */
function source_db_buildings_pictures_v3($params) 
{
	$data = array();
	
	LibFactory::GetStatic('location_v3');
	
	if ($params['type'] == 'list')
	{
		if (is_numeric($params['limit']))
			Location_v3::SetLimit($params['limit']);
		
		if (is_numeric($params['offset']))
			Location_v3::SetOffset($params['offset']);
		
		$data = Location_v3::GetBuildingsPicturesList(
			$params['streetcode'], 
			(isset($params['house'])?$params['house']:null), 
			(isset($params['build'])?$params['build']:null)
		);
	}
	elseif ($params['type'] == 'count')
	{
		$data = Location_v3::GetBuildingsPicturesListCount(
			$params['streetcode'], 
			(isset($params['house'])?$params['house']:null), 
			(isset($params['build'])?$params['build']:null)
		);
	}
	
	return $data;
}
?>
