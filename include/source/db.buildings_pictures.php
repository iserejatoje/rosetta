<?php

/**
 * Получение фотографий объекта по определенному адресу
 * @return array данные PictureID - идентификатор, ImageSmall - малое изображение, ImageBig - большое изображение
 */
function source_db_buildings_pictures($params) {
	
	$db = DBFactory::GetInstance('public');
	$result = __source_db_buildings_pictures($params, $db);
	//$db->close();
	return $result;
}
 
function __source_db_buildings_pictures($params, &$db)
{
	$data	= array();
	$path	= '/common_fs/i/sources/buildings_pictures/i/';
	$url	= '/_i/sources/buildings_pictures/i/';
	
	switch(	$params['type'] ) {
		case 'list': {
			
			if ( !isset($params['true_key']) ) 
				$params['true_key'] = true;
			
			$sql = 'SELECT p.* FROM source_buildings b ';
			$sql .= ' INNER JOIN source_buildings_pictures p ON(p.BuildID = b.BuildID) ';
			$sql .= ' WHERE b.Visible = 1 AND p.Visible = b.Visible';

			if ( is_numeric($params['street']) ) 
				$sql .= ' AND b.StreetID = '.$params['street'];
			
			if ( is_numeric($params['build']) ) 
				$sql .= ' AND b.BuildID = '.$params['build'];
			
			if ( !empty($params['house']) ) 
				$sql .= ' AND b.House = \''.addslashes(strtoupper($params['house'])).'\'';			
			
			$sql .= ' ORDER BY p.ord ';
			if ( is_numeric($params['limit']) ) 
				$sql .= ' LIMIT '. (is_numeric($params['offset']) ? $params['offset'] : 0) .', '.$params['limit'];
			
			$res = $db->query($sql);	
			if ( !$res || !$res->num_rows)
				return array();
			
			LibFactory::GetStatic('file2');	
			while($row = $res->fetch_assoc()) {
				
				$row['ImageSmall'] = File::GetPath($row['ImageSmall']);
				$path.$row['ImageSmall'];
				if ( is_file($path.$row['ImageSmall']) ) {
					$image = getimagesize($path.$row['ImageSmall']);
					$row['ImageSmall'] = array(
						'src' => $url.$row['ImageSmall'],
						'width' => $image[0],
						'height' => $image[1],
					);

				}
				
				$row['ImageBig'] = File::GetPath($row['ImageBig']);
				if ( is_file($path.$row['ImageBig']) ) {
					$image = getimagesize($path.$row['ImageBig']);
					$row['ImageBig'] = array(
						'src' => $url.$row['ImageBig'],
						'width' => $image[0],
						'height' => $image[1],
					);
				}
				if ( $params['true_key'] === true)
					$data[$row['PictureID']] = $row;
				else
					$data[] = $row;
			}	
		} break;
		
		case 'count': {
			$sql = 'SELECT COUNT(*) FROM source_buildings b ';
			$sql .= ' INNER JOIN source_buildings_pictures p ON(p.BuildID = b.BuildID) ';
			$sql .= ' WHERE b.Visible = 1 AND p.Visible = b.Visible';

			if ( is_numeric($params['street']) ) 
				$sql .= ' AND b.StreetID = '.$params['street'];
			
			if ( !empty($params['house']) && preg_match("@^[\xc0-\сdf]$@", $params['house']) ) 
				$sql .= ' AND b.House = \''.addslashes(strtoupper($params['house'])).'\'';
			
			$res = $db->query($sql);	
			if ( $res && false != (list($count) = $res->fetch_row()))
				return $count;
			return 0;			
		}
	}
		
	return $data;
}

?>
