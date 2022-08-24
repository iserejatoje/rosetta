<?php

/**
 * Получение списка объемов двигателей
 * @return array данные id - идентификатор, value - объем
 */
function source_db_valueengine($params)
{
	global $DCONFIG;
	$arr = array();
	$start = 0.5;
	$i = 1;
	while((($i-1)*0.1+$start)<=8)  {                     
		$arr[$i] = array('id' => $i, 'value' => number_format(($i-1)*0.1+$start,1,'.',' '));
		$i++;
	}
	$arr[$i] = array('id' => $i, 'value' => 'более 8.0');
	return $arr;
}

?>
