<?

class Subsection_forum_smagic_Provider extends SubsectionProvider
{
	private $tree		= null;
	private $filled		= false;
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	public function GetTree()
	{
		//return array();
		if($this->filled === false)
		{
			$this->filled = true;
			if(is_numeric($this->SectionID))
			{
				$config = ModuleFactory::GetConfigById('section', $this->SectionID);
				$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			}
			else
			{
				LibFactory::GetStatic('application');
				$config = ApplicationMgr::GetConfig($name, $folder);
				$link = '';
			}
			
			if($config === null)
				return null;
				
			$this->tree = $this->_getSectionsTree($config['db'], $config['tables']['sections'], $link, $config['root']);
		}
		
		return $this->tree;
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'s'.$params['id'];
	}
	
	private function _getSectionsTree($db_name, $table, $link, $root)
	{
		if(!empty($db_name))
		{
			$db = DBFactory::GetInstance($db_name);
			$sql = "SELECT id, parent, name";
			$sql.= " FROM {$table} FORCE INDEX (ord)";
			$sql.= " WHERE visible=1 AND is_del=0";
			$sql.= " ORDER BY ord";
					
			//error_log($sql);
			
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
				$data[$this->CreateKey(array('id'=>$row['id']))] = array(
					'parent' => $this->CreateKey(array('id'=>$row['parent'])),
					'data' => array(
						'id' => $row['id'],
						'name' => $row['name'],
						'link' => $link===null?null:($link."view.php?id=".$row['id']),
					),
				);
			$tree = new Tree();
			$tree->BuildTree($data, $this->CreateKey(array('id'=>$root)));
			return $tree;
		}
		return null;
	}
}

?>
