<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Include the {@link shared.make_timestamp.php} plugin
 */
require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     simply_date<br>
 * Purpose:  format simply date<br>
 * Input:<br>
 * @param string input date string
 * @param string format for the nearest days
 * @param string format for other days
 * @uses smarty_make_timestamp()
 */
function smarty_modifier_simply_date($string, $format="%f %H:%M", $format_alternate = "%d.%m.%Y %H:%M")
{
	$month = array(
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
		12=> "декабря"
		);
	global $CONFIG;

    if($string != '')
	{

		$time = smarty_make_timestamp($string);

		// вычисляем текущее локальное время
		$offset = 0;
		if(isset($CONFIG['env']['site']['timeoffset']))
			$offset = $CONFIG['env']['site']['timeoffset'];
		elseif(isset($CONFIG['timeoffset']))
			$offset = $CONFIG['timeoffset'];
		$offset*= 3600;

		$nowtime = mktime(0, 0, 0, idate('m', time()+$offset), idate('d', time()+$offset), idate('y', time()+$offset));
		//$nowday = idate('z', time()+$offset);
		$nowyear = date('y', time()+$offset);

		//$day = idate('z', $time);

		$year = date('y', $time);

		$error = error_get_last();
		if (is_array($error))
			if ($error['type'] == E_WARNING)
			{
				$bt = debug_backtrace();
				error_log($bt[1]['file'].':'.$bt[1]['line'].": smarty_modifier_simply_date: ".$string);
			}

		$mon = idate('m', $time);

		$text = '';
		// проверяем разницу в днях
		/*
		if($nowday - $day == 0 && $nowyear == $year)
			$text = 'сегодня';
		else if($nowday - $day == -1 && $nowyear == $year)
			$text = 'завтра';
		else if($nowday - $day == 1 && $nowyear == $year)
			$text = 'вчера';
		else if($nowday - $day == 2 && $nowyear == $year)
			$text = 'позавчера';
		else if ($nowyear == $year)
			$format = "%d %F";
		else
			$format = "%d %F %Y";
		*/
		if($nowtime <= $time && $nowtime + 86400 > $time)
			$text = 'сегодня';
		else if($nowtime + 86400 <= $time && $nowtime + 2*86400 > $time)
			$text = 'завтра';
		else if($nowtime - 86400 <= $time && $nowtime > $time)
			$text = 'вчера';
		else if($nowtime - 2*86400 <= $time && $nowtime - 86400 > $time)
			$text = 'позавчера';
		else if ($nowyear == $year)
			$format = "%d %F";
		else
			$format = "%d %F %Y";
		
		
		/*else
			$format = $format_alternate;*/
			
		$format = str_replace('%f', $text, $format);
		$format = str_replace('%F', $month[$mon], $format);
		
        return strftime($format, smarty_make_timestamp($string));
	}
}

/* vim: set expandtab: */

?>
