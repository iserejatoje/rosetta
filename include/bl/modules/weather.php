<?

/*****************************************/
/*											*/
/* Бизнес-логика для прогноза погоды weather
/*
/* @author Колчин Никита
/* @version 0.1
/* @created xx-авг-2010
/*****************************************/

class BL_modules_weather
{
	private	$_db			= null;
	private	$_cache			= null;
	private	$_regid			= 74;
	private	$_tables		= array();
	private	$_WindWards		= array();
	private	$_Precips		= array();
	private	$_States_of_sky = array();
	private	$_Cities		= array();

    /* Конструктор
     * Ноу комментс
	 */
	public function __construct()
	{
		$this->_tables			= include "weather/tables.php";
		$this->_WindWards		= include "weather/windwards.php";
		$this->_Precips			= include "weather/precips.php";
		$this->_States_of_sky	= include "weather/states_of_sky.php";
		$this->_Cities			= include "weather/cities.php";
	}
	/* Функция Init() - Инициализация класса */
	/* Входной параметр - массив с тремя ключами: */
	/* 'db' - база данных, с которой мы хотим поработать */
	/* 'tables' - таблички, в которых хранятся данные */
	/* 'regid' - ИД-шник региона */
	function Init($params)
	{
		if(isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);
		else
			$this->_db = DBFactory::GetInstance('weather');

		if(isset($params['tables']) && is_array($params['tables']))
			$this->_tables = $params['tables'];

		if(isset($params['regid']) && is_numeric($params['regid']))
			$this->_regid = $params['regid'];
	}

	/*
	 * Метод GetCurrentWeather
	 * возвращает данные о погоде за текущее время
	 * @param City - объект города, по которому неоходим прогноз
	 * @param nocache - по умолчанию фолс, брать из кеша, или из базы
     * @return - массив, с содержанием данных о прогнозах по указанному городу
	 */
	function GetCurrentWeather($CityCode, $nocache = false)
	{
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'weather');

		$cacheid = 'weather_current_'.$CityCode;

		$data = $this->_cache->get($cacheid);

		LibFactory::GetStatic('datetime_my');
		if ( empty($data) || $nocache === true || $_GET['nocache'] > 12 )
		{
            $data = array();
            $sql = 'SELECT * FROM '.$this->_tables['10days'].' WHERE ';
			$sql.= ' `CityCode` = \''.$CityCode.'\'';
			$sql.= ' AND `Date` >= \''.Datetime_my::DateOffset().'\' LIMIT 0,1';


			$result = $this->_db->query($sql);
			if ( $row = $result->fetch_assoc() )
			{
				$data['weather'] = $row;
				/* Получаем погоду */
				if ( isset($this->_Precips[$data['weather']['Precip']]) )
				{
					$data['weather']['PrecipText'] = $this->_Precips[$data['weather']['Precip']];
					$data['weather']['PrecipImg'] = $data['weather']['Precip'];
				}
			}


			$sql = 'SELECT * FROM '.$this->_tables['current'].' WHERE ';
			$sql.= ' `CityCode` = \''.$CityCode.'\'';
			$sql.= ' AND `Date` >= DATE_SUB(\''.Datetime_my::DateOffset().'\', INTERVAL 4 HOUR)';

			$res = $this->_db->query($sql);
			if ($res->num_rows != 0)
				$data['weather'] = array_merge( $data['weather'], $res->fetch_assoc() );
			else
				$data['weather'] = false;
			if (is_array($data['weather']))
			{
				$sql = 'SELECT d.Text FROM '.$this->_tables['describe'].' as d';
				$sql.= ' INNER JOIN '.$this->_tables['describe_precip_ref'].' as r ON(`CityCode` = \''.$CityCode.'\' AND r.DescID = d.DescID)';
				$sql.= ' WHERE d.MinT <= '.(int) $data['weather']['T'].' AND d.MaxT >= '.(int) $data['weather']['T'].' AND d.isVisible = 1';
				$sql.= ' AND d.RegID = '.$this->_regid;
				$sql.= ' AND r.PrecipID = '.(int) $data['weather']['Precip'];

				$res = $this->_db->query($sql);
				if ( $res && $res->num_rows )
					while ( $row = $res->fetch_row() )
						$data['describes'][] = $row[0];


				/* Получаем направление ветра */
				$data['weather']['WindWard'] = $this->_convertWindWard($data['weather']['WindWard']);

				/* Получаем погоду */
				if ( isset($this->_Precips[$data['weather']['Precip']]) )
				{
					$data['weather']['PrecipText'] = $this->_Precips[$data['weather']['Precip']];
					$data['weather']['PrecipImg'] = $data['weather']['Precip'];
				}

				$data['weather']['LongDay'] = null;
				if ( !$data['weather']['Sunrise'] || !$data['weather']['Sunset'] )
				{
					$this->_cache->set($cacheid, $data['weather'], 0);
					return $data['weather'];
				}

				$Sunrise = explode(':', $data['weather']['Sunrise']);
				$Sunset = explode(':', $data['weather']['Sunset']);

				$Sunrise = $Sunrise[0]*60+$Sunrise[1];
				$Sunset = $Sunset[0]*60+$Sunset[1];

				$data['weather']['LongDay'] = array(
					floor(($Sunset-$Sunrise)/60),
					($Sunset-$Sunrise)-floor(($Sunset-$Sunrise)/60)*60
				);

				$offsetTS = Datetime_my::NowOffsetTime();
				$data['weather']['HourType'] = 'day';
				if ( $Sunset < date('H', $offsetTS)*60+ date('i', $offsetTS) || $Sunrise > date('H', $offsetTS)*60+ date('i', $offsetTS))
					$data['weather']['HourType'] = 'night';
				$t = $this->_fix_morning_T($data['weather']['CityCode']);
				if ( $t !== false )
					$data['weather']['T'] = $t;

			}
			$this->_cache->set($cacheid, $data, 0);
		}
		if (is_array($data['describes']))
		{
			$desc = count($data['describes']);
			$data['describe'] = $data['describes'][rand(0, $desc)];
			unset($data['describes']);
		}
		$data['weather']['Hour'] = intval(date('G', Datetime_my::NowOffset())); // берем час
		return $data;
	}

	/*
	 * Метод Get10DaysWeather
	 * возвращает данные о погоде за 10 дней
	 * @param City - объект города, по которому неоходим прогноз
	 * @param nocache - по умолчанию фолс, брать из кеша, или из базы
     * @return - массив, с содержанием данных о прогнозах по указанному городу
	 */
	function Get10DaysWeather($CityCode, $nocache = false)
	{
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'weather');
		
		$cacheid = 'weather_10days_'.$CityCode;
		
		$data = $this->_cache->get($cacheid);

		LibFactory::GetStatic('datetime_my');
		if ( empty($data) || $nocache === true || $_GET['nocache'] > 12 )
		{
			$sql = 'SELECT DISTINCT * ';
			$sql.= ' FROM '.$this->_tables['advanced'].' WHERE ';
			$sql.= ' `CityCode` = \''.$CityCode.'\'';
			$sql.= ' AND `Date` >= \''.Datetime_my::DateOffset().'\'';
			$sql.= ' ORDER by `Date` ';

			$res = $this->_db->query($sql);

			if ( !$res || !$res->num_rows )
				$data = false;
			else
			{
				$listw = array();
				$lastRow = null;
				while ( false != ($row = $res->fetch_assoc()) )
				{
					$row['DateTS'] = strtotime($row['Date']);
					$row['Hour'] = date('G', $row['DateTS']);

					$row['HourType'] = 'day';
					if ( $row['Hour'] >= 21 )
					{
						$row['HourType'] = 'night';
						$row['HourText'] = 'Вечер';
					}
					elseif ( $row['Hour'] >= 15 )
					{
						$row['HourText'] = 'День';
					}
					elseif ( $row['Hour'] >= 9 )
					{
						$row['HourText'] = 'Утро';
					}
					else
					{
						$row['HourType'] = 'night';
						$row['HourText'] = 'Ночь';
					}

					if ( date('w', $row['DateTS']) == date('w') )
						$row['DayOfWeek'] = 'сегодня';
					else
						$row['DayOfWeek'] = Datetime_my::$day_of_week[date('w', $row['DateTS'])];

					$row['DayOfWeek'] = ucfirst($row['DayOfWeek']);
					$row['DayMonth'] = date('j', $row['DateTS']).' '.Datetime_my::$month2[date('n', $row['DateTS'])];

					$row['WindWard'] = $this->_convertWindWard($row['WindWard']);

					if ( isset($this->_Precips[$row['Precip']]) )
					{
						$row['PrecipText'] = $this->_Precips[$row['Precip']];
						$row['PrecipImg'] = $row['Precip'];
					}

					if ( in_array($row['Hour'], array(3,9,15,21)) )
					{

						$listw[ date('Y-m-d', $row['DateTS']) ][$row['DateTS']] = $row;
						$lastRow = $row;
					}
					else if ($lastRow && $lastRow['Hour']+6 < $row['Hour'])
					{

						$preRow = $row;//$list[date('Y-m-d', $lastRow['DateTS'])][sizeof( $list[date('Y-m-d', $lastRow['DateTS'])] )-1];
						$preRow['DateTS'] = $lastRow['DateTS']+3600*6;
						$preRow['Date'] = date('Y-m-d H:i:s', $preRow['DateTS']);
						$preRow['Hour'] = $lastRow['Hour']+6;
						$preRow['Part'] = true;

						$lastRow = $preRow;
						$listw[ date('Y-m-d', $preRow['DateTS']) ][$preRow['DateTS']] = $preRow;
					}
					else
						continue;
				}
				// На данном этапе в $list лежит подробный прогноз на сегодня и завтра (через 6 часов)
				$data['current'] = array_slice($listw,0,1);
				$data['tomorrow'] = array_slice($listw,1,1);

				$sql = "SELECT DISTINCT * FROM ".$this->_tables['10daysDN']." WHERE ";
				$sql.= " `CityCode` = '".$CityCode."'";
				$sql.= " AND `Date` >= DATE_ADD('".Datetime_my::DateOffset()."', INTERVAL 2 DAY)";
				$sql.= " ORDER by `Date`, `Type` ASC";//LIMIT 9';

				$res = $this->_db->query($sql);
				if ( $res && $res->num_rows )
					while ( false != ($row = $res->fetch_assoc()) )
					{
						$row['DateTS'] = strtotime($row['Date']);
						//if ( date('w', $row['DateTS']) == date('w') && date('j', $row['DateTS']) == date('j') )
							//$row['DayOfWeek'] = 'сегодня';
						//else
							$row['DayOfWeek'] = Datetime_my::$day_of_week[date('w', $row['DateTS'])];

						$row['DayOfWeek'] = ucfirst($row['DayOfWeek']);
						$row['DayMonth'] = date('j', $row['DateTS']).' '.Datetime_my::$month2[date('n', $row['DateTS'])];

						if ( isset($this->_Precips[$row['Precip']]) )
						{
							$row['PrecipText'] = $this->_Precips[$row['Precip']];
							$row['PrecipImg'] = $row['Precip'];
						}

						if ( $row['Type'] == 2 )
							$type = 'night';
						else
							$type = 'day';

						$row['WindWard'] = $this->_convertWindWard($row['WindWard']);

						$data['adv'][ date('Y-m-d', $row['DateTS']) ][$type] = $row;
					}

				//в $data['adv'] по ключам (день недели) лежит подробный прогноз с 3 по 10 дни


				//Получаем краткий прогноз
				$data['list'] = array();
				$sql = 'SELECT DISTINCT * FROM '.$this->_tables['10days'].' WHERE ';
				$sql.= ' `CityCode` = \''.$CityCode.'\'';
				$sql.= ' AND `Date` >= DATE_ADD(\''.Datetime_my::DateOffset().'\', INTERVAL 1 DAY)';
				$sql.= ' ORDER by `Date` LIMIT 10';

				$res = $this->_db->query($sql);
				if ( $res && $res->num_rows )
					while ( false != ($row = $res->fetch_assoc()) ) {
						$row['DateTS'] = strtotime($row['Date']);
						if ( date('w', $row['DateTS']) == date('w') && date('j', $row['DateTS']) == date('j') )
							$row['DayOfWeek'] = 'сегодня';
						else
							$row['DayOfWeek'] = Datetime_my::$day_of_week[date('w', $row['DateTS'])];

						$row['DayOfWeek'] = ucfirst($row['DayOfWeek']);
						$row['DayMonth'] = date('j', $row['DateTS']).' '.Datetime_my::$month2[date('n', $row['DateTS'])];

						if ( isset($this->_Precips[$row['Precip']]) )
						{
							$row['PrecipText'] = $this->_Precips[$row['Precip']];
							$row['PrecipImg'] = $row['Precip'];
						}

						$row['WindWard'] = $this->_convertWindWard($row['WindWard']);

						$key = date('Y-m-d', $row['DateTS']);

						//Сделано для того, чтобы заменить погоду из расширенного вида, т.к. она не соответствует
						if($i>0)
						{
							$data['adv'][ $key ][1]['T'] = $row['TDay'];
							$data['adv'][ $key ][2]['T'] = $row['TNight'];
						}
						$data['list'][ $key ] = $row;
						$i++;
					}



				$date = (date('n') << 8) + date('j');

				$sql = 'SELECT * FROM '.$this->_tables['timer'];
				$sql.= ' WHERE `DateID` = '.$date;
				$sql.= ' ORDER by RAND() LIMIT 1 ';

				$res = $this->_db->query($sql);
				if ( $res && $res->num_rows )
					$data['timer'] = $res->fetch_assoc();
			}

			$this->_cache->set($cacheid, $data, 0);
		}
		else
			$data['Hour'] = intval(date('G', Datetime_my::NowOffset()));

		return $data;
	}

	/*
	 * Метод saveCurrent
	 * сохраняет текущую погоду в базу данных
	 * @param cityid - ИД города, по которому сохраняется запись
	 * @param weather - Массив данных о погоде
     * @return - Булево значение, указывающее на успешность выполнения функции
	 */
	public function saveCurrent($cityid, $weather)
	{
		$CityCode = $this->_Cities[$cityid] ? $this->_Cities[$cityid] : '';

		$sql = 'SELECT `date` FROM '.$this->_tables['current'];
		$sql.= ' WHERE CityCode=\''.$CityCode.'\'';
		$res = $this->_db->query($sql);

		if( !isset($this->_States_of_sky[$weather['precip']]) && ($weather['precip'] != '') )
			$weather['precip'] = 'Partly Cloudy';

		if ( $row = $res->fetch_assoc() )
		{
			$date = strtotime($row['date']);
			if ( $date < time() )
			{
				$sql = 'UPDATE '.$this->_tables['current'].' SET';
				$sql.= ' Date = NOW()';
				$sql.= ' ,CityCode = \''.$CityCode.'\'';

				if ($weather['t'] !== null)
				$sql.= ' ,T = \''.(int) $weather['t'].'\'';

				if ( isset($weather['precip']) )
					$sql.= ' ,Precip = \''.(int) $this->_States_of_sky[$weather['precip']].'\'';

				if ( isset($weather['wind_ward']) )
					$sql.= ' ,WindWard = \''.$weather['wind_ward'].'\'';

				if ( isset($weather['wind_speed']) && $weather['wind_speed']>= 0 )
					$sql.= ' ,WindSpeed = \''.(int) $weather['wind_speed'].'\'';

				if ( isset($weather['humidity']) )
					$sql.= ' ,Humidity = \''.(int) $weather['humidity'].'\'';

				if ( isset($weather['sunrise']) )
					$sql.= ' ,Sunrise = \''.$weather['sunrise'].'\'';

				if ( isset($weather['sunset']) )
					$sql.= ' ,Sunset = \''.$weather['sunset'].'\'';

				if ( isset($weather['barometer']) && $weather['barometer']>= 0 )
					$sql.= ' ,Barometer = \''.(int) $weather['barometer'].'\'';

				$sql.= ' WHERE CityCode = \''.$CityCode.'\'';

				$this->_db->query($sql);

			}
		}
		else
		{
			$sql = 'INSERT INTO '.$this->_tables['current'].' SET';
			$sql.= ' CityID = '.$cityid.'';
			$sql.= ' ,CityCode = \''.$CityCode.'\'';
			$sql.= ' ,Date = NOW()';
			$sql.= ' ,T = '.(int) $weather['t'].'';

			if ( isset($weather['precip']) )
				$sql.= ' ,Precip = \''.(int) $this->_States_of_sky[$weather['precip']].'\'';

			if ( isset($weather['wind_ward']) )
				$sql.= ' ,WindWard = \''.$weather['wind_ward'].'\'';

			if ( isset($weather['wind_speed']) && $weather['wind_speed']>= 0 )
				$sql.= ' ,WindSpeed = \''.(int) $weather['wind_speed'].'\'';

			if ( isset($weather['humidity']) )
				$sql.= ' ,Humidity = \''.(int) $weather['humidity'].'\'';

			if ( isset($weather['sunrise']) )
				$sql.= ' ,Sunrise = \''.$weather['sunrise'].'\'';

			if ( isset($weather['sunset']) )
				$sql.= ' ,Sunset = \''.$weather['sunset'].'\'';

			if ( isset($weather['barometer']) && $weather['barometer']>= 0 )
				$sql.= ' ,Barometer = \''.(int) $weather['barometer'].'\'';

			$this->_db->query($sql);
		}

		$this->_db->close();

		$this->GetCurrentWeather($CityCode, true); // Делаем обновление кеша
		$this->Get10DaysWeather($CityCode, true); // Делаем обновление кеша

		return true;
	}

	/*
	 * Метод saveShort
	 * сохраняет погоду в базу данных в сокращенном варианте
	 * @param cityid - ИД города, по которому сохраняется запись
	 * @param weather - Массив данных о погоде
     * @return - Булево значение, указывающее на успешность выполнения функции
	 */
	public function saveShort($cityid, $weather)
	{
		$CityCode = $this->_Cities[$cityid] ? $this->_Cities[$cityid] : '';
		foreach ($weather as $info)
		{

			if ( strtotime($info['date']) === false )
				continue ;

			$sql = "SELECT * FROM ".$this->_tables['10days']." WHERE ";
			$sql.= " `CityCode` = '".$CityCode."'";
			$sql.= " AND `Date` = '".$info['date']."'";

			if (($res = $this->_db->query($sql)) === false)
				return false;

			if ( $res->num_rows > 1 )
			{
				$sql = "DELETE FROM ".$this->_tables['10days']." WHERE ";
				$sql.= " `CityCode` = '".$CityCode."'";
				$sql.= " AND `Date` = '".$info['date']."' LIMIT ".($res->num_rows-1);

				if ($this->_db->query($sql) == false)
					return false;
			}

			if ( $res && $res->num_rows )
			{
				$sql = "UPDATE ".$this->_tables['10days']." SET ";
				$sql.= " `Date` = '".$info['date']."'";
				$sql.= " ,`CityCode` = '".$CityCode."'";

				if ( $info['t_day'] !== null )
					$sql.= " ,`TDay` = ".$info['t_day'];

				if ( $info['t_night'] !== null )
					$sql.= " ,`TNight` = ".$info['t_night'];

				if ( $info['precip'] >= 0)
					$sql.= " ,`Precip` = ". (int) $info['precip'];
				if ( $info['precip_chance'] >= 0)
					$sql.= " ,`PrecipChance` = '".$info['precip_chance']."'";
				$sql.= " ,`WindWard` = '".$info['wind_ward']."'";
				if ( $info['wind_speed']>= 0 )
					$sql.= " ,`WindSpeed` = '".(int) $info['wind_speed']."'";

				$sql.= " WHERE ";
				$sql.= " `CityCode` = '".$CityCode."'";
				$sql.= " AND `Date` = '".$info['date']."'";

				if ($this->_db->query($sql) == false)
					return false;
			}
			elseif ($info['t_day'] !== null && $info['t_night'] !== null)
			{
				$sql = "INSERT INTO ".$this->_tables['10days']." SET ";
				$sql.= " `Date` = '".$info['date']."'";
				$sql.= " ,`CityID` = ".$cityid;
				$sql.= " ,`CityCode` = '".$CityCode."'";

				if ( $info['t_day'] !== null )
					$sql.= " ,`TDay` = ".$info['t_day'];

				if ( $info['t_night'] !== null )
					$sql.= " ,`TNight` = ".$info['t_night'];

				if ( $info['precip'] >= 0)
					$sql.= " ,`Precip` = '".$info['precip']."'";
				if ( $info['precip_chance'] >= 0)
					$sql.= " ,`PrecipChance` = '".$info['precip_chance']."'";

				$sql.= " ,`WindWard` = '".$info['wind_ward']."'";
				if ( $info['wind_speed']>= 0 )
					$sql.= " ,`WindSpeed` = '".(int) $info['wind_speed']."'";

				if ($this->_db->query($sql) == false)
					return false;
			}
		}

		$this->GetCurrentWeather($CityCode, true); // Делаем обновление кеша
		$this->Get10DaysWeather($CityCode, true); // Делаем обновление кеша

		$this->_db->close();
		return true;
	}

	/*
	 * Метод saveAdvanced
	 * сохраняет погоду в базу данных и обнуление кеша в расширенном варианте варианте
	 * @param cityid - ИД города, по которому сохраняется запись
	 * @param weather - Массив данных о погоде
     * @return - Булево значение, указывающее на успешность выполнения функции
	 */
	public function saveAdvanced($cityid, $weather)
	{
		$CityCode = $this->_Cities[$cityid] ? $this->_Cities[$cityid] : '';

		foreach ($weather as $info)
		{
			if ( strtotime($info['date']) === false )
				continue;

			$sql = "SELECT * FROM ".$this->_tables['advanced']." WHERE ";
			$sql.= " `CityCode` = '".$CityCode."'";
			$sql.= " AND `Date` = '".$info['date']."'";

			$res = $this->_db->query($sql);

			if ( $res->num_rows > 1 )
			{
				$sql = "DELETE FROM ".$this->_tables['advanced']." WHERE ";
				$sql.= " `CityCode` = '".$CityCode."'";
				$sql.= " AND `Date` = '".$info['date']."' LIMIT ".($res->num_rows-1);

				$this->_db->query($sql);
			}

			if ( $res && $res->num_rows )
			{
				$sql = "UPDATE ".$this->_tables['advanced']." SET ";
				$sql.= " `Date` = '".$info['date']."'";
				$sql.= " ,`CityCode` = '".$CityCode."'";
				if ($info['t'] !== null)
					$sql.= " ,`T` = ".(int) $info['t'];
				$sql.= " ,`WindWard` = '".trim($info['wind_ward'])."'";
				$sql.= " ,`WindSpeed` = ".(int) $info['wind_speed'];

				if ( $info['humidity'] >= 0)
					$sql.= " ,`Humidity` = ".(int) $info['humidity'];
                if ( $info['precip'] >= 0)
					$sql.= " ,`Precip` = ".(int) $info['precip'];
				if ( $info['precip_chance'] >= 0)
					$sql.= " ,`PrecipChance` = ".(int) $info['precip_chance'];
				if ( $info['visibility'] >= 0)
					$sql.= " ,`Visibility` = ".(int) $info['visibility'];

				$sql.= " WHERE ";
				$sql.= " `CityCode` = '".$CityCode."'";
				$sql.= " AND `Date` = '".$info['date']."'";
				$this->_db->query($sql);
			}
			elseif ($info['t'] !== null)
			{
				$sql = "INSERT INTO ".$this->_tables['advanced']." SET ";
				$sql.= " `Date` = '".$info['date']."'";
				$sql.= " ,`CityID` = ".$cityid;
				$sql.= " ,`CityCode` = '".$CityCode."'";

				$sql.= " ,`T` = ".(int) $info['t'];
				$sql.= " ,`WindWard` = '".trim($info['wind_ward'])."'";
				$sql.= " ,`WindSpeed` = ".(int) $info['wind_speed'];

				if ( $info['humidity'] >= 0)
					$sql.= " ,`Humidity` = ".(int) $info['humidity'];
                if ( $info['precip'] >= 0)
					$sql.= " ,`Precip` = ".(int) $info['precip'];
				if ( $info['precip_chance'] >= 0)
					$sql.= " ,`PrecipChance` = ".(int) $info['precip_chance'];
				if ( $info['visibility'] >= 0)
					$sql.= " ,`Visibility` = ".(int) $info['visibility'];

				$this->_db->query($sql);
			}
		}

		$this->GetCurrentWeather($CityCode, true); // Делаем обновление кеша
		$this->Get10DaysWeather($CityCode, true); // Делаем обновление кеша

		$this->_db->close();
		return true;
	}

	/*
	 * Метод saveOtherAdvanced - пока хрен знает для чего, но грабилкой используется, значит надо
	 * сохраняет погоду в базу данных и обнуление кеша в расширенном варианте варианте
	 * @param cityid - ИД города, по которому сохраняется запись
	 * @param weather - Массив данных о погоде
     * @return - Булево значение, указывающее на успешность выполнения функции
	 */
	public function saveOtherAdvanced($cityid, $weather)
	{
		$CityCode = $this->_Cities[$cityid] ? $this->_Cities[$cityid] : '';
		foreach ($weather as $list)
		{
			foreach ($list as $type => $info)
			{
				if ( strtotime($info['date']) === false )
					continue;

				if ( $type == 'night' )
					$type = 2;
				else
					$type = 1;

				$sql = "SELECT * FROM ".$this->_tables['10daysDN']." WHERE ";
				$sql.= " `CityCode` = '".$CityCode."' AND `Type`=".$type;
				$sql.= " AND `Date` = '".$info['date']."'";

				$res = $this->_db->query($sql);

				if ( $res->num_rows > 1 )
				{
					$sql = "DELETE FROM ".$this->_tables['10daysDN']." WHERE ";
					$sql.= " `CityCode` = '".$CityCode."' AND `Type`=".$type;
					$sql.= " AND `Date` = '".$info['date']."' LIMIT ".($res->num_rows-1);

					$this->_db->query($sql);
				}

				if ( $res && $res->num_rows )
				{

					$sql = "UPDATE ".$this->_tables['10daysDN']." SET ";
					$sql.= " `Date` = '".$info['date']."'";
					$sql.= " ,`CityCode` = '".$CityCode."'";

					if ($info['t'] !== null)
						$sql.= " ,`T` = ".(int) $info['t'];

					$sql.= " ,`WindWard` = '".trim($info['wind_ward'])."'";
					$sql.= " ,`WindSpeed` = ".(int) $info['wind_speed'];

					if ( $info['humidity'] >= 0)
						$sql.= " ,`Humidity` = ".(int) $info['humidity'];
					if ( $info['precip'] >= 0)
						$sql.= " ,`Precip` = ".(int) $info['precip'];
					if ( $info['precip_chance'] >= 0)
						$sql.= " ,`PrecipChance` = ".(int) $info['precip_chance'];
					$sql.= " WHERE ";
					$sql.= " `CityCode` = '".$CityCode."' AND `Type`=".$type;
					$sql.= " AND `Date` = '".$info['date']."'";

					$this->_db->query($sql);
				}
				elseif ($info['t'] !== null)
				{
					$sql = "INSERT INTO ".$this->_tables['10daysDN']." SET ";
					$sql.= " `Date` = '".$info['date']."'";
					$sql.= " ,`CityID` = ".$cityid;
					$sql.= " ,`CityCode` = '".$CityCode."'";
					$sql.= " ,`T` = ".(int) $info['t'];
					$sql.= " ,`WindWard` = '".trim($info['wind_ward'])."'";
					$sql.= " ,`WindSpeed` = ".(int) $info['wind_speed'];

					if ( $info['humidity'] >= 0)
						$sql.= " ,`Humidity` = ".(int) $info['humidity'];
					if ( $info['precip'] >= 0)
						$sql.= " ,`Precip` = ".(int) $info['precip'];
					if ( $info['precip_chance'] >= 0)
						$sql.= " ,`PrecipChance` = ".(int) $info['precip_chance'];
					$sql.= " , `Type` = ".$type;

					$this->_db->query($sql);
				}

			}
		}

		$this->GetCurrentWeather($CityCode, true); // Делаем обновление кеша
		$this->Get10DaysWeather($CityCode, true); // Делаем обновление кеша

		$this->_db->close();
		return true;
	}

	/*
	 * Метод _convertWindWard - закрытый
	 * конвертит абревиатуру в удобочитаемый вид
	 * @param ww - ИД города, по которому сохраняется запись
     * @return - Булево значение, указывающее на успешность выполнения функции
	 */
	protected function _convertWindWard($ww) {

		$ww = trim($ww);
		if ( isset($this->_WindWards[$ww]) )
			return $this->_WindWards[$ww];
		else if ( strlen($ww) == 3 ) {

			$ww = array(
				substr($ww,0,1),
				substr($ww,1,2),
			);

			if ( isset($this->_WindWards[$ww[0]]) && isset($this->_WindWards[$ww[1]]) ) {
				return array(
					$this->_WindWards[$ww[0]][0].' - '.$this->_WindWards[$ww[1]][0],
					$this->_WindWards[$ww[0]][1].' - '.$this->_WindWards[$ww[1]][1],
				);
			}
		}

		return null;
	}

	/**
	  хак для коррекции утренней погоды
	*/
	protected function _fix_morning_T($city)
	{
		$offsetTS = Datetime_my::NowOffsetTime();
		$hour = idate('H',$offsetTS);
		if ( $hour > 5 && $hour < 11 )
		{
			// берем подробную для утра: до 9:00 - для текущего часа, после 9:00 - для 9:00 (утренняя погода)
			$sql = 'SELECT `T` FROM '. $this->_tables['advanced'] . ' WHERE ';
			$sql.= ' `CityCode` = \''. $city .'\'';
			$sql.= ' AND `Date` <= \''. date('Y-m-d',$offsetTS).' '.min($hour,9).':00:00' .'\'';
			$sql.= ' ORDER BY `Date` DESC LIMIT 1';
			$res = $this->_db->query($sql);
			if ( $res !== false && (list($t) = $res->fetch_row()) )
			{
				if ( $hour < 8 )
					return $t-1;
				else
					return $t+1;
			}
		}
		return false;
	}
}
?>
