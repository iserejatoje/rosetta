<?

// работа с фильтрами: получение html кода для вставки в страницу, формирование sql запроса
class Filter
{
	/**
	 * Генерация хтмл кода для фильтра
	 * @param array $filter описание фильра
	 * @param boolean $hidden отображать кнопку открытия фильтра
	 * @param boolean $withform добавить форму для блока фильтра
	 */
	static function GetHTML($filter, $hidden = true, $withform = true)
	{
		// собираем код фильтра
		$html='';
		if($withform == true)
			$html.='<form>';
		$html.= '<input type="hidden" id="__filter_action" name="__filter_action" value=""><table width="80%" align="center">';
		$filled = false;
		foreach($filter as $k => $f)
		{
			$html.="<tr><td width=\"150\" bgcolor=\"#F0F0F0\">{$f['title']}</td><td>";
			switch($f['type'])
			{
			case 'number':	
				if(!empty($_REQUEST['__filter'][$k]) || (string) $_REQUEST['__filter'][$k] != '')
					$filled = true;
			case 'value':
			case 'string':
				if(!empty($_REQUEST['__filter'][$k]))
					$filled = true;
				$html.="<input type=\"text\" name=\"__filter[$k]\" value=\"{$_REQUEST['__filter'][$k]}\" class=\"input_100\">";
				break;
			case 'date_range':
				if($_REQUEST['__filter'][$k]['begin']['day']!=0||$_REQUEST['__filter'][$k]['begin']['month']!=0||$_REQUEST['__filter'][$k]['begin']['year']!=0
					||$_REQUEST['__filter'][$k]['end']['day']!=0||$_REQUEST['__filter'][$k]['end']['month']!=0||$_REQUEST['__filter'][$k]['end']['year']!=0)
					$filled = true;
				$y = idate('Y');
				$days1 = self::__GetOptionList(1,31,$_REQUEST['__filter'][$k]['begin']['day']);
				$days2 = self::__GetOptionList(1,31,$_REQUEST['__filter'][$k]['end']['day']);
				$months1 = self::__GetMonthList($_REQUEST['__filter'][$k]['begin']['month']);
				$months2 = self::__GetMonthList($_REQUEST['__filter'][$k]['end']['month']);
				$years1 = self::__GetOptionList(2000,$y+1,$_REQUEST['__filter'][$k]['begin']['year']);
				$years2 = self::__GetOptionList(2000,$y+1,$_REQUEST['__filter'][$k]['end']['year']);
				$html.="<nobr>С <select name=\"__filter[$k][begin][day]\"><option value=\"0\">- день -</option>$days1</select><select name=\"__filter[$k][begin][month]\"><option value=\"0\">- месяц -</option>$months1</select><select name=\"__filter[$k][begin][year]\"><option value=\"0\">- год -</option>$years1</select> до <select name=\"__filter[$k][end][day]\"><option value=\"0\">- день -</option>$days2</select><select name=\"__filter[$k][end][month]\"><option value=\"0\">- месяц -</option>$months2</select><select name=\"__filter[$k][end][year]\"><option value=\"0\">- год -</option>$years2</select></nobr>";
				break;
			case 'dropdown':
				if(is_array($f['params']['array']))
				{
					$o = "";
					if(count($f['params']['array']) > 0 && !empty($_REQUEST['__filter'][$k]))
						$filled = true;
					foreach($f['params']['array'] as $key=>$val)
						$o.= "<option value=\"{$key}\"".(($_REQUEST['__filter'][$k] == $key || (!isset($_REQUEST['__filter'][$k]) && $f['params']['default'] == $key))?' selected="selected"':'').">{$val}</option>";
					$html.="<select name=\"__filter[$k]\" ".($f['params']['elSize'] ? 'size="'.$f['params']['elSize'].'"' : '')." class=\"input_100\">$o</select>";
					break;
				}
				if(!empty($_REQUEST['__filter'][$k]))
					$filled = true;
				if ( empty($f['params']['sql']) ) {
				$sql = "SELECT {$f['params']['field_id']}, {$f['params']['field_name']}
						FROM {$f['params']['table']}";
				if(!empty($f['params']['where']))
					$sql.= ' WHERE '.$f['params']['where'];
				if(!empty($f['params']['order']))
					$sql.= ' ORDER BY '.$f['params']['order'];
				else
					$sql.= ' ORDER BY '.$f['params']['field_name'];
				} else
					$sql = $f['params']['sql'];
				$db = DBFactory::GetInstance($f['params']['db']);
				$res = $db->query($sql);
				$o = '';
				while($row = $res->fetch_row())
				{
					$o.= "<option value=\"{$row[0]}\"".($_REQUEST['__filter'][$k]==$row[0]?' selected="selected"':'').">{$row[1]}</option>";
				}
				$html.="<select name=\"__filter[$k]\" ".($f['params']['elSize'] ? 'size="'.$f['params']['elSize'].'"' : '')." class=\"input_100\"><option value=\"0\">".($f['params']['elDefaultText'] ? $f['params']['elDefaultText'] :'Все группы' )."</option>$o</select>";
				break;
			}
			if(is_array($f['field']))
			{
				$html.="<br><select name=\"__filter_logic[$k]\"><option value=\"or\"".($_REQUEST['__filter_logic'][$k]=='or'?' selected="selected"':'').">Или</option><option value=\"and\"".($_REQUEST['__filter_logic'][$k]=='and'?' selected="selected"':'').">И</option></select>";
				foreach($f['field'] as $_f => $_t)
				{
					$html.="<nobr><input type=\"checkbox\" name=\"__filter_fields[$k][]\" value=\"$_f\"".(is_array($_REQUEST['__filter_fields'][$k])?in_array($_f,$_REQUEST['__filter_fields'][$k])?' checked="checked"':'':'')."> $_t</nobr> ";
				}
			}
			$html.="</td></tr>";
		}
		$html.="<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" value=\"Применить\" onclick=\"if(document.getElementById('action').tagName == 'INPUT') { document.getElementById('action').value='filter'; } else if (document.getElementById('action').tagName == 'SELECT') { document.getElementById('action').options[document.getElementById('action').selectedIndex].value = 'filter'; } document.getElementById('__filter_action').value='filter';\"></td></tr>";
		$html.="</table>";
		if($withform == true)
			$html.="<input type=\"hidden\" name=\"action\" id=\"action\" value=\"filter\"></form>";
		if($hidden == true)
		{
			$html="<div id=\"__filter_div\" style=\"display:none\">$html</div>";
			$ret="<a href=\"#\" onclick=\"this.style.display='none';document.getElementById('__filter_div').style.display='';\">Настроить фильтр</a>";
			if($filled==true)
				$ret.= "&nbsp;<a href=\"#\" onclick=\"obj=document.getElementById('__filter_action');obj.value='clear_filter';document.getElementById('__filter_action').value='clear_filter';obj.form.submit();return false;\">Очистить фильтр</a>";
			$html=$ret.$html;
		}
		return $html;
	}
	
	/**
	 * Генерация условия для SQL запроса. 2do: возможность разделения, для JOIN'ов
	 * @param array $filter описание фильра
	 */
	static function GetSQL($filter, $withwhere = false)
	{
		$sql.='';
		foreach($filter as $k => $f)
		{
			$ret = '';
			switch($f['type'])
			{
			case 'number':
				// хорошая шутка: !empty($_REQUEST['__filter'][$k]
				// а если "0" в запросе ?!
				if(is_numeric($_REQUEST['__filter'][$k]))
					$ret.=self::__GetFieldsList($f['field'], $k, empty($f['compare'])?'equal':$f['compare']);
				break;
			case 'string':
				if(!empty($_REQUEST['__filter'][$k]) && strlen($_REQUEST['__filter'][$k]) >= 1)
					$ret.=self::__GetFieldsList($f['field'], $k, empty($f['compare'])?'string_like':$f['compare']);
				break;
			case 'date_range':
				if(($_REQUEST['__filter'][$k]['begin']['day'] != 0 && $_REQUEST['__filter'][$k]['begin']['month'] != 0 && $_REQUEST['__filter'][$k]['begin']['year'] != 0)
				|| ($_REQUEST['__filter'][$k]['end']['day'] != 0 && $_REQUEST['__filter'][$k]['end']['month'] != 0  && $_REQUEST['__filter'][$k]['end']['year'] != 0)
				)
					$ret.=self::__GetFieldsList($f['field'], $k, 'date_range');
				break;
			case 'dropdown':
				// хорошая шутка: $_REQUEST['__filter'][$k]!=0
				// а если строка в запросе ?!
				if(!empty($_REQUEST['__filter'][$k]) && ( !is_numeric($_REQUEST['__filter'][$k]!=0) || $_REQUEST['__filter'][$k]!=0) )
					$ret.=self::__GetFieldsList($f['field'], $k, empty($f['compare'])?'dropdown_in':$f['compare'], $f['params']);
				break;
			}
			if(!empty($ret) && !empty($sql))
				$sql.=' AND ';
			$sql.=$ret;
		}
		return ($withwhere==true&!empty($sql)?'WHERE ':'').$sql;
	}
	
	static function Clear($id = null)
	{
		unset($_REQUEST['__filter'], $_REQUEST['__filter_fields'], $_REQUEST['__filter_logic']);
		unset($_GET['__filter'], $_GET['__filter_fields'], $_GET['__filter_logic']);
		unset($_POST['__filter'], $_POST['__filter_fields'], $_POST['__filter_logic']);
		if($id != null)
			unset($_SESSION['s'.$id]['filter']);
	}
	
	static function Save($id = null)
	{
		if($id != null && isset($_REQUEST['__filter']))
		{
			$_SESSION['s'.$id]['filter']['filter'] = $_REQUEST['__filter'];
			$_SESSION['s'.$id]['filter']['fields'] = $_REQUEST['__filter_fields'];
			$_SESSION['s'.$id]['filter']['logic'] = $_REQUEST['__filter_logic'];
		}
	}
	
	static function Load($id = null)
	{
		if($id != null)
		{
			$_REQUEST['__filter']		= $_SESSION['s'.$id]['filter']['filter'];
			$_REQUEST['__filter_fields']= $_SESSION['s'.$id]['filter']['fields'];
			$_REQUEST['__filter_logic']	= $_SESSION['s'.$id]['filter']['logic'];
			$_GET['__filter']			= $_SESSION['s'.$id]['filter']['filter'];
			$_GET['__filter_fields']	= $_SESSION['s'.$id]['filter']['fields'];
			$_GET['__filter_logic']		= $_SESSION['s'.$id]['filter']['logic'];
			$_POST['__filter']			= $_SESSION['s'.$id]['filter']['filter'];
			$_POST['__filter_fields']	= $_SESSION['s'.$id]['filter']['fields'];
			$_POST['__filter_logic']	= $_SESSION['s'.$id]['filter']['logic'];
		}
	}
	
	static function IsStored($id = null)
	{
		if($id != null)
		{
			return isset($_SESSION['s'.$id]['filter']);
		}
		return false;
	}
	
	static function IsQuery()
	{
		return isset($_REQUEST['__filter']);
	}

	private static function __GetMonthList($selected=0)
	{
		$m = array(1 => "январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
		$html = '';
		for($i=1;$i<=12;$i++)
			$html.= '<option value="'.$i.'"'.($i==$selected?' selected="selected"':'').'>'.$m[$i]."</option>";
		return $html;
	}

	private static function __GetOptionList($start, $end, $selected=0)
	{
		$html = '';
		for($i=$start;$i<=$end;$i++)
			$html.= '<option value="'.$i.'"'.($i==$selected?' selected="selected"':'').'>'.$i."</option>";
		return $html;
	}

	private static function __GetFieldsList($field, $key, $type, $params=null)
	{
		if(is_array($field))
		{
			$f = &$field;
			$logic = $_REQUEST['__filter_logic'][$key]=='or'?' OR ':' AND ';
		}
		else
		{
			$f[$field]='';
			$logic;
		}
		$value = $_REQUEST['__filter'][$key];
		
		$sql = '';
		foreach($f as $_f => $_v)
		{
			if( is_array($_REQUEST['__filter_fields'][$key]) && !in_array($_f,$_REQUEST['__filter_fields'][$key]) && isset($logic))
				continue;
			if(empty($sql))
				$sql.='(';
			else
				$sql.=$logic;
			switch($type)
			{
			case 'equal':
				$sql.="$_f='".addslashes($value)."'";
				break;
			case 'string_like':
				$sql.="$_f LIKE '%".addslashes($value)."%'";
				break;
			case 'date_range':
				$begin = "";
				if($value['begin']['year']!=0 && $value['begin']['month']!=0 && $value['begin']['day']!=0)
					$begin = sprintf("%04d-%02d-%02d", $value['begin']['year'], $value['begin']['month'], $value['begin']['day']);
				$end = "";
				if($value['end']['year']!=0 && $value['end']['month']!=0 && $value['end']['day']!=0)
					$end = sprintf("%04d-%02d-%02d", $value['end']['year'], $value['end']['month'], $value['end']['day']);
				if($end && $begin)
					$sql.="($_f >= '$begin' AND $_f < '$end')";
				else if($end)
					$sql.="$_f < '$end'";
				else if($begin)
					$sql.="$_f >= '$begin'";
				break;
			case 'dropdown_in':
				if($params == null || $value==0)
				{
					$sql.='1=1';
					break;
				}
				$sql.="$_f IN (SELECT {$params['u_id']} FROM {$params['u_table']} WHERE {$params['u_wid']}='".addslashes($value)."')";
			}
		}
		if(!empty($sql))
			$sql.=')';
		return $sql;
	}
}
?>