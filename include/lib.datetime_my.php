<?

class Datetime_my
{

static $day_of_week = array(
		0 => "воскресенье",
		1 => "понедельник",
		2 => "вторник",
		3 => "среда",
		4 => "четверг",
		5 => "пятница",
		6 => "суббота",
	);
  static $day_of_week_short = array(
		0 => "ВС",
		1 => "ПН",
		2 => "ВТ",
		3 => "СР",
		4 => "ЧТ",
		5 => "ПТ",
		6 => "СБ",
	);

  static $month = array(
		1 => "январь",
		2 => "февраль",
		3 => "март",
		4 => "апрель",
		5 => "май",
		6 => "июнь",
		7 => "июль",
		8 => "август",
		9 => "сентябрь",
		10=> "октябрь",
		11=> "ноябрь",
		12=> "декабрь",
	);

  static $month2 = array(
		1 => "января",
		2 => "февраля",
		3 => "марта",
		4 => "апреля",
		5 => "мая",
		6 => "июня",
		7 => "июля",
		8 => "августа",
		9 => "сентября",
		10=> "октября",
		11=> "ноября",
		12=> "декабря",
	);
	
  static $month3 = array(
		1 => "янв",
		2 => "фев",
		3 => "мар",
		4 => "апр",
		5 => "мая",
		6 => "июн",
		7 => "июл",
		8 => "авг",
		9 => "сен",
		10=> "окт",
		11=> "ноя",
		12=> "дек",
	);

    static function NowOffset($offset = null, $time = null)
    {
    	
		return date('Y-m-d H:i:s', self::NowOffsetTime($offset, $time));
	}
	
	static function NowOffsetTime($offset = null, $time = null)
	{
		global $CONFIG;
		if($offset === null)
		{
			if(isset($CONFIG['env']['site']['timeoffset']))
				$offset = intval($CONFIG['env']['site']['timeoffset']);
			else if(isset($CONFIG['timeoffset']))
				$offset = intval($CONFIG['timeoffset']);
			else
				$offset = 0;
		}
		$offset*= 3600;
		if($time === null)
			$time = time();
		return $time + $offset;
	}
	
	static function DateOffset($offset = null, $time = null, $format = 'Y-m-d')
    {
    	global $CONFIG;
    	if($offset === null)
    	{
    		if(isset($CONFIG['env']['site']['timeoffset']))
    			$offset = $CONFIG['env']['site']['timeoffset'];
    		else if(isset($CONFIG['timeoffset']))
    			$offset = $CONFIG['timeoffset'];
    		else
    			$offset = 0;
		}
		$offset*= 3600;
		if($time === null)
			$time = time();
    	return date($format, $time + $offset);
	}
	
	
	/**
	 * Purpose:  format simply date<br>
	 * Input:<br>
	 * @param string input date string
	 * @param string format for the nearest days
	 * @param string format for other days
	 * @uses smarty_make_timestamp()
	 */
	static function SimplyDate( $string, $format="%f %H:%M", $format2="%d %F", $format3="%d %F %Y" )
	{
		global $CONFIG;
		
	    if ( empty($string) )
			$time = time();
		else if ( is_string($string) )
			$time = strtotime($string);
		else
			$time = intval($string);
		
		// вычисляем текущее локальное время
		$offset = 0;		
		if ( isset($CONFIG['env']['site']['timeoffset']) )
			$offset = $CONFIG['env']['site']['timeoffset'];
		elseif ( isset($CONFIG['timeoffset']) )
			$offset = $CONFIG['timeoffset'];
		$offset*= 3600;
		
		$nowtime = mktime(0, 0, 0, idate('m', time()+$offset), idate('d', time()+$offset), idate('y', time()+$offset));
		$nowyear = idate('y', time()+$offset);
		
		$year = date('y', $time);
		$mon = date('n', $time);
		
		$text = '';
		// проверяем разницу в днях
		if($nowtime <= $time && $nowtime + 86400 > $time)
			$text = 'сегодня';
		else if($nowtime + 86400 <= $time && $nowtime + 2*86400 > $time)
			$text = 'завтра';
		else if($nowtime - 86400 <= $time && $nowtime > $time)
			$text = 'вчера';
		else if($nowtime - 2*86400 <= $time && $nowtime - 86400 > $time)
			$text = 'позавчера';
		else if ($nowyear == $year)
			$format = $format2;
		else
			$format = $format3;
				
		$format = str_replace('%f', $text, $format);
		$format = str_replace('%Fs', self::$month3[$mon], $format);
		$format = str_replace('%F', self::$month2[$mon], $format);
		
		return strftime($format, $time);
	}


	function UserOnLine($string, $format="%f %H:%M", $format_alternate = "%d %F", $gender = 1)
	{
		global $CONFIG;

		if ( is_string($string) )
			$time = strtotime($string);
		else
			$time = intval($string);

		if($string <= 0)
			return '';
			
		// РІС‹С‡РёСЃР»СЏРµРј С‚РµРєСѓС‰РµРµ Р»РѕРєР°Р»СЊРЅРѕРµ РІСЂРµРјСЏ
		$offset = 0;
		if(isset($CONFIG['env']['site']['timeoffset']))
			$offset = $CONFIG['env']['site']['timeoffset'];
		elseif(isset($CONFIG['timeoffset']))
			$offset = $CONFIG['timeoffset'];
		$offset*= 3600;

		$now = time() + $offset;
		$time = $time + $offset;
		if($now - 15*60 < $time)
			return '<img src="/_img/modules/passport/online_01.gif" width="100" height="10" alt="РЅР° СЃР°Р№С‚Рµ" />'; //$text = 'РѕРЅР»Р°Р№РЅ';
		
		$text = '';
		if(date('Ymd') == date('Ymd', $time)) 
			$text = 'Р±С‹Р»'.($gender==2?'Р°':'').' СЃРµРіРѕРґРЅСЏ РІ ';
		else if(date('Ymd', $now - 86400) == date('Ymd', $time)) 
			$text = 'Р±С‹Р»'.($gender==2?'Р°':'').' РІС‡РµСЂР° РІ ';
		else if(date('Ymd', $now - 86400*2) == date('Ymd', $time)) 
			$text = 'Р±С‹Р»'.($gender==2?'Р°':'').' РїРѕР·Р°РІС‡РµСЂР° РІ ';
		else
			$format = 'Р±С‹Р»'.($gender==2?'Р°':'').' '.str_replace('%F', self::$month2[intval(date('n', $time))], $format_alternate);
		
		$format = str_replace('%f', $text, $format);
		return strftime($format, $time);
	}
	
	/**
	 * РІС‹РІРѕРґ РїСЂРѕРјРµР¶СѓС‚РєР° РјРµР¶РґСѓ РґР°С‚Р°РјРё РІ РІРёРґРµ 26 РЅРѕСЏР±СЂСЏ-31 РґРµРєР°Р±СЂСЏ 
	 * (РµСЃР»Рё РѕРґРёРЅ РјРµСЃСЏС†, С‚Рѕ РѕС‚РѕР±СЂР°Р¶Р°РµС‚СЃСЏ 1 СЂР°Р·, РµСЃР»Рё РµСЃС‚СЊ РіРѕРґ, С‚Рѕ РїРёС€РµС‚СЃСЏ РіРѕРґ)
	 * Input:<br>
	 * @param string input date string	
	 */
	static function DateRange($date1, $date2)
	{		
		$return_date = "";
		if (date("n", $date1) == date("n", $date2)) //Р•СЃР»Рё СЂР°Р·РЅС‹Рµ РјРµСЃСЏС†С‹
		{ 
			if (date("j", $date1) != date("j", $date2)) 	//Р•СЃР»Рё СЂР°Р·РЅС‹Рµ РґРЅРё		
				$return_date.= date("j", $date1)."-";
			$return_date.= date("j", $date2)." ".self::$month2[date("n", $date1)];
		}
		else
		{
			$return_date.=date("j", $date1)." ".self::$month2[date("n", $date1)];
			if (date("Y", $date1) != date("Y", $date2)) 		//Р•СЃР»Рё СЂР°Р·РЅС‹Рµ РіРѕРґР°
				$return_date.=" ".date("Y", $date1);
			$return_date.= " - ".date("j", $date2)." ".self::$month2[date("n", $date2)];
			if (date("Y", $date1) != date("Y", $date2))
				$return_date.=" ".date("Y", $date2);
		}
		return $return_date;
	}
}

?>
