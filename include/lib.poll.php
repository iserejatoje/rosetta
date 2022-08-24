<?
/**
* Библиотека вспомогательных функций для проектов, работающих с 
* модулем Mod_Poll
* 
* @date		$Date: 2007/07/30 15:00:00 $
*/

/**
* Зависимости:
* Lib:
* 
* 
*/

class Lib_Poll
{
	var $_db             = null;
	var $_config         = array();


	function Lib_Poll()
	{
		global $DCONFIG, $LCONFIG;
		
	}
	
	function Init($sectionid)
	{
		$this->_config = ModuleFactory::GetConfigById('section', $sectionid);
		$this->_db = DBFactory::GetInstance($this->_config['db']);
	}
	
	function GetInfo($id)
	{
		$sql = "SELECT id,name,manyans FROM ".$this->_config["tables"]["question"];
		$sql.= " WHERE id='".$id."'";
		$sql.= " AND visible=1";
		$res = $this->_db->query($sql);
		if ($row = $res->fetch_assoc()) 
		{
			$details["question"]=$row;
			$sql = "SELECT id,name,cnt FROM ".$this->_config["tables"]["answer"];
			$sql.= " WHERE parent='".$row["id"]."'";
			$res2 = $this->_db->query($sql);
			$details["cnt"] = 0;
			while ($row2 = $res2->fetch_assoc()) 
			{			
				$details["answers"][] = $row2;
				$details["cnt"] += $row2["cnt"];
			}
		}
		else
		{
			$details=array();
		}
		
		return $details;
	}
	
	function GetList()
	{
		$sql = "SELECT id,name FROM ".$this->_config["tables"]["question"];
		$sql.= " WHERE visible=1";
		$res = $this->_db->query($sql);
		$details=array();
		while ($row = $res->fetch_assoc())
		{
			$details["question"][]=$row;
		}
		return $details;
	}
	
	//=========================================	
	// оставлен для совместимости
	//=========================================
	function GetPollInfo($sitepath,$db,$id)
	{
		$this->_config = include_once($sitepath."configure/modules/poll.php");
		$this->_db = $db;
		$sql = "SELECT id,name,manyans FROM ".$this->_config["tables"]["question"];
		$sql.= " WHERE id='".$id."'";
		$sql.= " AND visible=1";
		$res = $this->_db->query($sql);
		if ($row = $res->fetch_assoc()) {
			$details["question"]=$row;
			$sql = "SELECT id,name,cnt FROM ".$this->_config["tables"]["answer"];
			$sql.= " WHERE parent='".$row["id"]."'";
			$res2 = $this->_db->query($sql);
			$details["cnt"] = 0;
			while ($row2 = $res2->fetch_assoc()) {			
				$details["answers"][] = $row2;
				$details["cnt"] += $row2["cnt"];
			}
		}else{
			$details=array();
		}

		return $details;
	}

	//=========================================
	function Admin_PollList($sitepath,$db)
	{
		$this->_config = include_once($sitepath."configure/modules/poll.php");
		$this->_db = $db;
		$sql = "SELECT id,name FROM ".$this->_config["tables"]["question"];
		$sql.= " WHERE visible=1";
		$res = $this->_db->query($sql);
		$details=array();
		while ($row = $res->fetch_assoc()) {
			$details["question"][]=$row;
		}
		return $details;
	}

}

?>