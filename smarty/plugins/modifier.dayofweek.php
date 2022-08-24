<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     dayofweek<br>
 * Purpose:  convert date to rus day of week
 * @param time
 * @return string
 */
function smarty_modifier_dayofweek($date, $type=1)
{
	$dw[1] = array(
		0 => "Воскресенье",
		1 => "Понедельник",
		2 => "Вторник",
		3 => "Среда",
		4 => "Четверг",
		5 => "Пятница",
		6 => "Суббота"
	);
	$dw[2] = array(
		0 => "воскресенье",
		1 => "понедельник",
		2 => "вторник",
		3 => "среда",
		4 => "четверг",
		5 => "пятница",
		6 => "суббота"
	);
	$dw[3] = array(
		0 => "вс",
		1 => "пн",
		2 => "вт",
		3 => "ср",
		4 => "чт",
		5 => "пт",
		6 => "сб"
	);
	if(!$date)
		$time = time();
	else 
		$time = strtotime($date);

	if(!in_array($type, array(1, 2, 3)))
		$type=2;

	$n = intval(date("w", $time));

	return $dw[$type][$n];
}

?>