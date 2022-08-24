<?

/**
	Библиотека для работы с адресами
*/

class Location
{
	// Коды актуальности объектов
	const AC_OBJ_ACTUAL		= 0;
	const AC_OBJ_TRANSFER	= 51;
	const AC_OBJ_OUTOFUSE 	= 99;
	
	// Коды актуальности ориентиров
	const AC_LM_ACTUAL		= 0;
	const AC_LM_DUPLICATE	= 1;
	const AC_LM_OUTOFUSE 	= 99;
	
	// Уровни объектов
	const OL_CONTINENTS		= 0;
	const OL_COUNTRIES		= 1;
	const OL_REGIONS		= 2;
	const OL_DISTRICTS		= 3;
	const OL_CITIES			= 4;
	const OL_VILLAGES		= 5;
	const OL_STREETS		= 6;
	const OL_LANDMARKS		= 7;
	
	// Статусы объектов
	const ST_COMMON							= 0;
	const ST_DISTRICT_CENTER_CITY			= 1;
	const ST_REGION_CENTER_CITY				= 2;
	const ST_DISTRICT_REGION_CENTER_CITY	= 3;
	const ST_REGION_CENTER_DISTRICT			= 4;
	
	// Типы сокращений
	const AT_KLADR							= 1;
	const AT_OUR_OBJECT						= 2;
	const AT_OUR_LANDMARK					= 3;
	
	// Коллекции типов (можно изменять и дополнять в соответствии с нашими запросами)
	public static $TC_CONTINENTS	= array(141);								# Континенты
	public static $TC_COUNTRIES		= array(140);								# Страны
	public static $TC_REGIONS		= array(1,2,3,4,5,136,139);					# Субъекты РФ, Регионы, Штаты и т.п.
	public static $TC_DISTRICTS		= array(6);									# Региональные районы
	public static $TC_CITIES		= array(2,10,24);							# Города и приравненные к ним объекты
	public static $TC_VILLAGES		= array(7,8,9,14,15,16,17,18,19,20,21,22,23,
											26,35,36,38,40,41,42,44,45,46,47,50,51,
											52,53,54,55,56,57,58,60,63,65,76,81,84,
											85,86,88,89,97,101,104,107,110,115,119,
											120,121,122,124,125,126,130,131,137,138);	# Села, деревни, поселки
	public static $TC_LAKES			= array(142);								# Озера
	public static $TC_GARDENS		= array(105,127,129);						# СНТ
	public static $TC_GARAGES		= array(128);								# ГСК
	public static $TC_STREETS		= array(25,59,61,62,64,66,72,75,78,79,80,83,90,91,
											92,93,98,99,100,102,106,111,112,113,114,116,
											123,133,134,135,77);				# Улицы, проспекты, переулки, площади
	public static $TC_HOUSES		= array(117);								# Дома
	public static $TC_CAMPINGS		= array(11,27);								# Дачные поселки
	public static $TC_COTTAGES		= array(145);								# Коттеджные поселки
	public static $TC_RESORTS		= array(12,37);								# Курортные поселки
	
	public static $LOC_FILIALS		= array(2031,1830,1888,2453,2706,2533,153105,1752,2656);	# Идентификаторы городов с филиалами компании
	
	public static $cache	= true;
	
	// Конфиг либы
	private static $_config = array(
		'db'		=> 'sources',
		'tables'	=> array(
			'objects' 		=> 'location_objects_new',
			'landmarks'		=> 'location_landmarks',
			'abbr'			=> 'location_abbr_new',
			'areas'			=> 'location_areas_new',
			'buildings'		=> 'location_buildings_new',
			'pictures'		=> 'location_buildings_pictures_new',
		),
		'_images_dir' => '/common_fs/i/location/1/',
		'_images_url' => '/_i/location/1/',
	
		'_photo_big_size' => array('max_width' => 450, 'max_height' => 337),	
		'_photo_small_size' => array('max_width' => 120, 'max_height' => 90),
	
		'_photo_file_size' => 1048576,
	);
	
	private static $limit 	= 1000;
	private static $_cache = null;
	private static $_cache_params = array(
			'host' => '10.80.12.39',
			'port' => 11211,
		);
	private static $_types = null;

	
	/**
		Получение объекта по идентификатору
		@param int $ObjectID - идентификатор объекта или массив идентификаторов
		@return array - объект или массив объектов
	*/
	public static function GetObjectByID( $ObjectID, $from_master = false )
	{
		if ( !is_numeric($ObjectID) && !is_array($ObjectID) )
			return array();
		if ( is_numeric($ObjectID) && $ObjectID <= 0 )
			return array();
		if ( is_array($ObjectID) && count($ObjectID) == 0 )
			return array();
		
		// попробуем взять объекты из кэша
		if ( self::$cache === true && $_GET['nocache'] < 12 )
		{
			self::__cache_init();
			$obj = array();
			if ( is_array($ObjectID) )
			{
				// грузим элементы из кэша, какие находим - ансетим, остальные провалятся дальше и получатся из базы
				foreach ( $ObjectID as $k => $id )
				{
					$row = self::$_cache->Get('objects|'. $id);
					if ( is_array($row) )
					{
						$obj[$id] = $row;
						unset($ObjectID[$k]);
					}
				}
				
				// если не осталось объектов - возвращаем результат
				if ( count($ObjectID) == 0 )
					return $obj;
			}
			else
			{
				$obj = self::$_cache->Get('objects|'. $ObjectID);
				if ( is_array($obj) )
					return $obj;
			}
		}
		
		$sql = "SELECT * FROM ". self::$_config['tables']['objects'];
		if ( is_array($ObjectID) )
		{
			if ( count($ObjectID) > 1 )
				$sql.= " WHERE `ObjectID` IN (". implode(',',$ObjectID) .")";
			else if ( current($ObjectID) > 0 )
				$sql.= " WHERE `ObjectID` = ". current($ObjectID);
			else
				return $obj;
		}
		else
			$sql.= " WHERE `ObjectID` = ". $ObjectID;
		
		if ( $from_master === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else		
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		
		if ( $res === false )
			return $obj;
		
		if ( !is_array($ObjectID) )
		{
			if ( false === ( $obj = $res->fetch_assoc() ) )
				return array();
			
			$obj['FullName'] = $obj['Name'].' '.self::GetAbbrByType($obj['Type']);
			
			if ( self::$cache === true )
			{
				self::__cache_init();
				self::$_cache->Set('objects|'. $ObjectID, $obj, 0);
			}
		}
		else
		{
			while ( $row = $res->fetch_assoc() )
			{
				$row['FullName'] = $row['Name'].' '.self::GetAbbrByType($row['Type']);
				$obj[$row['ObjectID']] = $row;
				
				if ( self::$cache === true )
				{
					self::__cache_init();
					self::$_cache->Set('objects|'. $row['ObjectID'], $row, 0);
				}
			}
		}
		
		return $obj;
	}
	
	
	/**
		Получение объектов по фильтру
		@param array $filter
		@return array - массив объект
	*/
	public static function GetObjects( $filter, $with_count = false )
	{
		if ( !is_array($filter) )
			return array();
		
		// убиваем лишние поля профиля, чтобы запрос не посыпался
		if ( isset($filter['LandmarkCode']) )
			unset ($filter['LandmarkCode']);
		
		// заполняем незаполненные поля фильтра дефолтными значениями и получаем sql-условие
		self::__filter_set_defaults($filter);
		
		return LocationDataSource::GetObjects($filter, $with_count);
	}
	
	
	/**
		Получение количества объектов по фильтру
		@param array $filter
		@return int - кол-во объектов
	*/
	public static function GetObjectsCount( $filter )
	{
		if ( !is_array($filter) )
			return array();
		
		// убиваем лишние поля профиля, чтобы запрос не посыпался
		if ( isset($filter['LandmarkCode']) )
			unset ($filter['LandmarkCode']);
		
		// заполняем незаполненные поля фильтра дефолтными значениями и получаем sql-условие
		self::__filter_set_defaults($filter);
		
		return LocationDataSource::GetObjectsCount($filter);
	}
	
	
	/**
		Получение подчиненных объектов по фильтру
		@param string $Code - код объекта
		@param string $filter - фильтр
		@param int $level - уровень объектов
		@return array - массив объектов
		@exception InvalidArgumentMyException
	*/
	public static function GetSubordinateObjects( $Code, $filter = array(), $level = false, $with_count = false )
	{
		if ( empty($Code) )
			return array();
		if ( !is_string($Code) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::GetSubordinateObjects\'');
		
		// парсим код
		$pc = self::ParseCode($Code);
		
		// объединяем фильтр на основе кода вышестоящего объекта с фильтром
		$filter = array_merge( self::__filter_get_subordinates($pc,$level), $filter );
		
		// добавим код в исключения, если не указан уровень, чтобы не попал сам объект
		if ( $level === false )
			$filter['ExcludeCodes'][] = $Code;
		
		return self::GetObjects($filter,$with_count);
	}
	
	
	/**
		Получение количества подчиненных объектов по фильтру
		@param string $Code - код объекта
		@param string $filter - фильтр
		@param int $level - уровень объектов
		@return int - кол-во объектов
		@exception InvalidArgumentMyException
	*/
	public static function GetSubordinateObjectsCount( $Code, $filter = array(), $level = false )
	{
		if ( empty($Code) )
			return array();
		if ( !is_string($Code) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::GetSubordinateObjectsCount\'');
		
		// парсим код
		$pc = self::ParseCode($Code);
		
		// объединяем фильтр на основе кода вышестоящего объекта с фильтром
		$filter = array_merge( self::__filter_get_subordinates($pc,$level), $filter );
		
		return self::GetObjectsCount($filter);
	}
	
	
	/**
		Получение ориентира по идентификатору или массиву идентификаторов
		@param int $LandmarkID - идентификатор объекта
		@return array - объект
	*/
	public static function GetLandmarkByID( $LandmarkID, $from_master = false )
	{
		if ( !is_numeric($LandmarkID) && !is_array($LandmarkID) )
			return array();
		if ( is_numeric($LandmarkID) && $LandmarkID <= 0 )
			return array();
		if ( is_array($LandmarkID) && count($LandmarkID) == 0 )
			return array();
		
		// попробуем взять ориентиры из кэша
		if ( self::$cache === true && $_GET['nocache'] < 12 )
		{
			self::__cache_init();
			if ( is_array($LandmarkID) )
			{
				// грузим элементы из кэша, какие находим - ансетим, остальные провалятся дальше и получатся из базы
				foreach ( $LandmarkID as $k => $id )
				{
					$row = self::$_cache->Get('landmarks|'. $id);
					if ( is_array($row) )
					{
						$obj[$id] = $row;
						unset($LandmarkID[$k]);
					}
				}
				
				// если не осталось объектов - возвращаем результат
				if ( count($LandmarkID) == 0 )
					return $obj;
			}
			else
			{
				$obj = self::$_cache->Get('landmarks|'. $LandmarkID);
				if ( is_array($obj) && count($obj) > 1 ) // 2do: это я ошибся, надо будет  каунт убрать потом
					return $obj;
			}
		}
		
		$sql = "SELECT * FROM ". self::$_config['tables']['landmarks'];
		if ( is_array($LandmarkID) )
		{
			if ( count($LandmarkID) > 1 )
				$sql.= " WHERE `LandmarkID` IN (". implode(',',$LandmarkID) .")";
			else if ( current($LandmarkID) > 0 )
				$sql.= " WHERE `LandmarkID` = ". current($LandmarkID);
			else
				return $obj;
		}
		else
			$sql.= " WHERE `LandmarkID` = ". $LandmarkID;

		if ( $from_master === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		
		if ( $res === false )
			return array();
		
		
		if ( !is_array($LandmarkID) )
		{
			if ( false === ( $obj = $res->fetch_assoc() ) )
				return array();
			
			$obj['FullName'] = $obj['FullName'] = $obj['Name'];;
			
			if ( self::$cache === true )
			{
				self::__cache_init();
				self::$_cache->Set('landmarks|'. $LandmarkID, $obj, 0);
			}
		}
		else
		{
			while ( $row = $res->fetch_assoc() )
			{
				$row['FullName'] = $row['FullName'] = $row['Name'];;
				$obj[$row['LandmarkID']] = $row;
				
				if ( self::$cache === true )
				{
					self::__cache_init();
					self::$_cache->Set('landmarks|'. $row['LandmarkID'], $row, 0);
				}
			}
		}
		
		
		return $obj;
	}
	
	
	/**
		Получение ориентиров по фильтру
		@param array $filter
		@return array - массив объект
	*/
	public static function GetLandmarks( $filter, $with_count = false )
	{
		if ( !is_array($filter) )
			return array();
		
		// убиваем лишние поля профиля, чтобы запрос не посыпался
		if ( isset($filter['Status']) )
			unset ($filter['Status']);
		
		// заполняем незаполненные поля фильтра дефолтными значениями и получаем sql-условие
		self::__filter_set_defaults($filter);
		
		return LocationDataSource::GetLandmarks($filter, $with_count);;
	}
	
	/**
		Получение ориентира по имени
		@param $landmark_text - имя
		@param $location - расположение
		@param $width_create - если true и ориентира нет - создаст новый
		@return объект
	*/
	public static function GetLandmarkByName($landmark_text, $parent = null, $width_create = false)
	{		
		if ( !empty($landmark_text) && $parent !== null )
		{               
			 $filter = Location::ParseCode($parent);
			 $filter['ExactName'] = true;
			 $filter['Name'] = $landmark_text;
			 $filter['limit'] = 1;
			 $lm = self::GetLandmarks($filter);
			 if (is_array($lm) && isset($lm[0]['LandmarkID']))
				  return $lm[0]['LandmarkID'];
			 elseif ( $width_create )
			 {				  
				  $LID = self::AddLandmark($parent, $landmark_text);
				  return $LID;
			 }
		}
		
		return false;
	}
	
	
	/**
		Получение количества ориентиров по фильтру
		@param array $filter
		@return int - кол-во объектов
	*/
	public static function GetLandmarksCount( $filter )
	{
		if ( !is_array($filter) )
			return array();
		
		// заполняем незаполненные поля фильтра дефолтными значениями и получаем sql-условие
		self::__filter_set_defaults($filter);
		
		return LocationDataSource::GetLandmarksCount($filter);;
	}
	
	
	/**
		Получение подчиненных ориентиров по фильтру
		@param $Code - код объекта
		@param $filter - фильтр
		@param $directly - нопосредственно подчиненные объекты
		@return array - массив объектов
	*/
	public static function GetSubordinateLandmarks( $Code, $filter = array(), $level = false, $with_count = false )
	{
		// парсим код
		$pc = self::ParseCode($Code);
				
		// объединяем фильтр на основе кода вышестоящего объекта с фильтром
		$filter = array_merge( self::__filter_get_subordinates($pc,$level), $filter );
		
		return self::GetLandmarks($filter,$with_count);
	}
	
	
	/**
		Получение количества подчиненных ориентиров по фильтру
		@param string $Code - код объекта
		@param string $filter - фильтр
		@param int $level - уровень объектов
		@return int - кол-во объектов
	*/
	public static function GetSubordinateLandmarksCount( $Code, $filter = array(), $level = false )
	{
		// парсим код
		$pc = self::ParseCode($Code);
		
		// объединяем фильтр на основе кода вышестоящего объекта с фильтром
		$filter = array_merge( self::__filter_get_subordinates($pc,$level), $filter );
		
		return self::GetLandmarksCount($filter);
	}
	
	
	/**
		Получение вышестоящего объекта
		@param array $object - объект
		@return array - вышестоящий объект
		@exception InvalidArgumentMyException
	*/
	public static function GetParentObject($object, $level = false)
	{
		if ( !is_array($object) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::GetParentObject\'');
		
		$filter = self::__filter_get_parent($object,$level);
		
		return self::GetObjects($filter);
	}
	
	
	/**
		Получение городского района по идентификатору
		@param int $AreaID - идентификатор объекта
		@return array - объект
	*/
	public static function GetAreaByID( $AreaID, $from_master = false )
	{
		if ( !is_numeric($AreaID) && !is_array($AreaID) )
			return array();
		if ( is_numeric($AreaID) && $AreaID <= 0 )
			return array();
		if ( is_array($AreaID) && count($AreaID) == 0 )
			return array();
		
		// попробуем взять объекты из кэша
		if ( self::$cache === true && $_GET['nocache'] < 12 )
		{
			self::__cache_init();
			if ( is_array($AreaID) )
			{
				// грузим элементы из кэша, какие находим - ансетим, остальные провалятся дальше и получатся из базы
				foreach ( $AreaID as $k => $id )
				{
					$row = self::$_cache->Get('areas|'. $id);
					if ( is_array($row) )
					{
						$obj[$id] = $row;
						unset($AreaID[$k]);
					}
				}
				
				// если не осталось объектов - возвращаем результат
				if ( count($AreaID) == 0 )
					return $obj;
			}
			else
			{
				$obj = self::$_cache->Get('areas|'. $AreaID);
				if ( is_array($obj) )
					return $obj;
			}
		}
		
		
		$sql = "SELECT * FROM ". self::$_config['tables']['areas'];
		if ( is_array($AreaID) )
			if ( count($AreaID) > 1 )
				$sql.= " WHERE `AreaID` IN (". implode(',',$AreaID) .")";
			else if ( current($AreaID) > 0 )
				$sql.= " WHERE `AreaID` = ". current($AreaID);
			else
				return $obj;
		else
			$sql.= " WHERE `AreaID` = ". $AreaID;
		
		if ( $from_master === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		
		if ( $res === false )
			return array();
		
		if ( !is_array($AreaID) )
		{
			if ( false === ( $obj = $res->fetch_assoc() ) )
				return array();
			
			$obj['FullName'] = $obj['Name'] .' '. Location::GetAbbrByType($obj['Type']);
			
			if ( self::$cache === true )
			{
				self::__cache_init();
				self::$_cache->Set('areas|'. $AreaID, $obj, 0);
			}
		}
		else
		{
			while ( $row = $res->fetch_assoc() )
			{
				$row['FullName'] = $row['Name'] .' '. Location::GetAbbrByType($row['Type']);
				
				$obj[$row['AreaID']] = $row;
				
				if ( self::$cache === true )
				{
					self::__cache_init();
					self::$_cache->Set('areas|'. $row['AreaID'], $row, 0);
				}
			}
		}
		
		return $obj;
	}
	
	
	/**
		Получение списка городских районов по фильтру
		@param array $filter - фильтр
		@param bool $with_count - с количеством
		@return array - массив районов
	*/
	public static function GetAreas( $filter, $with_count = false )
	{
		// переопределяем фильтр только на нужные поля
		$filter = array(
			'ContinentCode'	=> $filter['ContinentCode'],
			'CountryCode'	=> $filter['CountryCode'],
			'RegionCode'	=> $filter['RegionCode'],
			'DistrictCode'	=> $filter['DistrictCode'],
			'CityCode'		=> $filter['CityCode'],
			//'VillageCode'	=> $filter['VillageCode'],				// деревня не может иметь районы - пытаемся взять от города
			'AreaCode'		=> $filter['AreaCode'],
			'Name'			=> $filter['Name'],
		);
		
		return LocationDataSource::GetAreas($filter, $with_count);
    }

	/**
		Получение количества городских районов по фильтру
		@param array $filter - фильтр
		@return int - кол-во районов
	*/
	public static function GetAreasCount( $filter )
	{		
		// переопределяем фильтр только на нужные поля
		$filter = array(
			'ContinentCode'	=> $filter['ContinentCode'],
			'CountryCode'	=> $filter['CountryCode'],
			'RegionCode'	=> $filter['RegionCode'],
			'DistrictCode'	=> $filter['DistrictCode'],
			'CityCode'		=> $filter['CityCode'],
			//'VillageCode'	=> $filter['VillageCode'],			// деревня не может иметь районы - пытаемся взять от города
		);
		
		return LocationDataSource::GetAreasCount($filter);
    }
	
	
	/**
		Получение сокращений
		@param array $filter - фильтр
		@return array - массив с сокращениями
	*/
	public static function GetAbbr( $filter = array(), $with_count = false )
	{
		if ( !isset($filter['offset']) )
			$filter['offset'] = 0;
		if ( !isset($filter['limit']) )
			$filter['limit'] = self::$limit;
		
		$where = array();
		if ( is_numeric($filter['id']) )
			$where[] = "SocrId = ". $filter['id'];
		if ( isset($filter['level']) && $filter['level'] >= 0 && $filter['level'] <= 7 )
			$where[] = "SocrLevel = ". $filter['level'];
		
		$sql = "SELECT ";
		if ( $with_count === true )
			$sql.= "SQL_CALC_FOUND_ROWS ";
		$sql.= "* FROM ". self::$_config['tables']['abbr'];
		if ( count($where) > 0 )		
			$sql.= " WHERE ".implode(' AND ',$where);
		$sql.= " ORDER BY `SocrAbbr`";
		$sql.= " LIMIT ". $filter['offset'] .", ". $filter['limit'];
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		if ( $filter['from_master'] === true )
			$res = $db->query($sql);
		else
			$res = $db->query($sql);
		
		if ( $res === false )
			return array();
		
		if ( $with_count === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			if ( $filter['from_master'] === true )
				list($count) = $db->query($sql)->fetch_row();
			else
				list($count) = $db->query($sql)->fetch_row();
		}
		
		$data = array();
		while ( $row = $res->fetch_assoc() )
			$data[] = $row;
		
		if ( $with_count === true )
			return array($data,$count);
		
		return $data;
	}
	
	
	/**
		Получение сокращения по типу
		типы кэшируются
		@param int $Type - тип объекта
		@return string - сокращение
	*/
	public static function GetAbbrByType($Type, $Text = false, $from_master = false)
	{
		if ( intval($Type) == 0 )
			return '';
		
		if ( is_array(self::$_types) ) {
			if ($Text === true)
				return self::$_types[$Type]['SocrText'];
			return self::$_types[$Type]['SocrAbbr'];
		}
		
		if ( self::$cache === true )
		{
			self::__cache_init();
			self::$_types = self::$_cache->Get('types');
		}
		
		if ( self::$cache === false || self::$_types === false )
		{
			$sql = "SELECT * FROM ". self::$_config['tables']['abbr'];
			if ( $from_master === true )
				$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			else
				$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			
			while ( $row = $res->fetch_assoc() )
				self::$_types[$row['SocrId']] = $row;
						
			if ( self::$cache === true )
				self::$_cache->Set('types',self::$_types,3600);
		}
		
		if ($Text === true)
			return self::$_types[$Type]['SocrText'];

		return self::$_types[$Type]['SocrAbbr'];
	}
	
	
	
	/**
		Получение типа по сокращению
		типы кэшируются
		@param int $Socr - сокращение
		@return string - тип
	*/
	public static function GetTypeByAbbr($Socr, $from_master = false)
	{		
		if ( self::$cache === true )
		{
			self::__cache_init();
			self::$_types = self::$_cache->Get('types');
		}
		
		if ( self::$cache === false || self::$_types === false )
		{
			$sql = "SELECT * FROM ". self::$_config['tables']['abbr'];
			if ( $from_master === true )
				$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			else
				$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			
			while ( $row = $res->fetch_assoc() )
				self::$_types[$row['SocrId']] = $row;
						
			if ( self::$cache === true )
				self::$_cache->Set('types',self::$_types,3600);
		}
		
		foreach ( self::$_types as $Type => $Abbr )
		{
			if ( $Abbr['SocrAbbr'] == $Socr )
				return $Type;
		}
		
		return 0;
	}
	
	
	/**
		Возвращает код, разбитый на сегменты в массив
		@param string $code - код объекта
		@return array
		@exception InvalidArgumentMyException
	*/
	public static function ParseCode( $code, $is_area_code = false )
	{
		if ( empty($code) )
			return array();
		if ( !is_string($code) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::ParseCode\'');
		
		$ContinentCode 	= substr($code, 0, 3);
		$CountryCode 	= substr($code, 3, 3);
		$RegionCode 	= substr($code, 6, 3);
		$DistrictCode 	= substr($code, 9, 3);
		$CityCode 		= substr($code, 12, 3);
		$VillageCode 	= substr($code, 15, 3);
		if ( $is_area_code == false )
		{
			$StreetCode 	= substr($code, 18, 4);
			$LandmarkCode 	= substr($code, 22, 4);		
		}
		else
			$AreaCode 		= substr($code, 18, 3);
		
		$result = array();
		if ( $ContinentCode !== false && $ContinentCode != '???' )
			$result['ContinentCode'] = $ContinentCode;
		if ( $CountryCode !== false && $CountryCode != '???'  )
			$result['CountryCode'] = $CountryCode;
		if ( $RegionCode !== false && $RegionCode != '???'  )
			$result['RegionCode'] = $RegionCode;
		if ( $DistrictCode !== false && $DistrictCode != '???'  )
			$result['DistrictCode'] = $DistrictCode;
		if ( $CityCode !== false && $CityCode != '???'  )
			$result['CityCode'] = $CityCode;
		if ( $VillageCode !== false && $VillageCode != '???'  )
			$result['VillageCode'] = $VillageCode;
		if ( $is_area_code == false )
		{
			if ( $StreetCode !== false && $StreetCode != '????'  )
				$result['StreetCode'] = $StreetCode;
			if ( $LandmarkCode !== false && $LandmarkCode != '????'  )
				$result['LandmarkCode'] = $LandmarkCode;
		}
		else
			if ( $AreaCode !== false && $AreaCode != '???'  )
				$result['AreaCode'] = $AreaCode;			
		
		return $result;
	}
	
	
	/**
		Транслитерация наименования
		@param string $name - наименование
		@param mixed $code - код объекта
		@param bool $unique - признак уникальности
		@params array $exclude_code - коды исключений
		@return string - новое наименование
	*/
	public static function Transliterate($name, $code = null, $unique = false, $exclude_code = null)
	{
		LibFactory::GetStatic('translit');
		
		$isunique = !$unique;
		
		$tname = '';
		
		do {
			$name = Translit::Convert($name, 'ru', 'en');
			$name = str_replace("'", "", $name);
			$name = str_replace("`", "", $name);
			$name = str_replace(" ", "", $name);
			
			$tname = $name.$tname;
			if($isunique === true)
				break;
			
			$sql = "SELECT * FROM ". self::$_config['tables']['objects'];
			$sql.= " WHERE `TransName` = '". addslashes($tname) ."'";
			if ( $exclude_code !== null )
				$sql.= " AND Code = '". $exclude_code. "'";
			
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
			if ( $row = $res->fetch_assoc() )
			{
				$pobj = self::GetParentObject(self::ParseCode($code));
				
				if ( $pobj === null || !is_array($pobj) || count($pobj) === 0 )
					break;
				$code = $pobj[0]['Code'];
				$name = $pobj[0]['Name'];
			}
			else
				$isunique = true;
		} while ( $isunique !== true );
		
		return $tname;
	}
	
	
	/**
		Приведение адреса к нормализованному виду
		@param mixed $Code - код объекта
		@param array $use_levels - уровни объектов, которые нужно включать в нормализацию
		@param array $use_types - определяет для каких уровней добавить аббревиатуру объекта
		@param bool $add_full_types - дополнительно добавляет к аббревиалуре ее расшифровку (нужно для сфинкса), например, "Ленина ул Улица"
		@return string - адрес объекта
	*/
	public static function Normalize($Code, 
					$use_levels = array(
						self::OL_CONTINENTS		=> false,
						self::OL_COUNTRIES		=> false,
						self::OL_REGIONS		=> true,
						self::OL_DISTRICTS		=> true,
						self::OL_CITIES			=> true,
						self::OL_VILLAGES		=> true,
						self::OL_STREETS		=> true,
					),
					$use_types = array(
						self::OL_CONTINENTS		=> false,
						self::OL_COUNTRIES		=> false,
						self::OL_REGIONS		=> true,
						self::OL_DISTRICTS		=> true,
						self::OL_CITIES			=> true,
						self::OL_VILLAGES		=> true,
						self::OL_STREETS		=> true,
					),
					$add_full_types = false
				)
	{
		if ( is_string($Code) && !empty($Code) )
			$pc = self::ParseCode($Code);
		else if ( is_array($Code) )
			$pc = $Code;
		else
			return '';
		
		$result = array();
		
		$object = self::GetObjects($pc);		
		if ( !is_array($object[0]) )
			return '';
		
		
		$level = self::ObjectLevel($pc);
		
		$i = 0;		
		while ( $level >= self::OL_CONTINENTS && $i <= self::OL_LANDMARKS )
		{
			$i++;
			if ( $use_types[$level] )
			{
				if ( end($result) != $object[0]['FullName'] && $use_levels[$level] === true )
					array_unshift($result, (
							$add_full_types !== true ? $object[0]['FullName'] : $object[0]['FullName'] .' '. Location::GetAbbrByType($object[0]['Type'], true)
						));
			}
			else
			{
				if ( end($result) != $object[0]['Name'] && $use_levels[$level] === true )
					array_unshift($result, $object[0]['Name']);
			}
			$object = self::GetParentObject(self::ParseCode($object[0]['Code']));
			$level = self::ObjectLevel(self::ParseCode($object[0]['Code']));
		}
		
		unset($object, $pc, $level);
		
		return implode(', ',$result);		
	}	
	
	public static function GetBuildingsList($ObjectID) {
		if ( $ObjectID <= 0 )
			return null;
	
		$sql = 'SELECT * FROM '. self::$_config['tables']['buildings'];
		$sql.= ' WHERE ObjectID = '.$ObjectID;
		$sql.= ' ORDER by Ord ASC, House ASC ';
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return null;
		
		$list = array();
		while (false != ($row = $res->fetch_assoc()))
			$list[] = $row;
			
		return $list;
	}
	
	public static function GetBuildByID($BuildID) {
		if ( $BuildID <= 0 )
			return null;
	
		$sql = 'SELECT * FROM '. self::$_config['tables']['buildings'];
		$sql.= ' WHERE BuildID = '.(int) $BuildID;
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return null;
		
		return $res->fetch_assoc();
	}
	
	public static function AddBuild($ObjectID, array $info) {
		if ( $ObjectID <= 0 )
			return false;
	
		$sql = 'SELECT * FROM '. self::$_config['tables']['objects'];
		$sql.= ' WHERE ObjectID = '.(int) $ObjectID;
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return false;
		
		$info = array_change_key_case($info, CASE_LOWER);
		if (empty($info) || empty($info['house']))
			return false;
		
		if (!preg_match("@^\d+(-[\xc0-\xdf0-9]+)?$@i", $info['house']))
			return false;
		
		$info['ord']	= ($info['ord'] <= 0 ? 0 : $info['ord']);
		$info['isvisible']= ($info['isvisible'] ? 1 : 0);
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		
		$sql = 'SELECT BuildID FROM '.self::$_config['tables']['buildings'];
		$sql.= ' WHERE ObjectID = '.$ObjectID;
		$sql.= ' AND House = \''.strtoupper($info['house']).'\'';
		
		if (false == ($res = $db->query($sql)))
			return false;
			
		if ($res->num_rows) {
			$row = $res->fetch_row();
			return $row[0];
		}
		
		$sql = 'INSERT INTO '.self::$_config['tables']['buildings'];
		$sql.= ' SET ObjectID = '.$ObjectID;
		$sql.= ' , House = \''.strtoupper($info['house']).'\'';
		$sql.= ' , isvisible = \''.$info['isvisible'].'\'';
		$sql.= ' , Ord = '.(int) $info['ord'];
		
		if (false == $db->query($sql))
			return false;
			
		return $db->insert_id;
	}
	
	public static function EditBuild($BuildID, array $info) {
		if ( $BuildID <= 0 )
			return false;
	
		$sql = 'SELECT * FROM '. self::$_config['tables']['buildings'];
		$sql.= ' WHERE BuildID = '.(int) $BuildID;
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return false;
		
		$info = array_change_key_case($info, CASE_LOWER);
		if (empty($info))
			return false;
		
		if (isset($info['house']) && (empty($info['house']) || !preg_match("@^\d+(-[\xc0-\xdf0-9]+)?$@i", $info['house'])))
			return false;
		
		if (isset($info['ord']))
			$info['ord']	= ($info['ord'] <= 0 ? 0 : $info['ord']);
			
		if (isset($info['isvisible']))
			$info['isvisible'] = ($info['isvisible'] ? 1 : 0);
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		
		foreach($info as $k => $v)
			$info[$k] = "`$k` = '".addslashes($v)."'";
		
		$sql = 'UPDATE '.self::$_config['tables']['buildings'];
		$sql.= ' SET '.implode(',', $info);
		$sql.= ' WHERE BuildID = '.(int) $BuildID;

		if (false == $db->query($sql))
			return false;
			
		return true;
	}
	
	public static function DeleteBuild($BuildID)
	{
		if ( $BuildID <= 0 )
			return false;
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		$sql = 'DELETE FROM '.self::$_config['tables']['buildings'];
		$sql.= ' WHERE BuildID = '.(int) $BuildID;

		if (false == $db->query($sql))
			return false;
			
		LibFactory::GetStatic('filestore');
		$list = Location::GetBuildingsPicturesList($BuildID);
		foreach($list as $Picture)
		{
			if ( !empty($Picture['ImageSmall']) )
			{
				try
				{
					FileStore::Delete_NEW(FileStore::GetPath_NEW($Picture['ImageSmall']));
				}
				catch ( MyException $e ) {}
			}
			
			if ( !empty($Picture['ImageBig']) )
			{
				try
				{
					FileStore::Delete_NEW(FileStore::GetPath_NEW($Picture['ImageBig']));
				}
				catch ( MyException $e ) {}
			}
			
			$sql = 'DELETE FROM '.self::$_config['tables']['pictures'];
			$sql.= ' WHERE PictureID = '.(int) $PictureID;
			$db->query($sql);
		}
		
		return true;
	}
	
	
	public static function GetBuildPictureByID($PictureID) {
		if ( $PictureID <= 0 )
			return null;
	
		$sql = 'SELECT * FROM '. self::$_config['tables']['pictures'];
		$sql.= ' WHERE PictureID = '.(int) $PictureID;
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return null;
		
		return $res->fetch_assoc();
	}
	
	public static function AddBuildPicture($BuildID, $Name, array $info)
	{
		if ( $BuildID <= 0 )
			return false;
		
		$sql = 'SELECT * FROM '. self::$_config['tables']['buildings'];
		$sql.= ' WHERE BuildID = '.(int) $BuildID;
		
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if (!$res || !$res->num_rows)
			return false;
		
		LibFactory::GetStatic('filemagic');
		LibFactory::GetStatic('filestore');
		
		$info = array_change_key_case($info, CASE_LOWER);		
		$info['ord']	= ($info['ord'] <= 0 ? 0 : $info['ord']);
		$info['isvisible']= ($info['isvisible'] ? 1 : 0);
		
		// big photo
		try
		{
			$big_pname = FileStore::Upload_NEW(
					$Name, self::$_config['_images_dir'], $BuildID.'_b_'.rand(9,99999),
					FileMagic::MT_WIMAGE, self::$_config['_photo_file_size'],
					array(
						'resize' => array(
							'tr' => 0,
							'w'  => self::$_config['_photo_big_size']['max_height'],
							'h'  => self::$_config['_photo_big_size']['max_width'],
						),
					)
				);
		}
		catch ( MyException $e )
		{
			return false;
		}
		
		
		// small photo
		try
		{
			$small_pname = FileStore::Upload_NEW(
					$Name, self::$_config['_images_dir'], $BuildID.'_s_'.rand(9,99999),
					FileMagic::MT_WIMAGE, self::$_config['_photo_file_size'],
					array(
						'resize' => array(
							'tr' => 0,
							'w'  => self::$_config['_photo_small_size']['max_height'],
							'h'  => self::$_config['_photo_small_size']['max_width'],
						),
					)
				);
		}
		catch ( MyException $e )
		{
			try
			{
				FileStore::Delete_NEW( self::$_config['_images_dir'] . FileStore::GetPath($big_pname) );
			}
			catch ( MyException $e ) {}
			return false;
		}
		// end photo
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		
		$sql = 'INSERT INTO '.self::$_config['tables']['pictures'];
		$sql.= ' SET BuildID = '.$BuildID;
		$sql.= ' , isvisible = \''.$info['isvisible'].'\'';
		$sql.= ' , ImageBig = \''.$big_pname.'\'';
		$sql.= ' , ImageSmall = \''.$small_pname.'\'';
		$sql.= ' , Ord = '.(int) $info['ord'];
		
		if (false == $db->query($sql))
			return false;
			
		return $db->insert_id;
	}
	
	public static function EditBuildPicture($PictureID, $Name, array $info)
	{
		if ( $PictureID <= 0 )
			return false;
	
		$Picture = self::GetBuildPictureByID($PictureID);
		if (empty($Picture))
			return false;
		
		$info = array_change_key_case($info, CASE_LOWER);		
		if (isset($info['ord']))
			$Picture['Ord']	= ($info['ord'] <= 0 ? 0 : $info['ord']);
			
		if (isset($info['isvisible']))
			$Picture['IsVisible'] = ($info['isvisible'] ? 1 : 0);
		
		if (isset($_FILES[$Name]))
		{
			LibFactory::GetStatic('filemagic');
			LibFactory::GetStatic('filestore');
			
			// big photo
			try
			{
				$big_pname = FileStore::Upload_NEW(
						$Name, self::$_config['_images_dir'], $PictureID.'_b',
						FileMagic::MT_WIMAGE, self::$_config['_photo_file_size'],
						array(
							'resize' => array(
								'tr' => 0,
								'w'  => self::$_config['_photo_big_size']['max_height'],
								'h'  => self::$_config['_photo_big_size']['max_width'],
							),
						)
					);
			}
			catch ( MyException $e )
			{
				return false;
			}
			
			
			// small photo
			try
			{
				$small_pname = FileStore::Upload_NEW(
						$Name, self::$_config['_images_dir'], $PictureID.'_s',
						FileMagic::MT_WIMAGE, self::$_config['_photo_file_size'],
						array(
							'resize' => array(
								'tr' => 0,
								'w'  => self::$_config['_photo_small_size']['max_height'],
								'h'  => self::$_config['_photo_small_size']['max_width'],
							),
						)
					);
			}
			catch ( MyException $e )
			{
				try
				{
					FileStore::Delete_NEW( self::$_config['_images_dir'] . FileStore::GetPath($big_pname));
				}
				catch ( MyException $e ) {}
				return false;
			}
			// end photo
			
			try
			{
				FileStore::Delete_NEW( self::$_config['_images_dir'] . FileStore::GetPath_NEW($Picture['ImageSmall']));
			}
			catch ( MyException $e ) {}
			try
			{
				FileStore::Delete_NEW( self::$_config['_images_dir'] . FileStore::GetPath_NEW($Picture['ImageBig']));
			}
			catch ( MyException $e ) {}
			
			$Picture['ImageBig'] = $big_pname;
			$Picture['ImageSmall'] = $small_pname;
		}
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		
		$sql = 'UPDATE '.self::$_config['tables']['pictures'];
		$sql.= ' SET ';
		$sql.= ' IsVisible = \''.$Picture['IsVisible'].'\'';
		$sql.= ' , ImageBig = \''.$Picture['ImageBig'].'\'';
		$sql.= ' , ImageSmall = \''.$Picture['ImageSmall'].'\'';
		$sql.= ' , Ord = '.(int) $Picture['Ord'];
		$sql.= ' WHERE PictureID = '.$PictureID;
		
		if (false == $db->query($sql))
			return false;
			
		return true;
	}
	
	public static function DeleteBuildPicture($PictureID)
	{
		$Picture = self::GetBuildPictureByID($PictureID);
		if ( empty($Picture) )
			return false;
		
		LibFactory::GetStatic('filestore');
		
		try
		{
			FileStore::Delete_NEW(self::$_config['_images_dir'] . FileStore::GetPath_NEW($Picture['ImageSmall']));
		}
		catch ( MyException $e ) {}
		
		try
		{
			FileStore::Delete_NEW(self::$_config['_images_dir'] . FileStore::GetPath_NEW($Picture['ImageBig']));
		}
		catch ( MyException $e ) {}
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		$sql = 'DELETE FROM '.self::$_config['tables']['pictures'];
		$sql.= ' WHERE PictureID = '.(int) $PictureID;
		
		if (false == $db->query($sql))
			return false;
			
		return true;
	}
	
	/**
		Получение списка картинок для объекта
	*/
	public static function GetBuildingsPicturesList($filter) {
		
		$Build = self::GetBuildByID($BuildID);
		
		$sql = 'SELECT p.* FROM '. self::$_config['tables']['pictures'].' as p';
		$sql.= ' INNER JOIN '. self::$_config['tables']['buildings'].' as b ON(b.BuildID = p.BuildID)';
		$sql.= ' INNER JOIN '. self::$_config['tables']['objects'].' as o ON(o.ObjectID = b.ObjectID)';
		$sql.= ' WHERE ';
		
		$where = array();
		
		if ( isset($filter['BuildID']) )
			$where[] = ' b.`BuildID` = '. (int) $filter['BuildID'];
			
		if ( isset($filter['ObjectID']) )
			$where[] = ' b.`ObjectID` = '. (int) $filter['ObjectID'];
			
		if ( isset($filter['House']) )
			$where[] = ' b.`House` = \''.addslashes($filter['House']).'\'';
		
		if ( isset($filter['Code']) )
			$where[] = ' o.`Code` = \''.addslashes($filter['Code']).'\'';
		
		if ( isset($filter['IsVisible']) && $filter['IsVisible'] != -1 )
			$where[] = ' p.`IsVisible` = '. ($filter['IsVisible'] ? 1 : 0);
		
		$sql.= implode(' AND ', $where);
		
		$sql.= ' ORDER by p.Ord ASC';
		
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');
		
		$data = array();
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		if ( $res === false )
			return $data;
		
		while (false != ($row = $res->fetch_assoc()))
		{
			if ( !empty($row['ImageSmall']) )
			{
				try
				{
					$pname = FileStore::GetPath_NEW($row['ImageSmall']);
				}
				catch ( MyException $e )
				{
					$pname = '';
				}
				$row['ImageSmall'] = Images::PrepareImage_NEW($pname, self::$_config['_images_dir'], self::$_config['_images_url']);
			}
			
			if ( !empty($row['ImageBig']) )
			{
				try
				{
					$pname = FileStore::GetPath_NEW($row['ImageBig']);
				}
				catch ( MyException $e )
				{
					$pname = '';
				}
				$row['ImageBig'] = Images::PrepareImage_NEW($pname, self::$_config['_images_dir'], self::$_config['_images_url']);
			}
			
			$data[$row['PictureID']] = $row;
		}
		return $data;
	}
	
	/**
		Получение кода для нового объекта
		@param string $Code - код вышестоящего объекта
		@param int $level - уровень объектов
		@return string - код объекта
	*/
	public static function GetNewCode( $Code, $level = self::OL_LANDMARKS )
	{
		$code = Location::ParseCode($Code);
		
		if ( $level == self::OL_LANDMARKS )
			$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'] . $code['CityCode'] . $code['VillageCode'] . $code['LandmarkCode'];
		else if ( $level == self::OL_STREETS )
			$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'] . $code['CityCode'] . $code['VillageCode'];
		else if ( $level == self::OL_VILLAGES )
			$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'] . $code['CityCode'];
		else if ( $level == self::OL_CITIES)
			$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'];
		else if ( $level == self::OL_DISTRICTS )
			$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'];
		else if ( $level == self::OL_REGIONS )
			$pcode = $code['ContinentCode'] . $code['CountryCode'];
		else if ( $level == self::OL_COUNTRIES )
			$pcode = $code['ContinentCode'];
		else if ( $level == self::OL_CONTINENTS )
			$pcode = '';
		
		$sql = "SELECT `Code` FROM `". ( $level == self::OL_LANDMARKS ? self::$_config['tables']['landmarks'] : self::$_config['tables']['objects'] ) ."` WHERE `Code` LIKE '". $pcode ."%' ORDER BY `Code` DESC LIMIT 1";
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);		
		
		if ( $res === false )
			return '';
		
		list($lastcode) = $res->fetch_row();
		
		if ( empty($lastcode) )
			return '';
		
		$lastcode = Location::ParseCode($lastcode);
		
		
		/*
			КТО ТУТ ПРИВЕДЕНИЕ К МАССИВУ ДОБАВИЛ, СОЗНАВАЙТЕСЬ, РЕДИСКИ ?!!
			И ЗАЧЕМ ?!  Фарид.
		*/
		
		if ( $level == self::OL_LANDMARKS )
		{
			$lastcode['LandmarkCode'] = base_convert($lastcode['LandmarkCode'], 36, 10);
			$lastcode['LandmarkCode']++;
			$code['LandmarkCode'] = str_pad(base_convert($lastcode['LandmarkCode'], 10, 36),4,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_STREETS )
		{
			$lastcode['StreetCode'] = base_convert($lastcode['StreetCode'], 36, 10);
			$lastcode['StreetCode']++;
			$code['StreetCode'] = str_pad(base_convert($lastcode['StreetCode'], 10, 36),4,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_VILLAGES )
		{
			$lastcode['VillageCode'] = base_convert($lastcode['VillageCode'], 36, 10);
			$lastcode['VillageCode']++;
			$code['VillageCode'] = str_pad(base_convert($lastcode['VillageCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_CITIES )
		{
			$lastcode['CityCode'] = base_convert($lastcode['CityCode'], 36, 10);
			$lastcode['CityCode']++;
			$code['CityCode'] = str_pad(base_convert($lastcode['CityCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_DISTRICTS )
		{
			$lastcode['DistrictCode'] = base_convert($lastcode['DistrictCode'], 36, 10);
			$lastcode['DistrictCode']++;
			$code['DistrictCode'] = str_pad(base_convert($lastcode['DistrictCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_REGIONS )
		{
			$lastcode['RegionCode'] = base_convert($lastcode['RegionCode'], 36, 10);
			$lastcode['RegionCode']++;
			$code['RegionCode'] = str_pad(base_convert($lastcode['RegionCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_COUNTRIES )
		{
			$lastcode['CountryCode'] = base_convert($lastcode['CountryCode'], 36, 10);
			$lastcode['CountryCode']++;
			$code['CountryCode'] = str_pad(base_convert($lastcode['CountryCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		else if ( $level == self::OL_CONTINENTS )
		{
			$lastcode['ContinentCode'] = base_convert($lastcode['ContinentCode'], 36, 10);
			$lastcode['ContinentCode']++;
			$code['ContinentCode'] = str_pad(base_convert($lastcode['ContinentCode'], 10, 36),3,'0',STR_PAD_LEFT);
		}
		
		$new_code =	$code['ContinentCode'] . $code['CountryCode'] .	$code['RegionCode'] .
			$code['DistrictCode'] .	$code['CityCode'] .	$code['VillageCode'] . $code['StreetCode'];
		
		if ( $level == self::OL_LANDMARKS )
			$new_code .= $code['LandmarkCode'];
		
		return $new_code;
	}
	
	
	/**
		Получение кода для нового района города
		@param string $Code - код вышестоящего объекта
		@return array - распарсенный код объекта
	*/
	public static function GetNewAreaCode( $Code )
	{
		$code = Location::ParseCode($Code);
		
		$pcode = $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'] . $code['CityCode'] . $code['VillageCode'];
		
		$sql = "SELECT `Code` FROM `". self::$_config['tables']['areas'] ."` WHERE `Code` LIKE '". $pcode ."%' ORDER BY `Code` DESC LIMIT 1";
		$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);		
		
		if ( $res === false )
			return '';
		
		list($lastcode) = $res->fetch_row();
		
		if ( empty($lastcode) )
			return $code['ContinentCode'] . $code['CountryCode'] . $code['RegionCode'] . $code['DistrictCode'] . $code['CityCode'] . $code['VillageCode'] .'001';
		
		$lastcode = Location::ParseCode($lastcode,true);
		
		$lastcode['AreaCode'] = base_convert($lastcode['AreaCode'], 36, 10);
		$lastcode['AreaCode']++;
		$code['AreaCode'] = str_pad(base_convert($lastcode['AreaCode'], 10, 36),3,'0',STR_PAD_LEFT);
				
		$new_code =	$code['ContinentCode'] . $code['CountryCode'] .	$code['RegionCode'] .
			$code['DistrictCode'] .	$code['CityCode'] .	$code['VillageCode'] . $code['AreaCode'];
		
		return $new_code;
	}
	
	
	/**
		Чистка кэша
		@param string $type - тип кэша		
	*/
	public static function ClearCache($type, $id = null)
	{
		if ( $type == 'types' )		
		{
			self::__cache_init();
			self::$_cache->Remove('types');
		}
		else if ( $type == 'objects' )
		{
			self::__cache_init();
			self::$_cache->Remove('objects|'. $id);
		}
		else if ( $type == 'landmarks' )
		{
			self::__cache_init();
			self::$_cache->Remove('landmarks|'. $id);
		}
	}
	
	
	/**
		Добавка ориентира
		@param string $parent - Код родительского объекта
		@param string $Name - наименование ориентира
	*/
	public function AddLandmark($parent,$Name)
	{
		if ( empty($parent) || empty($Name) )
			return false;
		
		$pc = self::ParseCode($parent);
		
		$sql = "INSERT INTO ". self::$_config['tables']['landmarks'] ." SET ";
		$sql.= " `Code` = '". addslashes($parent) ."',";
		$sql.= " `Name` = '". addslashes($Name) ."',";
		$sql.= " `ContinentCode` = '". $pc['ContinentCode'] ."',";
		$sql.= " `CountryCode` = '". $pc['CountryCode'] ."',";
		$sql.= " `RegionCode` = '". $pc['RegionCode'] ."',";
		$sql.= " `DistrictCode` = '". $pc['DistrictCode'] ."',";
		$sql.= " `CityCode` = '". $pc['CityCode'] ."',";
		$sql.= " `VillageCode` = '". $pc['VillageCode'] ."',";
		$sql.= " `StreetCode` = '". $pc['StreetCode'] ."'";
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		$res = $db->query($sql);		
		if ( $res === false )
			return false;
		
		return $db->insert_id;
	}
	
	/**
		Получение уровня объекта по распарсенному коду
		@param array $object - объект
		@return int - уровень объекта
		@exception InvalidArgumentMyException
	*/
	public static function ObjectLevel( $object )
	{
		if ( !is_array($object) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::ObjectLevel\'');
		
		if ( isset($object['LandmarkCode']) && $object['LandmarkCode'] !== null && $object['LandmarkCode'] !== '0000' )
			return self::OL_LANDMARKS;
		if ( isset($object['StreetCode']) && $object['StreetCode'] !== null && $object['StreetCode'] !== '0000' )
			return self::OL_STREETS;
		if ( isset($object['VillageCode']) && $object['VillageCode'] !== null && $object['VillageCode'] !== '000' )
			return self::OL_VILLAGES;
		if ( isset($object['CityCode']) && $object['CityCode'] !== null && $object['CityCode'] !== '000' )
			return self::OL_CITIES;
		if ( isset($object['DistrictCode']) && $object['DistrictCode'] !== null && $object['DistrictCode'] !== '000' )
			return self::OL_DISTRICTS;
		if ( isset($object['RegionCode']) && $object['RegionCode'] !== null && $object['RegionCode'] !== '000' )
			return self::OL_REGIONS;
		if ( isset($object['CountryCode']) && $object['CountryCode'] !== null && $object['CountryCode'] !== '000' )
			return self::OL_COUNTRIES;
		return self::OL_CONTINENTS;
	}
	
	// определение подчиненности объекта по коду
	public static function IsSubordinateTo( $Object, $To )
	{
		$To = rtrim($To,'0');
		return (substr($Object, 0, strlen($To)) == $To);
	}
	
	//Получить часть кода по уровню
	public static function GetPartcodeByLevel($Code, $level = null)
	{
		if ($level == null)
			$level = self::ObjectLevel(self::ParseCode($Code));
			
		if ($level==Location::OL_CONTINENTS)
			return substr($Code, 0, 3);
		if ($level==Location::OL_COUNTRIES)
			return substr($Code, 0, 6);
		elseif($level==Location::OL_REGIONS)
			return substr($Code, 0, 9);
		elseif($level==Location::OL_DISTRICTS)
			return substr($Code, 0, 12);
		elseif($level==Location::OL_CITIES)
			return substr($Code, 0, 15);
		elseif($level==Location::OL_VILLAGES)
			return substr($Code, 0, 18);
		elseif($level==Location::OL_STREETS)
			return substr($Code, 0, 22);
		else
			return $Code;
	}

	/**
		Получение веса объекта основанного на уровне подчиненности
		@param array $object - объект
		@return int - уровень объекта
		@exception InvalidArgumentMyException
	*/
	public static function GetObjectWeight( $object )
	{
		if ( !is_array($object) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::ObjectLevel\'');
		
		$weight = 0;
		
		for ( $i = 0; $i < 7; $i++ )
		{
			if ( $i == 6 )
			{
				if ( substr($object['Code'], $i*3, 4) !== '0000' )
					$weight += 10;
			}
			else
			{
				$v = substr($object['Code'], $i*3, 3);
				if (  $v !== '000' )
					$weight += ($v === '001' ? 5 : 10 );
			}
		}
		
		return $weight + (10 - $object['Status']) + 1;
	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// инициализация кэша
	private static function __cache_init()
	{
		if ( self::$_cache === null )
		{
			LibFactory::GetStatic('cache');		
			self::$_cache = new Cache();
			self::$_cache->Init('memcache', 'location', self::$_cache_params);
		}
	}
	
	// корректировка фильтра
	private static function __filter_set_defaults( &$filter )
	{
		if ( !isset($filter['limit']) )
			$filter['limit'] = self::$limit;
		if ( !isset($filter['offset']) )
			$filter['offset'] = 0;
		if ( !isset($filter['field']) )
			$filter['field'] = 'Name';
		if ( !isset($filter['dir']) )
			$filter['dir'] = 'ASC';
		if ( !isset($filter['ActualCode']) )
			$filter['ActualCode'] = self::AC_OBJ_ACTUAL;
		if ( !isset($filter['IsVisible']) )
			$filter['IsVisible'] = 1;
	}
	
	/**
		Получение фильтра кода для подчиненных объектов по распарсенному коду вышестоящего объекта
		@param array $object - объект
		@return array
		@exception InvalidArgumentMyException
	*/
	private static function __filter_get_subordinates( $object, $level = false )
	{
		if ( !is_array($object) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::__filter_get_subordinates\'');
		
		// получим уровень объекта по его коду
		if ( $level === false )
			$cur_level = self::ObjectLevel($object);
		else
			$cur_level = $level;

		if ( $level < 0 || $level > 6 || $cur_level < 0 )
			return array();
		
		// убираем незначимые части фильтра
		if ( $cur_level < 7 )
			unset($object['LandmarkCode']);
		if ( $cur_level < 6 )
			unset($object['StreetCode']);
		if ( $cur_level < 5 )
			unset($object['VillageCode']);
		if ( $cur_level < 4 )
			unset($object['CityCode']);
		if ( $cur_level < 3 )
			unset($object['DistrictCode']);
		if ( $cur_level < 2 )
			unset($object['RegionCode']);
		if ( $cur_level < 1 )
			unset($object['CountryCode']);
		
		// если уровень не указан - берутся подчиненные объекты со всех уровней
		if ( $level === false )
			return $object;
		
		// если нужны объекты конкретного уровня - корректируем фильтр
		/*if ( isset($object['LandmarkCode']) )*/
			if ( $level == self::OL_LANDMARKS )
				$object['LandmarkCode'] = -1;
			/*else
				$object['LandmarkCode'] = '0000';*/
		
		if ( $level < self::OL_LANDMARKS )
			if ( $level == self::OL_STREETS )
				$object['StreetCode'] = -1;
			else
				$object['StreetCode'] = '0000';
		
		if ( $level < self::OL_STREETS )
			if ( $level == self::OL_VILLAGES )
				$object['VillageCode'] = -1;
			else
				$object['VillageCode'] = '000';
		
		if ( $level < self::OL_VILLAGES )
			if ( $level == self::OL_CITIES )
				$object['CityCode'] = -1;
			else
				$object['CityCode'] = '000';
		
		if ( $level < self::OL_CITIES )
			if ( $level == self::OL_DISTRICTS )
				$object['DistrictCode'] = -1;
			else
				$object['DistrictCode'] = '000';
				
		if ( $level < self::OL_DISTRICTS )
			if ( $level == self::OL_REGIONS )
				$object['RegionCode'] = -1;
			else
				$object['RegionCode'] = '000';
		
		if ( $level < self::OL_REGIONS )
			if ( $level == self::OL_COUNTRIES )
				$object['CountryCode'] = -1;
			else
				$object['CountryCode'] = '000';
		
		if ( $level == self::OL_CONTINENTS )
			$object['ContinentCode'] = -1;
		
		/*echo "<br><br>".
			$object['ContinentCode'].".".$object['CountryCode'].".".$object['RegionCode'].".".
			$object['DistrictCode'].".".$object['CityCode'].".".$object['VillageCode'].".".$object['StreetCode'];*/
		
		return $object;
	}
	
	// получение фильтра для вышестоящего объекта
	private static function __filter_get_parent($object,$level = false)
	{
		if ( !is_array($object) )
			throw new InvalidArgumentMyException('Invalid argument supplied for function \'Location::__filter_get_parent\'');
		
		// получим уровень объекта по его коду
		if ( $level === false )
			$level = self::ObjectLevel($object);
		
		if ( $level < 0 || $level > 7 )
			return array();

		if ( $level <= self::OL_STREETS )
			$object['StreetCode'] = '0000';
		if ( $level <= self::OL_VILLAGES )
			$object['VillageCode'] = '000';
		if ( $level <= self::OL_CITIES )
			$object['CityCode'] = '000';
		if ( $level <= self::OL_DISTRICTS )
			$object['DistrictCode'] = '000';
		if ( $level <= self::OL_REGIONS )
			$object['RegionCode'] = '000';
		if ( $level <= self::OL_COUNTRIES )
			$object['CountryCode'] = '000';
		if ( $level <= self::OL_CONTINENTS )
			$object['ContinentCode'] = '000';
		
		return $object;		
	}
	
	
	public static function DisableCache($v) {
		
		self::$cache = !$v;
	}
}

// Источник данных либы
class LocationDataSource
{
	const DS_MYSQL	= 1;
	const DS_SPHINX	= 2;
	
	private static $_prefered_source = null; // Предпочитаемый источник данных: mysql | sphinx
	
	
	public static function UseMySQL()
	{
		self::$_prefered_source = self::DS_MYSQL;
	}
	
	public static function UseSphinx()
	{
		self::$_prefered_source = self::DS_SPHINX;
	}
	
	
	public static function PreferSource( $source )
	{
		if ( $source != self::DS_MYSQL && $source != self::DS_SPHINX )
			throw new InvalidArgumentMyException('Invalid data source');
		
		self::$_prefered_source = $source;
	}
	
	public static function GetObjects( $filter, $with_count = false )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetObjects($filter, $with_count);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetObjects($filter, $with_count);
		else
			return array();
	}
	
	public static function GetObjectsCount( $filter )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetObjectsCount($filter);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetObjectsCount($filter);
		else
			return array();
	}
	
	public static function GetLandmarks( $filter, $with_count = false )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetLandmarks($filter, $with_count);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetLandmarks($filter, $with_count);
		else
			return array();
	}
	
	public static function GetLandmarksCount( $filter )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetLandmarksCount($filter);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetLandmarksCount($filter);
		else
			return array();
	}
	
	public static function GetAreas( $filter, $with_count = false )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetAreas($filter, $with_count);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetAreas($filter, $with_count);
		else
			return array();
	}
	
	public static function GetAreasCount( $filter )
	{
		if ( self::_get_source($filter) == self::DS_MYSQL )
			return LocationDataSourceMySQL::GetAreasCount($filter);
		else if ( self::_get_source($filter) == self::DS_SPHINX )
			return LocationDataSourceSphinx::GetAreasCount($filter);
		else
			return array();
	}
	
	// выбор источника на основе фильтра
	private static function _get_source( $filter )
	{
		if ( self::$_prefered_source !== null )
			return self::$_prefered_source;
		
		// заглушка - выключатель
		// сфинкс вырубать тут
		return self::DS_MYSQL;
		
		// Эти ключи нельзя обработать сфинксом
		if ( array_key_exists('OtherCodes', $filter) )
			return self::DS_MYSQL;
		
		return self::DS_SPHINX;
	}
}


class LocationDataSourceMySQL
{
	public static $cache	= true;
	
	private static $_cache	= null;
	private static $_cache_params = array(
			'host' => '10.80.12.39',
			'port' => 11211,
		);
	
	private static $_config = array(
		'db'		=> 'sources',
		'tables'	=> array(
			'objects' 		=> 'location_objects_new',
			'landmarks'		=> 'location_landmarks',
			'areas'			=> 'location_areas_new',
		),
	);
	private static $limit 	= 1000;
	
	public static function GetObjects( $filter, $with_count = false )
	{
		// пробуем достать выборку из кэша
		if ( self::$cache === true )
		{
			self::__cache_init();
			$cache_key = self::__filter_get_key($filter);
			$result = self::$_cache->Get('objects|'. $cache_key);
			
			if ( is_array($result) )
			{
				if ( $with_count === true )
					return $result;
				else
					return $result[0];
			}
		}
		
		$filter_sql = self::__filter_get_sql($filter);
		
		// получаем список объектов
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ". self::$_config['tables']['objects'];
		$sql.= " WHERE ". $filter_sql;
		if ( !empty($filter['field']) && !empty($filter['dir']) )
		{
			$sql.= " ORDER BY ". $filter['field'] ." ". $filter['dir'];
			$sql.= " LIMIT ". $filter['offset'] .", ". $filter['limit'];
		}
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		if ( $filter['from_master'] === true )
			$res = $db->query($sql);
		else
			$res = $db->query($sql);
		
		if ( $res === false )
		{
			if ( $with_count === true )
				return array(array(), 0);
			else
				return array();
		}
		
		$sql = "SELECT FOUND_ROWS()";
		if ( $filter['from_master'] === true )
			list($count) = $db->query($sql)->fetch_row();
		else
			list($count) = $db->query($sql)->fetch_row();
		
		$data = array();
		while ( $row = $res->fetch_assoc() )
		{
			$row['FullName'] = $row['Name'].' '.Location::GetAbbrByType($row['Type']);
			$data[] = $row;
		}
		
		// кэшируем
		if ( self::$cache === true )
		{
			$ttl = 43200 + rand(0,43200);
			self::$_cache->Set('objects|'. $cache_key, array($data, $count), $ttl);
		}
		
		if ( $with_count === true )
			return array($data,$count);
		
		return $data;
	}
	
	
	public static function GetObjectsCount( $filter )
	{
		$filter_sql = self::__filter_get_sql($filter);
		
		// получаем список объектов
		$sql = "SELECT count(*) FROM ". self::$_config['tables']['objects'];
		$sql.= " WHERE ". $filter_sql;
		
		if ( $filter['from_master'] === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		
		if ( $res === false )
			return array();
		
		$row = $res->fetch_row();
		
		return $row[0];
	}
	
	
	public static function GetLandmarks( $filter, $with_count = false )
	{
		// пробуем достать выборку из кэша
		if ( self::$cache === true )
		{
			self::__cache_init();
			$cache_key = self::__filter_get_key($filter);
			$result = self::$_cache->Get('landmarks|'. $cache_key);
			
			if ( is_array($result) )
			{
				if ( $with_count === true )
					return $result;
				else
					return $result[0];
			}
		}
		
		$filter_sql = self::__filter_get_sql($filter);
		
		// получаем список объектов
		$sql = "SELECT ";
		if ( $with_count === true )
			$sql.= "SQL_CALC_FOUND_ROWS ";
		$sql.= "* FROM ". self::$_config['tables']['landmarks'];
		$sql.= " WHERE ". $filter_sql;
		$sql.= " ORDER BY ". $filter['field'] ." ". $filter['dir'];
		$sql.= " LIMIT ". $filter['offset'] .", ". $filter['limit'];
		
		$db = DBFactory::GetInstance(self::$_config['db']);
		if ( $filter['from_master'] === true )
			$res = $db->query($sql);
		else
			$res = $db->query($sql);
		
		if ( $res === false )
		{
			if ( $with_count === true )
				return array(array(), 0);
			else
				return array();
		}
		
		if ( $with_count === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			if ( $filter['from_master'] === true )
				list($count) = $db->query($sql)->fetch_row();
			else
				list($count) = $db->query($sql)->fetch_row();
		}
		
		$data = array();
		while ( $row = $res->fetch_assoc() )
		{
			//$row['FullName'] = $row['Name'].' '.self::GetAbbrByType($row['Type']);
			$row['FullName'] = $row['Name'];
			$data[] = $row;
		}
		
		// кэшируем
		if ( self::$cache === true )
		{
			$ttl = 43200 + rand(0,43200);
			self::$_cache->Set('landmarks|'. $cache_key, array($data, $count), $ttl);
		}
		
		if ( $with_count === true )
			return array($data,$count);
		
		return $data;
	}
	
	public static function GetLandmarksCount( $filter )
	{
		$filter_sql = self::__filter_get_sql($filter);
		
		// получаем список объектов
		$sql = "SELECT count(*) FROM ". self::$_config['tables']['landmarks'];
		$sql.= " WHERE ". $filter_sql;
		
		if ( $filter['from_master'] === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		
		if ( $res === false )
			return array();
		
		$row = $res->fetch_row();
		
		return $row[0];
	}	
	
	public static function GetAreas( $filter, $with_count = false )
	{
		// пробуем достать выборку из кэша
		if ( self::$cache === true )
		{
			self::__cache_init();
			$cache_key = self::__filter_get_key($filter);
			$result = self::$_cache->Get('areas|'. $cache_key);
			
			if ( is_array($result) )
			{
				if ( $with_count === true )
					return $result;
				else
					return $result[0];
			}
		}
		
		$filter_sql = self::__filter_get_sql( $filter );
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ". self::$_config['tables']['areas'];
		$sql.= " WHERE ". $filter_sql;
		$sql.= " ORDER BY `Name`";
		if ( self::$limit !== null )
			$sql.= ' LIMIT '. self::$limit;
		
		$data = array();
		$db = DBFactory::GetInstance(self::$_config['db']);
		if ( $filter['from_master'] === true )
			$res = $db->query($sql);
		else
			$res = $db->query($sql);
		
		if ( $res === false )
		{
			if ( $with_count === true )
				return array(array(), 0);
			else
				return array();
		}
		
		$sql = "SELECT FOUND_ROWS()";
		if ( $filter['from_master'] === true )
			list($count) = $db->query($sql)->fetch_row();
		else
			list($count) = $db->query($sql)->fetch_row();
		
		while($row = $res->fetch_assoc())
		{
			$row['FullName'] = $row['Name'] .' '. Location::GetAbbrByType($row['Type']);
			$data[] = $row;
        }
		
		// кэшируем
		if ( self::$cache === true )
		{
			$ttl = 43200 + rand(0,43200);
			self::$_cache->Set('areas|'. $cache_key, array($data, $count), $ttl);
		}
		
		if ( $with_count === true )
			return array($data,$count);
		
		return $data;
	}
	
	public static function GetAreasCount( $filter )
	{
		$filter_sql = self::__filter_get_sql( $filter );
		
		$sql = "SELECT count(*) FROM ". self::$_config['tables']['areas'];
		$sql.= " WHERE ". $filter_sql;
		
		$data = array();
		if ( $filter['from_master'] === true )
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		else
			$res = DBFactory::GetInstance(self::$_config['db'])->query($sql);
		$row = $res->fetch_row();
		
		return $row[0];
	}
	
	
	private static function __cache_init()
	{
		if ( self::$_cache === null )
		{
			LibFactory::GetStatic('cache');		
			self::$_cache = new Cache();
			self::$_cache->Init('memcache', 'location', self::$_cache_params);
		}
	}
	
	// получение SQL-условия для фильтра
	private static function __filter_get_sql( $filter )
	{	
		$where = array();
		
		if ( $filter['ObjectID'] !== null && is_array($filter['ObjectID'])  )
		{
			$where[] = "ObjectID IN (". implode(',', (array) $filter['ObjectID']) .")";
		}
		
		if ( $filter['Name'] !== null )
		{
			if ( $filter['ExactName'] )
				$where[] = "Name = '". addslashes($filter['Name']) ."'";
			else
				$where[] = "Name LIKE '". addslashes($filter['Name']) ."%'";
		}
		
		if ( $filter['TransName'] !== null )
		{
			if ( $filter['TransExactName'] )
				$where[] = "TransName = '". addslashes($filter['TransName']) ."'";
			else
				$where[] = "TransName LIKE '". addslashes($filter['TransName']) ."%'";
		}
		
		if ( $filter['Type'] !== null && is_array($filter['Type']) )
		{			
			if ( array_key_exists('in', $filter['Type']) && count($filter['Type']['in']) > 0 ) {
				$filter['Type']['in'] = (array) $filter['Type']['in'];
				$where[] = "`Type` IN ('". implode("','",$filter['Type']['in']) ."')";
			}
			
			if ( array_key_exists('not_in', $filter['Type']) && count($filter['Type']['not_in']) > 0 ) {
				$filter['Type']['not_in'] = (array) $filter['Type']['not_in'];
				$where[] = "`Type` NOT IN ('". implode("','",$filter['Type']['not_in']) ."')";
			}
			
			if ( isset($filter['Type']['in']) )
				unset ($filter['Type']['in']);
			if ( isset($filter['Type']['not_in']) )
				unset ($filter['Type']['not_in']);
		}
		
		if ( $filter['IsVisible'] !== null && $filter['IsVisible'] == 1 )
			$where[] = "`IsVisible` = 1 ";
		
		if ( $filter['Important'] !== null && $filter['Important'] == 1 )
			$where[] = "`Important` = 1 ";
		
		if ( $filter['IsNew'] !== null  )
			$where[] = "`IsNew` = ". $filter['IsNew'];
		
		$sql = '';
		if (sizeof($where))
			$sql = implode(" AND ", $where);
		
		$where = array(
			1 => array(),
			2 => array(),
		);
		
		if ( $filter['ContinentCode'] !== null && $filter['ContinentCode'] !== -1 )
			$where[1][] = "`ContinentCode` = '". $filter['ContinentCode'] ."'";
		else if ( $filter['ContinentCode'] === -1 )
			$where[1][] = "`ContinentCode` != '000'";
		
		if ( $filter['CountryCode'] !== null && $filter['CountryCode'] !== -1 )
			$where[1][] = "`CountryCode` = '". $filter['CountryCode'] ."'";
		else if ( $filter['CountryCode'] === -1 )
			$where[1][] = "`CountryCode` != '000'";
		
		if ( $filter['RegionCode'] !== null && $filter['RegionCode'] !== -1 )
			$where[1][] = "`RegionCode` = '". $filter['RegionCode'] ."'";
		else if ( $filter['RegionCode'] === -1 )
			$where[1][] = "`RegionCode` != '000'";
		
		if ( $filter['DistrictCode'] !== null && $filter['DistrictCode'] !== -1 )
			$where[1][] = "`DistrictCode` = '". $filter['DistrictCode'] ."'";
		else if ( $filter['DistrictCode'] === -1 )
			$where[1][] = "`DistrictCode` != '000'";
		
		if ( $filter['CityCode'] !== null && $filter['CityCode'] !== -1 )
			$where[1][] = "`CityCode` = '". $filter['CityCode'] ."'";
		else if ( $filter['CityCode'] === -1 )
			$where[1][] = "`CityCode` != '000'";
		
		if ( $filter['VillageCode'] !== null && $filter['VillageCode'] !== -1 )
			$where[1][] = "`VillageCode` = '". $filter['VillageCode'] ."'";
		else if ( $filter['VillageCode'] === -1 )
			$where[1][] = "`VillageCode` != '000'";
		
		if ( $filter['StreetCode'] !== null && $filter['StreetCode'] !== -1 )
			$where[1][] = "`StreetCode` = '". $filter['StreetCode'] ."'";
		else if ( $filter['StreetCode'] === -1 )
			$where[1][] = "`StreetCode` != '0000'";
		
		if ( $filter['LandmarkCode'] !== null && $filter['LandmarkCode'] !== -1 )
			$where[1][] = "`LandmarkCode` = '". $filter['LandmarkCode'] ."'";
		else if ( $filter['LandmarkCode'] === -1 )
			$where[1][] = "`LandmarkCode` != '0000'";
		
		if ( $filter['AreaCode'] !== null && $filter['AreaCode'] !== -1 )
			$where[1][] = "`AreaCode` = '". $filter['AreaCode'] ."'";
		else if ( $filter['AreaCode'] === -1 )
			$where[1][] = "`AreaCode` != '000'";
		
		if ( $filter['ActualCode'] !== null )
		{
			if ( is_numeric($filter['ActualCode']) )
			{
				if ( $filter['ActualCode'] !== -1 )
					$where[1][] = "`ActualCode` = ". $filter['ActualCode'];
			}
			else
			{
				if ( is_array($filter['ActualCode']) && is_array($filter['ActualCode']['in']) )
					$where[1][] = "`ActualCode` IN (". implode(',',$filter['ActualCode']['in']) .")";
				if ( is_array($filter['ActualCode']) && is_array($filter['ActualCode']['not_in']) )
					$where[1][] = "`ActualCode` NOT IN (". implode(',',$filter['ActualCode']['not_in']) .")";
			}
		}
		
		if ( is_array($filter['Codes']) )
			$where[1][] ="`Code` IN ('". implode("','",$filter['Codes']) ."')";
		
		if ( is_array($filter['ExcludeCodes']) )
			$where[1][] ="`Code` NOT IN ('". implode("','",$filter['ExcludeCodes']) ."')";
			
		if ( is_array($filter['OtherCodes']) )
			$where[2][] ="`Code` IN ('". implode("','",$filter['OtherCodes']) ."')";
		
		if (sizeof($where[1]) && sizeof($where[2]))
			$where = '(('.implode(" AND ", $where[1]).') OR ('.implode(" AND ", $where[2]).'))';
		else if (sizeof($where[1]))
			$where = '('.implode(" AND ", $where[1]).')';
		else if (sizeof($where[2]))
			$where = '('.implode(" AND ", $where[2]).')';
			
		if ($sql && is_string($where))
			$sql .= ' AND '.$where;
		else if (!$sql && is_string($where))
			$sql .= $where;
		else
			$sql .= "true";
		
		return $sql;
	}
	
	
	// получение уникального ключа для фильтра
	private static function __filter_get_key( $filter )
	{
		return md5( http_build_query($filter) );
	}
	
}


class LocationDataSourceSphinx
{
	private static $cl = null;

	public static function GetObjects( $filter, $with_count = false )
	{
		$result = self::__search($filter, 'location_objects');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetObjects($filter, $with_count);
		
		if ( !is_array($result['matches']) )
		{
			if ( $with_count )
				return array(array(),0);
			else
				return array();
		}
		
		$data = self::__parse_result($result, 'location_objects');
		
		if ( $with_count )
			return array($data, $result['total_found']);
		else
			return $data;
	}
	
	public static function GetObjectsCount( $filter )
	{
		$result = self::__search($filter, 'location_objects');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetObjectsCount($filter);
		
		if ( !is_array($result['matches']) )
			return null;
		
		return $result['total_found'];
	}	
	
	
	
	public static function GetLandmarks( $filter, $with_count = false )
	{
		$result = self::__search($filter, 'location_landmarks');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetLandmarks($filter, $with_count);
		
		if ( !is_array($result['matches']) )
		{
			if ( $with_count )
				return array(array(),0);
			else
				return array();
		}
		
		$data = self::__parse_result($result, 'location_landmarks');
		
		if ( $with_count )
			return array($data, $result['total_found']);
		else
			return $data;
	}
	
	public static function GetLandmarksCount( $filter )
	{
		$result = self::__search($filter, 'location_landmarks');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetLandmarksCount($filter);
		
		if ( !is_array($result['matches']) )
			return null;
		
		return $result['total_found'];
	}	
	
	
	
	public static function GetAreas( $filter, $with_count = false )
	{
		$result = self::__search($filter, 'location_areas');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetAreas($filter, $with_count);
		
		if ( !is_array($result['matches']) )
		{
			if ( $with_count )
				return array(array(),0);
			else
				return array();
		}
		
		$data = self::__parse_result($result, 'location_areas');
		
		if ( $with_count )
			return array($data, $result['total_found']);
		else
			return $data;
	}
	
	public static function GetAreasCount( $filter )
	{
		$result = self::__search($filter, 'location_areas');
		
		if ( $result['status'] != SEARCHD_OK )
			return LocationDataSourceMySQL::GetAreasCount($filter);
		
		if ( !is_array($result['matches']) )
			return null;
		
		return $result['total_found'];
	}
	
	
	
	private static function __search( $filter, $index )
	{
		if ( self::$cl === null )
			self::__init_sphinx();
		else
			self::$cl->ResetFilters();
		
		if ( $index == 'location_objects' )
		{
			self::$cl->SetMatchMode ( SPH_MATCH_ALL );
			self::$cl->SetFieldWeights ( array ( 'Name' => 5, 'Normalized' => 1 ) );
			if ( !empty($filter['field']) && !empty($filter['dir']) )
			{
				if ( strtolower($filter['dir']) == 'asc' )
					self::$cl->SetSortMode( SPH_SORT_ATTR_ASC, $filter['field']);
				else
					self::$cl->SetSortMode( SPH_SORT_ATTR_DESC, $filter['field']);
			}
			else
			{
				self::$cl->SetSortMode( SPH_SORT_EXTENDED, "Weight ASC, Important DESC, @weight DESC, @id ASC");
			}
		}
		else if ( $index == 'location_areas' )
		{
			self::$cl->SetMatchMode ( SPH_MATCH_ALL );
			self::$cl->SetFieldWeights ( array ( 'Name' => 5 ) );
			if ( !empty($filter['field']) && !empty($filter['dir']) )
			{
				if ( strtolower($filter['dir']) == 'asc' )
					self::$cl->SetSortMode( SPH_SORT_ATTR_ASC, $filter['field']);
				else
					self::$cl->SetSortMode( SPH_SORT_ATTR_DESC, $filter['field']);
			}
			else
			{
				self::$cl->SetSortMode( SPH_SORT_RELEVANCE );
			}
		}
		else if ( $index == 'location_landmarks' )
		{
			self::$cl->SetMatchMode ( SPH_MATCH_ANY );
			self::$cl->SetFieldWeights ( array ( 'Name' => 5 ) );
			self::$cl->SetSortMode( SPH_SORT_RELEVANCE );
		}
		
		
		if ( isset($filter['offset']) && isset($filter['limit']) )
			self::$cl->SetLimits($filter['offset'], $filter['limit']);
		
		if ( !empty($filter['Name']) )
		{
			if ( $filter['ExactName'] )
				self::$cl->SetMatchMode(SPH_MATCH_PHRASE);
		}
		
		if ( $index != 'location_areas' )
		{
			if ( is_array($filter['Type']) )
			{
				if ( array_key_exists('in', $filter['Type']) && count($filter['Type']['in']) > 0 )
					self::$cl->SetFilter('Type', (array) $filter['Type']['in'], false);
				
				if ( array_key_exists('not_in', $filter['Type']) && count($filter['Type']['not_in']) > 0 )
					self::$cl->SetFilter('Type', (array) $filter['Type']['not_in'], true);
				
				if ( isset($filter['Type']['in']) )
					unset ($filter['Type']['in']);
				if ( isset($filter['Type']['not_in']) )
					unset ($filter['Type']['not_in']);
			}
		}
		
		if ( $filter['IsVisible'] == 1 )
			self::$cl->SetFilter('IsVisible', array(1), false);
		
		if ( $index != 'location_areas' )
		{
			if ( $filter['IsNew'] !== null  )
				self::$cl->SetFilter('IsNew', array($filter['IsNew']), false);
			
			if ( $filter['Important'] == 1 )
				self::$cl->SetFilter('Important', array(1), false);
		}
		
		if ( $filter['ContinentCode'] !== null && $filter['ContinentCode'] !== -1 )
			self::$cl->SetFilter('ContinentCode', (array) base_convert($filter['ContinentCode'], 36, 10), false);
		else if ( $filter['ContinentCode'] === -1 )
			self::$cl->SetFilter('ContinentCode', array(0), true);
		
		if ( $filter['CountryCode'] !== null && $filter['CountryCode'] !== -1 )
			self::$cl->SetFilter('CountryCode', (array) base_convert($filter['CountryCode'], 36, 10), false);
		else if ( $filter['CountryCode'] === -1 )
			self::$cl->SetFilter('CountryCode', array(0), true);
		
		if ( $filter['RegionCode'] !== null && $filter['RegionCode'] !== -1 )
			self::$cl->SetFilter('RegionCode', (array) base_convert($filter['RegionCode'], 36, 10), false);
		else if ( $filter['RegionCode'] === -1 )
			self::$cl->SetFilter('RegionCode', array(0), true);
		
		if ( $filter['DistrictCode'] !== null && $filter['DistrictCode'] !== -1 )
			self::$cl->SetFilter('DistrictCode', (array) base_convert($filter['DistrictCode'], 36, 10), false);
		else if ( $filter['DistrictCode'] === -1 )
			self::$cl->SetFilter('DistrictCode', array(0), true);
		
		if ( $filter['CityCode'] !== null && $filter['CityCode'] !== -1 )
			self::$cl->SetFilter('CityCode', (array) base_convert($filter['CityCode'], 36, 10), false);
		else if ( $filter['CityCode'] === -1 )
			self::$cl->SetFilter('CityCode', array(0), true);
		
		if ( $filter['VillageCode'] !== null && $filter['VillageCode'] !== -1 )
			self::$cl->SetFilter('VillageCode', (array) base_convert($filter['VillageCode'], 36, 10), false);
		else if ( $filter['VillageCode'] === -1 )
			self::$cl->SetFilter('VillageCode', array(0), true);
		
		if ( $filter['StreetCode'] !== null && $filter['StreetCode'] !== -1 )
			self::$cl->SetFilter('StreetCode', (array) base_convert($filter['StreetCode'], 36, 10), false);
		else if ( $filter['StreetCode'] === -1 )
			self::$cl->SetFilter('StreetCode', array(0), true);
		
		if ( $index == 'location_landmarks' )
		{
			if ( $filter['LandmarkCode'] !== null && $filter['LandmarkCode'] !== -1 )
				self::$cl->SetFilter('LandmarkCode', (array) base_convert($filter['LandmarkCode'], 36, 10), false);
			else if ( $filter['LandmarkCode'] === -1 )
				self::$cl->SetFilter('LandmarkCode', array(0), true);
		}
		
		if ( $index == 'location_areas' )
		{
			if ( $filter['AreaCode'] !== null && $filter['AreaCode'] !== -1 )
				self::$cl->SetFilter('AreaCode', (array) base_convert($filter['AreaCode'], 36, 10), false);
			else if ( $filter['AreaCode'] === -1 )
				self::$cl->SetFilter('AreaCode', array(0), true);
		}
		
		if ( $index != 'location_areas' )
		{
			if ( $filter['ActualCode'] !== null && is_numeric($filter['ActualCode']) && $filter['ActualCode'] !== -1 )
				self::$cl->SetFilter('ActualCode', (array) $filter['ActualCode'], false);
		}
		
		if ( is_array($filter['Codes']) && count($filter['Codes']) )
		{
			foreach ( $filter['Codes'] as &$v )
				$v = base_convert($v, 36, 10);
			self::$cl->SetFilter('Code', $filter['Codes'], false);
		}
		
		if ( is_array($filter['ExcludeCodes']) && count($filter['ExcludeCodes']) )
		{
			foreach ( $filter['ExcludeCodes'] as &$v )
				$v = base_convert($v, 36, 10);
			self::$cl->SetFilter('Code', $filter['ExcludeCodes'], true);
		}
		
		// Если это надо - реализовать в __parse_result
		/*if ( is_array($filter['OtherCodes']) )
			self::$cl->SetFilter('Code', $filter['OtherCodes'], false);*/
		
		$result = self::$cl->Query(iconv('WINDOWS-1251', 'UTF-8', $filter['Name'] ? $filter['Name'] : ''), $index );
		
		return $result;
	}
	
	
	private static function __init_sphinx()
	{
		self::$cl = LibFactory::GetInstance('sphinx_api');
		if ( !self::$cl || !self::$cl->Open() )
		{
			LocationDataSource::UseMySQL();
			return false;
		}
		
		//self::$cl->SetServer ( "10.80.12.202", 3313 );
		
		self::$cl->SetArrayResult ( true );
		self::$cl->SetConnectTimeout ( 3 );
		
		return true;
	}
	
	
	private static function __parse_result($result, $index)
	{
		if ( !is_array($result['matches']) )
			return array();
		
		$ids = array();
		foreach ( $result['matches'] as $row )
			$ids[] = $row['id'];
		
		if ( $index == 'location_objects' )
			$data = Location::GetObjectByID($ids);
		else if ( $index == 'location_landmarks' )
			$data = Location::GetLandmarkByID($ids);
		else if ( $index == 'location_areas' )
			$data = Location::GetAreaByID($ids);
		else
			return array();
		
		// располагаем их в порядке, в котором их вернул сфинкс
		$result = array();
		foreach ( $ids as $id )
		{
			if ( array_key_exists($id, $data) )
				$result[] = $data[$id];
		}
		
		return $result;
	}
}
?>