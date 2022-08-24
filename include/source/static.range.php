<?php

/**
 * Список диаппазона
 * @param int $params['from'] от
 * @param int $params['to'] до
 * @return array данные id - идентификатор, name - название цвета
 */
function source_static_range($params)
{
	if(empty($step))
		$step = 1;
	else
		$step = abs($params['step']);
	if($step == 0)
		$step = 1;
	if($params['from'] > $params['to'])
		$step = -$step;
	$arr = array();
	if($step < 0)
		for($i = $params['from']; $i >= $params['to']; $i+=$step)
			$arr[] = array('id' => $i, 'name' => $i);
	else
		for($i = $params['from']; $i <= $params['to']; $i+=$step)
			$arr[] = array('id' => $i, 'name' => $i);
	return $arr;
}

?>
