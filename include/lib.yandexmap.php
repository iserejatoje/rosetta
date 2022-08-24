<?

class YandexMap
{
	// наличие детальных карт
	static $DetailMaps = array(
		'Челябинск','Екатеринбург','Омск',
		'Киров','Ростов','Уфа','Тюмень','Архангельск','Тамбов',
		'Саратов','Сочи','Воронеж','Вологда','Краснодар','Мурманск',
		'Новосибирск','Тула'
	);
	
	/**
		Определение географических координат по адресу
		@param $query - адрес
		@param $mapkey - ключ карты
		@param [$precision] - точность соответствия (http://api.yandex.ru/maps/geocoder/doc/desc/reference/precision.xml)
	*/
	static function GeoSearch($query, $mapkey, $precision = false)
	{
		$result = array();
		
		$_curl = LibFactory::GetInstance('curl');
		$_curl->Init();
		$_curl->setParams( array( 'type' => 'module', 'use_proxy' => false ) );
		
		// запрос к геокодеру
		$res = $_curl->query(array( 'url' => "http://geocode-maps.yandex.ru/1.x/?geocode=". urlencode($query) ."&key=". $mapkey ));
		//error_log("http://geocode-maps.yandex.ru/1.x/?geocode=". urlencode($query) ."&key=". $mapkey);
		
		// вытаскиваем координаты
		if ( !preg_match('@<pos>([\d\.\-]+)\s([\d\.\-]+)<\/pos>@m', $res, $matche) )
			return false;
		
		$result['x'] = floatval($matche[1]);
		$result['y'] = floatval($matche[2]);
		
		// проверяем точность
		if ( $precision === false )
		{
			foreach ( self::$DetailMaps as $v )
			{
				if ( preg_match('@\b'. $v .'\b@i', $query) )
				{
					$precision = array('exact','number','near','street');
					break;
				}
			}
		}
		
		if ( is_array($precision) && preg_match('@<precision>([^<]+)<\/precision>@m', $res, $pr) )
		{
			if ( !in_array($pr[1], $precision) )
				return false;
		}
		
		// вытаскиваем границу
		if ( preg_match('@<lowerCorner>([\d\.\-]+)\s([\d\.\-]+)<\/lowerCorner>@m', $res, $matche1) &&
			preg_match('@<upperCorner>([\d\.\-]+)\s([\d\.\-]+)<\/upperCorner>@m', $res, $matche2) )
		{
			$result['span'] = array(
				$matche2[1] - $matche1[1],
				$matche2[2] - $matche1[2]
			);
		}
		
		return $result;
	}
	
	
	/**
		Определение координат адресного объекта по коду
		@param string $Code - код  объекта
		@result float
	*/
	static function GetPoint($Code)
	{
		if ( !is_string($Code) )
			return false;
		
		$db = DBFactory::GetInstance('sources');
		$sql = "SELECT m.`MapX`, m.`MapY` FROM `location_yandexmap` m";
		$sql.= " INNER JOIN `location_objects_new` o ON o.`ObjectID` = m.`ObjectID`";
		$sql.= " WHERE o.`Code` = '". addslashes($Code) ."'";
		if ( false === ($res = $db->query($sql)) || $res->num_rows == 0 )
			return false;
		
		return $res->fetch_row();
	}
	
	
	/**
		Определение дистанции между двумя адресными объектами
		@param string $Code1 - код первого объекта
		@param string $Code2 - код второго объекта
		@result float
	*/
	static function GetDistance($Code1, $Code2)
	{
		if ( !is_string($Code1) || !is_string($Code2) )
			return false;
		
		$Point1 = self::GetPoint($Code1);
		$Point2 = self::GetPoint($Code2);
		
		return sqrt(pow($Point1[0] - $Point2[0], 2) + pow($Point1[1] - $Point2[1], 2));
	}
	
	
	/**
		Получение списка ID объектов, находящихся в заданном радиусе от заданного объекта
		@param string $Code - код  объекта
		@param string $Distance - радиус
		@param string $Types - типы объектов
		@result array
	*/
	static function GetObjectsByDistance($Code, $Distance)
	{
		$Distance = floatval($Distance);
		if ( !is_string($Code) || $Distance == 0 )
			return false;
		
		$Point = self::GetPoint($Code);
		if ( $Point === false )
			return false;
		
		$db = DBFactory::GetInstance('sources');
		
		// берем список объектов в квадратной области
		$sql = "SELECT o.`ObjectID`, m.`MapX`, m.`MapY` FROM `location_objects_new` o";
		$sql.= " INNER JOIN `location_yandexmap` m ON m.`ObjectID` = o.`ObjectID`";
		$sql.= " WHERE o.`Code` != '". addslashes($Code) ."'";
		$sql.= " AND o.`IsVisible` = 1";
		$sql.= " AND o.`ActualCode` = ". Location::AC_OBJ_ACTUAL;
		$sql.= " AND o.`Type` IN (". implode(',', Location::$TC_CITIES) .")";
		$sql.= " AND m.`MapX` >= ". Data::NormalizeFloat($Point[0] - $Distance);
		$sql.= " AND m.`MapX` <= ". Data::NormalizeFloat($Point[0] + $Distance);
		$sql.= " AND m.`MapY` >= ". Data::NormalizeFloat($Point[1] - $Distance);
		$sql.= " AND m.`MapY` <= ". Data::NormalizeFloat($Point[1] + $Distance);
		
		if ( false === ($res = $db->query($sql)) )
			return false;
		
		// проверяем дистанцию в выбранном квадрате (вписываем круг)
		$result = array();
		while ( $row = $res->fetch_assoc() )
		{
			//$d = sqrt(pow($Point[0] - $row['MapX'], 2) + pow($Point[1] - $row['MapY'], 2));
			
			$long1 = $Point[0] * pi() / 180;
			$long2 = $row['MapX'] * pi() / 180;
			$lat1 = $Point[1] * pi() / 180;
			$lat2 = $row['MapY'] * pi() / 180;
			
			$d = 6378 * acos(sin($lat1)*sin($lat2)+cos($lat1)*cos($lat2)*cos($long1-$long2));
			
			if ( $d <= $Distance )
				$result[] = $row['ObjectID'];
		}
		
		return $result;
	}
	
	
}
?>