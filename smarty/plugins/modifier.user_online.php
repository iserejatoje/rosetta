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
 * Smarty spacify modifier plugin
 *
 * Type:     modifier<br>
 * Name:     user_online<br>
 * Purpose:  выводит "онлайн" или "был сегодня 10:58"
 * 
 * @param timestamp
 * @return string
 */
function smarty_modifier_user_online($string, $format="%f %H:%M", $format_alternate = "%d %F", $gender = 1)
{
	global $CONFIG;
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

		$now = time() + $offset;
		
		$text = '';
		$is_online = false;
		if($time == 0)
			return '';
		else if($now - 15*60 < $time)  {
			$text = '<img src="/_img/modules/passport/online_01.gif" width="100" height="10" alt="на сайте" />'; //$text = 'онлайн';
			$is_online = true;
		} else if(date('Ymd') == date('Ymd', $time)) 
			$text = 'был'.($gender==2?'а':'').' сегодня в ';
		else if(date('Ymd', $now - 86400) == date('Ymd', $time)) 
			$text = 'был'.($gender==2?'а':'').' вчера в ';
		else if(date('Ymd', $now - 86400*2) == date('Ymd', $time)) 
			$text = 'был'.($gender==2?'а':'').' позавчера в ';
		else
			$format = 'был'.($gender==2?'а':'').' '.str_replace('%F', $month[intval(date('n', $time))], $format_alternate);
			
		if($is_online)
			return $text;
		else
		{
			$format = str_replace('%f', $text, $format);
			return strftime($format, smarty_make_timestamp($string));
		}
	}
	else
		return '';
}

/* vim: set expandtab: */

?>
