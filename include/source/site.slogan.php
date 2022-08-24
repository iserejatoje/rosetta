<?php

/**
 * Получение слогана для сайта/сайтов
 * @param boolean $params['regid'] выбор слоганов по идентификатору региона
 * @return array данные regid - номер региона, text - слоган (key = domain)
 */
function source_site_slogan($params) {
	global $DCONFIG;
	
	$db = DBFactory::GetInstance('public');
	
	$sql = 'SELECT `domain`, `text`, `regid` FROM site_slogan ';
	
	if ($params['domain']) {
		$sql .= ' WHERE `domain` = \''.addslashes($params['domain']).'\' ';
	}
	if ($params['regid']) {
		$sql .= (!$params['domain']) ? ' WHERE ' : ' AND ';
		$sql .= ' `regid` = \''.addslashes($params['regid']).'\' ';
	}
	
	$res = $db->query($sql);
	$arr = array();
	while(false != ($row = $res->fetch_row())) {
		$arr[$row[0]] = array('text' => $row[1], 'regid' => $row[2]);
	}
	return $arr;
}

?>