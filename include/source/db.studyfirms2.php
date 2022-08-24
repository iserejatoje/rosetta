<?php

/**
 * Получение древовидного списка компаний
 * @param $params['db'] имя базы данных
 * @param $params['table'] имя таблицы
 * @param $params['table_tree'] имя таблицы для дерева
 * @param $params['table_ent'] имя таблицы для связи дерева и данных
 * @param $params['parent'] корневой для длерева (пути правильные)
 * @param $params['parents'] конечные разделы из которых брать фирмы
  * @param $params['regid'] регионы
 * @param $params['logopath'] путь к логотипам
 * @param $params['id'] идентификатор компании
 * @return array данные id - идентификатор, name - имя, shortname - короткое имя, logotype - полный web путь к логотипу, если нет пусто, path - путь в справочнике фирм
 */
function source_db_studyfirms2($params)
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
	
	$sql = "SELECT d.id,d.name,d.shortname,d.logotype,e.parent
			FROM {$params['table']} AS d
			LEFT JOIN {$params['table_ent']} AS e ON d.id=e.eid
			WHERE d.visible=1 AND e.parent IN ({$params['parents']}) AND d.regid IN({$params['regid']})";
	if(!empty($params['id']))
		$sql.= " AND d.id={$params['id']}";
	$sql.= " ORDER BY name";
	$res = $db->query($sql);
	$arr = array();
	while($row = $res->fetch_row())
	{
		list($node, $desc) = $tree->FindById($row[4], true, true);
		$last = end($desc);
		$path = $last['path'];
		$path = substr($path, strpos($path, '/')+1);
		if(!empty($row[3]))
			$logo = $params['logopath'].$row[3];
		else
			$logo = '';
		$arr[$row[0]] = array('id' => $row[0], 'name' => $row[1], 'shortname' => $row[2], 'logotype' => $logo, 'path' => "$path/{$row[0]}.html");
	}
	return $arr;
}

?>