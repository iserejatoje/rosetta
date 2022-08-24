<?
/**
* Библиотека вспомогательных функций для проектов, работающих с 
* модулем CrossRef
* 
* @date		$Date: 2006/05/12 13:00:00 $
*/

/**
* Зависимости:
* Lib:
*  Data
* 
*/

class Lib_Crossref
{
	static $Name             = "crossref";
	private $_db             = null;
	private $_parts          = array();
	private $_config         = array();

	function Lib_Crossref()
	{
		global $DCONFIG, $LCONFIG;
		
		LibFactory::GetConfig(self::$Name, 74);//$DCONFIG['REGION']);
		$this->_config = $LCONFIG[self::$Name];
		$this->_db = DBFactory::GetInstance($this->_config["db"]);
		$this->_db->query("SET NAMES cp1251");
	}


	/**
	* заполняет массив разделов
	*/
	private function _FillParts()
	{
		$sql = "SELECT * FROM ".$this->_config["tables"]["item"];
		$sql.= " ORDER BY id ASC";
		$res = $this->_db->query($sql);
		$this->_parts = array();
		while($row = $res->fetch_assoc())
			$this->_parts[$row["id"]] = $row;
	}
	
	
	/**
	* функция возвращающая перекрестные ссылки для заданной статьи, с заголовками
	* возвращает массив, где первый ключ является временем, второй индексом
	*
	* @param
	*		tid int - ID раздела
	*		nid int - ID материала
	* @return array
	*		time array(
	*			id - ID
	*			name - Название
	*			date - Дата (time)
	*		)
	*/
	private function _GetCrossRefs($tid, $nid)
	{
		$sql = "SELECT tcrossid, ncrossid FROM ".$this->_config["tables"]["refs"];
		$sql.= " WHERE tbaseid=".$tid." AND nbaseid=".$nid;
		$res = $this->_db->query($sql);
		$tns = array();
		while($row = $res->fetch_row())
			$tns[$row[0]][] = $row[1];
		
		foreach($tns as $tid => $nids)
		{
			$item = $this->_parts[$tid];
			$dbh = DBFactory::GetInstance($item["db"]);
			$dbh->query("SET NAMES cp1251");
			
			$sql = "SELECT ".$item["field_id"].", ".$item["field_name"].", ".$item["field_date"]." FROM ".$item["tbl_name"]." WHERE ".$item["field_id"]." IN (";
			$s = "";
			foreach($nids as $nid)
			{
				if($s != "")
					$s.= ",";
				$s.= $nid;
			}
			$sql.= $s.")";
			$res = $dbh->query($sql);
			while($row = $res->fetch_row())
				$tnids[strtotime($row[2])][] = array($tid, $row[0], $row[1], strtotime($row[2]));
		}
		
		return $tnids;
	}

	
	/**
	* сохраняет перекрестные ссылки в индексной таблице
	*
	* @param
	*		tid int - ID раздела
	*		nid int - ID материала
	*		ids array - (tid, nid)
	*/
	private function _SaveCrossRefs($tid, $nid, $ids)
	{
		$sql = "DELETE FROM ".$this->_config["tables"]["refs"];
		$sql.= " WHERE tbaseid=".$tid." AND nbaseid=".$nid;
		$this->_db->query($sql);
		
		foreach($ids as $id)
		{
			$sql = "INSERT INTO ".$this->_config["tables"]["refs"]." SET";
			$sql.= " tbaseid=".$tid.",";
			$sql.= " nbaseid=".$nid.",";
			$sql.= " tcrossid=".$id["tid"].",";
			$sql.= " ncrossid=".$id["nid"];
			$this->_db->query($sql);
		}
	}

	
/**
*
* РАБОТА с КЛИЕНТОМ
*
*/


	/**
	* Возвращает список перекрестных ссылок
	*
	* @param
	*		tid int - ID раздела
	*		nid int - ID материала
	* @return array
	*		date - time
	*		link - ссылка
	*		name - Название
	*		domain - Домен
	*/
	public function Client_GetCrossRefsList($tid, $nid)
	{
		if(!count($this->_parts))
			$this->_FillParts();
		
		$tnids = $this->_GetCrossRefs($tid, $nid);
		$list = array();
		if(count($tnids) > 0)
		{
			krsort($tnids, SORT_NUMERIC);
			foreach($tnids as $tnid)
			{
				foreach($tnid as $v)
				{
					$list[] = array(
						"date"   => $v[3],
						"link"   => sprintf($this->_parts[$v[0]]["link"], $v[1]),
						"name"   => strip_tags($v[2]),
						"domain" => $this->_parts[$v[0]]["domain"],
					);
				}
			}
		}
		return $list;
	}
	

/**
*
* РАБОТА с АДМИНОМ
*
*/


	/**
	* Возвращает список перекрестных ссылок
	*
	* @param
	*		tid int - ID раздела
	*		nid int - ID материала
	* @return array
	*		date - time
	*		link - ссылка
	*		name - Название
	*		domain - Домен
	*/
	public function Admin_GetCrossRefsList($tid, $nid)
	{
		if(!count($this->_parts))
			$this->_FillParts();
		
		LibFactory::GetStatic("data");

		$tnids = $this->_GetCrossRefs($tid, $nid);
		$list = array();
		$list["arr"] = "";
		$list["ids"] = "";
		$i=0;
		if(count($tnids) > 0)
		{
			krsort($tnids, SORT_NUMERIC);
			foreach($tnids as $tnid)
			{
				foreach($tnid as $v)
				{
					$list["arr"].= "crossref_arr[".$i."] = ['".$v[0]."','".$v[1]."','".date("d.m.Y",$v[3])."','".Data::HTMLOut(sprintf($this->_parts[$v[0]]["link"], $v[1]))."','".Data::HTMLOut(strip_tags($v[2]))."'];\n";
					$list["ids"].= ($list["ids"]?"|":"").$v[0]."@@".$v[1];
					$i++;
				}
			}
		}
		
		//  надо поправить и брать из конфига ID 
		$list["script"] = "
<a href=\"#\" onclick=\"crossref_opendlg(); return false;\">Добавить ссылки</a>
<div id=\"crossref_div\"></div>
<script type=\"text/javascript\" language=\"javascript\">
	var crossref_ids = document.getElementById('crossref_ids');
	var crossref_div = document.getElementById('crossref_div');
	var crossref_arr = new Array();
	".$list["arr"]."

	// открытие всплывающего окна
	function crossref_opendlg()
	{
		var sFeatures = \"height=600px, width=900px, resizable=yes, status=no, scrollbars=yes, toolbar=no, menubar=no, location=no\";
		window.open(\"/main.php?section_id=57&action=crossref_search\", \"crossref_".$tid."_".$nid."\", sFeatures, true);
	}
	
	// добавление ссылки в массив (из всплывающего окна)
	function crossref_add(val)
	{
		var is_set = false;
		for(i=0; i < crossref_arr.length; i++)
			if( (crossref_arr[i][0] == val[0]) && (crossref_arr[i][1] == val[1]) )
				is_set = true;
		if(!is_set)
		{
			// здесь создаем новый объект, чтобы это мудак IE6 забыл про то что данные пришли из другого документа.
			// тоесть при закрытии всплывающего окна здесь будут именно данные.
			// если просто сделать crossref_arr.push(val); - то IE6 будет при попытке обратиться к crossref_arr искать val в источнике.
			// это приводит к ошибке
			var vl = new Array(val[0],val[1],val[2],val[3],val[4]);
			crossref_arr.push(vl);
			crossref_make_string();
			crossref_paint();
		}
	}

	// удаление ссылки из массив
	function crossref_del(d)
	{
		crossref_arr.splice(d, 1);
		crossref_make_string();
		crossref_paint();
	}

	// Удаление ссылки из массив (из всплывающего окна)
	function crossref_delete(val)
	{
		var d = -1;
		for(i=0; i < crossref_arr.length; i++)
			if( (crossref_arr[i][0] == val[0]) && (crossref_arr[i][1] == val[1]) )
				d = i;
		crossref_del(d);
	}

	// РИСУЕМ табличку
	function crossref_paint(){
		tmp = \"\";
		if(crossref_arr.length)
		{
			tmp+=\"<table width='100%' cellpadding='2' cellspacing='1' border='0' bgcolor='#F0F0F0'>\";
			tmp+=\"<tr align='center' bgcolor='#FFFFFF'>\";
			tmp+=\"<td>&nbsp;</td>\";
			tmp+=\"<td width='10%'><b>Дата</td>\";
			tmp+=\"<td width='90%'><b>Название</td>\";
			tmp+=\"</tr>\";
			for(i=0; i < crossref_arr.length; i++){
				tmp+=\"<tr bgcolor='#FFFFFF'>\";
				tmp+=\"<td><img onclick='crossref_del(\"+i+\");' s\" + \"rc='/images/btnDelete.gif' width='20' style='cursor:pointer;cursor:hand;' alt='Удалить' /></td>\";
				tmp+=\"<td>\"+crossref_arr[i][2]+\"</td>\";
				tmp+=\"<td><a target='_blank' href='\"+crossref_arr[i][3]+\"'>\"+crossref_arr[i][4]+\"</td>\";
				tmp+=\"</tr>\";
			}
			tmp+=\"</table>\";
		}
		
		crossref_div.style.display = \"none\";
		crossref_div.innerHTML = tmp;
		crossref_div.style.display = \"block\";
	}

	// строим строку с IDs
	function crossref_make_string()
	{
		var tmp=\"\";
		for(i=0; i < crossref_arr.length; i++){
			if(i>0){tmp+=\"|\";}
			tmp+=crossref_arr[i][0];
			tmp+=\"@@\"+crossref_arr[i][1];
		}
		crossref_ids.value = tmp;
	}
	
	// инициализация начальная.
	function crossref_init(){
		crossref_paint();
	}
	crossref_init();
</script>		
		";
		unset($list["arr"]);
		
		return $list;
	}
	


	/**
	* Возвращает список перекрестных ссылок
	*
	* @param
	*		tid int - ID раздела
	*		nid int - ID материала
	*		ids string - строка ID 1@@123|12@@123...
	*/
	public function Admin_SaveCrossRefsList($tid, $nid, $ids)
	{
		$id_arr = array();
		$arr1 = explode("|", $ids);
		if(count($arr1))
			foreach($arr1 as $param)
			{
				$uups = explode("@@", $param);
				if(Data::Is_Number($uups[0]) && Data::Is_Number($uups[1]))
					$id_arr[] = array("tid"=>$uups[0], "nid"=>$uups[1]);
			}
		
		$this->_SaveCrossRefs($tid, $nid, $id_arr);
	}



}

?>