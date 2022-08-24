<?
/**
 * Модуль SITE_MAP.
 *
 * @date		$Date: 2008/03/24 10:28:00 $
 */

class Mod_Site_Map extends AMultiFileModule_Magic
{
	protected $_params;
	protected $_db;
	private $_db_section;
	private $_tree = null;
	protected $_module_caching = true;
	
	protected $_ignore_modules = array(
		'site_map',
		'block_forum',
	);

	public function __construct() {		
		parent::__construct('site_map');
		
	}

	function Init()
	{	
		
	}

	/**
	 * Выборка дерева в виде массива
	 * 
	 * @return array
	 */
	protected function _Get_TreePlain()
	{
		global $CONFIG, $OBJECTS;
		
		LibFactory::GetStatic('tree');
		LibFactory::GetStatic('subsection');
		
		// получить данные для дерева
		$sections = array();
		
		$it = STreeMgr::Iterator(array(
			'visible' => 1,
			'parent' => STreeMgr::GetSiteIDByHost($this->_env['site']['domain']),
			'type' => 2,
			'order' => 'ord'
		));
		
		foreach($it as $node)
		{
			if(in_array($node-Module, $this->_ignore_modules))
				continue;
			
			$sections[$node->ID] = array(
				'id' => $node->ID,
				'parent' => $node->ParentID,
				'name' => $node->Path,
				'data' => array(
					'name' => $node->Name,
					'link' => ModuleFactory::GetLinkBySectionId($node->ID),
				),
			);
		}
		
		$this->_tree = new Tree();
		$this->_tree->BuildTree($sections, STreeMgr::GetSiteIDByHost($this->_env['site']['domain']) );
		
		$this->_AttachSections();
		
		$page['tree'] = $this->_tree->GetTreePlainData();
		
		return $page;
	}
	
	
	/**
	 * Прикрепляет деревья разделов к разделам
	 * 
	 * @param object $node Объект дерева tree
	 * @return void
	 */
	protected function _AttachSections($node = null)
	{
		if($node === null)
			$node = $this->_tree;
		
		if(is_array($node->Nodes))
			foreach($node->Nodes as $k=>$_n)
			{
				$ss = SubsectionProviderFactory::GetInstance($_n->Id);
				if($ss === null)
					continue;				
				$ss->KeyPrefix = $_n->Id."_";
				$node->Nodes[$k]->AddTreeAssoc($ss->GetTree());				
			}
	}
	
}

?>