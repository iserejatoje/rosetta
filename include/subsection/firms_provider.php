<?

class Subsection_firms_Provider extends SubsectionProvider
{
	private $tree		        = null;
	private $filled		        = false;
	private $_firms_rootdir 	= 0;
    private $_nsTree            = null;
    private $_root              = null;
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	public function GetTree()
	{
		global $OBJECTS;		
		LibFactory::GetMStatic('tree', 'nstreemgr');
		if($this->filled === false)
		{
			$this->filled = true;
			$config = ModuleFactory::GetConfigById('section', $this->SectionID, true);
			$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			
			if($config === null)
				return null;
                
            $_db_places = DBFactory::GetInstance('places');
            $this->_nsTree = new NSTreeMgr($_db_places, 'place_tree');
          
			try{
			$this->_root = $this->_nsTree->setTreeId($this->SectionID);		
			}catch(Exception $e)
			{				
				return null;
			}
			$this->tree = $this->_getSectionsTree($link);
		}
		
		return $this->tree;
		
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'fr'.$params['id'];
	}
	
	private function _getSectionsTree($link)
	{
        if ($this->_root === null)
            return null;
            
        $childs = $this->_root->getChildNodes(1, 1, true);
       
        foreach($childs as $node)
        {
            if ($node->level == 1)
            {                
                $data[$this->CreateKey( array('id'=>$node->id) )] = array(
                    'parent' => $this->CreateKey(array('id'=>$node->parent->id)),
                    'data' => array(
                        'id' => $node->id,
                        'name' => $node->title,
                        'link' => $link===null?null:($link.$node->nameid.'/'),
                    ),
                );
            }
        }
		
		$tree = new Tree();
		$tree->BuildTree($data, $this->CreateKey(array('id'=>$this->_root->id)));
		return $tree;
		
	}
}

?>