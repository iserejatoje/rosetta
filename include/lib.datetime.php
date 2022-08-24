<?

/**
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!    D  E  P  R  E  C  A  T  E  D
*!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/



/**
*
*  А если по-русски, то эту либу пользоватье нельзя!
*
*/







class Datetime
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
	
    static function NowOffset($offset = null)
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
    	return date('Y-m-d H:i:s', time() + $offset);
	}
	
	static function DateOffset($offset = null)
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
    	return date('Y-m-d', time() + $offset);
	}

}

?>