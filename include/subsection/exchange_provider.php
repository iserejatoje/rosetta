<?

class Subsection_exchange_Provider extends SubsectionProvider
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
			$config = ModuleFactory::GetConfigById('section', $this->SectionID);
			$link = ModuleFactory::GetLinkBySectionId($this->SectionID);
			
			if($config === null)
				return null;
				
			$this->tree = $this->_getSectionsTree($link);
		}
		
		return $this->tree;
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'ex'.$params['id'];
	}
	
	private function _getSectionsTree($link)
	{
		$parent_key = $this->CreateKey(array('id'=>'0'));
		$i = 0;
		$key = $this->CreateKey(array('id'=>++$i));
		$data[$key] = array(
			'parent' => $parent_key,
			'data' => array(
				'name' => 'ЦБ РФ',
				'link' => $link===null?null:($link."cbrf.html"),
			),
		);
		$key = $this->CreateKey(array('id'=>++$i));
		$data[$key] = array(
			'parent' => $parent_key,
			'data' => array(
				'name' => 'Динамика',
				'link' => $link===null?null:($link."stat.html"),
			),
		);
		$key = $this->CreateKey(array('id'=>++$i));
		$data[$key] = array(
			'parent' => $parent_key,
			'data' => array(
				'name' => 'Конвертор',
				'link' => $link===null?null:($link."exch.html"),
			),
		);
		
		$tree = new Tree();
		$tree->BuildTree($data, $parent_key);
		return $tree;
	}
}

?>