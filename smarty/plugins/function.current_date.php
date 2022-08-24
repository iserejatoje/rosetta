<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_function_current_date($params, &$smarty)
{
	global $CONFIG;

	// вычисляем текущее локальное время
	$offset = 0;
	if(isset($CONFIG['env']['site']['timeoffset']))
		$offset = $CONFIG['env']['site']['timeoffset'];
	elseif(isset($CONFIG['timeoffset']))
		$offset = $CONFIG['timeoffset'];

	$offset*= 3600;

	$d = getdate(time()+$offset);

	switch($d['wday'])
	{
	case 0:$wd = 'Воскресенье';break;
	case 1:$wd = 'Понедельник';break;
	case 2:$wd = 'Вторник';break;
	case 3:$wd = 'Среда';break;
	case 4:$wd = 'Четверг';break;
	case 5:$wd = 'Пятница';break;
	case 6:$wd = 'Суббота';break;
	}
	
	switch($d['mon'])
	{
	case 1:$md = 'января';break;
	case 2:$md = 'февраля';break;
	case 3:$md = 'марта';break;
	case 4:$md = 'апреля';break;
	case 5:$md = 'мая';break;
	case 6:$md = 'июня';break;
	case 7:$md = 'июля';break;
	case 8:$md = 'августа';break;
	case 9:$md = 'сентября';break;
	case 10:$md = 'октября';break;
	case 11:$md = 'ноября';break;
	case 12:$md = 'декабря';break;
	}
	
	$retval = $wd.', '.$d['mday'].' '.$md;
	
    return $retval;
    
}

/* vim: set expandtab: */

?>
