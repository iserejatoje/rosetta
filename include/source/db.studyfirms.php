<?php

/**
 * Получение древовидного списка компаний
 * @param $params['db'] имя базы данных
 * @param $params['table'] имя таблицы
 * @param $params['logopath'] путь к логотипам
 * @param $params['id'] идентификатор компании
 * @return array данные id - идентификатор, name - имя, shortname - короткое имя, logotype - полный web путь к логотипу, если нет пусто, path - путь в справочнике фирм
 */
function source_db_studyfirms($params)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance($params['db']);
	
	$sql = "SELECT id, parent, title, name
			FROM {$params['table_tree']}
			WHERE visible=1
			ORDER BY ord";
			
	$res = $db->query($sql);
	while($row = $res->fetch_row())
		$data[$row[0]] = array('parent' => $row[1], 'data' => $row[2], 'name' => $row[3]);
	$tree = new Tree();
	$tree->BuildTree($data);
	
	$sql = "SELECT id,name,shortname,logotype,parent
			FROM {$params['table']}
			WHERE visible=1";
	if(!empty($params['id']))
		$sql.= " AND id={$params['id']}";
	$sql.= " ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
	{
		list($node, $desc) = $tree->FindById($row[4], true, true);
		$last = end($desc);
		$path = $last['path'];
		if(!empty($row[3]))
			$logo = $params['logopath'].$row[3];
		else
			$logo = '';
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1], 'shortname' => $row[2], 'logotype' => $logo, 'path' => "$path/{$row[0]}.html");
	}
	return $arr;
}

?>