<?

class Subsection_partner_Provider extends SubsectionProvider
{
	private $tree		= null;
	private $filled		= false;
	private $_firms_rootdir	= 0;
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
				
			$this->_firms_rootdir = $config['rootdir'];
				
			$this->tree = $this->_getSectionsTree($config['db'], $config['tables']['tree'], $link);
		}
		
		return $this->tree;
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'fr'.$params['id'];
	}
	
	private function _getSectionsTree($db_name, $table, $link)
	{
		if(!empty($db_name))
		{
			$db = DBFactory::GetInstance($db_name);
			
			$sql = 'SELECT id, parent, title, name
					FROM '.$table.'
					WHERE parent = '.$this->_firms_rootdir.'
						AND visible = 1
					ORDER BY ord, title';
			
			$res = $db->query($sql);
			while($row = $res->fetch_assoc())
				$data[$this->CreateKey(array('id'=>$row['id']))] = array(
					'parent' => $this->CreateKey(array('id'=>$row['parent'])),
					'data' => array(
						'id' => $row['id'],
						'name' => $row['title'],
						'link' => $link===null?null:($link.$row['name'].'/'),
					),
				);
			
			$tree = new Tree();
			$tree->BuildTree($data, $this->CreateKey(array('id'=>$this->_firms_rootdir)));
			
			return $tree;
		}
		return null;
	}
}

?>