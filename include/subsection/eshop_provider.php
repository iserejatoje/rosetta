<?

class Subsection_Eshop_Provider extends SubsectionProvider
{
	private $tree		        = null;
	private $filled		        = false;
	private $_firms_rootdir 	= 0;
    private $_tree            = null;
    private $_root              = null;
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	public function GetTree()
	{
		global $OBJECTS;		
		LibFactory::GetMStatic('eshop', 'eshopmgr');
		if($this->filled === false)
		{
			$this->filled = true;
			$config = ModuleFactory::GetConfigById('section', $this->SectionID, true);
			$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			
			if($config === null)
				return null;
                
            $db = DBFactory::GetInstance('ecologystyle');
            $this->_tree = new EShopTreeMgr($db, 'eshop_tree');
          
			try{
			$this->_root = $this->_tree->setTreeId($this->SectionID);		
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