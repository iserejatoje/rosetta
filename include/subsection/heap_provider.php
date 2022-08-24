<?php
class Subsection_heap_Provider extends SubsectionProvider
{
	private $tree		= null;
	private $filled		= false;
	private $config		= null; 
	
	public function GetTree()
	{
		//return array();
		if($this->filled === false)
		{
			$this->filled = true;
			$this->config = ModuleFactory::GetConfigById('section', $this->SectionID);
			$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			if($this->config === null)
				return null;
				
			$this->tree = $this->_getSectionsTree($link);
		}
		
		return $this->tree;
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'s'.$params['id'];
	}
	
	private function _getSectionsTree($link)
	{
		$data = array();
		
		$CFG = include($this->config['engine_path'].'configure/heap/groups.php');
		$parent_key = $this->CreateKey(array('id'=>'root'));
		foreach ($CFG['groups'] as $k => $v)
		{
			$key = $this->CreateKey(array('id'=> $k));
			$data[$key] = array(
				'parent' => $parent_key,
				'data' => array(
					'id' => $key,
					'name' => $v['title'],
					//'link' => $link===null?null:($link.$k.'.php'),
				),
			);
			foreach ($v['children'] as $ke => $value)
			{
				$keys = $this->CreateKey(array('id'=> $ke));
				$data[$keys] = array(
					'parent' => $key,
					'data' => array(
						'id' => $keys,
						'name' => $value['title'],
						'link' => $link===null?null:($link.$ke.'.php'),
					),
				);
			}
		}

		$tree = new Tree();
		$tree->BuildTree($data, $parent_key);
		return $tree;
	}
}

?>