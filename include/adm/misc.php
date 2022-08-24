<?

/**
 * Получение пути для раздела по id
 * @param int $id идентификатор раздела
 * @return array 0 - путь раздела 1 - путь сайта
 */
function GetSectionFullPath($id)
{
	$db = DBFactory::GetInstance('site');

	// определим путь к конфигу для выбранного объекта
	// типы: 1 - сайт, 2 - раздел, 3 - страница
	$res = $db->query(
		"SELECT id, parent, name, path, type, t_id
		 FROM tree");

	while($row = $res->fetch_row())
	{
		$data[$row[0]] = $row;
		$tree[$row[1]][] = $row[0];
	}
	
	$path = array();
	$name = array();
	$cid = $id;
	while($cid != 0)
	{
		$path[] = $data[$cid][3];	
		$name[] = $data[$cid][2];	
		$cid = $data[$cid][1];
	}
	$path = array_reverse($path, true);
	$name = array_reverse($name, true);
	return array($path, $name);
}

/**
 * Получение пути для раздела по id
 * @param int $id идентификатор раздела
 * @return array 0 - путь раздела 1 - путь сайта
 */
function GetSectionPath($id)
{
	$db = DBFactory::GetInstance('site');

	// определим путь к конфигу для выбранного объекта
	// типы: 1 - сайт, 2 - раздел, 3 - страница
	$res = $db->query(
		"SELECT id, parent, name, path, type, t_id
		 FROM tree");

	while($row = $res->fetch_row())
	{
		$data[$row[0]] = $row;
		$tree[$row[1]][] = $row[0];
	}
	
	$ctype = $data[$id][4];

	if($ctype == 1)
		return array(false,false);
	if($ctype == 2 || $ctype == 3)
	{
		$path = $data[$id][3];
		$cid = $id;
		$name = $data[$id][2];
		
		while($ctype != 1 && $cid != 0)
		{
			$cid = $data[$cid][1];
			$ctype = $data[$cid][4];
			if($ctype == 1)
			{
				$site_id = $cid;
			}
			if($ctype == 2 || $ctype == 3)
				$path = $data[$cid][3].'/'.$path;	
		}
	}
	
	$res = $db->query("SELECT path FROM site WHERE tree_id={$site_id}");
	if($row = $res->fetch_row())
	{
		$spath = $row[0];
	}
	
	return array($path, $spath);
}

/**
 * Список разделов на сайте, в различных видах
 */
 
function GetSectionList($outtype, $parent = 0, $params = null)
{
	$db = DBFactory::GetInstance('site');

	$res = $db->query(
		"SELECT id, parent, name, path, type, t_id, visible, deleted, regions
		 FROM tree
		 ORDER BY name");
		 
	while($row = $res->fetch_row())
	{
		$data[$row[0]] = $row;
		$tree[$row[1]][] = $row[0];
	}
	
	$arr = __S_CreateTree($data, $tree, $parent);
	if($outtype == 'array')
		return $arr;
	
	$opt = false;
	
	foreach($arr as $a)
	{
		if(1 == $a['type'])
		{
			if($opt == true)
				$html.= '</optgroup>';
			$html.= "<optgroup label=\"{$a['name']}\">";
		}
		else if($outtype == 'option' && (!isset($params['notshow']) || (isset($params['notshow']) && $params['notshow'] != $a['id'])))
		{
			if(!isset($params['onlytype']) || (isset($params['onlytype']) && $params['onlytype'] == $a['type']))
				$html.= "<option value=\"{$a['id']}\">".str_repeat('&nbsp;', ($a['offset']-1)*3)."{$a['name']}</option>";
		}
	}
	if($opt == true)
		$html.= '</optgroup>';
	
	return $html;
}

function __S_CreateTree(&$data, &$tree, $parent = 0, $offset = 0)
{
	global $SECTION_ID;
	if(count((array)$tree[$parent]) == 0)
		return "";
	$arr = array();
	foreach($tree[$parent] as $v)
	{
		$arr[] = array(
			'count'		=> count($tree[$v]),
			'type'		=> $data[$v][4],
			'id'		=> $v,
			'name'		=> $data[$v][2],
			'selected'	=> 0,
			'offset'	=> $offset
			);
		if(count($tree[$v]) > 0)
		{
			$arr = array_merge($arr, __S_CreateTree($data, $tree, $v, $offset+1));
		}
	}
	return $arr;
}

/**
 * Управление сортировкой столбцов
 * Функция сохраняет настройки в переменной _SESSION
 * @param array $field массивы полей сортировки (0 - имя поля в таблице, 1 - сортировка по умолчанию)
 * @param string $id идентификатор сортировки
 * @return array возвращает поле и порядок сортировки
 */

function GetSortOrder($fields, $id = "default")
{
	if(isset($_GET['sort']))
	{
		if($_GET['sort'] == $_SESSION['s'.$id]['sort_list'])
			$_SESSION['s'.$id]['sort_order'] = $_SESSION['s'.$id]['sort_order']=='ASC'?'DESC':'ASC';
		else
		{
			$_SESSION['s'.$id]['sort_list'] = $fields[$_GET['sort']][0];
			$_SESSION['s'.$id]['sort_order'] = $fields[$_GET['sort']][1];
		}
	}
	if(isset($_SESSION['s'.$id]['sort_list']))
	{
		$sort_field = $_SESSION['s'.$id]['sort_list'];
		$sort_order = $_SESSION['s'.$id]['sort_order']=='ASC'?'ASC':'DESC';
	}
	else
	{
		list($key, $sort) = each($fields);
		list($sort_field, $sort_order) = $sort;
	}
	return array($sort_field, $sort_order);
}

// некоторая работа с сессиями
/**
 * Получение значение переменной
 * @param int $id идентификатор раздела
 * @param string $name имя переменной в массиве $_SESSION
 * @param mixed $value значение по умолчанию
 * @param string $rname имя переменной в массиве $_REQUEST (если null, то значение в $_SESSION не меняем)
 */
function GetSessionValue($id, $name, $value, $rname = null)
{
	$_value = null;
	if(isset($_SESSION['s'.$id]['vars'][$name]))
		$_value = $_SESSION['s'.$id]['vars'][$name];
	else
	{
		$_SESSION['s'.$id]['vars'][$name] = $value;
		$_value = $value;
	}
	if($rname != null)
	{
		if(isset($_REQUEST[$rname]))
		{
			$_value = $_REQUEST[$rname];
			$_SESSION['s'.$id]['vars'][$name] = $_value;
		}
	}
	return $_value;
}

// Функции для смарти, используемые в админке, в основном генерация html кода для определенных полей ввода
/**
 * Вывод полей для ввода даты
 */
function smarty_date($params)
{
	if(isset($params['prefix']))
		$prefix = $params['prefix'].'_';
	else
		$prefix = '';
	$months = array(1 => "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
	if(!empty($params['current']))
		$cur = $params['current'];
	else
		$cur = time();
	if(!empty($params['with_date']) && $params['with_date']=='true')
	{
		$day = idate('d', $cur);
		echo "<select name=\"{$prefix}day\" style=\"width:40px;\">";
		for($i = 1; $i < 32; $i++)
			echo "<option value=\"$i\"".($day==$i?' selected':'').">$i</option>";
		echo '</select>&nbsp;';
		//echo "<select name=\"{$prefix}month\" style=\"width:80px;\">";
		echo "<select name=\"{$prefix}month\">";
		$month = idate('m', $cur);
		for($i = 1; $i < 13; $i++)
			echo "<option value=\"$i\"".($month==$i?' selected':'').">{$months[$i]}</option>";
		echo '</select>&nbsp;';
		echo "<select name=\"{$prefix}year\" style=\"width:58px;\">";
		$ys = idate('Y', time()) - 10;
		$year = idate('Y', $cur);
		for($i = $ys; $i <= $ys + 15; $i++)
			echo "<option value=\"$i\"".($year==$i?' selected':'').">$i</option>";
		echo '</select>&nbsp;';
	}
	if(!empty($params['with_time']) && $params['with_time']=='true')
	{
		$hour = idate('H', $cur);
		$min = idate('i', $cur);
		$sec = idate('s', $cur);
		echo "<input name=\"{$prefix}hour\" value=\"$hour\" style=\"width:24px;\">&nbsp;:&nbsp;";
		echo "<input name=\"{$prefix}min\" value=\"$min\" style=\"width:24px;\">&nbsp;:&nbsp;";
		echo "<input name=\"{$prefix}sec\" value=\"$sec\" style=\"width:24px;\">";
	}
}
?>