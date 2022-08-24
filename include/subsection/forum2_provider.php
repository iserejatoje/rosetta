<?

class Subsection_forum2_Provider extends SubsectionProvider
{
	private $tree		= null;
	private $filled		= false;
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	public function GetTree()
	{
		if($this->filled === false)
		{
			$this->filled = true;
			$config = ModuleFactory::GetConfigById('section', $this->SectionID, true);
			$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			
			if($config === null)
				return null;
				
			$this->tree = $this->_getSectionsTree($config['db'], $config['tables']['sections'], $link);
		}
		
		return $this->tree;
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'s'.$params['id'];
	}
	
	private function _getSectionsTree($db_name, $table, $link)
	{
		if(!empty($db_name))
		{
			$db = DBFactory::GetInstance($db_name);
			$sql = "SELECT id, parent, name
					FROM {$table} FORCE INDEX (ord)
					WHERE visible=1 AND is_del=0
					ORDER BY ord";
			
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
				$data[$this->CreateKey(array('id'=>$row['id']))] = array(
					'parent' => $this->CreateKey(array('id'=>$row['parent'])),
					'data' => array(
						'id' => $row['id'],
						'name' => $row['name'],
						'link' => $link===null?null:($link."view.html?id=".$row['id']),
					),
				);
			$tree = new Tree();
			$tree->BuildTree($data, $this->CreateKey(array('id'=>'0')));
			return $tree;
		}
		return null;
	}
}
