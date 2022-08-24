<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once $smarty->_get_plugin_filepath('shared','make_timestamp');

/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     month_to_string<br>
 * Purpose:  convert time to fullname month
 * @param time
 * @return string
 */
function smarty_modifier_month_to_string($time, $type=1)
{
	$month[1] = array(
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
		12=> "декабрь"
	);
	$month[2] = array(
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
	$month[3] = array(
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
		12=> "дек"
	);
	if(!$time)
		$time = time();
	if(!in_array($type, array(1, 2, 3)))
		$type=2;
    
	$n = ( $time <= 12 )? $time: date("n", smarty_make_timestamp($time));

	return $month[$type][intval($n)];
}

?>